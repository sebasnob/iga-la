<?php
session_start();
include_once 'gestor/includes/functions.php';
include_once 'gestor/includes/lenguaje.php';

//unset($_SESSION);
if(!isset($_SESSION['pais']))
{
    detectCountry($mysqli);
}
if(!isset($_SESSION['idioma_seleccionado']['cod_idioma']))
{
    $_SESSION['idioma_seleccionado']['cod_idioma'] = $_SESSION['pais']['cod_idioma'];
    $_SESSION['idioma_seleccionado']['idioma'] = $_SESSION['pais']['idioma'];
}

$paises = getPaises($mysqli);
$datos_home = getDatosHome($mysqli);
$idiomas = getIdiomas($mysqli);
$provincias = getProvincias($mysqli, $_SESSION['pais']['id']);
$slider = getSlider($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['cod_idioma']);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="lifeweb.com.ar">
        <title><?=$lenguaje['titulo_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></title>
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
            $gridArray = getImagenesGrilla($mysqli, $_SESSION['idioma_seleccionado']['cod_idioma'], $_SESSION['pais']['id']);
        ?>
    </head><!--/head-->
    
    <body>
        <div id="fb-root"></div>
        <!--.preloader-->
        <div class="preloader"> <i class="fa fa-circle-o-notch fa-spin"></i></div>
        <!--/.preloader-->
        
        <header id="home">
            <div id="home-slider" class="container-fluid">
                <div class="caption">
                    <h1 class="animated fadeInLeftBig">
                    <?php
                    switch($_SESSION['idioma_seleccionado']['cod_idioma']){
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
                    switch($_SESSION['idioma_seleccionado']['cod_idioma']){
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
                    <a data-scroll class="btn btn-start animated fadeInUpBig" href="#slider">
                        <?php switch($_SESSION['idioma_seleccionado']['cod_idioma'])
                        {
                            case 'IN':
                                echo 'What do you want to learn today ?';
                            break;
                            case 'POR':
                                echo 'Você quer aprender hoje?';
                            break;
                            default: 
                                echo 'Que Deseas aprender hoy?';
                            break;
                        }
                        ?>
                    </a>
                </div>
                <div class="embed-responsive embed-responsive-16by9 ">
                    <div id="background">
                        
                         <!--<iframe id='player' width="100%" height="100%" src="<?=$datos_home['url_video']?>" frameborder="0" volumen="0" class="hidden-sm hidden-xs"></iframe>-->
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
                            <li class="scroll active"><a href="#home"><?=$lenguaje['inicio_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                            <li class="scroll"><a href="#portfolio"><?=$lenguaje['curso_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                            
                            <li class="scroll"><a href="#blog"><?=$lenguaje['novedades_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                            <li class="scroll"><a href="#team"><?=$lenguaje['institucional_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>  
                            <li class="scroll"><a href="#contact"><?=$lenguaje['contacto_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                            <li><a href="http://campus.igacloud.net/" target="_blank"><?=$lenguaje['campus_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></a></li> 
                        </ul>
                        
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?=$_SESSION['pais']['flag']?>" /><span style="margin-left: 5px;"><?=$_SESSION['pais']['pais']?></span><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                <?php
                                foreach($paises as $i=>$d){
                                    if($_SESSION['pais']['cod_pais'] != $d['cod_pais']){
                                ?>
                                    <li><a href="javascript:cambiarPais('<?=$d['cod_pais']?>')" ><img src="<?=$d['flag']?>" /><?=$d['pais']?></a></li>
                                <?php
                                    }
                                }
                                ?>
                                </ul>
                            </li>
                            <li style="padding: 5px;">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?=$_SESSION['idioma_seleccionado']['idioma']?> 
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                <?php
                                    foreach($idiomas as $i=>$d){
                                        if($_SESSION['idioma_seleccionado']['cod_idioma'] != $d['cod_idioma']){
                                    ?>
                                    <li>
                                        <a href="javascript:cambiarIdioma('<?=$d['cod_idioma']?>')" >
                                                <?=$d['idioma']?> 
                                            <span class="caret"></span>
                                        </a>
                                    </li>
                                    <?php
                                    }
                                }
                                ?>
                                </ul>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div><!--/#main-nav-->
            
        </header><!--/#home-->
        
        <div id="slider" class="carousel slide carousel-fade" data-ride="carousel">
            <div class="carousel-inner" style="cursor:pointer">
                <?php $i=0; foreach ($slider as $slid){?>
                <div 
                        class="item <?php if($i == 0){echo 'active';}?>" 
                        <?php if(isset($slid['link']) && $slid['link'] != '')
                        {
                            echo "onclick=";
                            echo "javascript:iralink('{$slid['link']}')";
                                    
                        } ?>
                        title='<?= $slid['alt'];?>' 
                        style="background-image: url(<?= $slid['url'];?>)">
                </div>
                <?php $i++;} ?>
            </div>
            <a class="left-control" href="#slider" data-slide="prev"><i class="fa fa-angle-left"></i></a>
            <a class="right-control" href="#slider" data-slide="next"><i class="fa fa-angle-right"></i></a>
        </div><!--/#home-slider-->
        
        <section id="portfolio">
            <div class="container-fluid">
                <div class="row">
                    <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <h2><?=$lenguaje['pasion_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h2>
                        <p><?=$lenguaje['cursos_destacados_'.$_SESSION['idioma_seleccionado']['cod_idioma']]?></p>
                    </div>
                </div> 
            </div>
            <div class="container-fluid" id="grilla">
                <div class="row">
                    <?php 
                    if(!$gridArray){
                        echo "  No existen cursos disponibles para el pais seleccionado.";
                    }else{
                        foreach ($gridArray as $imgGrid){
                    ?>
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
                    <?php 
                        }
                     
                    ?>
                </div>
            </div> <!--/#container-fluid-porfolios-->
            <div id="portfolio-single-wrap">
                <?php foreach ($gridArray as $imgGrid){
                    
                    $nombre_defecto = $lenguaje['nombre_defecto_'.$_SESSION['idioma_seleccionado']['cod_idioma']];
                    $duracion_defecto = $lenguaje['duracion_defecto_'.$_SESSION['idioma_seleccionado']['cod_idioma']];
                    $descripcion_defecto = $lenguaje['descripcion_defecto_'.$_SESSION['idioma_seleccionado']['cod_idioma']];
                    $cursos_datos = getCursosDatos($mysqli, $imgGrid['id_curso'], $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['cod_idioma'], $nombre_defecto, $duracion_defecto, $descripcion_defecto);
                ?>
                
                <div id="single-portfolio" class="container collapse curso curso<?php echo $imgGrid['id_curso']?>">
                    <div class="row">
                        <div class="col-sm-12">
                            <img class="img-responsive animated fadeInDown" src="<?= $cursos_datos['url_cabecera']?>" alt="">
                            <div class="col-sm-9">
                                <div class="project-info">
                                    <h2><a href="cursos.php?cod_curso=<?php echo $imgGrid['id_curso']?>"><?= $cursos_datos['nombre']?></a></h2>
                                    <div class="entry-meta">
                                        
                                        <span>
                                            <i class="fa fa-calendar"></i>&nbsp;Duración: 
                                            <?php echo ($cursos_datos['horas'] != '' && $cursos_datos['horas'] != 0)? $cursos_datos['horas']." horas": ''; ?>
                                            <?php echo ($cursos_datos['meses'] != '' && $cursos_datos['meses'] != 0)? ", ".$cursos_datos['meses']." meses": ''; ?>
                                            <?php echo ($cursos_datos['anios'] != '' && $cursos_datos['anios'] != 0)? ", ".$cursos_datos['anios']." años": ''; ?>
                                        </span>
                                        
                                    </div>
                                    <p class="lead"><?= $cursos_datos['descripcion']?></p>
                                </div>
                            </div>
                            
                            <div class="col-sm-3">
                                <div class="project-details">
                                    <img class="img-responsive" src="<?php echo $imgGrid['img_url']?>" alt="">
                                    <!--
                                    <h3><?php //$lenguaje['uniformes_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h3>
                                    <p><img class="img-responsive animated fadeInDown" src="<?php //$cursos_datos['url_uniforme']?>" alt=""></p>
                                    <h3><?php //$lenguaje['materiales_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h3>
                                    <p><img class="img-responsive animated fadeInDown" src="<?php //$cursos_datos['url_material']?>" alt=""></p>
                                    -->
                                </div>  
                            </div>
                            
                            <div class="col-sm-12"><a href="cursos.php?cod_curso=<?php echo $imgGrid['id_curso']?>">Click aquí para más informacion</a></div>
                        </div>
                        <a href="javascript:cerrarCurso();" class="close-folio-item2" ><i class="fa fa-times"></i></a>
                        
                    </div>
                </div>
                <?php 
                    } 
                }
                ?>
            </div>
            
        </section><!--/#portfolio-->
        
        <section id="blog">
            <div class="container">
                <div class="row">
                    <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
                        <h2><?=$lenguaje['novedades_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h2>
                        <p><?=$lenguaje['encontranos_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
                    </div>
                </div>
                <div class="blog-posts">
                    <div class="row">
                        <div class="col-sm-6 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <div class="fb-page" data-href="https://www.facebook.com/IGA.GASTRONOMIA" data-width="500" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true">
                                <div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/IGA.GASTRONOMIA"><a href="https://www.facebook.com/IGA.GASTRONOMIA">IGA</a></blockquote>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="600ms">
                            <a class="twitter-timeline" href="https://twitter.com/IGA_LA" data-widget-id="650168451454119936">Tweets por el @IGA_LA.</a>
                            
                            
                        </div>
                        
                    </div>
                    
                </div>
                
                
                <div class="row">
                    <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
                        <h2>Novedades</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua ut enim ad minim veniam</p>
                    </div>
                </div>
                <div class="blog-posts">
                    <div class="row">
                        <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <div class="post-thumb">
                                <a href="#"><img class="img-responsive" src="images/blog/1.jpg" alt=""></a> 
                            </div>
                            <div class="entry-header">
                                <h3><a href="#">Lorem ipsum dolor sit amet consectetur adipisicing elit</a></h3>
                            </div>
                            <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                        <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <div class="post-thumb">
                                <a href="#"><img class="img-responsive" src="images/blog/1.jpg" alt=""></a> 
                            </div>
                            <div class="entry-header">
                                <h3><a href="#">Lorem ipsum dolor sit amet consectetur adipisicing elit</a></h3>
                            </div>
                            <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                        <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <div class="post-thumb">
                                <a href="#"><img class="img-responsive" src="images/blog/1.jpg" alt=""></a> 
                            </div>
                            <div class="entry-header">
                                <h3><a href="#">Lorem ipsum dolor sit amet consectetur adipisicing elit</a></h3>
                            </div>
                            <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            
            
        </div>
        
    </section><!--/#blog-->
    
    <section id="features" class="parallax">
        <div class="container">
            <div class="row count">
                <div class="col-sm-3 col-xs-6 wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <i class="fa fa-user"></i>
                    <h3 class="timer">4000</h3>
                    <p><?=$lenguaje['alumnos_felices_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
                </div>
                <div class="col-sm-3 col-xs-6 wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="500ms">
                    <i class="fa fa-home"></i>
                    <h3 class="timer">200</h3>                    
                    <p><?=$lenguaje['filiales_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
                </div> 
                <div class="col-sm-3 col-xs-6 wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="700ms">
                    <i class="fa fa-folder-o"></i>
                    <h3 class="timer">10</h3>                    
                    <p><?=$lenguaje['cursos_disponibles_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
                </div> 
                <div class="col-sm-3 col-xs-6 wow fadeInLeft" data-wow-duration="1000ms" data-wow-delay="900ms">
                    <i class="fa fa-comment-o"></i>                    
                    <h3>24/7</h3>
                    <p><?=$lenguaje['consultas_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
                </div>                 
            </div>
        </div>
    </section><!--/#features-->
    
    
    
    
    
    
    
    <section id="team">
        <div class="container">
            <div class="row">
                <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
                    <h2>IGA</h2>
                    <p><?=$lenguaje['capacitamos_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
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
                                <h3><?=$lenguaje['lared_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h3>
                                
                                <p><?=$lenguaje['lared_desc_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="500ms">
                            <div class="member-image">
                                <img class="img-responsive" src="images/team/2.jpg" alt="">
                            </div>
                            <div class="member-info">
                                <h3><?=$lenguaje['mision_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h3>
                                <p><?=$lenguaje['mision_desc_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="800ms">
                            <div class="member-image">
                                <img class="img-responsive" src="images/team/3.jpg" alt="">
                            </div>
                            <div class="member-info">
                                <h3><?=$lenguaje['vision_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h3>
                                <p><?=$lenguaje['vision_desc_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
                            </div>
                            
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="1100ms">
                            <div class="member-image">
                                <img class="img-responsive" src="images/team/4.jpg" alt="">
                            </div>
                            <div class="member-info">
                                    <?=$lenguaje['valores_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </section><!--/#team-->
    
    
    <section id="contact">
        
        <div id="contact-us" >
            <div class="container">
                <div class="row">
                    <div class="heading text-center wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <h2><?=$lenguaje['contactate_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h2>
                        <br/>
                        <div class="col-sm-12 text-center wow fadeIn" id="select_filial">
                            <form id="filter-form" name="filter-form" method="post" action="#" class="form-inline">
                                <div class="form-group">
                                    <b><?=$lenguaje['encontra_tu_iga_en_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?><?=$_SESSION['pais']['pais']?></b>&nbsp;
                                    <!--<label for="option"><?=$lenguaje['provincia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></label>-->
                                    <select id="provincias" class="form-control" onchange="javascript:cambiarProvincia('<option><?=$lenguaje["seleccione_filial_".$_SESSION["idioma_seleccionado"]["cod_idioma"]] ?></option>')">
                                        <option value="0"><?=$lenguaje['seleccione_provincia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></option>  
                                        <?php foreach ($provincias as $provincia){?>
                                        <option value="<?=$provincia['id']?>"><?=$provincia['nombre']?></option>    
                                        <?php }?>
                                    </select>    
                                </div>
                                <div class="form-group">
                                    <!--<label for="option"><?=$lenguaje['filiales_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></label>-->
                                    <select id="filiales" class="form-control" onchange="javascript:filialSeleccionada()">
                                        <option><?=$lenguaje['seleccione_filial_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></option>
                                    </select>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-5" style="display: none" id="direccion_filial">
                            <div class="contact-info">
                                <ul class="address">
                                    <li><i class="fa fa-map-marker"></i> <span><?=$lenguaje['direccion_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>: </span><span id="direccion"></span> </li>
                                    <li><i class="fa fa-phone"></i> <span><?=$lenguaje['telefono_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>: </span><span id="telefono"></span></li>
                                    <li><i class="fa fa-envelope"></i> <span><?=$lenguaje['mail_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>: </span><span id="mail"></span></li>
                                </ul>
                            </div>                            
                        </div>
                    </div>
                    <br/>
                    <div class="contact-form" style="display:none">
                        <div class="row">
                            <form id="main-contact-form" name="contact-form" method="post" action="sendemail.php">
                                <div class="col-sm-4">
                                    <input type="hidden" value="" id="correo" name="correo">
                                    <div class="row">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="<?=$lenguaje['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>" required="required">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="<?=$lenguaje['mail_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>" required="required">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="phone" class="form-control" placeholder="<?=$lenguaje['telefono_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1">&nbsp;</div>
                                <div class="col-sm-7">
                                    <div class="row">
                                        <div class="form-group form-inline">
                                            <select class="form-control" name="subject">
                                                <option value="">Elegi una opción</option>
                                                <option value="3">Cursos</option>
                                                <option value="4">Atencion al alumno</option>
                                            </select>
                                            &nbsp;
                                            <select class="form-control" name="cursos_contacto">
                                                <option value="">Elegi una opción</option>
                                                <option value="3">Gastronomia y Alta Cocina</option>
                                                <option value="4">Gastronomia y Alta Cocina 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <textarea name="message" id="message" class="form-control" rows="2" placeholder="<?=$lenguaje['mensaje_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>" required="required"></textarea>
                                        </div>                        
                                        <div class="form-group">
                                            <button type="submit" class="btn-submit"><?=$lenguaje['enviar_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>   
            <!-- <div id="google-map" data-latitude="52.365629" data-longitude="4.871331" class="hidden"></div>-->
            <!-- <div id="google-map">
                <iframe style="pointer-events:none; width: 100%" scrolling="no" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3348.1441195581438!2d-60.64096080000006!3d-32.94720419999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x95b7ab0fef47530f%3A0xb7b9732d2220d371!2sIGA+Instituto+Gastron%C3%B3mico+de+las+Am%C3%A9ricas!5e0!3m2!1ses-419!2sar!4v1442353059311" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>-->
            <div id="google-map" style="display: none"></div>
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
                    <div class="col-sm-4 text-center">
                        <p><a href="http://www.iga-la.com/empleos/" target="_blank"><?=$lenguaje['quiero_trabajar_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></p>
                    </div>
                    
                    <div class="col-sm-4 text-center">
                        <p><a href="http://igafranchising.com/" target="_blank"><?=$lenguaje['quiero_una_franquisia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></p>
                    </div>
                    <div class="col-sm-4 text-center">
                        <p>&copy; 2015 Designed by <a href="http://www.lifeweb.com.ar/">lifeWEB</a></p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="js/jquery.inview.min.js"></script>
    <script type="text/javascript" src="js/wow.min.js"></script>
    <script type="text/javascript" src="js/mousescroll.js"></script>
    <script type="text/javascript" src="js/smoothscroll.js"></script>
    <script type="text/javascript" src="js/jquery.countTo.js"></script>
    <script type="text/javascript" src="js/lightbox.min.js"></script>
    <script type="text/javascript" src="js/main.js"></script>
    <!-- Plugins Facebook -->
    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v2.4";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
    <!-- Plugins Twitter -->
    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
    <script>
    $('#filiales').change(function(){
        $('#direccion_filial').fadeIn("slow");
        $('#select_filial').removeClass("col-sm-12");
        $('#select_filial').addClass("col-sm-7");
    });
    </script>
</body>
</html>
