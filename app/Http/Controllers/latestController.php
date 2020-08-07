<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class latestController extends Controller
{
    public function index($currencySelected = false, $currencyVersus = false) {

        //El archivo se actualiza automaticamente a las 16:00 CET 
        $XMLContent=file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
    
        $dailyCurrencyArray = array();
        $dailyCurrencyArray = Arr::prepend($dailyCurrencyArray, 1, "EUR");

        //Llenar el array con los valores que posee el XML.
        foreach($XMLContent as $line){
            if(preg_match("/currency='([[:alpha:]]+)'/",$line,$currencyCode)){
                if(preg_match("/rate='([[:graph:]]+)'/",$line,$rate)){

                    //asignando el Rate(valor) y Currency(EUR). Ejemplo 1.17 = USD
                    $dailyCurrencyArray = Arr::prepend($dailyCurrencyArray, $rate[1], $currencyCode[1]);
                }
            }
        }

        ksort($dailyCurrencyArray); //ordenar en orrden alfabetico las monedas

        //Validacion moneda Base

        if($currencySelected == false ) {
           // dd("API para proporcionar el cambio de diferentes monedas, Ejempo: USD vs EUR.");
            return response(json_encode("API para proporcionar el cambio de diferentes monedas, Ejempo: USD vs EUR."));
        }
    
        //Convertir a mayuscula moneda base introducida en el API
        $currencySelected = strtoupper($currencySelected);
        
        //Buscar en el array la moneda base seleccionada, si no se encuentra en el array tiene un valor nulo(no valido)
        $currencySelectedRate = Arr::get($dailyCurrencyArray, $currencySelected); // Cuanto por 1 Euro. Ejemplo 1.17 USD = 1 Euro.
    
        //Si la moneda no se enontraba en los tipos de cambios del array o no se introdujo nada, mostrar mensaje.
        if($currencySelectedRate == null ) {
            //dd("La moneda Base introducida en la API no es valida");
            return response(json_encode("La moneda Base introducida en la API no es valida"));
        }
    
        //Ajustar los valores de intercambio de las demas monedas en relacion a la moneda base seleccionada
        foreach ($dailyCurrencyArray as $key => $value){
    
            $dailyCurrencyArray = array_merge($dailyCurrencyArray, [$key => ($value/$currencySelectedRate)]);
        }

        //El array que se convierte a json si los datos son validos
        $apiArray = array();

        //Determinar si es la API /{Currency} o /{Base}-{Versus}
        if($currencySelectedRate != null && $currencyVersus == false) { //si es false significa que no se introdujo
            $apiArray = array(
                'base' => $currencySelected,
                'date' => date("Y-m-d h:i:s a", time()),
                'rates'=>(
                    $dailyCurrencyArray
                )
            );
            //dd(json_encode($apiArray));
            return response(json_encode($apiArray)); 
        } 

        //Validacion moneda Versus

        //Convertir a mayuscula moneda verus introducida en el API
        $currencyVersus = strtoupper($currencyVersus);

        //Buscar en el array valor de la moneda versus seleccionada, si no se encuentra en el array tiene un valor nulo(no valido)
        $currencyVersusRate = Arr::get($dailyCurrencyArray, $currencyVersus); // Cuanto por 1 Euro. Ejemplo 1.17 USD = 1 Euro.
        
        if($currencySelectedRate != null && $currencyVersusRate == null) {

           //dd("La moneda versus introducida la API no es valida.");
            return response(json_encode("La moneda versus introducida en la API no es valida."));

        } else if ($currencySelectedRate != null && $currencyVersusRate != null) {

            $apiArray = array(
                'base' => $currencySelected,
                'vesus' => $currencyVersus,
                'date' => date("Y-m-d h:i:s a", time()),
                'rate'=> $currencyVersusRate,
            );
            //dd(json_encode($apiArray));
            return response(json_encode($apiArray));
        } 

        return view('index');
     }  

}
