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
if(isset($_GET['id_filial'])){
    $_SESSION['id_filial'] = $_GET['id_filial'];
}

$paises = getPaises($mysqli);
$provincias = getProvincias($mysqli, $_SESSION['pais']['id']);
$idiomas = getIdiomas($mysqli, false, $_SESSION['pais']['id']);
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
    
    $res_idioma = $mysqli->query("SELECT id FROM idiomas WHERE cod_idioma='{$_SESSION['idioma_seleccionado']['cod_idioma']}'");
    $idioma = $res_idioma->fetch_assoc();
    $id_idioma = $idioma['id'];
    $showModal = 0;
    
    $prov = getProvinciaFromFilial($mysqli,$_SESSION['id_filial']);
    
    $cursos_cortos = getCursosCortos($mysqli);
    $categorias_cursos_cortos = getCategoriasCursosCortos($mysqli);
?>
        <div id="fb-root"></div>
        <header id="home">
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
                <img class="img-responsive animated fadeInLeftBig" src="images/Cabecera-Cursos-Cortos-Mayo-2015.jpg" alt="" style="width: 100%;">
            </div>
        </section> 
        
        <section id="single_curso" class="container">
            <div class="row">
                <div class="col-sm-8">
                    <br>
                    <h2><?=$lenguaje['titulo_cursos_cortos_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h2>

                    <br/>
                        <form id="form-matricula" name="form-matricula" method="post" action="#" class="form-inline formularioCursosCortos">
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
                    <?php 
                        $categoria = '';
                        foreach ($cursos_cortos as $curso_corto)
                        {
                        
                    ?>
                    <div>
                        <h3>
                        <?php if($categoria !== $curso_corto['categoria'])
                        {
                            echo $categorias_cursos_cortos[$curso_corto['categoria']]['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']];
                            $categoria = $curso_corto['categoria'];
                        }
                        ?>
                        </h3>
                        <h4>
                            <?= '<a href="cursos.php?cod_curso=' . $curso_corto['cod_curso'] .'"> - ' . $curso_corto['nombre_'.$_SESSION['idioma_seleccionado']['cod_idioma']] . '</a>'?>
                            <?php 
                                $cupo = false;
                                $respuesta = getCursoConCupo($id_filial, $curso_corto['cod_curso']);
                                
                                if($respuesta)
                                {
                                    foreach ($respuesta as $curso)
                                    {
                                        if($curso['cupo'] > $curso['inscriptos'])
                                        {
                                            $cupo = true;
                                            break;
                                        }
                                    }
                                }    
                                if($cupo)
                                {
                                    echo "<span class='cupoDisponible'> - " . $lenguaje['cupo_disponible_'.$_SESSION['idioma_seleccionado']['cod_idioma']] . "</span>";
                                }
                            ?>
                        </h4>
                            <?php 
                               
                                /*
                                 * $datosCurso = getCursoConCupo($id_filial, $curso_corto['cod_curso']);
                                if(isset($datosCurso[0]['cupo']) && $datosCurso[0]['cupo'] != '' && $datosCurso[0]['cupo'] !== '0' && $datosCurso[0]['cupo'] !== 0)
                                {
                                    echo '<span>' . $lenguaje['inscripcion_abierta_'.$_SESSION['idioma_seleccionado']['cod_idioma']] . '</span>';
                                }
                                 * 
                                 */
                            ?>
                    </div>
                    <?php } ?>
                </div><!--/.col-md-8-->
                <div class="col-sm-4">
                    <br>
                    <?php
                    $novedad = getNovedades($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['id_idioma'], 1);
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
                                    <p><?=substr($novedad[0]['descripcion'],0,250) . '...'?></p>
                                    <br>
                                    <span>
                                        <a href="novedades.php?id=<?=$novedad[0]['id']?>">
                                            <?=$lenguaje['ver_mas_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>
                                        </a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div><!--/.categories-->
                    <?php
                    }
                    ?>
                </div>

            </div><!--/.row-->
        </section><!--/#single_cursos-->
        <?php
            include_once 'gestor/includes/footer.php';
        ?>
<?php
}else{
    $showModal = 1;
}
?>
        <!-- Modal -->
        <div class="modal fade" id="selectFilialModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-keyboard="false" data-backdrop="static">
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
            filialModalSeleccionadaCC($(this).val());
        });
        
        function ocultarDivReserva(id){
            $('#reserva-'+id).removeClass("collapse in");
            $('#reserva-'+id).addClass("collapse");
        }

        function ocultarDivConsulta(id){
            $('#consulta-'+id).removeClass("collapse in");
            $('#consulta-'+id).addClass("collapse");
        }
        </script>
        <script>
        $(document).ready(function(){
            var showModal = <?=$showModal?>;
            if(showModal === 1){
                $('#selectFilialModal').modal('show');
            }
            
            //Asigno al desplegable de provincias, el valor por defecto que se selecciono en el modal
            $("select#provincias option[value='<?=$prov['id_provincia']?>']").attr('selected','selected');
            
            //Traigo la informacion de los cupos disponibles
            $.ajax({
                url: "gestor/controller_ajax.php",
                method: "POST",
                data: { 
                    option : 'select_filiales', 
                    id_provincia : '<?=$prov['id_provincia']?>'
                },
                dataType: "json",
                success: function(data){
                    changeSelectOptions("filiales_matricula", data.options, 'nombre', 'id');
                    $("select#filiales_matricula option[value='<?=$_SESSION['id_filial']?>']").attr("selected", "selected");
                }
            });
            
            function changeSelectOptions(select_id, array_index, texto, value){
                var options, index, select, option;

                // Get the raw DOM object for the select box
                select = document.getElementById(select_id);

                // Clear the old options
                select.options.length = 0;

                // Load the new options
                options = array_index; // Or whatever source information you're working with
                select.options.add(new Option('- Seleccione -', '0'));
                for (index = 0; index < options.length; ++index) {
                    option = options[index];
                    select.options.add(new Option(option[texto], option[value]));
                }
            }
            
            $('#form-matricula').removeClass('formularioCursosCortos');

        });
        
        </script>
    </body>
</html>



