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
//$novedades = getNovedades($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['id_idioma']);

$categoriasNovedades = getCategoriasNovedades($mysqli);
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
            <div class="container-fluid" style="position: relative">
                <img class="img-responsive animated fadeInLeftBig" src="images/slider-novedades.jpg" alt="" style="width: 100%;" />
            </div>
        </section>
        
        <section id="buscador">
            <div class="container">
                <div class="col-sm-12">
                    <h2 style="font-size: 20px; font-weight: 500;">
                        Buscador de Noticias
                    </h2>
                </div>
                <div class="heading wow fadeInUp col-sm-12" data-wow-duration="1000ms" data-wow-delay="300ms">
                    <form name="filter-form" method="post" action="#" class="form-inline">
                        <div class="col-sm-4">
                            <input type="text" name="palabra" id="palabra" placeholder="Por palabra clave" />
                        </div>
                        <div class="col-sm-4">
                            <select  id="categorias" class="form-control">
                                <option value="0"><?=$lenguaje['seleccion_opcion_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></option>  
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <select id="fecha" class="form-control" >
                                <option value="0"><?=$lenguaje['seleccion_opcion_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </section>
            
        <section id="novedades">
            <div class="container">
                <?php
                    foreach ($categoriasNovedades as $cat)
                    {
                        $i=0;
                        $novedades = getNovedades($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['id_idioma'], 3, false, $cat['id']);
                        ?>
                                <div class="col-sm-12">
                                    <h2 style="font-weight: 600"><?=$cat['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']];?></h2>
                                    <hr>
                                </div>
                        <?php
                        foreach ($novedades as $novedad)
                        {
                        ?>
                        <?php if($i == 0){
                            $estiloTextos = 'font-size: 25px;';    
                            $estiloImagen = 'margin-bottom: 15px;'; ?>
                            <div class="col-sm-8">
                        <?php }
                            else
                            {
                                $estiloTextos = 'font-size: 15px;';
                                $estiloImagen = 'margin-bottom: 5px;'; ?>
                                <div class="col-sm-4" style="margin-bottom: 10px;">
                            <?php 
                            }
                            ?>
                                    <a href="novedad.php?id=<?=$novedad['id']?>"><img style="<?=$estiloImagen?>" class="img-responsive" src="images/novedades/<?=$novedad['imagen']?>" /></a>
                                    <a href="novedad.php?id=<?=$novedad['id']?>"><span style="<?=$estiloTextos?>"><?=$novedad['titulo']?></span></a>
                                </div>
                        <?php 
                            $i++;
                        }
                    }
                    ?>
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
            
    </body>
</html>    
