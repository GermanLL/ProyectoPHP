<?php

namespace App\Http\Controllers;
use App\Entidades\Postulacion;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Patente;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPostulacion extends Controller{

      public function nuevo()
      {
        $titulo = "Nuevo postulacion";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("POSTULANTEALTA")) {
                $codigo = "POSTULANTEALTA";
                $mensaje = "No tiene permisos para la operacion.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $postulacion = new Postulacion();
                return view("sistema.postulacion-nuevo", compact("titulo", "postulacion"));
            }
        } else {
            return redirect('admin/login');
        }
      }

      public function index()
      {
        $titulo = "Listado de Postulaciones";
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("POSTULANTECONSULTA")) {
                $codigo = "POSTULANTECONSULTA";
                $mensaje = "No tiene permisos para la operacion.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view("sistema.postulacion-listar", compact("titulo"));
            }
        } else {
            return redirect('admin/login');
        }
      }

      public function guardar(Request $request) 
      {
            try {
                //Define la entidad servicio
                $titulo = "Modificar postulacion";
                $entidad = new Postulacion();
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
                    
                    $_POST["id"] = $entidad->idpostulacion;
                    return view('sistema.postulacion-listar', compact('titulo', 'msg'));
                }
            } catch (Exception $e) {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = ERRORINSERT;
            }
    
            $id = $entidad->idpostulacion;
            $postulacion = new Postulacion();
            $postulacion->obtenerPorId($id);
    
    
            return view('sistema.postulacion-nuevo', compact('msg', 'postulacion', 'titulo')) . '?id=' . $postulacion->idpostulacion;
    
        }
        public function cargarGrilla(Request $request){
            $request = $_REQUEST;

            $entidad = new Postulacion();
            $aPostulaciones = $entidad->obtenerFiltrado();
    
            $data = array();
            $cont = 0;
    
            $inicio = $request['start'];
            $registros_por_pagina = $request['length'];
    
    
            for ($i = $inicio; $i < count($aPostulaciones) && $cont < $registros_por_pagina; $i++) {
                $row = array();
                $row[] = '<a href="/admin/postulaciones/' . $aPostulaciones[$i]->idpostulacion . '">' . $aPostulaciones[$i]->nombre . '</a>';
                $row[] = $aPostulaciones[$i]->apellido;
                $row[] = $aPostulaciones[$i]->celular;
                $row[] = $aPostulaciones[$i]->correo;
                $row[] = '<a href ="/files/'.$aPostulaciones[$i]-> curriculum.'"> Descargar </a>';
                $cont++;
                $data[] = $row;
            }
    
            $json_data = array(
                "draw" => intval($request['draw']),
                "recordsTotal" => count($aPostulaciones), //cantidad total de registros sin paginar
                "recordsFiltered" => count($aPostulaciones), //cantidad total de registros en la paginacion
                "data" => $data,
            );
            return json_encode($json_data);
        }

        public function editar($idPostulacion)
        {
            $titulo = "Edicion de postulacion";
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("POSTULANTEEDITAR")) {
                    $codigo = "POSTULANTEEDITAR";
                    $mensaje = "No tiene permisos para la operacion.";
                    return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
                } else {
                    $postulacion = new Postulacion();
                    $postulacion->obtenerPorId($idPostulacion);
                    return view("sistema.postulacion-nuevo", compact("titulo", "postulacion"));
                }
            } else {
                return redirect('admin/login');
            }
        }

        public function eliminar(request $request)
        {
            if (Usuario::autenticado() == true) {
                if (!Patente::autorizarOperacion("POSTULANTEBAJA")) {
                    $resultado["err"] = EXIT_FAILURE;
                    $resultado["mensaje"] = "No tiene permisos para la operacion.";
                } else {
                    $postulacion = new Postulacion();
                    $postulacion->idpostulacion = $request->input("id");
                    $postulacion->eliminar();
                    $resultado["err"] = EXIT_SUCCESS;
                    $resultado["mensaje"] = "Registro eliminado exitosamente.";
                }
            return json_encode($resultado);
        }
        }
}