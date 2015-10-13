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
                            <div class="pull-left"><h5><i class="fa fa-tasks"></i> Listado de Cursos</h5></div>
                            <br>
                        </div>
                          <div class="panel-body">
                              <div class="task-content">
                            <?php
                                $tiposCurso = getTiposCursos($mysqli);
                                $cursos = getCursos($mysqli);
                                foreach($cursos as $i=>$j){
                                ?>
                                 <ul class="task-list">
                                      <li>
                                          <div class="task-title">
                                              <span class="task-title-sp"><?=$j['cod_curso']?>&nbsp;&nbsp;<?=$j['nombre_es']?></span>
                                              <!--<span class="badge bg-theme">Nuevo</span>-->
                                              <div class="pull-right">
                                                  <a data-toggle="dropdown" class="dropdown-toggle" href="index.html#">
                                                    Edicion Rapida
                                                  </a>
                                                  <ul class="dropdown-menu list-inline">
                                                    <li>
                                                        <ul style="overflow-y: scroll;height: 200px;background-color: #fff;border: 1px solid #ccc;padding-left:0px;padding-right:25px;">
                                                            <?php
                                                            foreach($tiposCurso as $id_t=>$data_t){
                                                            ?>
                                                              <li><input type="checkbox" name="tipos"/>&nbsp;<?=$data_t['nombre_es']?></li>
                                                            <?php
                                                                $subTipos = getTiposCursos($mysqli, $data_t['id']);
                                                                foreach($subTipos as $id=>$data){
                                                            ?>
                                                              <li style="padding-left:18px">&nbsp;&nbsp; <input type="checkbox" name="tipos"/> <?=$data['nombre_es']?></li>
                                                            <?php
                                                                }
                                                            }
                                                           ?>
                                                        </ul>
                                                    </li>
                                                    <li style="vertical-align:top">
                                                        Cambiar Color<input type="text" id="select_color_fondo" value="#<?=$j['color']?>"/>
                                                    </li>
                                                    <br/>
                                                    <br/>
                                                    <li>
                                                        <button type="button" class="btn btn-success">Aceptar</button>
                                                        <button type="button" class="btn btn-default">Cerrar</button>
                                                    </li>
                                                  </ul>
                                                  
                                                  <a class="btn btn-primary btn-xs" href="cursos.php?cod_curso=<?=$j['cod_curso']?>"><i class="fa fa-pencil"></i></a>
                                                  <a class="btn btn-default btn-xs" href="cursos_grupo.php?cod_curso=<?=$j['cod_curso']?>"><i class="fa fa-th-list"></i></a>
                                              </div>
                                          </div>
                                      </li>
                                  </ul>
                                  <?php
                                    }
                                   ?>
                              </div>

                              <div class=" add-task-row">
                                  <!--<a class="btn btn-success btn-sm pull-left" href="todo_list.html#">Agregar Nuevo Curso</a>-->
                                  <a class="btn btn-default btn-sm pull-right" href="todo_list.html#">Buscar Curso</a>
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
        $(document).ready(function(){
            localStorage.clear();
        });
        
        $('.dropdown-menu').click(function(e) {
            e.stopPropagation();
        });
    </script>

  </body>
</html>
