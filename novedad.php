<?php
session_start();
include_once 'gestor/includes/functions.php';
include_once 'gestor/includes/lenguaje.php';

$pagina = 'novedades';

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
$categoria = getCategoriasNovedades($mysqli, $novedad['categoria']);
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
        <?php 
            include_once 'gestor/includes/header.php';
        ?>
        
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
                        <img class="img-responsive" src="images/novedades/<?=$novedad['imagen']?>" />
                        <h3><?=$novedad['titulo']?></h3>
                        <div style="text-align: justify">
                            <?=$novedad['descripcion']?>
                        </div>
                        <div class="row">
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <div class="col-md-6 social-icons" style="width: 100%;">
                                            <ul>
                                                <li><a class="facebook" href="https://www.facebook.com/IGA.GASTRONOMIA" target="_blank"><i class="fa fa-facebook"></i></a></li>  
                                                <li><a class="twitter" href="https://twitter.com/IGA_LA" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                                <li><a class="envelope" href="https://www.facebook.com/IGA.GASTRONOMIA" target="_blank"><i class="fa fa-google"></i></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-4" style="margin-bottom: 10px;">
                        <h2><?=$categoria[0]['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']]?></h2>
                    <?php
                        $novedades = getNovedades($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['id_idioma'], false, false, $novedad['categoria']);
                        foreach ($novedades as $nov)
                        {
                            $estiloTextos = 'font-size: 15px;';
                            $estiloImagen = 'margin-bottom: 5px;'; ?>
                            <div class="row">
                                <a href="novedad.php?id=<?=$nov['id']?>"><img style="<?=$estiloImagen?>" class="img-responsive" src="images/novedades/<?=$nov['imagen']?>" /></a>
                                <a href="novedad.php?id=<?=$nov['id']?>"><span style="<?=$estiloTextos?>"><?=$nov['titulo']?></span></a>
                                <br/>
                                <br/>
                            </div>
                    <?php 
                        }
                    ?>
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
