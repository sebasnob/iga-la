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
        <link rel="shortcut icon" href="images/favicon.ico">
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