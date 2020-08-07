@extends('components.template')
@section('content')

{{--Seccion Convertidor de moneda--}}
<div class="section" >
    <div class="container">
        <h1  id="currencyExchange" class="py-5 text-center">Currency Exchange</h1> 
        <div class="row mx-2">
            <div class="col-6">
               <div class="row">
                    @php
                        //Aqui agrego mas bandera en el dropdown y su respectiva tasa de cambio 
                        $flagArray = array("us","eu","gb","ca","jp","au","cn"); //Se usa la ISO-3166    
                        $validCurrency = array("USD","EUR","GBP","CAD","HKD","AUD","CNY"); //Se usa la ISO 4217
                    
                        foreach ($dailyCurrencyArray as $key => $value) {
                            if(in_array( $key, $validCurrency ) == false ) {
                                unset($dailyCurrencyArray[$key]); //Quitar del arreglo si moneda no esta en $validCurrency
                            }
                        } 
                        $i = 0;
                        $j = 0;
                    @endphp

                    <select data-show-content="true" class="form-control" name="currencySelected" id="currencySelected" onchange="currencyVersusUpdate()">
                        @foreach ($flagArray as $flag)
                            @foreach ($dailyCurrencyArray as $key => $value) 
                                @if ($key == $validCurrency[$i])
                                    <option value='{{$value}}' data-image="images/msdropdown/icons/blank.gif" data-imagecss="flag {{$flag}}" data-title="{{$key}}">{{$key}}</option>
                                @endif
                            @endforeach
                            @php
                            $i++;
                            @endphp
                        @endforeach 
                    </select> 
               </div>
               <div class="row mt-2">
                <input type="number" step="0.01" placeholder="0.00" style="width:50%" name="amountEntered" id="amountEntered" oninput="currencyVersusUpdate()" >
                <p id="demo"></p>
                <p id="demo2"></p>
               </div>
            </div>

            <div class="col-6 ">
                <div class="row">
                    <select data-show-content="true" class="form-control" name="currencyVersus" id="currencyVersus" onchange="currencyVersusUpdate()" >
                        @foreach ($flagArray as $flag)
                            @foreach ($dailyCurrencyArray as $key => $value) 
                                @if ($key == $validCurrency[$j])
                                    <option value='{{$value}}' data-image="images/msdropdown/icons/blank.gif" data-imagecss="flag {{$flag}}" data-title="{{$key}}">{{$key}}</option>
                                @endif
                            @endforeach
                            @php
                            $j++;
                            @endphp
                        @endforeach 
                    </select> 
                </div>
                <div class="row mt-2">
                 <input type="number" step="0.01" class="ml-auto" placeholder="0.00" style="width:50%"  name="amountVersus" id="amountVersus" oninput="currencyBaseUpdate()" >
                </div>
             </div>
        </div>
    </div>   
</div>

{{---Seccion detalles sobre la API--}}
<div class="section">
    <div class="container">
        <div class="row pt-5 mx-2">
            <div class="col-sm-6">
              <div class="card border-primary mb-3">
                <div class="card-body">
                  <h5 class="card-title">Sobre la API:</h5>
                  <p class="card-text">Proporciona el tipo de cambio de diferentes monedas, 
                                        por ejemplo. USD vs EUR. </p>
                  <p>Esta API proporciona el  tipo de cambio de una moneda al resto de las monedas.</p>                      
                  <a href="/latest/USD" class="btn btn-primary mb-1">/latest{USD}</a>
                  <a href="/latest/USD-EUR" class="btn btn-primary mb-1">/latest{USD}-{EUR}</a>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="card border-primary mb-3">
                <div class="card-body">
                  <h5 class="card-title">Detalles:</h5>
                  <p class="card-text">…/latest/{currency} Devuelve el último tipo de cambio para una moneda determinada frente a las demás monedas.</p>
                  <p class="card-text">…/latest/{base}-{versus} Devuelve el último tipo de cambio de la divisa base frente a la divisa en comparación.</p>
                  <p>Todas las respuestas son en formato JSON.</p>
                </div>
              </div>
            </div>
          </div>
    </div>
</div>

{{---Seccion detalles sobre el convertidor de monedas---}}
<div class="section">
    <div class="container">
        <div class="row mx-2 mt-2">
            <div class="col-sm-6">
                <div class="card border-primary mb-3">
                    <div class="card-header bg-primary text-white">Currency Exchange Web App</div>
                    <div class="card-body text-primary">
                      <h5 class="card-title">Detalles:</h5>
                      <p class="card-text">Muestra información de cambio de moneda y permite que los usuarios calculen el intercambio de una moneda a otra.</p>
                      <p class="card-text">Posee un diseño responsive para telefonos móviles, tablets y computadoras.</p>
                      <a href="#currencyExchange" class="btn btn-primary mb-1">Usar</a>
                    </div>
                  </div>
            </div>

            <div class="col-sm-6">
                <div class="card border-primary mb-3">
                    <div class="card-header bg-primary text-white">Ficha Técnica </div>
                    <div class="card-body text-primary">
                      <p class="card-text">Laravel Framework</p>
                      <p class="card-text">Bootstrap 5</p>
                      <p class="card-text">HTML5 & CSS</p>
                      <p class="card-text">Javascript</p>
                      <a href="" class="btn btn-primary mb-1">Ver Repositorio</a>
                    </div>
                  </div>
            </div>
          </div>
    </div>
</div>
@endsection



