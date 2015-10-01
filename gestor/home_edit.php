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

if(isset($_GET['idioma'])){
	$idioma = $_GET['idioma'];
}else{
	$idioma = 'ES';
}

$datos_home = getDatosHome($mysqli);

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
                <h3><i class="fa fa-angle-right"></i>Edición de home </h3>
                 <form name="formEditHome" id="formEditHome" action="upload.php" method="POST" class="form-horizontal style-form">
                  <input type="hidden" name="edicion_home" id="edicion_home" value="true"/>
                  <input type="hidden" name="idioma" id="idioma" value="<?=$idioma?>"/>
                
                        <div class="row mt">
                            <div class="col-lg-12">
                             <div class="form-panel">
                               <h4 class="mb"><i class="fa fa-angle-right"></i> <b>URL Actual:</b></h4> 
                                <p><?=$datos_home['url_video']?></p>
                                    <section id="editor_home">

                                        <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Cambiar video:</b></h4> 
                                          <div class="form-group">
                                              <label class="col-sm-2 col-sm-2 control-label">PEGAR LA URL DEL VIDEO</label>
                                              <div class="col-sm-10">
                                                  <input type="text" name="url_video" id="url_video" class="form-control">
                                              </div>
                                            </div>


                                    </section>
                                </div><!-- /form-panel -->

                              </div><!-- /col-lg-12 -->
                        </div><!-- /row -->  
                                
                                 <div class="row mt">
                            <div class="col-lg-12">
                             <div class="form-panel">
                               <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Editar Colores:</b></h4> 
                                
                                     <section id="editor_menu">
                                       
                                          <div class="form-group">
                                              <label class="col-sm-2 col-sm-2 control-label">Color de Fondo:</label>
                                              <div class="col-sm-10">
                                                  <input type="color" id="select_color_fondo" value="<?=$datos_home['menu_color']?>"/>
                                                   <input type="text" readonly="" id="chose_color_fondo" name="chose_color_fondo" value="<?=$datos_home['menu_color']?>"/>
                                              </div>
                                            </div>
                                         <div class="form-group">
                                              <label class="col-sm-2 col-sm-2 control-label">Color de Fuente:</label>
                                              <div class="col-sm-10">
                                                  <input type="color" id="select_color_fondo" value="<?=$datos_home['fuente_color']?>"/>
                                                  <input type="text" readonly="" id="chose_color_fuente" name="chose_color_fuente" value="<?=$datos_home['fuente_color']?>" />

                                              </div>
                                            </div>

                                    </section>
                                </div><!-- /form-panel -->

                              </div><!-- /col-lg-12 -->
                        </div><!-- /row --> 
                        <hr>
                        <h4><i class="fa fa-angle-right"></i>Editar Texto del Home</h4>
                         <div class="row mt">
                            <div class="col-lg-12">
                                <div class="form-panel">
                                     <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Seleccionar idioma:</b></h4> 
                                    <?php
                                        $idiomas = getIdiomas($mysqli);
                                        foreach($idiomas as $i=>$j){
                                            if($j['cod_idioma']==$idioma){
                                                echo $j['cod_idioma']."&nbsp;/&nbsp;";
                                            }else{
                                                echo "<a href='home_edit.php?idioma=".$j['cod_idioma']."'>".$j['cod_idioma']."</a>&nbsp;/&nbsp;";
                                            }
                                        }
                                    ?>
                              </div>
                            </div>
                        </div>
                    
                        <div class="row mt">
                            <div class="col-lg-12">
                                <div class="form-panel">
                                     <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Editar Título Bienvenida (principal):</b></h4>
                                    <section id="editor_home">
                                        
                                        <textarea name="titulo" id="titulo" cols="150" rows="7">
                                            <?php
                                            switch($idioma){
                                                case 'IN':
                                                        echo $datos_home['titulo_in'];
                                                    break;
                                                case 'POR':
                                                        echo $datos_home['titulo_por'];
                                                    break;
                                                default: 
                                                        echo $datos_home['titulo_es'];
                                                    break;
                                            }
                                            ?>
                                            </h1>
                                        </textarea>
                                        <br/>
                                       <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Editar SubTítulo (principal):</b></h4>
                                        <textarea name="subtitulo" id="subtitulo" class="textos" cols="150" rows="5">
                                            <?php
                                            switch($idioma){
                                                case 'IN':
                                                        echo $datos_home['subtitulo_in'];
                                                    break;
                                                case 'POR':
                                                        echo $datos_home['subtitulo_por'];
                                                    break;
                                                default: 
                                                        echo $datos_home['subtitulo_es'];
                                                    break;
                                            }
                                            ?>
                                        </textarea>
                                    </section>
                                </div><!-- /form-panel -->
                            </div><!-- /col-lg-12 -->			
                        </div><!-- /row -->
                         <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Que desea realizar?</b></h4>
                        <div class="row mt">
                            <div class="col-lg-12">
                                
                                <button id="confirm" class="btn btn-success">Guardar cambios </button>
                                <a id="preview" class="btn btn-default" href="preview_home.php" target="_blank">Vista previa</a>
                                <button id="publicar" class="btn btn-primary">Publicar contenido</button>
                            
                        </div>
                      </div>
                    </form>
                   </section><! --/wrapper -->
                </section><!-- /MAIN CONTENT -->
            <!--main content end-->
            
            <?php include_once './footer.php'; ?>
        </section>
        
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
        
        
        <!--common script for all pages-->
        <script src="assets/js/common-scripts.js"></script>
        
        <script type="text/javascript" src="assets/js/ckeditor/ckeditor.js"></script>
        <!--script for this page-->
        <script>
                // Replace the <textarea id="editor"> with an CKEditor
                // instance, using default configurations.
                CKEDITOR.replace( 'titulo', {
                        //uiColor: '#010F2C',
                        toolbar: [
                                [ 'Bold', 'Italic', 'Font', 'FontSize', 'TextColor' ]
                        ]
                });
                
                CKEDITOR.replace( 'subtitulo', {
                        //uiColor: '#010F2C',
                        toolbar: [
                                [ 'Bold', 'Italic', 'Font', 'FontSize', 'TextColor' ]
                        ]
                });
                
                $("#select_color_fondo").change(function(){
                    $("#chose_color_fondo").val($("#select_color_fondo").val());
                });
                
                $("#select_color_fuente").change(function(){
                    $("#chose_color_fuente").val($("#select_color_fuente").val());
                });

        </script>
        
    </body>
</html>
