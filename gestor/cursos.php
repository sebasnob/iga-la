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
	$idioma = '1';
}

if(isset($_GET['pais'])){
    $pais = $_GET['pais'];
}else{
    $pais = '1';
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
        
        <link rel="stylesheet" type="text/css" media="screen" href="styles.php?id_curso=<?=$_GET['cod_curso']?>">
        
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <style>
            #datos_curso{
                display: none;
            }
            
            #error_datos_curso{
                display: none;
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
                <section class="wrapper site-min-height">
                    <h3><i class="fa fa-angle-right"></i>Edicion del curso </h3>
                    <p>Formulario para la edicion del curso. Las modifiaciones solo afectaran al curso, en la filial e idioma seleccionados.</p>
                    <br/>
                    <form method="POST" action="upload.php" id="form_change" enctype="multipart/form-data">
                        <input type="hidden" name="id_curso" id="id_curso" value="<?=$_GET['cod_curso']?>" />
                        <input type="hidden" name="idioma" id="idioma" value="<?=$idioma?>" />
                        <input type="hidden" name="edicion_curso" id="edicion_curso" value="true" />

                        <div>
                            <label>Seleccione un Pais</label>
                            <select name="paises_curso" id="paises_curso">
                                <option value="0">- Seleccione -</option>
                                <?php
                                    $paises_curso = getCursoPais($mysqli, $_GET['cod_curso']);
                                    foreach($paises_curso as $i=>$d){
                                ?>
                                <option value="<?=$d['id']?>"><?=$d['pais']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                            &nbsp;
                            <label>Provincia</label>
                            <select name="provincias_curso" id="provincias_curso">
                                <option value="0">- Seleccione -</option>
                            </select>
                            &nbsp;
                            <label>Filial</label>
                            <select name="filiales_curso" id="filiales_curso">
                                <option value="0">- Seleccione -</option>
                            </select>
                            &nbsp;
                            <label>Idioma</label>
                            <select name="idioma_curso" id="idioma_curso">
                                <option value="0">- Seleccione -</option>
                                <?php
                                    $idiomas = getIdiomas($mysqli);
                                    foreach($idiomas as $i=>$d){
                                ?>
                                <option value="<?=$d['id']?>"><?=$d['idioma']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                        <br/>
                        <div id="error_datos_curso"></div>
                        <div id="datos_curso">
                            <!--<div class="row">
                                <div id="selector_color" class="col-md-6 text-left" >
                                    <input type="color" id="select_color" value="<? //$curso['color']?>" />
                                    <input type="text" readonly="" id="chose_color" name="chose_color" value="<? //$curso['color']?>" />
                                    <span id="muestra_color"><b>Color de los titulos</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                                <div id="selector_color" class="col-md-6 text-right" > </div>
                            </div>-->
                            <hr/>
                            <div>
                                <div id="sliderPreview">
                                    <img class="img-responsive animated fadeInLeftBig" id="imagePreview" src="" alt="">
                                </div>
                            </div>
                            <input id="uploadSlider" type="file" name="imageSlider" class="img" />
                            <hr/>
                            <div>
                                <div>
                                    <h3>Duracion</h3>
                                    <input type="text" id="titulo" name="titulo" style="width:350px" />
                                </div>
                                <hr/>
                                <div>
                                    <h3>Descripcion</h3>
                                    <textarea name="descripcion" id="descripcion" cols="100" rows="10"></textarea>
                                </div>
                                <hr/>
                                <div>
                                    <h3>Plan de Estudio</h3>
                                    <textarea name="plan_estudio" id="plan_estudio" cols="100" rows="10"></textarea>
                                </div>
                                <hr/>
                                <div id="materialesPreview">
                                    <h3>Materiales</h3>
                                    <img class="avatar img-thumbnail" src="<?=$datos_curso['img_materiales']?>" alt="" />
                                </div>
                                <textarea name="materiales_txt" id="materiales_txt" cols="100" rows="10"></textarea>
                                <input id="uploadMateriales" type="file" name="imageMateriales" class="img" />
                                <hr/>

                                <div id="uniformesPreview">
                                    <h3>Uniforme</h3>
                                    <img class="avatar img-thumbnail" src="<?=$datos_curso['img_uniforme']?>" alt="">
                                </div>
                                <textarea name="uniformes_txt" id="uniformes_txt" cols="100" rows="10"></textarea>
                                <input id="uploadUniformes" type="file" name="imageUniformes" class="img" />
                            </div>    
                            <hr/>
                            <button id="confirm" class="btn btn-success">Cambiar</button>
                            <a id="preview" class="btn btn-default" href="preview.php?id_curso=<?=$_GET['id_curso']?>&idioma=<?=$idioma?>" target="_blank">Vista Previa</a>
                            <button id="publicar" class="btn btn-primary">Publicar</button>
                        </div>
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
        
        <script type="text/javascript">
            /*$(function(){
                $('select.styled').customSelect();
            });*/
            
            function changeSelectOptions(select_id, array_index, texto, value){
                var options, index, select, option;

                // Get the raw DOM object for the select box
                select = document.getElementById(select_id);

                // Clear the old options
                select.options.length = 0;

                // Load the new options
                options = array_index; // Or whatever source information you're working with
                select.options.add(new Option('- Seleccione -', '0'));
                for (index = 0; index < options.length; ++index) {
                    option = options[index];
                    select.options.add(new Option(option[texto], option[value]));
                }
            }
            
            /*$("#select_color").change(function(){
                $("#chose_color").val($("#select_color").val());
                $("h1, h2, h3, h4").css("color", $("#select_color").val());
                $("#muestra_color").css("color", $("#select_color").val());
            });*/
	
            $("#confirm").click(function(){
                //$(".overlay").show();
                $("#form_change").submit();
            });
	
            //Cambiar la imagen previa de la cabecera
            $("#uploadSlider").on("change", function(){
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
                if (/^image/.test( files[0].type)){ // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file
                    reader.onloadend = function(){ // set image data as background of div
                        //$("#imagePreview").css("background-image", "url("+this.result+")");
                        $("#sliderPreview").html("<img class='img-responsive animated fadeInLeftBig' src='"+this.result+"' alt=''>");
                    }
                }
            });
            
            //Cambiar la imagen previa de los materiales
            $("#uploadMateriales").on("change", function(){
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
                if (/^image/.test( files[0].type)){ // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file
                    reader.onloadend = function(){ // set image data as background of div
                        //$("#imagePreview").css("background-image", "url("+this.result+")");
                        $("#materialesPreview").html("<img class='img-responsive animated fadeInLeftBig' src='"+this.result+"' alt=''>");
                    }
                }
            });
	
            //Cambiar la imagen previa de los uniformes
            $("#uploadUniformes").on("change", function(){
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
                if (/^image/.test( files[0].type)){ // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file
                    reader.onloadend = function(){ // set image data as background of div
                        //$("#imagePreview").css("background-image", "url("+this.result+")");
                        $("#uniformesPreview").html("<img class='img-responsive animated fadeInLeftBig' src='"+this.result+"' alt=''>");
                    }
                }
            });
            
            $("#paises_curso").change(function(){
                //Reincio el select de provincias
                $('#provincias_curso').html("<option value='0'>- Seleccione -</option>");
                //Reincio el select de filiales
                $('#filiales_curso').html("<option value='0'>- Seleccione -</option>");
                //Oculto los datos del curso y de los errores
                $('#error_datos_curso').hide();
                $('#datos_curso').hide();
                
                //Cargo el select de provincias
                $.ajax({
        	    url: "controller_ajax.php",
        	    method: "POST",
        	    data: { option : 'select_provincias', id_pais : $(this).val()  },
                    dataType: "json",
        	    success: function(data){
                        changeSelectOptions("provincias_curso", data.options, 'provincia', 'id');
        	    }
        	});
            });
            
            $("#provincias_curso").change(function(){
                $('#filiales_curso').html("<option value='0'>- Seleccione -</option>");
                //Oculto los datos del curso y de los errores
                $('#error_datos_curso').hide();
                $('#datos_curso').hide();
                
                $.ajax({
        	    url: "controller_ajax.php",
        	    method: "POST",
        	    data: { 
                        option : 'select_filiales', 
                        cod_curso : <?=$_GET['cod_curso']?>, 
                        id_pais : $("#paises_curso").val(),
                        id_provincia : $(this).val()
                    },
                    dataType: "json",
        	    success: function(data){
                        changeSelectOptions("filiales_curso", data.options, 'nombre', 'id');
        	    }
        	});
            });
            
            $('#filiales_curso').change(function(){
                //Oculto los datos del curso y de los errores
                $('#error_datos_curso').hide();
                $('#datos_curso').hide();
                
                //Reincio el select de idiomas
                $("#idioma_curso").find('option:selected').removeAttr("selected");
                $('#idioma_curso option:nth-child(0)').attr('selected','selected');
            });
            
            $("#idioma_curso").change(function(){
                $.ajax({
        	    url: "controller_ajax.php",
        	    method: "POST",
        	    data: {
                        option : 'get_datos_curso',
                        cod_curso : <?=$_GET['cod_curso']?>,
                        id_pais : $("#paises_curso").val(),
                        id_idioma : $(this).val(),
                        id_filial : $('#filiales_curso').val()
                    },
                    dataType: "json",
        	    success: function(data){
                        if(data.id){
                            $('#error_datos_curso').hide();
                            $('#imagePreview').attr("src", data.url_cabecera);
                            $('#datos_curso').show();
                        }else{
                            $('#datos_curso').hide();
                            $('#error_datos_curso').html(data);
                            $('#error_datos_curso').show();
                        }
        	    }
        	});
            });
            
        </script>
        
    </body>
</html>
