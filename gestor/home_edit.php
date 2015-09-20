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
        <meta name="author" content="Dashboard">
        <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        
        <title>Home - IGA</title>
        
        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
        <!-- Custom styles for this template -->
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/style-responsive.css" rel="stylesheet">
        
        <link href="assets/css/table-responsive.css" rel="stylesheet">
        
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
            
            <form name="formEditHome" id="formEditHome" action="upload.php" method="POST">
                <input type="hidden" name="edicion_home" id="edicion_home" value="true" />
                <input type="hidden" name="idioma" id="idioma" value="<?=$idioma?>" />
                <section id="main-content">
                    <section class="wrapper">
                        <div class="text-center" >
                            <h2>Edicion de Home</h2>
                        </div>
                        <div class="row">
                            <div id="videoPreview" class="text-center">
                                <!-- <iframe width="854" height="480" src="https://www.youtube.com/embed/JApGTCxZztg?rel=0&controls=0&showinfo=0&autoplay=1&autoplay=1&loop=0&playlist=Rk6_hdRtJOE&enablejsapi=1&version=3" frameborder="0"></iframe>-->
                                <p><b>URL Actual:</b>&nbsp;&nbsp; <?=$datos_home['url_video']?></p>
                            </div>
                        </div>
                        <div class="row mt">
                            <div class="col-lg-12">
                                <div class="content-panel">
                                    <section id="editor_home">
                                        <p>Cambiar video</p>
                                        <span>URL</span>
                                        <input type="text" name="url_video" id="url_video" style="width:350px" />
                                    </section>
                                </div><!-- /content-panel -->
                            </div><!-- /col-lg-4 -->			
                        </div><!-- /row -->
                        <hr/>
                        <div class="row">
                            <div class="col-md-6 text-left" >
                                Editar Texto
                            </div>
                            <div class="col-md-6 text-right" >
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

                        <div class="row mt">
                            <div class="col-lg-12">
                                <div class="content-panel">
                                    <section id="editor_home">
                                        <label>Titulo</label>
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
                                        <label>Sub-Titulo</label>
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
                                </div><!-- /content-panel -->
                            </div><!-- /col-lg-4 -->			
                        </div><!-- /row -->
                        <br/>
                        <div class="row">
                            <div class="col-lg-12">
                                <button id="confirm" class="btn btn-success">Aceptar</button>
                                <a id="preview" class="btn btn-default" href="preview_home.php" target="_blank">Vista Previa</a>
                                <button id="publicar" class="btn btn-primary">Publicar</button>
                            </div>
                        </div>
                    </section><! --/wrapper -->
                </section><!-- /MAIN CONTENT -->
            </form>
            
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
                                [ 'Bold', 'Italic', '-' ],
                                [ 'TextColor']
                        ]
                });
                
                CKEDITOR.replace( 'subtitulo', {
                        //uiColor: '#010F2C',
                        toolbar: [
                                [ 'Bold', 'Italic', '-' ],
                                [ 'TextColor']
                        ]
                });

        </script>
        
    </body>
</html>
