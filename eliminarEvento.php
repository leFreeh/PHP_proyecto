<!--Esta función esta a parte por problemas con el código. Sirve para borrar los eventos desde PaginaPerfil.php-->
<?php
require ('dbEvent.php');

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
?>