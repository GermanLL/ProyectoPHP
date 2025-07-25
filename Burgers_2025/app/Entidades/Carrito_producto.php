<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class CarritoProducto extends Model
{
      protected $table = 'carrito_productos';
      public $timestamps = false;
  
      protected $fillable = [
          'idcarrito_producto', 'fk_idproducto', 'fk_idcarrito', 'cantidad',
      ];
  
      protected $hidden = [
  
      ];

      public function obtenerTodos()
      {
          $sql = "SELECT
                    idcarritoproducto,
                    fk_idproducto,
                    fk_idcarrito,
                    cantidad
                  FROM carrito_productos ORDER BY nombre ASC";
          $lstRetorno = DB::select($sql);
          return $lstRetorno;
      }

      public function obtenerPorId($idCarritoProducto)
      {
          $sql = "SELECT
                  idcarritoproducto,
                  fk_idproducto,
                  fk_idcarrito,
                  cantidad
                  FROM carrito_productos WHERE idcarritoproducto = $idCarritoProducto";
          $lstRetorno = DB::select($sql);
  
          if (count($lstRetorno) > 0) {
              $this->idcarritoproducto = $lstRetorno[0]->idcarritoproducto;
              $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
              $this->fk_carrito = $lstRetorno[0]->fk_carrito;
              $this->cantidad = $lstRetorno[0]->cantidad;
              return $this;
          }
          return null;
      }

      public function guardar() 
      {
            $sql = "UPDATE carrito_productos SET
                fk_idproducto='$this->fk_idproducto',
                fk_idcarrito='$this->fk_idcarrito',
                cantidad=$this->cantidad
                WHERE idcarritoproducto=?";
            $affected = DB::update($sql, [$this->idcarritoproducto]);
      }

      public function eliminar()
      {
            $sql = "DELETE FROM carrito_productos WHERE
                idcarritoproducto=?";
            $affected = DB::delete($sql, [$this->idcarritoproducto]);
      }

      public function insertar()
      {
          $sql = "INSERT INTO carrito_productos (
                  fk_idproducto,
                  fk_idcarrito,
                  cantidad
              ) VALUES (?, ?, ? );";
          $result = DB::insert($sql, [
              $this->fk_idproducto,
              $this->fk_idcarrito,
              $this->cantidad,
          ]);
          return $this->idcarritoproducto = DB::getPdo()->lastInsertId();
      }


}