<style>
	label{
		font-weight: 100  !important;
		font-size  : 14px !important;
	}
</style>

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
             <!--<h1>Mantenedor de Perfil</h1>-->
             <!-- float-sm-right-->
             <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="javascript:void(0)">PAHO::HOPE</a></li>
               <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo \Traduce::texto("Tablas Tipo"); ?></a></li>
               <li class="breadcrumb-item active"><?php echo \Traduce::texto("Tipos de Formularios"); ?></li>
            </ol>
         </div>
         <div class="col-sm-6">
            <?php 
                //TABLA_FORMULARIO_TIPO
                $params = '_DAOFormulariosTipo/gl_nombre';
            ?>
            <button type="button" class="btn bg-teal btn-xs mt-2" style="float:right;"
				onclick="xModal.open('<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Mantenedor/TablasTipo/desplegarAgregarTipo/<?php echo $params; ?>','<?php echo \Traduce::texto('Agregar Tipo'); ?>','md');">
                <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo \Traduce::texto("Agregar Tipo"); ?>
            </button>
            <a data-toggle="collapse"  href="#collapseFilter" aria-expanded="true" class="btn btn-xs btn-default mt-2 mr-2" style="float:right;">
                <i class="fas fa-filter"></i> <?php echo \Traduce::texto("Filtros"); ?>
            </a>
         </div>
      </div>
   </div>
</section>

<!-- Filtros de Busqueda -->
<section id="collapseFilter" class="content panel-collapse collapse in">
   <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo \Traduce::texto("Busqueda Avanzada"); ?></h3>
                    </div>
                    <div class="card-body" style="display: block;">
                        <form id="formBuscar" action="#" method="post" class="form-horizontal">
                            <div class="row">
                                <div class="col-3">
                                    <label class="form-label"><?php echo \Traduce::texto("Estado"); ?></label>
                                    <select class="form-control form-control-sm" id="bo_activo" name="bo_activo">
                                        <option value=""><?php echo \Traduce::texto("Seleccione"); ?></option>
                                        <?php 
                                            $arrEstados = array(\Traduce::texto('Deshabilitado'), \Traduce::texto('Activo'));
                                            foreach ($arrEstados as $key => $item) : ?>
                                            <option value="<?php echo $key ?>"><?php echo $item ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span class="help-block hidden fa fa-warning"></span>
                                </div>
                            </div>
                            <div class="row float-right">
                                <div class="col-auto">
                                    <button type="button" id="limpiar" class="btn btn-default btn-xs" onclick="MantenedorTablasTipo.limpiarFiltros();"">
                                        <i class="fas fa-sync-alt"></i> <?php echo \Traduce::texto("Limpiar Filtros"); ?>
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <button type="button" id="buscar" class="btn bg-teal btn-xs" onclick="MantenedorTablasTipo.cargarGrillaTiposFormulario($('#formBuscar'));">
                                        <i class="fa fa-search"></i> <?php echo \Traduce::texto("Buscar"); ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
   </div>
</section>


<section class="content">
   <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title"><?php echo \Traduce::texto("Lista Tipos de Formularios"); ?></h3>
                </div>
                <div class="card-body">
                <div class="table-responsive col-lg-12" data-row="10">
                    <div id="dvGrilla">
                    </div>
                </div>
                </div>
            </div>
        </div>
      </div>
   </div>
</section>