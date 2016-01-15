<?php
session_start();
include_once 'gestor/includes/functions.php';
include_once 'gestor/includes/lenguaje.php';

$pagina = 'home';

//unset($_SESSION);
if(isset($_GET['pais']) && $_GET['pais'] != ''){
    session_destroy();
    detectCountry($mysqli, $_GET['pais']);
}

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
$slider = getSlider($mysqli, $_SESSION['pais']['id'],$_SESSION['idioma_seleccionado']['cod_idioma']);
$gridArrayCursos = getImagenesGrilla($mysqli, $_SESSION['idioma_seleccionado']['cod_idioma'], $_SESSION['pais']['id'], 1);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Instituto Gastronómico de las Américas">
        <title><?=$lenguaje['titulo_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/animate.min.css" rel="stylesheet" /> 
        <link href="css/font-awesome.min.css" rel="stylesheet" />
        <link href="css/lightbox.css" rel="stylesheet" />
        <link href="css/main.css" rel="stylesheet" />
        <link id="css-preset" href="css/presets/preset1.css" rel="stylesheet" />
        <link href="css/responsive.css" rel="stylesheet" />
        <link href="css/flexslider.css" rel="stylesheet" />
        <link href="css/intlTelInput.css" rel="stylesheet" />
        <!-- <link rel="stylesheet" type="text/css" media="screen" href="styles_home.php" />-->
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
        
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css' />
        <link rel="shortcut icon" href="images/favicon.ico" />
        <script src='https://www.google.com/recaptcha/api.js'></script>
    </head><!--/head-->
    
    <body>
        <div id="fb-root"></div>
        <!--.preloader-->
        <!--<div class="preloader"> <i class="fa fa-circle-o-notch fa-spin"></i></div>-->
        <!--/.preloader-->
        <?php 
            include_once 'gestor/includes/header.php';
        ?>
        
        <section id="grillaCursos" class="portfolio">
            <div class="container">
                <div class="row" style="padding:0">
                <?php
                if(is_array($gridArrayCursos) && count($gridArrayCursos) > 0){
                    switch (count($gridArrayCursos)){
                        case "6":
                            $texto_grilla = "textos_grilla16";
                        break;
                        case "5":
                            $texto_grilla = "textos_grilla20";
                        break;
                        
                        case "4":
                            $texto_grilla = "textos_grilla25";
                        break;
                        
                        case "3":
                            $texto_grilla = "textos_grilla33";
                        break;
                    
                        case "2":
                            $texto_grilla = "textos_grilla50";
                        break;
                    
                        case "1":
                            $texto_grilla = "textos_grilla100";
                        break;
                    }
                    $arrayColores = array('#2B933E', '#C40F79', '#246553', '#F5B432', '#264699');
                    $i = 0;
                    foreach ($gridArrayCursos as $imgGrid)
                    {
                            $datos_curso = getCursos($mysqli, $imgGrid['id_curso']);
                            if($imgGrid['id_curso'] == 0)
                            {
                                $back_color = "#516BAD";
                            ?>
                            <a href="cursos_cortos.php">    
                            <?php 
                            }else{
                                $back_color = $datos_curso[0]['color'];
                            ?>
                            <a href="cursos.php?cod_curso=<?php echo $imgGrid['id_curso']?>">
                            <?php }?>
                                <!--<div id="<?= $imgGrid['id_curso'] ?>" class="col-sm-6 col-xs-12 textos_grilla" style="background-color: <?=$arrayColores[$i]?>">-->
                                <div id="<?= $imgGrid['id_curso'] ?>" class="col-sm-6 col-xs-12 textos_grilla <?=$texto_grilla?>" style="background-color: <?=$back_color?>">
                                    <table style="height: 100px; width: 100%">
                                        <tr>
                                            <td class="tdPadding">
                                                <?=$imgGrid['titulo'] ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </a>
                <?php 
                        $i++;
                    }
                }
                ?>
                </div>
                <div id="imagenesGrillaCursos" class="row hidden-xs" style="padding:0; min-height: 350px;">
                    <div class="col-md-12" style="padding: 0">
                    <?php
                    if(is_array($imgGrid) && count($imgGrid) > 0){
                        $i = 1;
                        foreach ($gridArrayCursos as $imgGrid){ 
                            if($imgGrid['id_curso'] == 0)
                            {
                    ?>
                        <a href="cursos_cortos.php">    
                        <?php } else{?>
                            <a href="cursos.php?cod_curso=<?php echo $imgGrid['id_curso']?>">
                        <?php }?>
                                <div class="text-right imagenGrilla" id="<?= 'grilla-'.$imgGrid['id_curso'] ?>" <?php if($i > 1) {echo 'style="display:none;"';}?> >
                                    <img class='img-responsive' src="<?=$imgGrid['img_url']?>">
                                    <div class="texto-flotante">
                                        <table style="height: 100%; width: 100%">
                                            <tr style="vertical-align: bottom;">
                                                <td>
                                                    <span class="spanFlotante"><?=$imgGrid['desc']?></span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>    
                            </a>
                    <?php 
                            $i++;
                        }
                    }
                    ?>
                    </div>
                </div>
            </div>    
        </section>    
        
        <section id="blog">
            <div class="container">
                <div class="row">
                    <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
                        <h2><?=$lenguaje['novedades_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h2>
                    </div>
                </div>
                
                <div class="row">
                    <div class="flexslider">
                        <ul class="slides">
                            <?php
                                $novedades = getNovedades($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['id_idioma'], 12, 1);
                                foreach ($novedades as $id=>$data){
                            ?>
                                <li>
                                    <div style="min-height: 100px">
                                    <a href="novedad.php?id=<?=$data['id']?>"><img class="img-responsive" src="images/novedades/<?=$data['imagen']?>" alt="" style="margin: 0 auto;"></a>
                                    </div>
                                    <h3><?=$data['titulo']?></h3>
                                    <span>
                                        <a href="novedad.php?id=<?=$data['id']?>">
                                            <?=$lenguaje['ver_mas_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>
                                        </a>
                                    </span>
                                </li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        	<div class="col-sm-12 text-center text-uppercase " style="background-color: #337ab7">
            	    <a href="novedades.php" style="color: white">
                	<?=$lenguaje['ver_todas_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>
                    </a>
                </div>
        </section><!--/#blog-->
        
        <!--<section id="institucional">
            <div class="container">
                <div class="row">
                    <div class="heading text-center col-sm-8 col-sm-offset-2 wow fadeInUp" data-wow-duration="1200ms" data-wow-delay="300ms">
                        <h2><?=strtoupper($lenguaje['red_capacitacion_'.$_SESSION['idioma_seleccionado']['cod_idioma']])?></h2>
                        <br/>
                    </div>
                </div>
                <div class="team-members">
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="300ms">
                                <div class="member-image" align="center">
                                    <img class="img-responsive" src="images/mision.png" alt="" width="100px" />
                                </div>
                                <br/>
                                <div class="member-info justify">
                                    <h2><?=strtoupper($lenguaje['mision_'.$_SESSION['idioma_seleccionado']['cod_idioma']])?></h2>
                                    <span class="justify"><?=$lenguaje['mision_desc_'.$_SESSION['idioma_seleccionado']['cod_idioma']]?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="300ms">
                                <div class="member-image" align="center">
                                    <img class="img-responsive" src="images/Valores.png" alt="" width="100px" />
                                </div>
                                <br/>
                                <div class="member-info">
                                        <h2><?=strtoupper($lenguaje['valores_'.$_SESSION['idioma_seleccionado']['cod_idioma']])?></h2>
                                    <?=$lenguaje['valores_desc_'.$_SESSION['idioma_seleccionado']['cod_idioma']]?>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="team-member wow flipInY" data-wow-duration="1000ms" data-wow-delay="300ms">
                                <div class="member-image" align="center">
                                    <img class="img-responsive" src="images/Vision.png" alt="" width="100px" />
                                </div>
                                <br/>
                                <div class="member-info justify">
                                    <h2><?=strtoupper($lenguaje['vision_'.$_SESSION['idioma_seleccionado']['cod_idioma']])?></h2>
                                    <?=$lenguaje['vision_desc_'.$_SESSION['idioma_seleccionado']['cod_idioma']]?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!--/#team-->
        <br/>
        <section id="contact">
            <div id="contact-us" >
                <div class="container">
                    <div class="row">
                        <div class="heading text-center wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
                            <h2><?=$lenguaje['contactate_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h2>
                            <form id="filter-form" name="filter-form" method="post" action="#" class="form-inline">
                                <select  id="provincias" class="form-control" onchange="javascript:cambiarProvincia('<option><?=$lenguaje["seleccione_filial_".$_SESSION["idioma_seleccionado"]["cod_idioma"]] ?></option>')">
                                    <option value="0"><?=$lenguaje['seleccione_provincia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></option>  
                                        <?php foreach ($provincias as $provincia){?>
                                    <option value="<?=$provincia['id']?>"><?=$provincia['nombre']?></option>    
                                        <?php }?>
                                </select>    
                                <select id="filiales" class="form-control" onchange="javascript:filialSeleccionada()">
                                    <option><?=$lenguaje['seleccione_filial_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></option>
                                </select>
                            </form>
                        </div>    
                    </div>    
                    <div class="row">        
                        <div class="container contact-form" style="display: none">
                            <div class="row">
                                <form id="main-contact-form" name="contact-form">
                                    <div class="col-sm-6">
                                        <input type="hidden" value="" id="correo" name="correo" />
                                        <div class="form-group">
                                            <input type="text" name="name" id="name" class="form-control" placeholder="<?=$lenguaje['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" class="form-control" placeholder="<?=$lenguaje['mail_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>" required="required" />
                                        </div>
                                        <div class="form-group">
                                            <input type="tel" name="phone" id="phone" class="form-control" required="required" />
                                        </div>
                                        <div id="mensaje_contacto"></div>
                                    </div>
                                    <div class="col-sm-6">
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
                                            <div class="form-group">
                                                <button type="button" class="btn-submit" data-loading-text="<?=$lenguaje['enviando_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>"><?=$lenguaje['enviar_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <textarea name="message" id="message" class="form-control" rows="2" placeholder="<?=$lenguaje['mensaje_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>" required="required"></textarea>
                                        </div>                        
                                        <div class="g-recaptcha" data-sitekey="6LfcUBQTAAAAAA6cg2CaCnnZzxbxNnIOawZwo2KJ"></div>
                                        <br/>
                                    </div>
                                </form>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <div id="google-map"></div>
                                </div>
                                <div class="col-md-6 col-sm-12" id="direccion_filial">
                                    <div class="col-md-8" style="padding: 0;">
                                        <div id="pano"></div>
                                    </div>
                                    <div class="contact-info col-md-4">
                                        <ul class="address">
                                            <li>
                                                <span><?=$lenguaje['direccion_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>: </span><br>
                                                <span id="direccion"></span> 
                                            </li>
                                            <li>
                                                <span><?=$lenguaje['telefono_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>: </span><br>
                                                <span id="telefono"></span>
                                            </li>
                                            <li>
                                                <span><?=$lenguaje['mail_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>: </span><br>
                                                <span id="mail"></span>
                                            </li>
                                        </ul>
                                    </div> 
                                </div>
                            </div>    
                        </div>
                    </div>
                </div>  
            </div>    
        </section><!--/#contact-->
        
        <?php
            include_once 'gestor/includes/footer.php';
            $cod_pais = "ar";
            switch($_SESSION['pais']['cod_pais']){
                case "BR":
                case "br":
                    $cod_pais = "br";
                break;
                case "UR":
                case "ur":    
                    $cod_pais = "uy";
                break;
                case "PR":
                case "pr":
                    $cod_pais = "py";
                break;
                case "BO":
                case "bo":
                    $cod_pais = "bo";
                break;
                case "PA":
                case "pa":
                    $cod_pais = "pa";
                break;
                case "US":
                case "us":
                    $cod_pais = "us";
                break;
            }
        ?>
        
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="js/jquery.inview.min.js"></script>
        <script type="text/javascript" src="js/wow.min.js"></script>
        <script type="text/javascript" src="js/mousescroll.js"></script>
        <script type="text/javascript" src="js/smoothscroll.js"></script>
        <script type="text/javascript" src="js/jquery.countTo.js"></script>
        <script type="text/javascript" src="js/lightbox.min.js"></script>
        <script type="text/javascript" src="js/jquery.flexslider-min.js"></script>
        <script type="text/javascript" src="js/phoneValidation/intlTelInput.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
        
        <script type="text/javascript">
            $('#filiales').change(function(){
                $('#direccion_filial').fadeIn("slow");
                $('#select_filial').removeClass("col-sm-12");
                $('#select_filial').addClass("col-md-8");
            });
        
            /*$(document).ready(function () {
                $('.accordion-toggle').on('click', function(event){
                    event.preventDefault();
                    // create accordion variables
                    var accordion = $(this);
                    var accordionContent = accordion.next('.accordion-content');
                    var accordionToggleIcon = $(this).children('.toggle-icon');

                    // toggle accordion link open class
                    accordion.toggleClass("open");
                    // toggle accordion content
                    accordionContent.slideToggle(250);

                    // change plus/minus icon
                    if (accordion.hasClass("open")) {
                        accordionToggleIcon.html("<i class='fa fa-minus-circle'></i>");
                    } else {
                        accordionToggleIcon.html("<i class='fa fa-plus-circle'></i>");
                    }
                });
            });*/
            
            $(window).load(function(){
                $('.flexslider').flexslider({
                  animation: "slide",
                  animationLoop: false,
                  itemWidth: 210,
                  itemMargin: 30,
                  minItems: 2,
                  maxItems: 3,
                  start: function(slider){
                    $('body').removeClass('loading');
                  }
                });
              });
              
            $("#phone").intlTelInput({
                onlyCountries: ['ar', 'br', 'uy', 'py', 'bo', 'pa', 'us'],
                preferredCountries: [],
                utilsScript: "js/phoneValidation/utils.js"
            });
            $("#phone").intlTelInput("setCountry", "<?=$cod_pais?>");
        </script>
        
    </body>
</html>
