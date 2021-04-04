<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <!--<h1>Maestro de Menú</h1>-->
            <!-- float-sm-right-->
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="javascript:void(0)">Farmacia</a></li>
               <li class="breadcrumb-item active"><?php echo \Traduce::texto("Maestro de Menú"); ?></li>
            </ol>
         </div>
         <div class="col-sm-6">
            <button type="button" class="btn bg-teal btn-xs mt-2" style="float:right;"
                    onclick="xModal.open('<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Maestro/Menu/agregarMenu','<?php echo \Traduce::texto('Agregar Menú'); ?>','lg');">
                <i class="fa fa-plus"></i> <?php echo \Traduce::texto("Agregar Menú"); ?></button>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?php echo \Traduce::texto("Busqueda Avanzada"); ?></h3>
                    </div>
                    <div class="card-body" style="display: block;">
                        <form id="formBuscar" action="#" method="post" class="form-horizontal">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group row">
                                        <label class="form-label col-3"><?php echo \Traduce::texto("Nombre"); ?></label>
                                        <div class="col-9">
                                            <input class="form-control form-control-sm" id="gl_nombre" name="gl_nombre"
                                           value="<?php echo (isset($arrFiltros['gl_nombre']))?$arrFiltros['gl_nombre']:""; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <label class="form-label col-3"><?php echo \Traduce::texto("URL"); ?></label>
                                        <div class="col-9">
                                            <input class="form-control form-control-sm" id="gl_url" name="gl_url"
                                           value="<?php echo (isset($arrFiltros['gl_url']))?$arrFiltros['gl_url']:""; ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group row">
                                        <label class="form-label col-3"><?php echo \Traduce::texto("Modulo"); ?></label>
                                        <div class="col-9">
                                            <select class="form-control form-control-sm" id="id_modulo" name="id_modulo" >
                                                <?php if (!isset($arrModulo) || count((array) $arrModulo) == 0 || count((array) $arrModulo) > 1) : ?>
                                                    <option value="0"><?php echo \Traduce::texto("Todos"); ?></option>
                                                <?php endif; ?>
                                                <?php if (isset($arrModulo) && is_array($arrModulo)) : foreach ($arrModulo as $key => $modulo) : ?>
                                                        <option value="<?php echo $modulo->m_m_id; ?>"
                                                            <?php echo (isset($arrFiltros['id_modulo']) && $arrFiltros['id_modulo'] == $modulo->m_m_id)?"selected":""; ?>
                                                                ><?php echo $modulo->nombre_modulo; ?></option>
                                                <?php endforeach;
                                                endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row float-right">
                                <div class="col-auto">
                                    <button type="button" id="limpiar" class="btn btn-default btn-xs" onclick="MaestroMenu.limpiarFiltros();">
                                        <i class="fas fa-sync-alt"></i> <?php echo \Traduce::texto("Limpiar Filtros"); ?>
                                    </button>
                                </div>
                                <div class="col-auto">
                                    <button type="button" id="buscar" class="btn bg-teal btn-xs" onclick="MaestroMenu.buscar();">
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
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title"><?php echo \Traduce::texto("Lista de Menus"); ?></h3>
                </div>
                <div class="card-body">
                <div class="table-responsive col-lg-12" data-row="10">
                        <div id="contenedor-tabla">
                           Cargando..
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>
   </div>
</section>