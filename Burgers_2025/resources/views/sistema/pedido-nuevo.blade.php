@extends("plantilla")
@section('titulo', $titulo)
@section('scripts')
<script>
    globalId = '<?php echo isset($pedido->idpedido) && $pedido->idpedido > 0 ? $pedido->idpedido : 0; ?>';
    <?php $globalId = isset($pedido->idpedido) ? $pedido->idpedido : "0";?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/pedidos">Pedidos</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/sistema/menu";
}
</script>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div id = "msg"></div>
<div class="panel-body">
        <form id="form1" method="POST">
            <div class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required>
                 <div class="form-group col-lg-6">
                    <label for>Cliente:</label>
                    <select id="lstlfk_idcliente" name="lstlfk_idcliente" class="form-control selectpicker">
                        <option value="" disabled selected>Seleccionar</option>
                        @foreach($aClientes as $cliente)
                          @if($cliente->idcliente == $pedido->fk_idcliente)
                        <option selected value="{{ $cliente->idcliente}}">{{ $cliente->nombre}}</option>
                          @else
                        <option value="{{ $cliente->idcliente}}">{{ $cliente->nombre}}</option>
                          @endif
                        @endforeach
                    </select>
                 </div>
                 <div class="form-group col-lg-6">
                    <label for>Medio de pago:</label>
                    <select id="lstPago" name="lstPago" class="form-control selectpicker">
                        <option value="" disabled selected>Seleccionar</option>

                        <option <?php echo $pedido->pago == "Mercadopago"? "selected" : ""; ?> value="Mercadopago">MercadoPago</option>
                        <option <?php echo $pedido->pago == "efectivo"? "selected" : ""; ?> value="efectivo">Efectivo</option>
                    </select>
                 </div>
                 <div class="form-group col-6">
                    <label for="lstlfk_idsucursal">Sucursal:</label>
                    <select name="lstlfk_idsucursal" id="lstlfk_idsucursal" class="form-control selectpicker">
                        <option value="" disabled selected>Seleccionar</option>
                        @foreach($aSucursales as $sucursal)
                          @if($sucursal->idsucursal == $pedido->fk_idsucursal)
                        <option selected value="{{ $sucursal->idsucursal}}">{{ $sucursal->nombre}}</option>
                          @else
                        <option value="{{ $sucursal->idsucursal}}">{{ $sucursal->nombre}}</option>
                          @endif
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-6">
                    <label for="lstlfk_idestado">Estado Pedido:</label>
                    <select name="lstlfk_idestado" id="lstlfk_idestado" class="form-control selectpicker">
                        <option value="" disabled selected>Seleccionar</option>
                        @foreach($aEstados as $estado)
                         @if($estado->idestado == $pedido->fk_idestado)
                        <option selected value="{{ $estado->idestado}}">{{ $estado->nombre}}</option>
                         @else
                        <option value="{{ $estado->idestado}}">{{ $estado->nombre}}</option>
                         @endif
                        @endforeach
                     </select>

                  </div>

                <div class="form-group col-6">
                    <label>Fecha:</label>
                    <input type="date" id="txtFecha" name="txtFecha" class="form-control" value="{{ $pedido->fecha}}" required>
                </div>
                <div class="form-group col-6">
                    <label>Total:</label>
                    <input type="number" id="txtTotal" name="txtTotal" class="form-control" value="{{ $pedido->total}}" required>
                </div>
                <div class="form-group col-6">
                @if($pedido->idpedido > 0)
                <div class="row">
                    <div class="col-12">
                        <label>Listado de Productos</label>
                    </div>
                    <table class="table table-hover border">
                        <tr>
                            <th>Imagen</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            @foreach ($aPedidoProductos as $producto)
                                <tr>
                                    <td><img src="/files/{{ $producto->imagen}}" class="img-thumbnail" style="width:90"></td>
                                    <td> {{ $producto->nombre}}</td>
                                    <td> {{ $producto->cantidad}} </td>
                                </tr>
                            @endforeach    
                        </tr>
                    </table>
                </div>
                @endif
                </div>
        </form>

        <script>
        $("#form1").validate();

    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit();
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }

       function eliminar() {
        $.ajax({
            type: "GET",
            url: "{{ asset('admin/pedido/eliminar') }}",
            data: { id:globalId },
            async: true,
            dataType: "json",
            success: function (data) {
                if (data.err == 0) {
                    msgShow(data.mensaje, "success");
                    $("#btnEnviar").hide();
                    $("#btnEliminar").hide();
                    $('#mdlEliminar').modal('toggle');
                } else {
                    msgShow(data.mensaje, "danger");
                    $('#mdlEliminar').modal('toggle');
                }
                
            }
        });
    }
    </script>
@endsection