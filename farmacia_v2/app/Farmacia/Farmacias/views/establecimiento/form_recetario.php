<!-- TODO:	Tipo Botiquin publico - check "Ver en el Mapa" -->
<div class="row top-spaced">
	<div class="col-2">
		<label for="id_recetario_tipo" class="control-label">
			Detalle Recetario
		</label>
	</div>
	<div class="col-4">
		<select class="form-control" id="id_recetario_tipo" name="id_recetario_tipo">
			<option value="0">Seleccione</option>
			<?php foreach($arr_recetario_tipo as $item): ?>
				<option value="<?php echo $item->id_recetario ?>" <?php echo ($establecimiento->id_recetario_tipo == $item->id_recetario)?"selected":""; ?> >
					<?php echo $item->gl_nombre ?>
				</option>
			<?php endforeach;?>
		</select>
	</div>
	
	<div class="col-6 row" id="div_chk_recetario_centralizado" style="display:<?php if($establecimiento->id_recetario_tipo != 1):?>none;<?php else:?>block;<?php endif;?>">
		<div class="col-4 text-right" style="font-size:14px;">
			<input type="checkbox" class="checkbox" id="bo_recetario_en_local" name="bo_recetario_en_local"
			<?php if($establecimiento->local_tiene_recetario == "1"):?> checked <?php endif; ?>/>
		</div>
	
		<div class="col-4">
			<label for="bo_recetario_en_local" class="control-label">
				En el Local
			</label>
		</div>
	</div>
</div>

<div class="row top-spaced">
	<div class="col-2">
		<label for="chk_tipo_recetas" class="control-label">
			Tipo de Recetas
		</label>
	</div>
	<div class="col-8">
		<?php foreach( $arr_recetario_detalle as $item):?>
			<div class="col-md-12">
				<label class="checkbox-inline" style="margin-left:0px !important;">
					<input type="checkbox" name="chk_tipo_recetas" id="bo_receta_<?php echo $item->gl_letra_tipo;?>" value="<?php echo $item->id;?>">
					&nbsp;&nbsp;
					<span class="col-md-4">
						<b><?php echo $item->gl_letra_tipo;?></b>
						<?php if(strlen($item->gl_letra_tipo) == 1):?>
							&nbsp;
						<?php endif;?>
					</span>
					<span class="col-md-4">
						- &nbsp;&nbsp;<?php echo ucwords(mb_strtolower($item->gl_nombre_tipo));?>.
					</span>
				</label>
			</div>
		<?php endforeach;?>
	</div>
</div>
