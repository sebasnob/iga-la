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
          <div class="row mt">
                  <div class="col-md-12">
                      <section class="task-panel tasks-widget">
                        <div class="panel-heading">
                            <div class="pull-left"><h5><i class="fa fa-tasks"></i> Novedades</h5></div>
                            <a class="btn btn-default btn-sm pull-right" href="news_admin.php">Nueva</a>
                            <br>
                        </div>
                          <div class="panel-body">
                              <div class="task-content">
                                  <table class="table table-striped table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th><i class="fa fa-bullhorn"></i> Titulo</th>
                                            <th>&nbsp;</th>
                                            <th><i class="fa fa-bookmark"></i> Fecha</th>
                                            <th><i class=" fa fa-edit"></i> Estado</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $novedades = getNovedades($mysqli);
                                    foreach($novedades as $i=>$j){
                                    ?>
                                        <tr>
                                            <td><a href="news_admin.php?id=<?=$j['id']?>"><?=$j['titulo']?></a></td>
                                            <td>&nbsp;</td>
                                            <td><?=$j['fecha']?></td>
                                            <td>
                                                <?php echo ($j['estado'] == 1)? "<span id='span".$j['id']."' class='label label-success label-mini'>Publicada</span>":"<span id='span".$j['id']."' class='label label-danger label-mini'>No Publicada</span>"; ?>
                                            </td>
                                            <td>
                                                <button class='btn <?php echo ($j['estado'] == 1)? "btn-default":"btn-success";?>  btn-xs' onclick="javascript:cambiarEstadoNovedad(this, span<?=$j["id"]?>, <?=$j['id']?>)"><i class='fa fa-check'></i></button>
                                                <a href="news_admin.php?id=<?=$j['id']?>" class="btn btn-primary btn-xs"><i class="fa fa-pencil"></i></a>
                                                <button class="btn btn-danger btn-xs" onclick="javascript:eliminarNovedad(this, <?=$j['id']?>)"><i class="fa fa-trash-o "></i></button>
                                            </td>
                                        </tr>
                                    <!--<div class="task-title">
                                        <span class="task-title-sp"><? //$j['cod_curso']?>&nbsp;&nbsp;<? //$j['nombre_es']?></span>
                                        <!--<span class="badge bg-theme">Nuevo</span>
                                        <div class="pull-right">
                                            <input class="btn btn-xs" type="color" id="select_color_fondo" value="#<? //$j['color']?>"/>
                                            <a class="btn btn-primary btn-xs" href="cursos.php?cod_curso=<? //$j['cod_curso']?>"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-default btn-xs" href="cursos_grupo.php?cod_curso=<? //$j['cod_curso']?>"><i class="fa fa-th-list"></i></a>
                                        </div>
                                    </div>-->
                                    <?php
                                    }
                                   ?>
                                    </tbody>
                                </table>
                              </div>
                          </div>
                      </section>
                   </div><!-- /col-md-12-->
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
    <script type="text/javascript">
        function cambiarEstadoNovedad(boton, spanid, id_noticia){
            $.ajax({
                url: "controller_ajax.php",
                method: "POST",
                data: {option : 'cambiar_estado_noticia', id_noticia : id_noticia},
                dataType: "json",
                success: function(data){
                    if(data.result == 'ok'){
                        if($(boton).hasClass("btn-default")){
                            $(boton).removeClass("btn-default");
                            $(boton).addClass("btn-success");
                            
                            $(spanid).removeClass("label-success");
                            $(spanid).addClass("label-danger");
                            $(spanid).html('No Publicada')
                        }else{
                            $(boton).removeClass("btn-success");
                            $(boton).addClass("btn-default");
                            
                            $(spanid).removeClass("label-danger");
                            $(spanid).addClass("label-success");
                            $(spanid).html('Publicada')
                        }
                    }
                }
            });
        }
        
        function eliminarNovedad(boton, id_noticia){
            $.ajax({
                url: "controller_ajax.php",
                method: "POST",
                data: {option : 'eliminar_noticia', id_noticia : id_noticia},
                dataType: "json",
                success: function(data){
                    if(data.result == 'ok'){
                        
                    }
                }
            });
        }
    </script>

  </body>
</html>
