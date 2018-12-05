<?php 

if (!isset($_GET["pagina"])) {
  header("location: noticias.php?categoria=".$_GET["categoria"]."&pagina=1"); 
}

$MESES = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

$categorias = array();
$noticias = array();
$ultimasnoticias = array();

$cantidadnoticias = 0;

include_once("backend/ewcfg10.php");

$conn = mysqli_connect(EW_CONN_HOST, EW_CONN_USER, EW_CONN_PASS, EW_CONN_DB);

$sql = "SELECT * FROM categorias";

$resultado = mysqli_query($conn, $sql);

if ($resultado) {
  for ($i=0; $i < mysqli_num_rows($resultado); $i++) { 
    $registro = mysqli_fetch_assoc($resultado);
    $registro = array_map("utf8_encode", $registro);
    array_push($categorias, $registro);
  }
}

$sql = "SELECT * FROM noticias ORDER BY id DESC LIMIT 3 OFFSET ".($_GET["pagina"] -1) * 3;

if (isset($_GET["categoria"])) {
  if ($_GET["categoria"] != "") {
    $sql = "SELECT * FROM noticias WHERE idCategoria = '".$_GET["categoria"]."' ORDER BY id DESC LIMIT 3 OFFSET ".($_GET["pagina"] -1) * 3;    
  }
}

$resultado = mysqli_query($conn, $sql);

if ($resultado) {

  for ($i=0; $i < mysqli_num_rows($resultado); $i++) { 
    $registro = mysqli_fetch_assoc($resultado);
    $registro = array_map("utf8_encode", $registro);
    array_push($noticias, $registro);
  }
}

$sql = "SELECT * FROM noticias ORDER BY id DESC";

if (isset($_GET["categoria"])) {
  if ($_GET["categoria"] != "") {
    $sql = "SELECT * FROM noticias WHERE idCategoria = '".$_GET["categoria"]."' ORDER BY id DESC";    
  }
}

$resultado = mysqli_query($conn, $sql);

if ($resultado) {
  $cantidadnoticias = mysqli_num_rows($resultado);
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
    <nav id="navbar" class="navbar navbar-expand-lg navbar-dark fixed-top">
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
              <a class="nav-link" href="index.php#home">Home
                <span class="sr-only">(actual)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php#quienes-somos">Quienes Somos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php#servicios">Servicios</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php#productos">Productos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php#noticias">Noticias</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="index.php#contacto">Contacto</a>
            </li>            
          </ul>
        </div>

      </div>
    </nav>

    <section>
      <div class="container">

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a class="cl-naranja" href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Noticias</li>
          </ol>
        </nav>            
        <div class="row">
          
          <!-- NOTICIAS -->

          <div class="col-md-8">

            <?php

            if ($cantidadnoticias > 0) {
              $cantidadpaginas = ceil($cantidadnoticias/3);
              foreach ($noticias as $key => $value) {
                ?>
                  <div class="noticia mt-5">
                    <img width="100%" src="backend/upload/<?php echo $value["imagen"] ?>" alt="">
                    <h2 class="mt-3 bold display-5"><?php echo $value["titulo"] ?></h2>
                    <h6 class="mt-3 cl-naranja display-6"><?php echo date('d', strtotime($value["fecha"]))." de ".$MESES[date('n', strtotime($value["fecha"]))-1]." del ".date('Y', strtotime($value["fecha"])) ?></h6>
                    <p class="mt-3 "><?php echo substr(strip_tags($value["contenido"]), 0, 50)."..." ?></p>
                    <a class="mt-3 cl-naranja bold" href="noticia.php?id=<?php echo $value["id"] ?>">Leer Más...</a>
                  </div>
                <?php
              }

              ?>

              <nav class="mt-5" aria-label="Page navigation example">
                <ul class="pagination">
                  <li class="page-item">
                    <?php 
                      if ($_GET["pagina"] > 1) {
                        ?>
                          <a class="page-link" href="noticias.php?categoria=<?php echo $_GET["categoria"] ?>&pagina=<?php echo $_GET["pagina"]-1 ?>" aria-label="Previous">
                            <span aria-hidden="true"><i class="fas fa-chevron-circle-left cl-naranja fa-lg"></i></span>
                            <span class="sr-only">Previous</span>
                          </a>
                        <?php
                      }
                    ?>
                  </li>
                  
                  <?php

                    if ($cantidadpaginas > 1) {
                      for ($i=0; $i < $cantidadpaginas; $i++) { 
                        ?>
                        <li class="page-item"><a class="page-link" href="noticias.php?categoria=<?php echo $_GET["categoria"] ?>&pagina=<?php echo $i+1 ?>"><?php echo $i+1 ?></a></li>
                        <?php
                      }
                    }

                  ?>

                  <li class="page-item">
                    <?php
                      if ($_GET["pagina"] < $cantidadpaginas) {
                        ?>
                          <a class="page-link" href="noticias.php?categoria=<?php echo $_GET["categoria"] ?>&pagina=<?php echo $_GET["pagina"]+1 ?>" aria-label="Next">
                            <span aria-hidden="true"><i class="fas fa-chevron-circle-right cl-naranja fa-lg"></i></span>
                            <span class="sr-only">Next</span>
                          </a>
                        <?php
                      }
                    ?>
                  </li>
                </ul>
              </nav>

              <?php            
                 
             }else{
              ?>
              <h3>No hay noticias por aqui...</h3>
              <?php
             }

             ?>

            
          </div>

          <!-- FIN NOTICIAS -->

          <!-- CATEGORIAS -->

          <div class="col-md-4">

            <div class="row mt-5">
              <div class="bg-gris col-lg-12 p-3 redondeado">
                <h5 class="cl-blanco">Categorias</h5>

                <form id="categorias" class="form-horizontal">

                <div class="form-group">

                  <select id="categoria" name="categoria" class="form-control">
                    <option value="">Seleccione Categoría...</option>
                    <?php 

                      foreach ($categorias as $key => $value) {
                        
                        $selected = FALSE;

                        if (isset($_GET["categoria"])) {
                          if ($value["id"] == $_GET["categoria"]) {
                              $selected = TRUE;
                            }  
                        }

                        ?>

                        <option <?php echo $selected?"selected":" " ?> value="<?php echo $value["id"] ?>"><?php echo $value["denominacion"] ?></option>
                        <?php
                      }

                     ?>
                  </select>

                </div>

                </form>

              </div>
            </div>

            <div class="row mt-5">
              <div class="col-lg-12">

                <h5 class="mb-5">Últimas Entradas</h5>

                <?php 

                  foreach ($ultimasnoticias as $key => $value) {
                    ?>

                      <div class="ultima-entrada">
                        <h6 class="cl-naranja"><?php echo date('d', strtotime($value["fecha"]))." de ".$MESES[date('n', strtotime($value["fecha"]))-1]." del ".date('Y', strtotime($value["fecha"])) ?></h6>
                        <h6><a href="noticia.php?id=<?php echo $value["id"] ?>"><?php echo $value["titulo"] ?></a></h6>
                      </div>

                      <hr class="my-3">                              
                    
                    <?php

                  }

                ?>

              </div>
            </div>
            
          </div>

          <!-- FIN CATEGORIAS -->

        </div>

      </div>      
    </section>


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
                <a href="mailto:info@maringraf.com.ar">info@maringraf.com.ar</a> 
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
                <a href="callto:011 4203 7779">011 4203 7779</a>
              </li>
            </ul>          
          </div>
        </div>
      </div>
      <!-- /.container -->
    </footer>  

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>

    $("#categoria").change(function(){
      $("#categorias").submit();
    })

    </script>

  </body>

</html>
