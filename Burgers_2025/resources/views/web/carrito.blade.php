@extends("web.plantilla")
@section('contenido')
<section class="carrito layout_padding">
      <div class="container">
            <div class="heading_container">
                  <h2 style="font-size: 5em; margin-bottom: 10px;">
                        Mi carrito
                  </h2>
            </div>
            @if(isset($msg))
            <div class="row">
                  <div class="col-12 text-center">
                        <div class="alert alert-{{ $msg['err'] }}" role="alert">
                              {{ $msg['mensaje'] }}
                        </div>
                  </div>
            </div>
            @endif
            <div class="row">
                  @if($aCarritos)
                  <div class="col-md-9">
                        <div class="row m-2 p-2">
                              <div class="col-md-12">
                                    <table class="table table-hover">
                                          <thead>
                                                <tr>
                                                      <th></th>
                                                      <th></th>
                                                      <th></th>
                                                      <th>Precio</th>
                                                      <th style="width: 15px;">Cantidad</th>
                                                      <th>Subtotal</th>
                                                      <th></th>
                                                </tr>
                                          </thead>
                                          <tdody>
                                                <?php
                                                $total = 0;
                                                $subtotal = 0;
                                                ?>
                                                @foreach($aCarritos AS $carrito)
                                                <?php
                                                $subtotal = $carrito->precio * $carrito->cantidad;
                                                $total += $subtotal;
                                                ?>
                                                <tr>
                                                      <form action="" id="" method="POST">
                                                            <td style="width: 0px;">
                                                                  <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                                                                  <input type="hidden" id="txtCarrito" name="txtCarrito" class="form-control" style="width: 50px;" value="{{$carrito->idcarrito}}" required>
                                                            </td>
                                                            <td style="width: 100px;">
                                                                  <img src="files/{{$carrito->imagen}}" class="img-thumbnail">
                                                            </td>
                                                            <td>
                                                                  {{ $carrito->producto}}
                                                            </td>
                                                            <td>
                                                                  ${{ $carrito->precio }}
                                                            </td>
                                                            <td style="width: 15 px;">
                                                                  
                                                            
                                                                  <input class="form-control" value="{{$carrito->fk_idproducto}}" type="hidden" name="txtProducto" id="txtProducto">
                                                                  <input class="form-control" value="{{$carrito->cantidad}}" min="1" type="number" name="txtCantidad" id="txtCantidad">

                                                            </td>
                                                            <td>
                                                                  ${{ number_format($subtotal, 2, ",", ".") }}
                                                            </td>
                                                            <td>

                                                                  <div class="btn-group">
                                                                        
                                                                        <button type="submit" class="btn btn-info" id="btnActualizar" name="btnActualizar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                                                                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z" />
                                                                                    <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466" />
                                                                              </svg>

                                                                        </button>

                                                                        <button type="submit" class="btn btn-danger" id="btnBorrar" name="btnBorrar"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                                                              </svg>
                                                                        </button>
                                                                  </div>
                                                            </td>
                                                      </form>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                      <td colspan="4" style="text-align: right;">¿Te faltó algo?</td>
                                                      <td colspan="2" style="text-align: right;"><a class="btn btn-primary" href="/takeaway">Continuar pedido</a>
                                                </tr>
                                          </tdody>
                                    </table>
                              </div>
                        </div>
                  </div>
                  <div class="col-md-3">
                        <div class="row mt-2 p-2">
                              <div class="col-md-12">
                                    <table class="table">
                                          <thead>
                                                <tr>
                                                      <th>TOTAL: $ {{ number_format($total, 2, ",", ".")}}
                                                </tr>

                                                </tr>
                                          </thead>
                                          <form action="" id="" method="POST">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                                                <tbody>
                                                      <tr>
                                                            <td>
                                                                  <label class="d-block">Sucursal:</label>
                                                                  <select id="lstSucursal" name="lstSucursal" class="form-select" required>
                                                                        <option value="" disabled selected>Seleccionar</option>
                                                                        @foreach($aSucursales as $sucursal)
                                                                        <option value="{{ $sucursal->idsucursal }}">{{ $sucursal->nombre }}</option>
                                                                        @endforeach
                                                                  </select>
                                                            </td>
                                                      </tr>
                                                      <tr>
                                                            <td>
                                                                  <label>Metodo de pago:</label>
                                                                  <select id="lstPago" name="lstPago" class="form-select" required>
                                                                        <option value="" disabled selected>Seleccionar</option>
                                                                        <option value="Mercadopago">Mercadopago</option>
                                                                        <option value="efectivo">Efectivo</option>
                                                                  </select>
                                                            </td>

                                                      </tr>
                                                      <tr>
                                                            <td><button type="submit" class="btn btn-success" id="btnFinalizar" name="btnFinalizar">Finalizar </button>
                                                            </td>
                                                      </tr>
                                                </tbody>
                                          </form>
                                    </table>
                              </div>
                        </div>
                  </div>
                  @else
                  <div class="row">
                        <div class="carrito col-md-12">
                              <p style="font-size: 1.5em;">
                                    No hay producto seleccionado
                              </p>
                        </div>
                        @endif
                  </div>
            </div>
      </div>

</section>
@endsection