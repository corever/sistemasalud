
<form id="formModulo" class="form-horizontal" method="post" enctype="multipart/form-data">
	<section class="content">
		<div class="card card-primary">
            <div class="card-header"> <?php echo \Traduce::texto("Módulos Medico"); ?> </div>
			<div class="card-body">
				<input type="text" id="gl_token" name="gl_token" value="<?php echo $gl_token; ?>" hidden >
                <div class="row">

                    <?php $cont = 1; ?>
                    <?php foreach($arrModulo as $key => $item): ?>
                        <?php $arr_color = explode("-",$item->gl_color); ?>
                        <div class="col-lg-3 col-6">
                            <!-- small box -->
                            <div class="small-box <?php echo (array_key_exists($item->id_modulo,$arrModuloMedico))?$item->gl_color:"default"; ?>"
                                data-color="<?php echo $item->gl_color; ?>" id="div_modulo_color_<?php echo $item->id_modulo ?>">
                                <div class="inner">
                                    <div class="col-12"><h5><?php echo \Traduce::texto($item->gl_nombre); ?></h5></div>
                                    <div class="col-12"><button type="button" id="btnModuloEditar<?php echo $item->id_modulo ?>" class="btn btn-sm btn-default btnModuloEditar" data-color="<?php echo $item->gl_color; ?>" onclick="MantenedorMedico.editarOpcionesModulo(<?php echo $item->id_modulo; ?>,'<?php echo \Traduce::texto($item->gl_nombre); ?>','<?php echo $arr_color[1]; ?>');" <?php echo ($cont == 1)?"disabled":""; ?>><i class="fa fa-edit"></i>&nbsp;Editar</button></div>
                                    <!--p><?php //echo $item->gl_descripcion; ?></p-->
                                </div>
                                <div class="icon">
                                    <i class="<?php echo $item->gl_icono; ?>"></i>
                                </div>
                                <br>
                                <div class="small-box-footer" >
                                    <input type="checkbox" onclick="MantenedorMedico.seleccionarModulo(this);" data-id_modulo="<?php echo $item->id_modulo; ?>"
                                            <?php echo (array_key_exists($item->id_modulo,$arrModuloMedico))?"checked":""; ?>
                                            id="chk_modulo_<?php echo $item->id_modulo; ?>" name="chk_modulo_<?php echo $item->id_modulo; ?>">
                                            <label id="label_modulo_<?php echo $item->id_modulo ?>" style="color:black;"><?php echo (array_key_exists($item->id_modulo,$arrModuloMedico))?\Traduce::texto("Seleccionado"):\Traduce::texto("Seleccionar"); ?></label>
                                </div>
                            </div>
                        </div>

                        <?php
                            if($cont == 1){
                                $id_modulo_primero = $item->id_modulo;
                            }
                            $cont++;
                        ?>

                    <?php endforeach; ?>
                </div>

                <?php foreach($arrModulo as $key => $item): ?>
                    <div class="card card-<?php echo explode("-",$item->gl_color)[1]; ?> moduloEditar" id="moduloEditar<?php echo $item->id_modulo; ?>"
                        style="<?php echo ($item->id_modulo != $id_modulo_primero)?'display:none':''; ?>">
                        <div class="card-header"><?php echo \Traduce::texto($item->gl_nombre); ?></div>
                        <div class="card-body">

                            <div class="tab-pane active" id="step-2" role="tabpanel">
                                <section class="management-hierarchy section">
                                    <div class="hv-container">
                                        <div class="hv-wrapper">
                                            <!-- Key component -->
                                            <div class="hv-item" >
                                                <div class="hv-item-parent">
                                                    <div class="person">
                                                        <a href="#" style="color:white">
                                                            <i id="iconoModulo<?php echo $item->id_modulo; ?>" class="<?php echo $item->gl_icono; ?> fa-3x"></i>
                                                        </a>
                                                        <p class="name" style="margin-top:6px" id="nombreModulo<?php echo $item->id_modulo; ?>">
                                                            <strong><?php echo \Traduce::texto($item->gl_nombre); ?></strong>
                                                        </p>
                                                        <div class="checkbox checkbox-success">
                                                            <input class="styled" data-modulo="<?php echo $item->id_modulo; ?>" value="<?php echo $item->id_modulo; ?>"
                                                                id="checkboxModulo<?php echo $item->id_modulo; ?>" type="checkbox" checked=""><label for="checkboxModulo<?php echo $item->id_modulo; ?>"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="hv-item-children <?php //echo (count($arrOpciones[$item->id_modulo]) == 1)?'is-only':''; ?>">
                                                    <?php foreach($arrOpciones as $padre): ?>
                                                        <?php if($padre->id_modulo == $item->id_modulo): ?>
                                                            <div class="hv-item-child" data-modulo="<?php echo $padre->id_modulo; ?>" style="<?php echo (intval($padre->id_modulo) != intval($item->id_modulo))?'display:none;':''; ?>">
                                                                <!-- Key component -->
                                                                <div class="hv-item">

                                                                    <div class="hv-item-parent">
                                                                        <div class="person">
                                                                            <a href="#" style="color:white">
                                                                                <i class="<?php echo ($padre->gl_icono != "")?$padre->gl_icono:"fa fa-list"; ?> fa-3x"></i>
                                                                            </a>
                                                                            <p class="name" style="margin-top:6px">
                                                                                <strong><?php echo $padre->gl_nombre_opcion ?></strong>
                                                                            </p>
                                                                            <div class="checkbox checkbox-success">
                                                                                <input class="styled" data-orden="<?php echo $padre->id_opcion ?>" value="<?php echo $padre->id_opcion; ?>"
                                                                                    <?php if (in_array($padre->id_opcion,$opUsuario)): ?> checked <?php endif; ?>
                                                                                    id="checkbox<?php echo $padre->id_opcion; ?>" type="checkbox" checked=""><label for="checkbox<?php echo $padre->id_opcion; ?>"></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <?php if(count($padre->arrSubOpcion) > 0): ?>
                                                                    <?php foreach($padre->arrSubOpcion as $opcion): ?>
                                                                        <div class="hv-item-children <?php echo (count($padre->arrSubOpcion) == 1)?'is-only':''; ?>">
                                                                            <div class="hv-item-child">
                                                                                <div class="hv-item">
                                                                                    <div class="hv-item-parent">
                                                                                        <div class="person">
                                                                                            <i class="<?php echo ($opcion->gl_icono != "")?$opcion->gl_icono:"fa fa-list"; ?> fa-3x" style="color:white"></i>
                                                                                            <p class="name" style="margin-top:6px">
                                                                                                <strong><?php echo $opcion->gl_nombre_opcion ?></strong>
                                                                                            </p>
                                                                                            <div class="checkbox checkbox-success">
                                                                                                <input class="styled" data-orden="<?php echo $opcion->id_opcion ?>" value="<?php echo $opcion->id_opcion ?>"
                                                                                                    <?php if (in_array($opcion->id_opcion,$opUsuario)): ?> checked <?php endif; ?>
                                                                                                    id="checkbox<?php echo $opcion->id_opcion ?>" type="checkbox"><label for="checkbox<?php echo $opcion->id_opcion ?>"></label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <?php $id_opcion_permiso = $opcion->id_opcion; include("permisos.php"); ?>
                                                                            </div>

                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                <?php else: ?>
                                                                    <?php $id_opcion_permiso = $padre->id_opcion; include("permisos.php"); ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

		<div class="top-spaced" id="btn-terminar"  align="right">
			<button class="btn btn-success" type="button" onclick="MantenedorMedico.editarModulo(this.form, this);"><i class="fa fa-save"></i> <?php echo \Traduce::texto("Guardar"); ?> </button>
            <button class="btn btn-danger" type="button" onclick="xModal.close();"><i class="fa fa-close"></i> <?php echo \Traduce::texto("Cerrar"); ?> </button>
		</div>
	</section>
</form>
