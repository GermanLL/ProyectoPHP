<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido_producto extends Model
{
      protected $table = 'pedido_productos';
      public $timestamps = false;
  
      protected $fillable = [
          'idpedidoproducto', 'fk_idpedido', 'fk_idproducto', 'cantidad', 'precio_unitario', 'total',
      ];
  
      protected $hidden = [
  
      ];

      public function obtenerTodos()
      {
          $sql = "SELECT
                    idpedidoproducto,
                    fk_idpedido,
                    fk_idproducto,
                    cantidad,
                    precio_unitario,
                    total
                  FROM pedido_productos ORDER BY nombre ASC";
          $lstRetorno = DB::select($sql);
          return $lstRetorno;
      }

      public function obtenerPorPedido($idPedido)
      {
          $sql = "SELECT
                    A.idpedidoproducto,
                    A.fk_idpedido,
                    A.fk_idproducto,
                    A.cantidad,
                    A.precio_unitario,
                    A.total,
                    B.nombre,
                    B.imagen
                  FROM pedido_productos A
                  INNER JOIN productos B ON A.fk_idproducto = B.idproducto
                  WHERE A.fk_idpedido = $idPedido
                  ORDER BY idpedidoproducto ASC";
          $lstRetorno = DB::select($sql);
          return $lstRetorno;
      }

      public function obtenerPorId($idPedidoProducto)
      {
          $sql = "SELECT
                  idpedidoproducto,
                  fk_idpedido,
                  fk_idproducto,
                  cantidad,
                  precio_unitario,
                  total
                  FROM pedido_productos WHERE idpedidoproducto = $idPedidoProducto";
          $lstRetorno = DB::select($sql);
  
          if (count($lstRetorno) > 0) {
              $this->idpedidoproducto = $lstRetorno[0]->idpedidoproducto;
              $this->fk_idpedido = $lstRetorno[0]->fk_idpedido;
              $this->fk_idproducto = $lstRetorno[0]->fk_idproducto;
              $this->cantidad = $lstRetorno[0]->cantidad;
              $this->precio_unitario = $lstRetorno[0]->precio_unitario;
              $this->total = $lstRetorno[0]->total;
              return $this;
          }
          return null;
      }

      public function guardar() 
      {
            $sql = "UPDATE pedido_productos SET
                fk_idpedidoproducto='$this->fk_idpedidoproducto',
                fk_idproducto='$this->fk_idproducto',
                cantidad='$this->cantidad',
                precio_unitario='$this->precio_unitario',
                total='$this->total'
                WHERE idpedidoproducto=?";
            $affected = DB::update($sql, [$this->idpedidoproducto]);
      }

      public function eliminar()
      {
            $sql = "DELETE FROM pedido_productos WHERE
                idpedidoproducto=?";
            $affected = DB::delete($sql, [$this->idpedidoproducto]);
      }

      public function insertar()
      {
          $sql = "INSERT INTO pedido_productos (
                  fk_idpedido,
                  fk_idproducto,
                  cantidad,
                  precio_unitario,
                  total
              ) VALUES (?, ?, ?, ?, ? );";
          $result = DB::insert($sql, [
              $this->fk_idpedido,
              $this->fk_idproducto,
              $this->cantidad,
              $this->precio_unitario,
              $this->total,
          ]);
          return $this->idpedidoproducto = DB::getPdo()->lastInsertId();
      }

   

}