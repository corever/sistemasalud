<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>

<section class="content-header">
    <h1><i class="fa fa-tasks"></i> <span>{$origen}</span></h1>
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
        <div class="box-header">
            <h3 class="box-title" style="width: 100%">Informes</h3>
        </div>
        
        <div class="box-body">
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-xs-1">&nbsp;</div>
                        <div class="col-xs-10">
                            <b>* Chipeados con Domicilio Conocido = (Animales Chipeados/Animales Con Domicilio Conocido) * 100 <br>
                            {* * Chipeados sin Domicilio Conocido = (Animales Chipeados/Animales Sin Domicilio Conocido) * 100 <br>*}
                            * Chipeados Notificados = (Animales Chipeados/Animales Notificados) * 100 <br></b>
                        </div>
                    </div>
                    
                    <div class="row">&nbsp;</div>
                    
                    <div class="col-xs-1">&nbsp;</div>
                    <div id="contenedor-tabla-informe" class="col-xs-12">
                        {include file="reportes/grilla_informe.tpl"}
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="col-md-12">
                    <h3>Visitas por Comuna</h3>
                    <div id="contenedor-tabla-visitas">
                        {include file='home/grillaVisitas.tpl'}
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="col-md-12">
                    <h3>Visitas por Oficinas</h3>
                    <div id="contenedor-tabla-visitas-oficinas">
                        {include file='reportes/grillaVisitasOficinas.tpl'}
                    </div>
                </div>
            </div>
            {if false}
            <div class="col-md-12">
                <div class="col-md-12">
                    <h3>Establecimientos que notifican</h3>
                    <div id="contenedor-tabla-establecimientos-notifican">
                        {include file='reportes/establecimientosNotifican.tpl'}
                    </div>
                </div>
            </div>
            {/if}
            <div class="row">
                
            </div>

        </div>
    </div>
</section>

<!--section class="content">   
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title" style="width: 100%">Visitas</h3>
        </div>
        
        <div class="box-body">
            <div class="row">
                <div class="col-xs-1">&nbsp;</div>
                <div id="contenedor-tabla-visitas" class="col-xs-10">
                    {include file='home/grillaVisitas.tpl'}
                </div>
            </div>
        </div>
    </div>
</section>

<section class="content">   
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title" style="width: 100%">Visitas por Oficinas</h3>
        </div>
        
        <div class="box-body">
            
        </div>
    </div>
</section-->