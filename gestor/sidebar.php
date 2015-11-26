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
                    <i class="fa fa-th"></i>
                    <span>Cursos</span>
                </a>
                <ul class="sub">
                    <li><a  href="list_cursos.php">Todos los Cursos</a></li>
                    <!-- <li><a  href="cursos_tipo.php">Tipos de Cursos</a></li>-->
                </ul>
            </li>
            <li class="sub-menu">
                <a href="grilla_edit.php" >
                    <i class="fa fa-image"></i>
                    <span>Editar Grilla</span>
                </a>
            </li>    
            <li class="sub-menu">
                <a href="news.php" >
                    <i class="fa fa-rss"></i>
                    <span>Noticias</span>
                </a>
            </li>    
            <li class="sub-menu">
                <a href="slider_edit.php" >
                    <i class="fa fa-cloud-upload"></i>
                    <span>Editar Slider</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="auspiciantes_edit.php" >
                    <i class="fa fa-credit-card"></i>
                    <span>Editar Auspiciantes</span>
                </a>
            </li>
            <li class="sub-menu">
                <a href="cursos_cortos_edit.php" >
                    <i class="fa fa-list-ul"></i>
                    <span>Cursos Cortos</span>
                </a>
            </li>
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
