<link href="{$static}/template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$static}/template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>

<form id="formResultadoIsp" class="form-horizontal" enctype="multipart/form-data">
    <div class="panel panel-primary">
        <div class="panel-heading">Guardar Visita Resultado</div>
        <div class="panel-body" id="div_body_animal">

            <div class="top-spaced"></div>
            
            <div class="form-group" id="div_resultado_isp">
                <div class="col-md-12">
                    <input type="text" value="{$folio_mordedor}" id="folio_mordedor" name="folio_mordedor" class="hidden">
                            
                    <div class="form-group">
                        <label for="id_region_animal" class="control-label col-sm-3 required">Resultado</label>
                        <div class="col-sm-4">
                            <select class="form-control" id="id_tipo_visita_resultado" name="id_tipo_visita_resultado">
                                <option value="0">Seleccione Resultado</option>
                                {foreach $arrResultadoTipo as $item}
                                    <option value="{$item->id_tipo_resultado_isp}">{$item->gl_nombre}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>
                            
                    <div class="form-group">
                        <label for="gl_observaciones_resultado_visita" class="control-label col-sm-3 required">Observaciones</label>
                        <div class="col-sm-7">
                            <textarea type="text" class="form-control" placeholder="Observaciones Resultado Visita"
                                      id="gl_observaciones_resultado_visita" name="gl_observaciones_resultado_visita" rows="4"></textarea>
                        </div>
                    </div>
                </div>
            </div>
                    
            <div class="top-spaced"></div>
            
            <div class="form-group text-right">
                <button type="button" id="guardar" onclick="ResultadoVisita.guardarResultadoVisita(this);" class="btn btn-success">
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