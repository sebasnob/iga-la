<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}

if($logged == 'out'){
    header("Location: login.php");
    exit();
}

$pais_filtro = 0;
if(isset($_GET['pais_filtro'])){
    $pais_filtro = $_GET['pais_filtro'];
}
$idioma_filtro = 0;
if(isset($_GET['idioma_filtro'])){
    $idioma_filtro = $_GET['idioma_filtro'];
}
$tipo_filtro = 0;
if(isset($_GET['tipo_filtro'])){
    $tipo_filtro = $_GET['tipo_filtro'];
}

$habilitado_filtro = 3;
if(isset($_GET['habilitado_filtro'])){
    $habilitado_filtro = $_GET['habilitado_filtro'];
}
$id_curso_filtro = 0;
if(isset($_GET['id_curso_filtro'])){
    $id_curso_filtro = $_GET['id_curso_filtro'];
}

$cursos = getCursos($mysqli);
$gridArray = getImagenesGrilla($mysqli, $idioma_filtro, $pais_filtro, $tipo_filtro, $habilitado_filtro, $id_curso_filtro);
$paises = getPaises($mysqli);

?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        
        <title>Editor de Grilla - IGA</title>
        
        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
        <!-- Custom styles for this template -->
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/style-responsive.css" rel="stylesheet">
        <link href="assets/css/table-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css"> 
        
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
        DIV.table 
        {
            display:table;
        }
        FORM.tr, DIV.tr
        {
            display:table-row;
        }
        SPAN.td
        {
            display:table-cell;
            width: 10%;
        }
        </style>
    </head>
    
    <body>
        
        <section id="container" >
    <?php include_once 'header.php'; ?>
            
    <?php include_once 'sidebar.php'; ?>
            <!-- **********************************************************************************************************************************************************
             MAIN CONTENT
             *********************************************************************************************************************************************************** -->
            <!--main content start-->
            <section id="main-content">
                <section class="wrapper">
                    <h3><i class="fa fa-angle-right"></i>Edicion de Grilla Cursos </h3>
                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="form-panel">
                                <h4><i class="fa fa-angle-right"></i> Nueva Imagen de Curso</h4>
                                <section id="editor_grilla_nueva">
                                    <form class="form" enctype="multipart/form-data" method="POST" action="upload.php">
                                        <input type="hidden" name="edicion_grilla" id="edicion_grilla" value="true" />
                                        <input type="hidden" name="edicion_grilla_nueva" id="edicion_grilla_nueva" value="true" />
                                        <div class="form-group">
                                            <input type="file" accept="file_extension|image"  id="photo" name="photo" required autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Columnas:</label>
                                            <select class="form-control" name="cols">
                                                <option value="3">1</option>
                                                <option value="6">2</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Posici&oacute;n: </label>
                                            <select class="form-control" name="prioridad">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Curso: </label>
                                            <select class="form-control" name="id_curso">
                                                <?php foreach($cursos as $i=>$j){?>
                                                <option value="<?=$j['cod_curso']?>"><?=$j['nombre_es']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Tipo: </label>
                                            <select class="form-control" name="tipo">
                                                <option value="1">Curso</option>
                                                <option value="2">Curso Corto</option>
                                                <option value="3">Cocineritos</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Habilitado: </label>
                                            <select class="form-control" name="habilitado">
                                                <option value="1">Si</option>
                                                <option value="0">No</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Pais: </label>
                                            <select class="form-control" name="pais">
                                                <?php foreach($paises as $pais){?>
                                                <option value="<?=$pais['id']?>"><?=$pais['pais']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Idioma: </label>
                                            <select class="form-control" name="idioma">
                                                <option value="es">Espa&ntilde;ol</option>
                                                <option value="en">Ingles</option>
                                                <option value="pt">Portugues</option>
                                            </select>
                                        </div>
                                        <button onclick="enviar(this.form)" class="btn btn-success">Agregar Imagen</button>
                                        <div id="cargando"  style="width: 50px;margin-left: 30px;display: none;">
                                            <img src="../images/preloader.gif">
                                            <span>Cargando...</span>
                                        </div>
                                    </form>
                                </section>
                            </div><!-- /content-panel -->
                        </div>
                    </div>
                    
                    <div class="row mt">
                        <div class="col-md-12">
                            <div class="form-panel">
                                <section id="editor_grilla_editar" style="display: inline-block; width: 100%;">
                                    <h4><i class="fa fa-angle-right"></i> Editar Grilla</h4>
                                    <div class="col-md-12" id="filtro_grilla">
                                        <div class="tr form-inline">
                                            <span class="td">
                                                <label for="curso">Curso:</label>
                                                <select class="form-control input-sm" id="id_curso_filtro">
                                                    <option value="0">Seleccione</option>
                                                    <?php foreach($cursos as $i=>$j){?>
                                                        <option <?php if($j['cod_curso'] == $id_curso_filtro){ echo 'selected';}?> value="<?=$j['cod_curso']?>"><?=$j['nombre_es']?></option>
                                                    <?php }?>
                                                </select>
                                            </span>
                                            <span class="td">
                                                <label for="tipo">Tipo:</label>
                                                <select class="form-control input-sm" id="tipo_filtro">
                                                    <option value="0" <?php if(0 == $tipo_filtro){ echo 'selected';}?>>Seleccione</option>
                                                    <option value="1" <?php if(1 == $tipo_filtro){ echo 'selected';}?>>Cursos</option>
                                                    <option value="2" <?php if(2 == $tipo_filtro){ echo 'selected';}?>>Cursos Cortos</option>
                                                    <option value="3" <?php if(3 == $tipo_filtro){ echo 'selected';}?>>Cocineritos</option>
                                                </select>
                                            </span>
                                            <span class="td">
                                                <label for="habilitado">Habilitado: </label>
                                                <select class="form-control input-sm" id="habilitado_filtro">
                                                    <option value="3" <?php if(3 == $habilitado_filtro){ echo 'selected';}?>>Todos</option>
                                                    <option value="0" <?php if(0 == $habilitado_filtro){ echo 'selected';}?>>No</option>
                                                    <option value="1" <?php if(1 == $habilitado_filtro){ echo 'selected';}?>>Si</option>
                                                </select>
                                            </span>
                                            <span class="td">
                                                <label for="curso">Pais:</label>
                                                <select class="form-control input-sm" id="pais_filtro">
                                                    <option value="0">Seleccione</option>
                                                    <?php foreach($paises as $pais){?>
                                                    <option <?php if($pais['id'] == $pais_filtro){ echo 'selected';}?> value="<?=$pais['id']?>"><?=$pais['pais']?></option>
                                                    <?php }?>
                                                </select>
                                            </span>
                                            <span class="td">
                                                <label for="curso">Idioma: </label>
                                                <select class="form-control input-sm" id="idioma_filtro">
                                                    <option value="0" <?php if (0 === $idioma_filtro){ echo 'selected';}?>>Seleccione</option>
                                                    <option value="es" <?php if("es" === $idioma_filtro){ echo 'selected';}?>>Espa&ntilde;ol</option>
                                                    <option value="in" <?php if("in" === $idioma_filtro){ echo 'selected';}?>>Ingles</option>
                                                    <option value="pt" <?php if("pt" === $idioma_filtro){ echo 'selected';}?>>Portugues</option>
                                                </select>
                                            </span>  
                                            <span class="td">
                                             &nbsp;&nbsp;<a class="btn btn-primary " id="buscarGrilla"><i class="fa fa-search"></i></a>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="grilla_editor">
                                        <?php 
                                            foreach ($gridArray as $imgGrid){
                                        ?>
                                        <form enctype="multipart/form-data" method="POST" action="upload.php">
                                            <table style="margin-bottom: 25px; width: 100%;">
                                                <tbody>
                                                    <tr>
                                                        <input type="hidden" name="edicion_grilla" id="edicion_grilla" value="true" />
                                                        <input type="hidden" name="edicion_grilla_editar" id="edicion_grilla_editar" value="true" />
                                                        <input type="hidden" name="id_img_grilla" id="id_img_grilla" value="<?php echo $imgGrid['id']?>" />
                                                        <td style="width: 30%;">
                                                            <div>
                                                                <img src="../<?php echo $imgGrid['thumb_url']?>" width="100px" /><br/>
                                                                <input type="file" accept="file_extension|image" name="photo" autofocus style="display: -webkit-inline-box;"/>
                                                            </div>    
                                                        </td>
                                                        <td>
                                                            <span>Columnas: </span>
                                                            <select class="form-control input-sm" name="cols" style="display: inline-block">
                                                                <option value="3" <?php if($imgGrid['cols'] == 3){echo 'selected';}?>>1</option>
                                                                <option value="6" <?php if($imgGrid['cols'] == 6){echo 'selected';}?>>2</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <span>Prioridad: </span>
                                                            <select class="form-control input-sm" name="prioridad" style="display: inline-block">
                                                                <option value="1" <?php if($imgGrid['prioridad'] == 1){echo 'selected';}?>>1</option>
                                                                <option value="2" <?php if($imgGrid['prioridad'] == 2){echo 'selected';}?>>2</option>
                                                                <option value="3" <?php if($imgGrid['prioridad'] == 3){echo 'selected';}?>>3</option>
                                                                <option value="4" <?php if($imgGrid['prioridad'] == 4){echo 'selected';}?>>4</option>
                                                                <option value="5" <?php if($imgGrid['prioridad'] == 5){echo 'selected';}?>>5</option>
                                                                <option value="6" <?php if($imgGrid['prioridad'] == 6){echo 'selected';}?>>6</option>
                                                                <option value="7" <?php if($imgGrid['prioridad'] == 7){echo 'selected';}?>>7</option>
                                                                <option value="8" <?php if($imgGrid['prioridad'] == 8){echo 'selected';}?>>8</option>
                                                            </select>
                                                        </td>
                                                    </tr>    
                                                    <tr>    
                                                        <td>
                                                            <span>Curso: </span>
                                                            <select class="form-control input-sm" name="id_curso" style="display: inline-block">
                                                                        <?php foreach($cursos as $i=>$j){?>
                                                                <option value="<?=$j['cod_curso']?>"  <?php if($imgGrid['id_curso'] == $j['cod_curso']){echo 'selected';}?>><?=$j['nombre_es']?></option>
                                                                        <?php }?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <span>Tipo: </span>
                                                            <select class="form-control input-sm" name="tipo" style="display: inline-block">
                                                                <option value="1" <?php if($imgGrid['tipo'] == 1){echo 'selected';}?>>Cursos</option>
                                                                <option value="2" <?php if($imgGrid['tipo'] == 2){echo 'selected';}?>>Cursos Cortos</option>
                                                                <option value="3" <?php if($imgGrid['tipo'] == 3){echo 'selected';}?>>Cocineritos</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <span>Habilitado: </span>
                                                            <select class="form-control input-sm" name="habilitado" style="display: inline-block">
                                                                <option value="1" <?php if($imgGrid['habilitado'] == 1){echo 'selected';}?>>Si</option>
                                                                <option value="0" <?php if($imgGrid['habilitado'] == 0){echo 'selected';}?>>No</option>
                                                            </select>
                                                        </td>
                                                    </tr>    
                                                    <tr>    
                                                        <td>
                                                            <span>Pais: </span>
                                                            <select class="form-control input-sm" name="pais" style="display: inline-block">
                                                                        <?php foreach($paises as $pais){?>
                                                                <option value="<?=$pais['id']?>" <?php if($pais['id'] == $imgGrid['id_pais']){ echo 'selected';}?>><?=$pais['pais']?></option>
                                                                        <?php }?>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <span>Idioma: </span>
                                                            <select class="form-control input-sm" name="idioma" style="display: inline-block">
                                                                <option value="es" <?php if($imgGrid['idioma'] == 'es'){echo 'selected';}?>>Espa&ntilde;ol</option>
                                                                <option value="in" <?php if($imgGrid['idioma'] == 'en'){echo 'selected';}?>>Ingles</option>
                                                                <option value="pt" <?php if($imgGrid['idioma'] == 'pt'){echo 'selected';}?>>Portugues</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <button type="submit" class="btn btn-success">Aceptar</button>
                                                            <button type="button" onclick="borrar(this.form)" class="btn btn-danger">Borrar</button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </form>
                                        <hr>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                </section>
                            </div>    
                        </div>
                    </div>    
                </section>        
            </section><! --/wrapper -->
        </section><!-- /MAIN CONTENT -->
            
            <!--main content end-->
            <?php include_once 'footer.php';?>
        
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/forms.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
        <!--<script type="text/javascript" src="../js/main.js"></script>-->
        
        <!--common script for all pages-->
        <script src="assets/js/common-scripts.js"></script>
        <script>
            $(document).ready(function()
            {
               if($.get('accion') === 'filtrar')
               {
                   $('html, body').animate({
                        scrollTop: $("#editor_grilla_editar").offset().top - 100
                    }, 10);
               }
            });
        </script>
    </body>
</html>
