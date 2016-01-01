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
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <meta property="og:url"                content="http://www.m2000364.ferozo.com/ejemplos/IGA/iga-la/novedad.php?id=<?=$_GET['id']?>" />
        <meta property="og:type"               content="article" />
        <meta property="og:title"              content="<?=$novedad['titulo']?>" />
        <meta property="og:description"        content="<?=$novedad['descripcion']?>" />
        <meta property="og:image"              content="http://www.m2000364.ferozo.com/ejemplos/IGA/iga-la/images/novedades/<?=$novedad['imagen']?>" />
        
        <meta property="og:type" content="article" />
        <meta property="og:url" content="<?= 'http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]?>" />
        <meta property="og:title" content="<?=$novedad['titulo']?>" />
        <meta property="og:description" content="<?=$novedad['descripcion']?>" />
        <meta property="og:image" content="images/novedades/<?=$novedad['imagen']?>" />
        <meta property="og:image:width" content="250" />
        <meta property="og:image:height" content="140" />
        <title><?=$lenguaje['titulo_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/animate.min.css" rel="stylesheet" />
        <link href="css/font-awesome.min.css" rel="stylesheet" />
        <link href="css/lightbox.css" rel="stylesheet" />
        <link href="css/main.css" rel="stylesheet" />
        <link id="css-preset" href="css/presets/preset1.css" rel="stylesheet" />
        <link href="css/responsive.css" rel="stylesheet" />
            
        <!-- <link rel="stylesheet" type="text/css" media="screen" href="styles_home.php" />-->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
        
            
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css' />
        <link rel="shortcut icon" href="images/favicon.ico" />
        
        <div id="fb-root"></div>
        
        <script>
            window.fbAsyncInit = function() {
              FB.init({
                appId      : '1043650382373771',
                xfbml      : true,
                version    : 'v2.5'
              });
            };

            (function(d, s, id){
               var js, fjs = d.getElementsByTagName(s)[0];
               if (d.getElementById(id)) {return;}
               js = d.createElement(s); js.id = id;
               js.src = "//connect.facebook.net/en_US/sdk.js";
               fjs.parentNode.insertBefore(js, fjs);
             }(document, 'script', 'facebook-jssdk'));
        </script>
        
        <style>
            .social-icons-a{
                background-color: rgb(255, 255, 255);
                border-radius: 50px;
                text-align: center;
                color: #010F2C;
            }
            .social-icons-a{
                color:#fff;
                background-color: #d9d9d9;
                height: 50px;
                width: 50px;
                line-height: 50px;
                display: block;
                font-size: 30px;
                opacity: 0.8;
            }
        </style>
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
                    <div class="col-sm-8" itemscope itemtype="http://schema.org/ScholarlyArticle">
                        <img itemprop="image" class="img-responsive" src="images/novedades/<?=$novedad['imagen']?>" />
                        <span itemprop="name">
                            <h3><?=$novedad['titulo']?></h3>
                        </span>
                        <span itemprop="author" style="display:none">
                            iga-la.net
                        </span>
                        <span itemprop="about"  style="display:none">
                            <?= $categoria[0]['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>
                        </span>
                        <div style="text-align: justify">
                            <span itemprop="description">
                                <?=$novedad['descripcion']?>
                            </span>    
                        </div>
                        <div class="row">
                            <table style="width: 100%">
                                <tr>
                                    <td>
                                        <div class="col-md-6 social-icons" style="width: 100%;">
                                            <ul>
                                                <li></li>
                                                 <!--<a class="facebook" href="https://www.facebook.com/IGA.GASTRONOMIA" target="_blank"><i class="fa fa-facebook"></i></a>-->
                                                <!--<div class="fb-share-button" data-href="http://localhost/demosLifeWeb/iga/iga-la/novedad.php?id=2" data-layout="icon"></div>-->
                                                <!--<div class="fb-share-button"  data-href="http://localhost/demosLifeWeb/iga/iga-la/novedad.php?id=2" data-layout="icon"><i class="fa fa-facebook"></i></div>-->
                                                <li><a class="facebook" href="https://www.facebook.com/dialog/share?app_id=1043650382373771&amp;display=popup&amp;href=http%3A%2F%2Fm2000364.ferozo.com%2Fejemplos%2FIGA%2Figa-la%2Fnovedad.php?id=<?=$_GET['id']?>&amp;redirect_uri=http%3A%2F%2Fm2000364.ferozo.com%2Fejemplos%2FIGA%2Figa-la%2Fnovedad.php?id=<?=$_GET['id']?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                                <li><a class="twitter" href="https://twitter.com/IGA_LA" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                                <li><a class="envelope" href="https://www.facebook.com/IGA.GASTRONOMIA" target="_blank"><i class="fa fa-google"></i></a></li>
                                                <li>
                                                    <a id="facebook" class="facebook compartir" data-href="https://www.facebook.com/sharer/sharer.php?u=<?= 'http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]?>">
                                                        <i class="fa fa-facebook"></i>
                                                    </a>
                                                    <!--<div class="fb-share-button" data-href="http://localhost/demosLifeWeb/iga/iga-la/novedad.php?id=2" data-layout="icon"></div>-->
                                                    <!--div class="fb-share-button social-icons-a"  data-href="http://localhost/demosLifeWeb/iga/iga-la/novedad.php?id=2" data-layout="icon"><i class="fa fa-facebook"></i></div>-->
                                                </li>
                                                <li>
                                                    <a id="twitter" class="compartir" data-href="http://twitter.com/share?text=<?=$novedad['titulo']?>&url=<?= 'http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]?>&via=IGA_LA" target="_blank">
                                                        <i class="fa fa-twitter"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a id="google" class="envelope compartir" data-href="https://plus.google.com/share?url=<?= 'http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]?>">
                                                        <i class="fa fa-google"></i>
                                                    </a>
                                                </li>
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
                        $novedades = getNovedades($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['id_idioma'], 3, false, $novedad['categoria'], $_GET['id']);
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
            
        <?php
            include_once 'gestor/includes/footer.php';
        ?>
            
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
        <script>
            $('.compartir').click(function (){
                window.open($(this).data('href'), '_blank', "width=850, height=400, resizable=no, left=100, top=100");
                return false;
            });
        </script>    
    </body>
</html>    
