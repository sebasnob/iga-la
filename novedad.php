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
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" id="colapseButton" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
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
                            <li class="scroll"><a href="index.php#blog"><?=$lenguaje['novedades_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                            <li class="scroll"><a href="index.php#team"><?=$lenguaje['institucional_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>  
                            <li class="scroll"><a href="index.php#contact"><?=$lenguaje['contacto_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                            <li><a href="http://campus.igacloud.net/" target="_blank"><?=$lenguaje['campus_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></a></li> 
                        </ul>
                        
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?=$_SESSION['pais']['flag']?>" /><span style="margin-left: 5px;"><?=substr($_SESSION['pais']['pais'], 0, 3)?></span><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                <?php
                                foreach($paises as $i=>$d){
                                    if($_SESSION['pais']['cod_pais'] != $d['cod_pais']){
                                ?>
                                    <li><a href="javascript:cambiarPais('<?=$d['cod_pais']?>')" ><img src="<?=$d['flag']?>" /><span style="margin-left: 5px;"> <?=substr($d['pais'], 0, 3)?></span></a></li>
                                <?php
                                    }
                                }
                                ?>
                                </ul>
                            </li>
                            <?php if(count($idiomas) > 1) { ?>
                            <li style="padding: 5px;">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?=substr($lenguaje[$_SESSION['idioma_seleccionado']['idioma'].'_'.$_SESSION['idioma_seleccionado']['cod_idioma']], 0, 2)?> 
                                    <?php if(count($idiomas) > 1) { ?>
                                        <span class="caret"></span>
                                    <?php } ?>
                                </a>
                                <ul class="dropdown-menu">
                                <?php
                                    foreach($idiomas as $i=>$d){
                                        if($_SESSION['idioma_seleccionado']['cod_idioma'] != $d['cod_idioma']){
                                    ?>
                                    <li>
                                        <a href="javascript:cambiarIdioma('<?=$d['cod_idioma']?>')" >
                                                <?=substr($lenguaje[$d['idioma'].'_'.$_SESSION['idioma_seleccionado']['cod_idioma']], 0, 2)?> 
                                        </a>
                                    </li>
                                    <?php
                                        }
                                    }
                                ?>  
                                </ul>
                            </li>
                            <?php
                                }
                            ?>
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
        
        <section id="head_image_curso">
            <div class="container-fluid">
                <img class="img-responsive animated fadeInLeftBig" src="images/slider/20-de-descuento.jpg" alt="" style="width: 100%;">
            </div>
        </section>
        
        <section id="buscador">
            <div class="container">
                <div class="row">
                    
                </div>
            </div>
        </section>
            
        <section id="novedades">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <img src="images/novedades/30923990bb01_3333.jpg" />
                        <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent condimentum pharetra elit id ultrices. Donec pellentesque nec enim in tempus. Aliquam molestie varius nisl et laoreet. Pellentesque dignissim id augue at pharetra. Aenean facilisis ipsum sem. Mauris malesuada non neque sed ornare. Vivamus finibus nec sem sit amet interdum. Aenean orci mauris, venenatis ac pulvinar suscipit, porta id quam. Donec feugiat, dolor nec convallis auctor, turpis odio condimentum turpis, id porta augue nibh at mauris. Proin sit amet dictum velit. Donec odio massa, sagittis quis enim at, venenatis porta neque. Quisque accumsan erat ut massa feugiat vulputate. Vivamus non nulla gravida, luctus est non, gravida ligula. Vestibulum euismod turpis ut leo cursus dapibus. Duis nec eros egestas, fermentum velit quis, scelerisque risus. Nullam consequat eleifend tellus sed efficitur.

Praesent iaculis vitae dolor in ultrices. Nulla ullamcorper, sapien eget pretium ultrices, lacus ligula luctus urna, quis tempus nisl erat a turpis. Praesent pellentesque luctus enim vel mattis. Donec in tincidunt neque, ut porta ante. Fusce ex odio, sollicitudin vel nisi non, varius tincidunt erat. Phasellus ut enim ultricies, cursus nulla vitae, hendrerit justo. Maecenas vehicula hendrerit nisl eu suscipit. Vestibulum suscipit metus at tincidunt dignissim.

Sed id lorem ac elit vulputate condimentum. Duis sit amet libero vehicula, pretium massa quis, aliquet tellus. Aliquam efficitur sollicitudin tellus, ut congue tortor ullamcorper ut. Quisque at est sapien. Sed ac dapibus dui, ut porta nisl. Nulla sed iaculis tortor, id porttitor arcu. Sed fermentum purus a lacus viverra, eget mollis lorem condimentum. Sed aliquet mi vel enim imperdiet convallis. Quisque pharetra vulputate eros. Mauris nulla ligula, tincidunt nec maximus at, ultrices sit amet orci. Maecenas eu augue vel turpis varius imperdiet. Donec varius, erat eget eleifend tristique, tellus libero viverra nibh, nec tempus arcu libero vitae lorem. Morbi et posuere turpis, quis mollis tortor. Nullam tincidunt metus ex, et consequat risus pretium sed. Nullam bibendum, neque non sodales congue, erat massa tristique ex, laoreet faucibus arcu dolor ut arcu. Maecenas enim leo, volutpat vitae elementum ac, lacinia eget purus.

Nulla consectetur enim massa, et tristique mi ullamcorper et. Pellentesque iaculis dolor sed enim cursus iaculis. Morbi blandit ornare ornare. Nam finibus nisl sed accumsan fringilla. Nunc bibendum sapien eget condimentum euismod. Sed id odio rhoncus, semper risus ut, sollicitudin lacus. Aliquam rutrum, velit eu consequat gravida, mi mauris vulputate leo, eget viverra felis dui ut dolor. Donec posuere ullamcorper mauris. Nullam viverra metus id dolor egestas, id finibus velit rhoncus. Nunc condimentum, lorem a condimentum laoreet, felis felis eleifend sem, ultricies congue sapien ante sed erat. Duis et nisi molestie, laoreet lorem sit amet, pharetra nulla.</div>
                    </div>
                    <div class="col-sm-4">
                        <h2>Mas de Actualidad</h2>
                        <div>
                            <img class="img-responsive" src="images/novedades/4e468045cfd7_3333.jpg" />
                            <p>Titulo novedades 11</p>
                        </div>
                        <div>
                            <img class="img-responsive" src="images/novedades/4e468045cfd7_3333.jpg" />
                            <p>Titulo novedades 22</p></div>
                    </div>
                </div>
            </div>
        </section>
            
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
