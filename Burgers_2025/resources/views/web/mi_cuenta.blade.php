@extends("web.plantilla")
@section('contenido')
<?php
if (isset($msg)) {
  echo '<div id = "msg"></div>';
  echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>

<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container">
      <h2>
        Datos del Usuario
      </h2>
    </div>

    <div class="form_container">
      <form action="" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
        <div class="row">
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Nombre y Apellido" id="txtNombre" name="txtNombre" value="{{ $cliente->nombre}}">
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="DNI" id="txtDni" name="txtDni" value="{{ $cliente->dni}}">
          </div>
          <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Direccion" id="txtDireccion" name="txtDireccion" value="{{ $cliente->direccion}}">
          </div>
          <div class="col-md-6">
            <input type="email" class="form-control" placeholder="Email" id="txtCorreo" name="txtCorreo" value="{{ $cliente->correo}}">
          </div>
          <div class="col-md-6">
            <input type="txt" class="form-control" placeholder="WhatsApp" id="txtTelefono" name="txtTelefono" value="{{ $cliente->telefono}}">
          </div>
        </div>
        <div class="btn_box text-center">
          <button>
            Guardar
          </button>
        </div>
      </form>
    </div>
    <div class="row">
      <div class="col-6">
        <a href="/cambiar-clave"> Cambiar clave </a>
      </div>
    </div>

    <div class="row">
      <h2 class="mt-4">Pedidos Activos</h2>
      <div class="col-10 offset-1 mt-2">
        <table class="table table-hover mt-3">
          <thead>
            <tr>
              <th>Sucursal</th>
              <th>Pedido</th>
              <th>Estado Pedido</th>
              <th>Fecha</th>
              <th>Total</th>
            </tr>
          </thead>
          <form action="" id="" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <tbody>
           
              @foreach($aPedidos AS $pedido)
              <tr>
                <td>{{ $pedido->sucursal}}</td>
                <td>{{ $pedido->idpedido}}</td>
                <td>{{ $pedido->estado}}</td>
                <td>{{ $pedido->fecha}}</td>
                <td>${{ $pedido->total}}</td>
              </tr>
              @endforeach
       
            </tbody>
          </form>
        </table>
      </div>
    </div>
  </div>

</section>

@endsection