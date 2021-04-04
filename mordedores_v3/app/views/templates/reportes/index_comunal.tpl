<div class="box box-primary">
    <div class="box-header">
        <h3 class="box-title" style="width: 100%">
            Seleccione Filtros
        </h3>
    </div>
    <div class="box-body">
        <form id="form-buscar-matriz" class="form-horizontal">
            <input type="text" name="bool_region" id="bool_region" value="{$bool_region}" class="hidden"/>
            <input type="text" name="reg" id="reg" value="{$reg}" class="hidden"/>
            <div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
                <div class="col-sm-4">
                    <label for="id_region" class="col-sm-4 control-label optional">Región</label>
                    <div class="col-sm-8">
                        <select name="id_region" id="id_region" class="form-control"
                                onchange="Region.cargarServicioPorRegion(this.value, 'id_servicio');Region.cargarEstableSaludporRegion(this.value, 'id_establecimiento');">
                            {if count((array)$arrRegiones) == 0 || count((array)$arrRegiones) > 1}
                                <option value=""> Todas </option>
                            {/if}
                            {foreach $arrRegiones as $item}
                                <option value="{$item->id_region}" {if $item->id_region == $id_region}selected{/if} >{$item->gl_nombre_region}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
		            <div class="col-sm-4">
						<label for="id_servicio" class="control-label col-sm-4">Servicio de Salud</label>
						<div class="col-sm-8">
							<select name="id_servicio" id="id_servicio" class="form-control"
                                    onchange="if(this.value>0) Region.cargarEstableSaludporServicio(this.value, 'id_establecimiento'); else $('#id_comuna').trigger('change');" >
                                {if count((array)$arrServicio) == 0 || count((array)$arrServicio) > 1 || $id_perfil == 5}
                                    <option value="" > Seleccione Servicio </option>
                                {/if}
                                {foreach $arrServicio as $item}
                                    <option value="{$item->id_servicio}" >{$item->gl_nombre_servicio}</option>
                                {/foreach}
                            </select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
                <div class="col-sm-4">
                    <label for="id_comuna" class="col-sm-4 control-label optional">Comuna</label>
                    <div class="col-sm-8">
                        <select name="id_comuna" id="id_comuna" class="form-control"
                                onchange="Region.cargarCentroSaludporComuna(this.value, 'id_establecimiento');">
                            {if count((array)$arrComuna) == 0 || count((array)$arrComuna) > 1}
                                <option value="0">Seleccione una Comuna</option>
                            {/if}
                            {foreach $arrComuna as $item}
                                <option value="{$item->id_comuna}" >{$item->gl_nombre_comuna}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
                <div class="col-sm-4">
                    <label for="id_establecimiento" class="col-sm-4 control-label optional">Establecimiento</label>
                    <div class="col-sm-8">
                        <select name="id_establecimiento" id="id_establecimiento" class="form-control select2" >
                            <option value=""> Todas </option>
                            {foreach $arrEstableSalud as $item}
								<option value="{$item->id_establecimiento}" >{$item->gl_nombre_establecimiento}</option>
							{/foreach}
                        </select>
                    </div>
                </div>
                {if $origen != 'Informes'}
                    <div class="col-sm-4">
                        <label for="id_resultado_visita" class="col-sm-4 control-label optional">Resultado Visita</label>
                        <div class="col-sm-8">
                            <select name="id_resultado_visita" id="id_resultado_visita" class="form-control">
                                <option value=""> Todos </option>
                                {foreach $arrResulVisita as $item}
                                    <option value="{$item->id_tipo_visita_resultado}">{$item->gl_nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                {else}
                    <div class="col-sm-4">
                        <label for="fc_inicio" class="col-sm-4 control-label optional">Fecha Inicio</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input for="fc_inicio" type='text' class="form-control" id='fc_inicio' name='fc_inicio'
                                       value="{$smarty.now|date_format:"01/%m/%Y"}">
                                <span class="input-group-addon" onClick="$('#fc_inicio').focus();"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="fc_termino" class="col-sm-4 control-label optional">Fecha Término</label>
                        <div class='col-sm-8'>
                            <div class="input-group">
                                <input for="fc_termino" type='text' class="form-control" id='fc_termino' name='fc_termino'
                                       value="{$smarty.now|date_format:"%d/%m/%Y"}">
                                <span class="input-group-addon" onClick="$('#fc_termino').focus();"><i class="fa fa-calendar"></i></span>

                            </div>
                        </div>
                    </div>
                {/if}
                <div class="col-sm-4" style="display:none;">
                    <label for="bo_domicilio_conocido" class="col-sm-4 control-label optional">Domicilio</label>
                    <div class="col-sm-8">
                        <select name="bo_domicilio_conocido" id="bo_domicilio_conocido" class="form-control">
                            <option value=""> Todos </option>
                            <option value="1"> Con Domicilio </option>
                            <option value="0"> Sin Domicilio </option>
                        </select>
                    </div>
                </div>
            </div>
            
            {if $origen != 'Informes'}
                <div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
                    <div class="col-sm-4">
                        <label for="fc_inicio" class="col-sm-4 control-label optional">Fecha Inicio</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input for="fc_inicio" type='text' class="form-control" id='fc_inicio' name='fc_inicio'
                                       value="{$smarty.now|date_format:"01/%m/%Y"}">
                                <span class="input-group-addon" onClick="$('#fc_inicio').focus();"><i class="fa fa-calendar"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <label for="fc_termino" class="col-sm-4 control-label optional">Fecha Término</label>
                        <div class='col-sm-8'>
                            <div class="input-group">
                                <input for="fc_termino" type='text' class="form-control" id='fc_termino' name='fc_termino'
                                       value="{$smarty.now|date_format:"%d/%m/%Y"}">
                                <span class="input-group-addon" onClick="$('#fc_termino').focus();"><i class="fa fa-calendar"></i></span>

                            </div>
                        </div>
                    </div>
                </div>
            {/if}
            
            <div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
                <div class="col-sm-12">
                    <label class="control-label col-sm-4">&nbsp;</label>
                    <div class="col-sm-8" align="right">
                        <button type="button" id="btnBuscar" class="btn btn-info btn-sm" onclick="Reportes.buscar()" ><i class="fa fa-search"></i> Buscar </button>
                        <button type="button" id="btnQuitarFiltros" class="btn bg-purple btn-sm" onclick="Reportes.quitarFiltros()" ><i class="fa fa-mail-reply"></i> Limpiar Filtros </button>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
</div>