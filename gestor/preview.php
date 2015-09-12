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

if(isset($_GET['idioma'])){
	$idioma = $_GET['idioma'];
}else{
	$idioma = 'ES';
}

$datos_curso = getDatos($mysqli, $_GET['id_curso'], $idioma);

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
  <link id="../css-preset" href="css/presets/preset1.css" rel="stylesheet">
  <link href="../css/responsive.css" rel="stylesheet">
  
  <link rel="stylesheet" type="text/css" media="screen" href="styles.php?id_curso=<?=$_GET['id_curso']?>">

  <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
  <![endif]-->
  
  <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
  <link rel="shortcut icon" href="images/favicon.ico">
</head><!--/head-->

<body>
<!--
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
          <a class="navbar-brand" href="index.html">
            <h1><img class="img-responsive" src="images/logo-iga.jpg" alt="logo"></h1>
          </a>                    
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-left">     
            <li class="scroll active"><a href="index.html#home">Inicio</a></li>
            <li class="scroll"><a href="index.html#portfolio">Cursos</a></li>
            <li class="scroll"><a href="index.html#about-us">Institucional</a></li>                     
            <li class="scroll"><a href="index.html#blog">Novedades</a></li> 
           <li class="scroll"><a href="index.html#contact">Contacto</a></li>
            <li class="scroll"><a href="#contact">Campus</a></li> 
          </ul>


           <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Login</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Español <span class="caret"></span></a>
           <ul class="dropdown-menu">
            <li><a href="#">Portugues</a></li>
            <li><a href="#">Ingles</a></li>
           </ul>
         </div>
      </div>
    </div><!--/#main-nav

</header><!--/#home-->

 <section id="head_image_curso">
    <div class="container-fluid">
      <div class="row">
        <img class="img-responsive animated fadeInLeftBig" src="<?=$datos_curso['img_cabecera']?>" alt="">
      </div>
    </div>
 </section> 
 
 <section id="single_curso" class="container">
   
        <div class="row">
            <aside class="col-sm-4 col-sm-push-8">
              <div class="widget ads">
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="#"><img class="img-responsive img-rounded" src="../images/ads/ad1.png" alt=""></a>
                        </div>

                        <div class="col-xs-6">
                            <a href="#"><img class="img-responsive img-rounded" src="../images/ads/ad2.png" alt=""></a>
                        </div>
                    </div>
                    <p> </p>
                    <div class="row">
                        <div class="col-xs-6">
                            <a href="#"><img class="img-responsive img-rounded" src="../images/ads/ad3.png" alt=""></a>
                        </div>

                        <div class="col-xs-6">
                            <a href="#"><img class="img-responsive img-rounded" src="../images/ads/ad4.png" alt=""></a>
                        </div>
                    </div>
                </div><!--/.ads-->     

                <div class="widget categories">
                   
                    <div class="row">
                    
       
                    </div>
                       
                                      
                </div><!--/.categories-->
       

            </aside>        
            <div class="col-sm-8 col-sm-pull-4">
                        <section id="curso">
                              <h2><?=$datos_curso['titulo']?></h2>
                              <div class="entry-meta">
                                  
                                  <span><i class="fa fa-calendar"></i> 2 años de duración</span>
                                 
                              </div>
                              <p class="lead">“Gastronomía y Alta Cocina” brinda los conocimientos necesarios para alcanzar la excelencia como profesional de la gastronomía. Además obtendrás las herramientas para emprender un negocio culinario y alcanzar así la cima del éxito, haciendo de la cocina tu profesión.</p>

                              <p>Convertite en un profesional de la alta cocina y del arte culinario! Encabezá un equipo de cocineros en un negocio culinario de altísimo nivel!</p>

                              <p>Cursado el 1º año recibís el certificado de COCINERO PROFESIONAL
                              <br>Cursado el 2º año recibís el certificado de GASTRONOMÍA & ALTA COCINA</p>
                         </section>
                           <hr>

                          <section id="cursado_planes">
                            <h3>Cursado y plan de pagos</h3>
                            <p>Para ver los inicios de clases, los horarios de cursado y las formas de pago, seleccione una provincia y un local.</p>
                            <form id="filter-form" name="filter-form" method="post" action="#" class="form-inline">
                              <div class="form-group">
                             <label for="option">Provincia</label>
                              <select class="form-control">
                                 <option>Santa Fe</option>
                                 <option>opcion 2</option>
                             </select>
                             </div>
                             
                              <div class="form-group">
                                <label for="option">Localidad</label>
                               <select class="form-control">
                                <option>Rosario</option>
                                <option>opcion 2</option>
                              </select>
                             </div> 
                            <button type="submit" class="btn-btn-default">Consultar</button>
                            </form>

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
                          </section>

                            <hr>
                        <section id="meterial_curso" >

                        <h3>Material del curso</h3>

                            <div class="well">
                                <div class="media">
                                    <div class="pull-left">
                                        <img class="avatar img-thumbnail" src="images/blog/avatar.jpg" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-heading">
                                            <strong>Cada curso de IGA</strong>
                                        </div>
                                        <p>está respaldado por un material de estudio de primerísimo nivel y calidad, elaborado por profesionales altamente capacitados en el área de la gastronomía y la educación.<br>

El alumno que cursa “Gastronomía y Alta Cocina” dispone de libros de excelencia; un tomo por cuatrimestre, cuatro libros en total. Los mismos contienen cada una de las materias de la currícula, incluidas las denominadas prácticas en las cuales se desarrollan las principales recetas paso a paso acompañadas de fotos full color.</p>
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
                                        <img class="avatar img-thumbnail" src="images/blog/avatar2.jpg" alt="">
                                    </div>
                                    <div class="media-body">
                                        <div class="media-heading">
                                            <strong>Con la inscripción al curso,</strong>
                                        </div>
                                        <p>IGA hace entrega de un uniforme completo de cocinero, compuesto por un delantal, un gorro y una chaqueta.<br>
                                        El alumno recibirá dos uniformes, uno para el primer año de cursado y otro para el segundo año.
                                        </p>
                                    </div>
                                </div>
                            </div><!--/.author-->
                        </section>

                 
                </div><!--/.col-md-8-->
                 <div class="col-md-12">
                         <section id="objetivo">
                            <h2>Nuestro Objetivo</h2>
                            <div class="entry-meta">
                              <span><i class="fa fa-calendar"></i> 2 años de duración</span>
                            </div>
                            <p class="lead">Brindar una formación integral para desarrollar las destrezas necesarias de una profesión que posibilite insertarse rápidamente en el mercado laboral.<br>

                                Difundir nuestra gastronomía alrededor del mundo, participando activamente en eventos nacionales e internacionales.<br>

                                Preparar al alumno para ser excelente Chef y proveerlo de todos los conocimientos necesarios para ser un emprendedor exitoso.
                            </p>
                          </section>
                </div>
        </div><!--/.row-->
</section><!--/#single_cursos-->

  <section id="feature_cursos" class="container">
  <h2>OTROS CURSOS</h2>

        <ul class="portfolio-items col-3">
            <li class="portfolio-item apps">
                <div class="item-inner">
                    <img src="../images/portfolio/thumb/item1.jpg" alt="">
                    <h5>Lorem ipsum dolor sit amet</h5>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="" rel="prettyPhoto"><i class="fa fa-search-plus"></i></a>             
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
            <li class="portfolio-item joomla bootstrap">
                <div class="item-inner">
                    <img src="../images/portfolio/thumb/item2.jpg" alt="">
                    <h5>Lorem ipsum dolor sit amet</h5>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="images/portfolio/full/item2.jpg" rel="prettyPhoto"><i class="fa fa-search-plus"></i></a>              
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
            <li class="portfolio-item bootstrap wordpress">
                <div class="item-inner">
                    <img src="../images/portfolio/thumb/item3.jpg" alt="">
                    <h5>Lorem ipsum dolor sit amet</h5>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="images/portfolio/full/item3.jpg" rel="prettyPhoto"><i class="fa fa-search-plus"></i></a>        
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
            <li class="portfolio-item joomla wordpress apps">
                <div class="item-inner">
                    <img src="../images/portfolio/thumb/item4.jpg" alt="">
                    <h5>Lorem ipsum dolor sit amet</h5>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="images/portfolio/full/item4.jpg" rel="prettyPhoto"><i class="fa fa-search-plus"></i></a>          
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
            <li class="portfolio-item joomla html">
                <div class="item-inner">
                    <img src="../images/portfolio/thumb/item5.jpg" alt="">
                    <h5>Lorem ipsum dolor sit amet</h5>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="images/portfolio/full/item5.jpg" rel="prettyPhoto"><i class="fa fa-search-plus"></i></a>          
                    </div>    
                </div>       
            </li><!--/.portfolio-item-->
            <li class="portfolio-item wordpress html">
                <div class="item-inner">
                    <img src="../images/portfolio/thumb/item6.jpg" alt="">
                    <h5>Lorem ipsum dolor sit amet</h5>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="images/portfolio/full/item6.jpg" rel="prettyPhoto"><i class="fa fa-search-plus"></i></a>           
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->
        </ul>
    </section><!--/#portfolio-->


<footer id="footer">
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

  <script type="text/javascript" src="../js/jquery.js"></script>
  <script type="text/javascript" src="../js/bootstrap.min.js"></script>
  <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
  <script type="text/javascript" src="../js/jquery.inview.min.js"></script>
  <script type="text/javascript" src="../js/wow.min.js"></script>
  <script type="text/javascript" src="../js/mousescroll.js"></script>
  <script type="text/javascript" src="../js/smoothscroll.js"></script>
  <script type="text/javascript" src="../js/jquery.countTo.js"></script>
  <script type="text/javascript" src="../js/lightbox.min.js"></script>
  <script type="text/javascript" src="../js/main.js"></script>
 
</body>
</html>