<?php 

$MESES = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$servicios = array();
$productos = array();
$ultimasnoticias = array();

include_once("backend/ewcfg10.php");

$conn = mysqli_connect(EW_CONN_HOST, EW_CONN_USER, EW_CONN_PASS, EW_CONN_DB);

$sql = "SELECT * FROM servicios";

$resultado = mysqli_query($conn, $sql);

if ($resultado) {
  for ($i=0; $i < mysqli_num_rows($resultado); $i++) { 
    $registro = mysqli_fetch_assoc($resultado);
    $registro = array_map("utf8_encode", $registro);
    array_push($servicios, $registro);
  }
}

$sql = "SELECT * FROM productos";

$resultado = mysqli_query($conn, $sql);

if ($resultado) {
  for ($i=0; $i < mysqli_num_rows($resultado); $i++) { 
    $registro = mysqli_fetch_assoc($resultado);
    $registro = array_map("utf8_encode", $registro);
    array_push($productos, $registro);
  }
}


$sql = "SELECT * FROM noticias ORDER BY id DESC LIMIT 3";

$resultado = mysqli_query($conn, $sql);

if ($resultado) {

  for ($i=0; $i < mysqli_num_rows($resultado); $i++) { 
    $registro = mysqli_fetch_assoc($resultado);
    $registro = array_map("utf8_encode", $registro);
    array_push($ultimasnoticias, $registro);
  }
}


 ?>

<!DOCTYPE html>
<html lang="es">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Descubrí un nuevo concepto gráfico">
    <meta name="author" content="">

    <title>Maringraf</title>
    <link rel="icon" href="img/favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/full-slider.css" rel="stylesheet">

    <!-- Fontawesome -->
    <link href="vendor/fontawesome/css/all.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Work+Sans:100,200,300,400,500,600,700,800,900" rel="stylesheet">   

  </head>

  <body>

    <!-- Navigation -->
    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark fixed-top d-block">
      
      <div class="container">
        <div class="row w-100">
          <div class="p-0 col-12 text-right text-white">
            <ul class="fa-ul m-0">
              <li><span class=""><i class="fas fa-phone-square fa-flip-horizontal"></i></span>
                <a class="text-white" href="callto:011 4203 7770">011 4203 7770</a>
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="container">

        <a class="navbar-brand" href="#">
          <img src="img/logo_horizontal_200.png" alt="logo">
        </a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="#home">Home
                <span class="sr-only">(actual)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#quienes-somos">Quienes Somos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#servicios">Servicios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#productos">Productos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#noticias">Noticias</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contacto">Contacto</a>
            </li>            
          </ul>
        </div>

      </div>
    </nav>

    <!-- SLIDER -->

    <header id="home">

      <div id="slider-principal" class="carousel slide" data-ride="carousel">

        <ol class="carousel-indicators">

          <li data-target="#slider-principal" data-slide-to="0" class="active"></li>
          <li data-target="#slider-principal" data-slide-to="1"></li>
          <li data-target="#slider-principal" data-slide-to="2"></li>

        </ol>

        <div class="carousel-inner" role="listbox">

          <!-- Slide One - Set the background image for this slide in the line below -->
          <div class="carousel-item active" style="background-image: url('img/slide_2.png')">
            <div class="carousel-caption d-none d-md-block">
              <h3 class="display-2 bold">Gráfica y Diseño</h3>
              <p class="lead">Creación de diseños exclusivos.</p>
            </div>
          </div>

          <!-- Slide Two - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: url('img/slide_1.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h3 class="display-2 bold">Gigantografia y Carteleria</h3>
              <p class="lead">Diseño de gráfica, armado de simuladores y montado de todos los elementos en la sala gamer.</p>
            </div>
          </div>

          <!-- Slide Three - Set the background image for this slide in the line below -->
          <div class="carousel-item" style="background-image: url('img/slide_3.jpg')">
            <div class="carousel-caption d-none d-md-block">
              <h3 class="display-2 bold">Armado de Stands</h3>
              <p class="lead">Contamos con personal altamente capacitado.</p>
            </div>
          </div>
          
        </div>

        <a class="carousel-control-prev" href="#slider-principal" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Anterior</span>
        </a>

        <a class="carousel-control-next" href="#slider-principal" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Siguiente</span>
        </a>

      </div>
    </header>

    <!-- FIN SLIDER -->

    <!-- QUIENES SOMOS -->

    <section id="quienes-somos" class="bg-naranja">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
            <h2 class="cl-blanco display-3 bold">Quienes Somos</h2>
            <p class="cl-blanco mt-5 lead">Somos una empresa familiar con una trayectoria de 20 años en el mercado. Siempre a la vanguardia de las necesidades de nuestros clientes, incorporando maquinarias de última generación, distintos tipos de materiales y la creación de diseños exclusivos, con personal  altamente capacitado.</p>
          </div>
          <div class="col-md-4">
            <img width="100%" src="img/logo_cuadrado_500.png" alt="logo cuadrado">
          </div>
        </div>
      </div>
    </section>

    <!-- FIN QUIENES SOMOS -->

    <!-- SERVICIOS -->

    <section id="servicios">
      <div class="container">
        <h2 class="display-4 text-center bold">Servicios</h2>
        <p class="lead text-center">Estos son los servicios con los que contamos.</p>
        <div class="row">

          <?php 

            foreach ($servicios as $key => $value) {
              ?>
                <div class="col-lg-4 col-md-6 cuadricula">
                  <div class="inner-cuadricula" style="background-image:url('backend/upload/<?php echo $value["imagen"] ?>')">
                    <div class="contenido-cuadricula text-center">
                      <h3 class="cl-blanco text-center display-5"><?php echo $value["titulo"] ?></h3>
                      <p class="cl-blanco text-center"><?php echo substr($value["texto"], 0,50)."..." ?></p>
                      <a class="btn btn-naranja" href="" data-titulo="<?php echo $value["titulo"] ?>" data-texto="<?php echo $value["texto"] ?>">Más Info</a>
                    </div>
                  </div>
                  <h3 class="titulo-noticia bold"><?php echo $value["titulo"] ?></h3>                  
                </div>             
              <?php
            }

          ?>
                                        
        </div>
      </div>
    </section>

    <!-- FIN SERVICIOS -->    

    <!-- LLAMADO 1 -->

    <section class="llamado">
      <div class="container">
        <h3 class="display-4 cl-blanco text-center sombra bold ">Descubrí un Nuevo Concepto Gráfico</h3>
        <h5 class="display-5 cl-blanco text-center sombra">¿Por qué un Nuevo Concepto Gráfico? Es simple, por la gran variedad de trabajos que realizamos: Papelería, folletería, bolsas, gigantografías, cartelería, letras corpóreas, exhibidores, estructuras metálicas, portones con diseño, carteles con luminaria, armados completos de stand y mucho más!</h5>
      </div>
    </section>

    <!-- FIN LLAMADO 1 -->    

    <!-- PRODUCTOS -->    

    <section id="productos" class="bg-naranja">
      <div class="container">
        <h2 class="display-4 text-center bold cl-blanco">Productos</h2>
        <p class="lead text-center cl-blanco">Estos son algunos de los productos que realizamos.</p>
        <div class="row">

          <?php 

            foreach ($productos as $key => $value) {
              ?>
                <div class="col-lg-4 col-md-6 cuadricula">
                  <div class="inner-cuadricula" style="background-image:url('backend/upload/<?php echo $value["imagen"] ?>')">
                    <div class="contenido-cuadricula text-center">
                      <h3 class="cl-blanco text-center display-5"><?php echo $value["titulo"] ?></h3>
                      <p class="cl-blanco text-center"><?php echo substr($value["detalle"], 0,50)."..." ?></p>
                      <h3 class="cl-blanco text-center display-5"><?php echo $value["precio"] ?>.-</h3>                
                      <a class="btn btn-naranja" data-titulo="<?php echo $value["titulo"] ?>" data-texto="<?php echo $value["detalle"] ?>" data-precio="<?php echo $value["precio"] ?>" href="">Más Info</a>
                    </div>
                  </div>
                  <h3 class="titulo-noticia text-white bold"><?php echo $value["titulo"] ?></h3>                                    
                </div>                                            
              <?php
            }

           ?>

        </div>
      </div>
    </section>

    <!-- FIN PRODUCTOS -->        

    <!-- LLAMADO 2 -->    

    <section class="llamado">
      <div class="container">
        <h3 class="display-4 cl-blanco text-center sombra bold ">Todo lo hacemos posible</h3>
        <h5 class="display-5 cl-blanco text-center sombra">Porque si lo puedes soñar lo podemos crear</h5>
      </div>
    </section>

    <!-- FIN LLAMADO 2 -->

    <!-- NOTICIAS -->

    <section id="noticias">
      <div class="container">
        
        <h2 class="text-center display-4 bold">Noticias</h2>

        <div class="row">

          <?php 

            foreach ($ultimasnoticias as $key => $value) {
              ?>

                <div class="col-md-4 cuadricula">
                  <div class="inner-cuadricula" style="background-image:url('backend/upload/<?php echo $value["imagen"] ?>')">
                    <div class="contenido-cuadricula text-center">
                      <h3 class="cl-blanco text-center display-5"><?php echo $value["titulo"] ?></h3>
                      <p class="cl-blanco text-center"><?php echo substr(strip_tags($value["contenido"]), 0, 50)."..." ?></p>
                      <a class="btn btn-naranja" href="noticia.php?id=<?php echo $value["id"] ?>">Leer Más...</a>
                    </div>
                  </div>
                  <h5 class="cl-naranja mt-1"><?php echo date('d', strtotime($value["fecha"]))." de ".$MESES[date('n', strtotime($value["fecha"]))-1]." del ".date('Y', strtotime($value["fecha"])) ?></h5>
                  <h3 class="titulo-noticia bold"><?php echo $value["titulo"] ?></h3>

                </div>
              
              <?php
            }

          ?>



        </div>
  
        <div class="row text-center mt-3">
          <div class="col-lg-12">
            <a style="width:100%" class="btn btn-naranja cl-blanco" href="noticias.php">VER TODAS LAS NOTICIAS</a>
          </div>
        </div>

      </div>
    </section>

    <!-- FIN NOTICIAS -->

    <!-- CONTACTO -->

    <section id="contacto">
      <div class="container">
        <div class="row">

          <!-- FORMULARIO CONTACTO -->

          <div class="col-md-6">
            <h2 class="display-4 bold">Contacto</h2>
            <p class="lead">Envianos un mensaje</p>
            
            <form class="form-horizontal" method="POST">
            <fieldset>

            <!-- Text input-->
            <div class="form-group">
              <input id="textinput" name="textinput" type="text" placeholder="Nombre" class="form-control input-md"> 
            </div>

            <!-- Text input-->
            <div class="form-group">
              <input id="textinput" name="textinput" type="text" placeholder="Email" class="form-control input-md"> 
            </div>

            <!-- Textarea -->
            <div class="form-group">
                <textarea class="form-control" id="textarea" name="textarea" placeholder="Mensaje"></textarea>
            </div>

            <div class="form-group">
              <input type="submit" class="btn btn-naranja">
            </div>

            </fieldset>
            </form>

          </div>

          <!-- FIN FORMULARIO CONTACTO -->

          <!-- MAPA -->

          <div class="col-md-6">
              
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d26248.83974266483!2d-58.35581854669817!3d-34.67730015119513!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95a33319cc7f1047%3A0x25aeff54bdf4f779!2sCmte.+Craig+70%2C+B1872BQA+Sarand%C3%AD%2C+Buenos+Aires!5e0!3m2!1ses!2sar!4v1543515524472" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>

          </div>

          <!-- FIN MAPA -->          

        </div>
      </div>
    </section>    

    <!-- FIN CONTACTO -->    


    <!-- Footer -->
    <footer class="py-5 bg-gris">
      <div class="container">
        <div class="row">
          <div class="col-lg-3">
            <img src="img/logo_horizontal_200.png" alt="">
          </div>
          <div class="col-lg-3">
            <ul class="fa-ul">
              <li>
                <span class="fa-li" ><i class="fas fa-map-marker-alt"></i></span>Cte. Craig 70, Sarandí
              </li>
              <li><span class="fa-li" ><i class="fas fa-envelope"></i></span>
                <a href="mailto:maringraf@maringraf.com.ar">maringraf@maringraf.com.ar</a> 
              </li>
            </ul>
          </div>
          <div class="col-lg-3">
            <ul class="fa-ul">
              <li><span class="fa-li" ><i class="fas fa-clock"></i></span>De Lun a Vie de 8 a 17 hs</li>
              <li><span class="fa-li" ><i class="fab fa-facebook-square"></i></span>
                <a target="_blank" href="https://www.facebook.com/MaringrafSA/">@MaringrafSA</a>
              </li>
            </ul>          
          </div>
          <div class="col-lg-3">
            <ul class="fa-ul">
              <li><span class="fa-li" ><i class="fas fa-phone-square fa-flip-horizontal"></i></span>
                <a href="callto:011 4203 7770">011 4203 7770</a>
              </li>
            </ul>          
          </div>
        </div>
      </div>
      <!-- /.container -->
    </footer>

    <!-- MODAL SERVICIOS -->

    <div class="modal fade" id="modal-servicios" tabindex="-1" role="dialog" aria-labelledby="serviciosLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-body">
            <h3 id="modal-servicios-titulo" class="cl-naranja text-center display-5"></h3>
            <p id="modal-servicios-texto" class="text-center"></p>            
          </div>

        </div>
      </div>
    </div>    

    <!-- FIN MODAL SERVICIOS -->

    <!-- MODAL SERVICIOS -->

    <div class="modal fade" id="modal-productos" tabindex="-1" role="dialog" aria-labelledby="productosLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">

          <div class="modal-body">
            <h3 id="modal-productos-titulo" class="cl-naranja text-center display-5">Producto</h3>
            <p id="modal-productos-texto" class="text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente iste commodi, porro rem ut minima, neque odit </p>
            <h3 id="modal-productos-precio" class="cl-naranja text-center display-5">$150.-</h3>         
          </div>

        </div>
      </div>
    </div>    

    <!-- FIN MODAL SERVICIOS -->    

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="vendor/jqueryeasing/jquery.easing.1.3.js"></script>

    <script>

    $('body').scrollspy({ target: '#navbar' })

    $("#servicios .btn").click(function(e){
      
      e.preventDefault();

      $("#modal-servicios-titulo").html($(this).attr("data-titulo"));
      $("#modal-servicios-texto").html($(this).attr("data-texto"));

      $("#modal-servicios").modal('toggle');

    })


    $("#productos .btn").click(function(e){
      
      e.preventDefault();

      $("#modal-productos-titulo").html($(this).attr("data-titulo"));
      $("#modal-productos-texto").html($(this).attr("data-texto"));
      $("#modal-productos-precio").html($(this).attr("data-precio"));      

      $("#modal-productos").modal('toggle');

    })    

    $(".nav-link").click(function(e){

      e.preventDefault();

      var divTag = $($(this).attr("href"));

      $('html,body').animate({
        scrollTop: divTag.offset().top
      }, 1000, 'easeOutQuint');
      
    })

   
    </script>

  </body>

</html>
