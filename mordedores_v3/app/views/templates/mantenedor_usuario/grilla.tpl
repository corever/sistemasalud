<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla">
	<thead>
		<tr>
			<th width="5%">RUT</th>
			<th width="20%">Nombre</th>
			<th width="10%">Email</th>
			<th width="5%">Estado</th>
			<th width="5%">Opciones</th>
		</tr>
	</thead>
	<tbody>
		{*foreach from=$arr_data item=itm}
		<tr>
			<td class="text-center">{$itm->gl_rut}</td>
			<td class="text-center">{$itm->gl_nombres} {$itm->gl_apellidos}</td>
			<td class="text-center">{$itm->gl_email}</td>
			<td class="text-center">
				{if $itm->bo_activo == 1}
					<div style="color:green;"> Activo </div>
				{else}
					<div style="color:red;"> Inactivo </div>
				{/if}
			</td>
			<td class="text-center">
				<button type="button"
						onclick="xModal.open('{$smarty.const.BASE_URI}/Mantenedor/editarUsuario/{$itm->gl_token}','Editar Usuario',60);"
						data-toggle="tooltip" data-title="Editar Usuario"
						class="btn btn-xs btn-success">
						<i class="fa fa-edit"></i>
				</button>
				{<button type="button"  //VER SI PUEDE ELIMINAR
						onclick=""
						data-toggle="tooltip" data-title="Eliminar Usuario"
						class="btn btn-xs btn-danger">
						<i class="fa fa-eraser"></i>
				</button>}
			</td>
		</tr>
		{/foreach*}
	</tbody>
</table>