<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>

<section class="content-header">
    <h1><i class="fa fa-bar-chart"></i> <span>{$origen}</span></h1>
</section>

<section class="content">
    {if $id_perfil == 13}
        {include file="reportes/index_comunal.tpl"}
    {elseif $id_perfil == 15}
        {include file="reportes/index_servicio_salud.tpl"}
    {else}
        {include file="reportes/index.tpl"}
    {/if}
    <div class="box box-primary">
        <div class="box-body">
            <div class="row">&nbsp;</div>
            
            {if $id_perfil == 15 or $id_perfil == 13}
                <div class="col-md-12 col-lg-6">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Notificaciones por Establecimiento de Salud</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-xs-12">
                                <div id="contenedor-tabla-establecimientos">
                                    {include file='reportes/grillaEstablecimientos.tpl'}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {else}
                <div class="col-md-12 col-lg-6">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Total Registros : Mordedores con domicilio conocidos</h3>
                        </div>
                        <div class="box-body">
                            <div class="col-xs-12">
                                <div id="grafico_visitas_mordedores" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
            
            <div class="col-md-12 col-lg-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Resultado Visitas : Notificaciones Con/Sin Domicilio conocido</h3>
                    </div>
                    <div class="box-body">
                        <div class="col-xs-12">
                            <div id="grafico_domicilios" style="height: 400px;"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>