<?php

namespace App\Http\Controllers;
use App\Entidades\Cliente;
use App\Entidades\Pedido;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorCliente extends Controller{

      public function nuevo()
      {
        $titulo = "Nuevo cliente";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CLIENTEALTA")) {
                $codigo = "CLIENTEALTA";
                $mensaje = "No tiene permisos para la operacion.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $cliente = new Cliente();
            return view ("sistema.cliente-nuevo", compact("titulo", "cliente"));
            }
        } else {
            return redirect('admin/login');
        }
      }

      public function index()
      {
        $titulo = "Listado de clientes";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CLIENTECONSULTA")) {
                $codigo = "CLIENTECONSULTA";
                $mensaje = "No tiene permisos para la operacion.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view("sistema.cliente-listar", compact("titulo"));
            }
        } else {
            return redirect('admin/login');
        }
      }

      public function guardar(Request $request)
        {
            try {
                //Define la entidad servicio
                $titulo = "Modificar cliente";
                $entidad = new Cliente();
                $entidad->cargarDesdeRequest($request);

                //validaciones
                if ($entidad->nombre == "") {
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

                    $_POST["id"] = $entidad->idcliente;
                    return view('sistema.cliente-listar', compact('titulo', 'msg'));
                }
            } catch (Exception $e) {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = ERRORINSERT;
            }

            $id = $entidad->idcliente;
            $cliente = new Cliente();
            $cliente->obtenerPorId($id);


            return view('sistema.cliente-nuevo', compact('msg', 'cliente', 'titulo')) . '?id=' . $cliente->idcliente;
        }

        public function cargarGrilla(Request $request){
            $request = $_REQUEST;

            $entidad = new Cliente();
            $aClientes = $entidad->obtenerFiltrado();
    
            $data = array();
            $cont = 0;
    
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];
    
    
            for ($i = $inicio; $i < count($aClientes) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/clientes/' . $aClientes[$i]->idcliente . '">' . $aClientes[$i]->nombre . '</a>';
                $row[] = $aClientes[$i]->dni;
                $row[] = $aClientes[$i]->correo;
                $row[] = $aClientes[$i]->telefono;
                $row[] = $aClientes[$i]->direccion;
                $cont++;
                $data[] = $row;
            }
    
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => count($aClientes), //cantidad total de registros sin paginar
                "recordsFiltered" => count($aClientes), //cantidad total de registros en la paginacion
                "data" => $data,
            );
            return json_encode($json_data);
        }

        public function editar($idCliente)
        {
            $titulo = "Edicion de cliente";

            if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CLIENTEEDITAR")) {
                $codigo = "CLIENTEEDITAR";
                $mensaje = "No tiene permisos para la operacion.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $cliente = new Cliente();
                $cliente->obtenerPorId($idCliente);
            return view ("sistema.cliente-nuevo", compact("titulo", "cliente"));
            }
        } else {
            return redirect('admin/login');
        }
        }

        public function eliminar(Request $request)
        {
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("CLIENTEELIMINAR")) {
                    $resultado["err"] = EXIT_FAILURE;
                    $resultado["mensaje"] = "No tiene permisos para la operacion.";
                } else {
                    $idCliente = $request->input("id");
                    $pedido = new Pedido();
                    //
                    if ($pedido->existePedidosPorCliente($idCliente)) {
                        $resultado["err"] = EXIT_FAILURE;
                        $resultado["mensaje"] = "No se puede eliminar un cliente con pedidos asociados";
                    } else {
                        $cliente = new Cliente();
                        $cliente->idcliente = $idCliente;
                        $cliente->eliminar();
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