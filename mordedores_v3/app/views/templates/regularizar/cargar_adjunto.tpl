<div class="row" style="width: 100%; margin-left:auto;margin-right:auto; max-width: 100%;">
    <div class="col-xs-10">	
        <form class="form-horizontal" name="form-adjunto" id="form-adjunto" method="post" enctype="multipart/form-data"> 
            <input type="text" name="cont_mordedor" id="cont_mordedor" value="{$cont_mordedor}" class="hidden"/>
            <input type="text" name="id_tipo_adjunto" id="id_tipo_adjunto" value="{$id_tipo_adjunto}" class="hidden"/>
            <div class="form-group top-spaced">
                <label for="" class="control-label col-xs-2">Adjunto</label>
                <div class="col-xs-10">
                    <input type="file" name="adjunto" id="adjunto" class="form-control"/>
                </div>
            </div>

            {if isset($success)}
                {if $success == 1}
                    <div class="alert alert-success top-spaced">{$mensaje}</div>
                {else}
                    <div class="alert alert-danger top-spaced">{$mensaje}</div>
                {/if}
            {/if}

            <div class="top-spaced col-xs-offset-2">
                <button class="btn btn-sm btn-success" type="button" onclick="AdjuntoRegularizar.guardarAdjunto(this.form, this);"><i class="fa fa-save"></i> Guardar Adjunto</button>
                <button class="btn btn-sm btn-danger" type="button" onclick="parent.xModal.close();"><i class="fa fa-close"></i> Cerrar Ventana</button>
            </div>
        </form>
    </div>
</div>
