<!--Esto es el archivo de conexión a la base de datos. En caso de querer usarla en otro lugar debes comprobar que el nombre y la contraseña son iguales.
En caso contrario, cambiad el nombre "root" por el que corresponda, y la contraseña null por la que corresponda entre comillas ""-->
<?php

$conexion = @mysqli_connect("localhost:3309", "root", null, "event");

if (!$conexion)
{
    die ("Error de conexión");
}
?>