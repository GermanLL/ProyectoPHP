<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
      protected $table = 'rubros';
      public $timestamps = false;
  
      protected $fillable = [
          'idrubro', 'nombre',
      ];
  
      protected $hidden = [
  
      ];

      public function cargarDesdeRequest($request) 
      {
        $this->idrubro = $request->input('id') != "0" ? $request->input('id') : $this->idrubro;
        $this->nombre = $request->input('txtNombre');
    }

      public function obtenerTodos()
      {
          $sql = "SELECT
                    idrubro,
                    nombre
                  FROM rubros ORDER BY nombre ASC";
          $lstRetorno = DB::select($sql);
          return $lstRetorno;
      }

      public function obtenerPorId($idRubro)
      {
          $sql = "SELECT
                  idrubro,
                  nombre
                  FROM rubros WHERE idrubro = $idRubro";
          $lstRetorno = DB::select($sql);
  
          if (count($lstRetorno) > 0) {
              $this->idrubro = $lstRetorno[0]->idrubro;
              $this->nombre = $lstRetorno[0]->nombre;
              return $this;
          }
          return null;
      }

      public function guardar() 
      {
            $sql = "UPDATE rubros SET
                nombre='$this->nombre'
                WHERE idrubro=?";
            $affected = DB::update($sql, [$this->idrubro]);
      }

      public function eliminar()
      {
            $sql = "DELETE FROM rubros WHERE
                idrubro=?";
            $affected = DB::delete($sql, [$this->idrubro]);
      }

      public function insertar()
    {
        $sql = "INSERT INTO rubros (
                nombre
            ) VALUES (?);";
        $result = DB::insert($sql, [
            $this->nombre,
        ]);
        return $this->idrubro = DB::getPdo()->lastInsertId();
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'nombre',
        );
        $sql = "SELECT DISTINCT
                    idrubro,
                    nombre
                  FROM rubros
                WHERE 1=1
                ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

}