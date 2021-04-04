<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>
<form id="form" class="form-horizontal" action="{$base_url}/Mantenedor/editarUsuarioBD/" method="post" enctype="multipart/form-data"> 
	<section class="content">
		<div class="panel panel-primary">
			<div class="panel-body">
				<input type="text" id="gl_token" name="gl_token" value="{$itm->gl_token}" class="hidden"/>

				<div class="row">
                    <div class="col-sm-6 top-spaced">
                        <label for="gl_rut" class=" control-label">RUT (*)</label>
                        <div>
                            <input type="text" class="form-control" id="gl_rut" name="gl_rut" value="{$itm->gl_rut}" readonly/>
                        </div>
                    </div>
                    <div class="col-sm-3 top-spaced">
                        <label for="bo_estado" class="control-label">Cambio Usuario (*)</label>
                        <div>
                            <select id="bo_cambio_usuario" class="form-control" name="bo_cambio_usuario">
                                <option value="0" {if $itm->bo_cambio_usuario != 1} selected {/if} > No </option>
                                <option value="1" {if $itm->bo_cambio_usuario == 1} selected {/if} > Si </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3 top-spaced">
                        <label for="bo_estado" class="control-label">Estado (*)</label>
                        <div>
                            <select id="bo_estado" class="form-control" name="bo_estado">
                                <option value="0" {if $itm->bo_activo != 1} selected {/if} > Inactivo </option>
                                <option value="1" {if $itm->bo_activo == 1} selected {/if} > Activo </option>
                            </select>
                        </div>
                    </div>
				</div>
                <div class="row"> 
                    <div class="col-sm-6">
                        <label for="gl_nombres" class="control-label">Nombres (*)</label>
                        <div>
                            <input type="text" class="form-control" id="gl_nombres" name="gl_nombres" value="{$itm->gl_nombres}" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="gl_apellidos" class="control-label">Apellidos</label>
                        <div>
                            <input type="text" class="form-control" id="gl_apellidos" name="gl_apellidos" value="{$itm->gl_apellidos}" />
                        </div>
                    </div>
				</div>
				<div class="row"> 
                    <div class="col-sm-6">
                        <label for="gl_nombre" class="control-label">Email (*)</label>
                        <div>
                            <input type="text" class="form-control" id="gl_email" name="gl_email" value="{$itm->gl_email}" onblur="validaEmail(this, 'Correo Inválido!')" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="bo_informar_web" class="control-label">Informa en Web (*)</label>
                        <div>
                            <select id="bo_informar_web" class="form-control" name="bo_informar_web">
                                <option value="0" {if $itm->bo_informar_web != 1} selected {/if} > No </option>
                                <option value="1" {if $itm->bo_informar_web == 1} selected {/if} > Si </option>
                            </select>
                        </div>
                    </div>
                </div>
				<div class="row top-spaced" id="div_nuevo_secundario" style="display:none">
                    <div class="col-md-4 col-xs-12">
                        <label> Perfil  (*)</label>
                        <select name="id_perfil_secundario" id="id_perfil_secundario" class="form-control"
                                onchange="Mantenedor_usuario.cambioPerfil(this,'id_region_secundaria','id_oficina_secundario','id_establecimiento_secundario','id_comuna_secundaria','id_servicio_secundario');" >
                            <option value=""> -- Seleccione -- </option>
                            {foreach $perfiles as $perfil}
                                <option value="{$perfil->id_perfil}" nacional="{$perfil->bo_nacional}" regional="{$perfil->bo_regional}"
                                        oficina="{$perfil->bo_oficina}" comunal="{$perfil->bo_comunal}"> {$perfil->gl_nombre_perfil} </option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-md-4 col-xs-12" id="div_region_secundaria">
                        <label> Región </label>
                        <select name="id_region_secundaria" id="id_region_secundaria" class="form-control"
                                onchange="Region.cargarOficinaByRegion(this.value,'id_oficina_secundario');Region.cargarComunasPorRegion(this.value,'id_comuna_secundaria');
                                    Region.cargarEstableSaludporRegion(this.value,'id_establecimiento_secundario');Region.cargarServicioPorRegion(this.value, 'id_servicio_secundario');">
                            <option value="0"> -- Todas -- </option>
                            {foreach $arrRegiones as $item}
                                <option value="{$item->id_region}">{$item->gl_nombre_region}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-md-4 col-xs-12" id="div_oficina_perfil">
                        <label> Oficina </label>
                        <select name="id_oficina_secundario" id="id_oficina_secundario" class="form-control" 
                                                onchange="Region.cargarComunaByOficina(this.value, 'id_comuna_secundaria');">
                            <option value="0"> -- Todas -- </option>
                            {foreach $arrOficinas as $ofi}
                                <option value="{$ofi->id_oficina}">{$ofi->gl_nombre_oficina}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-md-4 col-xs-12" style="display: none" id="div_comuna_perfil">
                        <label> Comuna </label>
                        <select name="id_comuna_secundaria" id="id_comuna_secundaria" class="form-control"
                                onchange="Region.cargarCentroSaludporComuna(this.value, 'id_establecimiento_secundario');">
                            <option value="0"> -- Todas -- </option>
                        </select>
                    </div>
                    <div class="col-md-4 col-xs-12" style="display: none" id="div_establecimiento_perfil">
                        <label> Establecimiento Salud </label>
                        <select name="id_establecimiento_secundario" id="id_establecimiento_secundario" class="form-control" >
                            <option value="0"> -- Todas -- </option>
                            {foreach $arrEstableSalud as $item}
                                <option value="{$item->id_establecimiento}">{$item->gl_nombre_establecimiento}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="col-md-4 col-xs-12" style="display: none" id="div_servicio_perfil">
                        <label> Servicio Salud </label>
                        <select name="id_servicio_secundario" id="id_servicio_secundario" class="form-control" >
                            <option value="0"> -- Todas -- </option>
                        </select>
                    </div>
                    <div class="col-xs-12">&nbsp;</div>
                    <div class="col-xs-12" align="right">
                        <button id="btn_guarda_secundario" type="button" class="btn btn-sm btn-primary" onclick="Mantenedor_usuario.guardaPerfilUsuario(this);">
                            <i class="fa fa-plus"></i> Guardar</button> &nbsp;
                        <button id="btn_cancelar_secundario" type="button" class="btn btn-sm btn-danger" onclick="Mantenedor_usuario.cancelarSecundario();">
                            <i class="fa fa-times"></i> Cancelar</button>
                    </div>
                </div>
				<div class="row">
                    <div class="col-md-12 top-spaced" align="right">
                        <button class="btn btn-xs btn-success" type="button" onclick="Mantenedor_usuario.nuevoPerfil();" id="btn_nuevo_secundario" ><i class="fa fa-plus"></i>&nbsp; Agregar Perfil </button>
                    </div>
                    <div class="col-md-12 top-spaced" id="contenedor-grilla-perfiles">
                        {include file="mantenedor_usuario/grilla-perfiles-usuario.tpl"}
                    </div>
                </div>

				<div class="modal-footer top-spaced" id="btn-terminar">
					<button class="btn btn-success" type="button" onclick="Mantenedor_usuario.editarUsuario(this.form, this);"><i class="fa fa-save"></i>&nbsp; Guardar </button>
					&nbsp;&nbsp;
					<button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; Cerrar </button>
				</div>
			</div>
		</div>
	</section>
</form>