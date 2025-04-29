<!--Aquí estan practicamente todas las funciones que ayudan a crear y listar los eventos en las diferentes partes-->
<?php
require ('dbEvent.php');
require ('Eventos.php');

//Esta función comprueba los datos recogidos por el POST para enviarlos a la función crearEvento.
function comprobarEventos(){
    
    if(isset ($_POST["crearEvento"]))
    {
        $nombre = $_POST ["nomevent"];
        $categoria = $_POST ["categoria"];
        $fecha =  $_POST ["fecha"];
        $localizacion = $_POST ["localizacion"];
        $entrada = $_POST ["entrada"];
        $descripcion = $_POST["descripcion"];

        $nombreImg = $_FILES["imagen"]["name"];
        $archivo = $_FILES["imagen"]["tmp_name"];
        $ruta = "Imagenes/".$nombreImg;

        move_uploaded_file($archivo, $ruta);

        $usuario = $_SESSION["usuario"]["nombre"];


        $nuevoEvento = new Evento ($nombre, $categoria, $fecha, $localizacion, $entrada, $descripcion, $ruta, $usuario);
        crearEvento($nuevoEvento);

        
    }
}

//Esta función es para crear los eventos haciendo el query a la base de datos.
function crearEvento($evento){
    
    global $conexion;
 
        
        $consulta = "INSERT INTO eventos (nomevent, categoria, fecha, localizacion, entrada, descripcion, imagen, usuario)
                     VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $conexion -> prepare ($consulta);
        $stmt -> bind_param('ssssssss',$evento -> nomevent,
                                      $evento -> categoria, 
                                      $evento -> fecha,
                                      $evento -> localizacion,
                                      $evento -> entrada,
                                      $evento -> descripcion,
                                      $evento -> imagen,
                                      $evento -> usuario
                                      );
        $stmt -> execute();

}


//Esta funcion es la funcion comprobarEventos y crearEvento fusionadas. Queda aquí por si surgiese algún fallo.
/*
function crearEvento(){
    
    global $conexion;

    if(isset ($_POST["crearEvento"]))
    {
        $nombre = $_POST ["nomevent"];
        $categoria = $_POST ["categoria"];
        $fecha =  $_POST ["fecha"];
        $localizacion = $_POST ["localizacion"];
        $entrada = $_POST ["entrada"];
        $descripcion = $_POST["descripcion"];

        $nombreImg = $_FILES["imagen"]["name"];
        $archivo = $_FILES["imagen"]["tmp_name"];
        $ruta = "Imagenes/".$nombreImg;

        move_uploaded_file($archivo, $ruta);

        $usuario = $_SESSION["usuario"]["nombre"];

        $consulta = "INSERT INTO eventos (nomevent, categoria, fecha, localizacion, entrada, descripcion, imagen, usuario)
                     VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $conexion -> prepare ($consulta);
        $stmt -> bind_param('ssssssss', $nombre, $categoria, $fecha, $localizacion, $entrada, $descripcion, $ruta, $usuario);
        $stmt -> execute();
     }
}
*/

//Esta función es para imprimir los eventos.
function listarEventos (){
 
    global $conexion;

    $consulta = "SELECT * FROM eventos ORDER BY id DESC";

    $resultado = mysqli_query($conexion, $consulta);

    $eventos = array();
    
    if ($resultado){
        while ($fila = mysqli_fetch_assoc($resultado))
        {
           $nuevoEvento = new Evento ($fila ["nomevent"], $fila ["categoria"], $fila ["fecha"],$fila ["localizacion"], $fila ["entrada"], $fila ["descripcion"],
            $fila["imagen"], $fila ["usuario"]);
           array_push ($eventos, $nuevoEvento);
        }
        return $eventos;
    }
    
    else
    {
        echo $conexion -> error;
    }
    $conexion -> close();
}
//Esta función queda sin ser utilizada de momento.
function listarEventosPerfil(){
    /*Hay un fallo que causa que si se imprime mas variables de las que hay en el constructor, la imagen u otra variable no cargarán.*/
    
    global $conexion;

    $user = $_SESSION["usuario"]["nombre"];

    $consulta = "SELECT * FROM eventos WHERE usuario = '".$user."'";
    
    $resultado = mysqli_query($conexion, $consulta);

    $eventos = array();

    if ($resultado){
        
        while ($fila = mysqli_fetch_assoc($resultado))
        {
           $nuevoEvento = new Evento ($fila ["nomevent"], $fila ["categoria"], $fila ["fecha"],$fila ["localizacion"], $fila ["entrada"], $fila ["descripcion"]
           , $fila ["usuario"]);
           array_push ($eventos, $nuevoEvento);
        }
        return $eventos;
    }

    else
    {
        echo $conexion -> error;
    }
    $conexion -> close();
}
//Esta función lista en tu perfil los eventos a los que estás unido.
function listarEventosUnidos(){
    
    global $conexion;

    $id_user = $_SESSION ["usuario"]["usuario_id"];

    $consulta = "SELECT * FROM eventos INNER JOIN join_event ON eventos.id = join_event.id_evento WHERE id_usuario = $id_user";

    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado) {
        
        $eventosUnidos = mysqli_fetch_all($resultado, MYSQLI_ASSOC);

        return $eventosUnidos;
    }
    

    
}
//Esta función sirve para imprimir los ultimos 8 eventos y mostrarlos en la pagina principal.
function ListarUltimosEventos(){
    
    global $conexion;

    $consulta = "SELECT * FROM eventos ORDER BY id DESC LIMIT 6";
    $resultado = mysqli_query($conexion, $consulta);

    $eventos = array();
    
    if ($resultado) {
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $nuevoEvento = new Evento($fila["nomevent"], $fila["categoria"], $fila["fecha"], $fila["localizacion"], $fila["entrada"], $fila["descripcion"], $fila["imagen"], $fila["usuario"]);
            array_push($eventos, $nuevoEvento);
        }
        return $eventos;
    } else {
        echo $conexion->error;
    }
    $conexion->close();

}
//Esta función sirve para imprimir los 8 eventos que mas personas tenga.
function ListarEventosDestacados(){
    
    global $conexion;

    $consulta = "SELECT * FROM eventos INNER JOIN join_event ON eventos.id = join_event.id_evento WHERE join_action = 'unirse' GROUP BY id_evento DESC 
    HAVING COUNT(*) > 2 LIMIT 8 ";
    //"SELECT * FROM eventos ORDER BY id DESC LIMIT 8";
    $resultado = mysqli_query($conexion, $consulta);

    $eventos = array();
    
    if ($resultado){
        while ($fila = mysqli_fetch_assoc($resultado))
        {
           $nuevoEvento = new Evento ($fila ["nomevent"], $fila ["categoria"], $fila ["fecha"],$fila ["localizacion"], $fila ["entrada"], $fila ["descripcion"],
            $fila["imagen"], $fila ["usuario"]);
           array_push ($eventos, $nuevoEvento);
        }
        return $eventos;
    }
    
    else
    {
        echo $conexion -> error;
    }
    $conexion -> close();

}
//Esta funcion queda sin utilizarse, dado que se usa desde otra parte.
function eliminarEventosPerfil(){
    
    global $conexion;

    $id = $_GET['id'];

    $consulta = "DELETE FROM eventos WHERE id = ? ";
        $stmt =$conexion -> prepare ($consulta);
        $stmt -> bind_param ('d', $id);
        $resultado = $stmt -> execute(); 

    if ($resultado)
    {
        header("Location: PaginaPerfil.php ");
    }
    else
    {
        echo "No se eliminó";
    }

}