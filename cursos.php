<?php
session_start();

include_once 'gestor/includes/functions.php';
include_once 'gestor/includes/lenguaje.php';

$pagina = 'cursos';

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
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="" />
        <title><?=$lenguaje['titulo_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></title>
        <link href="css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/animate.min.css" rel="stylesheet" /> 
        <link href="css/font-awesome.min.css" rel="stylesheet" />
        <link href="css/lightbox.css" rel="stylesheet" />
        <link href="css/main.css" rel="stylesheet" />
        <link id="css-preset" href="css/presets/preset1.css" rel="stylesheet" />
        <link href="css/responsive.css" rel="stylesheet" />
        <link href="css/intlTelInput.css" rel="stylesheet" />
        
        <link rel="stylesheet" type="text/css" media="screen" href="styles_home.php?cod_curso=<?=$_GET['cod_curso']?>" />
        <!--[if lt IE 9]>
          <script src="js/html5shiv.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
        
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css' />
        <link rel="shortcut icon" href="images/favicon.ico" />
        
        <?php
            
            function imprimirDuracion($datos_curso, $lenguaje)
            {
                                    $alguno = false;
                                    
                                    if(isset($datos_curso['horas']) && $datos_curso['horas'] != 0)
                                    {
                                        $alguno = true;
                                        if($datos_curso['horas'] > 1)
                                        {
                                            echo $datos_curso['horas']. ' ' . $lenguaje['horas_'.$_SESSION['idioma_seleccionado']['cod_idioma']];
                                        }
                                        else
                                        {
                                            echo $datos_curso['horas']. ' ' . $lenguaje['hora_'.$_SESSION['idioma_seleccionado']['cod_idioma']];
                                        }
                                    }
                                    
                                    if(isset($datos_curso['meses']) && $datos_curso['meses'] != '0')
                                    {
                                        if($alguno)
                                        {
                                            echo ', ';
                                        }
                                        else
                                        {
                                            $alguno = true;
                                        }
                                        
                                        if($datos_curso['meses'] == '1')
                                        {
                                            echo $datos_curso['meses']. ' ' . $lenguaje['mes_'.$_SESSION['idioma_seleccionado']['cod_idioma']];
                                        }
                                        else
                                        {
                                            echo $datos_curso['meses']. ' ' . $lenguaje['meses_'.$_SESSION['idioma_seleccionado']['cod_idioma']];
                                        }
                                        
                                    }
                                    
                                    if(isset($datos_curso['anios']) && $datos_curso['anios'] != 0)
                                    {
                                        if($alguno)
                                        {
                                            echo ', ';
                                        }
                                        else
                                        {
                                            $alguno = true;
                                        }
                                        
                                        if($datos_curso['anios'] > 1)
                                        {
                                            echo $datos_curso['anios']. ' ' . $lenguaje['anios_'.$_SESSION['idioma_seleccionado']['cod_idioma']];
                                        }
                                        else
                                        {
                                            echo $datos_curso['anios']. ' ' . $lenguaje['anio_'.$_SESSION['idioma_seleccionado']['cod_idioma']];
                                        }
                                        
                                    }
            }
            
        ?>
        
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
    
    $prov = getProvinciaFromFilial($mysqli,$_SESSION['id_filial']);
    
    $datos_curso = getDatosCurso($mysqli, $cod_curso, $id_idioma, $id_filial);
    
    $malla_curricular = getMallaCurricular($mysqli, $datos_curso['id_cfi']);
    
    $es_curso_corto = esCursosCortos($mysqli, $cod_curso, $_SESSION['pais']['id']);
?>
        <div id="fb-root"></div>
        
        <?php 
            include_once 'gestor/includes/header.php';
        ?>
        
        <?php
        if($datos_curso['url_cabecera'] != '' && !$es_curso_corto){
        ?>
        <section id="head_image_curso">
            <!--style="background-color: <?=$datos_curso['color']?>"-->
            <div class="hidden-xs"  >
                <div class="container">
                    <h2 style="position:absolute;padding-top:8%;left:10%;z-index: 99;">
                        <span>
                            <p style="font-size:60px;color:white;width:450px;font-weight:600;"><?=$datos_curso['nombre']?></p>
                        </span>
                    </h2>
                </div>
                <img style="margin: 0 auto;width: 100%" src="<?=$datos_curso['url_cabecera']?>" class="img-responsive animated fadeInLeftBig" />
            </div>
            
            <div class="visible-xs" >
                <img style="margin: 0 auto;" src="<?=$datos_curso['url_cabecera']?>" class="img-responsive" />
                <div class="row col-md-12 text-center">
                    <h2 style="color:<?=$datos_curso['color']?>"><?=$datos_curso['nombre']?></h2>
                </div>
            </div>
        </section>
        <?php } else { ?>
        <!--<section id="head_image_curso">
            <div class="hidden-xs"  style="background-color: <?=$datos_curso['color']?>">
                <div class="container">
                    <h2 style="padding-top:4%;left:10%">
                        <span>
                            <p style="font-size:60px;color:<?=$datos_curso['color']?>;width:450px;font-weight:600;"><?=$datos_curso['nombre']?></p>
                        </span>
                    </h2>
                </div>
            </div>
            <div class="visible-xs" >
                <div class="row col-md-12 text-center">
                    <h2 style="color:<?=$datos_curso['color']?>"><?=$datos_curso['nombre']?></h2>
                </div>
            </div>
        </section>-->
        <?php } ?>
        <section id="single_curso" class="container">
            <div class="row">
                <div class="col-sm-7">
                    <div id="curso">
                        <?php
                        if($datos_curso['url_cabecera'] == ''){
                        ?>
                        <h2><?=$datos_curso['nombre']?></h2>
                        <?php
                        }
                        ?>
                        <div class="entry-meta">
                            <span>
                                <i class="fa fa-calendar"></i>&nbsp;<?=$lenguaje['duracion_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>:
                                <?php 
                                    imprimirDuracion($datos_curso, $lenguaje);
                                ?>
                            </span>
                        </div>
                        <br/>
                        <?=$datos_curso['descripcion']?>
                    </div>
                    <div id="cursado_planes">
                        <h3><?=$lenguaje['cursado_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h3>
                        <p><?=$lenguaje['desc_cursado_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></p>
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
                        
                        <div class="table-responsive" id="matricula_curso" style="display: none">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="9" class="text-center"><?=$lenguaje['planilla_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></th>
                                    </tr>
                                </thead>
                                
                                <tbody  style="font-size:11px">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div id="meterial_curso" >
                        <h3><?=$lenguaje['material_estudio_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h3>
                        <div class="well">
                            <div class="media">
                                <div class="pull-left">
                                    <img class="avatar img-thumbnail" src="<?=$datos_curso['url_material']?>" alt="">
                                </div>
                                <div class="media-body">
                                    <?=$datos_curso['desc_material']?>
                                </div>
                            </div>
                        </div><!--/.author-->
                    </div>    
                    <? if (!empty($datos_curso['url_uniforme'])) : ?>
                    <div id="uniformes" >
                        <h3><?=$lenguaje['uniforme_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h3>
                        <div class="well">
                            <div class="media">
                                <div class="pull-left">
                                    <img class="avatar img-thumbnail" src="<?=$datos_curso['url_uniforme']?>" alt="">
                                </div>
                                <div class="media-body">
                                    <?=$datos_curso['desc_uniforme']?>
                                </div>
                            </div>
                        </div><!--/.author-->
                    </div>
                    <? endif; ?>
                    <!--
                        <div id="malla_curricular" >
                        <h3><?=$lenguaje['malla_curricular_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h3>
                        <div class="well">
                            <div class="table">
                                <?php 
                                    $cuatri = 0;
                                    foreach ($malla_curricular as $malla)
                                    {
                                        $cuatrimestre = $malla['cuatrimestre'];
                                        $materia = $malla['materia'];
                                        
                                        if($cuatri != $cuatrimestre)
                                        {
                                            switch ($cuatrimestre)
                                            {
                                                case 1 :
                                                    echo "<h3>1er cuatrimestre</h3>";
                                                    break;
                                                case 2 :
                                                    echo "<h3>2do cuatrimestre</h3>";
                                                    break;
                                                case 3 :
                                                    echo "<h3>3er cuatrimestre</h3>";
                                                    break;
                                                case 4 :
                                                    echo "<h3>4to cuatrimestre</h3>";
                                                    break;
                                            }
                                            $cuatri ++;
                                        }
                                        echo "<h4>" . $materia . "</h4>";
                                    }
                                ?>
                            </div>
                        </div>
                    </div>-->
                    <br/>
                    <div id="objetivo">
                        <h2><?=$lenguaje['objetivos_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></h2>
                        <div class="entry-meta">
                            <span>
                                <i class="fa fa-calendar"></i>&nbsp;<?=$lenguaje['duracion_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>:
                                
                                <?php 
                                    imprimirDuracion($datos_curso, $lenguaje);
                                ?>
                                
                                
                                
                            </span>
                        </div>
                    <?=$datos_curso['objetivos']?>
                    </div>
                </div><!--/.col-md-7-->
                <div class="col-sm-1"></div>
                <div class="col-sm-4">
                    <br>
                    <?php
                    $novedades = getNovedades($mysqli, $_SESSION['pais']['id'], $_SESSION['idioma_seleccionado']['id_idioma'], 3);
                    if(count($novedades) > 0){
                    ?>
                    <div class="widget ads">
                        <div class="row">
                            <div class="col-sm-12 wow fadeInUp text-center" data-wow-duration="1000ms" data-wow-delay="400ms">
                            <?php
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
        <script type="text/javascript" src="js/phoneValidation/intlTelInput.js"></script>
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
                    cod_curso : '<?=$_GET['cod_curso']?>', 
                    id_provincia : '<?=$prov['id_provincia']?>'
                },
                dataType: "json",
                success: function(data){
                    changeSelectOptions("filiales_matricula", data.options, 'nombre', 'id');
                    $("select#filiales_matricula option[value='<?=$_SESSION['id_filial']?>']").attr("selected", "selected");
                    
                    getCursosConCupo($('#filiales_matricula').val(), '<?=$_GET['cod_curso']?>');
                    
                    $('#matricula_curso').show();
                }
            });
            
            $('#provincias').change(function(){
                $('#matricula_curso').hide();
            });
            
            $('#filiales_matricula').change(function(){
                getCursosConCupo($(this).val(), '<?=$_GET['cod_curso']?>');
                $('#matricula_curso').show();
            });
            
            
            
            function getCursosConCupo(id_filial, cod_curso){
                $('.table-bordered > tbody').html("<tr><td colspan='8' class='text-center'><img src='images/preloader.gif' /><br/>Cargando Información..</td></tr>");
                $.ajax({
                    url: "gestor/controller_ajax.php",
                    method: "POST",
                    data: {
                        option : 'get_cursos_con_cupo', 
                        cod_curso : cod_curso, 
                        id_filial : id_filial
                    },
                    success: function(data){
                        $('.table-bordered > tbody').html(data);
                    }
                });
            }
            
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
            

        });
        
        function reservarCupo(formid, boton, errorid){
            var btn = $(boton).button('loading');
            $.ajax({
                url: "gestor/controller_ajax.php",
                method: "POST",
                data: {
                    option : 'reserva_cupo',
                    nombre: $("#"+formid+" input[name=name]").val(),
                    email: $("#"+formid+" input[name=email]").val(),
                    telefono: $("#"+formid+" input[name=telefono]").val(),
                    id_comision: $("#"+formid+" input[name=id_comision]").val(),
                    id_filial: $("#"+formid+" input[name=id_filial]").val(),
                    id_plan: $("#"+formid+" input[name=id_plan]").val(),
                    recaptcha: $("#"+formid+" textarea[name=g-recaptcha-response]").val()
                },
                dataType: 'json',
                success: function(data){
                    console.log(data);
                    btn.button('reset');
                    if(data.success){
                        $('#'+formid).html("<div class='text-center text-reserva-ok'>"+data.mensaje+"</div>");
                    }else{
                        $('#'+errorid).html(data.mensaje);
                    }
                }
            });
        }
    
        function consultarCurso(formid, boton, coursecontact, errorid){
            $(boton).button('loading');
            $.ajax({
                type: "POST",
                url: "gestor/controller_ajax.php",
                data: {
                    option:"enviar_consulta",
                    nombre: $("#"+formid+" input[name=name]").val(),
                    email: $("#"+formid+" input[name=email]").val(),
                    phone: $("#"+formid+" input[name=phone]").val(),
                    message: $("#"+formid+" textarea[name=mensaje]").val(),
                    filial: $("#"+formid+" input[name=id_filial]").val(),
                    coursecontact: coursecontact,
                    id_comision: $("#"+formid+" input[name=id_comision]").val(),
                    id_plan: $("#"+formid+" input[name=id_plan]").val(),
                    cod_curso: $("#"+formid+" input[name=cod_curso]").val(),
                    tipo: "3",
                    recaptcha: $("#"+formid+" textarea[name=g-recaptcha-response]").val()
                },
                dataType:'json',
                success: function(data)
                {
                    $(boton).button('reset');
                    if(data.success){
                        $('#'+formid).html("<div class='text-center text-reserva-ok'>"+data.mensaje+"</div>");
                    }else{
                        $('#'+errorid).html(data.mensaje);
                    }
                }
            });
        }
        </script>
    </body>
</html>

