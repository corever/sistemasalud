<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Farmacias</a></li>
				<li class="breadcrumb-item active">Establecimientos Farmac&eacute;uticos</li>
			</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
	<div class="container-fluid">

		<div class="col-lg-12">
			<div class="text-right">
				<button type="button" class="btn btn-sm btn-success" id="btn_crear_establecimiento"
				onclick="window.location.href	=	'<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Farmacias/establecimiento/crearEstablecimiento'"
					data-toggle="tooltip" title="Crear Establecimiento"><i class="fa fa-plus"></i>&nbsp;&nbsp;Crear Establecimiento Farmac&eacute;utico
				</button>
			</div>
		</div>

		<div class="row my-3">
			
			<?php include_once("app/Farmacia/Farmacias/views/establecimiento/index/filtros.php");?>

			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="box box-primary">
					<div class="box-header with-border">
						Listado de Establecimientos Farmac&eacute;uticos
					</div>
					<div class="box-body" id="contenedor_grilla_establecimiento">
					</div>
				</div>
			</div>
		</div>
	</div>
</section>