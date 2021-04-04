<!DOCTYPE html>
<html>

<head>
    <title>Minsal :: <?php echo \pan\kore\App::getName(); ?></title>

    <link rel="shortcut icon" type="image/ico" href="<?php echo \pan\uri\Uri::getHost() ?>/favicon.ico">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
    <meta HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
    <meta NAME="ROBOTS" CONTENT="NONE">
    <meta NAME="GOOGLEBOT" CONTENT="NOARCHIVE">
    <meta HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost() ?>pub/template/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost() ?>pub/template/font-awesome-4.7/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost() ?>pub/template/ionic/css/ionicons.min.css">
    <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost() ?>pub/template/dist/css/AdminLTE.min.css">

    <script src='https://www.google.com/recaptcha/api.js'></script>


</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="javascript:void(0);"><strong><?php echo \pan\kore\App::getName(); ?></strong></a>
        </div>
        <div class="login-box-body">
            <p class="login-box-msg">Ingrese sus datos para comenzar sesión</p>
            <form role="form">
                <div class="form-group has-feedback">
                    <input type="text" name="rut" id="rut" class="form-control" style="background-color: #E4EBF3; color: #1180CA;" placeholder="RUT: 12345678-9" onkeyup="this.value = convierteEnRut(this.value);" onblur="Valida_Rut(this)">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" onkeypress="Login.pressEnter(event);" AUTOCOMPLETE="off">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>


                <div class="form-group has-feedback">
                    <div class="g-recaptcha" data-sitekey="6Lf1oDoUAAAAANdtIGB7QE8LJww3HADBKuR8Ib5H"></div>
                </div>

                <div class="row">
                    <div class="col-xs-4">
                        <button type="button" class="btn btn-primary btn-block btn-flat" id="btn_ingresar" onclick="Login.loginUsuario(this.form,this);">Ingresar</button>
                    </div>
                </div>

                <div class="row">
                    <hr>
                    <div class="col-xs-12 table-responsive">
                        <pre style="white-space: normal;">
                            <p>
                                <!--table class="table table-hover table-striped table-bordered no-footer dataTable">
                                    <tbody-->
                                        Administrador:  12121121-1<br>
                                        Enc.Regional Valparaíso:  22222222-2<br>
                                        Enc.Regional R.M.: 2752794-9<br>
                                        Enc.Territorial Valparaíso:  7832600-K<br>
                                        Enc.Territorial Metropolitana:  12649862-4<br>
                                        Vende.Talonario Valparaíso:  7832600-K<br>
                                        Vende.Talonario R.M.:  12649862-4<br>
                                        Director Tecnico:  12820552-7<br>
                                        Quimico Recepcionante:  16151659-7<br>
                                        Medico:  8583370-7  
                                    <!--/tbody>
                                </table-->
                            </p>
                        </pre>
                    </div>
                </div>

                <!--div class="row">
                        <hr>
                        <div class="col-xs-12">
                        <pre style="white-space: normal;">
                            <p>
                                admin@cosof.cl <br>
                                formularios@email.cl<br>
                                establecimientos@email.cl<br>
                                nacional@email.cl<br>
                                internacional@email.cl
                            </p>
                        </pre>
                        </div>
                    </div-->
                <div class="row">
                    <hr />
                    <div class="small text-center">                    
                        <a href='<?php echo \pan\uri\Uri::getHost()."Farmacia/Farmacias/SolicitudRegistroDT"?>' target="blank">Solicitud registro DT</a>
                    </div>
                </div>
                <div class="row">
                    <hr />
                    <div class="small text-center">
                        <a href="https://midas.minsal.cl" target="blank">&copy;HOPE</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php /*
        <div class="panel panel-body" align="center" style="width: 360px; margin:7% auto; margin-top:-100px;">
            <a href="<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Usuario/Login/crearCuenta">
                ¿Eres nuevo? Crear nueva cuenta
            </a>
        </div>
        */ ?>

    <!-- 
        Integra las constantes a nivel de js 
        (testing de funcionamiento)
        -->
    <script type="text/javascript">
        var listConstantes = <?php echo json_encode(\Constantes::getAll()); ?>;
        listConstantes['BASE_HOST'] = "<?php echo \Pan\Uri\Uri::getHost(); ?>";
        listConstantes['BASE_URI'] = "<?php echo \Pan\Uri\Uri::getBaseUri(); ?>";
    </script>

    <script src="<?php echo \pan\uri\Uri::getHost() ?>pub/js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo \pan\uri\Uri::getHost() ?>pub/template/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo \pan\uri\Uri::getHost() ?>pub/js/base.js?v=<?php microtime(); ?>"></script>
    <script src="<?php echo \pan\uri\Uri::getHost() ?>pub/js/helpers/modal.js?v=<?php microtime(); ?>"></script>
    <script src="<?php echo \pan\uri\Uri::getHost() ?>pub/js/validador.js?v=<?php microtime(); ?>"></script>
    <script src="<?php echo \pan\uri\Uri::getHost() ?>pub/js/plugins/bootstrap-dialog.js"></script>
</body>

</html>