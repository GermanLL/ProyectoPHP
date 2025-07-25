@extends("web.plantilla")
@section('contenido')
<!-- book section -->
<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container">
      <h2>
        Cambiar clave
      </h2>
    </div>
    @if(isset($msg))
    <div class="row">
      <div class="col-md-6">
        <div class="alert alert-{{ $msg['ESTADO'] }}"role="alert">
          {{ $msg['MSG'] }}
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
              <input type="password" class="form-control" name="txtClave1" id="txtClave1" placeholder="Clave nueva" />
            </div>
            <div>
              <input type="password" class="form-control" name="txtClave2" id="txtClave2" placeholder="Repetir nueva clave" />
            </div>
            <div class="btn_box">
              <button type="submit">
                Enviar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- end book section -->
@endsection