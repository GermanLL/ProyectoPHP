@extends("web.plantilla")
@section('contenido')

  <!-- book section -->
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Contactanos!
        </h2>
      </div>
      @if(isset($msg))
            <div class="row">
                  <div class="col-12 text-center">
                        <div class="alert alert-{{ $msg['ESTADO'] }}" role="alert">
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
                <input type="text" class="form-control" placeholder="Nombre" id="txtNombre" name="txtNombre" required/>
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Telefono" id="txtTelefono" name="txtTelefono" required/>
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Email" id="txtCorreo" name="txtCorreo" required/>
              </div>
              <div>
                <textarea name="txtComentario" class="form-control shadow" placeholder="Escribe aquí tu mensaje" id="txtComentario" name="txtComentario" required></textarea>
              </div>
              <div class="btn_box">
                <button type="submit">
                  Enviar
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container ">
            <div id="googleMap"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end book section -->

  @endsection
 