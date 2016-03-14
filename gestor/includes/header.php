<?php 
    $useragent=$_SERVER['HTTP_USER_AGENT'];
    $movil = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)); 
?>

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
                            <h1><img class="img-responsive" src="images/logo.jpg" alt="logo" style="width: 118px"></h1>
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
                    if(!$movil){
                    $i=0; 
                    foreach($slider as $slid){
                ?>
                    <div style="background-color: <?= $slid['background']?>" 
                        class="hidden-xs item <?php if($i == 0){echo 'active';}?>" 
                        <?php if(isset($slid['link']) && $slid['link'] != '')
                        {
                            echo "onclick=";
                            echo "javascript:iralink('{$slid['link']}')";
                                    
                        } ?>
                        title='<?= $slid['alt'];?>'>
                        <div class="container">
			<?php if($i < 1 ) : ?>                           
				 <h2 style="position:absolute;padding-top:5%;left:10%">
                                <span style="color: white;text-shadow: 1px 1px #333;">
                                  <?=$lenguaje['pasion_'.$_SESSION['pais']['cod_pais'].'_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?>
                                </span>
                            </h2>
			<?php endif; ?>

                        </div>
                        <img class="img-responsive" src="<?= $slid['url'];?>" style="margin: 0 auto;width: 100%">
                    </div>
                <?php
                        $i++;
                    }
                }    
                ?>
                    <?php
                    if($movil){
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
                    
                    <?php
                        $i++;
                    }
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

