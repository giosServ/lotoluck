const boton1= document.getElementById("botonBusqueda1");
const boton2= document.getElementById("botonBusqueda2");
const boton3= document.getElementById("botonBusqueda3");
const boton4= document.getElementById("botonBusqueda4");
const boton5= document.getElementById("botonBusqueda5");

var formulario = document.getElementById("formulario");
var formulario2 = document.getElementById("formulario2");
var formulario3 = document.getElementById("formulario3");
var formulario4 = document.getElementById("formulario4");
var formulario5 = document.getElementById("formulario5");


boton1.addEventListener("click", function(){
  if(formulario.style.display==="block"){
      formulario.style.display="none";
  }else{
    formulario.style.display="block";
    formulario2.style.removeProperty("display");
    formulario3.style.removeProperty("display");
    formulario4.style.removeProperty("display");
    formulario5.style.removeProperty("display");
  }
});

boton2.addEventListener("click", function(){
  if(formulario2.style.display==="block"){
      formulario2.style.display="none";
  }else{
    formulario2.style.display="block";
    formulario.style.removeProperty("display");
    formulario3.style.removeProperty("display");
    formulario4.style.removeProperty("display");
    formulario5.style.removeProperty("display");
  }
});

boton3.addEventListener("click", function(){
  if(formulario3.style.display==="block"){
      formulario3.style.display="none";
  }else{
    formulario3.style.display="block";
    formulario2.style.removeProperty("display");
    formulario.style.removeProperty("display");
    formulario4.style.removeProperty("display");
    formulario5.style.removeProperty("display");
  }
});
boton4.addEventListener("click", function(){
  if(formulario4.style.display==="block"){
      formulario4.style.display="none";
  }else{
    formulario4.style.display="block";
    formulario2.style.removeProperty("display");
    formulario3.style.removeProperty("display");
    formulario.style.removeProperty("display");
    formulario5.style.removeProperty("display");
  }
});
boton5.addEventListener("click", function(){
  if(formulario5.style.display==="block"){
      formulario5.style.display="none";
  }else{
    formulario5.style.display="block";
    formulario2.style.removeProperty("display");
    formulario3.style.removeProperty("display");
    formulario4.style.removeProperty("display");
    formulario.style.removeProperty("display");
  }
});

