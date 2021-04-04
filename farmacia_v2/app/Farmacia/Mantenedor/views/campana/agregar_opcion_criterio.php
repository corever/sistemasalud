<div class="">
    <div class="box box-solid">
        <div class="box-body">
            <div class="col-xs-12">
                <form id="formOpcionCriterio" class="form-horizontal">
                    <input type="text" class="hidden" id="opcion" name="opcion" value="<?php echo $opcion ?>"/>

                    <div class="form-group top-spaced">
                        <label for="gl_opciones" class="col-sm-12"> Agregue las Opciones separadas por una coma (",")</label>
                        <div class="col-sm-12">
                            <div class="input-group">
                            <?php if (isset($opciones['opciones_select'])) :?>
                            <input type="text" class="form-control" id="gl_opciones" name="gl_opciones" placeholder="Opcion1, Opcion2, Opcion3, ..." value="<?php echo implode(',', $opciones['opciones_select'])?>"/>
                            
                            <?php else:?>
                                <input type="text" class="form-control" id="gl_opciones" name="gl_opciones" placeholder="Opcion1, Opcion2, Opcion3, ..." />
                            <?php endif;?>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-success" onclick="agregarOpcionesCriterio(this.form, this);"><i class="fa fa-save"></i> Guardar</button>
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <div class="form-group" id="contenedor-opciones-agregadas">
                            <?php if (isset($opciones['opciones_select'])) :?>
                                <?php echo \pan\Kore\View::fetchIt('campana/grilla_opciones_criterio', array('arrEspecifico' => $opciones)); ?>
                            <?php endif;?>
                        </div>
                    </div>

                    <div class="modal-footer top-spaced" id="btn-terminar">
                        <button class="btn btn-danger" type="button" onclick="xModal.close();" id="btn_cerrar"><i class="fa fa-close"></i>&nbsp; Cerrar </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>