<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
      protected $table = 'sucursales';
      public $timestamps = false;
  
      protected $fillable = [
          'idsucursal', 'telefono', 'direccion', 'mapa', 'nombre', 'horario',
      ];
  
      protected $hidden = [
  
      ];

      public function cargarDesdeRequest($request) 
      {
        $this->idsucursal = $request->input('id') != "0" ? $request->input('id') : $this->idsucursal;
        $this->telefono = $request->input('txtTelefono');
        $this->direccion = $request->input('txtDireccion');
        $this->mapa = $request->input('txtMapa');
        $this->nombre = $request->input('txtNombre');
        $this->horario = $request->input('txtHorario');
    }

      public function obtenerTodos()
      {
          $sql = "SELECT
                    idsucursal,
                    telefono,
                    direccion,
                    mapa,
                    nombre,
                    horario
                  FROM sucursales ORDER BY nombre ASC";
          $lstRetorno = DB::select($sql);
          return $lstRetorno;
      }

      public function obtenerPorId($idSucursal)
      {
          $sql = "SELECT
                  idsucursal,
                  telefono,
                  direccion,
                  mapa,
                  nombre,
                  horario
                  FROM sucursales WHERE idsucursal = $idSucursal";
          $lstRetorno = DB::select($sql);
  
          if (count($lstRetorno) > 0) {
              $this->idsucursal = $lstRetorno[0]->idsucursal;
              $this->telefono = $lstRetorno[0]->telefono;
              $this->direccion = $lstRetorno[0]->direccion;
              $this->mapa = $lstRetorno[0]->mapa;
              $this->nombre = $lstRetorno[0]->nombre;
              $this->horario = $lstRetorno[0]->horario;
              return $this;
          }
          return null;
      }

      public function guardar() 
      {
            $sql = "UPDATE sucursales SET
                telefono='$this->telefono',
                direccion='$this->direccion',
                mapa='$this->mapa',
                nombre='$this->nombre',
                horario='$this->horario'
                WHERE idcliente=?";
            $affected = DB::update($sql, [$this->idsucursal]);
      }

      public function eliminar()
      {
            $sql = "DELETE FROM sucursales WHERE
                idsucursal=?";
            $affected = DB::delete($sql, [$this->idsucursal]);
      }

      public function insertar()
      {
          $sql = "INSERT INTO sucursales (
                  telefono,
                  direccion,
                  mapa,
                  nombre,
                  horario
              ) VALUES (?, ?, ?, ?, ? );";
          $result = DB::insert($sql, [
              $this->telefono,
              $this->direccion,
              $this->mapa,
              $this->nombre,
              $this->horario,
          ]);
          return $this->idsucursal = DB::getPdo()->lastInsertId();
      }

      public function obtenerFiltrado()
      {
          $request = $_REQUEST;
          $columns = array(
              0 => 'nombre',
              1 => 'direccion',
              2 => 'telefono',
              3 => 'horario',
          );
          $sql = "SELECT DISTINCT
                      idsucursal,
                      telefono,
                      direccion,
                      mapa,
                      nombre,
                      horario
                    FROM sucursales
                  WHERE 1=1
                  ";
  
          //Realiza el filtrado
          if (!empty($request['search']['value'])) {
              $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
              $sql .= " OR direccion LIKE '%" . $request['search']['value'] . "%' ";
              $sql .= " OR telefono LIKE '%" . $request['search']['value'] . "%' ";
              $sql .= " OR horario LIKE '%" . $request['search']['value'] . "%' )";
          }
          $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];
  
          $lstRetorno = DB::select($sql);
  
          return $lstRetorno;
      }

}