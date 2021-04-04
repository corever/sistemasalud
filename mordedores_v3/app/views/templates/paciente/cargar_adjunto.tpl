<link rel="stylesheet" type="text/css" href="{$static}js/plugins/bootstrap-3.3.2-dist/css/bootstrap.min.css" />

<div class="row" style="width: 100%; min-height: calc(100vh); margin-left:auto;margin-right:auto; max-width: 100%;">
	<div class="col-xs-10">	
		<form class="form-horizontal" name="form-adjunto" id="form-adjunto" action="{$base_url}/Paciente/guardarAdjunto/{$smarty.session.adj.tipo_adjunto}" method="post" enctype="multipart/form-data"> 
			<input type="text" name="tipo_adjunto" id="tipo_adjunto" value="{$smarty.session.adj.tipo_adjunto}" class="hidden"/>
			<div class="form-group top-spaced">
				<label for="" class="control-label col-xs-2">Adjunto</label>
				<div class="col-xs-10">
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

			<div class="text-center top-spaced">
				<button class="btn btn-sm btn-danger" type="button" onclick="parent.xModal.close();">Cerrar ventana</button>
				<button class="btn btn-sm btn-success" type="button" onclick="parent.guardarAdjunto(this.form,this);">Guardar adjunto</button>
			</div>
		</form>
	</div>
</div>
