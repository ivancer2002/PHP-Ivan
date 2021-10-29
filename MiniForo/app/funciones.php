<?php
//FUncion para el usuario y la contraseña
function usuarioOk($usuario, $contraseña) :bool {
  if (strlen($usuario) >= 8 && $usuario == strrev($contraseña) ) { //Lo qeue hace aqui es medir la longitud del usuario para que no sea mayor de 8 y que la contraseña tenga
   //que estar escrita del reves.
   return true;  
  }else{
     return false;
  }
    
}

//Funcion de las letras que se repiten

function letrasrepet(){
   $texto = $_REQUEST ["comentario"];
   $letra = str_split($texto); //Lo  que hace la fucnion str_split es convertirte la variable texto a un array
   $valores = array_count_values ($letra); //Lo que hace la funcion de count values es contarte los valores 1 por 1
   $max = 0; //Para inicializar la variable

   foreach ($valores as $key => $value) { //Hacemos un foreach para que recorra el array que hemos creado.
      if ($max < $value) {
        $max = $value;
        $maxrep = $key;
      }
   }

echo $maxrep;
   
}

//Funcion de las palabras repetidas

function palabrasrepet(){
   $texto = $_REQUEST ["comentario"];
   $palabra = str_split($texto); //Lo  que hace la fucnion str_split es convertirte la variable texto a un array
   $valores = array_count_values ($palabra); //Lo que hace la funcion de count values es contarte los valores 1 por 1
   $max = 0; //Para inicializar la variable

   foreach ($valores as $key => $value) { //Hacemos un foreach para que recorra el array que hemos creado.
      if ($max < $value) {
        $max = $value;
        $maxrep = $key;
      }
   }

echo $maxrep;
   
}
