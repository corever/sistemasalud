<section class="content-header">
    <h1><i class="fa fa-plus-circle"></i>&nbsp; Mantenedor Establecimiento </h1>
    <div class="col-md-12 text-right">
        <button type="button" class="btn btn-success pull-right" 
                onclick="xModal.open('{$smarty.const.BASE_URI}/Mantenedor/agregarEstablecimiento', 'Agregar Establecimiento', '45');">
            <i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar Establecimiento</button>
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
						<label for="region" class="control-label col-sm-4">Región</label>
						<div class="col-sm-8">
							<select for="region" class="form-control" id="region" name="region" onchange="Region.cargarComunasPorRegion(this.value, 'comuna')">
								<option value="0">Todos</option>
                                {foreach $arrRegiones as $item}
									<option value="{$item->id_region}" {if $region == $item->id_region}selected{/if} >{$item->gl_nombre_region}</option>
								{/foreach}
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
                    <div class="col-sm-2">
                        <button type="button" id="buscar" class="btn btn-sm btn-info" style="float:right;" onclick="Mantenedor_establecimiento.buscar();">
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
                <div id="contenedor-establecimiento">
                    {include file="mantenedor_establecimiento/grilla.tpl"}
                </div>
            </div>
        </div>
    </div>
</section>