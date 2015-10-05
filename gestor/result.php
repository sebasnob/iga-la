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
        <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        
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

        <link rel="stylesheet" type="text/css" media="screen" href="styles.php?id_curso=<?=$_GET['cod_curso']?>">

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
                                    <a id="preview" class="btn btn-success" href="preview.php?cod_curso=<?=$cod_curso?>&id_idioma=<?=$id_idioma?>&id_filial=<?=$id_filial?>" target="_blank">Vista Previa</a>
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
        <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
        
        
        <!--common script for all pages-->
        <script src="assets/js/common-scripts.js"></script>
        
        <script type="text/javascript" src="assets/js/ckeditor/ckeditor.js"></script>
        
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
                        changeSelectOptions("provincias_curso", data.options, 'nombre', 'id');
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
                            $('#imgMaterialesPreview').attr("src", data.url_material);
                            $('#imgUniformesPreview').attr("src", data.url_uniforme);
                            
                            $('#horas').val(data.horas);
                            $('#meses').val(data.meses);
                            $('#anios').val(data.anios);
                            
                            $('#datos_curso').show();
                            $('.datos_curso').css('display','block');
                            $('.acciones').css('display','block');
                            
                            if(!CKEDITOR.instances['uniformes_txt']){
                                $('#uniformes_txt').val(data.desc_uniforme);
                                CKEDITOR.replace( 'uniformes_txt', {
                                    //uiColor: '#010F2C',
                                    customConfig: 'config.js',
                                    toolbar: [
                                            [ 'Bold', 'Italic', 'FontSize']
                                    ]
                                });
                            }else{
                                CKEDITOR.instances['uniformes_txt'].setData(data.desc_uniforme);
                            }
                            
                            if(!CKEDITOR.instances['materiales_txt']){
                                $('#materiales_txt').val(data.desc_material);
                                CKEDITOR.replace( 'materiales_txt', {
                                    //uiColor: '#010F2C',
                                    customConfig: 'config.js',
                                    toolbar: [
                                            [ 'Bold', 'Italic', 'FontSize']
                                    ]
                                });
                            }else{
                                CKEDITOR.instances['materiales_txt'].setData(data.desc_material);
                            }
                            
                            if(!CKEDITOR.instances['descripcion']){
                                $('#descripcion').val(data.descripcion);
                                CKEDITOR.replace( 'descripcion', {
                                    //uiColor: '#010F2C',
                                    customConfig: 'config.js',
                                    toolbar: [
                                            [ 'Bold', 'Italic', 'FontSize']
                                    ]
                                });
                            }else{
                                CKEDITOR.instances['descripcion'].setData(data.descripcion);
                            }
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
