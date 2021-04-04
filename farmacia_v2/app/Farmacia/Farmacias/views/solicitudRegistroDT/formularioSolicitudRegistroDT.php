<!DOCTYPE html>
<html>
	<head>
		<title>MIDAS - Farmacia</title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
		<meta HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
		<meta NAME="ROBOTS" CONTENT="NONE">
		<meta NAME="GOOGLEBOT" CONTENT="NOARCHIVE">
		<meta HTTP-EQUIV="CONTENT-TYPE" CONTENT="text/html; charset=UTF-8">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/fontawesome-free/css/all.min.css">	
	<link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">	
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">	
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/select2/css/select2.min.css" />
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/select2-bootstrap4-theme/select2-bootstrap4.css" />	
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">	
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/dist/css/adminlte.min.css">	
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/dist/css/box-component.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
	<link rel="icon" type="image/png" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/img/logo_minsal_32.png" />	
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datepicker/datepicker3.css" />	
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/css/plugins/labelauty/jquery-labelauty.css" />
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datetimepicker/bootstrap-datetimepicker.css" />
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/timepicker_v1.3.5/timepicker.css">
	<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/css/style.css" />
    <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost() ?>pub/template/bootstrap/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/img/logo_minsal_32.png" />
		<link rel="icon" type="image/png" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/img/logo_minsal_32.png" />
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<style>
			.container-solicitud{
			background: url("<?php echo \pan\uri\Uri::getHost(); ?>pub/img/farmacia_background.png");
			background-position: center center;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;
			background-color: #464646;
			}
			.titulo_solicitud_dt{
			font-weight: 500;
			color: #c1f4ff;
            font-size: 35px;
			font-family: "system-ui";
			}
			.gradient-buttons .btn {
			background-image: linear-gradient(to bottom, rgba(255,255,255,0.5), rgba(255,255,255,0.2) 49%, rgba(0,0,0,0.15) 51%, rgba(0,0,0,0.05));
			background-repeat: repeat-x;
			}
			.form-control
			{
			-moz-border-radius:10px; /* Firefox */
			-webkit-border-radius: 10px; /* Safari, Chrome */
			-khtml-border-radius: 10px; /* KHTML */
			border-radius: 10px; /* CSS3 */
			
			}
			html{
			background: url("<?php echo \pan\uri\Uri::getHost(); ?>pub/img/farmacia_background.png") rgba(255, 0, 150, 0.3);
            /*background: url("<?php echo \pan\uri\Uri::getHost(); ?>pub/img/farmacia_background.png");*/
			background-position: center center;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover;
			background-color: #464646;
			}
			.overlay{
			position: absolute;
			height: 100%;
			width: 100%;
			top: 0;
			left: 0;
			background: rgba(0,0,0,0.35);
			
			color:white;
			display:flex;
			
			
			flex-direction: column;
			}

            .row {
    display: flex;
   /* align-items: center;*/
    justify-content: center;
}

.medio{
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    
    height: 100%;
    margin: auto;
}

.g-recaptcha{
    margin-left: 6%;
}

@media(max-width: 390px) {
    .g-recaptcha {
        margin: 1px;        
    }
}

.fondo-solicitud{
	background: -webkit-linear-gradient(left, rgba(43,66,109,0) 0%,rgba(43,66,109,0) 2%,rgba(43,66,109,0.80) 5%,rgba(43,66,109,0.8) 7%,rgba(43,66,109,0.80) 10%,rgba(43,66,109,0.80) 100%);
}
		</style>
	</head>
	<body>
    <div class="container">        
        <div class="overlay">
            <div class="row medio">
                <div class="col-3" style="background: rgb(0, 0, 0) transparent">
                    
                </div>
                <div class="col-9 fondo-solicitud" style=" align-items: center; padding-top: 8%; padding-left: 5%;">
                    <div class="login-box">
                        <div class="login-logo">
                            <strong class="titulo_solicitud_dt">CREAR SOLICITUD</strong>
                        </div>
                        <p class="login-box-msg">Ingrese sus datos para solicitud de registro de director técnico</p>
                        <div class="login-box-body">
                            <form role="form">
                                <div class="form-group has-feedback">
                                    <span> RUT </span>
                                    <input required type="text" name="rut" id="rut" class="form-control" style="background-color: #000c3a; color: #c1f4ff;" placeholder="RUT: 12345678-9" onkeyup="this.value = convierteEnRut(this.value);" onblur="Valida_Rut(this);"/>                    
                                </div>
                                <div class="form-group has-feedback">
                                    <span> Dirección de correo electrónico </span>
                                    <input required type="email" name="email" id="email" class="form-control"  style="background-color: #000c3a; color: #c1f4ff;" placeholder="email" onblur="validaEmail(this, 'Correo Inválido!')" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off" />
                                </div>
                                <div class="top-spaced form-group has-feedback">
                                    <span> Región de residencia </span>
                                    <select required id="select_solicitud_region_dt" name="select_solicitud_region_dt" class="form-control" style="background-color: #000c3a; color: #c1f4ff;" required>
                                        <?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
                                        <option value="0">Seleccione una Región</option>
                                        <?php endif; ?>
                                        <?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
                                        <option value="<?php echo $region->id_region_midas ?>" <?php echo (isset($arr->id_region) && $arr->id_region == $region->id_region_midas)?"selected":""; ?> ><?php echo $region->nombre_region_corto; ?></option>
                                        <?php endforeach;
                                            endif; ?>
                                    </select>
                                </div>
                                <div class="top-spaced">
                                    <div class="form-group has-feedback">
                                        <div class="g-recaptcha" data-sitekey="6Lf1oDoUAAAAANdtIGB7QE8LJww3HADBKuR8Ib5H"></div>
                                    </div>
                                </div>
                               <div class="row">
                                    <div id="ver_correo" class="row" style="display:none;">
                                        <hr />
                                        <div class="text-center">
                                            <span> ¿No llegó el correo? <a href='<?php echo "SolicitudRegistroDT/verCorreo"?>' target="blank" style="color:#d8ff00;">INGRESE AQUÍ</a></span>
                                        </div>
                                    </div><br>
                               </div>
                                <div class="row">
                                    
                                    <div class="col-xs-4 gradient-buttons">
                                        <button type="button" class="btn btn-primary" id="btn_solicitar" onclick="RegistroDT.ingresarSolicitud(this.form,this);">Continuar</button>
                                    </div>
                                   
                                </div>
                              
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
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
		<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/xmodal.js"></script>
		<script src="<?php echo \pan\uri\Uri::getHost() ?>pub/js/base.js?v=<?php microtime(); ?>"></script>
		<script src="<?php echo \pan\uri\Uri::getHost() ?>pub/js/helpers/modal.js?v=<?php microtime(); ?>"></script>
		<script src="<?php echo \pan\uri\Uri::getHost() ?>pub/js/validador.js?v=<?php microtime(); ?>"></script>
		<script src="<?php echo \pan\uri\Uri::getHost() ?>pub/js/plugins/bootstrap-dialog.js"></script>
		<script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery.livequery.min.js"></script>
		<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/form_dinamico.js"></script>      
		<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/utils.js"></script>
		<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery-labelauty.js"></script>
	</body>
</html>