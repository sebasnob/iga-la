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
}
if(!isset($_SESSION['idioma_seleccionado']['idioma']))
{
    $_SESSION['idioma_seleccionado']['idioma'] = $_SESSION['pais']['idioma'];
}
if(!isset($_SESSION['idioma_seleccionado']['id_idioma']))
{
    $_SESSION['idioma_seleccionado']['id_idioma'] = $_SESSION['pais']['id_idioma'];
}
    
$paises = getPaises($mysqli);
$idiomas = getIdiomas($mysqli, false, $_SESSION['pais']['id']);
$provincias = getProvincias($mysqli, $_SESSION['pais']['id']);
$auspiciantes = getAuspiciantes($mysqli);
$novedades = getNovedades($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['id_idioma']);
$novedad = getNovedad($mysqli, $_GET['id']);
    
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
     
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
            
        <!-- <link rel="stylesheet" type="text/css" media="screen" href="styles_home.php" />-->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
            
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="images/favicon.ico">
    </head><!--/head-->
        
    <body>
        <div class="fullParaCerrarMenu"></div>
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
                            <li class="scroll active"><a href="index.php"><?=$lenguaje['inicio_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                            <li id="cursos"><?=$lenguaje['curso_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></li>
                            <li class="scroll"><a href="index.php#team"><?=$lenguaje['institucional_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>  
                            <li class="scroll"><a href="index.php#contact"><?=$lenguaje['contacto_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
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
                                    <li><a href="javascript:cambiarPais('<?=$d['cod_pais']?>')" ><img src="<?=$d['flag']?>" /><span style="margin-left: 5px;"> <?=$d['pais']?></span></a></li>
                                <?php
                                    }
                                }
                                ?>
                                </ul>
                            </li>
                            <li style="padding: 5px;">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?=$_SESSION['idioma_seleccionado']['idioma']?> 
                                    <?php if(count($idiomas) > 1) { ?>
                                    <span class="caret"></span>
                                    <?php } ?>
                                </a>
                                <?php if(count($idiomas) > 1) { ?>
                                <ul class="dropdown-menu">
                                <?php
                                    foreach($idiomas as $i=>$d){
                                        if($_SESSION['idioma_seleccionado']['cod_idioma'] != $d['cod_idioma']){
                                    ?>
                                    <li>
                                        <a href="javascript:cambiarIdioma('<?=$d['cod_idioma']?>')" >
                                                <?=$d['idioma']?> 
                                        </a>
                                    </li>
                                    <?php
                                        }
                                    }
                                ?>
                                    <?php
                                }
                                ?>
                                </ul>
                            </li>
                                
                        </ul>
                    </div>
                </div>
                <div id="desplegableCursos">
                    <ul class="nav" style="float: left">
                        <li class="menuCursos">
                            <a href="cursos.php?cod_curso=1">
                                <?=$lenguaje['gastro_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> 
                            </a>
                        </li>
                        <li class="menuCursos">
                            <a href="cursos.php?cod_curso=63">
                                <?=$lenguaje['certif_gastro_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> 
                            </a>
                        </li>
                        <li class="menuCursos">
                            <a href="cursos.php?cod_curso=17">
                                <?=$lenguaje['cocineritos_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> 
                            </a>
                        </li>
                    </ul>
                    <ul class="nav" style="float: right">
                        <li class="menuCursos">
                            <a href="cursos.php?cod_curso=31">
                                <?=$lenguaje['paste_avanzada_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> 
                            </a>
                        </li>
                        <li class="menuCursos">
                            <a href="cursos.php?cod_curso=95">
                                <?=$lenguaje['gastro_intensivo_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> 
                            </a>
                        </li>
                        <li class="menuCursos">
                            <a href="cursos_cortos.php">
                                <?=$lenguaje['cursos_cortos_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> 
                            </a>
                        </li>
                    </ul>
                </div>
            </div><!--/#main-nav-->
        </header>
            
        <section id="novedad">
                <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
                    <h2><?=$novedad['titulo']?></h2>
                    <img src="images/novedades/<?=$novedad['imagen']?>" class="img-responsive img-novedad" />
                    <p><?=$novedad['descripcion']?></p>
                </div>
        </section>
            
        <section id="blog">
            <div class="container">
                <div class="row">
                    <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
                        <h2><?=$lenguaje['mas_novedades_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h2>
                    </div>
                </div>
                    
                <!-- noticias -->
                <div class="blog-posts">
                    <div class="row">
                        <?php
                        foreach ($novedades as $id=>$data){
                        ?>
                        <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <div class="post-thumb">
                                <img class="img-responsive" src="images/novedades/<?=$data['imagen']?>" alt="">
                            </div>
                            <div class="entry-header">
                                <h3><a href="#"><?=$data['titulo']?></a></h3>
                            </div>
                            <div class="entry-content">
                                <span>
                                    <?=substr($data['descripcion'],0,250) . '...'?>
                                </span>
                                <br>
                                <span>
                                    <a href="novedades.php?id=<?=$data['id']?>">
                                        <?=$lenguaje['ver_mas_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>
                                    </a>
                                </span>
                                    
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <!-- fin noticias -->
            </div>
        </section><!--/#blog-->
            
        <footer id="footer">
            <div class="footer-top wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                <div class="container text-center">
                    <div class="footer-logo">
                        <a href="index.php"><img class="img-responsive" src="images/logo-iga_transparent.png" alt=""></a>
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
                <div class="container text-center">
                    <?php foreach ($auspiciantes as $auspiciante){ 
                        if(in_array($_SESSION['pais']['id'], $auspiciante['cod_pais']))
                        {
                            $tienQueAparecer = true;
                    ?>
                    <div class="footer-logo">
                        <a href="<?= $auspiciante['link']?>">
                            <img class="img-responsive" 
                                 src="<?= $auspiciante['url_img']?>" 
                                 alt="<?= $auspiciante['nombre']?>" 
                                 style="max-width: 100px;"
                                 />
                        </a>
                    </div>
                    <?php 
                        }
                    } ?>
                </div>    
            </div>
            <div class="arrowTop"><i class="fa fa-arrow-circle-o-up"></i></div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 text-center">
                            <p><a href="http://www.iga-la.com/empleos/" target="_blank"><?=$lenguaje['quiero_trabajar_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></p>
                        </div>
                            
                        <div class="col-sm-4 text-center">
                            <p><a href="http://igafranchising.com/" target="_blank"><?=$lenguaje['quiero_una_franquicia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></p>
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
            
    </body>
</html>    