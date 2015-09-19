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
            
            <form name="edicion_home" id="edicion_home" action="#" method="POST">
            <section id="main-content">
                <section class="wrapper">
                    <div class="row">
                        <div class="col-md-6 text-left" >
                            Editar Video
                        </div>
                    </div>
                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="content-panel">
                                <section id="editor_home">
                                    <input type="text" name="texto" id="texto" />
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
                                    <textarea name="texto" id="texto"></textarea>
                                </section>
                            </div><!-- /content-panel -->
                        </div><!-- /col-lg-4 -->			
                    </div><!-- /row -->
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
        
        <!--script for this page-->
        
        
    </body>
</html>
