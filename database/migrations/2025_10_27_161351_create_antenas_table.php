<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('antenas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('descricao', 100)->unique();
            $table->decimal('latitude', 10, 7);
            $table->decimal('longitude', 10, 7);
            $table->char('uf', 2);
            $table->decimal('altura', 5, 2);
            $table->date('data_implantacao')->nullable();
            $table->string('foto')->nullable(); // caminho ou nome do arquivo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antenas');
    }
};
