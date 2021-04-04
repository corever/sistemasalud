<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Farmacias</a></li>
				<li class="breadcrumb-item active">Empresa Farmac&eacute;utica</li>
			</ol>
			</div>
		</div>
	</div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row my-3">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card card-primary">
                    <div class="card-header">Filtros</div>
                    <div class="card-body">
                        <form id="formMaestroEmpresa">
                            <div class="form-group">
                                <label>Estado:</label>
                                <div class="form-check">
                                    <label class="form-check-label" for="radio1">
                                        <input type="radio" class="form-check-input" id="radio1" name="farmacia_estado" value="1" checked> Habilitadas
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="radio2">
                                        <input type="radio" class="form-check-input" id="radio2" name="farmacia_estado" value="0" > Deshabilitadas
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label" for="radio3">
                                        <input type="radio" class="form-check-input" id="radio3" name="farmacia_estado" value="" > Todas
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-sm btn-success" id="btn_buscar"
						    data-toggle="tooltip" title="Buscar Empresa"><i class="fa fa-search"></i>&nbsp;&nbsp;Buscar
						</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="card card-primary">
                    <div class="card-header">Accesos Directos</div>
                    <div class="card-body">
                        <button type="button" class="btn btn-sm btn-success" onclick="maestro_empresa.crear();"
                        data-toggle="tooltip" title="Crear Empresa"><i class="fa fa-plus"></i>&nbsp;&nbsp;Crear Empresa Farmac&eacute;utica
                    </button>
                    <!-- onclick="xModal.open('<?php //echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Farmacias/empresa/crearEmpresa/','Crear Empresa','90','modal_crearEmpresa');" -->
                    </div>
                </div>
                <div class="card card-primary">
                    <div class="card-header">Empresas Farmac&eacute;uticas</div>
                    <div class="card-body">
                        <label for="fname">Resumen:</label>

                    </div>
                </div>
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card card-primary">
                    <div class="card-header">Listado de Empresas Farmac&eacute;uticas</div>
                    <div class="card-body" id="contenedor_grilla_empresa">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>