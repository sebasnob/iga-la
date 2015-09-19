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
            <h3><i class="fa fa-angle-right"></i> Listado de Cursos</h3>
            <div class="row mt">
                <div class="col-lg-12">
                    <div class="content-panel">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Titulo</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $cursos = getCursos($mysqli);
                                foreach($cursos as $i=>$j){
                            ?>
                                <tr>
                                    <td data-title="ID"><a href="cursos.php?id_curso=<?=$j['id']?>"><?=$j['id']?></a></td>
                                    <td data-title="Titulo"><a href="cursos.php?id_curso=<?=$j['id']?>"><?=$j['titulo']?></a></td>
                                </tr>
                            <?php
                                }
                            ?>
                                
                            </tbody>
                        </table>
                    </div><!-- /content-panel -->
               </div><!-- /col-lg-4 -->			
            </div><!-- /row -->
        </section><! --/wrapper -->
    </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <?php include_once './footer.php';?>
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="assets/js/common-scripts.js"></script>

    <!--script for this page-->
    

  </body>
</html>
