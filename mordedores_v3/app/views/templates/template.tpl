<!DOCTYPE html>
<html lang="es">
<head>
    {*{include file="layout/css.tpl"}*}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Minsal :: Animales Mordedores</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{$static}template/bootstrap/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{$static}css/plugins/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <link rel="stylesheet" href="{$static}template/dist/css/AdminLTE.min.css" />
	
    <link rel="stylesheet" href="{$static}js/plugins/qtip/jquery.qtip.min.css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
      -->
    <link rel="stylesheet" href="{$static}template/dist/css/skins/skin-blue.min.css" />
    <link rel="stylesheet" href="{$static}template/dist/css/skins/skin-red.min.css" />
    <link rel="stylesheet" href="{$static}css/style.css" type="text/css" />
    <link href="{$static}template/plugins/datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{$static}template/plugins/jquery.ui.timepicker.css">
    <link rel="stylesheet" type="text/css" href="{$static}css/plugins/jquery-ui.css">
	<link rel="icon" type="image/png" href="{$static}images/logo_minsal_32.png" />
</head>

{if $smarty.const.ENVIROMENT == "PROD"}
    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
{else}
    <body class="hold-transition skin-red sidebar-mini sidebar-collapse">
{/if}

<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">
	<div id="cargando" style="display:none"><i class="fa fa-cog fa-spin fa-2x fa-fw margin-bottom"></i> Cargando</div>	

        <!-- Logo -->
        <a href="javascript:void(0);" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img src="{$static}images/logo_minsal_32.png"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg" style="">
                <!-- <img src="{$static}/images/cosof.png" width="50" height="50"><b>T</b>ickets -->
                <img src="{$static}images/logo_minsal_32.png">&nbsp;<b>Mordedores</b>
            </span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
                {*<span class="">Menú</span>*}
            </a>
            
            {if $smarty.const.ENVIROMENT != 'PROD'}
            <span style="color:#fff;font-size:20px;height: 50px;line-height: 50px">
                Ambiente de Ejecución: <strong>{$smarty.const.ENVIROMENT}</strong>
            </span>
            {/if}

            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">

                <ul class="nav navbar-nav">
                    <!-- User Account Menu -->
                    {htmlBoxUsuario}
                </ul>
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
                {htmlMenu}
            </ul><!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        {$content}

        <!-- Content Header (Page header) -->
        {*<section class="content-header">
            <h1>
                Page Header
                <small>Optional description</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
                <li class="active">Here</li>
            </ol>
        </section>*}

        <!-- Main content -->
        {*<section class="content">


        </section>*}<!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Animales Mordedores
        </div>
        <!-- Default to the left -->
        <strong>&copy; 2018 <a href="http://www.minsal.cl/" target="_blank">Ministerio de Salud</a></strong>
    </footer>


</div><!-- ./wrapper -->

</body>
{include file="layout/js.tpl"}
</html>