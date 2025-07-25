<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
      protected $table = 'estados';
      public $timestamps = false;
  
      protected $fillable = [
          'idestado', 'nombre',
      ];
  
      protected $hidden = [
  
      ];

      public function obtenerTodos()
      {
          $sql = "SELECT
                    idestado,
                    nombre
                  FROM estados ORDER BY nombre ASC";
          $lstRetorno = DB::select($sql);
          return $lstRetorno;
      }

      public function obtenerPorId($idEstado)
      {
          $sql = "SELECT
                  idestado,
                  nombre
                  FROM estados WHERE idestado = $idEstado";
          $lstRetorno = DB::select($sql);
  
          if (count($lstRetorno) > 0) {
              $this->idestado = $lstRetorno[0]->idestado;
              $this->nombre = $lstRetorno[0]->nombre;
              return $this;
          }
          return null;
      }

      public function guardar() 
      {
            $sql = "UPDATE estados SET
                nombre='$this->nombre'
                WHERE idestado=?";
            $affected = DB::update($sql, [$this->idestado]);
      }

      public function eliminar()
      {
            $sql = "DELETE FROM estados WHERE
                idestado=?";
            $affected = DB::delete($sql, [$this->idestado]);
      }

      public function insertar()
      {
          $sql = "INSERT INTO estados (
                  nombre
              ) VALUES (? );";
          $result = DB::insert($sql, [
              $this->nombre,
          ]);
          return $this->idestado = DB::getPdo()->lastInsertId();
      }


}