<?php

namespace App\Entidades;

use DB;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    public $timestamps = false;

    protected $fillable = [
        'idpedido',
        'fk_idcliente',
        'fk_idsucursal',
        'fk_idestado',
        'fecha',
        'total',
        'pago'
    ];

    protected $hidden = [];

    public function cargarDesdeRequest($request)
    {
        $this->idpedido = $request->input('id') != "0" ? $request->input('id') : $this->idpedido;
        $this->fk_idcliente = $request->input('lstlfk_idcliente');
        $this->fk_idsucursal = $request->input('lstlfk_idsucursal');
        $this->fk_idestado = $request->input('lstlfk_idestado');
        $this->fecha = $request->input('txtFecha');
        $this->total = $request->input('txtTotal');
        $this->pago = $request->input('lstPago');
    }

    public function obtenerTodos()
    {
        $sql = "SELECT
                    idpedido,
                    fk_idcliente,
                    fk_idsucursal,
                    fk_idestado,
                    fecha,
                    total,
                    pago
                  FROM pedidos ORDER BY fecha DESC";
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }

    public function obtenerPorId($idPedido)
    {
        $sql = "SELECT
                        idpedido,
                        fk_idcliente,
                        fk_idsucursal,
                        fk_idestado,
                        fecha,
                        total,
                        pago
                  FROM pedidos WHERE idpedido = '$idPedido'";
        $lstRetorno = DB::select($sql);

        if (count($lstRetorno) > 0) {
            $this->idpedido = $lstRetorno[0]->idpedido;
            $this->fk_idcliente = $lstRetorno[0]->fk_idcliente;
            $this->fk_idsucursal = $lstRetorno[0]->fk_idsucursal;
            $this->fk_idestado = $lstRetorno[0]->fk_idestado;
            $this->fecha = $lstRetorno[0]->fecha;
            $this->total = $lstRetorno[0]->total;
            $this->pago = $lstRetorno[0]->pago;
            return $this;
        }
        return null;
    }

    public function guardar()
    {
        $sql = "UPDATE pedidos SET
                         fk_idcliente='$this->fk_idcliente',
                         fk_idsucursal='$this->fk_idsucursal',
                         fk_idestado='$this->fk_idestado',
                         fecha='$this->fecha',
                         total='$this->total',
                         pago='$this->pago'
                WHERE idpedido=?";
        $affected = DB::update($sql, [$this->idpedido]);
    }

    public function eliminar()
    {
        $sql = "DELETE FROM pedidos WHERE
                idpedido=?";
        $affected = DB::delete($sql, [$this->idpedido]);
    }

    public function insertar()
    {
        $sql = "INSERT INTO pedidos (
                  fk_idcliente,
                  fk_idsucursal,
                  fk_idestado,
                  fecha,
                  total,
                  pago
              ) VALUES (?, ?, ?, ?, ?, ?);";
        $result = DB::insert($sql, [
            $this->fk_idcliente,
            $this->fk_idsucursal,
            $this->fk_idestado,
            $this->fecha,
            $this->total,
            $this->pago,
        ]);
        return $this->idpedido = DB::getPdo()->lastInsertId();
    }

    public function obtenerFiltrado()
    {
        $request = $_REQUEST;
        $columns = array(
            0 => 'fecha',
            1 => 'fk_idsucursal',
            2 => 'fk_idcliente',
            3 => 'fk_idestado',
            4 => 'total',
            5 => 'pago',
        );
        $sql = "SELECT DISTINCT
                    A.idpedido,
                    A.fk_idcliente,
                    A.fk_idsucursal,
                    A.fk_idestado,
                    A.fecha,
                    A.total,
                    A.pago,
                    B.nombre AS sucursal,
                    C.nombre AS cliente,
                    D.nombre AS estado
                  FROM pedidos A
                  INNER JOIN sucursales B ON A.fk_idsucursal = B.idsucursal
                  INNER JOIN clientes C ON A.fk_idcliente = C.idcliente
                  INNER JOIN estados D ON A.fk_idestado = D.idestado
                  WHERE 1=1
                  ";

        //Realiza el filtrado
        if (!empty($request['search']['value'])) {
            $sql .= " AND ( A.fecha LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR fk_idsucursal LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR fk_idcliente LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR fk_idestado LIKE '%" . $request['search']['value'] . "%' )";
            $sql .= " OR total LIKE '%" . $request['search']['value'] . "%' ";
            $sql .= " OR pago LIKE '%" . $request['search']['value'] . "%' ";
        }
        $sql .= " ORDER BY " . $columns[$request['order'][0]['column']] . "   " . $request['order'][0]['dir'];

        $lstRetorno = DB::select($sql);

        return $lstRetorno;
    }

    public function existePedidosPorCliente($idCliente)
    {
        $sql = "SELECT
                      idpedido,
                      fk_idcliente,
                      fk_idsucursal,
                      fk_idestado,
                      fecha,
                      total,
                      pago
                  FROM pedidos WHERE fk_idcliente = $idCliente";
        $lstRetorno = DB::select($sql);

        return (count($lstRetorno) > 0);
    }

    public function existePedidosPorSucursal($idSucursal)
    {
        $sql = "SELECT
                      idpedido,
                      fk_idcliente,
                      fk_idsucursal,
                      fk_idestado,
                      fecha,
                      total,
                      pago
                  FROM pedidos WHERE fk_idsucursal = $idSucursal";
        $lstRetorno = DB::select($sql);

        return (count($lstRetorno) > 0);
    }

    public function existePedidosPorProducto($idProducto)
    {
        $sql = "SELECT
                      idpedidoproducto,
                      fk_idpedido,
                      fk_idproducto,
                      cantidad,
                      precio_unitario,
                      total,
                      pago
                  FROM pedidos_producto WHERE fk_idproducto = $idProducto";
        $lstRetorno = DB::select($sql);

        return (count($lstRetorno) > 0);
    }

    public function obtenerPedidoPorCliente($idCliente)
    {
        $sql = "SELECT
                    A.idpedido,
                    A.fk_idcliente,
                    A.fk_idsucursal,
                    A.fk_idestado,
                    A.fecha,
                    A.total,
                    A.pago,
                    B.nombre AS sucursal,
                    C.nombre AS estado
                  FROM pedidos A
                  INNER JOIN sucursales B ON A.fk_idsucursal = B.idsucursal
                  INNER JOIN estados C ON A.fk_idestado = C.idestado
                  WHERE fk_idcliente = '$idCliente' AND A.fk_idestado <>3"; 
        $lstRetorno = DB::select($sql);
        return $lstRetorno;
    }
}
