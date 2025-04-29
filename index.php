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
//Esta variable es para imprimir los ultimos eventos creados que se muestran en la página principal.
$list_Ultimos = ListarUltimosEventos();
//Esta imprime los que mas personas tenga unidas.
$list_Destacados = ListarEventosDestacados();
?>
<!--Este bloque hace que el usuario pueda iniciar sesión a través del modal.-->
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
        
        echo '<script language="javascript">alert("El usuario o contraseña no son correctos");window.location.href="index.php"</script>';
        
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
    <meta name="author" content="TemplateMo">
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
                                <a href="PaginaPerfil.php"><?php echo $usuario ?></a>
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

  <!-- ***** Main Banner Area Start ***** -->
  <section class="section main-banner" id="top" data-section="section1">
      <video autoplay muted loop id="bg-video">
          <source src="assets/images/course-video.mp4" type="video/mp4" />
      </video>

      <div class="video-overlay header-text">
          <div class="container">
            <div class="row">
              <div class="col-lg-12">
                <div class="caption">
              <h2>Bienvenidos</h2>
              <p>"Encuentra la emoción en cada evento: ¡Descubre y vive experiencias inolvidables en nuestra web!"</p>
          </div>
              </div>
            </div>
          </div>
      </div>
  </section>
  <!-- ***** Main Banner Area End ***** -->

  <section class="services">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-service-item owl-carousel">
          
            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-01.png" alt="">
              </div>
              <div class="down-content">
                <h4>Variedad de eventos</h4>
                <p>Ofrece una amplia gama de eventos para diferentes audiencias.</p>
              </div>
            </div>
            
            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-02.png" alt="">
              </div>
              <div class="down-content">
                <h4>Experiencia de usuario intuitiva</h4>
                <p>Diseña una interfaz sencilla y fácil de navegar.</p>
              </div>
            </div>
            
            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-03.png" alt="">
              </div>
              <div class="down-content">
                <h4>Información detallada y actualizada</h4>
                <p>Incluye información relevante y atractiva en las páginas de eventos.</p>
              </div>
            </div>
            
            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-02.png" alt="">
              </div>
              <div class="down-content">
                <h4>Funciones de búsqueda y filtrado</h4>
                <p>IProporciona descripciones y detalles actualizados de los eventos.</p>
              </div>
            </div>
            
            <div class="item">
              <div class="icon">
                <img src="assets/images/service-icon-03.png" alt="">
              </div>
              <div class="down-content">
                <h4>Crea tu evento con nosotros</h4>
                <p>Implementa herramientas de búsqueda avanzada y filtros.</p>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="upcoming-meetings" id="meetings">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading">
            <h2>Proximos Eventos</h2>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="categories">
            <h4>Categorias</h4>
            <ul>
              <li><a href="meetings.php?category=deportes">Deportes</a></li><br>
              <li><a href="meetings.php?category=conciertos">Conciertos</a></li><br>
              <li><a href="meetings.php?category=viajes">Viajes</a></li><br>
              <li><a href="meetings.php?category=competiciones">Competiciones</a></li><br>
              <li><a href="meetings.php?category=motor">Motor</a></li><br>
              <li><a href="meetings.php?category=cultura">Cultura</a></li><br>
              <li><a href="meetings.php?category=otros">Otros</a></li><br>
              <li><a href="meetings.php">Ver más</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-8">
          <div class="row">
            <?php foreach ($list_Ultimos as $evento): ?>
              <div class="col-lg-6">
                <div class="meeting-item">
                  <div class="thumb">
                    <a><img src="<?php echo $evento->imagen ?>" alt="Event Image"></a>
                  </div>
                  <div class="down-content">
                    <div class="date">
                      <?php
                            $fecha = new DateTime($evento->fecha);
                            $mes = $fecha->format('M');
                            $dia = $fecha->format('d');
                          ?>
                          <h6><?php echo $mes ?> <span><?php echo $dia ?></span></h6>
                    </div>
                    <a><h4><?php echo $evento->nomevent ?></h4></a>
                    <p><?php echo $evento->descripcion ?></p>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>


  <section class="our-courses" id="courses">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="section-heading">
            <h2>Eventos más destacados</h2>
          </div>
        </div>
        <div class="col-lg-12">
          <div class="owl-courses-item owl-carousel">
            <?php foreach ($list_Ultimos as $evento): ?>
              <div class="item">
                <img src="<?php echo $evento->imagen ?>" alt="Event Image">
                <div class="down-content">
                  <h4><?php echo $evento->nomevent ?></h4>
                  <div class="info">
                    <div class="row">
                      <div class="col-8">
                        <ul>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                          <li><i class="fa fa-star"></i></li>
                        </ul>
                      </div>
                      <div class="col-4">
                        <span><?php echo $evento->entrada ?></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>




  <section class="contact-us" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-9 align-self-center">
          <div class="row">
            <div class="col-lg-12">
              <form id="contact" action="" method="post">
                <div class="row">
                  <div class="col-lg-12">
                    <h2>Contacta con nosotros</h2>
                  </div>
                  <div class="col-lg-4">
                    <fieldset>
                      <input name="name" type="text" id="name" placeholder="Nombre..." required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-4">
                    <fieldset>
                    <input name="email" type="text" id="email" pattern="[^ @]*@[^ @]*" placeholder="Correo..." required="">
                  </fieldset>
                  </div>
                  <div class="col-lg-4">
                    <fieldset>
                      <input name="subject" type="text" id="subject" placeholder="Asunto..." required="">
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <textarea name="message" type="text" class="form-control" id="message" placeholder="Mensaje..." required=""></textarea>
                    </fieldset>
                  </div>
                  <div class="col-lg-12">
                    <fieldset>
                      <button type="submit" id="form-submit" class="button">Enviar mensaje</button>
                    </fieldset>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="right-info">
            <ul>
              <li>
                <h6>Número de telefono</h6>
                <span>673-020-0340</span>
              </li>
              <li>
                <h6>Correo de contacto</h6>
                <span>PEvent@ionos.com</span>
              </li>
              <li>
                <h6>Dirección</h6>
                <span>Prta del Sol, s/n, 28013 Madrid, España</span>
              </li>
            </ul>
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