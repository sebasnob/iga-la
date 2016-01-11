<?php
session_start();
include_once 'gestor/includes/functions.php';
include_once 'gestor/includes/lenguaje.php';

$pagina = 'novedades';
$palabra = false;
$fecha = false;
$categoria = false;
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
if(isset($_GET['palabra']) && $_GET['palabra'] != '')
{
    $palabra = $_GET['palabra'];
}
if(isset($_GET['categoria']) && $_GET['categoria'] != '')
{
    $categoria = $_GET['categoria'];
}
if(isset($_GET['fecha']) && $_GET['fecha'] != '')
{
    $fecha = $_GET['fecha'];
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
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <meta name="author" content="lifeweb.com.ar" />
        <title><?=$lenguaje['titulo_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/animate.min.css" rel="stylesheet" /> 
        <link href="css/font-awesome.min.css" rel="stylesheet" />
        <link href="css/lightbox.css" rel="stylesheet" />
        <link href="css/main.css" rel="stylesheet" />
        <link id="css-preset" href="css/presets/preset1.css" rel="stylesheet" />
        <link href="css/responsive.css" rel="stylesheet" />
        <link href="css/jquery.filthypillow.css" rel="stylesheet" />
            
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
        
        <section id="head_image_curso">
            <div class="hidden-xs"  style="background-color: <?=$datos_curso['color']?>">
                <div class="container">
                    <h2 style="position:absolute;padding-top:4%">
                        <span>
                            <p style="font-size:70px;color:white;width:450px;font-weight:600;"><?=$lenguaje['blog_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
                            <p style="font-size:50px;color:white;width:450px;font-weight:600;"><?=$lenguaje['actualidad_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
                        </span>
                    </h2>
                </div>
                <img class="img-responsive animated" src="images/slider-novedades.jpg" alt="" style="width: 100%;" />
            </div>
            
            <div class="visible-xs" >
                <img class="img-responsive animated fadeInLeftBig" src="images/slider-novedades.jpg" alt="" style="width: 100%;" />
                <div class="row col-md-12 text-center">
                    <h3><?=$lenguaje['blog_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h3>
                    <?=$lenguaje['actualidad_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>
                </div>
            </div>
            
        </section>
        
        <section id="buscador">
            <div class="container">
                <div class="col-sm-12 text-center">
                    <h2 style="font-size: 20px; font-weight: 500;">
                        <?=$lenguaje['buscador_de_noticias_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>
                    </h2>
                </div>
                <div class="col-sm-12">
                        <div class="col-sm-4">
                            <input class="form-control" type="text" name="palabra" id="palabra" placeholder="<?=$lenguaje['palabra_clave_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>" value="<?=$palabra?>"/>
                        </div>
                        <div class="col-sm-4">
                            <select  id="categorias" class="form-control">
                                <option value="0"><?=$lenguaje['por_categoria_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></option>  
                                <?php
                                        foreach ($categoriasNovedades as $cat)
                                        {?>
                                            <option value="<?=$cat['id']?>" <?php if($cat['id'] == $categoria){echo 'selected';}?>><?=$cat['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']];?></option>
                                <?php   }?>
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input class="form-control filthypillow-1" type="text" name="fecha" id="fecha" placeholder="<?=$lenguaje['por_fecha_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>" value='<?=$fecha?>'/>
                        </div>
                        <div class="col-sm-1">
                            <button class="btn btn-default" onclick="javascript:buscarNoticias();"><?=$lenguaje['buscar_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></button>
                        </div>    
                </div>
            </div>
        </section>
            
        <section id="novedades">
            <div class="container">
                <div class="row">
                <?php
                if($categoria)
                {
                        $i=0;
                        $novedades = getNovedades($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['id_idioma'], 3, false, $categoria, $palabra, $fecha);
                        foreach ($categoriasNovedades as $cat){
                            if($cat['id'] == $categoria){
                        ?>
                                
                                <div class="col-sm-12">
                                    <h2 style="font-weight: 600"><?=$cat['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']];?></h2>
                                    <hr>
                                </div>
                        <?php
                            }
                        }
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
                else
                {
                    foreach ($categoriasNovedades as $cat)
                    {
                        $i=0;
                        $novedades = getNovedades($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['id_idioma'], 3, false, $cat['id'], $palabra, $fecha);
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
                        if($i == 0)
                        { ?>
                            <div class="col-sm-8"><?=$lenguaje['sin_novedad_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></div>  
                        <?php } 
                    }
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
        <script type="text/javascript" src="js/moment.js"></script>
        <script type="text/javascript" src="js/jquery.filthypillow.min.js"></script>
        
        <script>
        var $fp = $( ".filthypillow-1" );
        
        $fp.filthypillow();
        $fp.on( "focus", function( ) {
          $fp.filthypillow( "show" );
        } );
        $fp.on( "fp:save", function( e, dateObj ) {
          $fp.val( dateObj.format( "YYYY-MM-DD" ) );
          $fp.filthypillow( "hide" );
        } );
        
        </script>
    </body>
</html>    
