<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla">
	<thead>
		<tr>
			<th width="30%">Nombre</th>
			<th width="40%">Descripción</th>
			<th width="20%">Estado</th>
			<th width="5%">Opciones</th>
		</tr>
	</thead>
	<tbody>
		{foreach from=$arr_data item=itm}
		<tr>
			<td class="text-center">{$itm->gl_nombre_perfil}</td>
			<td class="text-center">{$itm->gl_descripcion}</td>
			<td class="text-center">
				{if $itm->bo_estado == "1"}
					<div style="color:green;"> Activo </div>
				{else}
					<div style="color:red;"> Inactivo </div>
				{/if}
			</td>
			<td class="text-center">
				<button type="button" class="btn btn-xs btn-success" data-title="Editar" data-toggle="tooltip"
						onclick="xModal.open('{$smarty.const.BASE_URI}/Mantenedor/editarPerfil/{$itm->gl_token}','Editar Perfil','45');">
					<i class="fa fa-edit"></i></button>
				{*<button type="button"  //VER SI PUEDE ELIMINAR
						onclick=""
						data-toggle="tooltip" data-title="Eliminar Perfil"
						class="btn btn-xs btn-danger">
						<i class="fa fa-eraser"></i>
				</button>*}
			</td>
		</tr>
		{/foreach}
	</tbody>
</table>