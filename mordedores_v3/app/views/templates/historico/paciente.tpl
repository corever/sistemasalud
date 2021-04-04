<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>

<section class="content-header">
    <h1><i class="fa fa-book"></i>&nbsp; Historico </h1>
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
		
			<form id="form" action="#" method="post" class="form-horizontal">
				<input type="text" name="bool_region" id="bool_region" value="{$bool_region}" class="hidden"/>
				<input type="text" name="reg" id="reg" value="{$reg}" class="hidden"/>
				<div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-4">
						<label for="region" class="control-label col-sm-4">Región</label>
						<div class="col-sm-8">
							<select for="region" class="form-control" id="region" name="region" onchange="Region.cargarOficinaByRegion(this.value, 'id_oficina');Region.cargarComunasPorRegion(this.value, 'comuna')">
								<option value="0">Seleccione una Región</option>
								{foreach $arrRegiones as $item}
									<option value="{$item->id_region}" >{$item->gl_nombre_region}</option>
								{/foreach}
							</select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
		            <div class="col-sm-4">
						<label for="comuna" class="control-label col-sm-4">Oficina</label>
						<div class="col-sm-8">
							<select name="id_oficina" id="id_oficina" class="form-control"
		                                onchange="Region.cargarComunaByOficina(this.value, 'comuna');$('#id_region').trigger('change');">
		                            <option value=""> Todas </option>
		                        </select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
					<div class="col-sm-4">
						<label for="comuna" class="control-label col-sm-4">Comuna</label>
						<div class="col-sm-8">
							<select for="comuna" class="form-control" id="comuna" name="comuna">
								<option value="0">Seleccione una Comuna</option>
							</select>
							<span class="help-block hidden fa fa-warning"></span>
						</div>
					</div>
				</div>
				<div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-4">
						<label for="nombre_fiscalizador" class="control-label col-sm-4">Nombre Fiscalizador</label>
						<div class="col-sm-8">
							<input type="text" name="nombre_fiscalizador" id="nombre_fiscalizador" value="{$nombre_fiscalizador}"
								   placeholder="Nombre Fiscalizador" class="form-control"/>
							<span class="help-block hidden"></span>
						</div>
					</div>
					<div class="col-sm-4">
						<label for="establecimiento_salud" class="control-label col-sm-4">Establecimiento de Salud</label>
						<div class="col-sm-8">
							<select class="form-control select2" id="establecimiento_salud" name="establecimiento_salud">
							<option value="0">Seleccione un Establecimiento Salud</option>
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
				<div class="form-group" style="margin-top: 10px !important; margin-bottom: 10px !important;">
					<div class="col-sm-4">
						<label for="fecha_desde" class="control-label col-sm-4">Fecha Mordedura Desde</label>
						<div class="col-sm-8">
							<div class="input-group">
	                            <input for="fecha_desde" type='text' class="form-control" id='fecha_desde' name='fecha_desde' value="{$fecha_desde}">
	                            <span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fecha_desde').focus();"></i></span>
	                        </div>
						</div>
					</div>
					<div class="col-sm-4">
						<label for="fecha_hasta" class="control-label col-sm-4">Fecha Mordedura Hasta</label>
						<div class="col-sm-8">
							<div class="input-group">
	                            <input for="fecha_hasta" type='text' class="form-control" id='fecha_hasta' name='fecha_hasta' value="{$fecha_hasta|date_format:"%d/%m/%Y"}">
	                            <span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fecha_hasta').focus();"></i></span>
	                            <span class="help-block hidden"></span>
	                        </div>
						</div>
					</div>
					<div class="col-sm-4 top-spaced">
						<button type="button" id="buscar" class="btn btn-info" style="float:right;">
							<i class="fa fa-search"></i>  Buscar
						</button>
					</div>
				</div>
			
			</form>
		</div>
	</div>

	<div class="top-spaced"></div>

	<div class="box box-primary">
		<div class="box-header">
			Listado Histórico
		</div>
		<div class="box-body">
			{if isset($errorWS)}
				<div class="alert alert-danger">Hubo un problema al obtener los Soportes.<br> Favor intentar nuevamente o contactarse con Administrador.</div>
			{else}
				<div id="contenedor-grilla-pacientes">
					{if $mostrar==1}
						{include file='grilla/pacientes.tpl'}
					{/if}	
				</div>
			{/if}
		</div>
	</div>
</section>