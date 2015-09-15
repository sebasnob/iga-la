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

    <title>Listado de Cursos - IGA</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
	
    <link rel="stylesheet" type="text/css" media="screen" href="styles.php?id_curso=<?=$_GET['id_curso']?>">

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
              <h1 class="text-center">Edicion de Home</h1>
			<form method="POST" action="#" id="form_change" enctype="multipart/form-data">
				<input type="hidden" name="id_curso" id="id_curso" value="<?=$_GET['id_curso']?>" />
				<input type="hidden" name="idioma" id="idioma" value="<?=$idioma?>" />
                                
                                <div class="row">
                                    <div id="selector_color" class="col-md-6 text-left" >
                                            <input type="color" id="select_color" value="<?=$datos_curso['color']?>" />
                                            <input type="text" readonly="" id="chose_color" name="chose_color" value="<?=$datos_curso['color']?>" />
                                            <span id="muestra_color"><b>Color de los titulos</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                    </div>
                                    <div id="selector_color" class="col-md-6 text-right" >
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
				<hr/>
				<div class="row">
                                    <b>Cambiar video</b>
                                    <input id="uploadSlider" type="file" name="imageSlider" class="img" />
                                </div>
				<hr/>
				
				<a id="preview" class="btn btn-default" href="preview.php?id_curso=<?=$_GET['id_curso']?>&idioma=<?=$idioma?>" target="_blank">Vista Previa</a>
				<button id="publicar" class="btn btn-primary">Publicar</button>
			</form>
			
			
		</section><! --/wrapper -->
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
    
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>
  
    <script type="text/javascript">
	$("#select_color").change(function(){
		$("#chose_color").val($("#select_color").val());
		$("h1, h2, h3, h4").css("color", $("#select_color").val());
		$("#muestra_color").css("color", $("#select_color").val());
	});
	
    </script>
  </body>
</html>
