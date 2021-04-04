<div class="box box-primary">
	<div class="box-header">
		<h3 class="box-title" style="width: 100%">
			Fiscalización a regularizar:
		</h3>
	</div>
	<div class="box-body">
		<table class="table table-hover table-responsive table-striped table-bordered dataTable no-footer export" data-titulo="actividades" data-row="5" data-exportar="0,1,2,3,4" id="tabla-actividades">
			<thead>
				<tr role="row">
					<th width="5%">ID Expediente </th>
					<th width="15%">Folio</th>
                    <th width="5%">N° mordedores</th>
					<th width="10%">Estado en la Web</th>
					<th width="20%">Fiscalizador</th>
					<th width="5%"></th>
				</tr>
			</thead>
			<tbody>
                {foreach $arrFiscalizacion as $key => $item}
                <tr>
					<td class="text-center">{$item.id_expediente}</td>
					<td class="text-center">{$item.gl_folio}</td>
					<td class="text-center">{$item.cantidad_mordedores}</td>
					<td class="text-center"><span class="{$item.class_estado_web}">{$item.nombre_estado_web}</span></td>
					<td class="text-center">{$item.fiscalizador_nombre} {$item.fiscalizador_rut}</td>
					<td class="text-center">
                        {*if $estado_web == 6 || $estado_web == 14 *}
                            <button id="btnRegularizar" type="button" class="btn btn-sm btn-primary" onclick="Regularizar.llenarFormulario('{$respaldo}', {$key}, {$item.gl_folio})">
                                <i class="fa fa-play"> Regularizar</i>
                            </button>
                        {*/if*}
					</td>
				</tr>
                {/foreach}
            </tbody>
		</table>
	</div>
</div>