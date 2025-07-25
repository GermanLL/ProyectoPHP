@extends("web.plantilla")
@section('contenido')
<!-- about section -->

<section class="about_section layout_padding">
  <div class="container  ">

    <div class="row">
      <div class="col-md-6 ">
        <div class="img-box">
          <img src="web/images/about-img.png" alt="">
        </div>
      </div>
      <div class="col-md-6">
        <div class="detail-box">
          <div class="heading_container">
            <h2>
              Somos Lassen
            </h2>
          </div>
          <p>
            Reformulamos la receta original, fortaleciendo hamburguesas gourmet, llenas de sabor, de estilo casero, usando los mejores ingredientes frescos y naturales. Presentadas en un pan casero especial de elaboración propia. Tenemos una propuesta innovadora de Pop-up Stores montadas en contenedores reciclados, totalmente equipados, que prometen al visitante una experiencia gastronómica única, garantizando la calidad y la originalidad de nuestros productos.
          </p>
          <a href="">
            Leer mas
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- end about section -->
<!-- client section -->

<section class="client_section layout_padding-bottom">
  <div class="container">
    <div class="heading_container heading_center psudo_white_primary mb_45">
      <h2>
        What Says Our Customers
      </h2>
    </div>
    <div class="carousel-wrap row ">
      <div class="owl-carousel client_owl-carousel">
        <div class="item">
          <div class="box">
            <div class="detail-box">
              <p>
                ¡Qué hamburguesas tan espectaculares! ¡Un lugar totalmente recomendado!
              </p>
              <h6>
                Monica Sevalle
              </h6>
              <p>
                Cordoba
              </p>
            </div>
            <div class="img-box">
              <img src="web/images/client1.jpg" alt="" class="box-img">
            </div>
          </div>
        </div>
        <div class="item">
          <div class="box">
            <div class="detail-box">
              <p>
                ¡Este sitio de hamburguesas es tan bueno que le daría un abrazo al cocinero... si no estuviera demasiado lleno de hamburguesa!
              </p>
              <h6>
                Andres Acosta
              </h6>
              <p>
                Buenos Aires
              </p>
            </div>
            <div class="img-box">
              <img src="web/images/client2.jpg" alt="" class="box-img">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- end client section -->

<!-- book section -->
<section class="book_section layout_padding">
  <div class="container">
    <div class="heading_container heading_center psudo_white_primary mb_45">
      <h2>
        Trabaja para nosotros!
      </h2>
    </div>
    <div class="row">
      <div class="col-md-6 mx-auto">
        <div class="form_container">
          <form action="" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
            <div>
              <input type="text" class="form-control" placeholder="Nombre" id="txtNombre" name="txtNombre" value="" required />
            </div>
            <div>
              <input type="text" class="form-control" placeholder="Apellido" id="txtApellido" name="txtApellido" value="" required />
            </div>
            <div>
              <input type="text" class="form-control" placeholder="Telefono / WhatsApp" id="txtCelular" name="txtCelular" value="" required />
            </div>
            <div>
              <input type="email" class="form-control" placeholder="Email" id="txtCorreo" name="txtCorreo" value="" required />
            </div>
            <div class="my-2">
              <label for="">Cargar CV</label>
              <input type="file"name="archivo" id="archivo" accept=".doc, .docx, .pdf">
              <small class="d-block">Archivos admitidos: .doc, .docx, .pdf</small>
            </div>
            <div class="btn_box text-center">
              <button type="submit">
                Enviar
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
</section>
<!-- end book section -->

@endsection