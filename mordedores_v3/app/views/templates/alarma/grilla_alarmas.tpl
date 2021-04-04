<div class="{(count($arrAlarmas) > 0) ? '' : 'hidden'}">
	<section class="content" style="min-height: auto;">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title">Alarmas</h3>
			</div>
			<div class="box-body">
				<table class="table table-hover table-condensed table-bordered table-middle datatable">
					<thead>
						<tr role="row">
							<th align="center" width="10%">Folio</th>
							<th align="center" width="10%">Fecha Mordedura</th>
							<th align="center" width="10%">Paciente</th>
							<th align="center" width="10%">Tel&eacute;fono Contacto</th>
							<th align="center" width="10%">Correo Contacto</th>
							<th align="center" width="10%">Tipo</th>
							<th align="center" width="10%">Estado</th>
							<th align="center" width="10%">Fiscalizador</th>
							<th align="center" width="10%">Fecha Creación</th>
							<th align="center" width="10%">Opciones</th>
						</tr>
					</thead>

					<tbody>
					{foreach $arrAlarmas as $item}
						<tr class={if $item->id_alarma_estado == 1}
										'danger'
									{else if $item->id_alarma_estado == 2}
										'warning'
									{else if $item->id_alarma_estado == 4}
										'success'
									{else}
										''
									{/if}>
							<td class="text-center">{$item->gl_folio}</td>
							<td class="text-center">{$item->fc_mordedura}</td>
							<td class="text-center">
								{$item->paciente_nombre}
								{$item->paciente_apellido_paterno}
								{$item->paciente_apellido_materno}
							</td>
							<td class="text-center">
								{foreach $item->paciente_telefonos_contacto as $telefono}
									{$telefono}</br>
								{/foreach}
							</td>
							<td class="text-center">
								{foreach $item->paciente_correos_contacto as $telefono}
									{$telefono}</br>
								{/foreach}
							</td>
							<td class="text-center" nowrap>
                                {if $item->id_tipo_alarma == 1}
                                    <span class="label label-success">{$item->nombre_tipo_alarma}</span>
                                {else}
                                    <span class="label label-danger">{$item->nombre_tipo_alarma}</span>
                                {/if}
							</td>
							<td class="text-center" nowrap>
                                {if $item->id_alarma_estado == 2 || $item->id_alarma_estado == 4}
                                    <span class="label label-success">{$item->nombre_alarma_estado}</span>
                                {else}
                                    <span class="label label-danger">{$item->nombre_alarma_estado}</span>
                                {/if}
							</td>
							<td class="text-center">
									{$item->usuario_nombre}
									{$item->usuario_apellidos}
							</td>
							<td class="text-center">{$item->fecha_creacion}</td>
							<td align="center">
								<button type="button" onclick="xModal.open('{$smarty.const.BASE_URI}/Bitacora/ver/{$item->token_expediente}', 'Bitácora {$item->gl_folio}', 85)"
										data-toggle="tooltip" class="btn btn-xs btn-primary" data-title="Bitácora" data-hasqtip="0" aria-describedby="qtip-0">
									<i class="fa fa-info-circle"></i>
								</button>
								{*if $item->id_alarma_estado == 1}
								<button type="button" class="btn btn-xs btn-warning cambiarEstadoAlarma"
										onclick="verAlarma(this);"
										data-alarma="{$item->id_alarma}"
										data-estado="2"
										data-toggle="tooltip" data-title="Marcar Visto">
									<i class="fa fa-eye"></i>
								</button>
								{/if*}
								{if $item->id_alarma_estado == 1}
								<button type="button" class="btn btn-xs btn-success cambiarEstadoAlarma"
										onclick="xModal.open('{$smarty.const.BASE_URI}/Paciente/registroAccionAlarma/?token_expediente={$item->token_expediente}', 'Registro Alarma {$item->gl_folio}', 70);"
										data-alarma="{$item->id_alarma}"
										data-estado="4"
										data-toggle="tooltip" data-title="Informar">
									<i class="fa fa-phone"></i>
								</button>
								{/if}
								{if $item->id_alarma_estado == 4 &&  $item->bo_apagar == 1}
								<button type="button" class="btn btn-xs btn-danger cambiarEstadoAlarma" 
										onclick="xModal.open('{$smarty.const.BASE_URI}/Paciente/registroAccionAlarma/?token_expediente={$item->token_expediente}', 'Apagar Alarma {$item->gl_folio}', 70);"
										data-alarma="{$item->id_alarma}"
										data-estado="3"
										data-toggle="tooltip" data-title="Apagar Alarma">
									<i class="fa fa-power-off"></i>
								</button>
								{/if}
							</td>
						</tr>
					{/foreach}
					</tbody>
				</table>
				<br/>
			</div>
		</div>
	</section>
</div>