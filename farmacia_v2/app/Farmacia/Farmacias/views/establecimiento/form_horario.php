<div style="display: block;overflow-x: auto;white-space: nowrap;">
	<table style='width:100%' class='table table-striped border-gray' id="tabla_horarios">
		<thead>
			<th class="bg-primary"></th>
			<th id='lunes' name ='lunes' class='lunes row_lunes bg-primary text-center'>
				<div class="row">
					<div class="col-md-10 col-sm-10" style="margin-top:6px;font-size:14px;">
						<b>Lunes</b>
					</div>
					<div class="col-md-2 col-sm-2 text-right">
						<button type='button' class='btn btn-xs btn-success pull-right' onclick='Horario.copiarHorario("lunes");'>
							&nbsp;<i style="font-size:12px;" class='fa fa-arrow-right'></i>&nbsp;
						</button>
					</div>
				</div>
			</th>
			<th id='martes' name ='martes' class='martes row_martes bg-primary text-center'>
				<div class="row">
					<div class="col-md-10 col-sm-10" style="margin-top:6px;font-size:14px;">
						<b>Martes</b>
					</div>
					<div class="col-md-2 col-sm-2 text-right">
						<button type='button' class='btn btn-xs btn-success pull-right' onclick='Horario.copiarHorario("martes");'>
							&nbsp;<i style="font-size:12px;" class='fa fa-arrow-right'></i>&nbsp;
						</button>
					</div>
				</div>
			</th>
			<th id='miercoles' name ='miercoles' class='miercoles row_miercoles bg-primary text-center'>
				<div class="row">
					<div class="col-md-10 col-sm-10" style="margin-top:6px;font-size:14px;">
						<b>Miercoles</b>
					</div>
					<div class="col-md-2 col-sm-2 text-right">
						<button type='button' class='btn btn-xs btn-success pull-right' onclick='Horario.copiarHorario("miercoles");'>
							&nbsp;<i style="font-size:12px;" class='fa fa-arrow-right'></i>&nbsp;
						</button>
					</div>
				</div>

			</th>
			<th id='jueves' name ='jueves' class='jueves row_jueves bg-primary text-center'>
				<div class="row">
					<div class="col-md-10 col-sm-10" style="margin-top:6px;font-size:14px;">
						<b>Jueves</b>
					</div>
					<div class="col-md-2 col-sm-2 text-right">
						<button type='button' class='btn btn-xs btn-success pull-right' onclick='Horario.copiarHorario("jueves");'>
							&nbsp;<i style="font-size:12px;" class='fa fa-arrow-right'></i>&nbsp;
						</button>
					</div>
				</div>

			</th>
			<th id='viernes' name ='viernes' class='viernes row_viernes bg-primary text-center'>
				<div class="row">
					<div class="col-md-10 col-sm-10" style="margin-top:6px;font-size:14px;">
						<b>Viernes</b>
					</div>
					<div class="col-md-2 col-sm-2 text-right">
						<button type='button' class='btn btn-xs btn-success pull-right' onclick='Horario.copiarHorario("viernes");'>
							&nbsp;<i style="font-size:12px;" class='fa fa-arrow-right'></i>&nbsp;
						</button>
					</div>
				</div>

			</th>
			<th id='sabado' name ='sabado' class='sabado row_sabado bg-primary text-center'>
				<div class="row">
					<div class="col-md-10 col-sm-10" style="margin-top:6px;font-size:14px;">
						<b>Sabado</b>
					</div>
					<div class="col-md-2 col-sm-2 text-right">
						<button type='button' class='btn btn-xs btn-success pull-right' onclick='Horario.copiarHorario("sabado");'>
							&nbsp;<i style="font-size:12px;" class='fa fa-arrow-right'></i>&nbsp;
						</button>
					</div>
				</div>

			</th>
			<th id='domingo' name ='domingo' class='domingo row_domingo bg-primary text-center'>
				<div class="row">
					<div class="col-md-10 col-sm-10" style="margin-top:6px;font-size:14px;">
						<b>Domingo</b>
					</div>
					<div class="col-md-2 col-sm-2 text-right">
						<button type='button' class='btn btn-xs btn-success pull-right' onclick='Horario.copiarHorario("domingo");'>
							&nbsp;<i style="font-size:12px;" class='fa fa-arrow-right'></i>&nbsp;
						</button>
					</div>
				</div>

			</th>
			<th id='festivo' name ='festivo' class='festivo row_festivo bg-primary text-center'>
				<div class="row">
					<div class="col-md-10 col-sm-10" style="margin-top:6px;font-size:14px;">
						<b>Festivo</b>
					</div>
					<div class="col-md-2 col-sm-2 text-right">
					</div>
				</div>

			</th>
		</thead>
		<tbody>
			<?php foreach($arr_horario as $horario):?>
			<tr align="center" <?php if($horario["bo_no_continuado"]):?>
				class="no_continuado" style="display:none;"
			<?php endif;?>>
				<td nowrap><b><?php echo $horario["gl_nombre"];?></b></td>
				<td class='lunes row_lunes'>
					<div class='input-group' style="min-width:110px">
						<input class='form-control timepicker<?php if($horario["bo_no_continuado"]):?> ipt_no_continuado<?php endif;?>' id='<?php echo $horario["id"];?>_lunes' name='lunes_<?php echo $horario["id"];?>' value='' readonly required_lunes></input>
						<span class='input-group-append'>
							<span class="input-group-text">
								<i class="far fa-clock"></i>
							</span>
						</span>
					</div>
				</td>
				<td class='martes row_martes'>
					<div class='input-group' style="min-width:110px">
						<input class='form-control timepicker<?php if($horario["bo_no_continuado"]):?> ipt_no_continuado<?php endif;?>' id='<?php echo $horario["id"];?>_martes' name='martes_<?php echo $horario["id"];?>' value='' readonly required_martes></input>
						<span class='input-group-append'>
							<span class="input-group-text">
								<i class="far fa-clock"></i>
							</span>
						</span>
					</div>
				</td>
				<td class='miercoles row_miercoles'>
					<div class='input-group' style="min-width:110px">
						<input class='form-control timepicker<?php if($horario["bo_no_continuado"]):?> ipt_no_continuado<?php endif;?>' id='<?php echo $horario["id"];?>_miercoles' name='miercoles_<?php echo $horario["id"];?>' value='' readonly required_miercoles></input>
						<span class='input-group-append'>
							<span class="input-group-text">
								<i class="far fa-clock"></i>
							</span>
						</span>
					</div>
				</td>
				<td class='jueves row_jueves'>
					<div class='input-group' style="min-width:110px">
						<input class='form-control timepicker<?php if($horario["bo_no_continuado"]):?> ipt_no_continuado<?php endif;?>' id='<?php echo $horario["id"];?>_jueves' name='jueves_<?php echo $horario["id"];?>' value='' readonly required_jueves></input>
						<span class='input-group-append'>
							<span class="input-group-text">
								<i class="far fa-clock"></i>
							</span>
						</span>
					</div>
				</td>
				<td class='viernes row_viernes'>
					<div class='input-group' style="min-width:110px">
						<input class='form-control timepicker<?php if($horario["bo_no_continuado"]):?> ipt_no_continuado<?php endif;?>' id='<?php echo $horario["id"];?>_viernes' name='viernes_<?php echo $horario["id"];?>' value='' readonly required_viernes></input>
						<span class='input-group-append'>
							<span class="input-group-text">
								<i class="far fa-clock"></i>
							</span>
						</span>
					</div>
				</td>
				<td class='sabado row_sabado'>
					<div class='input-group' style="min-width:110px">
						<input class='form-control timepicker<?php if($horario["bo_no_continuado"]):?> ipt_no_continuado<?php endif;?>' id='<?php echo $horario["id"];?>_sabado' name='sabado_<?php echo $horario["id"];?>' value='' readonly required_sabado></input>
						<span class='input-group-append'>
							<span class="input-group-text">
								<i class="far fa-clock"></i>
							</span>
						</span>
					</div>
				</td>
				<td class='domingo row_domingo'>
					<div class='input-group' style="min-width:110px">
						<input class='form-control timepicker<?php if($horario["bo_no_continuado"]):?> ipt_no_continuado<?php endif;?>' id='<?php echo $horario["id"];?>_domingo' name='domingo_<?php echo $horario["id"];?>' value='' readonly required_domingo></input>
						<span class='input-group-append'>
							<span class="input-group-text">
								<i class="far fa-clock"></i>
							</span>
						</span>
					</div>
				</td>
				<td class='festivo row_festivo'>
					<div class='input-group' style="min-width:110px">
						<input class='form-control timepicker<?php if($horario["bo_no_continuado"]):?> ipt_no_continuado<?php endif;?>' id='<?php echo $horario["id"];?>_festivo' name='festivo_<?php echo $horario["id"];?>' value='' readonly required_festivo></input>
						<span class='input-group-append'>
							<span class="input-group-text">
								<i class="far fa-clock"></i>
							</span>
						</span>
					</div>
				</td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
</div>