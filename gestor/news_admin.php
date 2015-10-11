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

if(isset($_GET['id'])){
    $accion = 'editar';
    $id_novedad = $_GET['id'];
    $novedad = getNovedad($mysqli, $_GET['id']);
}else{
    $id_novedad = '';
    $accion = 'agregar';
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Dashboard">
        <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        
        <title>Administracion de Novedaes - IGA</title>
        
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
                <section class="wrapper site-min-height">
                    <h3><i class="fa fa-angle-right"></i><?php echo ($accion == 'agregar')?"Nueva noticia":"Edicion de noticia"?></h3>
                    <form method="POST" action="upload.php" id="form_change" enctype="multipart/form-data">
                        <input type="hidden" name="id_novedad" id="id_novedad" value="<?=$id_novedad?>" />
                        <input type="hidden" name="accion" id="accion" value="<?=$accion?>" />
                        <input type="hidden" name="edicion_noticia" id="edicion_noticia" value="true" />
                        
                        <div class="row mt">
                            <div class="col-lg-12">
                                <div class="form-panel">
                                    <div id="datos_curso">
                                        <div class="form-group">
                                            <label>Pais </label>
                                            <select name="pais" id="pais" class="form-control">
                                                <option value="0">- Seleccione -</option>
                                                <?php
                                                    $paises = getPaises($mysqli);
                                                    foreach($paises as $i=>$d){
                                                        $selected = '';
                                                        if(isset($novedad['id_pais']) && $novedad['id_pais'] == $d['id']){
                                                            $selected = "selected = 'selected'";
                                                        }
                                                ?>
                                                        <option value="<?=$d['id']?>" <?=$selected?> ><?=$d['pais']?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                            
                                            <label>Idioma</label>
                                            <select name="idioma" id="idioma" class="form-control">
                                                <option value="0">- Seleccione -</option>
                                                <?php
                                                    $idiomas = getIdiomas($mysqli);
                                                    foreach($idiomas as $i=>$d){
                                                        $selected = '';
                                                        if(isset($novedad['id_idioma']) && $novedad['id_idioma'] == $d['id']){
                                                            $selected = "selected = 'selected'";
                                                        }
                                                ?>
                                                <option value="<?=$d['id']?>" <?=$selected?> ><?=$d['idioma']?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Titulo:</b></h4> 
                                            <input type="text" id="titulo" name="titulo" value="<?php echo (isset($novedad['titulo']))?$novedad['titulo']:''; ?>" class="form-control"/>
                                        </div>
                                        <div class="form-group">
                                           <div id="sliderPreview">
                                              <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Imagen:</b></h4> 
                                              <img class="img-responsive animated fadeInLeftBig" id="imagePreview" src="../images/novedades/<?=$novedad['imagen']?>" alt="">
                                           </div>
                                           <input id="imagen" type="file" name="imagen" class="img"/>
                                        </div>

                                        <div class="form-group">
                                            <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Descripción:</b></h4> 
                                            <textarea name="descripcion" id="descripcion" class="form-control" rows="5"><?=$novedad['descripcion']?></textarea>
                                        </div>
                                        
                                        <div class="form-group">
                                            <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Link:</b></h4> 
                                            <input type="text" id="link" name="link" value="<?php echo (isset($novedad['link']))?$novedad['link']:''; ?>" class="form-control"/>
                                        </div>

                                    </div>    
                                </div><!-- /form-panel -->
                            </div><!-- /col-lg-12 -->
                        </div><!-- /row --> 
                        <br/>
                        <div class="row mt">
                            <div class="col-lg-12">
                                <button id="confirm" class="btn btn-success">Guardar cambios</button>
                            </div><!-- /col-lg-12 -->
                        </div><!-- /row --> 
                    </form>
                </section>
            </section><!-- /MAIN CONTENT -->
            <!--main content end-->
            <?php include_once 'footer.php'; ?>
        </section>
        
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
        <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
        
        <!--common script for all pages-->
        <script src="assets/js/common-scripts.js"></script>
        <!--script for this page-->
        <script type="text/javascript" src="assets/js/ckeditor/ckeditor.js"></script>
        
        <script type="text/javascript">
            CKEDITOR.replace( 'descripcion', {
                //uiColor: '#010F2C',
                customConfig: 'config.js',
                toolbar: [
                        [ 'Bold', 'Italic', 'FontSize']
                ]
            });
            
            var descripcion = '<?php echo (isset($novedad['descripcion']))?$novedad['descripcion']:''; ?>';
            CKEDITOR.instances['descripcion'].setData(descripcion);
            
            $('#confirm').click(function(){
                $('#form_change').submit();
            });
        </script>
    </body>
</html>
