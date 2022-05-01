<?php
// ------------------------------------------------
// Controlador que realiza la gestión de usuarios
// ------------------------------------------------

include_once 'config.php';
include_once 'modeloPeliDB.php'; 

/**********
/*
 * Inicio Muestra o procesa el formulario (POST)
 */

function  ctlPeliInicio(){
    die(" No implementado.");
   }

/*
 *  Muestra y procesa el formulario de alta 
 */

function ctlPeliAlta (){
    $nombre = isset($_POST['nombre']) ? $_POST['nombre']: false;
    $director = isset($_POST['director']) ? $_POST['director']: false;
    $genero = isset($_POST['genero']) ? $_POST['genero']: false;
    $imagen = isset($_POST['imagen']) ? $_POST['imagen']: false;
if($nombre && $director && $genero){
    if($imagen ==""){
        $imagen ="";
    }
    $pelicula = ModeloPeliDB::PeliAdd($nombre, $director, $genero, $imagen);
} 


require_once 'plantilla/newform.php';
}
/*
 *  Muestra y procesa el formulario de Modificación 
 */
function ctlPeliModificar (){
    header('location:app/plantilla/fmodifica.php');
}



/*
 *  Muestra detalles de la pelicula
 *  Ponemos la ruta a la que queremos ir con un header.
 */

function ctlPeliDetalles(){
   if (isset(($_GET['codigo']))){
   $pelicula = ModeloPeliDB::PeliDetalles($_GET['codigo']);
 require_once 'plantilla/detalle.php';
}
}

/*
 * Borrar Peliculas
 */

function ctlPeliBorrar(){
    if (isset($_GET['codigo'])){
   $pelicula = ModeloPeliDB::PeliDel($_GET['codigo']);
}
    header('Location:index.php');
}

/*
 * Buscar Peliculas
 */
{
    function ctlPeliBuscar(){
        header('Location:app/plantilla/verpeliculas.php');
    }
}

/*
 * Cierra la sesión y vuelca los datos
 */
function ctlPeliCerrar(){
    session_destroy();
    modeloPeliDB::closeDB();
    header('Location:index.php');
}

/*
 * Muestro la tabla con los usuario 
 */ 
function ctlPeliVerPelis (){
    // Obtengo los datos del modelo
    $peliculas = ModeloPeliDB::GetAll(); 
    // Invoco la vista 
    include_once 'plantilla/verpeliculas.php';
   
}