<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;

class ControladorWebPostulacionGracias extends Controller
{
    public function index()
    {
            $titulo = "Postulacion Gracias";
            $sucursal = new Sucursal;
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.postulacion_gracias", compact("titulo", "aSucursales"));
    }
}