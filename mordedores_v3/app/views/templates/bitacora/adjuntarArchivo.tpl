<div class="box-body">
    <br>
    <div class="col-md-12">
        <div class="btn-group">
            <button type="button" id="aceptar" onclick="habilitarAdjunto()"
                    class="btn btn-primary btn-sm">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;Adjuntar Archivo
            </button>
        </div>
        <div class="form-group" id="seccionAdjunto" style="display:none">
            <section class="content-header" >
                <form class="form-horizontal" name="form-adjunto" id="form-adjunto" 
                      enctype="multipart/form-data" method="post" >
                    <input type="hidden" name="token_expediente" id="token_expediente" value="{$arr->gl_token}" />
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="tipoAdj">Tipo de Adjunto</label>
                                    <select class="form-control" id="tipoAdj" name="tipoAdj">
                                        <option value="0">Seleccione Tipo de Adjunto</option>
                                        {foreach $arr->arrTipoAdjunto as $tipoadj}
                                            <option value="{$tipoadj->id_adjunto_tipo}" >
                                                {$tipoadj->gl_nombre_tipo_adjunto}
                                            </option>
                                        {/foreach}
                                    </select>

                                    <br>
                                    <label class="control-label" for="archivo">Adjuntar documento</label>
                                    <input type="file" name="archivo" id="archivo" class="form-control" >

                                    <br>
                                    <label class="control-label">Comentario (opcional)</label>
                                    <textarea style="resize:none" class="form-control" value=""
                                              id="comentario_adjunto" name="comentario_adjunto"></textarea>
                                    <br>
                                </div>

                                <div class="btn-group">
                                    <button id="" type="button" 
                                            class="btn btn-success btn-sm "
                                            onclick="Bitacora.guardarNuevoAdjunto(this.form,this)">
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