<link href="{$static}/template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$static}/template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>

<form id="formPacienteObserva" class="form-horizontal" enctype="multipart/form-data">
    <div class="panel panel-primary">
        <div class="panel-heading">Llamado de Paciente que Observa</div>
        <div class="panel-body" id="div_body_animal">

            <div class="top-spaced"></div>
            
            <div class="form-group" id="div_resultado_isp">
                <div class="col-md-12">
                    <input type="text" value="{$token_expediente}" id="token_expediente" name="token_expediente" class="hidden">
                    
                    <div class="form-group">
                        <label for="gl_nombre_paciente" class="control-label col-md-3 col-sm-5 col-xs-12">Nombre</label>
                        <div class="col-lg-4 col-md-6 col-xs-5">
                            <input id="gl_nombre_paciente" name="gl_nombre_paciente" class="form-control" type="text" value="{$arr->nombre_paciente} {$arr->apellidos_paciente}" readonly>
                        </div>
                    </div>
                    
                    {if $arr->arrContactoPac}
                    {foreach $arr->arrContactoPac as $contacto}
                        {if $contacto.id_tipo_contacto == 2 || $contacto.id_tipo_contacto == 4}
                            {assign var="json_contacto" value=$contacto.json_datos}
                            
                            {if $contacto.id_tipo_contacto == 2}
                                {assign var="gl_tipo_contacto" value="Teléfono"}
                                {assign var="gl_contacto" value=$json_contacto.telefono_movil}
                            {else if $contacto.id_tipo_contacto == 4}
                                {assign var="gl_tipo_contacto" value="Email"}
                                {assign var="gl_contacto" value=$json_contacto.gl_email}
                            {/if}
                            
                            <div class="form-group">
                                <label for="gl_contacto_paciente" class="control-label col-sm-3">{$gl_tipo_contacto} Paciente</label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control" value="{$gl_contacto}" id="gl_contacto_paciente" name="gl_contacto_paciente" readonly>
                                </div>
                            </div>
                        {/if}
                    {/foreach}
                    {/if}
                    <div class="form-group">
                        <label for="id_quien_llama" class="control-label col-sm-3 form-check-inline">¿Quién llama? (*)</label>
                        <div class="col-sm-7">
                            <input class="form-check-input" type="radio" name="id_quien_llama" id="id_quien_llama_1" value="1" onclick="LlamadoPaciente.cambioLlamador();">
                            <label class="form-check-label" for="id_quien_llama_1">Paciente</label>
                            <input class="form-check-input" type="radio" name="id_quien_llama" id="id_quien_llama_2" value="2" onclick="LlamadoPaciente.cambioLlamador();">
                            <label class="form-check-label" for="id_quien_llama_2">Seremi</label>
                        </div>
                    </div>
                    
                    <div class="form-group" id="div_paciente_contesta" style="display:none;">
                        <label for="bo_paciente_contesta" class="control-label col-sm-3 form-check-inline">¿Paciente contesta? (*)</label>
                        <div class="col-sm-7">
                            <input class="form-check-input" type="radio" name="bo_paciente_contesta" id="bo_paciente_contesta_1" value="1" onclick="LlamadoPaciente.cambioPacienteContesta();">
                            <label class="form-check-label" for="bo_paciente_contesta_1">SI</label>
                            <input class="form-check-input" type="radio" name="bo_paciente_contesta" id="bo_paciente_contesta_0" value="0" onclick="LlamadoPaciente.cambioPacienteContesta();">
                            <label class="form-check-label" for="bo_paciente_contesta_0">NO</label>
                        </div>
                    </div>
                    
                    <div class="form-group" id="div_sintomas_rabia" style="display:none;">
                        <label for="bo_sintomas_rabia" class="control-label col-sm-3 form-check-inline">¿Animal presenta Síntomas de Rabia? (*)</label>
                        <div class="col-sm-7">
                            <input class="form-check-input" type="radio" name="bo_sintomas_rabia" id="bo_sintomas_rabia_1" value="1">
                            <label class="form-check-label" for="bo_sintomas_rabia_1">SI</label>
                            <input class="form-check-input" type="radio" name="bo_sintomas_rabia" id="bo_sintomas_rabia_0" value="0">
                            <label class="form-check-label" for="bo_sintomas_rabia_0">NO</label>
                        </div>
                    </div>
                            
                    <div class="form-group">
                        <label for="gl_observaciones" class="control-label col-sm-3">Observaciones</label>
                        <div class="col-sm-7">
                            <textarea type="text" class="form-control" placeholder="Observaciones"
                                      id="gl_observaciones" name="gl_observaciones" rows="4"></textarea>
                        </div>
                    </div>
                </div>
            </div>
                    
            <div class="top-spaced"></div>
            
            <div class="form-group text-right">
                <button type="button" id="guardar" onclick="LlamadoPaciente.guardarLlamado(this);" class="btn btn-success">
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