<!--Esta función esta a parte por problemas con el código. Sirve para abandonar los eventos desde PaginaPerfil.php-->
<?php
require ('dbEvent.php');
session_start();

global $conexion;

    $id_user = $_SESSION ["usuario"]["usuario_id"];
    $id_evento = $_GET['id'];

    $consulta = "DELETE FROM join_event WHERE id_usuario = $id_user AND id_evento = $id_evento ";
        
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado)
    {
        header("Location: PaginaPerfil.php ");
    }
    else
    {
        echo "No se eliminó";
    }
?>