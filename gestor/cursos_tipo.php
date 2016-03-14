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

if(filter_var($_GET['id'], FILTER_VALIDATE_INT) === false)
{
    header("Location:index.php");
    exit();
}

$tiposCurso = getTiposCursos($mysqli);

?>
<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        
        <title>Tipos de Cursos - IGA</title>
        
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
                    <h3><i class="fa fa-angle-right"></i>Tipos de Cursos </h3>
                    
                    <?php
                    if(isset($_GET['id'])){
                        $tipo_curso = getTipoCurso($mysqli, $_GET['id']);
                    ?>
                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="form-panel">
                                <h4><i class="fa fa-angle-right"></i> Editar Tipo de Curso</h4>
                                <section id="editor_grilla_nueva">
                                    <form class="form" method="POST" action="upload.php">
                                        <input type="hidden" name="editar_tipo_curso" id="agregar_tipo" value="true" />
                                        <input type="hidden" name="id_tipo" id="id_tipo" value="<?=$_GET['id']?>" />
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Nombre Es: </label>
                                            <input type="text" id="nombre_es" name="nombre_es" value="<?=$tipo_curso['nombre_es']?>" />
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Nombre IN: </label>
                                            <input type="text" id="nombre_in" name="nombre_in" value="<?=$tipo_curso['nombre_in']?>" />
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Nombre POR: </label>
                                            <input type="text" id="nombre_pt" name="nombre_pt" value="<?=$tipo_curso['nombre_pt']?>" />
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Superior: </label>
                                            <select class="form-control" name="tipo_curso" id="tipo_curso">
                                                <option value="0">Sin Superior</option>
                                                <?php 
                                                foreach($tiposCurso as $i=>$j){ 
                                                    if($j['nombre_es'] != $tipo_curso['nombre_es']){
                                                ?>
                                                <option value="<?=$j['id']?>"><?=$j['nombre_es']?></option>
                                                <?php 
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-success" id="btn_editar">Editar Tipo</button>
                                        <a href="cursos_tipo.php" type="button" class="btn btn-info">Volver</a>
                                    </form>
                                </section>
                            </div><!-- /content-panel -->
                        </div>
                    </div>
                    
                    <?php    
                    }else{
                    ?>
                    
                    <div class="row mt">
                        <div class="col-lg-12">
                            <div class="form-panel">
                                <h4><i class="fa fa-angle-right"></i> Agregar Tipo de Curso</h4>
                                <section id="editor_grilla_nueva">
                                    <form class="form" method="POST" action="upload.php">
                                        <input type="hidden" name="agregar_tipo" id="agregar_tipo" value="true" />
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Nombre Es: </label>
                                            <input type="text" id="nombre_es" name="nombre_es" />
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Nombre IN: </label>
                                            <input type="text" id="nombre_in" name="nombre_in" />
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Nombre POR: </label>
                                            <input type="text" id="nombre_pt" name="nombre_pt" />
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-2 col-sm-2 control-label">Superior: </label>
                                            <select class="form-control" name="tipo_curso" id="tipo_curso">
                                                <option value="0">Sin Superior</option>
                                                <?php foreach($tiposCurso as $i=>$j){ ?>
                                                <option value="<?=$j['id']?>"><?=$j['nombre_es']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-success" id="btn_agregar">Agregar Tipo</button>
                                    </form>
                                </section>
                            </div><!-- /content-panel -->
                        </div>
                    </div>
                    
                    <div class="row mt">
                        <div class="col-md-12">
                            <div class="form-panel">
                             <table class="table table-striped table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre ES</th>
                                            <th>Nombre IN</th>
                                            <th>Nombre POR</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach($tiposCurso as $i=>$j){
                                    ?>
                                        <tr class="<?=$j['id']?>">
                                            <td><?=$j['nombre_es']?></td>
                                            <td><?=$j['nombre_in']?></td>
                                            <td><?=$j['nombre_pt']?></td>
                                            <td class="text-right">
                                                <a href="cursos_tipo.php?id=<?=$j['id']?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <button class="btn btn-danger btn-xs" onclick="javascript:eliminarTipo(this, <?=$j['id']?>, <?=$j['id']?>)"><i class="fa fa-trash-o "></i></button>
                                            </td>
                                        </tr>
                                    <?php
                                        $subTipos = getTiposCursos($mysqli, $j['id']);
                                        foreach($subTipos as $id=>$data){
                                    ?>
                                        <tr class="<?=$j['id']?>">
                                            <td>&nbsp;&nbsp;- <?=$data['nombre_es']?></a></td>
                                            <td class="text-right"></td>
                                            <td class="text-right"></td>
                                            <td class="text-right">
                                                <a href="cursos_tipo.php?id=<?=$data['id']?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <button class="btn btn-danger btn-xs" onclick="javascript:eliminarTipo(this, <?=$data['id']?>,'')"><i class="fa fa-trash-o "></i></button>
                                            </td>
                                        </tr>
                                    <?php
                                        }
                                    }
                                   ?>
                                    </tbody>
                                </table>      
                            </div>
                        </div>    
                    </div><!-- /row -->
                    <?php
                    }
                    ?>
                    
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
        
        
        <!--common script for all pages-->
        <script src="assets/js/common-scripts.js"></script>
        
        <!--script for this page-->
        <script type="text/javascript">
        function eliminarTipo(boton, id_tipo, classtr){
            $.ajax({
                url: "controller_ajax.php",
                method: "POST",
                data: {option : 'eliminar_tipo_curso', id_tipo : id_tipo},
                dataType: "json",
                success: function(data){
                    if(data.result == 'ok'){
                        if(classtr != ''){
                            $("."+classtr).fadeOut("slow");
                        }else{
                            $(boton).parents("tr").fadeOut("slow");
                        }
                        location.reload(true);
                    }
                }
            });
        }
        
        $('#btn_agregar').click(function(){
            $.ajax({
                url: "controller_ajax.php",
                method: "POST",
                data: {
                    option : 'agregar_tipo_curso', 
                    nombre_es: $('#nombre_es').val(), 
                    nombre_in: $('#nombre_in').val(), 
                    nombre_pt: $('#nombre_pt').val(), 
                    tipo_curso: $('#tipo_curso').val()
                },
                dataType: "json",
                success: function(data){
                    if(data.result == 'ok'){
                        location.reload(true);
                    }
                }
            }); 
        });
        
        $('#btn_editar').click(function(){
            $.ajax({
                url: "controller_ajax.php",
                method: "POST",
                data: {
                    option : 'editar_tipo_curso', 
                    nombre_es: $('#nombre_es').val(), 
                    nombre_in: $('#nombre_in').val(), 
                    nombre_pt: $('#nombre_pt').val(), 
                    tipo_curso:$('#tipo_curso').val(),
                    id_tipo: $('#id_tipo').val()
                },
                dataType: "json",
                success: function(data){
                    if(data.result == 'ok'){
                        window.location.href='cursos_tipo.php';
                    }
                }
            }); 
        });
        
        
        </script>
        
    </body>
</html>
