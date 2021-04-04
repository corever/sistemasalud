<div class="card card-success" style="border-style: solid; border-width: 1px; border-color: #ccdcf9; background: #ddf2ff;">
    <div class="card-header" style="background: #1e77ab;">
        <div class="card-title"><h6><b>DATOS FARMACIA</b></h6></div>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row top-spaced">
            <div class="col-1">
                <label class="control-label required-left">Región</label>
            </div>
            <div class="col-5">
                <select id="id_region_famacia" name="id_region_famacia" onchange="RegistroDT.cargarComunasPorRegion(this.value,'id_comuna_farmacia','');"  value=""
                    class="form-control" required>
                    <?php if (!isset($arrRegion) || count((array) $arrRegion) == 0 || count((array) $arrRegion) > 1) : ?>
                    <option value="0">Seleccione una Región</option>
                    <?php endif; ?>
                    <?php if (isset($arrRegion) && is_array($arrRegion)) : foreach ($arrRegion as $key => $region) : ?>
                    <option value="<?php echo $region->id_region_midas ?>" <?php echo (isset($arr->id_region) && $arr->id_region == $region->id_region_midas)?"selected":""; ?> ><?php echo $region->nombre_region_corto; ?></option>
                    <?php endforeach;
                        endif; ?>
                </select>
            </div>
            <div class="col-1">
                <label class="control-label required-left">Comuna</label>
            </div>
            <div class="col-5">
                <select id="id_comuna_farmacia" name="id_comuna_farmacia" class="form-control" required>
                    <?php if (!isset($arrComuna) || count((array) $arrComuna) == 0 || count((array) $arrComuna) > 1) : ?>
                    <option value="0">Seleccione Comuna</option>
                    <?php endif; ?>
                    <?php 
                    if (isset($arrComuna) && is_array($arrComuna)) : foreach ($arrComuna as $key => $comuna) : ?>
                        <option value="<?php echo $comuna->comuna_id ?>" data-region="<?php echo $comuna->comuna_id ?>"><?php echo $comuna->comuna_nombre; ?></option>
                        <?php endforeach;
                        endif; ?>
                </select>
            </div>
        </div>
        <div class ="row top-spaced">
            <div class="col-1">
                <label class="control-label required-left">Dirección</label>
            </div>
            <div class="col-5">
                <input type="text" class="form-control" name="gl_direccion_farmacia" id="gl_direccion_farmacia"  value="" required onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">
            </div>
            <div class="col-1">
                <label class="control-label required-left">Nombre Alternativo</label>
            </div>
            <div class="col-5">
                <input type="text" class="form-control" name="gl_nombre_farmacia" id="gl_nombre_farmacia" value="" required onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">
            </div>
            <br><br>
        </div>
        <div class ="row top-spaced">
            <div class="col-1">
                <label class="control-label required-left">RUT</label>
            </div>
            <div class="col-5">
                <input  type="text" class="form-control"  id="gl_rut_farmacia" name="gl_rut_farmacia" value=""
                    onkeyup="formateaRut(this), this.value = this.value.toUpperCase()" onkeypress="return soloNumerosYK(event)" onblur="RegistroDT.Valida_Rut(this);" onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"/>
            </div>
            <div class="col-1">
                <label class="control-label required-left">Número de local</label>
            </div>
            <div class="col-5">
                <input type="text" class="form-control" name="nr_local_farmacia" id="nr_local_farmacia" value="" required onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">
            </div>
            <br><br>
        </div>
        <div class ="row top-spaced">
            <div class="col-1">
                <label class="control-label required-left">Email de contacto</label>
            </div>
            <div class="col-5">
                <input type="text" class="form-control" name="gl_email_farmacia" id="gl_email_farmacia" value="" required onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off">
            </div>
            <div class="col-1">
                <label class="control-label required-left">Teléfono</label>
            </div>
            <div class="col-5">
                <input type="text" class="form-control" name="gl_telefono_farmacia"  id="gl_telefono_farmacia"  onkeypress="return soloNumeros(event)" value="" required onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete="off"> 
            </div>
            <br><br>
        </div>
    </div>
</div>