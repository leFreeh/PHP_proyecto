<?php
// Parámetros de conexión
$host = 'containers-us-west-123.railway.app'; // Ejemplo de host (puede variar)
$db = 'railway'; // Nombre de la base de datos (lo proporciona Railway)
$user = 'root'; // Usuario de la base de datos
$pass = 'tu-contraseña'; // Contraseña de la base de datos (la proporciona Railway)
$port = 3306; // El puerto por defecto de MySQL

// Crear la conexión
$conexion = new mysqli($host, $user, $pass, $db, $port);

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

echo "Conexión exitosa a la base de datos.";
?>
