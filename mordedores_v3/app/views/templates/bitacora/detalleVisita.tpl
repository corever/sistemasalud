<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#ver_notificacion">Notificación</a></li>
    {*if $arrMordedores->row_0*}
        <li><a data-toggle="tab" href="#ver_visita">Visita</a></li>
    {*/if*}
</ul>
<div class="top-spaced">&nbsp;</div>
<div class="tab-content">

    <!-- DATOS VISITA  -->
    <div id="ver_notificacion" class="tab-pane fade in active">
        {include file='bitacora/ver_notificacion.tpl'}
    </div>

    <!-- DATOS MORDEDOR  -->
    <div id="ver_visita" class="tab-pane">
        
        <div class="panel panel-info">
            <div class="panel-heading">
                Resultado de Visita
            </div>
            <div class="panel-body">
                {assign var="json_visita" value=$arr->json_visita|@json_decode}
                <div class="row">
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class='col-sm-12'>
                            <label class="control-label">Estado</label><br>
                            {if $arr->id_visita_estado == 1}
                                <span class="form-control label label-danger">{$arr->gl_estado}</span>
                            {else}
                                <span class="form-control label label-success">{$arr->gl_estado}</span>
                            {/if}
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class='col-sm-12'>
                            <label class="control-label">Resultado</label><br>
                            {if $arr->id_visita_estado == 2 && $arr->id_tipo_visita_resultado != 4}
                                {if $arr->id_tipo_visita_resultado == 1}
                                    <span class="form-control label label-success">{$arr->gl_tipo_resultado}</span>
                                {elseif $arr->id_tipo_visita_resultado == 2}
                                    <span class="form-control label label-danger">{$arr->gl_tipo_resultado}</span>
                                {elseif $arr->id_tipo_visita_resultado == 3}
                                    <span class="form-control label label-info">{$arr->gl_tipo_resultado}</span>
                                {elseif $arr->id_tipo_visita_resultado == 5}
                                    <span class="form-control label label-danger">{$arr->gl_tipo_resultado}</span>
                                {else}
                                    -
                                {/if}
                            {else}
                                {if $arr->id_tipo_visita_perdida == 1}
                                    <span class="form-control label label-danger">{$arr->gl_tipo_perdida}</span>
                                {elseif $arr->id_tipo_visita_perdida == 2}
                                    <span class="form-control label label-info">{$arr->gl_tipo_perdida}</span>
                                {elseif $arr->id_tipo_visita_perdida == 3}
                                    <span class="form-control label label-warning">{$arr->gl_tipo_perdida}</span>
                                {elseif $arr->id_tipo_visita_perdida == 4}
                                    <span class="form-control label label-default">{$arr->gl_tipo_perdida}</span>
                                {elseif $arr->id_tipo_visita_perdida == 5}
                                    <span class="form-control label label-warning">{$arr->gl_tipo_perdida}</span>
                                {else}
                                    -
                                {/if}
                            {/if}

                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="col-sm-12">
                            <label class="control-label">Fiscalizador</label>
                            <input type='text' class="form-control" value="{$arr->gl_fiscalizador}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="col-sm-12">
                            <label class="control-label">Email</label>
                            <input type='text' class="form-control" value="{$arr->gl_email_fiscalizador}" readonly>
                        </div>
                    </div>
                        
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="col-sm-12">
                            <label class="control-label">Folio</label>
                            <input type="text" value="{if $json_visita->datos_visita->gl_folio}{$json_visita->datos_visita->gl_folio}{else}{$arr->gl_folio_expediente}{/if}" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class='col-sm-12'>
                            <label class="control-label">Fecha Visita</label>
                            <input type='text' class="form-control" value="{$arr->fc_visita}" readonly>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class="col-sm-12">
                            <label class="control-label">Fecha Sincronización</label>
                            <input type="text" value="{$arr->fc_sincronizacion}" class="form-control" readonly>
                        </div>
                    </div>
                    {if $arr->gl_origen == "APP"}
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class='col-sm-12'>
                            <label class="control-label">Versión app</label>
                            <input type='text' class="form-control" value="{$arr->gl_app_version}" readonly>
                        </div>
                    </div>
                    {/if}
                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                        <div class='col-sm-12'>
                            <label class="control-label">Origen</label><br>
                            {if $arr->gl_origen == "APP"}
                                <span class="form-control label label-info">{$arr->gl_origen}</span>
                            {else}
                                <span class="form-control label label-primary">{$arr->gl_origen}</span>
                            {/if}
                        </div>
                    </div>
                    
                    {assign var=nr_version_format value=$arr->gl_app_version|replace:'.':''}
                    {*version 110 (1.1.0 - en Producción / Test es 1.3.3) no tenia implementado campo de Volver a Visitar*}
                    {if $nr_version_format > 110}
                        {if $arr->id_visita_estado == 1 && ($arr->id_tipo_visita_perdida == 2 || $arr->id_tipo_visita_perdida == 4 || $arr->id_tipo_visita_perdida == 5)}
                            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <div class='col-sm-12'>
                                    <label class="control-label">Volver a Visitar</label><br>
                                    {if $arr->bo_volver_a_visitar == 1}
                                        <span class="form-control label label-success">SI</span>
                                    {else}
                                        <span class="form-control label label-danger">NO</span>
                                    {/if}
                                </div>
                            </div>
                        {/if}
                    {/if}
                    
                    {if $arr->id_visita_estado == 1}
                    <div class="col-sm-6 col-xs-12">
                        <div class="col-sm-12">
                            <label class="control-label">Observaciones visita</label>
                            <textarea type="text" class="form-control" rows="3" readonly>{if $arr->gl_observacion_visita}{$arr->gl_observacion_visita}{/if}</textarea>
                        </div>
                    </div>
                    {/if}
                    {if $arr->bo_sumario == 1}
                        <div class="col-sm-6 col-xs-12">
                            <span class="form-control label label-danger">Se Inicia Sumario</span>
                        </div>
                    {/if}


                    <div class="top-spaced">&nbsp;</div>
                </div>
            </div>
        </div>

        <div class="top-spaced"></div>
        
        {if $arrMordedores->row_0}
            {assign var=cont value=1}
            {foreach $arrMordedores key=key item=mor}
                {if $arrMordedores->row_1}
                    {assign var=icono value='glyphicon glyphicon-chevron-up'}
                    {assign var=hidden value='none'}
                {else}
                    {assign var=icono value='glyphicon glyphicon-chevron-down'}
                    {assign var=hidden value='block'}
                {/if}
                
                {assign var=adj_token_microchip value=''}
                {assign var=adj_token_vacuna value=''}
                {assign var=adj_token_eutanasia value=''}
                
                {if $mor->arrAdjuntos}
                    {foreach $mor->arrAdjuntos as $adj}
                        {if $adj->id_adjunto_tipo == 5}
                            {assign var=adj_token_microchip value=$adj->gl_token}
                        {elseif $adj->id_adjunto_tipo == 6}
                            {assign var=adj_token_vacuna value=$adj->gl_token}
                        {elseif $adj->id_adjunto_tipo == 3}
                            {assign var=adj_token_eutanasia value=$adj->gl_token}
                        {/if}
                    {/foreach}
                {/if}
                
                {if is_string($mor->json_otros_datos)}
                    {assign var=json_otros_datos value=$mor->json_otros_datos|@json_decode}
                {else}
                    {assign var=json_otros_datos value=$mor->json_otros_datos}
                {/if}
                {assign var=json_tipo_sintoma value=$mor->json_tipo_sintoma|@json_decode}
                {assign var=json_direccion_mor value=$mor->json_direccion|@json_decode}
                {assign var=arrMordedor value=$mor->arrMordedor|@json_decode}
                {assign var=vacuna value=$arrMordedor->json_vacuna}
                {assign var="json_dueno" value=$mor->json_direccion_dueno|@json_decode}
                {assign var="json_dueno_visita" value=$mor->json_dueno_visita|@json_decode}
                
                <div class="panel panel-info">
                    <div class="panel-heading" style="cursor:pointer;" onclick="ocultaMuestraVista('mordedor_{$key}');">
                        Mordedor 
                        {if !empty($mor->gl_folio_mordedor)}
                            Folio: {$mor->gl_folio_mordedor}
                        {else}
                            Microchip: {$arrMordedor->gl_microchip} 
                        {/if}

                        <div class="pull-right"><i id="i-mordedor_{$key}" class="{$icono}"></i></div>
                    </div>
                    <div class="panel-body" id="mordedor_{$key}" style="display: {$hidden}">
                        <fieldset>
                            <legend>Datos Mordedor
                                {if !empty($mor->gl_folio_mordedor)}
                                    Folio: {$mor->gl_folio_mordedor}
                                {else}
                                    Microchip: {$arrMordedor->gl_microchip} 
                                {/if}
                            </legend>
                            <div class="row">
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Estado Visita</label>
                                    {if $mor->id_visita_estado == 1}
                                        <span class="form-control label label-warning">{$mor->visita_mordedor_estado}</span>
                                    {else}
                                        <span class="form-control label label-success">{$mor->visita_mordedor_estado}</span>
                                    {/if}
                                </div>
                                {if $mor->id_visita_estado == 1}
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Tipo Visita Perdida</label>
                                    {*if $mor->id_tipo_visita_perdida == 1}
                                        <span class="form-control label label-danger">{$mor->visita_tipo_perdida}</span>
                                    {else*}
                                        <span class="form-control label label-warning">{$mor->visita_tipo_perdida}</span>
                                    {*/if*}
                                </div>
                                {elseif $mor->id_visita_estado == 2 && $mor->id_tipo_visita_resultado == 5}
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        <label>Tipo Visita</label>
                                        <span class="form-control label label-danger">{$mor->gl_tipo_resultado}</span>
                                    </div>
                                {/if}
                                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label>Estado Animal</label>
                                    {if $mor->id_visita_estado != 1}
                                        {if $mor->id_animal_estado == 1}
                                            <span class="form-control label label-success">{$arrMordedor->gl_animal_estado}</span>
                                        {else}
                                            <span class="form-control label label-warning">{$arrMordedor->gl_animal_estado}</span>
                                        {/if}
                                    {else}
                                        {if $mor->id_visita_animal_estado == 1}
                                            <span class="form-control label label-success">{$mor->visita_animal_estado}</span>
                                        {else}
                                            <span class="form-control label label-warning">{$mor->visita_animal_estado}</span>
                                        {/if}
                                    {/if}
                                </div>
                                {if $mor->id_visita_estado != 1}
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        <label>Sospecha de Rabia</label><br>
                                        {if $arrMordedor->bo_rabia}
                                            <span class="form-control label label-danger">SI</span>
                                        {else}
                                            <span class="form-control label label-success">NO</span>
                                        {/if}
                                    </div>
									{*
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        <label>¿Mordedor Habitual?</label><br>
                                        {if $arrMordedor->bo_mordedor_habitual}
                                            <span class="form-control label label-danger">SI</span>
                                        {else}
                                            <span class="form-control label label-success">NO</span>
                                        {/if}
                                    </div>
									*}
                                    {*if $mor->id_animal_estado == 1}
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        <label>¿Necesita vacuna?</label><br>
                                        {if $mor->bo_necesita_vacuna}
                                            <span class="form-control label label-danger">SI</span>
                                        {else}
                                            <span class="form-control label label-success">NO</span>
                                        {/if}
                                    </div>
                                    {/if*}
                                {/if}
                            </div>

                            {*if $mor->id_animal_estado == 2 && $mor->bo_rabia != 1*}
                                {if $arrMordedor->id_animal_estado == 2}
                                    {if $arrMordedor->bo_eutanasiado == 1}
                                    {*
				    <div class="col-md-4 col-xs-12">
                                        <label>Fecha Eutanasia</label>
                                        <input type="text" class="form-control" value="{$arrMordedor->fc_eutanasia}" readonly>
                                    </div>
				    *}
                                    {else}
                                    <div class="col-md-4 col-xs-12">
                                        <label>Fecha Muerte</label>
                                        <input type="text" class="form-control" value="{$arrMordedor->fc_muerte}" readonly>
                                    </div>
                                    {/if}
                                {/if}
                                    <div class="col-md-4 col-xs-12">
                                        <label>Especie</label>
                                        <input type="text" class="form-control" value="{$arrMordedor->gl_animal_especie}" readonly>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <label>Raza</label>
                                        <input type="text" class="form-control" value="{$arrMordedor->gl_animal_raza}" readonly>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <label>Nombre</label>
                                        <input type="text" class="form-control" value="{(!empty($arrMordedor->gl_nombre))?$arrMordedor->gl_nombre:'-'}" readonly>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <label>Color</label>
                                        <input type="text" class="form-control" value="{(!empty($arrMordedor->gl_color_animal))?$arrMordedor->gl_color_animal:$json_otros_datos->gl_color_animal}" readonly>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <label>Tamaño</label>
                                        <input type="text" class="form-control" value="{$arrMordedor->gl_animal_tamano}" readonly>
                                    </div>
                                {if $arrMordedor->id_animal_estado == 1}
                                    <div class="col-md-4 col-xs-12">
                                        <label>Sexo</label>
                                        <input type="text" class="form-control" value="{$arrMordedor->gl_animal_sexo}" readonly>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <label>Edad</label>
                                        <input type="text" class="form-control" value="{(!empty($arrMordedor->nr_edad))?$arrMordedor->nr_edad:$json_otros_datos->nr_edad}" readonly>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <label>Edad Meses</label>
                                        <input type="text" class="form-control" value="{(!empty($arrMordedor->nr_edad_meses))?$arrMordedor->nr_edad_meses:$json_otros_datos->nr_edad_meses}" readonly>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <label>Peso</label>
                                        <input type="text" class="form-control" value="{(!empty($arrMordedor->nr_peso))?$arrMordedor->nr_peso:$json_otros_datos->nr_peso}" readonly>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <label>Estado Reproductivo</label>
                                        <input type="text" class="form-control" value="{if $arrMordedor->gl_estado_productivo}{$arrMordedor->gl_estado_productivo}{/if}" readonly>
                                    </div>
                                    <div class="col-md-4 col-xs-12">
                                        <label>Descripción</label>
                                        <textarea type="text" class="form-control" readonly>{if $json_otros_datos->gl_apariencia}{$json_otros_datos->gl_apariencia}{else}{$arrMordedor->gl_apariencia}{/if}</textarea>
                                    </div>
                                {/if}
                                <div class="col-md-6 col-xs-12">
                                    <label>Dirección Mordedor</label>
                                    <input type="text" class="form-control" value="{if $arrMordedor->gl_direccion}{$arrMordedor->gl_direccion}{else}{$json_direccion_mor->gl_direccion}{/if}{if $arrMordedor->gl_region}, {$arrMordedor->gl_region}{/if}{if $arrMordedor->gl_comuna}, {$arrMordedor->gl_comuna}{/if}" readonly>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <label>Datos Referencia</label>
                                    <input type="text" class="form-control" value="{if $arrMordedor->gl_direccion_detalles}{$arrMordedor->gl_direccion_detalles}{/if}" readonly>
                                </div>
                                {if $arrMordedor->id_animal_estado == 2}
                                    <div class="col-sm-6 col-xs-12">
                                        <label class="control-label">Observaciones</label>
                                        <textarea type="text" class="form-control" rows="3" readonly>{if $json_otros_datos->gl_motivo_otro}{$json_otros_datos->gl_motivo_otro}{/if}</textarea>
                                    </div>
                                {/if}
                            {*/if*}
                        </fieldset>
                        <div class="top-spaced">&nbsp;</div>
                        
                        <fieldset>
                            <legend>Microchip</legend>
                            
                            <div class="row">
                                {if $arrMordedor->gl_microchip || $vacuna->gl_microchip}
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                        <label>¿Previamente Instalado?</label><br>
                                        {if $arrMordedor->bo_microchipInstalado == 1}
                                            <span class="form-control label label-success">SI</span>
                                        {else}
                                            <span class="form-control label label-danger">NO</span>
                                        {/if}
                                    </div>
                                    {if $arrMordedor->bo_microchipInstalado == 1 && ($arrMordedor->instalador_microchip->nombre || $arrMordedor->gl_otro_instalador_microchip)}
                                        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                            <label>¿Quién instaló microchip?</label><br>
                                            {if $arrMordedor->instalador_microchip->nombre}
                                                <input type="text" class="form-control" value="{$arrMordedor->instalador_microchip->nombre}" readonly>
                                            {elseif $arrMordedor->gl_otro_instalador_microchip}
                                                <input type="text" class="form-control" value="{$arrMordedor->gl_otro_instalador_microchip}" readonly>
                                            {/if}
                                        </div>
                                    {/if}
                                {/if}
                            </div>
                            
                            <div class="row">
                                {if $arrMordedor->gl_microchip || $vacuna->gl_microchip}
                                    <div class="col-md-4 col-xs-6">
                                        <label>N° Microchip</label>
                                        <input type="text" class="form-control" value="{if $arrMordedor->gl_microchip}{$arrMordedor->gl_microchip}{else}{$vacuna->gl_microchip}{/if}" readonly>
                                    </div>
                                    <div class="col-md-2 col-xs-6">
                                        <label>Documento Microchip</label><br>
                                        {if $adj_token_microchip != ''}
                                        <button class="btn btn-xs btn-primary" id="btnDescarga"
                                        onclick="window.open('{$smarty.const.BASE_URI}/Adjunto/verByToken/?token={$adj_token_microchip}')">
                                         <i class="fa fa-file"></i></button>
                                        {else}-
                                        {/if}
                                    </div>
                                    <div class="col-md-4 col-xs-6">
                                        <label>Fecha Microchip</label>
                                        <input type="text" class="form-control" value="{$arrMordedor->fc_microchip}" readonly>
                                    </div>
                                {else}
                                    <div class="col-md-12 col-xs-12">
                                        <span class="form-control label bg-red color-palette">Sin Información</span>
                                    </div>
                                {/if}
                            </div>
                        </fieldset>
                        <div class="top-spaced">&nbsp;</div>
                        {if $json_tipo_sintoma}
                            <fieldset>
                                <legend>Sintomas</legend>
                                {foreach from=$arrSintomas item=sintoma}
                                    <div class="col-md-3 col-xs-6">
                                        {assign var=bo_igual value=0}
                                        
                                        {foreach from=$json_tipo_sintoma item=tipo_sintoma}
                                            {if $sintoma->id_tipo_sintoma == $tipo_sintoma->id}
                                                <span class="form-control label label-info">{$sintoma->gl_nombre}</span>
                                                {assign var=bo_igual value=1}
                                            {/if}
                                        {/foreach}
                                        
                                        {if $bo_igual != 1}
                                            <span class="form-control label label-default">{$sintoma->gl_nombre}</span>
                                        {/if}
                                    </div>
                                {/foreach}
                                <div class="col-xs-12">&nbsp;</div>
                                <div class="col-md-6 col-xs-12">
                                    <label>Descripción Sintomas</label>
                                    <textarea type="text" class="form-control" size="3" readonly>{if $mor->gl_descripcion_mordedor}{$mor->gl_descripcion_mordedor}{/if}</textarea>
                                </div>
                                <div class="col-md-3 col-xs-12">
                                    <label>Fecha Eutanasia</label>
                                    <input type="text" class="form-control" value="{$mor->fecha_eutanasia}" readonly>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <label>Acta Eutanasia</label><br>
                                    {if $adj_token_eutanasia != ''}
                                    <button class="btn btn-xs btn-primary" id="btnDescarga"
                                    onclick="window.open('{$smarty.const.BASE_URI}/Adjunto/verByToken/?token={$adj_token_eutanasia}')">
                                     <i class="fa fa-file"></i></button>
                                    {/if}
                                </div>
                            </fieldset>
                            <div class="top-spaced">&nbsp;</div>
                        {/if}
                        
                        {if $arrMordedor->id_animal_estado == 1}
                            <fieldset>
                                <legend>Vacuna Antirrábica</legend>
                                
                                {*if $arrMordedor->bo_antirrabica_vigente*}
                                    <div class="row">
                                        <div class="col-md-4 col-xs-6">
                                            <label>¿Vacuna vigente?</label>
                                            <input type="text" class="form-control" value="{$arrMordedor->gl_vacuna_vigencia}{if $arrMordedor->bo_antirrabica_vigente == 4} ({$arrMordedor->gl_otro_vigencia}){/if}" readonly>
                                        </div>
                                    </div>
                                {*/if*}
                                
                                {if !empty($mor->id_animal_vacuna) && $arrMordedor->bo_antirrabica_vigente != 2 && $arrMordedor->bo_antirrabica_vigente != 3}
                                    <div class="row">
                                        <div class="col-md-4 col-xs-12">
                                            <label>N° Certificado</label>
                                            <input type="text" class="form-control" value="{$vacuna->gl_certificado_vacuna}" readonly>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <label>N° de Serie</label>
                                            <input type="text" class="form-control" value="{$vacuna->gl_numero_serie_vacuna}" readonly>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <label>Documento Vacuna</label><br>
                                            {if $adj_token_vacuna != ''}
                                            <button class="btn btn-xs btn-primary" id="btnDescarga"
                                            onclick="window.open('{$smarty.const.BASE_URI}/Adjunto/verByToken/?token={$adj_token_vacuna}')">
                                             <i class="fa fa-file"></i></button>
                                            {else}-
                                            {/if}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-12">
                                            <label>Laboratorio</label>
                                            <input type="text" class="form-control" value="{if $vacuna->gl_laboratorio}{$vacuna->gl_laboratorio}{else}{$arrMordedor->gl_laboratorio}{/if}" readonly>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <label>Medicamento</label>
                                            <input type="text" class="form-control" value="{if $vacuna->gl_medicamento}{$vacuna->gl_medicamento}{/if}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-12">
                                            <label>Duración Inmunidad</label>
                                            <input type="text" class="form-control" value="{$vacuna->id_duracion_inmunidad}" readonly>
                                        </div>
                                        <div class="col-md-4 col-xs-12">
                                            <label>Fecha Vacunación</label>
                                            <input type="text" class="form-control" value="{$arrMordedor->fc_vacuna}" readonly>
                                        </div>
                                        <div class="col-md-3 col-xs-12">
                                            <label>Fecha Caducidad Vacuna</label>
                                            <input type="text" class="form-control" value="{$vacuna->fc_caducidad_vacuna}" readonly>
                                        </div>
                                    </div>
                                {else}
                                    <div class="col-md-12 col-xs-12">
                                        <span class="form-control label bg-red color-palette">Sin Información</span>
                                    </div>
                                {/if}
                            </fieldset>
                            <div class="top-spaced">&nbsp;</div>
                        {/if}
                            <fieldset>
                                <legend>Datos Dueño</legend>
                                {if $mor->id_dueno > 0 or $mor->gl_nombre_dueno != 'SIN DUEÑO'}
                                    {if $mor->bo_dueno_extranjero == 1 && ($mor->bo_rut_informado == 0 || empty($mor->gl_rut_dueno))}
                                    <div class="col-md-4 col-xs-12">
                                        <label>Pasaporte</label>
                                        <input type="text" class="form-control" value="{$mor->gl_pasaporte}" readonly>
                                    </div>
                                    {else}
                                    <div class="col-md-4 col-xs-12">
                                        <label>Rut</label>
                                        <input type="text" class="form-control" value="{$mor->gl_rut_dueno}" readonly>
                                    </div>
                                    {/if}
                                <div class="col-md-4 col-xs-12">
                                    <label>Nombre Completo</label>
                                    <input type="text" class="form-control" value="{$mor->gl_nombre_dueno}" readonly>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <label>Región</label>
                                    <input type="text" class="form-control" value="{$mor->gl_region_dueno}" readonly>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <label>Comuna</label>
                                    <input type="text" class="form-control" value="{$mor->gl_comuna_dueno}" readonly>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <label>Dirección</label>
                                    <input type="text" class="form-control" value="{if $json_dueno->direccion}{$json_dueno->direccion}{else}{$json_dueno_visita->direccion}{/if}" readonly>
                                </div>
                                <div class="col-md-4 col-xs-12">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="{if $mor->gl_email_dueno}{$mor->gl_email_dueno}{/if}" readonly>
                                </div>
                                {else}
                                    <div class="col-md-12 col-xs-12">
                                        <span class="form-control label bg-red color-palette">Sin Información</span>
                                    </div>
                                {/if}
                            </fieldset>
                            <div class="top-spaced">&nbsp;</div>
                    </div>
                </div>
                <div class="top-spaced">&nbsp;</div>
            {/foreach}
        {else}
            {*<div class="panel panel-info"><div class="panel-heading">Sin Mordedor</div></div>*}
        {/if}
        
    </div>
