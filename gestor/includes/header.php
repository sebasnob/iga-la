        <div class="fullParaCerrarMenu"></div>
        <header id="home">
            <div class="main-nav">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" id="colapseButton" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php">
                            <h1><img class="img-responsive" src="images/logo-iga_transparent.png" alt="logo"></h1>
                        </a>                    
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-left">
                            <?php 
                                switch ($pagina)
                                {
                                    case 'home':
                                
                            ?>
                                        <li class="scroll active"><a href="#home"><?=$lenguaje['inicio_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                                        <li class="scroll"><a href="javascript:scroll('grillaCursos')"><?=$lenguaje['curso_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></a></li>
                                        <li class="scroll"><a href="javascript:scroll('blog')"><?=$lenguaje['novedades_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                                        <!--<li class="scroll"><a href="javascript:scroll('institucional')"><?=$lenguaje['institucional_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>  -->
                                        <li class="scroll"><a href="javascript:scroll('contact')"><?=$lenguaje['contacto_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                                    <?php if($_SESSION['pais']['cod_pais'] != 'US'){ ?>
                                        <li><a href="http://campus.igacloud.net/" target="_blank"><?=$lenguaje['campus_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></a></li> 
                                    <?php }
                                    break;
                                    
                                    case 'novedades':
                                    case 'cursos':
                                    case 'cursos_cortos':
                            ?>
                                        <li class="scroll active"><a href="index.php"><?=$lenguaje['inicio_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                                        <li class="scroll"><a href="index.php#grillaCursos"><?=$lenguaje['curso_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></a></li>
                                        <li class="scroll"><a href="index.php#blog"><?=$lenguaje['novedades_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                                        <!-- <li class="scroll"><a href="index.php#team"><?=$lenguaje['institucional_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>  -->
                                        <li class="scroll"><a href="index.php#contact"><?=$lenguaje['contacto_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></li>
                                        <?php if($_SESSION['pais']['cod_pais'] != 'US'){ ?>
                                        <li><a href="http://campus.igacloud.net/" target="_blank"><?=$lenguaje['campus_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?></a></li> 
                                    <?php }
                                    break;
                                }
                            ?>
                                        
                        </ul>
                        
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img src="<?=$_SESSION['pais']['flag']?>" /><span style="margin-left: 5px;"><?=substr($_SESSION['pais']['pais'], 0, 3)?></span><span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                <?php
                                foreach($paises as $i=>$d){
                                    if($_SESSION['pais']['cod_pais'] != $d['cod_pais']){
                                ?>
                                    <li><a href="javascript:cambiarPais('<?=$d['cod_pais']?>')" ><img src="<?=$d['flag']?>" /><span style="margin-left: 5px;"> <?=substr($d['pais'], 0, 3)?></span></a></li>
                                <?php
                                    }
                                }
                                ?>
                                </ul>
                            </li>
                            <?php if(count($idiomas) > 1) { ?>
                            <li style="padding: 5px;">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <?=substr($lenguaje[$_SESSION['idioma_seleccionado']['idioma'].'_'.$_SESSION['idioma_seleccionado']['cod_idioma']], 0, 2)?> 
                                    <?php if(count($idiomas) > 1) { ?>
                                    <span class="caret"></span>
                                    <?php } ?>
                                </a>
                                <ul class="dropdown-menu">
                                <?php
                                    foreach($idiomas as $i=>$d){
                                        if($_SESSION['idioma_seleccionado']['cod_idioma'] != $d['cod_idioma']){
                                    ?>
                                    <li>
                                        <a href="javascript:cambiarIdioma('<?=$d['cod_idioma']?>')" >
                                                <?=substr($lenguaje[$d['idioma'].'_'.$_SESSION['idioma_seleccionado']['cod_idioma']], 0, 2)?> 
                                        </a>
                                    </li>
                                    <?php
                                        }
                                    }
                                ?>  
                                </ul>
                            </li>
                            <?php
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div><!--/#main-nav-->
        <?php
        if(isset($slider) && count($slider) > 0){
        ?>
            <div id="slider" class="carousel slide carousel-fade" data-ride="carousel">
                
                <div class="carousel-inner">
                <?php 
                    $i=0; 
                    foreach($slider as $slid){
                ?>
                    <!--/#Solo en movil-->
                    <div id="sliderMovil" class="visible-xs item <?php if($i == 0){echo 'active';}?>"
                         <?php if(isset($slid['link']) && $slid['link'] != '')
                        {
                            echo "onclick=";
                            echo "javascript:iralink('{$slid['link']}')";
                                    
                        } ?>
                        title='<?= $slid['alt'];?>'>
                        <div class="container">
                            <div class="row">
                                <img class="img-responsive" src="<?= $slid['url'];?>" style="margin: 0 auto;">
                            </div>
                        </div>
                    </div>
                    <!--/#end movil-->
                    
                    
                    <div style="background-color: <?= $slid['background']?>" 
                        class="hidden-xs item <?php if($i == 0){echo 'active';}?>" 
                        <?php if(isset($slid['link']) && $slid['link'] != '')
                        {
                            echo "onclick=";
                            echo "javascript:iralink('{$slid['link']}')";
                                    
                        } ?>
                        title='<?= $slid['alt'];?>'>
                        <!--<div class="container">
                            <h2 style="position:absolute;padding-top:10%">
                                <table style="height: 100%; width: 100%">
                                    <tr style="vertical-align: bottom;">
                                        <td>
                                            <span style="color: white; font: bold 24px/45px Helvetica, Sans-Serif; letter-spacing: -1px;background: rgb(0, 0, 0); background: rgba(0, 0, 0, 0.7); padding: 10px; ">
                                    
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </h2>
                        </div>-->
                        <div class="container">
                            <h2 style="position:absolute;padding-top:4%;left:10%">
                                <span style="color: white;text-shadow: 1px 1px #333;">
                                  <?=$lenguaje['pasion_'.$_SESSION['pais']['cod_pais'].'_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>
                                </span>
                            </h2>
                        </div>
                        <img class="img-responsive" src="<?= $slid['url'];?>" style="margin: 0 auto;width: 100%">
                    </div>
                <?php
                        $i++;
                    } 
                ?>
                </div>
                
                <a class="left-control" href="#slider" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                <a class="right-control" href="#slider" data-slide="next"><i class="fa fa-angle-right"></i></a>
            </div><!--/#home-slider-->
            
            <div class="container visible-xs" >
                <br/>
                <div class="row col-md-12 text-center">
                    <?=$lenguaje['pasion_'.$_SESSION['pais']['cod_pais'].'_movil_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>
                </div>
            </div>
        <?php
        }
        ?>
            
        </header>
        <!--/#home-->

