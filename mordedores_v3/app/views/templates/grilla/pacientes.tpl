<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>

{if $sin_header != 1}
<section class="content-header">
    <div class="row">
        <div class="col-md-6 content-header">
            <h1><i class="fa fa-book"></i>&nbsp; {$origen} </h1>
        </div>
        <div class="col-md-6 text-right">
            {if $bo_agrega == 1}
            <button type="button" id="ingresar" onclick="location.href = '{$base_url}/Paciente/nuevo'"
                    class="btn btn-success">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;Nuevo Registro
            </button>
            {/if}
        </div>
    </div>
</section>
{/if}

{include file='alarma/grilla_alarmas.tpl'}    


<section class="content">
    {if $bo_filtros}
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title" style="width: 100%">
                Seleccione Filtros
            </h3>
        </div>
		<div class="box-body">		
			<form id="form_filtros" class="form-horizontal" enctype="multipart/form-data">
				<input type="text" name="bool_region" id="bool_region" value="{$bool_region}" class="hidden"/>
				<input type="text" name="reg" id="reg" value="{$reg}" class="hidden"/>
				<input type="text" name="bo_microchip" id="bo_microchip" value="{$bo_microchip}" class="hidden"/>
				<input type="text" name="bandeja" id="bandeja" value="{$bandeja}" class="hidden"/>
				<input type="text" name="id_region_usuario" id="id_region_usuario" value="{$id_region}" class="hidden"/>

				<div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-4">
						<label for="region" class="control-label col-sm-4">Región del establecimiento de salud</label>
						<div class="col-sm-8">
							<select for="region" class="form-control" id="region" name="region"
                                    onchange="Region.cargarOficinaByRegion(this.value, 'id_oficina');Region.cargarEstableSaludporRegion(this.value, 'establecimiento_salud');
                                            Region.cargarComunasPorRegion(this.value, 'comuna');Region.cargarFiscalizadorPorRegion(this.value, 'id_fiscalizador');">
								{if count((array)$arrRegiones) == 0 || count((array)$arrRegiones) > 1}
                                    <option value="0"> Seleccione una Región </option>
                                {/if}
                                {foreach $arrRegiones as $item}
                                    <option value="{$item->id_region}" {if !$bo_nacional && $item->id_region == $id_region}selected{/if} >{$item->gl_nombre_region}</option>
                                {/foreach}
							</select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
		            <div class="col-sm-4">
						<label for="id_oficina" class="control-label col-sm-4">Oficina del establecimiento de salud</label>
						<div class="col-sm-8">
							<select name="id_oficina" id="id_oficina" class="form-control"
                                    onchange="Region.cargarComunaByOficina(this.value, 'comuna');
                                        if(this.value>0)Region.cargarEstableSaludporOficina(this.value, 'establecimiento_salud');
                                        if(this.value>0)Region.cargarFiscalizadorPorOficina(this.value, 'id_fiscalizador'); else $('#region').trigger('change');">
                                {if count((array)$arrOficina) == 0 || count((array)$arrOficina) > 1}
                                    <option value=""> Todas </option>
                                {/if}
                                {foreach $arrOficina as $item}
                                    <option value="{$item->id_oficina}" >{$item->gl_nombre_oficina}</option>
                                {/foreach}
                            </select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
					<div class="col-sm-4">
						<label for="comuna" class="control-label col-sm-4">Comuna establecimiento de salud</label>
						<div class="col-sm-8">
							<select for="comuna" class="form-control" id="comuna" name="comuna"
                                    onchange="if(this.value>0)Region.cargarCentroSaludporComuna(this.value, 'establecimiento_salud'); else $('#id_oficina').trigger('change');">
								{if count((array)$arrComuna) == 0 || count((array)$arrComuna) > 1}
                                    <option value="0">Seleccione una Comuna</option>
                                {/if}
                                {foreach $arrComuna as $item}
									<option value="{$item->id_comuna}" >{$item->gl_nombre_comuna}</option>
								{/foreach}
							</select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
				</div>

				<div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-4">
						<label for="id_fiscalizador" class="control-label col-sm-4">Fiscalizador</label>
						<div class="col-sm-8">
							<select class="form-control select2" id="id_fiscalizador" name="id_fiscalizador">
                                {if count((array)$arrFiscalizador) == 0 || count((array)$arrFiscalizador) > 1 && ($id_perfil != 6 || $id_perfil != 14)}
                                    <option value="0">Seleccione un Fiscalizador</option>
                                {/if}
                                {foreach $arrFiscalizador as $item}
                                    <option value="{$item->id_usuario}" >{$item->gl_nombres} {$item->gl_apellidos} ({$item->gl_rut})</option>
                                {/foreach}
							</select>
							<span class="help-block hidden"></span>
						</div>
					</div>
					<div class="col-sm-4">
						<label for="establecimiento_salud" class="control-label col-sm-4">Establecimiento de Salud</label>
						<div class="col-sm-8">
							<select class="form-control select2" id="establecimiento_salud" name="establecimiento_salud">
                                {if count((array)$arrEstableSalud) == 0 || count((array)$arrEstableSalud) > 1}
                                    <option value="0">Seleccione un Establecimiento Salud</option>
                                {/if}
                                {foreach $arrEstableSalud as $item}
                                    <option value="{$item->id_establecimiento}" >{$item->gl_nombre_establecimiento}</option>
                                {/foreach}
							</select>
							<span class="help-block hidden"></span>
						</div>
					</div>
					<div class="col-sm-4">
						<label for="documento" class="control-label col-sm-4">RUT / Pasaporte Paciente</label>
						<div class="col-sm-8">
							<input type="text" name="documento" id="documento" value="{$documento}" 
								   placeholder="RUT / Pasaporte (Extranjero)" class="form-control"/>
							<span class="help-block hidden"></span>
						</div>
					</div>
				</div>

				<div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-4">
						<label for="folio_expediente" class="control-label col-sm-4">Folio</label>
						<div class="col-sm-8">
							<input type="text" name="folio_expediente" id="folio_expediente" value="{$folio_expediente}" 
								   placeholder="Folio" class="form-control"/>
							<span class="help-block hidden"></span>
						</div>
					</div>
					<div class="col-sm-4">
						<label for="folio_mordedor" class="control-label col-sm-4">Folio Mordedor</label>
						<div class="col-sm-8">
							<input type="text" name="folio_mordedor" id="folio_mordedor" value="{$folio_mordedor}" 
								   placeholder="Folio Mordedor" class="form-control"/>
							<span class="help-block hidden"></span>
						</div>
					</div>
					<div class="col-sm-4">
						<label for="microchip_mordedor" class="control-label col-sm-4">Microchip Mordedor</label>
						<div class="col-sm-8">
							<input type="text" name="microchip_mordedor" id="microchip_mordedor" value="{$microchip_mordedor}"
								   placeholder="Código Microchip" class="form-control"/>
							<span class="help-block hidden"></span>
						</div>
					</div>
				</div>
                {if $microchip == 1 && false} {*YA NO SE MUESTRA FILTRO FECHA EN MICROCHIP - MICROCHIP MUESTRA SOLO ULTIMOS 60 DIAS (17/07/2019)*}
                <div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-4">
						<label for="fecha_desde" class="control-label col-sm-4">Fecha Mordedura Desde</label>
						<div class="col-sm-8">
							<div class="input-group">
	                            {* <input for="fecha_desde" type='text' class="form-control" id='fecha_desde' name='fecha_desde' value="{$smarty.now|date_format:"01/%m/%Y"}"> *}
	                            <input for='fecha_desde' type='text' class='form-control' id='fecha_desde' name='fecha_desde' value="{'-90 days'|date_format:'01/%m/%Y'}">
	                            <span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fecha_desde').focus();"></i></span>
	                        </div>
						</div>
					</div>
					<div class="col-sm-4">
						<label for="fecha_hasta" class="control-label col-sm-4">Fecha Mordedura Hasta</label>
						<div class="col-sm-8">
							<div class="input-group">
	                            <input for="fecha_hasta" type='text' class="form-control" id='fecha_hasta' name='fecha_hasta' value="{$smarty.now|date_format:"%d/%m/%Y"}">
	                            <span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fecha_hasta').focus();"></i></span>
	                            <span class="help-block hidden"></span>
	                        </div>
						</div>
					</div>
				</div>
                {/if}
                                   
				<div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-12">
                        <label class="control-label col-sm-4">&nbsp;</label>
                        <div class="col-sm-8" align="right">
                            <button type="button" id="btn_buscar" class="btn btn-sm btn-info">
                                <i class="fa fa-search"></i>  Buscar
                            </button>
                            <button type="button" id="btn_limpia_filtros" class="btn btn-sm bg-purple">
                                <i class="fa fa-mail-reply"></i>  Limpiar Filtros
                            </button>
                        </div>
					</div>
				</div>
			
			</form>
		</div>
	</div>
    {/if}

	<div class="top-spaced"></div>
    
    <div class="box box-primary">
        <div class="box-body" id="contenedor_grilla_registros">
            {if $bandeja == "establecimiento" || $bandeja == "admin" || $bandeja == "nacional"}
                {include file='grilla/grilla_pacientes_supervisor.tpl'}
            {else if $bandeja == "seremi" || $bandeja == "otro"}
				{include file='grilla/grilla_pacientes_seremi.tpl'}
			{else if $bandeja == "administrativo"}
				{include file='grilla/grilla_pacientes_administrativo.tpl'}
            {else}
                {include file='grilla/grilla_pacientes.tpl'}
            {/if}
            
        </div>
    </div>
</section>