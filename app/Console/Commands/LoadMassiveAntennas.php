<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoadMassiveAntennas extends Command
{
    protected $signature = 'antenas:load {quantity=100000}';
    protected $description = 'Carrega quantidade massiva de antenas no banco';

    public function handle()
    {
        $quantity = (int) $this->argument('quantity');
        $this->info("Iniciando carga de {$quantity} antenas...");

        $ufs = ['SP', 'RJ', 'MG', 'BA', 'RS', 'PR', 'SC', 'PE', 'CE', 'GO',
            'DF', 'ES', 'PA', 'MA', 'MS', 'MT', 'PB', 'PI', 'RN', 'SE',
            'AC', 'AL', 'AM', 'AP', 'RO', 'RR', 'TO'];

        $batchSize = 1000;
        $batches = (int) ceil($quantity / $batchSize);
        $bar = $this->output->createProgressBar($batches);
        $bar->start();

        DB::beginTransaction();

        try {
            for ($batch = 0; $batch < $batches; $batch++) {
                $data = [];
                $currentBatchSize = min($batchSize, $quantity - ($batch * $batchSize));

                for ($i = 0; $i < $currentBatchSize; $i++) {
                    $num = ($batch * $batchSize) + $i + 1;
                    $data[] = [
                        'descricao' => 'Antena Teste ' . str_pad((string) $num, 6, '0', STR_PAD_LEFT) . ' ' . Str::random(10),
                        'latitude' => $this->randomFloat(-33.75, 5.27, 7),
                        'longitude' => $this->randomFloat(-73.99, -28.84, 7),
                        'uf' => $ufs[array_rand($ufs)],
                        'altura' => $this->randomFloat(10, 150, 2),
                        'data_implantacao' => now()->subDays(rand(1, 3650))->format('Y-m-d'),
                        'foto' => null,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

                DB::table('antenas')->insert($data);
                $bar->advance();
            }

            DB::commit();
            $bar->finish();
            $this->newLine(2);
            $this->info("✅ {$quantity} antenas carregadas com sucesso!");

            $this->newLine();
            $this->info("📊 Estatísticas:");
            $stats = DB::table('antenas')
                ->select('uf', DB::raw('COUNT(*) as total'))
                ->groupBy('uf')
                ->orderByDesc('total')
                ->limit(5)
                ->get();

            foreach ($stats as $stat) {
                $this->line("   {$stat->uf}: {$stat->total} antenas");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Erro ao carregar antenas: " . $e->getMessage());
            return 1;
        }

        return 0;
    }

    private function randomFloat($min, $max, $decimals = 2)
    {
        return round($min + mt_rand() / mt_getrandmax() * ($max - $min), $decimals);
    }
}
