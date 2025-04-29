<!--Este archivo es una prueba temporal y no hace ninguna función de momento-->

<?php

//Se conecta a la base de datos.
require ('dbEvent.php');

error_reporting(0); //Ojo a esto, lo he puesto para que cuando no haya un usuario no imprima el error. Pero impide ver cualquier otro error que aparezca.

//Creamos una variable para que recoja al usuario conectado.

session_start(); //Necesitamos el session_start para saber que hay un usuario logueado. Sin esto da error y no funciona.

$id_user = $_SESSION ["usuario"]["usuario_id"];

global $conexion;

// Si el usuario hace click en el boton unirse...

//(ATENCION: Las variables en las sentencias llevan comillas simples, sin ellas la sentencia falla y con ella otras partes del código)

if (isset($_POST['action'])) {
  $evento_id = $_POST['id_evento'];
  $action = $_POST['action'];
  switch ($action) {
  	case 'unirse':
         $sql = "INSERT INTO join_event (id_evento, id_usuario, join_action) 
         	   VALUES ( $evento_id, $id_user, 'unirse') 
         	   ON DUPLICATE KEY UPDATE join_action='unirse'";
         break;
  	case 'abandonar':
	      $sql="DELETE FROM join_event WHERE id_usuario = $id_user AND id_evento = $evento_id";
	      break;
  	default:
  		break;
  }

  // ejecuta la query para realizar los cambios

  mysqli_query($conexion, $sql);
  echo ObtenerUnion($evento_id);
  exit(0);
}

// Obtiene el numero total de personas unidas en un evento

function Union($id)
{
  global $conexion;
  $sql = "SELECT COUNT(*) FROM join_event
  		  WHERE id_evento=$id AND join_action='unirse'";
  $rs = mysqli_query($conexion, $sql);
  $result = mysqli_fetch_array($rs);
  return $result[0];
}

// Obtiene el numero total de cuantos usuarios hay unidos a un evento

function ObtenerUnion($id)
{
  global $conexion;
  $rating = array();
  $consulta_uniones = "SELECT COUNT(*) FROM join_event WHERE id_evento=$id AND join_action='unirse'";

  $unirse_rs = mysqli_query($conexion, $consulta_uniones);

  $unirse = mysqli_fetch_array($unirse_rs);
 
  $rating = [
  	'unirse' => $unirse[0]
  ];
  return json_encode($rating);
}

// Informa de si un usuario se ha unido o no.

function UsuarioUnido($evento_id)
{
  global $conexion;
  global $id_user;
  $sql = "SELECT * FROM join_event WHERE id_usuario='".$id_user."' AND id_evento= $evento_id AND join_action='unirse'";
  $result = mysqli_query($conexion, $sql);
  if (mysqli_num_rows($result) > 0) {
  	return true;
  }else{
  	return false;
  }
}

//Vamos a realizar una nueva query aquí para evitar problemas futuros para la página Listaeventos.php

$sql = "SELECT * FROM eventos ORDER BY id DESC";
$result = mysqli_query($conexion, $sql);
$eventos = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>