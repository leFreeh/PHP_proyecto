<!--Esta es la página donde se listan todos los eventos creados.-->

<?php
require ('dbEvent.php');
require ('FuncionesEventos.php');
require ('usuarios.php');
require ('unirseEvento.php');
?>

<?php

comprobarUsuarios();
error_reporting(0);

?>
<?php

$listado_db = listarEventos();

?>

<!--Necesitamos todo este bloque para poder iniciar sesión desde esta página-->
<?php
session_start();

$error = "";

if (isset($_POST["Entrar"]))
{
    $usuario = obtenerUsuario($_POST["correo"], $_POST["contraseña"]);
    
    if ($usuario)
    {
        Entrar($usuario);
    }
    else
    {
        
        echo '<script language="javascript">alert("El usuario o contraseña no son correctos");window.location.href="Listaeventos.php"</script>';
        
    }
}
?>

<!-- Este pequeño bloque es para que el modal de Registro permita crear una cuenta-->
<?php
if (isset($_POST["CrearCuenta"]))
{
    if (strlen($_POST["contraseña"]) >= 1 && strlen($_POST["correo"]) >= 1 && strlen($_POST["nombre"]) >= 1 ){
        crearUsuarios($_POST["contraseña"], $_POST["correo"], $_POST["nombre"]);
    }  
}
?>


<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Proyect Event</title>
        <link href="CSS/EstilosPaginaEventos.css" rel="stylesheet" type="text/css">
        <link href="CSS/EstilosModales.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"> <!--Iconos de las barras-->
        <link rel="icon" href="icon.png">
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script src="Script/script.js"></script>
    </head>

<body>
    <div class="cabezera"> <!--Este bloque ocupa todo el menu de cabecera.-->
        <div class="logoCont">
            <a href="index.php"><img src="imagenes_proyecto/logo_negro.png" class="logo"></a>
        </div>
        <div class="btnCont">             
            <a class="btn2 tooltip" href = 'verificarSesion.php'> + 
            <span class="tooltip-down">Crear Evento</span>
            </a>
        </div>
        <div class="btnCont">

            <button class="btn1 acordeon"> <img src="imagenes_proyecto/IconoUsuario2.png" alt=""> </button> 

                    <div class="acordeonMenu">
                        <ul>
                            <li> <a id="popup">Iniciar Sesión </a> </li>

                            <li> <a href = "PaginaPerfil.php"> <?php echo $_SESSION ["usuario"]["nombre"]?></a></li>
                                            
                            <li><a href= "Logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </div>
        </div>    
    </div>

    <!-- Este bloque corresponde a los modales de inicio y registro -->
    <dialog id="modal" class="modal">
        <button class="btnclose" id="cancel" type="reset">&times;</button>
        <h1>Iniciar Sesion</h1>
        <div class="contenedor"> 
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">    
                <div class="input-contenedor">
                    <i class="fas fa-user icon"></i>
                    <input type="text" name="correo" placeholder="Correo">        
                </div>
                <div class="input-contenedor">
                    <i class="fas fa-key icon"></i>
                    <input type="password" name="contraseña" placeholder="Contraseña">       
                </div>     
                <input type="submit" name="Entrar" value="Iniciar Sesion" class="button">
            </form> 
        </div>
        <br>
        <p>Bienvenido a Proyect Event</p>
        <br>
        <p>¿No tienes una cuenta? <button id="popup2">Regístrate</button></p>
    </dialog>
    <dialog id="modal2" class="modal2">     
        <button class="btnclose" id="cancel2" type="reset">&times;</button>
        <h1>Registrate</h1>
        <div class="contenedor">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  
                <div class="input-contenedor">
                    <i class="fas fa-user icon"></i>
                    <input type="text" name="nombre" placeholder="Nombre Completo">
                </div>
                <div class="input-contenedor">
                    <i class="fas fa-envelope icon"></i>
                    <input type="text" name="correo" placeholder="Correo Electronico">
                </div>
                <div class="input-contenedor">
                    <i class="fas fa-key icon"></i>
                    <input type="password" name="contraseña" placeholder="Contraseña"> 
                </div>
                <input type="submit" name="CrearCuenta" value="Registrate" class="button">   
            </form>  
        </div>
        <br>
        <p>Al registrarte, aceptas nuestras Condiciones de uso y Política de privacidad.</p>
    </dialog>


        <!--Todo este bloque pertenece a la función de listar eventos.-->
        <div class="destacados">

            <h2>Únete y comparte eventos</h2>
            
                <?php foreach ($eventos as $evento):?>
                       
                        <div class = "eventos">

                            <img class="imagenes" src="<?php echo $evento['imagen'] ?>"/>
    
                             <p><?php echo $evento['nomevent'] ?></p> <br> 
                             
                            <!-- <p><?php echo $evento['categoria'] ?></p> <br> -->
                            
                             <p><?php echo $evento['fecha'] ?></p> <br>
                             
                             <p><?php echo $evento['localizacion'] ?></p> <br>
                             
                             <p><?php echo $evento['entrada'] ?></p> <br>
                             
                            <!-- <p><?php echo $evento['descripcion'] ?></p> <br> -->

                             <p><?php echo $evento['usuario'] ?></p> </br>
                            
                             <div class="cajaEventoUnirse">
                              
                                <!--<button class="btnUnirse">Unirse</button>-->
                                <!-- <div class="unirse-info"> -->
                                        <!-- Si el usuario pulsa el botón este cambia de aspecto -->
                                        <button <?php if (UsuarioUnido($evento['id'])): ?>
                                            class="uniendose btnU"
                                        <?php else:?>
                                            class="abandonando btnU"
                                        <?php endif ?>
                                        data-id="<?php echo $evento['id'] ?>">Unirse</button>
                                        &nbsp;
                                        <span class="unirse"><?php echo Union($evento['id']); ?></span>
                                <!-- </div> -->             
                             </div>
                             
                        </div>

                <?php endforeach; ?>
            
        </div>

        <!--Este es nuestro footer-->
        <footer>
            <div class = "parrafos">
                <p>Copyright @ 2023 Proyect Event</p>
                <p>Siguenos en:</p>
                <img src="imagenes_proyecto/redes.png" alt="">
            </div>
        </footer>
        
        <!--Aquí esta el script que usaremos para la función de unirse o votar eventos-->
        <script>
            cargar();
            modales();
            acordeon();
        </script>
        
    </body>
</html>