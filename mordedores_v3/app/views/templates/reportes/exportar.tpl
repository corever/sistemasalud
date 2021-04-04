<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.STATIC_FILES}template/plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$static}css/plugins/select2.min.css"/>

<section class="content-header">
    <h1><i class="fa fa-book"></i>&nbsp; {$origen} </h1>
    <br/><br/>
</section>

<section class="content">
    <div class="box box-primary">
        {include file="reportes/index_exportar.tpl"}
    </div>

    <div class="top-spaced"></div>

    <div class="box box-primary">
        <div class="box-header">Exportar</div>
        <div class="box-body">
        </div>
    </div>
</section>