@extends("web.plantilla")
@section('contenido')
<!-- book section -->
<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container">
      <h2>
        ¿Olvidaste tu contraseña?
      </h2>
      <p>Ingresa la direccion de correo electronico con la que te registraste y te enviaremos las instrucciones para cambiar la contraseña</p>
    </div>
     @if(isset($mensaje))
      <div class="row">
        <div class="col-md-6">
          <div class="alert alert-{{ $mensaje }}" role="alert">
            {{ $mensaje }}
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
              <input type="email" class="form-control" placeholder="Ingresa su correo electronico" name="txtCorreo" id="txtCorreo" required />
              </div>
              <div class="btn_box">
                <button type="submit">
                  Recuperar
                </button>
              </div>
            </div>
            </form>
          </div>
        </div>
      </div>
</section>
<!-- end book section -->

@endsection