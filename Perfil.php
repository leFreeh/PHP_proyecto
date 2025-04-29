<!--Este es un constructor para poder imprimir los datos de perfil del usuario de forma mas cómoda. NO BORRAR-->
<?php
class Perfil{
    public $correo;
    public $nombre;
    public $fecha;
function __construct($correo, $nombre , $fecha){
    $this -> correo = $correo;
    $this -> nombre = $nombre;
    $this -> fecha = $fecha;
}
}


?>