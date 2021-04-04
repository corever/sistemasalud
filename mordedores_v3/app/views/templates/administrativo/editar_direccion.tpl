<link href="{$static}/template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$static}/template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>

<form id="form_animal" class="form-horizontal" enctype="multipart/form-data">
    <div class="panel panel-primary">
        <div class="panel-heading">Identificación de Mordedor</div>
        <div class="panel-body" id="div_body_animal">

            <div class="top-spaced"></div>
            
            <div class="form-group" id="div_dueno_animal">
                <div class="col-md-6">
                    <input type="text" value="{$token_exp_mor}" id="token_exp_mor" name="token_exp_mor" class="hidden">
                    <input type="text" value="{$bandeja}" id="gl_bandeja" name="gl_bandeja" class="hidden">
                    <div class="form-group">
                        <label for="id_region_animal" class="control-label col-sm-4">Región</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="id_region_animal" name="id_region_animal"
                                    onchange="Region.cargarComunasPorRegion(this.value, 'id_comuna_animal')" onblur="validarVacio(this, 'Por favor Seleccione una Región')">
                                <option value="0">Seleccione Región</option>
                                {foreach $arrRegiones as $item}
                                    <option value="{$item->id_region}"  id="{$item->gl_latitud}" name="{$item->gl_longitud}"
                                            {if $item->id_region == $id_region}selected{/if}>{$item->gl_nombre_region}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="id_comuna_animal" class="control-label col-sm-4">Comuna</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="id_comuna_animal" name="id_comuna_animal">
                                <option value="0">Seleccione una Comuna</option>
                                {if $bo_ver == 1}
                                    <option value="{$arr.id_comuna_animal}" selected>{$arr.gl_comuna_animal}</option>
                                {/if}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gl_direccion" class="control-label col-sm-4">Dirección</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="gl_direccion" name="gl_direccion" value="{$arr.gl_direccion}" placeholder="Ingrese una dirección de dueño">
                        </div>
                    </div>
                        
                    <div class="form-group">
                        <label for="gl_referencias_animal" class="control-label col-sm-4">Datos de Referencia</label>
                        <div class="col-sm-8">
                            <textarea type="text" class="form-control" placeholder="Indique datos de Referencia"
                                      id="gl_referencias_animal" name="gl_referencias_animal" rows="4">{$arr.gl_referencias_animal}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="col-sm-12">
                        <div id="mapAnimal" data-editable="{if $bo_ver==1}0{else}1{/if}" style="width:100%;height:200px;"></div>
                        <div class="form-group">
                            <label for="gl_latitud_animal" class="control-label col-sm-3">Latitud</label>
                            <div class="col-sm-3">
                                <input type="text" name="gl_latitud_animal" id="gl_latitud_animal" value="{$arr.gl_latitud_animal}" placeholder="Latitud" class="form-control"/>
                            </div>
                            <label for="gl_longitud_animal" class="control-label col-sm-1">Longitud</label>
                            <div class="col-sm-3">
                                <input type="text" name="gl_longitud_animal"  id="gl_longitud_animal" value="{$arr.gl_longitud_animal}" placeholder="Longitud" class="form-control"/>
                            </div>
                        </div>
					</div>
				</div>
            </div>
                    
            <div class="top-spaced"></div>
            
            <div class="form-group text-right" {if $bo_ver==1}style="display: none"{/if}>
                <button type="button" id="guardar" onclick="Animal.guardaAnimalMordedor(this);" class="btn btn-success">
                    <i class="fa fa-save"></i>  Guardar
                </button>&nbsp;
                <button type="button" id="cancelar"  class="btn btn-default" 
                        onclick="xModal.close()">
                    <i class="fa fa-remove"></i>  Cancelar
                </button>
                <br/><br/>
            </div>
        </div>
    </div>
</form>