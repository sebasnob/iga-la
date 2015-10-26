<?php
session_start();
include_once 'gestor/includes/functions.php';
include_once 'gestor/includes/lenguaje.php';

//unset($_SESSION);
if(!isset($_GET['cod_curso']) || $_GET['cod_curso'] == ''){
    header("Location:index.php");
    exit();
}

if(!isset($_SESSION['pais']))
{
    detectCountry($mysqli);
}
if(!isset($_SESSION['idioma_seleccionado']['cod_idioma']))
{
    $_SESSION['idioma_seleccionado']['cod_idioma'] = $_SESSION['pais']['cod_idioma'];
    $_SESSION['idioma_seleccionado']['idioma'] = $_SESSION['pais']['idioma'];
}
if(isset($_GET['id_filial'])){
    $_SESSION['id_filial'] = $_GET['id_filial'];
}

$paises = getPaises($mysqli);
$provincias = getProvincias($mysqli, $_SESSION['pais']['id']);
$idiomas = getIdiomas($mysqli);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?=$lenguaje['titulo_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/animate.min.css" rel="stylesheet"> 
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="css/lightbox.css" rel="stylesheet">
        <link href="css/main.css" rel="stylesheet">
        <link id="css-preset" href="css/presets/preset1.css" rel="stylesheet">
        <link href="css/responsive.css" rel="stylesheet">
        
        <link rel="stylesheet" type="text/css" media="screen" href="styles_home.php?cod_curso=<?=$_GET['cod_curso']?>" />
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
        
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>
        <link rel="shortcut icon" href="images/favicon.ico">
    </head><!--/head-->
    <body>
<?php
if(isset($_GET['id_filial']) || isset($_SESSION['id_filial']))
{
    $id_filial = (isset($_GET['id_filial'])) ? $_GET['id_filial'] : $_SESSION['id_filial'];
    $cod_curso = $_GET['cod_curso'];
    
    $res_idioma = $mysqli->query("SELECT id FROM idiomas WHERE cod_idioma='{$_SESSION['idioma_seleccionado']['cod_idioma']}'");
    $idioma = $res_idioma->fetch_assoc();
    $id_idioma = $idioma['id'];
    $showModal = 0;
    
    $datos_curso = getDatosCurso($mysqli, $cod_curso, $id_idioma, $id_filial);

?>
        <div id="fb-root"></div>
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
                            <li class="scroll"><a href="index.php#portfolio"><?=$lenguaje['curso_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                                            
                            <li class="scroll"><a href="index.php#blog"><?=$lenguaje['novedades_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
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

        <section id="head_image_curso">
            <div class="container-fluid">
                <div class="row">
                    <img class="img-responsive animated fadeInLeftBig" src="<?=$datos_curso['url_cabecera']?>" alt="" style="width: 100%;">
                </div>
            </div>
        </section> 
        
        <section id="single_curso" class="container">
            <div class="row">
                <aside class="col-sm-4 col-sm-push-8">
                    <div class="widget ads">
                        <div class="row">
                            <div class="col-sm-12 wow fadeInUp text-center" data-wow-duration="1000ms" data-wow-delay="400ms">
                                <div class="fb-page" data-href="https://www.facebook.com/IGA.GASTRONOMIA" data-width="500" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true">
                                    <div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/IGA.GASTRONOMIA"><a href="https://www.facebook.com/IGA.GASTRONOMIA">IGA</a></blockquote></div>
                                </div>
                            </div>
                        </div>
                    </div><!--/.ads-->     
                    <br/>
                    <?php
                    $novedad = getNovedadesHome($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['id_idioma'], 1);
                    if(count($novedad) > 0){
                    ?>
                    <div class="widget ads">
                        <div class="row">
                            <div class="col-sm-12 wow fadeInUp text-center" data-wow-duration="1000ms" data-wow-delay="400ms">
                                
                                <div class="post-thumb">
                                    <a href="index.php#blog"><img class="img-responsive" src="images/novedades/<?=$novedad[0]['imagen']?>" alt=""></a>
                                </div>
                                <div class="entry-header">
                                    <h3><a href="index.php#blog"><?=$novedad[0]['titulo']?></a></h3>
                                </div>
                                <div class="entry-content">
                                    <p><?=$novedad[0]['descripcion']?></p>
                                </div>
                            </div>
                        </div>
                    </div><!--/.categories-->
                    <?php
                    }
                    ?>
                </aside>        
                <div class="col-sm-8 col-sm-pull-4">
                    <section id="curso">
                        <h2><?=$datos_curso['nombre']?></h2>
                        <div class="entry-meta">
                            <span>
                                <i class="fa fa-calendar"></i>&nbsp;Duración:
                    	    <?php echo ($datos_curso['horas'] != '' && $datos_curso['horas'] != 0)? $datos_curso['horas']." horas": ''; ?>
                    	    <?php echo ($datos_curso['meses'] != '' && $datos_curso['meses'] != 0)? ", ".$datos_curso['meses']." meses": ''; ?>
                    	    <?php echo ($datos_curso['anios'] != '' && $datos_curso['anios'] != 0)? ", ".$datos_curso['anios']." años": ''; ?>
                            </span>
                        </div>
                    <?=$datos_curso['descripcion']?>
                    </section>
                    <hr>
                    <section id="cursado_planes">
                        <h3>Cursado y plan de pagos</h3>
                        <p>Para ver los inicios de clases, los horarios de cursado y las formas de pago, seleccione una provincia y un local.</p>
                        <form id="form-matricula" name="form-matricula" method="post" action="#" class="form-inline">
                            <div class="form-group">
                                <label for="option"><?=$lenguaje['provincia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></label>
                                <select id="provincias" class="form-control" onchange="javascript:cambiarProvinciaMatricula('<option><?=$lenguaje["seleccione_filial_".$_SESSION["idioma_seleccionado"]["cod_idioma"]] ?></option>')">
                                    <option value="0"><?=$lenguaje['seleccione_provincia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></option>  
                                <?php foreach ($provincias as $provincia){?>

                                    <option value="<?=$provincia['id']?>"><?=$provincia['nombre']?></option>    

                                <?php }?>
                                </select>    

                            </div>

                            <div class="form-group">
                                <label for="option"><?=$lenguaje['filiales_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></label>
                                <select id="filiales_matricula" class="form-control">
                                    <option><?=$lenguaje['seleccione_filial_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></option>
                                </select>

                            </div>
                        </form>
                        <br/>
                        <div id="matricula_curso" style="display: none">
                            <ul class="list-group">
                                <li class="list-group-item "><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> <strong>Lunes y Miércoles </strong> - de 18:30 a 20:30 y de 18:30 a 22:30 - <strong>Matrícula</strong> $400 - 22 Cuotas de $995</li>
                                <li class="list-group-item"><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> <strong>Miércoles </strong> - de 15:30 a 17:30 <strong>Matrícula</strong> $400 - 22 Cuotas de $995</li>
                                <li class="list-group-item" ><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..."> <strong>Lunes</strong> - de 18:30 a 20:30 - <strong>Matrícula</strong> $400 - 22 Cuotas de $995</li>
                                <li class="list-group-item"><input type="checkbox" id="blankCheckbox" value="option1" aria-label="..." > <strong>Sábado </strong> - de 12:00 a 14:00 - <strong>Matrícula</strong> $400 - 22 Cuotas de $995</li>
                            </ul>  
                        
                            <form id="main-contact-form" name="contact-form" method="post" action="#">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control" placeholder="Nombre" required="required">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input type="email" name="email" class="form-control" placeholder="Dirección de Email" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="telefono" class="form-control" placeholder="Teléfono" required="required">
                                </div>
                                <div class="form-group">
                                    <textarea name="message" id="message" class="form-control" rows="4" placeholder="Ingrese su mensaje" required="required"></textarea>
                                </div>                        
                                <div class="form-group">
                                    <button type="submit" class="btn-btn-default">Reservar Lugar</button>
                                </div>
                            </form>
                        </div>
                    </section>
                    <hr>
                    <section id="meterial_curso" >
                        <h3>Material del curso</h3>
                        <div class="well">
                            <div class="media">
                                <div class="pull-left">
                                    <img class="avatar img-thumbnail" src="<?=$datos_curso['url_material']?>" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <strong>Cada curso de IGA</strong>
                                    </div>
                                <?=$datos_curso['desc_material']?>
                                </div>
                            </div>
                        </div><!--/.author-->
                    </section>
                    <hr>
                    <section id="uniformes" >
                        <h3>Uniformes</h3>
                        <div class="well">
                            <div class="media">
                                <div class="pull-left">
                                    <img class="avatar img-thumbnail" src="<?=$datos_curso['url_uniforme']?>" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <strong>Con la inscripción al curso,</strong>
                                    </div>
                                <?=$datos_curso['desc_uniforme']?>
                                </div>
                            </div>
                        </div><!--/.author-->
                    </section>
                </div><!--/.col-md-8-->
                <div class="col-md-12">
                    <section id="objetivo">
                        <h2>Nuestro Objetivo</h2>
                        <div class="entry-meta">
                            <span>
                                <i class="fa fa-calendar"></i>&nbsp;Duración:
                	<?php echo ($datos_curso['horas'] != '' && $datos_curso['horas'] != 0)? $datos_curso['horas']." horas": ''; ?>
                	<?php echo ($datos_curso['meses'] != '' && $datos_curso['meses'] != 0)? ", ".$datos_curso['meses']." meses": ''; ?>
                	<?php echo ($datos_curso['anios'] != '' && $datos_curso['anios'] != 0)? ", ".$datos_curso['anios']." años": ''; ?>
                            </span>
                        </div>
                    <?=$datos_curso['objetivos']?>
                    </section>
                </div>
            </div><!--/.row-->
        </section><!--/#single_cursos-->
        
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
                            <p><a href="http://igafranchising.com/" target="_blank"><?=$lenguaje['quiero_una_franquicia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></p>
                        </div>
                        <div class="col-sm-4 text-center">
                            <p>&copy; 2015 Designed by <a href="http://www.lifeweb.com.ar/">lifeWEB</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
<?php
}else{
    $showModal = 1;
}
?>
        <!-- Modal -->
        <div class="modal fade" id="selectFilialModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="heading text-center">
                            <p><?=$lenguaje['seleccione_filial_'.$_SESSION['idioma_seleccionado']['cod_idioma']]?></p>
                            <div class="col-sm-12 text-center">
                                <form id="filter-form" name="filter-form" method="post" action="#" class="form-inline">
                                    <div class="form-group">
                                        <label for="option"><?=$lenguaje['provincia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></label>
                                        <select id="provincias" class="form-control" onchange="javascript:cambiarProvincia('<option><?=$lenguaje["seleccione_filial_".$_SESSION["idioma_seleccionado"]["cod_idioma"]] ?></option>')">
                                            <option value="0"><?=$lenguaje['seleccione_provincia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></option>  
                            <?php foreach ($provincias as $provincia){?>
                                            <option value="<?=$provincia['id']?>"><?=$provincia['nombre']?></option>    
                            <?php }?>
                                        </select>    
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="option"><?=$lenguaje['filiales_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></label>
                                        <select id="filiales" class="form-control">
                                            <option><?=$lenguaje['seleccione_filial_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
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
        
        $('#filiales').change(function(){
            filialModalSeleccionada($(this).val(), <?=$_GET['cod_curso']?>);
        });
        
        $('#filiales_matricula').change(function(){
            $('#matricula_curso').show();
        });
        </script>
        <script>
        $(document).ready(function(){
            var showModal = <?=$showModal?>;
            if(showModal === 1){
                $('#selectFilialModal').modal('show');
            }
        });
        </script>
    </body>
</html>



