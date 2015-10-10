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
               <a href="home_edit.php" >
                    <i class="fa fa-home fa-lg"></i>
                    <span>Editar Home</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="list_cursos.php" >
                    <i class="fa fa-th"></i>
                    <span>Listado de Cursos</span>
                </a>

            </li>
            <li class="sub-menu">
                <a href="grilla_edit.php" >
                    <i class="fa fa-image"></i>
                    <span>Editar Grilla</span>
                </a>
            </li>    
            <li class="sub-menu">
                <a href="news.php" >
                    <i class="fa fa-image"></i>
                    <span>Novedades</span>
                </a>
            </li>    
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->