<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @property string|null $foto
 */
class Antena extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'descricao',
        'latitude',
        'longitude',
        'uf',
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

    /**
     * Retorna URL completa da foto
     */
    public function getFotoUrlAttribute(): ?string
    {
        if (!$this->foto) {
            return null;
        }

        return Storage::url($this->foto);
    }
}
