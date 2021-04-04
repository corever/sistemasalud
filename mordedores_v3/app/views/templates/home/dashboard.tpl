<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<section class="content-header">
    <h1><i class="fa fa-home"></i> <span>Inicio</span></h1>
</section>

<section class="content">
    <div class="row">
		{*
        <div class="col-md-12 col-lg-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Notificaciones (Con/Sin Domicilio conocido) {$nombre_mes}</h3>
                </div>
                <div class="box-body">
                    <div class="col-xs-12">
                        <div id="grafico_domicilios" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-lg-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Resultado de Visitas {$nombre_mes}</h3>
                </div>
                <div class="box-body">
                    <div class="col--12">
                        <div id="grafico_visitas_mordedores" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
        
        {if $perfil != 12}
            <!-- DATOS DE VISITAS -->
            <div class="{$class_col}" id="visitas" class="tab-pane">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Resultado de Visitas (Comunal) {$nombre_mes}</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            {include file='home/grillaVisitas.tpl'}
                        </div>
                    </div>
                </div>
            </div>

            {if $perfil_nacional == 1}
            <div class="col-md-12 col-lg-6" id="visitasRegion" class="tab-pane">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Resultado de Visitas (Regional) {$nombre_mes}</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            {include file='home/grillaVisitasRegion.tpl'}
                        </div>
                    </div>
                </div>
            </div>
            {/if}
        {/if}
        *}

    </div>
    
</section>
</body>