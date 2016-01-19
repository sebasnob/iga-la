<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin - IGA</title>
        <link rel="apple-touch-icon" sizes="57x57" href="images/favicons/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="images/favicons/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="images/favicons/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="images/favicons/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="images/favicons/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="images/favicons/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="images/favicons/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="images/favicons/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="images/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="images/favicons/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/favicon-16x16.png">
        <link rel="manifest" href="images/favicons/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="images/favicons/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <link href='http://fonts.googleapis.com/css?family=Raleway:400,100,900,800,600,500,700,300,200' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.css">
        <script src="assets/js/jquery.js"></script> 
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/sha512.js"></script> 
        <script src="assets/js/forms.js"></script> 
    </head>
    <body>
        <div id="login-page">
            <div class="container">
                <form class="form-login" id="form-login" method="POST" action="includes/process_login.php">
                <?php
                if (isset($_GET['error'])) 
                {
                    echo '<p class="error">email o password incorrecto</p>';
                }
                ?>
                <h2 class="form-login-heading">Administrador IGA </h2>
                <div class="login-wrap">
                    <input type="text" name="email" class="form-control" placeholder="Email" autofocus />
                    <br>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" />
                    <br />
                    <button class="btn btn-lg btn-primary btn-block" type="button" onclick="formhash(this.form, this.form.password);" ><i class="fa fa-lock"></i> Ingresar</button>
                    <br />
               </div>
                </form>
            </div>
        </div>
        <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
        <script>
            $.backstretch("assets/img/login-bg.jpg", {speed: 500});
            
            $(document).ready(function(){
                $(document).keypress(function(e){
                    if (e.keyCode == 13) {
                        formhash(document.getElementById('form-login'), document.getElementById('password'));
                    }
                });
            });
            
        </script>
    </body>
</html>