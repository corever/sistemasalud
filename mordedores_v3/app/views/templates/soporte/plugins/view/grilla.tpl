<div class="col-lg-12">
	<ul id="myTab2" class="nav nav-tabs top-spaced">
		<li class="active"><a href="#pendientes" data-toggle="tab">Pendientes</a></li>
		<li class=""><a href="#cerradas" data-toggle="tab">Cerradas</a></li>
	</ul>
	<div class="tab-content top-spaced">
		<div class="tab-pane active" id="pendientes">
			<table class="table table-hover table-condensed table-bordered datatable paginada table-striped" >
				<thead>
					<tr style="background-color:#01619E !important; color: white !important">
						<th style="width:10% !important;">Ticket</th>
						<th style="width:30% !important;">Asunto</th>
						<th style="width:20% !important;">Email</th>
						<th style="width:10% !important;">Fecha Creaci&oacute;n</th>
						<th style="width:10% !important;">Estado</th>
						<th style="width:10% !important;">D&iacute;as Transcurridos</th>
						<th style="width:10% !important;">Acciones</th>
					</tr>
				</thead>
				<tbody>
					{foreach $soportes as $item}
						{if $item['id_estado_soporte'] != 3}
							<tr>
								<td align="center">{$item['gl_codigo_soporte']}</td>
								<td>{$item['asunto_soporte']}</td>
								<td>{$item['email_usuario']}</td>
								<td>{$item['fc_creacion']}</td>
								<td>{$item['gl_nombre_estado']}</td>
								<td align="center">{$item['dias_bandeja']}</td>
								<td align="center">
									<a title="VER" class="btn btn-xs btn-default btn-opcion glyphicon glyphicon-info-sign" onclick="xModal.open('{$base_url}/Soporte/verDetalleSoporte/{$item['id_soporte']}/','Detalle Soporte #{$item['gl_codigo_soporte']} MIDAS','lg');"></a>	
								</td>
							</tr>
						{/if}
					{/foreach}
				</tbody>
			</table>
		</div>
		
		<div class="tab-pane" id="cerradas">
			<table class="table table-hover table-condensed table-bordered datatable paginada table-striped" >
				<thead>
					<tr style="background-color:#01619E !important; color: white !important">
						<th style="width:10% !important;">Ticket</th>
						<th style="width:30% !important;">Asunto</th>
						<th style="width:20% !important;">Email</th>
						<th style="width:10% !important;">Fecha Creaci&oacute;n</th>
						<th style="width:10% !important;">Estado</th>
						<th style="width:10% !important;">D&iacute;as Transcurridos</th>
						<th style="width:10% !important;">Acciones</th>
					</tr>
				</thead>
				<tbody>
					{foreach $soportes as $item}
						{if $item['id_estado_soporte'] == 3}
							<tr>
								<td align="center">{$item['gl_codigo_soporte']}</td>
								<td>{$item['asunto_soporte']}</td>
								<td>{$item['email_usuario']}</td>
								<td>{$item['fc_creacion']}</td>
								<td>{$item['gl_nombre_estado']}</td>
								<td align="center">{$item['dias_bandeja']}</td>
								<td align="center">
									<a title="VER" class="btn btn-xs btn-default btn-opcion glyphicon glyphicon-info-sign" onclick="xModal.open('{$base_url}/Soporte/verDetalleSoporte/{$item['id_soporte']}/','Detalle Soporte #{$item['gl_codigo_soporte']} MIDAS','lg');"></a>	
								</td>
							</tr>
						{/if}
					{/foreach}
				</tbody>
			</table>
		</div>
	</div>
</div>