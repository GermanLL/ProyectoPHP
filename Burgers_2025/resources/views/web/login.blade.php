@extends("web.plantilla")
@section('contenido')
<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container">
      <h2>
        Ingresar
      </h2>
    </div>
    @if(isset($mensaje))
    <div class="row">
      <div class="col-md-6">
        <div class="alert alert-danger" role="alert">
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
              <input type="email" class="form-control" placeholder="Email" id="txtCorreo" name="txtCorreo" value="" />
            </div>
            <div>
              <input type="password" class="form-control" placeholder="Contraseña" id="txtClave" name="txtClave" value="" />
            </div>
            <div class="btn_box text-center">
              <button type="submit" name="btnIngresar">
                Ingresar
              </button>
               <p>
                 <a href="/registrarse"> No tenes cuenta? Registrar nuevo usuario </a>
                </p>
                <p>
                  <a href="/recuperar-clave">Olvidaste tu contraseña?</a>
                </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
</section> 
@endsection