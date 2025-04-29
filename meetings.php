<!--Esta es la página donde se listan todos los eventos creados.-->

<?php
require ('dbEvent.php');
require ('FuncionesEventos.php');
require ('usuarios.php');
require ('unirseEvento.php');
?>

<?php
session_start();
comprobarUsuarios();
error_reporting(0);

?>
<?php

$listado_db = listarEventos();

?>

<!--Necesitamos todo este bloque para poder iniciar sesión desde esta página-->
<?php
session_start();
$id_user = $_SESSION ["usuario"]["usuario_id"]; /*Esto es nuevo, es una variable goblal*/
$usuario = $_SESSION ["usuario"]["nombre"]; /*Esto es nuevo, la variable se utiliza en el bloque de iniciar sesión*/

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
        
        echo '<script language="javascript">alert("El usuario o contraseña no son correctos");window.location.href="meetings.php"</script>';
        
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

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Template Mo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>Proyecto DAW</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-edu-meeting.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/lightbox.css">
<!--

TemplateMo 569 Edu Meeting

https://templatemo.com/tm-569-edu-meeting

-->
  </head>

<body>

<header class="header-area header-sticky">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="main-nav">
                      <!-- ***** Logo Start ***** -->
                      <a href="index.php" class="logo">
                          Proyect Event
                      </a>
                      <!-- ***** Logo End ***** -->
                      <!-- ***** Menu Start ***** -->
                      <ul class="nav">
                        <li class="has-sub">
                          <a href="javascript:void(0)">Usuario</a>
                          <ul class="sub-menu">
                            <li>
                              <a id="popup" onclick="showModal('modal')">Iniciar Sesión</a>
                            </li>
                            <?php if ($usuario): ?>
                              <li>
                                <a href="Listaeventos.php"><?php echo $usuario ?></a>
                              </li>
                              <li>
                                <a href="Logout.php">Cerrar Sesión</a>
                              </li>
                            <?php endif; ?>
                          </ul>
                        </li>
                        <li><a href='verificarSesion.php'>Crear Evento</a></li> 
                      </ul>
                      <a class='menu-trigger'>
                          <span>Menu</span>
                      </a>
                  </nav>

<dialog id="modal">
  <button class="popup-close" onclick="closeModal('modal')">&times;</button>
  <h1>Iniciar Sesión</h1>
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
      <input type="submit" name="Entrar" value="Iniciar Sesión" class="button">
    </form> 
  </div>
  <br>
  <p>Bienvenido a Proyect Event</p>
  <br>
  <p>¿No tienes una cuenta? <button onclick="showModal('modal2')">Regístrate</button></p>
</dialog>

<dialog id="modal2">
  <button class="popup-close" onclick="closeModal('modal2')">&times;</button>
  <h1>Regístrate</h1>
  <div class="contenedor">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  
      <div class="input-contenedor">
        <i class="fas fa-user icon"></i>
        <input type="text" name="nombre" placeholder="Nombre Completo">
      </div>
      <div class="input-contenedor">
        <i class="fas fa-envelope icon"></i>
        <input type="text" name="correo" placeholder="Correo Electrónico">
      </div>
      <div class="input-contenedor">
        <i class="fas fa-key icon"></i>
        <input type="password" name="contraseña" placeholder="Contraseña"> 
      </div>
      <input type="submit" name="CrearCuenta" value="Regístrate" class="button">   
    </form>  
  </div>
  <br>
  <p>Al registrarte, aceptas nuestras Condiciones de uso y Política de privacidad.</p>
</dialog>

  </header>
  <!-- ***** Header Area End ***** -->

  <section class="heading-page header-text" id="top">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h6>Busca tu evento</h6>
          <h2>Proximos</h2>
        </div>
      </div>
    </div>
  </section>

  <section class="meetings-page" id="meetings">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-12">
            <div class="filters">
              <ul>
                <li data-filter="*" class="active">Todos</li>
                <li data-filter=".deportes">Deportes</li>
                <li data-filter=".conciertos">Conciertos</li>
                <li data-filter=".viajes">Viajes</li>
                <li data-filter=".competiciones">Competiciones</li>
                <li data-filter=".motor">Motor</li>
                <li data-filter=".cultura">Cultura</li>
                <li data-filter=".otros">Otros</li>
              </ul>
            </div>
            </div>
            <div class="col-lg-12">
              <div class="row grid">
                <?php foreach ($eventos as $evento): ?>
                  <div class="col-lg-4 templatemo-item-col all <?php echo $evento['categoria'] ?>">
                    <div class="meeting-item">
                      <div class="thumb">
                        <div class="price">
                          <span><?php echo $evento['entrada'] ?></span>
                        </div>
                        <a href="meeting-details.php?id=<?php echo $evento['id'] ?>"><img src="<?php echo $evento['imagen'] ?>" alt=""></a>
                      </div>
                      <div class="down-content">
                        <div class="date">
                          <?php
                            $fecha = new DateTime($evento['fecha']);
                            $mes = $fecha->format('M');
                            $dia = $fecha->format('d');
                          ?>
                          <h6><?php echo $mes ?> <span><?php echo $dia ?></span></h6>
                        </div>
                        <a href="meeting-details.php?id=<?php echo $evento['id'] ?>"><h4><?php echo $evento['nomevent'] ?></h4></a>
                        <p><?php echo $evento['descripcion'] ?></p>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer">
      <p>Copyright @ 2023 Proyect Event.
          <br>Siguenos en: 
          <a href="https://twitter.com" target="_parent" title="free css templates"><i class="fa fa-twitter"></i></a>
          <a href="https://fb.com" target="_parent" title="free css templates"><i class="fa fa-facebook"></i></a>
          <a href="https://instagram.com" target="_parent" title="free css templates"><i class="fa fa-instagram"></i></a>
      </p>
    </div>
  </section>


  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/isotope.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="assets/js/tabs.js"></script>
    <script src="assets/js/isotope.js"></script>
    <script src="assets/js/video.js"></script>
    <script src="assets/js/slick-slider.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        //according to loftblog tut
        $('.nav li:first').addClass('active');

        var showSection = function showSection(section, isAnimate) {
          var
          direction = section.replace(/#/, ''),
          reqSection = $('.section').filter('[data-section="' + direction + '"]'),
          reqSectionPos = reqSection.offset().top - 0;

          if (isAnimate) {
            $('body, html').animate({
              scrollTop: reqSectionPos },
            800);
          } else {
            $('body, html').scrollTop(reqSectionPos);
          }

        };

        var checkSection = function checkSection() {
          $('.section').each(function () {
            var
            $this = $(this),
            topEdge = $this.offset().top - 80,
            bottomEdge = topEdge + $this.height(),
            wScroll = $(window).scrollTop();
            if (topEdge < wScroll && bottomEdge > wScroll) {
              var
              currentId = $this.data('section'),
              reqLink = $('a').filter('[href*=\\#' + currentId + ']');
              reqLink.closest('li').addClass('active').
              siblings().removeClass('active');
            }
          });
        };

        $('.main-menu, .responsive-menu, .scroll-to-section').on('click', 'a', function (e) {
          e.preventDefault();
          showSection($(this).attr('href'), true);
        });

        $(window).scroll(function () {
          checkSection();
        });
    </script>

<script>
  function showModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.showModal();
    
    if (modalId === 'modal2') {
      var modal1 = document.getElementById('modal');
      modal1.close();
    }
  }

  function closeModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.close();

    if (modalId === 'modal2') {
      var modal1 = document.getElementById('modal');
      modal1.close();
    }
  }
</script>
</body>
</html>
