<div class="box-body">
    <br>
    <div class="col-md-12">
        <div class="btn-group">
            <button type="button" id="nuevoComentario" onclick="habilitar()"
                    class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;Nuevo Comentario
            </button>
        </div>
        <div class="form-group" id="seccionComentario" style="display: none;">
            <section class="content-header" >
                <form class="form-horizontal" name="form-historial" id="form-historial" 
                      enctype="multipart/form-data" method="post" >
                    <input type="hidden" name="token_expediente" id="token_expediente" value="{$arr->gl_token}" />
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="tipoComent">Tipo de Comentario (*)</label>
                                    <select class="form-control" id="tipoComent" name="tipoComent"
                                            onchange="{literal}if(this.value==3){$('#div_otro_comentario').show();} else {$('#div_otro_comentario').hide();}{/literal}">
                                        <option value="0">Seleccione Tipo de Comentario</option>
                                        {foreach $arr->arrTipoComentario as $tipoComent}
                                            <option value="{$tipoComent->id_comentario_tipo}" >
                                                {$tipoComent->gl_nombre_tipo_comentario}
                                            </option>
                                        {/foreach}
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                        <div class="row" id="div_otro_comentario" style="display:none;">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="otroTipoComent">(Otro tipo de comentario) (*)</label>
                                    <input type="text" class="form-control" id="otroTipoComent" name="otroTipoComent">
                                </div>
                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Comentario Inspección (*)</label>
                                    <textarea class="form-control" rows="3" cols="50" value=""
                                              id="comentario" name="comentario"></textarea>
                                    <br>
                                </div>

                                <div class="btn-group">
                                    <button id="" type="button" 
                                            class="btn btn-success btn-sm "
                                            onclick="Bitacora.guardarNuevoComentario(this.form,this)">
                                        <i class="fa fa-save"></i>&nbsp;&nbsp;Guardar
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>