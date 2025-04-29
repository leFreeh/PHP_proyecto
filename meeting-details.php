<?php
require ('usuarios.php');
require ('FuncionesEventos.php');
?>

<?php
function obtenerDetallesEvento($id) {
    $servername = "localhost:3309";
    $username = "root";
    $password = null;
    $dbname = "event";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Error" . $conn->connect_error);
    }

    $sql = "SELECT * FROM eventos WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $detalleEvento = $result->fetch_assoc();
        return $detalleEvento;
    } else {
        return false;
    }

    $conn->close();
}
?>

<?php
session_start();
comprobarUsuarios();
error_reporting(0);
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

    <title>Detalle del evento</title>

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

  <!-- ***** Header Area Start ***** -->
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
          <h6>Get all details</h6>
          <h2>Online Teaching and Learning Tools</h2>
        </div>
      </div>
    </div>
  </section>

  <section class="meetings-page" id="meetings">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
      <?php

    $id = $_GET['id'];

    $detalleEvento = obtenerDetallesEvento($id);

    if ($detalleEvento) {

        $entrada = $detalleEvento['entrada'];
        $fecha = $detalleEvento['fecha'];
        $nombreEvento = $detalleEvento['nomevent'];
        $descripcion = $detalleEvento['descripcion'];
        $categoria = $detalleEvento['categoria'];
        $localizacion = $detalleEvento['localizacion'];
        $usuario = $detalleEvento['usuario'];
        $imagen = $detalleEvento['imagen'];
        $direccion = $detalleEvento['direccion'];
        $mes = date('F', strtotime($fecha));
        $dia = date('d', strtotime($fecha));
        ?>
          <div class="row">
            <div class="col-lg-12">
              <div class="meeting-single-item">
                <div class="thumb">
                  <div class="price">
                    <span><?php echo $entrada; ?></span>
                  </div>
                  <div class="date">
                    <h6><?php echo $mes; ?> <span><?php echo $dia; ?></span></h6>
                  </div>
                  <a><img src="<?php echo $imagen; ?>" alt=""></a>
                </div>
                <div class="down-content">
                  <a href="meeting-details.html"><h4><?php echo $nombreEvento; ?></h4></a>
                  <p><?php echo $localizacion; ?></p>
                  <p class="description">
                    <?php echo $descripcion; ?>
                  </p>
                  <div class="row">
                    <div class="col-lg-4">
                      <div class="hours">
                        <h5>Categoría</h5>
                        <p><?php echo $categoria; ?></p>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="location">
                        <h5>Dirección</h5>
                        <p><?php echo $localizacion; ?></p>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="book now">
                        <h5>Usuario</h5>
                        <p><?php echo $usuario; ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="main-button-red">
                <a href="meetings.php">Regresar a la lista de eventos</a>
              </div>
            </div>
          </div>
        <?php
        } else {
          echo "El evento no existe.";
        }
        ?>
      </div>
    </div>
  </div>
  <div class="footer">
    <p>Copyright @ 2023 Proyect Event.
        <br>Siguenos en: 
        <a href="https://twitter.com/" target="_parent" title="free css templates"><i class="fa fa-twitter"></i></a>
        <a href="https://fb.com/" target="_parent" title="free css templates"><i class="fa fa-facebook"></i></a>
        <a href="https://instagram.com/" target="_parent" title="free css templates"><i class="fa fa-instagram"></i></a>
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


  </body>

</html>
