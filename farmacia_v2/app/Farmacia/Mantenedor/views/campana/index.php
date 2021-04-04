<section class="content-header">
    <h1>
        <i class="fa fa-flag"></i> 
        <?php if ($tipo == \App\Fiscalizaciones\Entity\DAOCampana::TIPO_CAMPANA) :?>
            Mantenedor Campañas
        <?php elseif ($tipo == \App\Fiscalizaciones\Entity\DAOCampana::TIPO_PROGRAMA) :?>
            Mantenedor Programas
        <?php endif;?>
        <small>Mantenedores</small>
    </h1>
</section>

<section class="content">
    <div class="box box-solid">
        <div class="box-header">
            <div class="text-right">
                <?php if ($tipo == \App\Fiscalizaciones\Entity\DAOCampana::TIPO_CAMPANA) :?>
                <button type="button" class="btn btn-success" onclick="Modal.open('<?php echo \Pan\Uri\Uri::getHost()?>/Mantenedor/Campana/agregarCampana','Agregar Campaña','lg');"><i class="fa fa-plus"></i> Agregar Campaña</button>
                <?php elseif ($tipo == \App\Fiscalizaciones\Entity\DAOCampana::TIPO_PROGRAMA) :?>
                <button type="button" class="btn btn-warning" onclick="Modal.open('<?php echo \Pan\Uri\Uri::getHost()?>/Mantenedor/Campana/agregarPrograma','Agregar Programa','lg');"><i class="fa fa-plus"></i> Agregar Programa</button>
                <?php endif;?>
            </div>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive small" id="contenedor-tabla-campanas"></div>
                </div>
            </div>
        </div>
    </div>
</section>
