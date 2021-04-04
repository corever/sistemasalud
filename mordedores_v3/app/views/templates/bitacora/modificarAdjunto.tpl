
<form id="form_modificar_adjunto" class="form-horizontal" enctype="multipart/form-data">

    <div class="panel panel-primary">
        <div class="panel-heading">Modificar Adjunto</div>
            <div class="panel-body">

                <input type="hidden" name="token_adjunto" id="token_adjunto" value="{$gl_token}" />
                <input type="hidden" name="nombre_txt" id="nombre_txt" value="{$gl_nombre}" />
                <div class="form-group" style="">
                    <label for="nombre" class="control-label col-sm-4">Nombre Actual</label>
                    <div class="col-sm-8">
                        <!-- <input type="text" name="gl_nombre" id="gl_nombre" placeholder="" class="form-control" content="{$gl_nombre}"> -->
                        <label for="nombre_adj">{$gl_nombre}</label>
                    </div>
                </div>

                <!-- <div class="form-group">
                    <label for="bo_estado" class="control-label col-sm-2">Estado</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="bo_estado" id="bo_estado_1" value="1">
                        <label class="form-check-label" for="inlineRadio1">Activo</label>
                        <input class="form-check-input" type="radio" name="bo_estado" id="bo_estado_0" value="0">
                        <label class="form-check-label" for="inlineRadio2">Inactivo</label>
                    </div>
                </div> -->

                <div class="form-group">

                    <label class="control-label col-sm-4" for="archivo_adj">Adjuntar documento</label>
                    <div class="col-sm-8">
                        <input type="file" name="archivo_adj" id="archivo_adj" class="form-control" >
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-4">Comentario (opcional)</label>
                    <div class="col-sm-8">
                        <textarea style="resize:none" class="form-control" value=""
                        id="comentario_adjunto" name="comentario_adjunto"></textarea>
                    </div>
                </div>

                <br/><br/>
                <div class="form-group clearfix  text-right">
                    <button type="button" id="guardar" class="btn btn-success" onclick="Bitacora.modificarAdjunto(this.form,this)">
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
