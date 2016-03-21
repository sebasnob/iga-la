<?php
session_start();
include_once 'gestor/includes/functions.php';
include_once 'gestor/includes/lenguaje.php';

$pagina = 'novedades';

if(isset($_GET['id']) && $_GET['id'] != ''){
    if(!filter_var($_GET['id'], FILTER_VALIDATE_INT)){
        header("Location:index.php");
        exit();
    }
}

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
        
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css' />
        <link rel="shortcut icon" href="images/favicon.ico" />
    </head><!--/head-->
    
    <body>
        <?php 
            include_once 'gestor/includes/header.php';
        ?>
        
        <section id="head_novedades">
            <div class="hidden-xs">
                <div class="container">
                    <h2 style="position:absolute;padding-top:4%;z-index: 99;">
                        <span>
                            <p style="font-size:70px;color:white;width:450px;font-weight:600;"><?=$lenguaje['blog_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
                            <p style="font-size:50px;color:white;width:450px;font-weight:600;"><?=$lenguaje['actualidad_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
                        </span>
                    </h2>
                </div>
                <img class="img-responsive animated fadeInLeftBig" src="images/slider-novedades.jpg" alt="" style="width: 100%;" />
            </div>
            
            <div class="visible-xs" >
                <img class="img-responsive animated fadeInLeftBig" src="images/slider-novedades.jpg" alt="" style="width: 100%;" />
                <div class="row col-md-12 text-center">
                    <h3><?=$lenguaje['blog_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h3>
                    <?=$lenguaje['actualidad_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>
                </div>
            </div>
            
        </section>
        
        <section id="novedades">
            <div class="container">
                <div class="row">
                    <div class="col-sm-7" itemscope itemtype="http://schema.org/ScholarlyArticle">
                        <div id="post-carousel"  class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                              <?php
                              if($novedad['imagen'] != ''){
                              ?>
                              <li data-target="#post-carousel" data-slide-to="0" class="active"></li>
                              <?php
                              }
                              if($novedad['imagen2'] != ''){
                              ?>
                              <li data-target="#post-carousel" data-slide-to="1"></li>
                              <?php
                              }
                              if($novedad['imagen3'] != ''){
                              ?>
                              <li data-target="#post-carousel" data-slide-to="2"></li>
                              <?php
                              }
                              ?>
                            </ol>
                            <div class="carousel-inner">
                              <?php
                              if($novedad['imagen'] != ''){
                              ?>
                              <div class="item active">
                                  <a href="#"><img class="img-responsive" src="images/novedades/<?=$novedad['imagen']?>" width="100%" alt=""></a>
                              </div>
                              <?php
                              }
                              if($novedad['imagen2'] != ''){
                              ?>
                              <div class="item">
                                  <a href="#"><img class="img-responsive" src="images/novedades/<?=$novedad['imagen2']?>" width="100%" alt=""></a>
                              </div>
                              <?php
                              }
                              if($novedad['imagen3'] != ''){
                              ?>
                              <div class="item">
                                  <a href="#"><img class="img-responsive" src="images/novedades/<?=$novedad['imagen3']?>" width="100%" alt=""></a>
                              </div>
                              <?php
                              }
                              ?>
                                <a class="blog-left-control" href="#post-carousel" role="button" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                                <a class="blog-right-control" href="#post-carousel" role="button" data-slide="next"><i class="fa fa-angle-right"></i></a>
                            </div>                               
                        </div>
                        
                        <!--<img itemprop="image" class="img-responsive" src="images/novedades/<?=$novedad['imagen']?>" />-->
                        <br/>
                        <span itemprop="name">
                            <h2><?=$novedad['titulo']?></h2>
                        </span>
                        <div style="text-align: justify;">
                            <span itemprop="description">
                                <?php if($_GET['id'] == 132) {
				$html_pagar = '<form action="https://pagseguro.uol.com.br/checkout/v2/cart.html?action=add" method="post"><!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO --><input type="hidden" name="itemCode" value="97F4B405656514D1144C4FBD33332431" /><input type="image" src="https://stc.pagseguro.uol.com.br/public/img/botoes/pagamentos/120x53-pagar-cinza.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" /></form>';
					 $novedad['descripcion'] = str_replace('|boton|', $html_pagar, $novedad['descripcion']);
				}
				?>
                                <?=$novedad['descripcion']?>

                            </span>    
                        </div>
                        <div class="row">
                            <div class="col-md-12 social text-right">
                                <span>Compart&iacute; esta noticia </span>
                                <ul>
                                    <li>
                                        <a id="facebook" class="facebook compartir" data-href="https://www.facebook.com/sharer/sharer.php?u=<?= 'http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]?>">
                                            <i class="fa fa-facebook"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a id="twitter" class="compartir" data-href="http://twitter.com/share?text=<?=$novedad['titulo']?>&url=<?= 'http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]?>&via=IGA_LA" target="_blank">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a id="google" class="envelope compartir" data-href="https://plus.google.com/share?url=<?= 'http://'.$_SERVER[HTTP_HOST].$_SERVER[REQUEST_URI]?>">
                                            <i class="fa fa-google-plus"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-4">
                        <h2><?=$lenguaje['mas_de_'.$_SESSION['idioma_seleccionado']['cod_idioma']]?><?=$categoria[0]['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']]?></h2>
                    <?php
                        $novedades = getNovedades($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['id_idioma'], 4, false, $novedad['categoria'], false, false, $_GET['id']);
                        foreach ($novedades as $nov)
                        {
                            $estiloTextos = 'font-size: 15px;';
                            $estiloImagen = 'margin-bottom: 5px;'; ?>
                        <a href="novedad.php?id=<?=$nov['id']?>"><img style="<?=$estiloImagen?>" class="img-responsive" src="images/novedades/<?=$nov['imagen']?>" /></a>
                        <a href="novedad.php?id=<?=$nov['id']?>"><span style="<?=$estiloTextos?>"><?=$nov['titulo']?></span></a>
                        <br/>
                        <br/>
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
