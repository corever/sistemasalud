<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla">
	<thead>
		<tr>
			<th width="5%">N°</th>
			<th width="5%">Icono</th>
			<th width="20%">Nombre Opción</th>
			<th width="10%">¿Tiene Opción Hijo?</th>
			<th width="20%">Nombre Padre</th>
			<th width="20%">URL</th>
			<th width="10%">Estado</th>
			<th width="5%">Opciones</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$arr_data item=itm}
		<tr>
			<td class="text-center">{$itm->id_opcion}</td>
			<td class="text-center"><i class="{$itm->gl_icono}{if substr($itm->gl_icono,-2)!='2x'} fa-2x{/if}" data-toggle="tooltip" data-title="{$itm->gl_icono}" ></i></td>
			<td class="text-center">{$itm->gl_nombre_opcion}</td>
			<td class="text-center">
				{if $itm->bo_tiene_hijo == 1}
					<div style="color:green;">Si</div>
				{else}
					<div style="color:red;">No</div>
				{/if}
			</td>
			<td class="text-center">{$itm->gl_nombre_padre}</td>
			<td class="text-center">{$itm->gl_url}</td>
			<td class="text-center">
				{if $itm->bo_activo == 1}
					<div style="color:green;"> Activo </div>
				{else}
					<div style="color:red;"> Inactivo </div>
				{/if}
			</td>
			<td class="text-center">
				<button type="button" class="btn btn-xs btn-success" data-toggle="tooltip" data-title="Editar" 
						onclick="xModal.open('{$smarty.const.BASE_URI}/Mantenedor/editarMenuOpcion/{$itm->id_opcion}','Editar Menú Opción','45');">
						<i class="fa fa-edit"></i></button>
			</td>
		</tr>
		{/foreach}
	</tbody>
</table>