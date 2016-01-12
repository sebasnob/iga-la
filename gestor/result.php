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

$cod_curso = $_GET['cod_curso'];
if(isset($_GET['id_idioma']) && isset($_GET['id_filial'])){
    $id_idioma = $_GET['id_idioma'];
    $id_filial = $_GET['id_filial'];
    $datos_curso = getDatosCurso($mysqli, $cod_curso, $id_idioma, $id_filial);
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Dashboard">
        
        <title>IGA</title>
        
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
                    <div class="row mt">
                       <div class="col-lg-12">
                         <div class="form-panel">
                            <div class="form-group">
                                <?php
                                if(isset($id_idioma)){
                                ?>
                                    <label>Edicion finalizada</label>
                                    <p>Curso: <?=$datos_curso['nombre']?></p>
                                    <p>Filial: 
                                        <?php
                                        $filial = getFilial($id_filial, $mysqli);
                                        echo $filial['nombre'];
                                        ?></p>

                                    <br/><br/>
                                    <a id="preview" class="btn btn-success" href="../cursos.php?cod_curso=<?=$cod_curso?>&id_filial=<?=$id_filial?>" target="_blank">Ver Cambios</a>
                                    <a id="preview" class="btn btn-primary" href="cursos.php?cod_curso=<?=$cod_curso?>">Volver</a>
                                <?php
                                }else{
                                ?>
                                    <label>Edicion finalizada</label>
                                    <br/><br/>
                                    <a id="preview" class="btn btn-success" href="list_cursos.php">Lista de Cursos</a>
                                    <a id="preview" class="btn btn-primary" href="cursos_grupo.php?cod_curso=<?=$cod_curso?>">Volver al editor</a>   
                                <?php
                                }
                                ?>
                            </div>
                         </div><!-- /form-panel -->
                       </div><!-- /col-lg-12 -->
                    </div><!-- /row -->   
                </section>
            </section><!-- /MAIN CONTENT -->
            <?php include_once 'footer.php'; ?>
        </section>
        
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
        <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        
        <script src="assets/js/common-scripts.js"></script>
        
    </body>
</html>
