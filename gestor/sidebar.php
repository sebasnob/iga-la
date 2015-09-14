<!-- **********************************************************************************************************************************************************
MAIN SIDEBAR MENU
*********************************************************************************************************************************************************** -->
<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">

            <!-- <p class="centered"><a href="profile.html"><img src="images/logo-iga_transparent.png" class="img-circle"></a></p>-->
            <p class="centered"><a href="index.php"><img src="images/logo-iga_transparent.png"></a></p>
            <h5 class="centered"><?=strtoupper($_SESSION['username']);?></h5>

           <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-plus-square-o"></i>
                    <span>Agregar Curso</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-th"></i>
                    <span>Listado de Cursos</span>
                </a>
                <ul class="sub">
                    <?php 
                    $cursos = getCursos($mysqli);
                    foreach($cursos as $i=>$j){
                    ?>
                    <li><a href="cursos.php?id_curso=<?=$j['id']?>"><?=$j['nombre']?></a></li>
                    <?php
                    }
                    ?>
                </ul>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->