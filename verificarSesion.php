<!--Esta archivo sirve para validar de forma sencilla que haya un usuario logueado. Si no lo hay te mandará al Login. Si estas conectado te dejará crear eventos-->

<?php
require ('usuarios.php');
session_start();

if (!isset ($_SESSION["usuario"])){
    echo '<script language="javascript">alert("Debes iniciar sesión para crear eventos.");window.location.href="index.php"</script>';
    exit();

}
else{
    header("Location: formEvento.php");
}
   
?> 