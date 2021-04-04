<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>MINSAL :: <?php echo \pan\kore\App::getName(); ?></title>
      <!-- Font Awesome Icons -->
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/fontawesome-free/css/all.min.css">
      <!-- IonIcons -->
      <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
      <!-- overlayScrollbars -->
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
      <!-- Tempusdominus Bbootstrap 4 -->
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
      <!-- Select 2 Bootstrap 4 theme -->
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/select2/css/select2.min.css" />
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/select2-bootstrap4-theme/select2-bootstrap4.css" />
      <!-- Bootstrap4 Duallistbox -->
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
      <!-- Theme style -->
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/dist/css/adminlte.min.css">
      <!-- Componente Box -->
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/dist/css/box-component.css">
      <!-- Google Font: Source Sans Pro -->
      <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
      <link rel="icon" type="image/png" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/img/logo_minsal_32.png" />
      <!-- Date Picker -->
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datepicker/datepicker3.css" />
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/daterangepicker/daterangepicker.css" />
      <!-- DataTables -->
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.css">
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
      <!-- Project -->
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/css/plugins/labelauty/jquery-labelauty.css" />
	  <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datetimepicker/bootstrap-datetimepicker.css" />
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/timepicker_v1.3.5/timepicker.css">
      <link rel="stylesheet" href="<?php echo \pan\uri\Uri::getHost(); ?>pub/css/style.css" />
      
		
   </head>
   <body class="hold-transition sidebar-mini layout-fixed text-sm">
      
      <!-- Actualizar JSON para traducir palabras -->
      <?php $jsonTraductor = \Traduce::actualizaJson($_SESSION[\Constantes::SESSION_BASE]['idIdiomaPreferencia']); ?>
      
      <div class="wrapper">
         <!-- Navbar navbar-white navbar-light-->
         <nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
            <!-- Left navbar links -->
            <ul class="navbar-nav nav-compact">
               <li class="nav-item">
                  <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
               </li>
               <li class="nav-item d-none d-sm-inline-block">
                  <!--a href="<?php echo \pan\Uri\Uri::getBaseUri() . "Farmacia/Home/Dashboard/"?>" class="nav-link">Inicio</a-->
                  <a href="javascript:void(0)" class="nav-link" onclick="Base.entrarModulo(this);" data-url="Farmacia/Home/Dashboard/" data-id_modulo="0"><?php echo \Traduce::texto("Inicio"); ?></a>
               </li>
               <?php
                  if(in_array("1",$_SESSION[\Constantes::SESSION_BASE]['arrRoles'])){
                    //echo \pan\utils\TemplateMenu::getSideBar(1);
                  }
                  ?>
               <!--<li class="nav-item d-none d-sm-inline-block">
                  <a href="<?php echo \pan\Uri\Uri::getBaseUri() . "MesaAyuda/Home/MisTickets/"?>" class="nav-link"><?php echo \Traduce::texto("MesaAyuda"); ?></a>
               </li>-->
               <li class="nav-item d-none d-sm-inline-block">
                  <a href="<?php echo \pan\Uri\Uri::getBaseUri() . "Farmacia/Usuario/Login/logoutUsuario" ?>" class="nav-link"><?php echo \Traduce::texto("CerrarSesion"); ?></a>
               </li>
            </ul>
            <!-- SEARCH FORM -->
            <form class="form-inline ml-3">
               <div class="input-group input-group-sm">
                  <input class="form-control form-control-navbar" type="search" placeholder="<?php echo \Traduce::texto("Buscar"); ?>" aria-label="Search">
                  <div class="input-group-append">
                     <button class="btn btn-navbar" type="submit">
                     <i class="fas fa-search"></i>
                     </button>
                  </div>
               </div>
            </form>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
               <li class="nav-item dropdown" id="idBarIdioma">
                  <?php //echo \pan\utils\TemplateMenu::getBarIdioma(); ?>
               </li>
               <!-- Notifications Dropdown Menu -->
               <li class="nav-item dropdown">
                  <a class="nav-link" data-toggle="dropdown" href="#">
                  <i class="far fa-bell"></i>
                  <span class="badge badge-warning navbar-badge">2</span>
                  </a>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                     <span class="dropdown-item dropdown-header">2 Notificaciones</span>
                     <div class="dropdown-divider"></div>
                     <a href="javascript:void(0)" class="dropdown-item text-center">
                     To do, en desarrollo
                     </a>
                     <div class="dropdown-divider"></div>
                     <a href="<?php echo \pan\Uri\Uri::getBaseUri() . "Notificaciones/Home/MisNotificaciones/"?>" class="dropdown-item dropdown-footer">Ver todas las notificaciones</a>
                  </div>
               </li>
               <li class="nav-item">
                  <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                    <i class="far fa-file-pdf"></i>
                  </a>
               </li>
               <?php if(isset($esVisor) && $esVisor == true): ?>
                    <a id="btn-visor-sidebar" class="nav-link" role="button"><i class="fa fa-cogs"></i></a>
               <?php endif; ?>
               <ul class="nav navbar-nav">
                  <!-- User Account Menu -->
                  <?php //echo \pan\utils\TemplateMenu::getBoxUsr(); ?>
               </ul>
            </ul>
         </nav>
         <!-- /.navbar -->
         <!-- Main Sidebar Container sidebar-dark-primary-->
         <aside class="main-sidebar sidebar-dark-primary">
            <!-- Brand Logo navbar-primary-->
            <a href="javascript:void(0)" class="brand-link navbar-primary text-white">
            <img src="http://1.bp.blogspot.com/-bzjfCLD7MF4/TuPxxXFqO8I/AAAAAAAAAAs/tR2rq-n9SOI/s320/OPS.jpg" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light "><?php echo \pan\kore\App::getName(); ?></span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
               <!-- Sidebar user panel (optional) -->
               <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                  <?php //echo \pan\utils\TemplateMenu::getBoxUsr(); ?>
               </div>
               <!-- Sidebar Menu -->
               <?php //if($_SESSION[\Constantes::SESSION_BASE]['idModuloSelecionado'] > 0): ?>
               <nav class="mt-2">
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                     <?php echo \pan\utils\TemplateMenu::getSideBar(); ?>
                     <!-- OTROS LINKS (AUXILIARES)-->
                     <li class="nav-header">OTROS LINKS</li>
                     <?php if ($_SESSION[\Constantes::SESSION_BASE]['bo_cambio_usuario'] == 1){ ?>
                        <li class="nav-item has-treeview">
                           <a href="#"; onclick="xModal.open('<?php echo \pan\Uri\Uri::getBaseUri() . 'Farmacia/Usuario/Login/vistaCambioUsuario'; ?>','Cambio de Usuario','50')" class="nav-link">
                              <i class="nav-icon fas fa-user-plus"></i>
                              <p>Cambiar Usuario</p>
                           </a>
                        </li>
                     <?php } ?>
                     <?php if (!empty($_SESSION[\Constantes::SESSION_BASE]['gl_token_original'])){ ?>
                        <li class="nav-item has-treeview">
                           <a href="<?php echo \pan\Uri\Uri::getBaseUri() . "Farmacia/Usuario/Login/volverUsuario"; ?>" class="nav-link">
                              <i class="nav-icon fas fa-user-plus"></i>
                              <p>Volver Usuario</p>
                           </a>
                        </li>
                     <?php } ?>
                     <?php /*if (intval($_SESSION[\Constantes::SESSION_BASE]['nr_roles']) > 1){ ?>
                        <li class="nav-item has-treeview">
                           <a href="<?php echo \pan\Uri\Uri::getBaseUri() . "Farmacia/Usuario/Login/cambioRol"; ?>" class="nav-link">
                              <i class="nav-icon fas fa-user-plus"></i>
                              <p>Cambiar Rol</p>
                           </a>
                        </li>
                     <?php }*/ ?>
                     <li class="nav-item has-treeview">
                        <a href="<?php echo \pan\Uri\Uri::getBaseUri() . "MesaAyuda/Home/MisTickets/"; ?>" class="nav-link">
                           <i class="nav-icon fa fa-envelope"></i>
                           <p>Mesa de Ayuda</p>
                        </a>
                     </li>
                     <li class="nav-item has-treeview">
                        <a href="<?php echo \pan\Uri\Uri::getBaseUri() . "Farmacia/Usuario/Login/logoutUsuario"; ?>" class="nav-link">
                           <i class="nav-icon fas fa-sign-out-alt"></i>
                           <p>Cerrar Sesión</p>
                        </a>
                     </li>
                     <!-- FIN OTROS LINKS (AUXILIARES)-->
                  </ul>
               </nav>
               <?php //endif; ?>
               <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
         </aside>
         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper bg-white">
            <?php echo $contenido; ?>
         </div>
         <!-- /.content-wrapper -->
         <!-- Control Sidebar  control-sidebar-dark-->
         <aside id="control-sidebar" class="control-sidebar control-sidebar control-sidebar-light">
            <!-- Control sidebar content goes here -->
            <div class="p-2 control-sidebar-content">
               <div class="card card-primary" style="box-shadow: none;margin-bottom: 0;">
               <div class="card-header pl-1">
                  <h3 class="card-title"><?php echo \Traduce::texto("ManualesUsuario"); ?></h3>
                  <div class="card-tools">
                     <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                  </div>
               </div>
                  <?php
                     $arrManuales = array(
                        'Ingresos y Autenticación',
                        'Cambios de Contraseña',
                        'Recuperar de Contraseña',
                        'Solicitar Acceso a Modulos'
                     );
                  ?>
                  <div class="card-body p-2 pl-1">
                     <?php foreach($arrManuales as $valManual) : ?>
                        <div class="mb-2">
                           <a href="javascript:void(0)" class="p-0 text-muted" style="font-size:18.5px">
                           <i class="fas fa-file-download"></i>
                              <?php echo $valManual?>
                           </a>
                        </div>
                     <?php endforeach; ?>
               </div>
               </div>
            </div>
         </aside>

         <!-- /.control-sidebar -->
         <!-- Main Footer -->
         <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
               <?php echo \Pan\Kore\App::getName(); ?>
            </div>
            <strong>&copy; <?php echo date('Y'); ?>  <a href="http://www.minsal.cl/" target="_blank">Ministerio de Salud</a></strong>
         </footer>
      </div>
      <!-- ./wrapper -->
      <!-- REQUIRED SCRIPTS -->
      <!-- jQuery -->
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/jquery/jquery.min.js"></script>

      <!-- Bootstrap -->
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <!-- Select2 -->
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/select2/js/select2.full.min.js"></script>
      <!-- plugins-->
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
      <!-- AdminLTE -->
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/dist/js/adminlte.js"></script>
      <!-- datepicker -->
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/moment/moment-with-locales.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/moment/moment.min.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datepicker/bootstrap-datepicker.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/template/plugins/datepicker/locales/bootstrap-datepicker.es.js"></script>
      
      <!-- daterangepicker -->
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/daterangepicker/daterangepicker.js"></script>

	  <!-- timepicker -->
    	<script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/timepicker_v1.3.5/timepicker.js"></script>

      <!-- DataTables -->
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables/jquery.dataTables.min.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/jszip/jszip.min.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/DataTables/plugins/moment/datetime-moment.js"></script>


      <!-- Box widget -->
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/box-widget.js"></script>
      <!-- 
         Integra las constantes a nivel de js 
         (testing de funcionamiento)
         -->
         
      <script type="text/javascript">
         var listConstantes          = <?php echo json_encode(\Constantes::getAll()); ?>;
         listConstantes['BASE_HOST'] = "<?php echo \Pan\Uri\Uri::getHost();?>";
         listConstantes['BASE_URI']  = "<?php echo \Pan\Uri\Uri::getBaseUri();?>";
         
         var jsonTraductor           = <?php echo $jsonTraductor; ?>;
         var jsonTraductorEsp        = <?php echo \Traduce::getJsonEspanol(); ?>;
      </script>
      <!-- Project -->
      <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery.livequery.min.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/base.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/form_dinamico.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/validador.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/utils.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/xmodal.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/jquery-labelauty.js"></script>
      
      <!-- Configuración MAPA -->
      <!-- jquery.typing-0.2.0.min.js-->
      <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost()?>pub/js/plugins/jquery.typing-0.2.0.min.js"></script>
      <!-- Easily convert between latitude/longitude, Universal Transverse Mercator (UTM) and Ordnance Survey (OSGB) references with JavaScript using the JScoord package -->
      <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost()?>pub/js/jscoord-1.1.1.js"></script>
      <script src="<?php echo \pan\uri\Uri::getHost(); ?>pub/js/plugins/joii-4.1.1/joii.min.js"></script>
      <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost()?>pub/js/mapa.js"></script>
      <script type="text/javascript" src="<?php echo \pan\uri\Uri::getHost()?>pub/js/marcador.js"></script>
      <!-- Google Maps API KEY -->
      <script src="https://maps.googleapis.com/maps/api/js?libraries=places,drawing&key=<?php echo GOOGLE_MAPS_API_KEY;?>"></script>
      
      <!-- OPTIONAL SCRIPTS -->
      <!--<script src="<?php // echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/plugins/chart.js/Chart.min.js"></script>-->
      <!--<script src="<?php // echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/dist/js/demo.js"></script>-->
      <!--<script src="<?php // echo \pan\uri\Uri::getHost(); ?>pub/adminlte3/dist/js/pages/dashboard3.js"></script>-->
   </body>
</html>