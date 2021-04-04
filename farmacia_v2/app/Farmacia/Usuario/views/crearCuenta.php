<!DOCTYPE html>
<html>
    <head>
    <title>Minsal :: <?php echo \pan\kore\App::getName(); ?></title>

    <link rel="shortcut icon" type="image/ico" href="<?php echo \pan\uri\Uri::getHost()?>/favicon.ico">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <meta HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
    <meta NAME="ROBOTS" CONTENT="NONE">
    <meta NAME="GOOGLEBOT" CONTENT="NOARCHIVE">
    <meta HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/fontawesome-free/css/all.min.css">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="icon" type="image/png" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/img/logo_minsal_32.png" />
    <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/css/style.css" />

    <script src='https://www.google.com/recaptcha/api.js'></script>

    </head>
    <body class="hold-transition login-page">
        <?php if($boCrearCuenta == 1): ?>
        
            <div class="col-3">
                <div class="card card-default">
                    <div class="card-body" style="text-align: center;">
                        <label>Ingrese su email</label>
                        <form role="form" action="<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Usuario/Login/crearCuenta" method="post" id="loginForm">
                            <input class="form-control" id="gl_email" name="gl_email" value="<?php echo $gl_email; ?>" <?php echo $disabled; ?>>
                            <button class="form-control btn btn-primary" id="btn_enviar" name="btn_enviar" onclick="submit"><i class="fa fa-send"></i>&nbsp;Confirmar Email</button>
                        </form>
                    </div>
                </div>
            </div>

        <?php else: ?>
        
            

        <?php endif; ?>
        
        <script type="text/javascript">
            var listConstantes          = <?php echo json_encode(\Constantes::getAll()); ?>;
            listConstantes['BASE_HOST'] = "<?php echo \Pan\Uri\Uri::getHost();?>";
            listConstantes['BASE_URI']  = "<?php echo \Pan\Uri\Uri::getBaseUri();?>";
        </script>
        
        <!-- jQuery -->
        <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- plugins-->
        <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
        <!-- AdminLTE -->
        <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/dist/js/adminlte.js"></script>
        
        <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery.livequery.min.js"></script>
        <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/base.js"></script>
        <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/xmodal.js"></script>
    </body>
</html>
