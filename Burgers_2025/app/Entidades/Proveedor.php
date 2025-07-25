<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
      protected $table = 'proveedores';
      public $timestamps = false;
  
      protected $fillable = [
          'idproveedor', 'nombre', 'domicilio', 'cuit', 'fk_idrubro',
      ];
  
      protected $hidden = [
  
      ];

      public function cargarDesdeRequest($request) 
      {
        $this->idproveedor = $request->input('id') != "0" ? $request->input('id') : $this->idproveedor;
        $this->nombre = $request->input('txtNombre');
        $this->domicilio = $request->input('txtDomicilio');
        $this->cuit = $request->input('txtCuit');
        $this->fk_idrubro = $request->input('lstFk_idrubro');
    }


      public function obtenerTodos()
      {
          $sql = "SELECT
                    idproveedor,
                    nombre,
                    domicilio,
                    cuit,
                    fk_idrubro
                  FROM proveedores ORDER BY nombre ASC";
          $lstRetorno = DB::select($sql);
          return $lstRetorno;
      }


      public function obtenerPorId($idProveedor)
      {
          $sql = "SELECT
                  idproveedor,
                  nombre,
                  domicilio,
                  cuit,
                  fk_idrubro
                  FROM proveedores WHERE idproveedor = $idProveedor";
          $lstRetorno = DB::select($sql);
  
          if (count($lstRetorno) > 0) {
              $this->idproveedor = $lstRetorno[0]->idproveedor;
              $this->nombre = $lstRetorno[0]->nombre;
              $this->domicilio = $lstRetorno[0]->domicilio;
              $this->cuit = $lstRetorno[0]->cuit;
              $this->fk_idrubro = $lstRetorno[0]->fk_idrubro;
              return $this;
          }
          return null;
      }

      public function guardar() 
      {
            $sql = "UPDATE proveedores SET
                nombre='$this->nombre',
                domicilio='$this->domicilio',
                cuit=$this->cuit,
                fk_idrubro='$this->fk_idrubro'
                WHERE idproveedor=?";
            $affected = DB::update($sql, [$this->idproveedor]);
      }
      
      public function eliminar()
      {
            $sql = "DELETE FROM proveedores WHERE
                idproveedor=?";
            $affected = DB::delete($sql, [$this->idproveedor]);
      }

      public function insertar()
      {
          $sql = "INSERT INTO proveedores (
                  nombre,
                  domicilio,
                  cuit,
                  fk_idrubro
              ) VALUES (?, ?, ?, ?);";
          $result = DB::insert($sql, [
              $this->nombre,
              $this->domicilio,
              $this->cuit,
              $this->fk_idrubro,
          ]);
          return $this->idproveedor = DB::getPdo()->lastInsertId();
      }

      public function obtenerFiltrado()
      {
          $request = $_REQUEST;
          $columns = array(
              0 => 'nombre',
              1 => 'cuit',
              2 => 'domicilio',
              3 => 'fk_idrubro',
          );
          $sql = "SELECT DISTINCT
                      A.idproveedor,
                      A.nombre,
                      A.domicilio,
                      A.cuit,
                      A.fk_idrubro,
                      B.nombre AS rubro
                    FROM proveedores A
                    INNER JOIN rubros B ON A.fk_idrubro = B.idrubro
                  WHERE 1=1
                  ";
  
          //Realiza el filtrado
          if (!empty($request['search']['value'])) {
              $sql .= " AND ( A.nombre LIKE '%" . $request['search']['value'] . "%' ";
              $sql .= " OR cuit LIKE '%" . $request['search']['value'] . "%' ";
              $sql .= " OR domicilio LIKE '%" . $request['search']['value'] . "%' ";
              $sql .= " OR fk_idrubro LIKE '%" . $request['search']['value'] . "%' )";
          }
          $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];
  
          $lstRetorno = DB::select($sql);
  
          return $lstRetorno;
      }

      public function existeProveedoresPorRubro($idRubro){
         $sql = "SELECT
                  idproveedor,
                  nombre,
                  domicilio,
                  cuit,
                  fk_idrubro
                  FROM proveedores WHERE fk_idrubro = $idRubro";
          $lstRetorno = DB::select($sql);
  
          return (count($lstRetorno) > 0);
           

      }

      
}