<link href="{$static}/template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$static}/template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>

<form id="form_animal" class="form-horizontal" enctype="multipart/form-data">
    <div class="panel panel-primary">
        <div class="panel-heading">Identificación de Mordedor</div>
        <div class="panel-body" id="div_body_animal">

            <div class="form-group">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="id_animal_especie" class="control-label col-sm-4 required">Especie</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="id_animal_especie" name="id_animal_especie" onchange="Animal.cargarRazaporEspecie(this.value,'id_animal_raza');Animal.muestraOtro()">
                                <option value="0">Seleccione una Especie</option>
                                {foreach $arrAnimalEspecie as $item}
                                    <option value="{$item->id_animal_especie}" {if $item->id_animal_especie == $arr.id_animal_especie}selected{/if} >{$item->gl_nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="div_raza_animal" {if $arr.id_animal_especie != 1 && $arr.id_animal_especie != 2}style="display: none"{/if}>
                            <label for="id_animal_raza" class="control-label col-sm-4" >Raza Animal</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" id="id_animal_raza" name="id_animal_raza">
                                    <option value="0">Seleccione una Raza</option>
                                    {if $bo_ver == 1}
                                        <option value="{$arr.id_animal_raza}" selected>{$arr.gl_nombre_raza}</option>
                                    {/if}
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="div_otra_especie" {if $arr.id_animal_especie != 3}style="display: none"{/if}>
                            <label for="gl_animal_especie" class="control-label col-sm-4">Especifique (Otro)</label>
                            <div class="col-sm-8">
                                <input type="text" name="gl_animal_especie" id="gl_animal_especie" value="{$arr.gl_animal_especie}"
                                       onblur="validarVacio(this, 'Por favor especifique especie animal')" placeholder="Especifique Especie Animal (Otro)" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="gl_nombre_animal" class="control-label col-sm-4">Nombre</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="gl_nombre_animal" placeholder="Nombre Mordedor" name="nombre_animal" value="{$arr.nombre_animal}">
                        </div>
                        <label for="gl_color_animal" class="control-label col-sm-4">Color</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="gl_color_animal" placeholder="Color Mordedor" name="gl_color_animal" value="{$arr.gl_color_animal}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="id_animal_tamano" class="control-label col-sm-4">Tamaño</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="id_animal_tamano" name="id_animal_tamano">
                                {foreach $arrAnimalTamano as $item}
                                    <option value="{$item->id_animal_tamano}" {if $item->id_animal_tamano == $arr.id_animal_tamano}selected{/if}>{$item->gl_nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>


                    
                    <div class="form-group">
                        <label for="obs_animal" class="control-label col-sm-4">Observaciones</label>
                        <div class="col-sm-8">
                         <textarea type="text" class="form-control" placeholder="Detallar características físicas del animal (ubicación y color de manchas, similitud con alguna raza, etc.) y el motivo de generó la mordedura."
                                      id="obs_animal" name="obs_animal" rows="4">{$arr.obs_animal}</textarea>
                        </div>
                    </div>
                </div>
                        
                <div class="col-sm-6">
                        
                    <div class="form-group">
                        <label class="control-label col-sm-6">¿Mordedor vive con Paciente?</label>
                        <div class="col-sm-6">
                            <label><input class="bo_vive_con_paciente" type="radio" name="bo_vive_con_paciente" onclick="Animal.viveConPaciente();"
                                          id="bo_vive_con_paciente_1" value="1" {if $arr.bo_vive_con_paciente == 1}checked{/if}>Si</label>
                            &nbsp;&nbsp;
                            <label><input class="bo_vive_con_paciente" type="radio" name="bo_vive_con_paciente" onclick="Animal.viveConPaciente();"
                                          id="bo_vive_con_paciente_0" value="0" {if isset($arr.bo_vive_con_paciente) && $arr.bo_vive_con_paciente == 0}checked{/if}>No</label>
                        </div>
                    </div>

                    <!--<div class="form-group">
                        <label class="control-label col-sm-6">¿Paciente es el Dueño?</label>
                        <div class="col-sm-6">
                            <label><input class="bo_paciente_dueno" type="radio" name="bo_paciente_dueno"
                                          id="bo_paciente_dueno_1" value="1" {if $arr.bo_paciente_dueno == 1}checked{/if}>Si</label>
                            &nbsp;&nbsp;
                            <label><input class="bo_paciente_dueno" type="radio" name="bo_paciente_dueno"
                                          id="bo_paciente_dueno_0" value="0" {if isset($arr.bo_paciente_dueno) && $arr.bo_paciente_dueno == 0}checked{/if}>No</label>
                        </div>
                    </div>-->

                    <div class="form-group">
                        <label class="control-label col-sm-6">¿Conoce el domicilio exacto del animal que lo mordió?</label>
                        <div class="col-sm-6">
                            <label><input class="bo_domicilio_conocido" type="radio" name="bo_domicilio_conocido" onclick="Animal.mostrarDireccion();"
                                          id="bo_domicilio_conocido_1" value="1" {if $arr.bo_domicilio_conocido == 1}checked{/if}>Si</label>
                            &nbsp;&nbsp;
                            <label><input class="bo_domicilio_conocido" type="radio" name="bo_domicilio_conocido" onclick="Animal.mostrarDireccion();"
                                          id="bo_domicilio_conocido_0" value="0" {if isset($arr.bo_domicilio_conocido) && $arr.bo_domicilio_conocido == 0}checked{/if}>No</label>
                        </div>
                    </div>
                        
                    <div class="form-group" id="div_direccion_mordedura" {if !isset($arr.bo_direccion_mordedura)}style="display:none;"{/if}>
                        <label class="control-label col-sm-6" for="bo_direccion_mordedura">¿Misma dirección que Mordedura?</label>
                        <div class="col-sm-6">
                            <input type="checkbox" id="bo_direccion_mordedura" name="bo_direccion_mordedura" {if $arr.bo_direccion_mordedura == 'on'}checked{/if} >
                        </div>
                    </div>
                        
                    <div class="form-group" id="div_ubicable" {if $arr.bo_domicilio_conocido == 1 || !isset($arr.bo_domicilio_conocido)}style="display:none;"{/if}>
                        <label class="control-label col-sm-6" for="bo_ubicable">¿Tiene alguna referencia del lugar donde se pudiese ubicar al animal? (plaza, parque, esquina u otro)?</label>
                        <div class="col-sm-6">
                            <label><input class="bo_ubicable" type="radio" name="bo_ubicable" onclick="Animal.mostrarDireccionUbicable();"
                                          id="bo_ubicable_1" value="1" {if $arr.bo_ubicable == 1}checked{/if}>Si</label>
                            &nbsp;&nbsp;
                            <label><input class="bo_ubicable" type="radio" name="bo_ubicable" onclick="Animal.mostrarDireccionUbicable();"
                                          id="bo_ubicable_0" value="0" {if isset($arr.bo_ubicable) && $arr.bo_ubicable == 0}checked{/if}>No</label>
                        </div>
                    </div>

                    {*<div class="form-group">
                        <label class="control-label col-sm-6" for="bo_direccion_mordedura">¿Misma dirección que Mordedura?</label>
                        <div class="col-sm-6">
                            <input type="checkbox" id="bo_direccion_mordedura" name="bo_direccion_mordedura" >
                        </div>
                    </div>*}
                </div>
            </div>
            
            <div class="top-spaced"></div>
            
            <div class="form-group" id="div_direccion_animal" {if $bo_ver != 1 or $arr.gl_direccion == ""}style="display: none"{/if}>
                <div class="col-md-6">
                    
                     <div class="form-group">
                        <div class="col-sm-4">       
                        </div>
                      <div class="col-sm-8">
                      <label><font color="red">*Los siguientes Datos son imprescindibles para realizar investigación epidemiológica por la Autoridad Sanitaria.</font> </label>  
                      </div>
                    </div>


                    <div class="form-group">
                        <label for="id_region_animal" class="control-label col-sm-4">Región</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="id_region_animal" name="id_region_animal"
                                    onchange="Region.cargarComunasPorRegion(this.value, 'id_comuna_animal')" onblur="validarVacio(this, 'Por favor Seleccione una Región')">
                                <option value="0">Seleccione Región</option>
                                {foreach $arrRegiones as $item}
                                    <option value="{$item->id_region}"  id="{$item->gl_latitud}" name="{$item->gl_longitud}"
                                            {if $item->id_region == $arr.id_region_animal}selected{else if $bo_ver != 1 && $item->id_region == $id_region_sesion}selected{/if}>{$item->gl_nombre_region}</option>
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
                        <label for="gl_direccion" class="control-label col-sm-4">Dirección de Mordedor</label>
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