<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />

<section class="content-header">
    <h1><i class="fa fa-book"></i>&nbsp; {$origen} </h1>
    <div class="col-md-12 text-right">
		{if $bo_agrega == 1}
        <button type="button" id="ingresar" onclick="location.href = '{$base_url}/Paciente/nuevo'"
                class="btn btn-success">
            <i class="fa fa-plus"></i>&nbsp;&nbsp;Nuevo Registro
        </button>
		{/if}
    </div>
    <br/>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-body" id="contenedor_grilla_registros">
            {include file='grilla/grilla_pacientes_supervisor.tpl'}
        </div>
    </div>
</section>