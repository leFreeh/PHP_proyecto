<?php
// Obtener la URL de conexión desde la variable de entorno
$mysql_url = getenv('MYSQL_URL');

// Parsear la URL para obtener los componentes de la conexión
$parsed_url = parse_url($mysql_url);

// Parámetros de conexión
$host = $parsed_url['host'];
$port = $parsed_url['port'];
$user = $parsed_url['user'];
$pass = $parsed_url['pass'];
$db = ltrim($parsed_url['path'], '/'); // Eliminamos la barra inicial del nombre de la base de datos

// Crear la conexión
$conexion = new mysqli($host, $user, $pass, $db, $port);

// Verificar si la conexión fue exitosa
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

echo "Conexión exitosa a la base de datos.";
?>
