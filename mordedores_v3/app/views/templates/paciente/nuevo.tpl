<link href="{$static}/template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$static}/template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>

<section class="content-header">
    <h1><i class="fa fa-plus"></i>&nbsp; Nuevo</h1>
    <ol class="breadcrumb">
        <li><a href="{$base_url}/Paciente/">
                <i class="fa fa-folder-open"></i>&nbsp;Pacientes</a></li>
        <li class="active"> &nbsp;Nuevo Paciente</li>
    </ol>
</section>

<form id="form" class="form-horizontal" enctype="multipart/form-data" autocomplete="false" >

    <section class="content">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Identificación de Establecimiento {$botonAyudaInfoMordedura}
            </div>
            <div class="panel-body">
                <input type="hidden" value="{if $id_region_sesion > 0}{$id_region_sesion}{else}0{/if}" id="region_sesion">
                <div class="form-group">
                    <label for="establecimientosalud" class="control-label col-sm-3 col-xs-5 required">Establecimiento de Salud</label>
                    <div class="col-sm-3 col-xs-5">
                        <select class="form-control select2" id="establecimientosalud" name="establecimientosalud">
                            <option value="0">Seleccione un Establecimiento de Salud</option>
                            {foreach $arrEstableSalud as $item}
                                <option value="{$item->id_establecimiento}" region_establecimiento="{$item->id_region}"
                                        {if $item->id_establecimiento == $id_establecimiento_sesion}selected{/if}>{$item->gl_nombre_establecimiento}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fechaingreso" class="control-label col-sm-3 col-xs-5 required">Fecha de Atención a Paciente</label>
                    <div class='col-sm-2 col-xs-5'>
                        <div class="input-group">
                            <input for="fechaingreso" type='text' class="form-control" id='fechaingreso' name='fechaingreso' value="{$smarty.now|date_format:"%d/%m/%Y"}"
                                   onchange="cambioFechaIngreso();">
                            <span class="help-block hidden fa fa-warning"></span>
                            <span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fechaingreso').focus();"></i></span>

                        </div>
                    </div>
                    <label for="horaingreso" class="control-label col-sm-2 col-xs-5">Hora de Atención a Paciente</label>
                    <div class="col-sm-2 col-xs-5">
                        <div class="input-group">
                            <input for="horaingreso" type="text" name="horaingreso" id="horaingreso" value="{$smarty.now|date_format:"%H:%M"}"
                                   placeholder="Hora de Ingreso" class="form-control">
                            <span class="help-block hidden"></span>
                            <span class="input-group-addon"><i class="fa fa-clock-o" onClick="$('#horaingreso').focus();"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fechanotificacion" class="control-label col-sm-3 col-xs-5" required>Fecha de Notificación a SEREMI</label>
                    <div class='col-sm-2 col-xs-5'>
                        <div class="input-group">
                            <input for="fechanotificacion" type='text' class="form-control" id='fechanotificacion' name='fechanotificacion'
                                   value="{$smarty.now|date_format:"%d/%m/%Y"}">
                            <span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fechanotificacion').focus();"></i></span>

                        </div>
                    </div>

                     <label for="fechasistema" class="control-label col-sm-2 col-xs-5">Fecha de registro en sistema</label>
                    <div class="col-sm-2 col-xs-5">
                        <div class="input-group">
                            <input for="fechasistema" type='text' class="form-control" id='fechasistema' name='fechasistema'
                                   value="{$smarty.now|date_format:"%d/%m/%Y - %H:%M"}" disabled>
                            <span class="input-group-addon"><i class="fa fa-calendar" ></i></span>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="top-spaced"></div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                Identificación de Paciente {$botonAyudaPaciente}
                <input type="text" value="0" id="token_paciente" name="token_paciente" class="hidden">
                <input type="text" value="0" id="gl_grupo_tipo" name="gl_grupo_tipo" class="hidden">
                <input type="text" value="0" id="cambio_direccion" name="cambio_direccion" class="hidden">
                <input type="text" name="tipo_adj" id="tipo_adj" value="{$smarty.session.adj.tipo_adjunto}" class="hidden"/>
            </div>
            <div class="panel-body">

                <div class="form-group">
                    <label for="chkextranjero" class="control-label col-sm-3 col-xs-5">¿Extranjero sin RUT emitido en Chile?</label>
                    <div class="col-sm-1 col-xs-2">
                        <input id="chkextranjero" type="checkbox" value='1'>
                    </div>
                </div>

                <div class="form-group" id="div_rut_no_informado">
                    <label for="chk_no_informado" class="control-label col-sm-3 col-xs-5">¿RUT NO informado?</label>
                    <div class="col-sm-1 col-xs-2">
                        <input id="chk_no_informado" type="checkbox" value='1'>
                    </div>
                </div>

                <div class="form-group">
                    <div id="nacional">
                        <label for="rut" class="control-label col-sm-3 col-xs-4 required">RUT Paciente</label>
                        <div class="col-sm-2 col-xs-5">
                            <input type="text" name="rut" id="rut" maxlength="12" onkeyup="formateaRut(this), this.value = this.value.toUpperCase()"
                                   onkeypress ="return soloNumerosYK(event)" placeholder="Rut paciente" class="form-control" onchange="Paciente.revisar();"
                                   onblur="Valida_Rut(this);">
                        </div>
                        <div id="div_hidden" hidden ></div>
                    </div>
                    <div style="display: none" id="extranjero">
                        <label for="nombres" class="control-label col-sm-3 col-xs-4">N°/Pasaporte Extranjero</label>
                        <div class="col-sm-2 col-xs-5">
                            <input type="text" name="inputextranjero" id="inputextranjero" maxlength="12" id="inputextranjero" value='' class="form-control"
                                   placeholder="Ingrese N°/Pasaporte Extranjero">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <button type="button" id="btnBitacora" style="display:none"
                                data-toggle="tooltip"
                                data-title="Revisar bitácora"
                                class="btn btn-xs btn-primary">
                            <i class="fa fa-info-circle"></i>
                        </button>
                    </div>

                    <label for="nombres" class="control-label col-sm-2 col-xs-4 required">Nombres</label>
                    <div class="col-sm-3 col-xs-7">
                        <input type="text" name="nombres" id="nombres" placeholder="Nombres" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="apellido_materno" class="control-label col-sm-3 col-xs-4 required">Apellido Paterno</label>
                    <div class="col-sm-3 col-xs-7">
                        <input type="text" name="apellido_paterno" id="apellido_paterno" placeholder="Apellido Paterno" class="form-control">
                    </div>
                    <label for="apellido_materno" class="control-label col-sm-2 col-xs-4">Apellido Materno</label>
                    <div class="col-sm-3 col-xs-7">
                        <input type="text" name="apellido_materno" id="apellido_materno" placeholder="Apellido Materno" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label for="fc_nacimiento" class="control-label col-sm-3 col-xs-4">Fecha Nacimiento</label>
                    <div class='col-sm-3 col-xs-7'>
                        <div class="input-group">
                            <input type='text' class="form-control" value="" id='fc_nacimiento' name='fc_nacimiento'
                                   onchange="calcularEdad(this.value, '#edad')" autocomplete="off">
                            <span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fc_nacimiento').focus();"></i></span>
                        </div>
                    </div>
                    <label for="edad" class="control-label col-sm-2 col-xs-4">Edad</label>
                    <div class="col-md-2 col-sm-3 col-xs-7">
                        <input type="text" name="edad" id="edad" maxlength="3" onKeyPress="return soloNumeros(event)" placeholder="Edad" class="form-control" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="id_pais_origen" class="control-label col-sm-3 col-xs-4">País de Origen</label>
                    <div class="col-sm-3 col-xs-7">
                        <select class="form-control select2" id="id_pais_origen" name="id_pais_origen">
                            <option value="0">Seleccione un País de Origen</option>
                            {foreach $arrPais as $item}
                                <option value="{$item->id_pais}" {if $item->id_pais == 152}selected{/if} id="{$item->gl_nombre_nacionalidad}">{$item->gl_nombre_pais}</option>
                            {/foreach}
                        </select>
                    </div>

                    <label for="id_nacionalidad" class="control-label col-sm-2 col-xs-4">Nacionalidad</label>
                    <div class="col-md-2 col-sm-3 col-xs-7">
                        <select class="form-control select2" id="id_nacionalidad" name="id_nacionalidad">
                            <option value="0">Seleccione Nacionalidad</option>
                            {foreach $arrNacionalidad as $item}
                                <option value="{$item->id_nacionalidad}" {if $item->id_pais == 152}selected{/if} id="{$item->id_pais}">{$item->gl_nombre_nacionalidad}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-3 col-xs-4">Email</label>
                    <div class="col-md-2 col-sm-3 col-xs-7">
                        <input type="text" name="email_paciente" id="email_paciente" onblur="validaEmail(this, 'Correo Inválido!')"
                               placeholder="Email" class="form-control">
                    </div>

                    <label class="control-label col-sm-3 col-xs-4 required">Teléfono</label>

                    <div class="col-md-2 col-sm-3 col-xs-7" id="div_numero_paciente" >
                        <input type="text" name="telefono_paciente" id="telefono_paciente" onblur="cambiarTelefono()"
                               onKeyPress="return soloNumeros(event)" placeholder="Teléfono" class="form-control" disabled>
                    <br>
                    <label><font color="red">*Dato imprescindible para realizar investigación epidemiológica por la Autoridad Sanitaria.</font> </label>
                    </div>
                 
                     <div class="col-sm-2 col-xs-2" >
                        <label><input type="checkbox" id="cambiarTelefono">&nbsp;Agregar el número de teléfono</label>
                    </div>
                </div>

                

                <div class="form-group">
                    <label for="id_tipo_sexo" class="control-label col-sm-3 col-xs-4">Sexo</label>
                    <div class="col-md-2 col-sm-3 col-xs-7">
                        <select for="id_tipo_sexo" class="form-control" id="id_tipo_sexo" name="id_tipo_sexo">
                            <option value="0">Seleccione Sexo</option>
                            {foreach $arrTipoSexo as $item}
                                <option value="{$item->id_tipo_sexo}" >{$item->gl_tipo_sexo}</option>
                            {/foreach}
                        </select>
                    </div>
                    <label for="prevision" class="control-label col-sm-3 col-xs-4">Previsión</label>
                    <div class="col-md-2 col-sm-3 col-xs-7">
                        <select id="opcionPrevision" for="prevision" class="form-control" id="prevision" name="prevision">
                            <option  value="0">Seleccione una Previsión</option>
                            {foreach $arrPrevision as $item}
                                <option  value="{$item->id_prevision}" >{$item->gl_nombre_prevision}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                {*<div class="form-group hidden" id="groupFonasaExtranjero" >
                    <label for="gl_codigo_fonasa" class="control-label col-sm-3 col-xs-4">Identificador Fonasa</label>
                    <div class="col-sm-3 col-xs-7">
                        <input type="text" class="form-control col-sm-2" name="gl_codigo_fonasa" id="gl_codigo_fonasa">
                    </div>
                    <!--div class="col-sm-1">
                            <button type="button" id="btnUploadFonasa" class="btn btn-sm btn-success"
                                            onclick="xModal.open('{$smarty.const.BASE_URI}/Paciente/cargarAdjuntoFonasa', 'Cargar Adjunto', '', 1, true, '150'); $('#tipo_adj').val(3);" >
                                    <i class="fa fa-upload" aria-hidden="true"></i> Subir Archivo Fonasa
                            </button>
                    </div-->
                </div>
                <div class="form-group">
                    <div class="col-xs-12" id="listado-adjuntos-fonasa" name="listado-adjuntos-fonasa"></div>
                </div>*}

                <div class="form-group">
                    <div class="col-sm-3" align="right">
                        <button type="button" id="btnNuevoContacto" class="btn btn-sm btn-success"
                                onclick="xModal.open('{$smarty.const.BASE_URI}/Paciente/cargaNuevoContacto/?bo_direccion=1', 'Agregar Dirección Paciente', 80);" >
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar Dirección
                        </button>
                    </div>
                    <div class="col-sm-6" id="grilla-contacto-paciente">

                    </div>
                </div>

            </div>
        </div>

        <div class="top-spaced"></div>

        <div class="panel panel-primary">
            <div class="panel-heading">Identificación de Mordedura: Lugar geográfico donde ocurrió la mordedura</div>
            <div class="panel-body">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="fc_mordedura" class="control-label col-sm-4 required">Fecha Mordedura</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="fc_mordedura" name="fc_mordedura" autocomplete="off">
                                <span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fc_mordedura').focus();"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4 required">Región</label>
                        <div class="col-sm-6">
                            <select for="region" class="form-control" id="region" name="region" onchange="Region.cargarComunasPorRegion(this.value, 'comuna')">
                                <option value="0">Seleccione una Región</option>
                                {foreach $arrRegiones as $item}
                                    <option value="{$item->id_region}" id="{$item->gl_latitud}" name="{$item->gl_longitud}"
                                            {if $item->id_region == $id_region_sesion}selected{/if}>{$item->gl_nombre_region}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label  col-sm-4 required">Comuna</label>
                        <div class="col-sm-6">
                            <select for="comuna" class="form-control" id="comuna" name="comuna">
                                <option value="0">Seleccione una Comuna</option>
                                {if !$es_admin}
                                    {foreach $arrComunas as $item}
                                        <option value="{$item->id_comuna}" id="{$item->gl_latitud_comuna}" name="{$item->gl_longitud_comuna}">{$item->gl_nombre_comuna}</option>
                                    {/foreach}
                                {/if}
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="direccion" class="control-label col-sm-4">Lugar donde ocurrió la mordedura</label>
                        <div class="col-sm-6">
                            <input type="text" name="direccion" id="direccion" value="" placeholder="Dirección" class="form-control">
                        </div>
                        <div id="groupConfirmaDir" class="form-group hidden">
                            <label for="chk_confirma_dir" class="control-label col-sm-2 col-xs-6">Confirma Direccion</label>
                            <div class="col-sm-1 col-xs-6">
                                <input id="chk_confirma_dir" type="checkbox" value='1'>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="direccion" class="control-label col-sm-4">Datos de Referencia</label>
                        <div class="col-sm-6">
                            <textarea type="text" name="gl_datos_referencia" id="gl_datos_referencia"
                                      placeholder="Datos de Referencia" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4 required">Lugar Mordedura</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="id_lugar_mordedura" name="id_lugar_mordedura">
                                <option value="0">Seleccione Lugar</option>
                                {if $arrLugarMordedura}
                                    {foreach $arrLugarMordedura key=key item=item}
                                        <option value="{$item->id_lugar_mordedura}">{$item->gl_nombre}</option>
                                    {/foreach}
                                {/if}
                            </select>
                        </div>
                    </div>
                    <div class="form-group" id="div_otro_lugar" style="display: none">
                        <label for="gl_otro_lugar_mordedura" class="control-label col-sm-4">Otro (especifíque)</label>
                        <div class="col-sm-6">
                            <input type="text" name="gl_otro_lugar_mordedura" id="gl_otro_lugar_mordedura"
                                   placeholder="Otro (especifíque)" class="form-control">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label col-sm-4  required" data-toggle="" data-placement="bottom" >
                        Inicia Vacunación Antirrabica </label>
                        <div class="col-sm-4 col-xs-6">
                            {foreach $arrIniciaVacuna key=key item=itm}
                                <label><input class="id_inicia_vacuna" onclick="IniciaVacunacion({$itm->id_inicia_vacuna})" type="radio" name="id_inicia_vacuna" id="id_inicia_vacuna_{$itm->id_inicia_vacuna}"
                                              value="{$itm->id_inicia_vacuna}">{$itm->gl_nombre}</label>&nbsp;&nbsp;
                            {/foreach}
                        </div>
                        <div class="col-sm-4 col-xs-6" id="descargarInstVac" hidden>
                            <button type="button" class="btn btn-sm btn-info" id="btnDescargarInstVac" onclick="window.open('{$smarty.const.BASE_URI}{$base_url}/Paciente/descargarDocumento/126b420b8b011e45736fc1ca0e3bf72134684345464036c85c4a7dcf8f9d043f0757aa1ebcada4f00c8bafd02849b568e2d2308f597deefac4514680ad4ac840')" download>
                                <i class="fa fa-download"></i> Instructivo
                            </button>
                        </div>
                    </div>
                     <div class="form-group" id="NotaNoVac"  hidden>
                     <div class="col-sm-4 col-xs-6"> 
                        </div>
                         <div class="col-sm-8 col-xs-6">
                        <label><font color="red">*Si el mordedor es un perro o gato y "No" se iniciará vacunación,  es imprescindible que indique la DIRECCIÓN DEL DOMICILIO del mordedor para su observación, en ítem dispuesto para ello.</font> </label>
                        </div>
                     </div>
                    <div class="form-group">
                        <label class="control-label  col-sm-4 required">Tipo de Mordedura</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="tipo_mordedura" name="tipo_mordedura">
                                <option value="0">Única</option>
                                <option value="1">Múltiple</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="id_animal_especie" class="control-label col-sm-4">Observaciones</label>
                        <div class="col-sm-6">
                            <textarea type="text" class="form-control" id="gl_observaciones" name="gl_observaciones" placeholder="Describir gravedad de la mordedura, ubicación en el cuerpo , etc." rows="4"></textarea>
                        </div>
                    </div>
                    <!-- paciente observa animal? -->
                    <div class="form-group">
                        <label for="gl_referencias_animal" class="control-label col-sm-4" data-toggle="" data-placement="bottom" title="Según lo establecido en el artículo 24 del D.S. 1/2014 del MINSAL Reglamento sobre Prevención y Control de la Rabia en el Hombre y en los Animales.">
							¿La observación del animal mordedor la realizará el paciente?
                        </label>
                        <div class="form-check form-check-inline col-sm-4 col-xs-6">
                            <input class="form-check-input" type="radio" name="bo_paciente_observa" id="bo_paciente_observa1" value="1">
                            <label class="form-check-label" for="inlineRadio1">SI</label>
                            <input class="form-check-input" type="radio" name="bo_paciente_observa" id="bo_paciente_observa_0" value="0" checked>
                            <label class="form-check-label" for="inlineRadio2">NO</label>
                        </div>
                        <div class="col-sm-4 col-xs-6" id="descargarInst" hidden>
                            <button type="button" class="btn btn-sm btn-info" id="btnDescargarInst" onclick="window.open('{$smarty.const.BASE_URI}{$base_url}/Paciente/descargarDocumento/CA4965F48E8BD17CBC94213EA7DC5BB82E7BC4FAA101AD200C879C8D37BA81E75AB7034808FCAC99663EB3CD02747C3AEA20252892DF619B7571A1F26231FC62')" download>
                                <i class="fa fa-download"></i> Instructivo
                            </button>
                        </div>
                    </div>
                    <!--div id="files">
                            <div class="form-group">
                                    <label for="files" class="control-label col-sm-4">Consentimiento</label>

                    {*
                    <div class="col-sm-3">
                    <a class="btn btn-sm btn-info" id="btnDescarga" onclick="xModal.open('{$smarty.const.BASE_URI}/Paciente/generarConsentimiento', 'Cargar Adjunto', '70', 1, true,'700');" download target="_blank">
                    <i class="fa fa-download"></i>Descargar
                    </a>
                    </div>
                    *}

                    <div class="col-sm-3">
                            <a class="btn btn-sm btn-info" id="btnDescarga" download target="_blank">
                                    <i class="fa fa-download"></i>Descargar
                            </a>
                    </div>
            </div>
            <div class="form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-2">
                            <button type="button" id="btnUploadUno" class="btn btn-sm btn-success"
                                            onclick="xModal.open('{$smarty.const.BASE_URI}/Paciente/cargarAdjunto', 'Cargar Adjunto', '', 1, true, '150'); $('#tipo_adj').val(1);" >
                                    <i class="fa fa-upload" aria-hidden="true"></i> Subir Firmado
                            </button>
                    </div>
            </div>
    </div-->
                </div>
                <div class="col-md-6 col-sm-12">
                    <div id="map" data-editable="1" style="width:100%;height:300px;"></div>
                    <div class="form-group">
                        <label for="gl_latitud" class="control-label col-sm-3">Latitud</label>
                        <div class="col-sm-3">
                            <input type="text" name="gl_latitud" id="gl_latitud" value="" placeholder="latitud" class="form-control"/>
                        </div>
                        <label for="gl_longitud" class="control-label col-sm-1">Longitud</label>
                        <div class="col-sm-3">
                            <input type="text" name="gl_longitud"  id="gl_longitud" value="" placeholder="longitud" class="form-control"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-12" id="listado-adjuntos" name="listado-adjuntos"></div>
                </div>
            </div>

        </div>

        <div class="top-spaced"></div>

        <div class="panel panel-primary">
            <div class="panel-heading">Identificación de Mordedor</div>
            <div class="panel-body">

                <div class="form-group">
                    <label class="control-label col-sm-2 required">Grupo Animal Mordedor</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="id_animal_grupo" name="id_animal_grupo">
                            <option value="0">Seleccione un Grupo de Animal</option>
                            {foreach $arrAnimalGrupo as $item}
                                <option value="{$item->id_animal_grupo}">{$item->gl_nombre}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div id="div_nuevo_mordedor" style="display:none">
                        <button type="button" id="btnNuevoMordedor" class="btn btn-sm btn-success"
                                onclick="xModal.open('{$smarty.const.BASE_URI}/Paciente/cargaNuevoMordedor', 'Nuevo Animal Mordedor', 80);" >
                            <i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar Animal Mordedor
                        </button>
                    </div>
                </div>

                <div class="form-group" id="div_grilla_mordedor">
                    <div class="col-sm-2">&nbsp;</div>
                    <div class="col-sm-6" id="grilla-animal-mordedor">

                    </div>
                </div>

                <div class="form-group">
                    <label for="gl_observaciones_mordedor" class="control-label col-sm-2">Observaciones</label>
                    <div class="col-sm-6">
                        <textarea type="text" class="form-control" id="gl_observaciones_mordedor" name="gl_observaciones_mordedor" placeholder="Describa brevemente el motivo que generó la mordedura y el comportamiento que tuvo del animal mordedor" rows="4"></textarea>
                    </div>
                </div>

                <div class="form-group clearfix  text-right">
                    <button type="button" id="guardar" onclick="javascript:$(this).attr('disabled', 'disabled');" class="btn btn-success">
                        <i class="fa fa-save"></i>  Guardar
                    </button>&nbsp;
                    <button type="button" id="cancelar"  class="btn btn-default"
                            onclick="location.href = '{$base_url}/Paciente/index'">
                        <i class="fa fa-remove"></i>  Cancelar
                    </button>
                    <br/><br/>
                </div>
            </div>
        </div>
    </section>
</form>