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
$auspiciantes = getAuspiciantes($mysqli);
?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        
        <title>Editor de Auspisiantes - IGA</title>
        
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
                    <h3><i class="fa fa-angle-right"></i>Edicion de Auspisiantes</h3>
                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="form-panel">
                                <h4><i class="fa fa-angle-right"></i> Nuevo Auspisiantes</h4>
                                <section style="margin-top: 35px">
                                    <form class="form" enctype="multipart/form-data" method="POST" action="upload.php">
                                        <input type="hidden" name="nuevoAuspiciante" value="true">
                                        <label>Nombre: </label>
                                        <input type="text" name="name">
                                        <label>Pais: </label>
                                        <select name="pais">
                                            <option value="0">seleccione un pais</option>
                                            <?php foreach ($paises as $pais){?>
                                                <option value="<?= $pais['id'] ?>"><?= $pais['pais'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <label>Imagen: </label>
                                        <input type="file" accept="file_extension|image" name="photo" style="display: inline;">
                                        <br><br>
                                        <div id="respuesta" class="alert" style="display: none"></div>
                                        <br>
                                        <input type="submit" class="btn btn-success" value="Agregar">
                                    </form>
                                </section>
                            </div>
                        </div>
                    </div>
                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="form-panel">
                                <h4><i class="fa fa-angle-right"></i> Listado de Auspisiantes</h4>
                                <section>
                                        <?php foreach ($auspiciantes as $auspiciante){?>
                                        <div>
                                            <form class="form" enctype="multipart/form-data" method="POST" action="upload.php">
                                                <input type="hidden" name="id" value="<?= $auspiciante['id']?>">
                                                <label>Nombre:</label>
                                                <input type="text" value="<?= $auspiciante['nombre']?>" name="name">
                                                <label>Pais:</label>
                                                <select name="pais" required>
                                                    <option value="0">seleccione un pais</option>
                                                    <?php foreach ($paises as $pais){?>
                                                        <option value="<?= $pais['id'] ?>" <?php if($pais['id'] == $auspiciante['cod_pais']){echo 'selected';}?>><?= $pais['pais'] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label>Imagen:</label>
                                                <input type="file" 
                                                       accept="file_extension|image"  
                                                       name="photo" 
                                                       required 
                                                       style="display: inline;"
                                                       value="<?= $auspiciante['url_img']?>">
                                                <img src="../<?= $auspiciante['url_img']?>" style="max-width: 100px;">
                                                <input class="btn btn-danger" type = 'button' onclick='eliminarAuspiciante(this.form)' value='Eliminar'>
                                                <input class="btn btn-warning" type = 'button' onclick='editarAuspiciante(this.form)' value='Editar'>
                                            </form>
                                        </div>
                                        <?php } ?>
                                </section>
                            </div>
                        </div>
                    </div>
                </section><! --/wrapper -->
            </section><!-- /MAIN CONTENT -->
            
            <!--main content end-->
            <?php include_once 'footer.php';?>
        </section>
        
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/forms.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js" type="text/javascript"></script>
        <!--<script type="text/javascript" src="../js/main.js"></script>-->
        
        <!--common script for all pages-->
        <script src="assets/js/common-scripts.js"></script>
        
        <script>
            
            (function($) {  
                $.get = function(key)   {  
                    key = key.replace(/[\[]/, '\\[');  
                    key = key.replace(/[\]]/, '\\]');  
                    var pattern = "[\\?&]" + key + "=([^&#]*)";  
                    var regex = new RegExp(pattern);  
                    var url = unescape(window.location.href);  
                    var results = regex.exec(url);  
                    if (results === null) {  
                        return null;  
                    } else {  
                        return results[1];  
                    }  
                }  
            })(jQuery); 
            
            if($.get('result') != null)
            {
                if($.get('result') === 'ok')
                {
                    $('#respuesta').removeClass('alert-danger');
                    $('#respuesta').html('Auspiciante agregado correctamente');
                    $('#respuesta').addClass('alert-success');
                    $('#respuesta').show('slow').delay(3000).hide('slow');
                }
                else
                {
                    $('#respuesta').removeClass('alert-success');
                    $('#respuesta').html('Hubo un error, no fue posible agregar el Auspiciante');
                    $('#respuesta').addClass('alert-danger');
                    $('#respuesta').show('slow').delay(3000).hide('slow');
                }
            };
        </script>
    </body>
</html>