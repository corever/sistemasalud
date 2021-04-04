<section class="content-header">
   <div class="container-fluid">
      <div class="row mb-2">
         <div class="col-sm-6">
            <button type="button" class="btn bg-teal btn-xs mt-2"
            onclick="xModal.open('<?php echo \Pan\Uri\Uri::getBaseUri(); ?>Farmacia/Mantenedor/Medico/agregarSucursal/<?php echo $medico->id_usuario;?>','Agregar Sucursal Medico','90');">
            <i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo \Traduce::texto("Agregar Sucursal Medico"); ?></button>

         </div>
      </div>
   </div>
   <!-- /.container-fluid -->
</section>

<section class="content">
   <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h3 class="card-title"><?php echo \Traduce::texto("Lista de Sucursales"); ?></h3>
                </div>
                <div class="card-body">
                  <div class="table-responsive col-lg-12" data-row="10">
                      <div id="contenedor-tabla-sucursal">
<table class="table table-hover table-striped table-bordered dataTable no-footer" id="grilla-sucursal-medicos" width="100%">
		<thead>
				<tr>
					<th width="20%"><?php echo \Traduce::texto("Region"); ?></th>
					<th width="20%"><?php echo \Traduce::texto("Comuna"); ?></th>
					<th width="20%"><?php echo \Traduce::texto("Dirección"); ?></th>
					<th width="20%"><?php echo \Traduce::texto("Telefono"); ?></th>
					<th width="20%"><?php echo \Traduce::texto("Opciones"); ?></th>
				</tr>
		</thead>
		<tbody>
			<?php //if (isset($arr)): ?>
				<?php foreach ($arr as $key => $itm): ?>
					<tr>
						<td class="text-center"><?php echo $itm->gl_region; ?></td>
						<td class="text-center"><?php echo $itm->gl_comuna; ?></td>
						<td class="text-center"><?php echo $itm->gl_direccion; ?></td>
						<td class="text-center">(<?php echo $itm->id_codfono; ?>) <?php echo $itm->gl_telefono; ?></td>
						<td class="text-center">
								<button type="button" class="btn btn-xs btn-success"
												onclick="xModal.open('<?php echo \pan\uri\Uri::getHost() ?>Farmacia/Mantenedor/Medico/editarSucursal/<?php echo $itm->id_sucursal ?>','<?php echo addslashes(\Traduce::texto("Editar Medico")) ?> <b><?php echo $item->gl_nombre_completo ?></b>','90');"
												data-toggle="tooltip" title="<?php echo \Traduce::texto("Editar Medico") ?>"><i class="fa fa-edit"></i>
								</button>

							<?php if($itm->bo_activo == 1){ ?>
							<button type="button" class="btn btn-xs btn-danger"
											onclick="MantenedorMedico.habilitarSucursal('<?php echo $itm->id_sucursal ?>',0);"
											data-toggle="tooltip" title="<?php echo \Traduce::texto("Deshabilitar") ?>"><i class="fas fa-ban"></i>
							</button>

						 	<?php }else{ ?>
							<button type="button" class="btn btn-xs btn-success"
											onclick="MantenedorMedico.habilitarSucursal('<?php echo $itm->id_sucursal ?>',1);"
											data-toggle="tooltip" title="<?php echo \Traduce::texto("Habilitar") ?>"><i class="fas fa-check"></i>
							</button>

							<?php } ?>
						</td>


					</tr>
				<?php endforeach; ?>
			<?php //endif; ?>
		</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
