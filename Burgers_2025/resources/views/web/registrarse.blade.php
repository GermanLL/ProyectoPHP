@extends("web.plantilla")
@section('contenido')

 <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Registrarse
        </h2>
      </div>
      @if(isset($msg))
      <div class="row">
        <div class="col-md-6">
          <div class="alert alert-{{ $msg['ESTADO'] }}" role="alert">
            {{ $msg['MSG']}}
        </div>
      </div>
    </div>
    @endif
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form action="" method="POST">
              <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
              <div>
                <input type="text" class="form-control" placeholder="Nombre" id="txtNombre" name="txtNombre" value="" required />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="DNI" id="txtDni" name="txtDni" value="" required />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Telefono" id="txtTelefono" name="txtTelefono" value="" required />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Direccion" id="txtDireccion" name="txtDireccion" value="" required />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Mail" id="txtCorreo" name="txtCorreo" value="" required />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Contraseña" id="txtClave" name="txtClave" value="" required />
              </div>
              <div class="btn_box">
                <button type="submit">
                  Registrarse
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection