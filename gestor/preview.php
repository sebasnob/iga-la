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

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?=$lenguaje['titulo_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/animate.min.css" rel="stylesheet"> 
        <link href="../css/font-awesome.min.css" rel="stylesheet">
        <link href="../css/lightbox.css" rel="stylesheet">
        <link href="../css/main.css" rel="stylesheet">
        <link id="css-preset" href="../css/presets/preset1.css" rel="stylesheet">
        <link href="../css/responsive.css" rel="stylesheet">
        
        <link rel="stylesheet" type="text/css" media="screen" href="../styles_home.php" />
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
        
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
        <link rel="apple-touch-icon" sizes="57x57" href="images/favicons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="images/favicons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="images/favicons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="images/favicons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="images/favicons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="images/favicons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="images/favicons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="images/favicons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="images/favicons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/favicon-16x16.png">
        <link rel="manifest" href="images/favicons/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="images/favicons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
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
                        <ul class="nav navbar-nav navbar-left">     
                            <li class="scroll active"><a href="#">Inicio </a></li>
                            <li class="scroll"><a href="#">Cursos </a></li>
                                            
                            <li class="scroll"><a href="#">Novedades </a></li>
                             <li class="scroll"><a href="#">Institucional </a></li>  
                            <li class="scroll"><a href="#">Contacto </a></li>
                            <li><a href="#" target="_blank">Campus</a></li> 
                        </ul>
                        <ul class="nav navbar-nav navbar-right">&nbsp;</ul>
                    </div>
                </div>
            </div><!--/#main-nav-->
            
        </header><!--/#home-->

        <section id="head_image_curso">
            <div class="container-fluid">
                <div class="row">
                    <img class="img-responsive animated fadeInLeftBig" src="" alt="" style="width: 100%;">
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
                        <h2></h2>
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
                                <label for="option">Provincia</label>
                                <select id="provincias" class="form-control" >
                                    <option value="0">- Seleccione -</option>  
                                </select>    
                            </div>

                            <div class="form-group">
                                <label for="option">Filial</label>
                                <select id="filiales_matricula" class="form-control">
                                    <option>- Seleccione -</option>
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
                                    <img class="avatar img-thumbnail" src="" alt="">
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
                                    <img class="avatar img-thumbnail" src="" alt="">
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
                        <span id="objetivos_curso"></span>
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
        </footer>
        
        <script type="text/javascript" src="../js/jquery.js"></script>
        <script type="text/javascript" src="../js/bootstrap.min.js"></script>
        <script type="text/javascript" src="../js/jquery.inview.min.js"></script>
        <script type="text/javascript" src="../js/wow.min.js"></script>
        <script type="text/javascript" src="../js/mousescroll.js"></script>
        <script type="text/javascript" src="../js/smoothscroll.js"></script>
        <script type="text/javascript" src="../js/jquery.countTo.js"></script>
        <script type="text/javascript" src="../js/lightbox.min.js"></script>
        <script type="text/javascript" src="../js/main.js"></script>
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
            $('#curso h2').append(localStorage.getItem('nombre_curso'));
            $('#head_image_curso img').attr('src', localStorage.getItem('imagePreview'))
            $('.horas').append(localStorage.getItem('horas')+" horas");
            $('.meses').append(", "+localStorage.getItem('meses')+" meses");
            $('.anios').append(", "+localStorage.getItem('anios')+" años");
            $('#descripcion').append(localStorage.getItem('descripcion'));
            $('#meterial_curso img').attr('src', localStorage.getItem('imageMat'));
            $('#desc_materiales').append(localStorage.getItem('descMat'));
            $('#uniformes img').attr('src', localStorage.getItem('imageUnif'));
            $('#desc_uniformes').append(localStorage.getItem('descUnif'));
            $('#objetivos_curso').append(localStorage.getItem('objetivos'));
        });
        </script>
    </body>
</html>



