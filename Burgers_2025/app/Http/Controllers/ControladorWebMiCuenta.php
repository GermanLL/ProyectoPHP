<?php

namespace App\Http\Controllers;

use App\Entidades\Cliente;
use App\Entidades\Sucursal;
use App\Entidades\Pedido;
use Illuminate\Http\Request;
use Session;

class ControladorWebMiCuenta extends Controller
{
    public function index()
    {
            $idCliente = Session::get("idCliente");
            if($idCliente !=""){
            $cliente = new Cliente();
            $cliente->obtenerPorId($idCliente);

            $sucursal = new Sucursal;
            $aSucursales = $sucursal->obtenerTodos();

            $pedido = new Pedido();
            $aPedidos = $pedido->obtenerPedidoPorCliente($idCliente);
            
            return view("web.mi_cuenta", compact("cliente", "aSucursales", "aPedidos"));
            } else{
                return redirect("/login");
            }
    }

    public function guardar(Request $request){

        $cliente= new Cliente();
        $idCliente = Session::get("idCliente");
        $cliente->idcliente = $idCliente;
        $cliente->nombre= $request->input("txtNombre");
        $cliente->telefono= $request->input("txtTelefono");
        $cliente->dni= $request->input("txtDni");
        $cliente->correo= $request->input("txtCorreo");
        $cliente->direccion= $request->input("txtDireccion");
        $cliente->guardar();

        $sucursal = new Sucursal;
        $aSucursales = $sucursal->obtenerTodos();
        $pedido = new Pedido();
        $aPedidos = $pedido->obtenerPedidoPorCliente($idCliente);

        return view("web.mi_cuenta", compact("cliente", "aSucursales", "aPedidos" ));


    }

    

    //*Agregar los pedidos
    
}