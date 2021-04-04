<link rel="stylesheet" type="text/css" href="{$static}js/plugins/bootstrap-3.3.2-dist/css/bootstrap.min.css" />

	<div class="col-xs-12">	
		<form class="form-horizontal" name="form-adjunto" id="form-adjunto" action="{$base_url}/Soporte/guardarAdjunto" method="post" enctype="multipart/form-data"> 
			<div class="form-group">
				<label for="" class="control-label col-xs-12">Adjunto</label>
				<div class="col-xs-12">
					<input type="file" name="adjunto" id="adjunto" class="form-control"/>
				</div>
			</div>

			{if isset($success)}
				{if $success == 1}
				<div class="alert alert-success top-spaced">{$mensaje}</div>
				{else}
				<div class="alert alert-danger top-spaced">{$mensaje}</div>
				{/if}
			{/if}

			<div class="text-center">
				<button class="btn btn-danger" type="button" onclick="parent.xModal.close();">Cerrar ventana</button>
				<!-- <button class="btn btn-success" type="button" onclick="parent.Soportes_midas.guardarAdjunto(this.form,this);">Guardar adjunto</button> -->
				<button class="btn btn-success" type="submit">Guardar adjunto</button>
			</div>
		</form>
	</div>
