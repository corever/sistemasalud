<section class="content-header">
    <h1><i class="fa fa-plus-circle"></i>&nbsp; Mantenedor Perfil </h1>
    <div class="col-md-12 text-right">
		<button type="button" class="btn btn-success pull-right" 
				onclick="xModal.open('{$smarty.const.BASE_URI}/Mantenedor/agregarPerfil','Agregar Perfil','45');">
				<i class="fa fa-plus"></i>&nbsp;&nbsp;Agregar Perfil</button>
    </div>
    <br/><br/>
</section>
				
<section class="content">
    <div class="box box-primary">
        <div class="box-body">
			<div class="table-responsive col-lg-12" data-row="10">
				<div id="contenedor-tabla">
					{include file="mantenedor_perfil/grilla.tpl"}
				</div>
		  	</div>
		</div>
	</div>
</section>