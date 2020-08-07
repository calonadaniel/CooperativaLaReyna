//require('./bootstrap');

//Selector dropdown de la moneda Base
$(document).ready(function() {
  $("#currencySelected").msDropdown();
});

//Selector dropdown de la moneda Versus
$(document).ready(function() {
  $("#currencyVersus").msDropdown();
});


/*
  Funcion para actualizar el valor del textbox de la moneda versus tomando de referencia la moneda base y  
  cantidad introducida en el textbox de la moneda base
  
  Esta funcion tambien se utiliza en selector de la moneda versus para que se actualice el textbox de la moneda versus
   con la moneda versus seleccionada del selector sin que este sobreescriba los valores del selector base 
   y su respectiva cantidad base introducida en el texbox
*/

function currencyVersusUpdate() { 
  currencySelectedRate = document.getElementById("currencySelected").value; 
  amountEntered = document.getElementById("amountEntered").value;

  totalBase = (1/currencySelectedRate) * amountEntered; 

  currencyVersusRate = document.getElementById("currencyVersus").value; 

  totalVersus = totalBase*currencyVersusRate;

  document.getElementById("amountVersus").value = totalVersus.toFixed(2);

  console.log(totalBase*currencyVersusRate);
} 

/*
  Con esta funcion actaulizo el texbox de la moneda base tomando de referencia la moneda versus seleccionada
  y su respectiva cantidad.
*/
function currencyBaseUpdate() { 
  currencyVersusRate = document.getElementById("currencyVersus").value; 
  amountVersus = document.getElementById("amountVersus").value;

  totalVersus = (1/currencyVersusRate) * amountVersus; 

  currencySelectedRate = document.getElementById("currencySelected").value; 

  totalBase = totalVersus*currencySelectedRate;

  document.getElementById("amountEntered").value = totalBase.toFixed(2);

  console.log(totalBase*currencyVersusRate);
} 








  