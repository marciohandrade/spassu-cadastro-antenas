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
        'descricao',
        'latitude',
        'longitude',
        'uf',
        'altura',
        'data_implantacao',
        'foto',
    ];
}
