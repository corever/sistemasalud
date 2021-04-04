<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>
<form id="formNuevoUsuario" class="form-horizontal">
	<section class="content">
		<div class="panel panel-primary">
			<div class="panel-body">

				<div class="row">
                    <div class="col-sm-6 top-spaced">
                        <label for="gl_rut" class=" control-label">RUT (*)</label>
                        <div>
                            <input type="text" class="form-control" id="gl_rut" name="gl_rut" value=""
							   onkeyup="formateaRut(this), this.value = this.value.toUpperCase()"
							   onkeypress ="return soloNumerosYK(event)" onblur="validarVacio(this,'')" placeholder="Ingrese Rut">
                        </div>
                    </div>
                    <div class="col-sm-3 top-spaced">
                        <label for="bo_estado" class="control-label">Cambio Usuario (*)</label>
                        <div>
                            <select id="bo_cambio_usuario" class="form-control" name="bo_cambio_usuario">
                                <option value="0"> No </option>
                                <option value="1"> Si </option>
                            </select>
                        </div>
                    </div>
				</div>
                <div class="row"> 
                    <div class="col-sm-6">
                        <label for="gl_nombres" class="control-label">Nombres (*)</label>
                        <div>
                            <input type="text" class="form-control" id="gl_nombres" name="gl_nombres" value="" />
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <label for="gl_apellidos" class="control-label">Apellidos</label>
                        <div>
                            <input type="text" class="form-control" id="gl_apellidos" name="gl_apellidos" value="" />
                        </div>
                    </div>
				</div>
				<div class="row"> 
                    <div class="col-sm-6">
                        <label for="gl_nombre" class="control-label">Email (*)</label>
                        <div>
                            <input type="text" class="form-control" id="gl_email" name="gl_email" value="" onblur="validaEmail(this, 'Correo Inválido!')" />
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="bo_informar_web" class="control-label">Informa en Web (*)</label>
                        <div>
                            <select id="bo_informar_web" class="form-control" name="bo_informar_web">
                                <option value="0"> No </option>
                                <option value="1"> Si </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row top-spaced">
                    <div class="col-sm-12">
                        <div class="panel panel-info">
                            <div class="panel-heading"> Perfil por Defecto (más utilizado) </div>
                            <div class="panel-body">
                                <div id="div_nuevo_defecto" class="top-spaced">
                                    <div class="col-md-4 col-xs-12">
                                        <label> Perfil  (*)</label>
                                        <select name="id_perfil_usuario" id="id_perfil_usuario" class="form-control"
                                                onchange="Mantenedor_usuario.cambioPerfil(this,'id_region_perfil','id_oficina_perfil','id_establecimiento_perfil','id_comuna_perfil','id_servicio_perfil');" >
                                            <option value=""> -- Seleccione -- </option>
                                            {foreach $perfiles as $perfil}
                                                <option value="{$perfil->id_perfil}" nacional="{$perfil->bo_nacional}" regional="{$perfil->bo_regional}"
                                                        oficina="{$perfil->bo_oficina}" comunal="{$perfil->bo_comunal}"> {$perfil->gl_nombre_perfil} </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-xs-12" id="div_region_defecto">
                                        <label> Región  (*)</label>
                                        <select name="id_region_perfil" id="id_region_perfil" class="form-control"
                                                onchange="Region.cargarOficinaByRegion(this.value,'id_oficina_perfil');Region.cargarComunasPorRegion(this.value,'id_comuna_perfil');
                                                    Region.cargarEstableSaludporRegion(this.value,'id_establecimiento_perfil');Region.cargarServicioPorRegion(this.value, 'id_servicio_perfil');">
                                            <option value="0"> -- Todas -- </option>
                                            {foreach $arrRegiones as $item}
                                                <option value="{$item->id_region}">{$item->gl_nombre_region}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-xs-12" id="div_oficina_perfil">
                                        <label> Oficina </label>
                                        <select name="id_oficina_perfil" id="id_oficina_perfil" class="form-control" 
                                                onchange="Region.cargarComunaByOficina(this.value, 'id_comuna_perfil');">
                                            <option value="0"> -- Todas -- </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-xs-12" style="display: none" id="div_comuna_perfil">
                                        <label> Comuna </label>
                                        <select name="id_comuna_perfil" id="id_comuna_perfil" class="form-control"
                                                onchange="Region.cargarCentroSaludporComuna(this.value, 'id_establecimiento_perfil');">
                                            <option value="0"> -- Todas -- </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-xs-12" style="display: none" id="div_establecimiento_perfil">
                                        <label> Establecimiento Salud </label>
                                        <select name="id_establecimiento_perfil" id="id_establecimiento_perfil" class="form-control" >
                                            <option value="0"> -- Todas -- </option>
                                            {foreach $arrEstableSalud as $item}
                                                <option value="{$item->id_establecimiento}">{$item->gl_nombre_establecimiento}</option>
                                            {/foreach}
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-xs-12" style="display: none" id="div_servicio_perfil">
                                        <label> Servicio de Salud </label>
                                        <select name="id_servicio_perfil" id="id_servicio_perfil" class="form-control" >
                                            <option value="0"> -- Todas -- </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="top-spaced">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>
                                        
				<div class="modal-footer top-spaced" id="btn-terminar">
					<button class="btn btn-success" type="button" onclick="Mantenedor_usuario.agregarUsuario(this.form, this);"><i class="fa fa-save"></i>&nbsp; Guardar </button>
					&nbsp;&nbsp;
					<button class="btn btn-danger"  type="button" onclick="xModal.close();" id="btn_cerrar" ><i class="fa fa-close"></i>&nbsp; Cerrar </button>
				</div>
			</div>
		</div>
	</section>
</form>