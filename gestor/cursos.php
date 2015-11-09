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

if(isset($_GET['cod_curso']) && $_GET['cod_curso'] != ''){
    $datos_curso = getCursos($mysqli, $_GET['cod_curso']);
}else{
    header("Location: list_cursos.php");
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
        <link href="assets/css/table-responsive.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css"> 
        
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
                    <h3><i class="fa fa-angle-right"></i>Edición del curso <b><?=$datos_curso[0]['nombre_es']?></b></h3>
                     <p>Formulario para la edicion del curso. Las modifiaciones solo afectaran al curso, en la filial e idioma seleccionados.</p>
                    <br/>
                    <form method="POST" action="upload.php" id="form_change" enctype="multipart/form-data">
                        <input type="hidden" name="cod_curso" id="cod_curso" value="<?=$_GET['cod_curso']?>" />
                        <input type="hidden" name="edicion_curso" id="edicion_curso" value="true" />

                        <div class="row mt">
                           <div class="col-lg-12">
                             <div class="form-panel">
                                <div class="form-group">
                                    <label>Seleccione un Pais</label>
                                    <select name="paises_curso" id="paises_curso" class="form-control">
                                        <option value="0">- Seleccione -</option>
                                        <?php
                                            $paises_curso = getPaises($mysqli);
                                            foreach($paises_curso as $i=>$d){
                                        ?>
                                        <option value="<?=$d['id']?>"><?=$d['pais']?></option>
                                        <?php
                                            }
                                        ?>
                                    </select>
                                    &nbsp;
                                    <label>Provincia</label>
                                    <select name="provincias_curso" id="provincias_curso" class="form-control">
                                        <option value="0">- Seleccione -</option>
                                    </select>
                                    &nbsp;
                                    <label>Filial</label>
                                    <select name="filiales_curso" id="filiales_curso" class="form-control">
                                        <option value="0">- Seleccione -</option>
                                    </select>
                                    &nbsp;
                                    <label>Idioma</label>
                                    <select name="idioma_curso" id="idioma_curso" class="form-control">
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
                             </div><!-- /form-panel -->
                           </div><!-- /col-lg-12 -->
                        </div><!-- /row -->   

                        <p id="error_datos_curso" class="bg-danger"></p>
                        <div class="datos_curso">
                          <div class="row mt">
                             <div class="col-lg-12">
                               <div class="form-panel">
                                    <div id="datos_curso">
                                        <input type="hidden" id="id_cfi">
                                      <!--<div class="row">
                                          <div id="selector_color" class="col-md-6 text-left" >
                                              <input type="color" id="select_color" value="<? //$curso['color']?>" />
                                              <input type="text" readonly="" id="chose_color" name="chose_color" value="<? //$curso['color']?>" />
                                              <span id="muestra_color"><b>Color de los titulos</b></span>&nbsp;&nbsp;&nbsp;&nbsp;
                                          </div>
                                          <div id="selector_color" class="col-md-6 text-right" > </div>
                                      </div>-->
                                      <div class="form-group">
                                          <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Estado:</b></h4>
                                          <select name="estado_curso" id="estado_curso">
                                              <option value="0">Deshabilitado</option>
                                              <option value="1">Habilitado</option>
                                          </select>
                                          <button type="button" id="cambiar_estado" class="btn btn-success btn-sm" data-loading-text="Cambiando...">Cambiar</button>
                                      </div>
                                      <div class="form-group">
                                          <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Nombre del Curso:</b></h4>
                                          <input type="text" id="nombre_curso" name="nombre_curso" class="form-control"/>
                                      </div>
                                      <div class="form-group">
                                          <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Seleccione la nueva imagen de cabecera:</b></h4>
                                          <div id="sliderPreview">
                                              <img class="img-responsive animated fadeInLeftBig" id="imagePreview" src="" alt="">
                                          </div>
                                      </div>
                                      <input id="uploadSlider" type="file" name="imageSlider" class="img" />
                                          <div class="form-group">
                                             <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Duración:</b></h4>
                                             <p>(Asignar 0 en caso de no querer mostrar el valor)</p>
                                             Horas: <input type="text" id="horas" name="horas" style="width:250px" /><br/>
                                             Meses: <input type="text" id="meses" name="meses" style="width:250px" /><br/>
                                             Años: <input type="text" id="anios" name="anios" style="width:250px" /><br/>
                                          </div>

                                          <div class="form-group">
                                              <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Descripción:</b></h4>
                                             <textarea name="descripcion" id="descripcion" class="form-control" rows="5"></textarea>
                                          </div>

                                         <div class="form-group">
                                             <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Plan de Estudio:</b></h4>
                                              <textarea name="plan_estudio" id="plan_estudio" class="form-control" rows="5"></textarea>
                                          </div>

                                          <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Materiales:</b></h4>
                                          <div id="materialesPreview" class="form-group">
                                              <img class="avatar img-thumbnail" id="imgMaterialesPreview" src="" alt="" />
                                          </div>
                                          <textarea name="materiales_txt" id="materiales_txt" class="form-control" rows="5"></textarea>
                                          <input id="uploadMateriales" type="file" name="imageMateriales" class="img" />

                                          <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Uniforme:</b></h4>
                                          <div id="uniformesPreview" class="form-group">
                                               <img class="avatar img-thumbnail" id="imgUniformesPreview" src="" alt="">
                                          </div>
                                          <textarea name="uniformes_txt" id="uniformes_txt" class="form-control" rows="5"></textarea>
                                          <input id="uploadUniformes" type="file" name="imageUniformes" class="img" />
                                          
                                          <h4 class="mb">
                                              <i class="fa fa-angle-right"></i> 
                                              <b>Malla Curricular:</b>
                                          </h4>
                                          <div class="form-group">
                                              <div id="malla">
                                                  <div>
                                                    <label>Cuatrimestre:</label><input id="cuatrimestre" type="number">
                                                    <label>Materia:</label><input id="materia" type="text">
                                                    <input type="button" value="+" onclick="agregarAMalla()">
                                                  </div>
                                              </div>
                                          </div>
                                          
                                          <div class="form-group">
                                             <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Objetivos:</b></h4>
                                              <textarea name="objetivos" id="objetivos" class="form-control" rows="5"></textarea>
                                          </div>
                                   </div>

                                </div><!-- /form-panel -->
                             </div><!-- /col-lg-12 -->
                            </div><!-- /row -->  
                        </div>
                        <div class="acciones">   
                            <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Que desea realizar?</b></h4>
                            <div class="row mt">
                                <div class="col-lg-12">  
                                    <button id="confirm" class="btn btn-success">Guardar cambios</button>
                                    <a id="preview" class="btn btn-default" href="preview.php?cod_curso=<?=$_GET['cod_curso']?>&idioma=<?=$idioma?>" target="_blank">Vista Previa</a>
                                    <a href="list_cursos.php" type="button" class="btn btn-info">Volver</a>
                                </div><!-- /form-panel -->
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
        <script src="assets/js/jquery-ui-1.9.2.custom.min.js"></script>
        <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
        
        
        <!--common script for all pages-->
        <script src="assets/js/common-scripts.js"></script>
        
        <script type="text/javascript" src="assets/js/ckeditor/ckeditor.js"></script>
        
        <script type="text/javascript">
            
            function getProvincias(id_pais){
                var id_pais = id_pais;
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
        	    data: { option : 'select_provincias', id_pais : id_pais  },
                    dataType: "json",
        	    success: function(data){
                        changeSelectOptions("provincias_curso", data.options, 'nombre', 'id');
                        $("select#provincias_curso option[value='"+localStorage.getItem("provincia")+"']").attr("selected", "selected");
        	    }
        	});
            }
            
            function getFiliales(cod_curso, id_pais, id_provincia){
                var cod_curso = cod_curso;
                var id_pais = id_pais;
                var id_provincia = id_provincia;
                $('#filiales_curso').html("<option value='0'>- Seleccione -</option>");
                //Oculto los datos del curso y de los errores
                $('#error_datos_curso').hide();
                $('#datos_curso').hide();
                
                $.ajax({
        	    url: "controller_ajax.php",
        	    method: "POST",
        	    data: { 
                        option : 'select_filiales', 
                        cod_curso : cod_curso, 
                        id_pais : id_pais,
                        id_provincia : id_provincia
                    },
                    dataType: "json",
        	    success: function(data){
                        changeSelectOptions("filiales_curso", data.options, 'nombre', 'id');
                        $("select#filiales_curso option[value='"+localStorage.getItem("filial")+"']").attr("selected", "selected");
        	    }
        	});
            }
            
            function getDatosCurso(cod_curso, id_pais, id_idioma, id_filial){
                $.ajax({
        	    url: "controller_ajax.php",
        	    method: "POST",
        	    data: {
                        option : 'get_datos_curso',
                        cod_curso : cod_curso,
                        id_pais : id_pais,
                        id_idioma : id_idioma,
                        id_filial : id_filial
                    },
                    dataType: "json",
        	    success: function(data){
                        if(data.id){
                            $('#error_datos_curso').hide();
                            $('#imagePreview').attr("src", "../"+data.url_cabecera);
                            $('#materialesPreview img').attr("src", "../"+data.url_material);
                            $('#uniformesPreview img').attr("src", "../"+data.url_uniforme);
                            $('#id_cfi').val(data.id_cfi);
                            /*$.each(data.malla_curricular, function(index, value)
                            {
                                $('#malla').prepend("<div id="+value.id+"><label>Cuatrimestre:</label><input readonly type='number' value = " + value.cuatrimestre + "><label>Materia:</label><input readonly type = 'text' value =  "+ value.materia +"><input type = 'button' onclick='eliminarDeMalla("+ value.id +")' value='-'></div>");
                            });*/
                            
                            $('#horas').val(data.horas);
                            $('#meses').val(data.meses);
                            $('#anios').val(data.anios);
                            $('#nombre_curso').val(data.nombre);
                            
                            $("#estado_curso").find('option:selected').removeAttr("selected");
                            $("select#estado_curso option[value='"+data.estado+"']").attr("selected", "selected");
                            
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
                            
                            if(!CKEDITOR.instances['objetivos']){
                                $('#objetivos').val(data.objetivos);
                                CKEDITOR.replace( 'objetivos', {
                                    //uiColor: '#010F2C',
                                    customConfig: 'config.js',
                                    toolbar: [
                                            [ 'Bold', 'Italic', 'FontSize']
                                    ]
                                });
                            }else{
                                CKEDITOR.instances['objetivos'].setData(data.objetivos);
                            }
                        }else{
                            $('#datos_curso').hide();
                            $('#error_datos_curso').html(data);
                            $('#error_datos_curso').show();
                        }
        	    }
        	  });
            }
    
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
                localStorage.setItem('pais', $(this).val());
                getProvincias($(this).val());
            });
            
            $("#provincias_curso").change(function(){
                localStorage.setItem('provincia', $(this).val());
                getFiliales(<?=$_GET['cod_curso']?>, $("#paises_curso").val(), $(this).val());
            });
            
            $('#filiales_curso').change(function(){
                localStorage.setItem('filial', $(this).val());
                //Oculto los datos del curso y de los errores
                $('#error_datos_curso').hide();
                $('#datos_curso').hide();
                
                //Reincio el select de idiomas
                $("#idioma_curso").find('option:selected').removeAttr("selected");
                $('#idioma_curso option:nth-child(0)').attr('selected','selected');
            });
            
            $("#idioma_curso").change(function(){
                localStorage.setItem('idioma', $(this).val());
                getDatosCurso(<?=$_GET['cod_curso']?>, $("#paises_curso").val(), $(this).val(), $('#filiales_curso').val());
            });
            
            $("#preview").click(function(){
                localStorage.setItem('nombre_curso', $("#nombre_curso").val());
                localStorage.setItem('imagePreview', $("#sliderPreview img").attr('src'));
                localStorage.setItem('horas', $("#horas").val());
                localStorage.setItem('meses', $("#meses").val());
                localStorage.setItem('anios', $("#anios").val());
                localStorage.setItem('descripcion', CKEDITOR.instances['descripcion'].getData());
                localStorage.setItem('imageMat', $("#materialesPreview img").attr('src'));
                localStorage.setItem('descMat', CKEDITOR.instances['materiales_txt'].getData());
                localStorage.setItem('imageUnif', $("#uniformesPreview img").attr('src'));
                localStorage.setItem('descUnif', CKEDITOR.instances['uniformes_txt'].getData());
                localStorage.setItem('objetivos', CKEDITOR.instances['objetivos'].getData());
            });
            
            $('#cambiar_estado').on('click', function(){
                var $btn = $(this).button('loading');
                $.ajax({
        	    url: "controller_ajax.php",
        	    method: "POST",
        	    data: {
                        option : 'cambiar_estado_curso',
                        cod_curso : $('#cod_curso').val(),
                        id_idioma : $('#idioma_curso').val(),
                        id_filial : $('#filiales_curso').val(),
                        estado: $('#estado_curso').val()
                    },
                    dataType: "json",
        	    success: function(data){
                        $btn.button('reset');
                    }
                });
            });
            
            function eliminarDeMalla(id)
            {
                 $.ajax({
        	    url: "controller_ajax.php",
        	    method: "POST",
        	    data: {
                        option : 'eliminar_de_malla',
                        id : id
                    },
                    dataType: "json",
        	    success: function()
                    {
                        $('#'+id).remove();
                    }
                });
            }
            
            function agregarAMalla()
            {
                 $.ajax({
        	    url: "controller_ajax.php",
        	    method: "POST",
        	    data: {
                        option : 'agregar_a_malla',
                        cuatrimestre: $('#cuatrimestre').val(),
                        materia: $('#materia').val(),
                        id_cfi: $('#id_cfi').val()
                    },
                    dataType: "json",
        	    success: function(data)
                    {
                        location.reload();
                    }
                });
            }
            
            $(document).ready(function(){
                if(localStorage.getItem("pais")){
                   $("select#paises_curso option[value='"+localStorage.getItem("pais")+"']").attr("selected", "selected");
                   getProvincias($("#paises_curso").val());
                }
                
                if(localStorage.getItem("provincia")){
                    console.log("Prov: "+localStorage.getItem("provincia"));
                    getFiliales(<?=$_GET['cod_curso']?>, $("#paises_curso").val(), localStorage.getItem("provincia"));
                }
                
                if(localStorage.getItem("idioma")){
                    console.log("Filial: "+localStorage.getItem("filial"));
                    $("select#idioma_curso option[value='"+localStorage.getItem("idioma")+"']").attr("selected", "selected");
                    getDatosCurso(<?=$_GET['cod_curso']?>, localStorage.getItem("pais"), localStorage.getItem('idioma'), localStorage.getItem("filial"));
                }
            });
            
        </script>
        
    </body>
</html>
