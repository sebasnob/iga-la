<?php
session_start();
include_once 'gestor/includes/db_connect.php';
include_once 'gestor/includes/functions.php';

if(!$_SESSION){
    //detectCountry($mysqli);
    $_SESSION['pais'] = array('cod_pais'=>"AR", 'idioma'=>'ES');
}

$paises = getPaises($mysqli);
$datos_home = getDatosHome($mysqli);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="lifeWEB.com">
        <title>IGA - INSTITUTO GASTRONÓMICO DE LAS AMÉRICAS </title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/animate.min.css" rel="stylesheet"> 
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/lightbox.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link id="css-preset" href="css/presets/preset1.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">
        
        <link rel="stylesheet" type="text/css" media="screen" href="styles_home.php" />
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
      
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="images/favicon.ico">
        
        <?php
            $gridArray = getImagenesGrilla($mysqli);
        ?>
    </head><!--/head-->
    
    <body>
    
        <!--.preloader-->
        <div class="preloader"> <i class="fa fa-circle-o-notch fa-spin"></i></div>
        <!--/.preloader-->
      
        <header id="home">
            <div id="home-slider" class="container-fluid">
                <div class="caption">
                    <h1 class="animated fadeInLeftBig">
                    <?php
                    switch($_SESSION['pais']['idioma']){
                        case 'IN':
                                echo $datos_home['titulo_in'];
                            break;
                        case 'POR':
                                echo $datos_home['titulo_por'];
                            break;
                        default: 
                                echo $datos_home['titulo_es'];
                            break;
                    }
                    ?>
                    </h1>
                    <p class="animated fadeInRightBig">
                    <?php
                    switch($_SESSION['pais']['idioma']){
                        case 'IN':
                                echo $datos_home['subtitulo_in'];
                            break;
                        case 'POR':
                                echo $datos_home['subtitulo_por'];
                            break;
                        default: 
                                echo $datos_home['subtitulo_es'];
                            break;
                    }
                    ?>
                    </p>
                    <!--<h1 class="animated fadeInLeftBig">Bienvenidos a <span>IGA</span></h1>
                    <p class="animated fadeInRightBig">INSTITUTO GASTRONÓMICO DE LAS AMÉRICAS </p>-->
                    <a data-scroll class="btn btn-start animated fadeInUpBig" href="#portfolio">Que Deseas aprender hoy?</a>
                </div>
                <div class="embed-responsive embed-responsive-16by9">
                    <div id="background">
                        <!-- https://www.youtube.com/embed/JApGTCxZztg?rel=0&controls=0&showinfo=0&autoplay=1&autoplay=1&loop=0&playlist=Rk6_hdRtJOE&enablejsapi=1&version=3-->
                        <!--<iframe id='player' width="100%" height="100%" src="<?=$datos_home['url_video']?>" frameborder="0" volumen="0"></iframe>-->
                    </div>
                </div>          
            </div>
       
        <div class="main-nav">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html">
                        <h1><img class="img-responsive" src="images/logo-iga_transparent.png" alt="logo"></h1>
                    </a>                    
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-left">     
                        <li class="scroll active"><a href="#home">Inicio</a></li>
                        <li class="scroll"><a href="#portfolio">Cursos</a></li>
                        <li class="scroll"><a href="#team">Institucional</a></li>                     
                        <li class="scroll"><a href="#blog">Novedades</a></li> 
                        <li class="scroll"><a href="#contact">Contacto</a></li>
                        <li class="scroll"><a href="#contact">Campus</a></li> 
                    </ul>
              
                    <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?=$_SESSION['pais']['flag']?>" /><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                <?php
                foreach($paises as $i=>$d){
                    if($_SESSION['pais']['cod_pais'] != $d['cod_pais']){
                ?>
                        <li><a href="#"><img src="" /></a></li>
                <?php
                    }
                }
                ?>
                </ul>
            </li>
            <li>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Español <span class="caret"></span></a>
                <ul class="dropdown-menu">
                                <li><a href="#">Portugues</a></li>
                                <li><a href="#">Ingles</a></li>
                            </ul>
            </li>
           
          </ul>
                            </div>
                            </div>
                            </div><!--/#main-nav-->
                            </header><!--/#home-->
    
                            <section id="portfolio">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                                            <h2>Suscríbete a todos nuestros cursos</h2>
                                            <p>Ingresa tus datos en el formulario de consultas y envíanos tu consulta</p>
                                        </div>
                                    </div> 
                                </div>
                                <div class="container-fluid">
                                    <div class="row">
                                        <?php foreach ($gridArray as $imgGrid){?>
                                        <div class="col-md-<?php echo $imgGrid['cols']?>">
                                            <div class="folio-item wow fadeInRightBig" data-wow-duration="1000ms" data-wow-delay="300ms">
                                                <div class="folio-image">
                                                    <img class="img-responsive" src="<?php echo $imgGrid['img_url']?>" alt="">
                                                </div>
                                                <div class="overlay">
                                                    <div class="overlay-content">
                                                        <div class="overlay-text">
                                                            <div class="folio-overview">
                                                                <span class="folio-expand ">
                                                                    <a href="javascript:descripcionCurso('<?php echo $imgGrid['id_curso']?>')">
                                                                        <i class="fa fa-plus"></i>
                                                                    </a>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                </div> <!--/#container-fluid-porfolios-->
          
                                <div id="portfolio-single-wrap">
                                    <div id="single-portfolio" class="container collapse">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <img class="img-responsive animated fadeInDown" src="images/slider/4.jpg" alt="">
                                                <div class="col-sm-9">
                                                    <div class="project-info">
                                                        <h2>Gastronomía y Alta Cocina</h2>
                                                        <div class="entry-meta">
                                                            
                                                            <span><i class="fa fa-calendar"></i> 2 años de duración</span>
                                                          
                                                        </div>
                                                        <p class="lead">“Gastronomía y Alta Cocina” brinda los conocimientos necesarios para alcanzar la excelencia como profesional de la gastronomía. Además obtendrás las herramientas para emprender un negocio culinario y alcanzar así la cima del éxito, haciendo de la cocina tu profesión.</p>
                                                      
                                                        <p>Convertite en un profesional de la alta cocina y del arte culinario! Encabezá un equipo de cocineros en un negocio culinario de altísimo nivel!</p>
                                                      
                                                        <p>Cursado el 1º año recibís el certificado de COCINERO PROFESIONAL
                                                            <br>Cursado el 2º año recibís el certificado de GASTRONOMÍA & ALTA COCINA</p>
                                                    </div>
                                                </div>
                                
                                                <div class="col-sm-3">
                                                    <div class="project-details">
                                                        <h3>Project Details</h3>
                                                        <p><span>Client: </span>WrapBootstrap</p>
                                                        <p><span>Date:</span> 15 Oct 2014</p>
                                                        <p><span>Tag:</span> Graphic, Design, Creative</p>
                                                    </div>  
                                                </div>
                              
                                            </div>
                                            <a class="close-folio-item" href="#single-portfolio" data-toggle="collapse"><i class="fa fa-times"></i></a>
                   
                                        </div>
                                    </div>
                                </div>
           
                            </section><!--/#portfolio-->
      
                            <section id="team">
                                <div class="container">
                                    <div class="row">
                                        <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
                                            <h2>IGA</h2>
                                            <p>Capacitamos a nuestros alumnos con una especialización en el arte culinario, desarrollando las actitudes y valores que requiere la formación de personas responsables, reflexivas, críticas, con conciencia ética y solidaria, para poder cubrir así la demanda laboral nacional e internacional.</p>
                                        </div>
                                    </div>
                                    <div class="team-members">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="300ms">
                                                    <div class="member-image">
                                                        <img class="img-responsive" src="images/team/1.jpg" alt="">
                                                    </div>
                                                    <div class="member-info">
                                                        <h3>La Red</h3>
                    
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam</p>
                                                    </div>
                  
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="500ms">
                                                    <div class="member-image">
                                                        <img class="img-responsive" src="images/team/2.jpg" alt="">
                                                    </div>
                                                    <div class="member-info">
                                                        <h3>Misión</h3>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam</p>
                                                    </div>
                  
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="800ms">
                                                    <div class="member-image">
                                                        <img class="img-responsive" src="images/team/3.jpg" alt="">
                                                    </div>
                                                    <div class="member-info">
                                                        <h3>Visión</h3>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam</p>
                                                    </div>
                  
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="1100ms">
                                                    <div class="member-image">
                                                        <img class="img-responsive" src="images/team/4.jpg" alt="">
                                                    </div>
                                                    <div class="member-info">
                                                        <h3>Valores</h3>
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam</p>
                                                    </div>
                  
                                                </div>
                                            </div>
                                        </div>
                                    </div>            
                                </div>
                            </section><!--/#team-->
      
                            <section id="features" class="parallax">
                                <div class="container">
                                    <div class="row count">
                                        <div class="col-sm-3 col-xs-6 wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="300ms">
                                            <i class="fa fa-user"></i>
                                            <h3 class="timer">4000</h3>
                                            <p>Alumnos Felices :)</p>
                                        </div>
                                        <div class="col-sm-3 col-xs-6 wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="500ms">
                                            <i class="fa fa-home"></i>
                                            <h3 class="timer">200</h3>                    
                                            <p>Filiales</p>
                                        </div> 
                                        <div class="col-sm-3 col-xs-6 wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="700ms">
                                            <i class="fa fa-folder-o"></i>
                                            <h3 class="timer">10</h3>                    
                                            <p>Cursos Disponibles</p>
                                        </div> 
                                        <div class="col-sm-3 col-xs-6 wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="900ms">
                                            <i class="fa fa-comment-o"></i>                    
                                            <h3>24/7</h3>
                                            <p>Consultas</p>
                                        </div>                 
                                    </div>
                                </div>
                            </section><!--/#features-->
      
      
      
      
      
                            <section id="blog">
                                <div class="container">
                                    <div class="row">
                                        <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
                                            <h2>Novedades - Blog Posts</h2>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam</p>
                                        </div>
                                    </div>
                                    <div class="blog-posts">
                                        <div class="row">
                                            <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                                                <div class="post-thumb">
                                                    <a href="#"><img class="img-responsive" src="images/blog/1.jpg" alt=""></a> 
                                                    <div class="post-meta">
                                                        <span><i class="fa fa-comments-o"></i> 3 Comments</span>
                                                        <span><i class="fa fa-heart"></i> 0 Likes</span> 
                                                    </div>
                                                    <div class="post-icon">
                                                        <i class="fa fa-pencil"></i>
                                                    </div>
                                                </div>
                                                <div class="entry-header">
                                                    <h3><a href="#">Lorem ipsum dolor sit amet consectetur adipisicing elit</a></h3>
                                                    <span class="date">June 26, 2014</span>
                                                    <span class="cetagory">in <strong>Photography</strong></span>
                                                </div>
                                                <div class="entry-content">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="600ms">
                                                <div class="post-thumb">
                                                    <div id="post-carousel"  class="carousel slide" data-ride="carousel">
                                                        <ol class="carousel-indicators">
                                                            <li data-target="#post-carousel" data-slide-to="0" class="active"></li>
                                                            <li data-target="#post-carousel" data-slide-to="1"></li>
                                                            <li data-target="#post-carousel" data-slide-to="2"></li>
                                                        </ol>
                                                        <div class="carousel-inner">
                                                            <div class="item active">
                                                                <a href="#"><img class="img-responsive" src="images/blog/2.jpg" alt=""></a>
                                                            </div>
                                                            <div class="item">
                                                                <a href="#"><img class="img-responsive" src="images/blog/1.jpg" alt=""></a>
                                                            </div>
                                                            <div class="item">
                                                                <a href="#"><img class="img-responsive" src="images/blog/3.jpg" alt=""></a>
                                                            </div>
                                                        </div>                               
                                                        <a class="blog-left-control" href="#post-carousel" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                                                        <a class="blog-right-control" href="#post-carousel" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>
                                                    </div>                            
                                                    <div class="post-meta">
                                                        <span><i class="fa fa-comments-o"></i> 3 Comments</span>
                                                        <span><i class="fa fa-heart"></i> 0 Likes</span> 
                                                    </div>
                                                    <div class="post-icon">
                                                        <i class="fa fa-picture-o"></i>
                                                    </div>
                                                </div>
                                                <div class="entry-header">
                                                    <h3><a href="#">Lorem ipsum dolor sit amet consectetur adipisicing elit</a></h3>
                                                    <span class="date">June 26, 2014</span>
                                                    <span class="cetagory">in <strong>Photography</strong></span>
                                                </div>
                                                <div class="entry-content">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="800ms">
                                                <div class="post-thumb">
                                                    <a href="#"><img class="img-responsive" src="images/blog/3.jpg" alt=""></a>
                                                    <div class="post-meta">
                                                        <span><i class="fa fa-comments-o"></i> 3 Comments</span>
                                                        <span><i class="fa fa-heart"></i> 0 Likes</span> 
                                                    </div>
                                                    <div class="post-icon">
                                                        <i class="fa fa-video-camera"></i>
                                                    </div>
                                                </div>
                                                <div class="entry-header">
                                                    <h3><a href="#">Lorem ipsum dolor sit amet consectetur adipisicing elit</a></h3>
                                                    <span class="date">June 26, 2014</span>
                                                    <span class="cetagory">in <strong>Photography</strong></span>
                                                </div>
                                                <div class="entry-content">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                                </div>
                                            </div>                    
                                        </div>
                                        <div class="load-more wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="500ms">
                                            <a href="#" class="btn-loadmore"><i class="fa fa-repeat"></i> Cargar más</a>
                                        </div>                
                                    </div>
                                </div>
                            </section><!--/#blog-->
      
                                <section id="contact">
      
                                <div id="contact-us" >
                                    <div class="container">
                                        <div class="row">
                                            <div class="heading text-center wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                                                <h2>Contactate con nosotros</h2>
                                                <p>Encontra tu IGA en Argentina</p>
                                                <div class="col-sm-12 text-center wow fadeIn">
                                                    <form id="filter-form" name="filter-form" method="post" action="#" class="form-inline">
                                                        <div class="form-group">
                                                            <label for="option">Provincia</label>
                                                            <select class="form-control">
                                                                <option>Rosario</option>
                                                                <option>opcion 2</option>
                                                            </select>
                                                        </div>
                       
                                                        <div class="form-group">
                                                            <label for="option">Filial</label>
                                                            <select class="form-control">
                                                                <option>filial 1</option>
                                                                <option>opcion 2</option>
                                                            </select>
                                                        </div> 
                       
                                                        <button type="submit" class="btn-btn-default">Seleccionar</button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="contact-form wow fadeIn" data-wow-duration="1000ms" data-wow-delay="600ms">
            
                                                    <div class="row">
              
              
              
                                                    <div class="col-sm-6">
                
                                                            <form id="main-contact-form" name="contact-form" method="post" action="#">
                  
                                                            <div class="row  wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
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
                                                                <input type="text" name="subject" class="form-control" placeholder="Asunto" required="required">
                                                            </div>
                                                            <div class="form-group">
                                                                <textarea name="message" id="message" class="form-control" rows="4" placeholder="Ingrese su mensaje" required="required"></textarea>
                                                            </div>                        
                                                            <div class="form-group">
                                                                <button type="submit" class="btn-submit">Eviar ahora</button>
                                                            </div>
                                                        </form>   
                                                    </div>
                                                    <div class="col-sm-6">
                                                            <div class="contact-info wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                  
                                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>
                                                            <ul class="address">
                                                                <li><i class="fa fa-map-marker"></i> <span> Address:</span> 2400 South Avenue A </li>
                                                                <li><i class="fa fa-phone"></i> <span> Phone:</span> +928 336 2000  </li>
                                                                <li><i class="fa fa-envelope"></i> <span> Email:</span><a href="mailto:someone@yoursite.com"> support@oxygen.com</a></li>
                                                                <li><i class="fa fa-globe"></i> <span> Website:</span> <a href="#">www.sitename.com</a></li>
                                                            </ul>
                                                        </div>                            
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>   
        <!-- <div id="google-map" class="wow fadeIn" data-latitude="52.365629" data-longitude="4.871331" data-wow-duration="1000ms" data-wow-delay="400ms"></div>     -->
        <div id="google-map">
            <iframe scrolling="no" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3348.1441195581438!2d-60.64096080000006!3d-32.94720419999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95b7ab0fef47530f%3A0xb7b9732d2220d371!2sIGA+Instituto+Gastron%C3%B3mico+de+las+Am%C3%A9ricas!5e0!3m2!1ses-419!2sar!4v1442353059311" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
                                    </div>      
                            </section><!--/#contact-->
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
                                            <div class="col-sm-3">
                                                <p><a href="http://www.lifeweb.com.ar/">Quiero trabajar en IGA</a></p>
                                            </div>
              
                                            <div class="col-sm-3">
                                                <p><a href="http://www.lifeweb.com.ar/">Quiero una Franquisia de IGA</a></p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="pull-right">&copy; 2015 Designed by <a href="http://www.lifeweb.com.ar/">lifeWEB</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </footer>
      
                            <script type="text/javascript" src="js/jquery.js"></script>
                            <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script> -->
                            <script type="text/javascript" src="js/jquery.inview.min.js"></script>
                            <script type="text/javascript" src="js/wow.min.js"></script>
                            <script type="text/javascript" src="js/mousescroll.js"></script>
                            <script type="text/javascript" src="js/smoothscroll.js"></script>
                            <script type="text/javascript" src="js/jquery.countTo.js"></script>
                            <script type="text/javascript" src="js/lightbox.min.js"></script>
                            <script type="text/javascript" src="js/main.js"></script>
      
                            </body>
                            </html>
