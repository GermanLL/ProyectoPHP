<?php

namespace App\Http\Controllers;
use App\Entidades\Pedido;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Estado;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use App\Entidades\Pedido_producto;
use Illuminate\Http\Request;


require app_path() . '/start/constants.php';

class ControladorPedido extends Controller{

      public function nuevo()
      {     
            $titulo = "Nuevo pedido";
            if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PEDIDOALTA")) {
                $codigo = "PEDIDOALTA";
                $mensaje = "No tiene permisos para la operacion.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $pedido = new Pedido();
                $sucursal = new Sucursal();
                $aSucursales = $sucursal->obtenerTodos();
                $cliente = new Cliente();
                $aClientes = $cliente->obtenerTodos();
                $estado = new Estado();
                $aEstados = $estado->obtenerTodos();
            return view ("sistema.pedido-nuevo", compact("titulo", "aSucursales", "aClientes", "aEstados", "pedido"));
            }
        } else {
            return redirect('admin/login');
        }
      }

      public function index(){

        $titulo = "Listado de pedidos";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PEDIDOCONSULTA")) {
                $codigo = "PEDIDOCONSULTA";
                $mensaje = "No tiene permisos para la operacion.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view ("sistema.pedido-listar", compact("titulo"));
            }
        } else {
            return redirect('admin/login');
        }
  }

    public function guardar(Request $request)
    {
        try {
            //Define la entidad servicio
            $titulo = "Modificar pedido";
            $entidad = new Pedido();
            
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->fk_idcliente == "" || $entidad->fk_idsucursal == "" || $entidad->fk_idestado == "" || $entidad->fecha == "" || $entidad->total == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                

                $_POST["id"] = $entidad->idpedido;

                 
                return view('sistema.pedido-listar', compact('titulo', 'msg', ));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->idpedido;
        $pedido = new Pedido();
        $pedido->obtenerPorId($id);
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
        $cliente = new Cliente();
        $aClientes = $cliente->obtenerTodos();
        $estado = new Estado();
        $aEstados = $estado->obtenerTodos();

       
        return view('sistema.pedido-nuevo', compact('msg', 'pedido', 'titulo', "aSucursales", "aClientes", "aEstados")) . '?id=' . $pedido->idpedido;
    }

    public function cargarGrilla(Request $request)
    {
        $request = $_REQUEST;

        $entidad = new Pedido();
        $aPedidos = $entidad->obtenerFiltrado();

        $data = array();
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aPedidos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = '<a href="/admin/pedidos/' . $aPedidos[$i]->idpedido . '">' . $aPedidos[$i]->fecha . '</a>';
            $row[] = $aPedidos[$i]->sucursal;
            $row[] = $aPedidos[$i]->cliente;
            $row[] = $aPedidos[$i]->estado;
            $row[] = $aPedidos[$i]->total;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPedidos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPedidos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function editar($idPedido)
    {
        $titulo = "Edicion de pedido";

        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PEDIDOEDITAR")) {
                $codigo = "PEDIDOEDITAR";
                $mensaje = "No tiene permisos para la operacion.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $pedido = new Pedido();
                $pedido->obtenerPorId($idPedido);
                $sucursal = new Sucursal();
                $aSucursales = $sucursal->obtenerTodos();
                $cliente = new Cliente();
                $aClientes = $cliente->obtenerTodos();
                $estado = new Estado();
                $aEstados = $estado->obtenerTodos();

                $entidadPedidoProduto = new Pedido_producto();
                $aPedidoProductos =$entidadPedidoProduto->obtenerPorPedido($idPedido);


                return view("sistema.pedido-nuevo", compact("titulo", "aSucursales", "aClientes", "aEstados", "pedido","aPedidoProductos"));
            }
        } else {
            return redirect('admin/login');
        }
    }


    public function eliminar(Request $request)
    {
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PEDIDOBAJA")) {
                $resultado["err"] = EXIT_FAILURE;
                $resultado["mensaje"] = "No tiene permisos para la operacion.";
            } else {
                $idPedido = $request->input("id");
                $cliente = new Cliente();
                //
                if ($cliente->existeClientesPorPedido($idPedido)) {
                    $resultado["err"] = EXIT_FAILURE;
                    $resultado["mensaje"] = "No se puede eliminar un pedido con clientes asociados";
                } else {
                    $pedido = new Pedido();
                    $pedido->idpedido = $idPedido;
                    $pedido->eliminar();
                    $resultado["err"] = EXIT_SUCCESS;
                    $resultado["mensaje"] = "Registro eliminado exitosamente.";
                }
            }
        } else {
            $resultado["err"] = EXIT_FAILURE;
            $resultado["mensaje"] = "Usuario no autenticado";
        }
        return json_encode($resultado);
    }
}