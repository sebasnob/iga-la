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
        <link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
        
		<!--<link rel="stylesheet" href="../rs-plugin/css/settings.css" media="screen" />
        <link rel="stylesheet" href="../css/plugins.css" />
        <link rel="stylesheet" href="../css/style.css" />
        <link rel="stylesheet" href="../css/scrolling-nav.css" />-->
        
        <script src="js/jquery.js"></script> 
        <script src="js/bootstrap.min.js"></script>
		
		<!--<script src="../js/jquery-migrate-1.2.1.min.js"></script> 
        <script src="../rs-plugin/js/jquery.themepunch.tools.min.js"></script> 
        <script src="../rs-plugin/js/jquery.themepunch.revolution.min.js"></script> 
        <script src="../js/plugins.js"></script> 
        <script src="../js/custom.js"></script> 
        <script src="../js/scrolling-nav.js"></script>
        <script src="../js/jquery.easing.min.js"></script>-->
        
        <script src="js/sha512.js"></script> 
        <script src="js/forms.js"></script> 
    </head>
    
    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <div class="account-wall">
                        <form class="form-signin" method="POST" action="includes/process_login.php">
                            <?php
                                if (isset($_GET['error'])) 
                                {
                                    echo '<p class="error">email o password incorrecto</p>';
                                }
                                ?>
                            <input type="text" name="email" class="form-control" placeholder="email" required autofocus>
                            <input type="password" name="password" id="password" class="form-control" placeholder="contraseña" required>
                            <button class="btn btn-lg btn-primary btn-block" 
                                    type="button" 
                                    onclick="formhash(this.form, this.form.password);">
                                Ingresar
                            </button>
                    </div>
                </div>
            </div>
    </body>
</html>

