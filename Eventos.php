<!--Es el contructor para los eventos que nos ayuda a imprimirlos y guardarlos de forma mas cómoda. Es necesario para el resto de funciones. NO BORRAR-->
<?php
class Evento{
    public $nomevent;
    public $categoria;
    public $fecha;
    public $localizacion;
    public $entrada;
    public $descripcion;
    public $imagen;
    public $usuario;
function __construct($nomevent, $categoria , $fecha, $localizacion, $entrada, $descripcion, $imagen, $usuario){
    $this -> nomevent = $nomevent;
    $this -> categoria = $categoria;
    $this -> fecha = $fecha;
    $this -> localizacion = $localizacion;
    $this -> entrada = $entrada;
    $this -> descripcion = $descripcion;
    $this -> imagen = $imagen;
    $this -> usuario = $usuario;

}
}


?>