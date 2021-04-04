<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>MINSAL :: <?php echo \pan\kore\App::getName(); ?></title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.5 -->
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/bootstrap/css/bootstrap.min.css" />
		<!-- Font Awesome -->
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/css/plugins/font-awesome/css/font-awesome.min.css" />
		<!-- CDN -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
		<!-- Ionicons CDN -->
		<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/dist/css/AdminLTE.min.css" />

		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/qtip/jquery.qtip.min.css" />
		<!-- AdminLTE Skins. -->
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/dist/css/skins/skin-blue.min.css" />
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/dist/css/skins/skin-red.min.css" />
		<!-- iCheck -->
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/iCheck/all.css" />
		<!-- Morris chart -->
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/morris/morris.css" />
		<!-- jvectormap -->
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/jvectormap/jquery-jvectormap-1.2.2.css" />
		<!-- Date Picker -->
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datepicker/datepicker3.css" />
		<!-- Daterange picker -->
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/daterangepicker/daterangepicker-bs3.css" />
        <!-- select2 -->
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/select2/select2.min.css" />
        <!-- bootstrap wysihtml5 - text editor -->
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" />

		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/css/style.css"/>
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datetimepicker/bootstrap-datetimepicker.css" />
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/jquery.ui.timepicker.css">
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/css/plugins/jquery-ui.css">
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datatables/jquery.dataTables.min.css" />
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datatables/dataTables.bootstrap.css" />
		<link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/css/plugins/labelauty/jquery-labelauty.css" />
		<link rel="icon" type="image/png" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/img/logo_minsal_32.png" />
	</head>

<?php if (AMBIENTE == "PROD"): ?>
    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
<?php else: ?>
    <body class="hold-transition skin-red sidebar-mini">
<?php endif; ?>

<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">
	       <div id="cargando" style="display:none"><i class="fa fa-cog fa-spin fa-2x fa-fw margin-bottom"></i> Cargando</div>

        <!-- Logo -->
        <a href="javascript:void(0);" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="<?php echo \pan\uri\Uri::getHost(); ?>pub/img/logo_minsal_32.png"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg" style="">

                <img src="<?php echo \pan\uri\Uri::getHost(); ?>pub/img/logo_minsal_32.png">&nbsp;&nbsp; <b> <?php echo \pan\kore\App::getName(); ?></b>
            </span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
              <?php if (AMBIENTE != "PROD"): ?>
                  <span style="color:#fff;font-size:20px;height: 50px;line-height: 50px">
                    Ambiente de Ejecución: <strong><?php echo AMBIENTE; ?></strong>
                  </span>
              <?php endif; ?>


            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
              <?php
                   $perfil = \pan\utils\SessionPan::getSession('perfil');
					
                   if ($perfil != 22 || $perfil != 0 ): ?>
                      <ul class="nav navbar-nav">
                        <!-- User Account Menu -->
                            <?php echo \pan\utils\TemplateMenu::getBoxUsr(); ?>
                      </ul>

              <?php endif; ?>
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">
                <!-- li class="header" style="color:#fff; font-size:16px; text-align: center">Menu Principal</li -->
                <?php echo \pan\utils\TemplateMenu::getSideBar(); ?>
            </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <?php echo $contenido; ?>

    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            <?php echo \Pan\Kore\App::getName(); ?>
        </div>
        <!-- Default to the left -->
        <strong>&copy; <?php echo date('Y'); ?>  <a href="http://www.minsal.cl/" target="_blank">Ministerio de Salud</a></strong>
    </footer>

</div><!-- ./wrapper -->

</body>

<footer>
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/morris/morris.min.js"></script>
    <!-- Sparkline -->
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/knob/jquery.knob.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- select2 -->
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/select2/select2.full.min.js"></script>
    <!-- datepicker -->
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/bootstrap-wysihtml5/locales/bootstrap3-wysihtml5.es-ES.js"></script>
    <!-- Slimscroll -->
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/dist/js/app.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/iCheck/icheck.min.js"></script>


    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery.livequery.min.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery.typing-0.2.0.min.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/DataTables/plugins/JSZip/jszip.min.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/DataTables/plugins/buttons/buttons.html5.min.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/DataTables/plugins/pdfmake/pdfmake.min.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/DataTables/plugins/pdfmake/vfs_fonts.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/DataTables/plugins/FakeRowspan/fnFakeRowspan-V1.10.16.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/bootbox-4.4.0/bootbox.min.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery.mask.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery.colorbox.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/xmodal.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/joii-3.1.3/joii.min.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/qtip/jquery.qtip.min.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/base.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/validador.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/formulario.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datetimepicker/moment-with-locales.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/jquery.ui.timepicker.js"></script>
    <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/DataTables/extensions/FixedColumns/js/dataTables.fixedColumns.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=AIzaSyCjFzMO5H07sCBdzuQ90eVTAnViYhi1adg"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/utils.js"></script>
	<script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery-labelauty.js"></script>
</footer>

</html>
