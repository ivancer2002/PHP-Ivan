<?php
//Aqui voy a crear un formulario para poder agregar una pelicula
ob_start();

?>
<div id="aviso"><b><?= (isset($msg))?$msg:"" ?></b></div>
<form name="darAlta" method="POST" action="index.php?orden=Alta">
Nombre : <input type="text" name="nombre" value=""><br>
Director : <input type="text" name="director" value=""><br>
Genero : <input type="text" name="genero" value=""><br>
Imagen : <input type="text" name="imagen" value=""><br>
<input type="submit" value="Agregar">
<input type="cancel" value="Cancelar" size="5" onclick="javascript:window.location='index.php'">
</form>
<?php
$contenido = ob_get_clean();
include_once "principal.php";

?>