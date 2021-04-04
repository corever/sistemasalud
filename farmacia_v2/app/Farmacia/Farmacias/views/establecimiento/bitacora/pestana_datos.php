<div class="box box-primary">
	<div class="box-body">
		<ul class="nav nav-tabs" role="tablist">
			<li id="li_detalle_eventos" class="nav-item">
				<a class="nav-link active" data-toggle="pill" role="tab" id="tab_detalle_eventos" href="#detalle_eventos">
					Historial
				</a>
			</li>
			<li id="li_detalle_documentos" class="nav-item" hidden>
				<a class="nav-link" data-toggle="pill" role="tab" aria-selected="true" id="tab_detalle_documentos" href="#detalle_documentos">
					Documentos
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade active show" id="detalle_eventos" role="tabpanel">
				<?php include_once("app/Farmacia/Farmacias/views/establecimiento/bitacora/pestanas/insertar_comentario.php");?>
				<div class="col-sm-12" id="div_grilla_eventos">
					<?php include_once("app/Farmacia/Farmacias/views/establecimiento/bitacora/pestanas/grilla_eventos.php");?>
				</div>
			</div>

			<div class="tab-pane fade" id="detalle_documentos" role="tabpanel" hidden>
				<div class="col-sm-12 box" id="contenedor-grilla-documentos">
					<?php include_once("app/Farmacia/Farmacias/views/establecimiento/bitacora/pestanas/grilla_documentos.php");?>
				</div>
			</div>
		</div>
	</div>
</div>