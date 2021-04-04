<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>
<section class="content">
    
    <div class="panel panel-primary">
        <input type="text" value="{$id_agenda}" id="id_agenda" name="id_agenda" class="hidden">
        <div class="panel-heading">
            Aplicar Vacuna
        </div>
        
        <div class="top-spaced"></div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-4 col-md-2">&nbsp;</div>
                <div class="col-lg-5 col-md-8">
                    <label for="id_region_derivar">Región</label>
                    <select id="id_region_derivar" name="id_region_derivar" class="form-control"
                            onchange="Region.cargarComunasPorRegion(this.value,'id_comuna_derivar');
                                        Region.cargarEstableSaludporRegion(this.value,'id_establecimiento_derivar',0,'Seleccione Establecimiento');">
                        <option value="0"> Seleccione Región </option>
                        {foreach $arrRegion as $itm}
                            <option value="{$itm->id_region}" >{$itm->gl_nombre_region}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-2">&nbsp;</div>
                <div class="col-lg-5 col-md-8">
                    <label for="id_comuna_derivar">Comuna</label>
                    <select id="id_comuna_derivar" name="id_comuna_derivar" class="form-control"
                            onchange="Region.cargarCentroSaludporComuna(this.value, 'id_establecimiento_derivar',0,'Seleccione Establecimiento');">
                        <option value="0"> Seleccione una Comuna </option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-2">&nbsp;</div>
                <div class="col-lg-5 col-md-8">
                    <label for="id_establecimiento_derivar">Establecimiento de Salud</label>
                    <select id="id_establecimiento_derivar" name="id_establecimiento_derivar" class="form-control">
                        <option value="0"> Seleccione Establecimiento </option>
                    </select>
                </div>
            </div>
            <div class="top-spaced"></div>
            <div class="row">
                <div class="col-lg-4 col-md-2">&nbsp;</div>
                <div class="col-lg-6 col-md-8">
                    <button type="button" onclick="Agenda.derivar(this);" class="btn btn-success">
						<i class="fa fa-save"></i>  Guardar
					</button>&nbsp;
					<button type="button" id="cancelar"  class="btn btn-default" 
                            onclick="xModal.close();">
						<i class="fa fa-remove"></i>  Cancelar
					</button>
                </div>
            </div>
        </div>

        <div class="top-spaced"></div>
        
    </div>
</section>