<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Antena extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'nome',
        'descricao',
        'latitude',
        'longitude',
        'uf_sigla',
        'cidade',
        'altura',
        'data_implantacao',
        'foto',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'altura' => 'float',
        'data_implantacao' => 'date',
    ];

    // Se você armazenar apenas o caminho (ex: "antenas/xxx.jpg"), esse accessor retorna URL pública
    public function getFotoUrlAttribute()
    {
        if (! $this->foto) {
            return null;
        }
        // se já salvou com Storage::url(), esse método não é necessário, mas é seguro:
        return preg_match('#^https?://#', $this->foto) ? $this->foto : Storage::url($this->foto);
    }
}
