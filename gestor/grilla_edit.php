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

$cursos = getCursos($mysqli);
$gridArray = getImagenesGrilla($mysqli);
$paises = getPaises($mysqli);

?>
<!DOCTYPE html>

 <html lang="en">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    
    <title>Listado de Cursos - IGA</title>

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
                                            
                                            <input type="file" accept="file_extension|image" class="form-control" name="photo" required autofocus>
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
                                        <button type="submit" class="btn btn-success">Agregar Imagen</button>
                                    </form>
                                </section>
                            </div><!-- /content-panel -->
                        </div>
                    </div>
                    <div class="row mt">
                        <div class="col-md-12">
                            <div class="content-panel">
                                <section id="editor_grilla_editar" style="display: inline-block;">
                                <h4><i class="fa fa-angle-right"></i> Editar Grilla</h4>
                                
                                <?php foreach ($gridArray as $imgGrid){?>
                                    <div class="col-md-4">
                                        <form class="form" enctype="multipart/form-data" method="POST" action="upload.php">
                                            <input type="hidden" name="edicion_grilla" id="edicion_grilla" value="true" />
                                            <input type="hidden" name="edicion_grilla_editar" id="edicion_grilla_editar" value="true" />
                                            <input type="hidden" name="id_img_grilla" id="id_img_grilla" value="<?php echo $imgGrid['id']?>" />
                                            <div class="form-group">
                                                <div>
                                                <img src="../<?php echo $imgGrid['thumb_url']?>">
                                                </div>
                                                <input type="file" accept="file_extension|image" class="form-control" name="photo" autofocus>
                                            </div>
                                            <div class="form-group">
                                                <label >Columnas: </label>
                                                <select name="cols">
                                                    <option value="3" <?php if($imgGrid['cols'] == 3){echo 'selected';}?>>1</option>
                                                    <option value="6" <?php if($imgGrid['cols'] == 6){echo 'selected';}?>>2</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label >Posici&oacute;n: </label>
                                                <select name="prioridad">
                                                    <option value="1" <?php if($imgGrid['prioridad'] == 1){echo 'selected';}?>>1</option>
                                                    <option value="2" <?php if($imgGrid['prioridad'] == 2){echo 'selected';}?>>2</option>
                                                    <option value="3" <?php if($imgGrid['prioridad'] == 3){echo 'selected';}?>>3</option>
                                                    <option value="4" <?php if($imgGrid['prioridad'] == 4){echo 'selected';}?>>4</option>
                                                    <option value="5" <?php if($imgGrid['prioridad'] == 5){echo 'selected';}?>>5</option>
                                                    <option value="6" <?php if($imgGrid['prioridad'] == 6){echo 'selected';}?>>6</option>
                                                    <option value="7" <?php if($imgGrid['prioridad'] == 7){echo 'selected';}?>>7</option>
                                                    <option value="8" <?php if($imgGrid['prioridad'] == 8){echo 'selected';}?>>8</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label >Curso: </label>
                                                <select name="id_curso">
                                                    <?php foreach($cursos as $i=>$j){?>
                                                        
                                                        <option value="<?=$j['cod_curso']?>"  <?php if($imgGrid['id_curso'] == $j['cod_curso']){echo 'selected';}?>><?=$j['nombre_es']?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label >Habilitado: </label>
                                                <select name="habilitado">
                                                    <option value="1" <?php if($imgGrid['habilitado'] == 1){echo 'selected';}?>>Si</option>
                                                    <option value="0" <?php if($imgGrid['habilitado'] == 0){echo 'selected';}?>>No</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-2 col-sm-2 control-label">Pais: </label>
                                                <select class="form-control" name="pais">
                                                    <?php foreach($paises as $pais){?>
                                                        <option value="<?=$pais['id']?>" <?php if($pais['id'] == $imgGrid['id_pais']){ echo 'selected';}?>><?=$pais['pais']?></option>
                                                    <?php }?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label >Idioma: </label>
                                                <select name="idioma">
                                                    <option value="es" <?php if($imgGrid['idioma'] == 'es'){echo 'selected';}?>>Espa&ntilde;ol</option>
                                                    <option value="in" <?php if($imgGrid['idioma'] == 'en'){echo 'selected';}?>>Ingles</option>
                                                    <option value="pt" <?php if($imgGrid['idioma'] == 'pt'){echo 'selected';}?>>Portugues</option>
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-success">Editar</button>
                                            <button type="button" onclick="borrar(this.form)" class="btn btn-danger">Borrar</button>
                                        </form>
                                    </div>
                                <?php } ?>
                                </section>        
                            </div>
                        </div>    
                    </div><!-- /row -->
                    
                    
                    
                </section><! --/wrapper -->
            </section><!-- /MAIN CONTENT -->
            
            <!--main content end-->
            <?php include_once 'footer.php';?>
        </section>
        
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/forms.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
        
        
        <!--common script for all pages-->
        <script src="assets/js/common-scripts.js"></script>
        
        <!--script for this page-->
        
        
    </body>
</html>
