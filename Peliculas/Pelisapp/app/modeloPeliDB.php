<?php

include_once 'config.php';
include_once 'Pelicula.php';

class ModeloPeliDB {

     private static $dbh = null; 
     private static $consulta_peli = "Select * from peliculas where codigo_pelicula = ?";

     private static $borrarpeli = "delete from peliculas where codigo_pelicula = ?";


     private static $add_peli = "insert into peliculas (nombre,director,genero,imagen) "."Values (?,?,?,?)";
  /*
     private static $delete_peli   = "Delete from Usuarios where id = ?"; 
     private static $insert_user   = "Insert into Usuarios (id,clave,nombre,email,plan,estado)".
                                     " VALUES (?,?,?,?,?,?)";
     private static $update_user    = "UPDATE Usuarios set  clave=?, nombre =?, ".
                                     "email=?, plan=?, estado=? where id =?";
 */    
     
public static function init(){
   
    if (self::$dbh == null){
        try {
            // Cambiar  los valores de las constantes en config.php
            $dsn = "mysql:host=".DBSERVER.";dbname=".DBNAME.";charset=utf8";
            self::$dbh = new PDO($dsn,DBUSER,DBPASSWORD);
            // Si se produce un error se genera una excepción;
            self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexión ".$e->getMessage();
            exit();
        }
        
    }
    
}



// Borrar pelicula (boolean)
public static function PeliDel($codigo_pelicula){
    $stmt = self::$dbh->prepare(self::$borrarpeli);
    $stmt->bindValue(1,$codigo_pelicula);
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        return true;
    }
    return false;
}

// Añadir una nueva pelicula (boolean)
public static function PeliAdd($nombre, $director, $genero, $imagen):bool{
    $stmt = self::$dbh->prepare(self::$add_peli);
    $stmt->bindValue(1,$nombre);
    $stmt->bindValue(2,$director);
    $stmt->bindValue(3,$genero);
    $stmt->bindValue(4,$imagen);
    if ($stmt->execute()){
       return true;
    }
    return false; 
}

/*
// Actualizar un nuevo usuario (boolean)
// GUARDAR LA CLAVE CIFRADA
public static function UserUpdate ($userid, $userdat){
    $clave = $userdat[0];
    // Si no tiene valor la cambio
    if ($clave == ""){ 
        $stmt = self::$dbh->prepare(self::$update_usernopw);
        $stmt->bindValue(1,$userdat[1] );
        $stmt->bindValue(2,$userdat[2] );
        $stmt->bindValue(3,$userdat[3] );
        $stmt->bindValue(4,$userdat[4] );
        $stmt->bindValue(5,$userid);
        if ($stmt->execute ()){
            return true;
        }
    } else {
        $clave = Cifrador::cifrar($clave);
        $stmt = self::$dbh->prepare(self::$update_user);
        $stmt->bindValue(1,$clave );
        $stmt->bindValue(2,$userdat[1] );
        $stmt->bindValue(3,$userdat[2] );
        $stmt->bindValue(4,$userdat[3] );
        $stmt->bindValue(5,$userdat[4] );
        $stmt->bindValue(6,$userid);
        if ($stmt->execute ()){
            return true;
        }
    }
    return false; 
}
*/

// Tabla de objetos con todas las peliculas
public static function GetAll ():array{
    // Genero los datos para la vista que no muestra la contraseña
    
    $stmt = self::$dbh->query("select * from peliculas");
    
    $tpelis = [];
    $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
    while ( $peli = $stmt->fetch()){
        $tpelis[] = $peli;       
    }
    return $tpelis;
}


// CRreamos nuestra funcion de detalles
public static function PeliDetalles($codigo_pelicula)
{
    $datosuser=[];
    $stmt= self::$dbh->prepare(self::$consulta_peli);
    $stmt-> bindValue(1,$codigo_pelicula);
    $stmt->execute();
        if($stmt->rowCount() > 0){
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'Pelicula');
            $peliobjeto = $stmt->fetch();
            $datospelicula = [
                $peliobjeto->nombre,
                $peliobjeto->director,
                $peliobjeto->genero,
                $peliobjeto->imagen
            ];
        return $datospelicula;
        }

        return null;

}


// Datos de una película para visualizar
public static function UserGet ($codigo){
    $datospelicula = [];
   // $consulta_user= 'SELECT * FROM peliculas WHERE codigo_pelicula=$codigo';
   $stmt = self::$dbh->query("select * from peliculas where codigo_pelicula=$codigo");
    $stmt->bindValue(1,$codigo);
    
    $stmt->execute();
    if ($stmt->rowCount() > 0 ){
        // Obtengo un objeto de tipo Usuario, pero devuelvo una tabla
        // Para no tener que modificar el controlador
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
        $uobj = $stmt->fetch();
        $datospelicula = [ 
                     $uobj->codigo_pelicula,
                     $uobj->nombre,
                     $uobj->director,
                     $uobj->genero
                     ];
        return $datospelicula;
    }
    return null;    
    
}

public static function closeDB(){
    self::$dbh = null;
}

} // class
