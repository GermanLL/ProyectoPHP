<?php

namespace App\Http\Controllers;

use App\Entidades\Pedido;


require app_path() . '/start/constants.php';

class ControladorMercadoPago extends Controller{

      public function aprobar($idPedido){
            $pedido = new Pedido();
            $pedido->obtenerPorId($idPedido);
            $pedido->fk_idestado = 1;
            $pedido->guardar();
            return redirect("/mi-cuenta");
      }

       public function pendiente($idPedido){

            $pedido = new Pedido();
            $pedido->obtenerPorId($idPedido);
            $pedido->fk_idestado = 5;
            $pedido->guardar();
            
      }

       public function error($idPedido){

            $pedido = new Pedido();
            $pedido->obtenerPorId($idPedido);
            $pedido->fk_idestado = 4;
            $pedido->guardar();
            
      }

      
}