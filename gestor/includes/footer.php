<footer id="footer">
    <div class="footer-top wow fadeInUp" data-wow-duration="1000ms" data-wow-delay="300ms">
        <div class="container">
            <div class="row">

                <div class="col-md-6 col-sm-12 textleft">
                    <ul>
                        <li><p class="letterfoot"><a href="http://www.iga-la.com/empleos/" target="_blank"><?=$lenguaje['quiero_trabajar_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></p></li>
                        <li><p class="letterfoot"><a href="http://igafranchising.com/" target="_blank"><?=$lenguaje['quiero_una_franquicia_'.$_SESSION['idioma_seleccionado']['cod_idioma']] ?> </a></p></li>
                    </ul> 

                </div>
                <?php 
                $facebook = "https://www.facebook.com/IGA.GASTRONOMIA";
                $twitter = "https://twitter.com/IGA_LA";
                $google = "https://google.com/+Igalatinoamerica";
                    if($_SESSION['pais']['id'] == 2)
                    {
                        $facebook = "https://www.facebook.com/IGABRASIL";
                        $twitter = "https://twitter.com/IGA_BRASIL";
                        $google = "https://google.com/+IGABRASILGASTRONOMIA";
                    }
                    if($_SESSION['pais']['id'] == 10)
                    {
                        $facebook = "https://www.facebook.com/IGA.US";
                        $twitter = "#";
                        $google = "https://plus.google.com/116894700549987766068/about";
                    }
                ?>
                <div class="col-md-6 col-sm-12 social-icons">
                    <ul>
                        <li><a class="facebook" href="<?=$facebook?>" target="_blank"><i class="fa fa-facebook"></i></a></li>  
                        <li> <a class="twitter" href="<?=$twitter?>" target="_blank"><i class="fa fa-twitter"></i></a></li>  
                        <li><a class="envelope" href="<?=$google?>" target="_blank"><i class="fa fa-google-plus"></i></a></li>  
                    </ul>    
                </div>
            </div>
        </div>
    </div>
    <!--<div class="col-md-12 auspiciantes">
        <?php 
        $auspiciantes = getAuspiciantes($mysqli);
        foreach ($auspiciantes as $auspiciante){ 
            if(in_array($_SESSION['pais']['id'], $auspiciante['cod_pais']))
            {
                $tienQueAparecer = true;
            ?>
            <div class="footer-logo">
                <a href="<?= $auspiciante['link']?>">
                    <img class="img-responsive" src="<?= $auspiciante['url_img']?>" alt="<?= $auspiciante['nombre']?>" style="max-width: 100px;"/>
                </a>
            </div>
        <?php 
            }
        } ?>
    </div>-->
    <div class="col-md-12 footer-bottom">
        <div class="container">
            <div class="col-md-9">
                <?php 
                $auspiciantes = getAuspiciantes($mysqli);
                foreach ($auspiciantes as $auspiciante){ 
                    if(in_array($_SESSION['pais']['id'], $auspiciante['cod_pais']))
                    {
                        $tienQueAparecer = true;
                    ?>
                    <div class="footer-logo">
                        <a href="<?= $auspiciante['link']?>">
                            <img class="img-responsive" src="<?= $auspiciante['url_img']?>" alt="<?= $auspiciante['nombre']?>" style="max-width: 100px;"/>
                        </a>
                    </div>
                <?php 
                    }
                } ?>
            </div>
            <div class="col-md-3 col-xs-12 col-sm-12" style="padding-right: 5px;">
                <p class="letterblack"><a target="_blank" href="http://www.lifeweb.com.ar/">&copy; <?=date("Y")?> Designed by lifeWEB</a></p>
            </div>
        </div>
    </div>
    <div class="arrowTop"><i class="fa fa-arrow-circle-o-up"></i></div>
</footer>
