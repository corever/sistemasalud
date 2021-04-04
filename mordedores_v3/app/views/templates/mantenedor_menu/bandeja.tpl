<section class="content-header">
    <h1><i class="fa fa-list"></i>&nbsp; Mantenedor Menú </h1>
    <div class="col-md-12" align="right">
		<button type="button" class="btn btn-success" 
				onclick="xModal.open('{$smarty.const.BASE_URI}/Mantenedor/agregarMenuPadre','Agregar Menú Padre','45');">
				<i class="fa fa-plus"></i> Agregar Menú Padre</button>
		&nbsp;&nbsp;
		<button type="button" class="btn btn-success" 
				onclick="xModal.open('{$smarty.const.BASE_URI}/Mantenedor/agregarMenuOpcion','Agregar Menú Opción','45');">
				<i class="fa fa-plus"></i> Agregar Menú Opción</button>
    </div>
    <br/><br/>
</section>

<section class="content">
    <div class="box box-primary">
        <div class="box-body">
			<div class="table-responsive col-lg-12" data-row="10">
				<div id="contenedor-tabla">
					{include file="mantenedor_menu/grilla.tpl"}
				</div>
		  	</div>
		</div>
	</div>
</section>