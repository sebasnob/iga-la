<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}

if($logged == 'out'){
    header("Location: login.php");
    exit();
}

$cod_curso = $_GET['cod_curso'];
$id_idioma = $_GET['id_idioma'];
$id_filial = $_GET['id_filial'];

$datos_curso = getDatosCurso($mysqli, $cod_curso, $id_idioma, $id_filial);

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>IGA - INSTITUTO GASTRONÓMICO DE LAS AMÉRICAS </title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/animate.min.css" rel="stylesheet"> 
  <link href="../css/font-awesome.min.css" rel="stylesheet">
  <link href="../css/lightbox.css" rel="stylesheet">
  <link href="../css/main.css" rel="stylesheet">
  <link id="css-preset" href="../css/presets/preset1.css" rel="stylesheet">
  <link href="../css/responsive.css" rel="stylesheet">

  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
  <![endif]-->
  
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
  <link rel="shortcut icon" href="images/favicon.ico">
</head><!--/head-->

<body>
    <section id="head_image_curso">
       <div class="container-fluid">
         <div class="row" align="center">
           <img class="img-responsive animated fadeInLeftBig" src="../<?=$datos_curso['url_cabecera']?>" alt="">
         </div>
       </div>
    </section> 
 
    <section id="single_curso" class="container">
        <div class="row">
            <aside class="col-sm-4 col-sm-push-8 ">
              <div class="widget ads">
                    <div class="row">
                        <div class="col-sm-12 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <div class="fb-page" data-href="https://www.facebook.com/IGA.GASTRONOMIA" data-width="500" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true">
                            <div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/IGA.GASTRONOMIA"><a href="https://www.facebook.com/IGA.GASTRONOMIA">IGA</a></blockquote></div>
                            </div>
                        </div>
                    </div>
                </div><!--/.ads-->     
            </aside>        
            <div class="col-sm-8 col-sm-pull-4">
                <section id="curso">
                      <h2><?=$datos_curso['nombre']?></h2>
                      <div class="entry-meta">
                          <span>
                              <i class="fa fa-calendar">
                                  <?php echo ($datos_curso['horas'] != '' && $datos_curso['horas'] != 0)? $datos_curso['horas']." horas": ''; ?>
                                  <?php echo ($datos_curso['meses'] != '' && $datos_curso['meses'] != 0)? ", ".$datos_curso['meses']." meses": ''; ?>
                                  <?php echo ($datos_curso['anios'] != '' && $datos_curso['anios'] != 0)? ", ".$datos_curso['anios']." años": ''; ?>
                              </i>
                          </span>
                      </div>
                      <?=$datos_curso['descripcion']?>
                </section>
                <hr>
                <section id="meterial_curso" >
                    <h3>Material del curso</h3>
                            <div class="well">
                                <div class="media">
                                    <div class="pull-left">
                                        <img class="avatar img-thumbnail" src="../<?=$datos_curso['url_material']?>" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-heading">
                                            <strong>Cada curso de IGA</strong>
                                        </div>
                                        <p><?=$datos_curso['desc_material']?></p>
                                    </div>
                                </div>
                            </div><!--/.author-->
                        </section>
                        <hr>
                         <section id="uniformes" >
                            <h3>Uniformes</h3>
                             <div class="well">
                                <div class="media">
                                    <div class="pull-left">
                                        <img class="avatar img-thumbnail" src="../<?=$datos_curso['url_uniforme']?>" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-heading">
                                            <strong>Con la inscripción al curso,</strong>
                                        </div>
                                        <p><?=$datos_curso['desc_uniforme']?></p>
                                    </div>
                                </div>
                            </div><!--/.author-->
                        </section>
                </div><!--/.col-md-8-->
                <div class="col-md-12">
                    <section id="objetivo">
                       <h2>Nuestro Objetivo</h2>
                       <div class="entry-meta">
                         <span> <i class="fa fa-calendar"> Duración:
                                  <?php echo ($datos_curso['horas'] != '')? $datos_curso['horas']." horas": ''; ?>
                                  <?php echo ($datos_curso['meses'] != '')? ", ".$datos_curso['meses']." meses": ''; ?>
                                  <?php echo ($datos_curso['anios'] != '')? ", ".$datos_curso['anios']." años": ''; ?>
                              </i></span>
                       </div>
                       <p class="lead"><?=$datos_curso['objetivos']?></p>
                    </section>
                </div>
        </div><!--/.row-->
</section><!--/#single_cursos-->

<script type="text/javascript" src="assets/js/jquery.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
      <!-- Plugins Facebook -->
    <script>(function(d, s, id) {
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) return;
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.4";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   </script>
</body>
</html>