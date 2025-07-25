<?php

namespace App\Http\Controllers;
use App\Entidades\Categoria;
use App\Entidades\Producto;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorCategoria extends Controller{

      public function nuevo()
      {
            $titulo = "Nueva categoria";
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("CATEGORIAALTA")) {
                    $codigo = "CATEGORIAALTA";
                    $mensaje = "No tiene permisos para la operacion.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $categoria = new Categoria;
                    return view("sistema.categoria-nuevo", compact("titulo", "categoria"));
                }
            } else {
                return redirect('admin/login');
            }   
      }


      public function index()
      {
        $titulo = "Listado de categoria";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("CATEGORIACONSULTA")) {
                $codigo = "CATEGORIACONSULTA";
                $mensaje = "No tiene permisos para la operacion.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view("sistema.categoria-listar", compact("titulo"));
            }
        } else {
            return redirect('admin/login');
        }
    }

      public function guardar(Request $request) 
      {
            try {
                //Define la entidad servicio
                $titulo = "Modificar categoria";
                $entidad = new Categoria();
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
                    
                    $_POST["id"] = $entidad->idcategoria;
                    return view('sistema.categoria-listar', compact('titulo', 'msg'));
                }
            } catch (Exception $e) {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = ERRORINSERT;
            }
    
            $id = $entidad->idcategoria;
            $categoria = new categoria();
            $categoria->obtenerPorId($id);
    
    
            return view('sistema.categoria-nuevo', compact('msg', 'categoria', 'titulo')) . '?id=' . $categoria->idcategoria;
    
        }

        public function cargarGrilla(Request $request){
            $request = $_REQUEST;

            $entidad = new Categoria();
            $aCategorias = $entidad->obtenerFiltrado();
    
            $data = array();
            $cont = 0;
    
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];
    
    
            for ($i = $inicio; $i < count($aCategorias) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/categorias/' . $aCategorias[$i]->idcategoria . '">' . $aCategorias[$i]->nombre . '</a>';
                $row[] = $aCategorias[$i]->nombre;
                $cont++;
                $data[] = $row;
            }
    
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => count($aCategorias), //cantidad total de registros sin paginar
                "recordsFiltered" => count($aCategorias), //cantidad total de registros en la paginacion
                "data" => $data,
            );
            return json_encode($json_data);
        }

        public function editar($idCategoria)
        {
            $titulo = "Edicion de categoria";
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("CATEGORIAEDITAR")) {
                    $codigo = "CATEGORIAEDITAR";
                    $mensaje = "No tiene permisos para la operacion.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $categoria = new Categoria();
                    $categoria->obtenerPorId($idCategoria);
                    return view("sistema.categoria-nuevo", compact("titulo", "categoria"));
                }
            } else {
                return redirect('admin/login');
            }           
        }

        public function eliminar(Request $request)
        {   
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("CATEGORIAELIMINAR")) {
                    $resultado["err"] = EXIT_FAILURE;
                    $resultado["mensaje"] = "No tiene permisos para la operacion.";
                } else {
                    $idCategoria = $request->input("id");
                    $producto = new Producto();
            //
            if($producto->existeProductosPorCategoria($idCategoria)){
                $resultado["err"] = EXIT_FAILURE;
                $resultado["mensaje"] = "No se puede eliminar una categoria con productos asociados";
            } else {
                       $categoria = new Categoria();
                       $categoria->idcategoria = $idCategoria;
                       $categoria->eliminar();
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