<!--Este archivo recoge los datos de usuario y los imprime en su perfil, así como sus eventos y poder borrarlos-->

<?php
require ('dbEvent.php');
require ('usuarios.php');
require ('FuncionesEventos.php');
?>
<?php
session_start();

comprobarUsuarios();

error_reporting(0);
?>
<?php
$tuPerfil = obtenerDatosPerfil();
$EventosJoin = listarEventosUnidos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Proyect Event</title>
    <link href="CSS/EstilosPerfil.css" rel="stylesheet" type="text/css">
    <script src="Script/script.js"></script>
</head>
<body>
    <div class="cabezera"> <!--Este bloque ocupa todo el menu de cabecera.-->
        <div class="logoCont">
            <a href="PaginaPrincipal.php"><img src="imagenes_proyecto/logo_negro.png" class="logo"></a>
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
                            <li><a href= "Logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </div>
        </div>    
    </div>

    <div id="cajaGlobal">

        <div id="cabezeraPerfil"><!--Este bloque de código se usa para imprimir los datos de perfil de usuario.-->
            <?php
                foreach ($tuPerfil as $perfil): ?>

            <div id="datosPerfil"> 
                <div id="fotoGrande"><img src="imagenes_proyecto/IconoUsuario3.png" alt=""></div>
                    <div id="datos">
                        <p class="p1">Nombre: </p></n><p><?php echo $perfil -> nombre ?></p></n>
                        <p class="p1">Correo: </p></n><p><?php echo $perfil -> correo ?></p></n>
                        <p class="p1">Fecha de ingreso: </p> <p> <?php echo $perfil -> fecha ?></p>
                    
                    </div>
            </div>
            <?php endforeach; ?>
            
        </div>
        

        <div class="carrusel">
            <div class="botonCambiar">
                <button class="btnEventos activo">Eventos Creados</button>
                <button class="btnEventos">Eventos a los que te unes</button>
             </div>
            <div class="grande">
                <div class="destacados"> <!--A partir de aquí los eventos se imprimen de esta forma para hacer funcionar la parte de eliminar evento-->
                        <?php

                        global $conexion;

                        $user = $_SESSION["usuario"]["nombre"];
                    
                        $consulta = "SELECT * FROM eventos WHERE usuario = '".$user."'";
                        
                        $resultado = mysqli_query($conexion, $consulta);

                        if ($resultado){
                            
                            while ($fila = mysqli_fetch_assoc($resultado))
                            {
                                ?>
                                <button class="acordeonPerfil">
                                    <!--#Id <?php echo $fila["id"]?>-->
                                        &nbsp; &nbsp;&nbsp;
                                    <?php echo $fila["nomevent"]?>
                                </button>
                                <div class="eventosPerfil">
                                    
                                    <div class="infoPerfil">
                                        <p>Categoría</p> 
                                            <p><?php echo $fila["categoria"]?></p></br>
                                        <p>Fecha</p> 
                                            <p><?php echo $fila["fecha"]?></p></br>
                                        <p>Lugar</p> 
                                            <p><?php echo $fila["localizacion"]?></p></br>
                                        <p>Precio</p>
                                            <p><?php echo $fila["entrada"]?></p> </br>
                                        <p>Descripción</p> 
                                            <p><?php echo $fila["descripcion"]?></p></br>
                                        <p>Creado por:</p>
                                            <p><?php echo $fila["usuario"]?></p>
                                    </div>
                                    <div class="imgPerfil">
                                        <img class="imagenes" src="<?php echo $fila["imagen"] ?>"/>
                                    </div>
                                <!--Esta linea es para capturar la id y borrar el evento-->
                                    <div id="btnBorrar"><?php echo  "<a href=eliminarEvento.php?id=". $fila['id'].">Borrar Evento</a>"; ?></div> 

                                </div>
                            <?php
                            }  
                        }
                        $conexion -> close();
                        ?>    
                </div>
                <div class="destacados">
                    <?php
                        foreach ($EventosJoin as $eventojoin): ?>
                            <button class="acordeonPerfil">
                                <?php echo $eventojoin["nomevent"]?>       
                            </button>
                                    <div class="eventosPerfil">
                                        
                                        <div class="infoPerfil">
                                            <p>Categoría</p>
                                                <p><?php echo $eventojoin['categoria'] ?></p> <br>
                                            <p>Fecha</p>
                                                <p><?php echo $eventojoin['fecha'] ?></p> <br>
                                            <p>Lugar</p>
                                                <p><?php echo $eventojoin['localizacion'] ?></p> <br>
                                            <p>Precio</p>
                                                <p><?php echo $eventojoin['entrada'] ?></p> <br>
                                            <p>Descripción</p>
                                                <p><?php echo $eventojoin['descripcion'] ?></p> <br>
                                            <p>Creado por:</p>
                                            <p><?php echo $eventojoin['usuario'] ?></p> </br>

                                        </div>
                                        <div class="imgPerfil">
                                            <img class="imagenes" src="<?php echo $eventojoin["imagen"] ?>"/>
                                        </div>
                                        <div id="btnBorrar"><?php echo  "<a href=abandonarEvento.php?id=". $eventojoin['id'].">Abandonar Evento</a>"; ?></div> 
                                    </div>
                            
            
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
    <footer>
        <div class = "parrafos">
             <p>Copyright @ 2023 Proyect Event</p>
             <p>Siguenos en:</p>
             <img src="imagenes_proyecto/redes.png" alt="">
        </div>
    </footer>
<script>
    acordeon();
    acordeonEventos();
    CarruselPerfil();
</script>
   
</body>    
</html>