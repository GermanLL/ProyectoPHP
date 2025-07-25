<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorWebRegistrarse extends Controller
{
    public function index()
    {
        $sucursal = new Sucursal;
        $aSucursales = $sucursal->obtenerTodos();
        return view("web.registrarse", compact("aSucursales"));
    }

    public function registrarse(Request $request)
    {

        $titulo = "Nuevo Registro";
        $entidad = new Cliente;
        $entidad->nombre = $request->input("txtNombre");
        $entidad->clave = password_hash($request->input('txtClave'), PASSWORD_DEFAULT);
        $entidad->dni = $request->input('txtDni');
        $entidad->telefono = $request->input('txtTelefono');
        $entidad->direccion = $request->input('txtDireccion');
        $entidad->correo = $request->input('txtCorreo');
        $sucursal = new Sucursal;
        $aSucursales = $sucursal->obtenerTodos();

        if ($entidad->nombre == "" || $entidad->clave == "" || $entidad->dni == "" || $entidad->telefono == "" || $entidad->direccion == "" || $entidad->correo == "") {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = "Complete todos los datos";
            return view("web.registrarse", compact("titulo", "msg", "aSucursales"));
        } else {
            $entidad->insertar();
            return redirect("/login");
        }

        
    }
}
