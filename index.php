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
$slider = getSlider($mysqli, $_SESSION['pais']['id']);
$auspiciantes = getAuspiciantes($mysqli);

$gridArrayCursos = getImagenesGrilla($mysqli, $_SESSION['idioma_seleccionado']['cod_idioma'], $_SESSION['pais']['id'], 1, 1);
//$gridArrayCursosCortos = getImagenesGrilla($mysqli, $_SESSION['idioma_seleccionado']['cod_idioma'], $_SESSION['pais']['id'], 2, 1);
//$gridArrayCocineritos = getImagenesGrilla($mysqli, $_SESSION['idioma_seleccionado']['cod_idioma'], $_SESSION['pais']['id'], 3, 1);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
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
        <div id="fb-root"></div>
        <!--.preloader-->
        <!--<div class="preloader"> <i class="fa fa-circle-o-notch fa-spin"></i></div>-->
        <!--/.preloader-->
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
                            <li class="scroll active"><a href="#home"><?=$lenguaje['inicio_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                            <li id="cursos"><?=$lenguaje['curso_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></li>
                            <li class="scroll"><a href="#blog"><?=$lenguaje['novedades_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                            <li class="scroll"><a href="#team"><?=$lenguaje['institucional_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>  
                            <li class="scroll"><a href="#contact"><?=$lenguaje['contacto_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
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
        <?php
        if(count($slider) > 0){
        ?>
            <div id="slider" class="carousel slide carousel-fade" data-ride="carousel">
                
                <div class="carousel-inner">
                <?php 
                    $i=0; 
                    foreach($slider as $slid){
                ?>
                    <div 
                        class="item <?php if($i == 0){echo 'active';}?>" 
                        <?php if(isset($slid['link']) && $slid['link'] != '')
                        {
                            echo "onclick=";
                            echo "javascript:iralink('{$slid['link']}')";
                                    
                        } ?>
                        title='<?= $slid['alt'];?>'>
                        <h2 style="position: absolute;">
                            <span style="color: white; font: bold 24px/45px Helvetica, Sans-Serif; letter-spacing: -1px;background: rgb(0, 0, 0); background: rgba(0, 0, 0, 0.7); padding: 10px; ">
                                Asadasdsad sad asd
                            </span>
                        </h2>
                        <img class="img-responsive" src="<?= $slid['url'];?>">
                    </div>
                <?php
                        $i++;
                    } 
                ?>
                </div>
                
                <a class="left-control" href="#slider" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                <a class="right-control" href="#slider" data-slide="next"><i class="fa fa-angle-right"></i></a>
            </div><!--/#home-slider-->
        <?php
        }
        ?>
        </header><!--/#home--> 
        <section id="grillaCursos" class="portfolio">
            <div class="container" id="grilla">
                <div class="row">
                    <?php 
                    if(!$gridArrayCursos){
                        echo "<div class='text-center'>" . $lenguaje['no_existen_cursos_'.$_SESSION['idioma_seleccionado']['cod_idioma']] . "</div>";
                    }else{
                        foreach ($gridArrayCursos as $imgGrid){
                    ?>
                    <div class="col-md-<?php echo $imgGrid['cols']?>">
                        <div class="folio-item wow fadeInRightBig" data-wow-duration="1000ms" data-wow-delay="300ms">
                            <div class="folio-image">
                                <a href="cursos.php?cod_curso=<?php echo $imgGrid['id_curso']?>">
                                    <img class="img-responsive" src="<?php echo $imgGrid['img_url']?>" alt="">
                                </a>    
                            </div>
                            <div class="overlay">
                                <div class="overlay-content">
                                    <div class="overlay-text">
                                        <div class="folio-overview">
                                            <span class="folio-expand ">
                                                <a href="cursos.php?cod_curso=<?php echo $imgGrid['id_curso']?>">
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
                    }
                    ?>
                </div>
            </div> <!--/#container-fluid-porfolios-->
        </section><!--/#grillaCursos-->
        
        <section id="blog">
            <div class="container">
                <div class="row">
                    <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
                        <h2><?=$lenguaje['novedades_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h2>
                    </div>
                </div>

                <!-- noticias -->
                <div class="blog-posts">
                    <div class="row">
                        <?php
                        $novedades = getNovedades($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['id_idioma'], 3, 1);
                        foreach ($novedades as $id=>$data){
                        ?>
                        <div class="col-sm-4 wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <div class="post-thumb">
                                <img class="img-responsive" src="images/novedades/<?=$data['imagen']?>" alt="">
                            </div>
                            <div class="entry-header">
                                <h3><?=$data['titulo']?></h3>
                            </div>
                            <div class="entry-content">
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
        
        <!--/#Solo en movil-->
       <section id="team" class="visible-xs">
        <div class="container">
           <div class="row">
            <div class="col-xs-12">
              <p>hola esto es en celular</p>
            </div>
            </div>
       </div>
       </section>
       <!--/#end movil-->
        
        <section id="team" class="hidden-xs">
            <div class="container">
                <div class="row">&nbsp;&nbsp;</div>
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
                            <div class="col-md-4" style="display: none" id="direccion_filial">
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
                        <div class="container contact-form" style="display: none">
                            <div class="row">
                                <form id="main-contact-form" name="contact-form">
                                    <div class="col-sm-4">
                                        <input type="hidden" value="" id="correo" name="correo">
                                        
                                            <div class="form-group">
                                                <input type="text" name="name" id="name" class="form-control" placeholder="<?=$lenguaje['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>" required="required">
                                            </div>
                                            <div class="form-group">
                                                <input type="email" name="email" id="email" class="form-control" placeholder="<?=$lenguaje['mail_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>" required="required">
                                            </div>
                                            <div class="form-group">
                                                <input type="text" name="phone" id="phone" class="form-control" placeholder="<?=$lenguaje['telefono_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>" required="required">
                                            </div>
                                            <div id="mensaje_contacto"></div>
                                        
                                    </div>
                                    <div class="col-sm-1">&nbsp;</div>
                                    <div class="col-sm-7">
                                        
                                            <div class="form-group form-inline">
                                                <select id="opciones" class="form-control" name="subject" onchange="javascript:getSelectCursos('opciones','cursos_contacto')">
                                                    <option value="0"><?=$lenguaje['seleccion_opcion_'.$_SESSION['idioma_seleccionado']['cod_idioma']]?></option>
                                                    <option value="3"><?=$lenguaje['curso_'.$_SESSION['idioma_seleccionado']['cod_idioma']]?></option>
                                                    <option value="4"><?=$asunto=$lenguaje['atencion_alumno_'.$_SESSION['idioma_seleccionado']['cod_idioma']];?></option>
                                                </select>
                                                &nbsp;
                                                <select class="form-control" name="cursos_contacto" id="cursos_contacto" style="display: none;">
                                                    <option value=""><?=$lenguaje['seleccion_opcion_'.$_SESSION['idioma_seleccionado']['cod_idioma']]?></option>
                                                <?php
                                                $cursos = getCursos($mysqli);
                                                foreach($cursos as $id=>$data){
                                                ?>
                                                    <option value="<?=$data['cod_curso']?>">
                                                        <?php
                                                        switch($_SESSION['idioma_seleccionado']['cod_idioma']){
                                                            case "ES":
                                                                echo $data['nombre_es'];
                                                            break;
                                                            
                                                            case "POR":
                                                                echo $data['nombre_portugues'];
                                                            break;
                                                        
                                                            case "IN":
                                                                echo $data['nombre_ingles'];
                                                            break;
                                                        }
                                                        ?>
                                                    </option>
                                                <?php
                                                }
                                                ?>
                                                </select>
                                            </div>
                                        
                                        
                                            <div class="form-group">
                                                <textarea name="message" id="message" class="form-control" rows="2" placeholder="<?=$lenguaje['mensaje_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>" required="required"></textarea>
                                            </div>                        
                                            <div class="form-group">
                                                <button type="button" class="btn-submit" data-loading-text="<?=$lenguaje['enviando_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>"><?=$lenguaje['enviar_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></button>
                                            </div>
                                        
                                    </div>
                                </form>
                            </div>
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
                        <a href="index.php"><img class="img-responsive" src="images/logo-iga_transparent.png" alt=""></a>
                    </div>
                    <div class="social-icons">
                        <ul>
                            <li><a class="twitter" href="https://twitter.com/IGA_LA" target="_blank"><i class="fa fa-twitter"></i></a></li> 
                            <li><a class="facebook" href="https://www.facebook.com/IGA.GASTRONOMIA" target="_blank"><i class="fa fa-facebook"></i></a></li>
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
        <script type="text/javascript">
        $('#filiales').change(function(){
            $('#direccion_filial').fadeIn("slow");
            $('#select_filial').removeClass("col-sm-12");
            $('#select_filial').addClass("col-md-8");
        });
        </script>
    </body>
</html>
