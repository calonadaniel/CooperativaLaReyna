<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class currencyExchangeController extends Controller
{
    public function index() { 

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
        return view('index', compact('dailyCurrencyArray'));
     }  
}
