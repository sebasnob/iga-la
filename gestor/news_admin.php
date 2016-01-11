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

$paises = getPaises($mysqli);
$categoriasNovedades = getCategoriasNovedades($mysqli);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="Dashboard">
        <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
        
        <title>Administracion de Novedades - IGA</title>
        
        <!-- Bootstrap core CSS -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <!--external css-->
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
        <!-- Custom styles for this template -->
        <link href="assets/css/style.css" rel="stylesheet">
        <link href="assets/css/style-responsive.css" rel="stylesheet" />
        <link href="assets/css/table-responsive.css" rel="stylesheet" />
        <link href="../css/jquery.filthypillow.css" rel="stylesheet" />
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
                    <?php
                    if(isset($_GET['result'])){
                    ?>
                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="form-panel">
                                <div class="form-group">
                                 <?php
                                 if(isset($_GET['id'])){
                                 ?>
                                    <label>Edicion de Noticia finalizada</label>
                                    <br/><br/>
                                    <a id="preview" class="btn btn-success" href="news.php">Lista de Noticias</a>
                                    <a id="preview" class="btn btn-primary" href="news_admin.php?id=<?=$_GET['id']?>">Volver al editor</a>   
                                 <?php
                                 }else{
                                 ?>
                                    <label>Noticia Agregada correctamente</label>
                                    <br/><br/>
                                    <a id="preview" class="btn btn-success" href="news.php">Lista de Noticias</a>
                                    <a id="preview" class="btn btn-primary" href="news_admin.php">Volver al editor</a>
                                 <?php
                                 }
                                 ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }else{
                        if(isset($_GET['id'])){
                            $accion = 'editar';
                            $id_novedad = $_GET['id'];
                            $novedad = getNovedad($mysqli, $_GET['id']);
                        }else{
                            $id_novedad = '';
                            $accion = 'agregar';
                        }
                    ?>
                    <h3><i class="fa fa-angle-right"></i><?php echo ($accion == 'agregar')?"Nueva noticia":"Edicion de noticia"?></h3>
                    <form method="POST" action="upload.php" id="form_change" enctype="multipart/form-data">
                        <input type="hidden" name="id_novedad" id="id_novedad" value="<?=$id_novedad?>" />
                        <input type="hidden" name="accion" id="accion" value="<?=$accion?>" />
                        <input type="hidden" name="edicion_noticia" id="edicion_noticia" value="true" />
                        <?php
                            if($accion == 'editar'){
                        ?>
                                <input type='hidden' name='imagenBorrar2' id='imagenBorrar2' value='' />
                                <input type='hidden' name='imagenBorrar3' id='imagenBorrar3' value='' />
                        <?php
                            }
                        ?>
                        <div class="row mt">
                            <div class="col-lg-12">
                                <div class="form-panel">
                                    <div id="datos_curso">
                                        <div class="form-group">
                                            <label>Pais </label><br>
                                            <select name="pais[]" multiple="true" required>
                                                <?php foreach ($paises as $pais){?>
                                                <option value="<?= $pais['id'] ?>"
                                                    <?php 
                                                    if(isset($novedad)){
                                                        if(in_array($pais['id'], $novedad['id_pais']))
                                                        {
                                                            echo 'selected';
                                                        }
                                                    }
                                                    ?>
                                                >
                                                <?= $pais['pais'] ?>
                                                </option>
                                                <?php } ?>
                                            </select>
                                            <br><br>
                                            <label>Fecha</label>
                                            <input type="text" name="fecha" id="fecha" class="form-control filthypillow-1" value="<?=date("d-m-Y", strtotime($novedad['fecha']))?>" />
                                            <br><br>
                                            <label>Categoria</label>
                                            <select name="categoria" id="categoria" class="form-control">
                                                <option value="0">- Seleccione -</option>
                                                <?php 
                                                    foreach ($categoriasNovedades as $categoriaNovedad)
                                                    {
                                                        $selected = '';
                                                        if(isset($novedad['categoria']) && $novedad['categoria'] == $categoriaNovedad['id'])
                                                        {
                                                            $selected = "selected = 'selected'";
                                                        }
                                                ?>
                                                <option value="<?=$categoriaNovedad['id']?>" <?=$selected?> ><?=$categoriaNovedad['nombre_ES']?></option>
                                              <?php } ?>
                                            </select>
                                            <br><br>
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
                                            <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Imagen 1:</b></h4>
                                            <div id="imagenPreview1">
                                              <?php
                                                if($accion == 'editar'){
                                              ?>
                                                <img class="img-responsive animated fadeInLeftBig" id="imagePreview" src="../images/novedades/<?=$novedad['imagen']?>" alt="" width="250px" />
                                              <?php
                                                }
                                              ?>
                                            </div>
                                            <input id="imagen" type="file" name="imagen[]" class="img" />
                                        </div>
                                        
                                        <div class="form-group">
                                            <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Imagen 2:</b></h4>
                                            <div id='agregarImg2' style="<?php echo (isset($novedad['imagen2']) && $novedad['imagen2'] != '')?"display: none":""?>">
                                                <button type="button" class="btn btn-primary" onclick="javascript:abrirDiv('2')">Agregar Imagen</button>
                                            </div>
                                            <div id='divImg2' style="<?php echo (isset($novedad['imagen2']) && $novedad['imagen2'] != '')?"":"display:none"?>">
                                                <div id='imagenPreview2'>
                                                  <?php
                                                    if($accion == 'editar'){
                                                  ?>
                                                    <div id='eliminarFoto2' style='width:250px;text-align:right;<?php echo (isset($novedad['imagen2']) && $novedad['imagen2'] != '')?"":"display:none"?>'><button class='btn btn-danger' onclick="javascript:eliminarFoto('2')"><i class='fa fa-trash-o'></i></button></div>
                                                    <img class="img-responsive animated fadeInLeftBig" id="imagePreview2" src="../images/novedades/<?=$novedad['imagen2']?>" alt="" width="250px" />
                                                  <?php
                                                    }
                                                  ?>
                                                </div>
                                                <input id="imagen2" type="file" name="imagen[]" class="img" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Imagen 3:</b></h4>
                                            <div id='agregarImg3' style="<?php echo (isset($novedad['imagen3']) && $novedad['imagen3'] != '')?"display: none":""?>">
                                                <button type="button" class="btn btn-primary" onclick="javascript:abrirDiv('3')">Agregar Imagen</button>
                                            </div>
                                            <div id='divImg3' style="<?php echo (isset($novedad['imagen3']) && $novedad['imagen3'] != '')?"":"display:none"?>">
                                                <div id="imagenPreview3">
                                                  <?php
                                                    if($accion == 'editar'){
                                                  ?>
                                                    <div id='eliminarFoto3' style='width:250px;text-align:right;<?php echo (isset($novedad['imagen3']) && $novedad['imagen3'] != '')?"":"display:none"?>'><button class='btn btn-danger' onclick="javascript:eliminarFoto('3')"><i class='fa fa-trash-o'></i></button></div>
                                                    <img class="img-responsive animated fadeInLeftBig" id="imagePreview3" src="../images/novedades/<?=$novedad['imagen3']?>" alt="" width="250px" />
                                                  <?php
                                                    }
                                                  ?>
                                                </div>
                                                <input id="imagen3" type="file" name="imagen[]" class="img" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <h4 class="mb"><i class="fa fa-angle-right"></i> <b>Descripción:</b></h4> 
                                            <textarea name="descripcion" id="descripcion" class="form-control" rows="5"><?php echo (isset($novedad['descripcion']))?$novedad['descripcion']:''; ?></textarea>
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
                                <button id="confirm" class="btn btn-success">Guardar</button>
                                <img src="../images/preloader.gif" style="height: 30px; margin-left: 10px; display: none">
                            </div><!-- /col-lg-12 -->
                        </div><!-- /row --> 
                    </form>
                    <?php
                    }
                    ?>
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
        <script type="text/javascript" src="../js/moment.js"></script>
        <script type="text/javascript" src="../js/jquery.filthypillow.min.js"></script>
        
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
            
            CKEDITOR.instances['descripcion'].setData(<?php echo (isset($novedad['descripcion']))?json_encode($novedad['descripcion']):''; ?>);
            
            $('#confirm').click(function()
            {
                $('#cargando').show('slow');
                $('#form_change').submit();
            });
            
            //Cambiar la imagen previa
            $("#imagen").on("change", function(){
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
                if (/^image/.test( files[0].type)){ // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file
                    reader.onloadend = function(){ // set image data as background of div
                        //$("#imagePreview").css("background-image", "url("+this.result+")");
                        $("#imagenPreview").html("<img class='img-responsive animated fadeInLeftBig' src='"+this.result+"' alt=''>");
                    }
                }
            });
            
            $("#imagen2").on("change", function(){
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
                if (/^image/.test( files[0].type)){ // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file
                    reader.onloadend = function(){ // set image data as background of div
                        //$("#imagePreview").css("background-image", "url("+this.result+")");
                        $("#imagenPreview2").html("<div id='eliminarFoto2' style='width:250px;text-align:right'><button type='button' class='btn btn-danger' onclick=\"javascript:eliminarFoto('2')\"><i class='fa fa-trash-o'></i></button></div><img class='img-responsive animated fadeInLeftBig' src='"+this.result+"' width='250px'>");
                    }
                }
            });
            
            $("#imagen3").on("change", function(){
                var files = !!this.files ? this.files : [];
                if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
                if (/^image/.test( files[0].type)){ // only image file
                    var reader = new FileReader(); // instance of the FileReader
                    reader.readAsDataURL(files[0]); // read the local file
                    reader.onloadend = function(){ // set image data as background of div
                        //$("#imagePreview").css("background-image", "url("+this.result+")");
                        $("#imagenPreview3").html("<div id='eliminarFoto3' style='width:250px;text-align:right'><button type='button' class='btn btn-danger' onclick=\"javascript:eliminarFoto('3')\"><i class='fa fa-trash-o'></i></button></div><img class='img-responsive animated fadeInLeftBig' src='"+this.result+"' width='250px'>");
                    }
                }
            });
            
            function eliminarFoto(id_foto){
                $('#agregarImg'+id_foto).show();
                $('#divImg'+id_foto).hide();
                $('#imagen'+id_foto).val('');
                $('#imagenPreview'+id_foto).html('');
                
                if($('#imagenBorrar'+id_foto).length){
                   $('#imagenBorrar'+id_foto).val('borrar');
                }
            }
            
            function abrirDiv(id){
                $('#agregarImg'+id).hide();
                $('#divImg'+id).show();
            }
            
            $(document).ready(function(){
                console.log($("#imagePreview2").length);
            });
            
            var $fp = $(".filthypillow-1");
            $fp.filthypillow();
            $fp.on("focus", function(){
                $fp.filthypillow("show");
            });
            $fp.on( "fp:save", function(e,dateObj){
                $fp.val( dateObj.format("DD-MM-YYYY"));
                $fp.filthypillow( "hide" );
            });
        </script>
    </body>
</html>
