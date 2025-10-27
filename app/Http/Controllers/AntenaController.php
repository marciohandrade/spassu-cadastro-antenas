<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AntenaController extends Controller
{
    public function create(IbgeService $ibge)
    {
        $ufs = $ibge->getEstados();
        return view('antenas.create', compact('ufs'));
    }
}
