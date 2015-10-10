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

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?=$lenguaje['titulo_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></title>
        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />

        <!-- Custom styles for this template -->
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/style-responsive.css" rel="stylesheet">
        <link href="assets/css/table-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css"> 
        
        <link rel="stylesheet" type="text/css" media="screen" href="styles.php?id_curso=<?=$_GET['cod_curso']?>">
        
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
        
    </head><!--/head-->
    <body>
        <div id="fb-root"></div>
        <header id="home">
            <div class="main-nav">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php">
                            <h1><img class="img-responsive" src="images/logo-iga_transparent.png" alt="logo"></h1>
                        </a>                    
                    </div>
                    <div class="collapse navbar-collapse">
                        
                    </div>
                </div>
            </div><!--/#main-nav-->
            
        </header><!--/#home-->

        <section id="head_image_curso">
            <div class="container-fluid">
                <div class="row">
                    <img id="slider" class="img-responsive animated fadeInLeftBig" src="" alt="" style="width: 100%;">
                </div>
            </div>
        </section> 
        
        <section id="single_curso" class="container">
            <div class="row">
                <aside class="col-sm-4 col-sm-push-8">
                    <!--<div class="widget ads">
                        <div class="row">
                            <div class="col-sm-12 wow fadeInUp text-center" data-wow-duration="1000ms" data-wow-delay="400ms">
                                <div class="fb-page" data-href="https://www.facebook.com/IGA.GASTRONOMIA" data-width="500" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true">
                                    <div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/IGA.GASTRONOMIA"><a href="https://www.facebook.com/IGA.GASTRONOMIA">IGA</a></blockquote></div>
                                </div>
                            </div>
                        </div>
                    </div><!--/.ads-->     
                    <div class="widget ads">
                        <div class="row">
                            <div class="col-sm-12 wow fadeInUp text-center" data-wow-duration="1000ms" data-wow-delay="400ms">
                               <div class="post-thumb">
                                    <a href="#"><img class="img-responsive" src="images/blog/3.jpg" alt=""></a>
                                </div>
                                <div class="entry-header">
                                    <h3><a href="#">Lorem ipsum dolor sit amet consectetur adipisicing elit</a></h3>
                                </div>
                                <div class="entry-content">
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                </div>
                            </div>
                        </div>
                    </div><!--/.categories-->
                </aside>        
                <div class="col-sm-8 col-sm-pull-4">
                    <section id="curso">
                        <h2><span id="nombre_curso"></span></h2>
                        <div class="entry-meta">
                            <span>
                                <i class="fa fa-calendar"></i>&nbsp;Duración:
                                <span class="horas"></span>
                                <span class="meses"></span>
                                <span class="anios"></span>
                            </span>
                        </div>
                        <span id="descripcion"></span>
                    </section>
                    <hr>
                    <section id="cursado_planes">
                        <h3>Cursado y plan de pagos</h3>
                        <p>Para ver los inicios de clases, los horarios de cursado y las formas de pago, seleccione una provincia y un local.</p>
                        <form id="form-matricula" name="form-matricula" method="post" action="#" class="form-inline">
                            <div class="form-group">
                                <label for="option"><?=$lenguaje['provincia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></label>
                                <select id="provincias" class="form-control" onchange="javascript:cambiarProvinciaMatricula('<option><?=$lenguaje["seleccione_filial_".$_SESSION["idioma_seleccionado"]["cod_idioma"]] ?></option>')">
                                    <option value="0"><?=$lenguaje['seleccione_provincia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></option>  
                                <?php foreach ($provincias as $provincia){?>

                                    <option value="<?=$provincia['id']?>"><?=$provincia['nombre']?></option>    

                                <?php }?>
                                </select>    

                            </div>

                            <div class="form-group">
                                <label for="option"><?=$lenguaje['filiales_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></label>
                                <select id="filiales_matricula" class="form-control">
                                    <option><?=$lenguaje['seleccione_filial_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></option>
                                </select>

                            </div>
                        </form>
                        <br/>
                        <div id="matricula_curso" style="display: none">
                            <ul class="list-group">
                                <li class="list-group-item "><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> <strong>Lunes y Miércoles </strong> - de 18:30 a 20:30 y de 18:30 a 22:30 - <strong>Matrícula</strong> $400 - 22 Cuotas de $995</li>
                                <li class="list-group-item"><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> <strong>Miércoles </strong> - de 15:30 a 17:30 <strong>Matrícula</strong> $400 - 22 Cuotas de $995</li>
                                <li class="list-group-item" ><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> <strong>Lunes</strong> - de 18:30 a 20:30 - <strong>Matrícula</strong> $400 - 22 Cuotas de $995</li>
                                <li class="list-group-item"><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..." > <strong>Sábado </strong> - de 12:00 a 14:00 - <strong>Matrícula</strong> $400 - 22 Cuotas de $995</li>
                            </ul>  
                        
                            <form id="main-contact-form" name="contact-form" method="post" action="#">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Nombre" required="required">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="Dirección de Email" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required="required">
                                </div>
                                <div class="form-group">
                                    <textarea name="message" id="message" class="form-control" rows="4" placeholder="Ingrese su mensaje" required="required"></textarea>
                                </div>                        
                                <div class="form-group">
                                    <button type="submit" class="btn-btn-default">Reservar Lugar</button>
                                </div>
                            </form>
                        </div>
                    </section>
                    <hr>
                    <section id="meterial_curso" >
                        <h3>Material del curso</h3>
                        <div class="well">
                            <div class="media">
                                <div class="pull-left">
                                    <img id="img_materiales" class="avatar img-thumbnail" src="" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <strong>Cada curso de IGA</strong>
                                    </div>
                                    <span id="desc_materiales"></span>
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
                                    <img id="img_uniformes" class="avatar img-thumbnail" src="" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <strong>Con la inscripción al curso,</strong>
                                    </div>
                                    <span id="desc_uniformes"></span>
                                </div>
                            </div>
                        </div><!--/.author-->
                    </section>
                </div><!--/.col-md-8-->
                <div class="col-md-12">
                    <section id="objetivo">
                        <h2>Nuestro Objetivo</h2>
                        <div class="entry-meta">
                            <span>
                                <i class="fa fa-calendar"></i>&nbsp;Duración:
                                <span class="horas"></span>
                                <span class="meses"></span>
                                <span class="anios"></span>
                            </span>
                        </div>
                        <span id="objetivos"></span>
                    </section>
                </div>
            </div><!--/.row-->
        </section><!--/#single_cursos-->
        
        <footer id="footer">
            <div class="footer-top wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <div class="container text-center">
                    <div class="footer-logo">
                        <a href="index.html"><img class="img-responsive" src="images/logo-iga_transparent.png" alt=""></a>
                    </div>
                    <div class="social-icons">
                        <ul>
                           <!-- <li><a class="envelope" href="#"><i class="fa fa-envelope"></i></a></li>-->
                            <li><a class="twitter" href="https://twitter.com/IGA_LA" target="_blank"><i class="fa fa-twitter"></i></a></li> 
                           <!-- <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>-->
                            <li><a class="facebook" href="https://www.facebook.com/IGA.GASTRONOMIA" target="_blank"><i class="fa fa-facebook"></i></a></li>
                           <!-- <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>-->
                           <!-- <li><a class="tumblr" href="#"><i class="fa fa-tumblr-square"></i></a></li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 text-center">
                            <p><a href="http://www.iga-la.com/empleos/" target="_blank"><?=$lenguaje['quiero_trabajar_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></p>
                        </div>
                        
                        <div class="col-sm-4 text-center">
                            <p><a href="http://igafranchising.com/" target="_blank"><?=$lenguaje['quiero_una_franquisia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></p>
                        </div>
                        <div class="col-sm-4 text-center">
                            <p>&copy; 2015 Designed by <a href="http://www.lifeweb.com.ar/" target="_blank">lifeWEB</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
       
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
        <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
        
        
        <!--common script for all pages-->
        <script src="assets/js/common-scripts.js"></script>
        
        <script type="text/javascript" src="assets/js/ckeditor/ckeditor.js"></script>
        <!-- Plugins Facebook -->
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.4";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        
        </script>
        <script>
            $(document).ready(function(){
                $('#slider').attr('src',localStorage.getItem("imagePreview"));
                $('#nombre_curso').html(localStorage.getItem("nombre_curso"));
                $('.horas').html(localStorage.getItem("horas"));
                $('.meses').html(localStorage.getItem("meses"));
                $('.anios').html(localStorage.getItem("anios"));
                $('#descripcion').html(localStorage.getItem("descripcion"));
            });
        </script>
    </body>
</html>

