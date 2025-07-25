@extends("web.plantilla")
@section("banner")
    <!-- slider section -->
    <section class="slider_section ">
      <div id="customCarousel1" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="container ">
              <div class="row">
                <div class="col-md-7 col-lg-6 ">
                  <div class="detail-box">
                    <h1>
                      LASSEN BURGER
                    </h1>
                    <p>
                      Nos especializamos en creación de productos gourmet, donde la prioridad esta puesta en la calidad como en la elección de los mejores productos frescos y naturales, sin agregado de conservantes ni colorantes.
                    </p>
                    <div class="btn-box">
                      <a href="/login" class="btn1">
                        Pedir ahora
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item ">
            <div class="container ">
              <div class="row">
                <div class="col-md-7 col-lg-6 ">
                  <div class="detail-box">
                    <h1>
                      LASSEN BURGER
                    </h1>
                    <p>
                       Nuestro chef desarrolló una receta de hamburguesas gourmet de estilo casero, llenas de sabor, pan de elaboración propia y salsas especiales.
                    </p>
                    <div class="btn-box">
                      <a href="/registrarse" class="btn1">
                        Crea tu cuenta
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="carousel-item">
            <div class="container ">
              <div class="row">
                <div class="col-md-7 col-lg-6 ">
                  <div class="detail-box">
                    <h1>
                      LASSEN BURGER
                    </h1>
                    <p>
                      En LASSEN BURGER estamos en esos pequeños detalles, brindándote una cálida experiencia para que te sientas comiendo en casa.
                    </p>
                    <div class="btn-box">
                      <a href="/login" class="btn1">
                        ingresa a tu cuenta
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="container">
          <ol class="carousel-indicators">
            <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
            <li data-target="#customCarousel1" data-slide-to="1"></li>
            <li data-target="#customCarousel1" data-slide-to="2"></li>
          </ol>
        </div>
      </div>

    </section>
    <!-- end slider section -->
@endsection

 <!-- offer section -->
@section("contenido")
  <section class="offer_section layout_padding-bottom">
    <div class="offer_container">
      <div class="container ">
         @if(isset($msg))
      <div class="row justify-content-center">
        <div class="col-md-5-content-center">
          <div class="alert alert-{{ $msg['ESTADO'] }}" role="alert">
            {{ $msg['MSG']}}
        </div>
      </div>
    </div>
    @endif
        <div class="row">
          @foreach($aProductos AS $producto) @if($producto->categoria == 'Combo')
          <div class="col-md-6 {{ $producto->categoria}} ">
            
            <div class="box ">
              <div class="img-box">
                <img src="/files/{{ $producto->imagen }}" alt="">
              </div>
              
              <div class="detail-box">
                <h5>
                  {{ $producto->nombre}}
                </h5>
                <p>
                  <span> ${{ number_format($producto->precio, 0, ',', '.') }}</span>
                </p>
               <form action="" method="POST" style="display: flex; align-items: center; gap: 25px;">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" id="txtProducto" name="txtProducto" class="form-control" style="width: 50px;" value="{{ $producto->idproducto}}" required>
                    <input type="number" id="txtCantidad" name="txtCantidad" class="form-control" style="width: 50px;" value="0" min="1" required>
                  
                  <button type="submit"  class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-fill" viewBox="0 0 16 16">
                      <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                    </svg> </button>
                    </form>
              </div>
            </div>
          </div>
          @endif
          @endforeach
        </div>
      </div>
    </div>
  </section>


  @endsection
 
  