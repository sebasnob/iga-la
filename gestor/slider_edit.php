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

$sliderArray = getSlider($mysqli);
$paises = getPaises($mysqli);
$idiomas = getIdiomas($mysqli);


?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        
        <title>Editor Slider - IGA</title>
        
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
                    <h3><i class="fa fa-angle-right"></i>Edicion Slider </h3>
                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="form-panel">
                                <h4><i class="fa fa-angle-right"></i> Nueva Imagen</h4>
                                <section id="editor_grilla_nueva">
                                    <form  enctype="multipart/form-data" method="POST" action="upload.php" class="form">
                                        <input type="hidden" name="edicion_slider" id="edicion_slider" value="true" />
                                        <input type="hidden" name="edicion_slider_nueva" id="edicion_slider_nueva" value="true" />
                                        <div class="form-group">
                                            <input type="file" accept="file_extension|image" class="form-control" name="photo" required autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Link: </label>
                                            <input type="text" id="link" name="link" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Alt: </label>
                                            <input type="text" id="alt" name="alt" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Pais: </label>
                                            <select class="form-control" name="id_pais">
                                                <?php foreach ($paises as $pais){ ?>
                                                <option value="<?=$pais['id']?>"><?=$pais['pais']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Idioma: </label>
                                            <select class="form-control" name="cod_idioma">
                                                <?php foreach ($idiomas as $idioma){ ?>
                                                <option value="<?=$idioma['cod_idioma']?>"><?=$idioma['idioma']?></option>
                                                <?php }?>
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
                            <div class="form-panel">
                                
                                <section id="editor_grilla_editar" style="display: inline-block;">
                                    <h4><i class="fa fa-angle-right"></i> Editar Slider</h4>
                                    
                                <?php foreach ($sliderArray as $imgSlider){?>
                                    <div class="col-md-4">
                                        <form  enctype="multipart/form-data" method="POST" action="upload.php">
                                            <input type="hidden" name="edicion_slider" id="edicion_slider" value="true" />
                                            <input type="hidden" name="edicion_slider_editar" id="edicion_slider_editar" value="true" />
                                            <input type="hidden" name="id_img_slider" id="id_img_slider" value="<?php echo $imgSlider['id']?>" />
                                            <div class="form-group">
                                                <div class="form-img">
                                                    <img src="../<?=$imgSlider['thumb']?>">
                                                </div>
                                                <input type="file" accept="file_extension|image" name="photo" autofocus>
                                            </div>
                                            <div class="form-group">
                                                <label>Link:</label>
                                                <input type="text" id="link" name="link" class="form-control" value="<?=$imgSlider['link']?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Alt:</label>
                                                <input type="text" id="alt" name="alt" class="form-control" value="<?=$imgSlider['alt']?>">
                                            </div>
                                            <div class="form-group">
                                                <label>Pais:</label>
                                                <select class="form-control input-sm"  name="id_pais">
                                                <?php foreach ($paises as $pais){ ?>
                                                    <option value="<?=$pais['id']?>" <?php if($pais['id'] == $imgSlider['id_pais']){echo 'selected';} ?> ><?=$pais['pais']?></option>
                                                <?php }?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Idioma: </label>
                                                <select class="form-control input-sm"  name="cod_idioma">
                                                <?php foreach ($idiomas as $idioma){ ?>
                                                    <option value="<?=$idioma['cod_idioma']?>" <?php if($idioma['cod_idioma'] == $imgSlider['cod_idioma']){echo 'selected';} ?> ><?=$idioma['idioma']?></option>
                                                <?php }?>
                                                </select>
                                            </div>
                                            <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Que desea realizar?</b></h4>
                                            <div class="row mt">
                                                <div class="col-lg-12">
                                                    <button type="submit" class="btn btn-success">Editar</button>
                                                    <button type="button" onclick="borrar(this.form)" class="btn btn-danger">Borrar</button>
                                                </div>
                                            </div>
                                            <br>
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