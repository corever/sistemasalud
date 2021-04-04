
	<div class="panel-body small">
		{if isset($errorWS)}
			{if $errorWS === true}
				<div class="alert alert-danger">Hubo un problema, favor intentar nuevamente.</div>
			{else}
				<div class="alert alert-danger">{$errorWS}</div>
			{/if}
		{else}
			<div class="form-group form-group-sm">
				<label class="col-xs-2 control-label">Trámite</label>
				<div class="col-xs-4">
					<input class="form-control" disabled="" value="{utf8_encode($soporte.gl_usuario_creador)}">
				</div>
				<label class="col-xs-2 control-label">Enviado por</label>
				<div class="col-xs-4">
					<input class="form-control" disabled="" value="{$soporte.fc_creacion}">
				</div>
			</div>

			<div class="form-group form-group-sm top-spaced">
				<label class="col-xs-2 control-label">Email</label>
				<div class="col-xs-4">
					<input class="form-control" disabled="" value="{utf8_encode($soporte.email_usuario)}">
				</div>
				<label class="col-xs-2 control-label">Teléfono</label>
				<div class="col-xs-4">
					<input class="form-control" disabled="" value="{utf8_encode($soporte.telefono_usuario)}">
				</div>
			</div>

			<div class="form-group form-group-sm top-spaced">
				<label class="col-xs-2 control-label">Asunto</label>
				<div class="col-xs-10">
					<input class="form-control" disabled="" value="{utf8_encode($soporte.asunto_soporte)}">
				</div>
			</div>

			<div class="form-group form-group-sm top-spaced">
				<label class="col-xs-2 control-label">Consulta</label>
				<div class="col-xs-10">
					<div class="form-control" disabled" style="height:auto;overflow:hidden; background: #eee">
						{utf8_encode($soporte.cuerpo_soporte)}
					</div>
				</div>
			</div>

			{if count($adjuntos_usu) > 0}
				<div class="form-group form-group-sm top-spaced">
					<label class="col-xs-2 control-label">Adjuntos</label>
					<div class="col-xs-10">
						<div class="modal-adjuntos form-control" style="font-size:12px;height:auto;overflow:hidden;background:#eee">
						{foreach from=$adjuntos_usu item=adjunto}
							<a href="javascript:void(0);" onclick="window.open('{$adjunto.gl_ruta_archivo}')" ><i class="fa fa-file-o"></i> {utf8_encode($adjunto.gl_nombre_archivo)}</a><br/>
						{/foreach}
						</div>
					</div>
				</div>
			{/if}

			{if count($historial) > 0}
				<h4 class="modal-title top-spaced"><b>Historial</b></h4>
				<div class="modal-historial" style="font-size:12px">
					{foreach from=$historial item=mensaje}
						{if $mensaje.id_estado != 7}
							<p class="well well-sm  top-spaced" style="margin-bottom:3px;line-height:12px"><b>{utf8_encode($mensaje.fc_creacion)}</b> {utf8_encode($mensaje.gl_mensaje)}
								{if $mensaje.gl_detalle!= '' and in_array($mensaje.id_estado, array(4,5,6))}<b> : {utf8_encode($mensaje.gl_detalle)}</b> {/if}
							</p>
							<div class="text-right" style="font-size:12px">
								<h4 class="label label-primary" style="font-size: 11px;border-radius: 0 0 0.25em 0.25em;">
									Por {mb_strtoupper(utf8_encode($mensaje.gl_nombre_usuario))}- {mb_strtoupper(utf8_encode($mensaje.gl_region_usuario))}
								</h4>
							</div>
						{/if}
					{/foreach}
				</div>
			{/if}

			{if in_array($soporte.id_estado_soporte, array(3,8)) }
				<h4 class="modal-title top-spaced"><b>RESPUESTA</b></h4>
				<div class="modal-respuesta" style="font-size:12px">
					<p class="well well-sm top-spaced" style="margin-bottom:3px;font-size:12px;height:auto;overflow:hidden;background:#eee;"> {utf8_encode($soporte.gl_respuesta)}</p>
					<!--
					<div class="text-right" style="font-size:12px">
						<h4 class="label label-primary" style="font-size: 11px;border-radius: 0 0 0.25em 0.25em;">
							<b>{utf8_encode($soporte.fc_respuesta)}</b> Por {utf8_encode($soporte.gl_usuario_respuesta)}- {utf8_encode($soporte.gl_region_respuesta)}
						</h4>
					</div>
					-->
				</div>
				
				{if count($adjuntos_fap) > 0}
				<div class="form-group" id="adjuntos_respuesta" style="display: table;">
					<label class="col-xs-4 control-label clabel top-spaced"><b>Adjuntos de la respuesta</b></label>
					<div class="col-xs-8">
						<div class="modal-adjuntos-respuesta form-control top-spaced" style="font-size:12px;height:auto;overflow:hidden;background:#eee">
							<span class="adjunto"></span>
							{foreach from=$adjuntos_fap item=adjunto}
								<a href="javascript:void(0);" onclick="window.open('{$adjunto.gl_ruta_archivo}')" ><i class="fa fa-file-o"></i> {utf8_encode($adjunto.gl_nombre_archivo)}</a><br/>
							{/foreach}
						</div>
					</div>
				</div>
				{/if}
			{/if}

			<div class="modal-footer">
				<div id="btn-terminar">
					<button type="button" class="btn btn-primary" onclick="window.open('{$smarty.const.BASE_URI}/index.php/Soporte/imprimir/{$soporte.id_soporte}/{$soporte.gl_codigo_soporte}');">Imprimir</button>
					<button type="button" class="btn btn-danger" onclick="xModal.close();">Cerrar Ventana</button>
				</div>
			</div>
		{/if}
    </div>