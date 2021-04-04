<section class="content">
    <!-- CABECERA -->
    {*include file='bitacora/cabecera_expediente.tpl'*}
    
    <form id="form_contacto" class="form-horizontal" enctype="multipart/form-data">
        
        {if $arr->arrContactoPac}
            {foreach from=$arr->arrContactoPac key=key item=itm}
                {if $itm.id_tipo_contacto == 2}
                    {assign var=gl_telefono_paciente value=$itm.json_datos.telefono_movil}
                {/if}
            {/foreach}
        {/if}
                
        <div class="form-group">
            <div class="col-lg-12 col-sm-12">
                <div class="alert alert-info">
                    &ensp;&ensp;&ensp;&ensp;&ensp;Informar a Paciente del cambio en el protocolo de su Vacunación
                </div>
            </div>
        </div>
        
        <div class="panel panel-primary">
            <div class="panel-heading">
                Detalles de Acción
            </div>
            <div class="panel-body" id="div_body_contacto">
                <div class="form-group">
                    <label for="gl_nombre_paciente" class="control-label col-md-3 col-sm-5 col-xs-12">Nombre</label>
                    <div class="col-lg-4 col-md-6 col-xs-5">
                        <input id="gl_nombre_paciente" name="gl_nombre_paciente" class="form-control" type="text" value="{$arr->nombre_paciente} {$arr->apellidos_paciente}" readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label for="gl_telefono_paciente" class="control-label col-md-3 col-sm-5 col-xs-12">Tel&eacute;fono</label>
                    <div class="col-lg-3 col-sm-4 col-xs-5">
                        <input id="gl_telefono_paciente" name="gl_telefono_paciente" class="form-control" type="text" value="{$gl_telefono_paciente}" readonly>
                    </div>
                </div>
                
                <div class="form-group chkcontacto">
                    <label for="chkcontacto" class="control-label col-md-3 col-sm-5 col-xs-12">¿Pudo contactar al Paciente?</label>
                    <div class="col-sm-1 col-xs-2">
                        <input id="chkcontacto" type="checkbox" value="1" onclick="toogleFechaHoraContacto()">
                    </div>
                </div>
                <div class="form-group fechahoracontacto" style="display:none;">
                    <label for="fechacontacto" class="control-label col-md-3 col-sm-5 col-xs-12">Fecha de Contacto a Paciente</label>
                    <div class='col-sm-2 col-xs-5'>
                        <div class="input-group">
                            <input for="fechacontacto" type='text' class="form-control" id='fechacontacto' name='fechacontacto'
                                   onblur="validarVacio(this, 'Por favor Ingrese Fecha y Hora de Contacto')" value="{$smarty.now|date_format:"%d/%m/%Y"}">
                            <span class="help-block hidden fa fa-warning"></span>
                            <span class="input-group-addon"><i class="fa fa-calendar" onClick="$('#fechacontacto').focus();"></i></span>

                        </div>
                    </div>
                    <label for="horacontacto" class="control-label col-md-2 col-sm-5 col-xs-12">Hora de Contacto a Paciente</label>
                    <div class="col-sm-2 col-xs-5">
                        <div class="input-group">
                            <input for="horacontacto" type="text" name="horacontacto" id="horacontacto" value="{$smarty.now|date_format:"%H:%M"}" 
                                   onblur="validarVacio(this, 'Por favor Ingrese Fecha y Hora de Contacto')" placeholder="Hora de Contacto" class="form-control">
                            <span class="help-block hidden"></span>
                            <span class="input-group-addon"><i class="fa fa-clock-o" onClick="$('#horacontacto').focus();"></i></span>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="gl_observaciones_mordedor" class="control-label col-sm-3 col-xs-5">Observaciones</label>
                    <div class="col-sm-6">
                        <textarea type="text" class="form-control" id="gl_observaciones_alarma" name="gl_observaciones_alarma" placeholder="Ingrese Observaciones" rows="4"></textarea>
                    </div>
                </div>

                <div class="row text-right">
                    <input type="text" class="form-control hidden" id="gl_token" name="gl_token" value="{$gl_token}">
                    <input type="text" class="form-control hidden" id="id_alarma" name="id_alarma" value="{$id_alarma}">
                    <button type="button" id="guardar" onclick="cambiarEstadoAlarma({$id_alarma})" class="btn btn-success">
                        <i class="fa fa-save"></i>  Guardar
                    </button>&nbsp;
                    <button type="button" id="cancelar"  class="btn btn-default" 
                            onclick="xModal.close()">
                        <i class="fa fa-remove"></i>  Cancelar
                    </button>
                </div></br>

            </div>
        </div>
    </form>

    <div class="top-spaced"></div>
</section>