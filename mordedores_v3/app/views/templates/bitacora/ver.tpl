<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<section class="content">
    <!-- CABECERA -->
    {include file='bitacora/cabecera_expediente.tpl'}

    <div class="panel panel-primary">
        <div class="top-spaced"></div>

        <div class="panel-body">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#paciente">DATOS PACIENTE</a></li>
                <li><a data-toggle="tab" href="#visita">DATOS DE VISITA</a></li>
                {if $ver_mordedores === true}
                    <li><a data-toggle="tab" href="#animales">DATOS MORDEDOR</a></li>
                {/if}
                <li><a data-toggle="tab" href="#adjuntos">ADJUNTOS</a></li>
                <li><a data-toggle="tab" href="#historial">HISTORIAL</a></li>
            </ul>

            <div class="tab-content">

                <!-- DATOS PACIENTE  -->
                <div id="paciente" class="tab-pane fade in active">
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                {include file='bitacora/datosPaciente.tpl'}
                            </div>
                        </div>
                        <br>
                    </div>
                </div>

                <!-- DATOS DE VISITAS -->
                <div id="visita" class="tab-pane fade">
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                {include file='bitacora/grillaVisitas.tpl'}
                            </div>
                        </div>
                    </div>
                </div>
                
                {if $ver_mordedores === true}
                <!-- DATOS DE ANIMALES  -->
                <div id="animales" class="tab-pane fade">
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                {include file='bitacora/grillaAnimales.tpl'}
                            </div>
                        </div>
                        <br>
                    </div>
                </div>
                {/if}

                <!-- ADJUNTOS -->
                <div id="adjuntos" class="tab-pane fade">
                {include file='bitacora/adjuntarArchivo.tpl'}
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group" id="grilla-adjuntos">
                                {include file='bitacora/grillaAdjuntos.tpl'}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HISTORIAL EVENTOS -->
                <div id="historial" class="tab-pane fade">
                {include file='bitacora/insertarComentario.tpl'}
                    <div class="box-body">
                        <div class="col-md-12">
                            <div class="form-group">
                                {include file='bitacora/grillaHistorial.tpl'}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="top-spaced"></div>
        </div>
    </div>

    <div class="top-spaced"></div>
</section>

<script type="text/javascript">
    function habilitar() {
        $('#seccionComentario').toggle()
    }

    function habilitarAdjunto() {
        $('#seccionAdjunto').toggle()
    }
</script>