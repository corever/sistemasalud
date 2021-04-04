<section class="content-header">
    <h1><i class="fa fa-group"></i>&nbsp; Mantenedor Usuario </h1>
    <div class="col-md-12 text-right">
		<button type="button" class="btn btn-success pull-right" 
				onclick="xModal.open('{$smarty.const.BASE_URI}/Mantenedor/agregarUsuario','Agregar Usuario','60');">
				<i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar Usuario</button>
    </div>
    <br/><br/>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title" style="width: 100%">
                Seleccione Filtros
            </h3>
        </div>
		<div class="box-body">
			<form id="formBuscar" action="#" method="post" class="form-horizontal">
				<div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-4">
						<label for="id_region" class="control-label col-sm-4">Región</label>
						<div class="col-sm-8">
                            <select for="id_region" class="form-control" id="id_region" name="id_region"
                                    onchange="Region.cargarOficinaByRegion(this.value,'id_oficina');Region.cargarComunasPorRegion(this.value, 'id_comuna')">
								<option value="0">Todos</option>
                                {foreach $arrRegiones as $item}
									<option value="{$item->id_region}" {if $region == $item->id_region}selected{/if} >{$item->gl_nombre_region}</option>
								{/foreach}
							</select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
					<div class="col-sm-4">
						<label for="id_oficina" class="control-label col-sm-4">Oficina</label>
						<div class="col-sm-8">
							<select for="id_oficina" class="form-control" id="id_oficina" name="id_oficina"
                                    onchange="Region.cargarComunaByOficina(this.value, 'id_comuna');">
								<option value="0">Seleccione una Oficina</option>
							</select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
					<div class="col-sm-4">
						<label for="id_comuna" class="control-label col-sm-4">Comuna</label>
						<div class="col-sm-8">
							<select for="id_comuna" class="form-control" id="id_comuna" name="id_comuna">
								<option value="0">Seleccione una Comuna</option>
							</select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
                </div>
                <div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-4">
						<label for="id_perfil" class="control-label col-sm-4">Perfil</label>
						<div class="col-sm-8">
							<select for="id_perfil" class="form-control" id="id_perfil" name="id_perfil">
								<option value="0">Seleccione un Perfil</option>
                                {foreach $arrPerfiles as $item}
									<option value="{$item->id_perfil}" >{$item->gl_nombre_perfil}</option>
								{/foreach}
							</select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
					<div class="col-sm-4">
						<label for="bo_activo" class="control-label col-sm-4">Estado</label>
						<div class="col-sm-8">
							<select for="bo_activo" class="form-control" id="bo_activo" name="bo_activo">
								<option value="">Todos</option>
								<option value="1">Activo</option>
								<option value="0">Inactivo</option>
							</select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
                    <div class="col-sm-3">
                        <button type="button" id="buscar" class="btn btn-sm btn-info" style="float:left;" onclick="Mantenedor_usuario.buscar();">
                            <i class="fa fa-search"></i>  Buscar
                        </button>
                    </div>
				</div>			
			</form>
		</div>
	</div>

	<div class="top-spaced"></div>
    
    <div class="box box-primary">
        <div class="box-body">
			<div class="table-responsive col-lg-12" data-row="10">
				<div id="contenedor-tabla-usuario">
					{include file="mantenedor_usuario/grilla.tpl"}
				</div>
		  	</div>
		</div>
	</div>
</section>