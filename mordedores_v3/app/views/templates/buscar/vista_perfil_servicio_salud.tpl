<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>

<section class="content-header">
    <h1><i class="fa fa-book"></i>&nbsp; Buscar </h1>
</section>

<section class="content">
	<div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title" style="width: 100%">
                Seleccione Filtros
            </h3>
        </div>
		<div class="box-body">

			<form id="form" action="#" method="post" class="form-horizontal">
                
				<input type="text" name="bool_region" id="bool_region" value="{$bool_region}" class="hidden"/>
				<input type="text" name="reg" id="reg" value="{$reg}" class="hidden"/>
				<input type="text" name="id_perfil" id="id_perfil" value="{$id_perfil}" class="hidden"/>
                
				<div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-4">
						<label for="region" class="control-label col-sm-4">Región</label>
						<div class="col-sm-8">
							<select for="region" class="form-control" id="region" name="region"
                                    onchange="Region.cargarServicioPorRegion(this.value, 'id_servicio');Region.cargarEstableSaludporRegion(this.value, 'establecimiento_salud');
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
						<label for="id_servicio" class="control-label col-sm-4">Servicio de Salud</label>
						<div class="col-sm-8">
							<select name="id_servicio" id="id_servicio" class="form-control"
                                    onchange="if(this.value>0)Region.cargarEstableSaludporServicio(this.value, 'establecimiento_salud');else $('#region').trigger('change');" >
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
						<label for="comuna" class="control-label col-sm-4">Comuna</label>
						<div class="col-sm-8">
							<select for="comuna" class="form-control" id="comuna" name="comuna"
                                    {*onchange="if(this.value>0)Region.cargarCentroSaludporComuna(this.value, 'establecimiento_salud'); else $('#id_oficina').trigger('change');"*}>
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
						<label for="establecimiento_salud" class="control-label col-sm-4">Establecimiento de Salud</label>
						<div class="col-sm-8">
							<select class="form-control select2" id="establecimiento_salud" name="establecimiento_salud">
							<option value="0">Todos</option>
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
					<div class="col-sm-4">
						<label for="bo_crea_establecimiento" class="control-label col-sm-4">Ingresó Establecimiento</label>
						<div class="col-sm-8">
							<select name="bo_crea_establecimiento" id="bo_crea_establecimiento" class="form-control">
                                <option value="">Todos</option>
                                <option value="1" >SI</option>
                                <option value="0" >NO</option>
                            </select>
						</div>
					</div>
				</div>
                
				<div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-4">
						<label for="folio_expediente" class="control-label col-sm-4">Folio Notificación</label>
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
						<label for="id_resultado" class="control-label col-sm-4">Resultado</label>
						<div class="col-sm-8">
							<select name="id_resultado" id="id_resultado" class="form-control">
                                <option value="">Todos</option>
                                <option value="1" >Sospechoso</option>
                                <option value="2" >No Sospechoso</option>
                                <option value="3" >Visita Perdida</option>
                                <option value="4" >Se Niega a Visita</option>
                            </select>
						</div>
					</div>
				</div>
                
				<div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-4">
						<label for="fecha_desde" class="control-label col-sm-4">Fecha Mordedura Desde</label>
						<div class="col-sm-8">
							<div class="input-group">
	                            <input for="fecha_desde" type='text' class="form-control" id='fecha_desde' name='fecha_desde' value="{'-90 days'|date_format:'01/%m/%Y'}">
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
                                
                <div class="form-group" style="display:none;">
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
                    
					<div class="col-sm-4" style="display:none;">
						<label for="bo_ubicable" class="control-label col-sm-4">Ubicable</label>
						<div class="col-sm-8">
							<select name="bo_ubicable" id="bo_ubicable" class="form-control">
                                <option value="">Todos</option>
                                <option value="1" >SI</option>
                                <option value="0" >NO</option>
                            </select>
						</div>
					</div>
				</div>
                
                <div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
                    <div class="col-sm-12">
                        <label class="control-label col-sm-4">&nbsp;</label>
                        <div class="col-sm-8" align="right">
                            <button type="button" id="buscar" class="btn btn-sm btn-info">
                                <i class="fa fa-search"></i>  Buscar
                            </button>
                        </div>
                    </div>
                </div>

			</form>
		</div>
	</div>

	<div class="top-spaced"></div>

	<div class="box box-primary">
		<div class="box-header">
			Resultado de la Búsqueda
		</div>
		<div class="box-body">
			{if isset($errorWS)}
				<div class="alert alert-danger">Hubo un problema al obtener los Soportes.<br> Favor intentar nuevamente o contactarse con Administrador.</div>
			{else}
				<div id="contenedor-grilla-pacientes">
                    <div class="table-responsive col-lg-12" data-row="10">
                        {if $grilla}
                            {$grilla}
                        {else}
                            <table id="grilla-buscar" class="table table-hover table-striped table-bordered dataTable no-footer">
                                <thead>
                                    <tr role="row">
                                        <th class="text-center" width="5%">Folio</th>
                                        <th class="text-center" width="5%">Fecha Registro</th>
                                        <th class="text-center" width="15%">Establecimiento Salud</th>
                                        <th class="text-center" width="10%">Comuna</th>{*DEL ESTABLECIMIENTO QUE NOTIFICA*}
                                        <th class="text-center" width="10%">Dirección<br>Mordedor</th>
                                        <th class="text-center" width="5%">Fecha de Mordedura</th>
                                        <th class="text-center" width="5%">Días desde Mordedura</th>
                                        <th class="text-center" width="10%">Estado</th>
                                        <th class="text-center" width="10%">Resultado</th>
                                        <th class="text-center" width="10%">Resultado <br>Laboratorio</th>
                                        <th class="text-center" width="10%">Especie Mordedor</th>
                                        <th class="text-center" width="10%">¿Paciente Observa animal?</th>
                                        <th class="text-center" width="10%">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        {/if}
                    </div>
				</div>
			{/if}
		</div>
	</div>
</section>
