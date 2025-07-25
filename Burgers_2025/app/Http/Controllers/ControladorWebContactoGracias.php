<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;

class ControladorWebContactoGracias extends Controller
{
    public function index()
    {
            
            $sucursal = new Sucursal;
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.contacto-gracias", compact("aSucursales"));
    }
}