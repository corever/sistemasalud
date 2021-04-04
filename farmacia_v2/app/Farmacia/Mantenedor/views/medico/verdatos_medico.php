<div class="card card-primary">
	<div class="card-header"> Datos Medico</div>
	<div class="card-body">
        <div class="row">
            <div class="col-sm-9">
                <label for="gl_rut_medico" class="control-label">RUT: </label>
								<label for="gl_rut_medico" class="control-label"><?php echo (isset($arr->gl_rut))?$arr->gl_rut:""; ?></label>
						</div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="gl_nombre_medico" class="control-label"><?php echo \Traduce::texto("Nombre Completo"); ?>: </label>
								<label for="gl_nombre_medico" class="control-label"><?php echo (isset($arr->gl_nombres))?$arr->gl_nombres:""; ?><?php echo (isset($arr->gl_apellido_paterno))?$arr->gl_apellido_paterno:""; ?><?php echo (isset($arr->gl_apellido_materno))?$arr->gl_apellido_materno:""; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="id_profesion_medico" class="control-label"><?php echo \Traduce::texto("Profesión"); ?></label>
								<label for="id_profesion_medico" class="control-label"><?php echo (isset($arrProfesion->id_profesion))?$arrProfesion->nombre_profesion:""; ?></label>
            </div>
						<div class="col-sm-6">
								<label for="id_especialidad_medico" class="control-label"><?php echo \Traduce::texto("Especialidad"); ?></label>
								<label for="id_especialidad_medico" class="control-label"><?php echo (isset($arrEspecialidad->especialidad_id))?$arrEspecialidad->especialidad_nombre:""; ?></label>
						</div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label class="control-label"><?php echo \Traduce::texto("Género"); ?></label>
								<label class="labelauty"><?php echo (isset($arr->chk_genero))?$arr->chk_genero:""; ?> </label>
            </div>
            <div class="col-sm-6">
                <label for="fc_nacimiento_medico" class="control-label"><?php echo \Traduce::texto("Fecha Nacimiento"); ?></label>
								<label for="fc_nacimiento_medico" class="control-label"><?php echo (isset($arr->fc_nacimiento))?\Fechas::formatearHtml($arr->fc_nacimiento):""; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="gl_email_medico" class="control-label">Email</label>
								<label for="gl_email_medico" class="control-label"><?php echo (isset($arr->gl_email))?$arr->gl_email:""; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label for="id_region_medico" class="control-label"><?php echo \Traduce::texto("Región"); ?></label>
								<label for="id_region_medico" class="control-label"><?php echo (isset($arrRegion->region_id))?$arrRegion->nombre_region_corto:""; ?></label>
            </div>
            <div class="col-sm-6">
                <label for="id_comuna_medico" class="control-label"><?php echo \Traduce::texto("Comuna"); ?></label>
								<label for="id_comuna_medico" class="control-label"><?php echo (isset($arrComuna->comuna_id))?$arrComuna->comuna_nombre:""; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <label for="gl_direccion_medico" class="control-label">Dirección</label>
								<label for="gl_direccion_medico" class="control-label"><?php echo (isset($arr->gl_direccion))?$arr->gl_direccion:""; ?></label>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <label for="id_codregion_medico" class="control-label">Teléfono</label>
								<label for="id_codregion_medico" class="control-label"><?php echo (isset($arr->id_codfono))?$arr->id_codfono:""; ?> <?php echo (isset($arr->gl_telefono))?$arr->gl_telefono:""; ?></label>
            </div>
        </div>
	</div>

</div>
