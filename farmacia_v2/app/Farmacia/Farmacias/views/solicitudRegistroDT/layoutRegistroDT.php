<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>MINSAL :: <?php echo \pan\kore\App::getName(); ?></title>	
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
	<style>
		input.labelauty:checked + label {
			background-color: #179bf9;
			color: #ffffff;
			
		}
		input.labelauty + label {
			display: table;
			font-size: 14px;
			min-width: 192px;
		}
		input.labelauty:checked:not([disabled]) + label:hover {
			background-color: #61b6ff;
			min-width: 192px;
		}

		.card-dt-purple{
			background-color: #2c5e82;
		}

		.card-primary:not(.card-outline)>.card-header {
			background-color: #2c5e82;
		}


		label {
			color: #2c4b79;
		}

		.form-control:disabled, .form-control[readonly] {
			background-color: #cbe0f7;
			opacity: 1;
		}

		.form-control:disabled, .form-control[readonly] {
			background-color: #cbe0f7;
			opacity: 1;
		}

		input[type='text']{
			color:#506fb7;
		}
		input[type='text']:focus{
			color:#506fb7;
			background: #f9fde8;
		}
		select.form-control{
			color:#506fb7;
		}
		select.form-control:focus{
			color:#506fb7;
			background: #f9fde8;
		}
		@media screen and (max-width: 600px) {
			.col-1, .col-5{
				min-width: 100%;
				margin-top: 0;
			}

			.col-2, .col-4, .col-10, .col-6, .col-3, .col-9{
				min-width: 100%;
				margin-top: 0;
			}

		}


		@media 
		only screen and (max-width: 760px),
		(min-device-width: 768px) and (max-device-width: 1024px)  {

			/* Force table to not be like tables anymore */
			table, thead, tbody, th, td, tr { 
				display: block; 
			}
			
			/* Hide table headers (but not display: none;, for accessibility) */
			thead tr { 
				position: absolute;
				top: -9999px;
				left: -9999px;
			}
			
			tr { border: 1px solid #ccc; }
			
			td { 
				/* Behave  like a "row" */
				border: none;
				border-bottom: 1px solid #eee; 
				position: relative;
				padding-left: 50%; 
			}
			
			td:before { 
				/* Now like a table header */
				position: absolute;
				/* Top/left values mimic padding */
				top: 6px;
				left: 6px;
				width: 45%; 
				padding-right: 10px; 
				white-space: nowrap;
			}
		}

	</style>

</head>
<body>
	<?php
		
		$get_hash 		= (basename("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].""))!=null?basename("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].""):"";			
		$parametros 	=  base64_decode(substr($get_hash,8));		
		$rut_hash 		= substr($parametros, 0, 20);	
		$email_hash 	= substr($parametros, 20, 100);
		$region_hash 	= substr($parametros, 120, 6);
		$rut 		    = base64_decode(str_replace("-","",$rut_hash)); 		
		$email 			= base64_decode(str_replace("-","",$email_hash)); 		
		$id_region 		= base64_decode(str_replace("-","",$region_hash));		
		$valida_rut		= preg_replace('/[^k0-9]/i', '', $rut);
		$dv  			= substr($valida_rut, -1);		
		$numero 		= substr($valida_rut, 0, strlen($valida_rut)-1);
		$no_valido		= 0;
		$i = 2; $suma 	= 0;
		foreach(array_reverse(str_split($numero)) as $v)
		{
			if($i==8)
				$i = 2;

			$suma += $v * $i;
			++$i;
		}

		$dvr = 11 - ($suma % 11);
		if($dvr == 11) $dvr = 0;
		if($dvr == 10) $dvr = 'K';
		if(($dvr != strtoupper($dv))||!(strlen($dv)>0)){					
			$no_valido++;
		}		

		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			$no_valido = 0;
		} else{
			$no_valido++;			
		}
	
		if(!is_int((int)trim($datosSolicitud['id_region']))||!(strlen($id_region)>0)){
			$no_valido++;			
		}  		
		if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
			$link = "https"; 
		else
			$link = "http"; 
		
		// Here append the common URL characters. 
		$link .= "://"; 
		
		// Append the host(domain name, ip) to the URL. 
		$link .= $_SERVER['HTTP_HOST']; 
		
		// Append the requested resource location to the URL 
		$link .= $_SERVER['REQUEST_URI']; 
			
		// Print the link 		
		if($no_valido>0){			
			include('errorVerificacionRegistroDT.php');
		}else{	
			
	?>
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-md-12">            
			<?php 
			include('formularioRegistroDT.php'); ?>            
			</div>
		</div>
	</div>
	<script type="text/javascript">
      var listConstantes          = <?php echo json_encode(\Constantes::getAll()) ?>;		
      listConstantes['BASE_HOST'] = "<?php echo \Pan\Uri\Uri::getHost()?>";
      listConstantes['BASE_URI']  = "<?php echo \Pan\Uri\Uri::getBaseUri()?>";
   </script>	
   	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/xmodal.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/jquery/jquery.min.js"></script>	
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>	
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/select2/js/select2.full.min.js"></script>	
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>	
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/dist/js/adminlte.js"></script>	
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/moment/moment.min.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datepicker/bootstrap-datepicker.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
	<script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/timepicker_v1.3.5/timepicker.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables/jquery.dataTables.min.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/jszip/jszip.min.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/DataTables/plugins/moment/datetime-moment.js"></script>	
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/box-widget.js"></script>	
	<script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery.livequery.min.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/form_dinamico.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/validador.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/utils.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery-labelauty.js"></script>	
	<script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost();?>pub/js/plugins/jquery.typing-0.2.0.min.js"></script>	
	<script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost();?>pub/js/jscoord-1.1.1.js"></script>
	<script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/joii-4.1.1/joii.min.js"></script>
	<script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost();?>pub/js/mapa.js"></script>
	<script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost();?>pub/js/marcador.js"></script>	
	<script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=<?php echo GOOGLE_MAPS_API_KEY?>"></script>
	<script src="<?php echo \pan\uri\Uri::getHost() ?>pub/js/base.js?v=<?php microtime(); ?>"></script>

	
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
</body>
<?php } ?>