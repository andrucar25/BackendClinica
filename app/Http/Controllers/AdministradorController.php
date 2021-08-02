<?php

namespace App\Http\Controllers;

use App\Administrador;
use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    public function index()
    {
        $administradores = Administrador::all();
        return response()->json($administradores);
    }
}
