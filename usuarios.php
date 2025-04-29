<!--Este archivo recoge todas las funciones empleadas que tengan que ver con los usuarios-->
<?php

include ('dbEvent.php');
include ('Perfil.php');

//Esta función comprueba si hay un usuario conectado. Y si lo hay, guarda sus datos en una COOKIE.
function comprobarUsuarios(){
   if (!isset ($_SESSION["usuario"]) && isset ($_COOKIE["cookie_usuario"])){
        $_SESSION["usuario"] = obtenerUsuarioPorId($_COOKIE["cookie_usuario"]);
   }
}
//Aquí obtenemos los datos de usuario por su ID.
function obtenerUsuarioPorId($id){
    global $conexion;
    $consulta = "SELECT usuario_id, nombre, correo FROM usuarios WHERE id = ?";
    $stmt = $conexion -> prepare ($consulta);
    $stmt -> bind_param('s', $id);
    $stmt -> execute();
    $resultado = $stmt -> get_result();
    
    if ($resultado)
    {
        $usuario_db = mysqli_fetch_assoc($resultado);
        return $usuario_db;
    }
}
function obtenerUsuario($nombreUsuario, $contraseña){
    global $conexion;
    $consulta = "SELECT usuario_id, nombre, correo FROM usuarios WHERE correo = ? AND contraseña = ?";
    $stmt = $conexion -> prepare ($consulta);
    $stmt -> bind_param('ss', $nombreUsuario, $contraseña);
    $stmt -> execute();
    $resultado = $stmt -> get_result();
    
    if ($resultado)
    {
        $usuario_db = mysqli_fetch_assoc($resultado);
        return $usuario_db;
    }
}
//Esta función es usada para comprobar si el ID de usuario es igual al de la base de datos y poder entrar al perfil.
function Entrar($usuario){
      $id_usuario = $usuario["usuario_id"];
      $_SESSION ["usuario"] = $usuario;
      setcookie ('cookie_usuario', $id_usuario, time() - 3600, '/');
      header("Location: index.php"); //Cuidado con la ruta si se mueven los archivos de carpeta.
      exit();
}

//Aquí realizamos la query que usamos para registrar usuarios nuevos.
function crearUsuarios ($contraseña, $correo, $nombre){

    global $conexion;

    //Estoy intentando que recoga la fecha del pc y la guarde en la base de datos
    
    date_default_timezone_set('Europe/Madrid');
    $fecha_actual = date("Y-m-d");

    $consulta = "INSERT INTO usuarios (contraseña, correo, nombre, fecha)
                 VALUES ('$contraseña', '$correo', '$nombre', '$fecha_actual')";
    $resultado = mysqli_query($conexion, $consulta);
    if ($resultado){
        echo '<script language="javascript">alert("El usuario ha sido creado correctamente");window.location.href="index.php"</script>';
        return obtenerUsuario($nombre, $contraseña);
    }
    else{
        echo '<script language="javascript">alert("El usuario no se ha podido crear");window.location.href="index.php"</script>';
        echo $conexion -> error;
        return false;
    }
}

//Esta función es empleada para imprimir los datos de usuario en su perfil.
function obtenerDatosPerfil(){
    
    global $conexion;

    $user = $_SESSION["usuario"]["usuario_id"]; //He cambiado el nombre por la id.

    $consulta = "SELECT correo, nombre, fecha FROM usuarios WHERE usuario_id = '".$user."'";
    
    $resultado = mysqli_query($conexion, $consulta);

    $perfil = array();

    if ($resultado){
        
        while ($fila = mysqli_fetch_assoc($resultado))
        {
           $nuevoPerfil = new Perfil ($fila ["correo"], $fila ["nombre"], $fila ["fecha"]);
           array_push ($perfil, $nuevoPerfil);
        }
        return $perfil;
    }

    else
    {
        echo $conexion -> error;
    }

   
}
?>