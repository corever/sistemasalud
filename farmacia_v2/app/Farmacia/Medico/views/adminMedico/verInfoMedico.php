<div class="card card-primary">
   <div class="card-header"> Detalle </div>
   <div class="card-body">
      <div class="row">
         <div class="col-2">
            <label for="gl_nombre_medico" class="control-label">Nombre Medico</label>
         </div>
         <div class="col-10">
            <input readonly type="text" class="form-control" value="<?php echo isset($nombreCompleto)?$nombreCompleto:"" ?> "/>
         </div>
      </div>
      <div class="row top-spaced">
         <div class="col-2">
            <label for="gl_rut_medico" class="control-label">RUT Medico</label>
         </div>
         <div class="col-4">
            <input readonly type="text" class="form-control" value="<?php echo isset($arrDatosMedico->gl_rut)?$arrDatosMedico->gl_rut:"" ?> "/>
         </div>
         <div class="col-2">
            <label class="control-label "><?php echo \Traduce::texto("Fecha Nacimiento"); ?></label>
         </div>
         <div class="col-4">            
            <input readonly type="text" class="form-control" value="<?php echo isset($arrDatosMedico->fc_nacimiento)?$arrDatosMedico->fc_nacimiento:"" ?>"/>
         </div>
      </div>
      <div class="row top-spaced">
         <div class="col-2">
            <label for="gl_direccion_usuario" class="control-label ">Especialidad</label>
         </div>
         <div class="col-10">       
            <?php                 
               foreach($arrEspecialidad as $key => $especialidad){
                   if($arrDatosMedico->id_especialidad==$especialidad->id_especialidad){
                       echo '<input readonly type="text" class="form-control" value="'.$especialidad->gl_especialidad.'"/>';
                   }
               }
               ?>
         </div>
      </div>
      <div class="row top-spaced">
         <div class="col-2">
            <label for="gl_direccion_usuario" class="control-label ">Email</label>
         </div>
         <div class="col-10">       
            <?php                 
               echo '<input readonly type="text" class="form-control" value="'.$arrDatosMedico->gl_email.'"/>';
               ?>
         </div>
      </div>
      <br>
      <div class="top-spaced">
         <div class="card-header" style="background: #9dccff;"><b> Consultas Médicas Asociadas</b></div>
         <div class="card-body">
            <?php
               if(isset($arrConsultas)){
                   $indice = 1;
                   foreach ($arrConsultas as $key => $consulta){        
                       $region = "";
                       $comuna = "";
                   
                       foreach ($arrRegion as $key => $region) {
                           
                            if ($region->region_id == $consulta->id_region){
                                $region = $region->nombre_region_corto;
                                break;
                            }
                       }
               
                       foreach ($arrComuna as $key => $comuna) {
                           
                            if ($comuna->comuna_id == $consulta->id_comuna){
                                $comuna = $comuna->comuna_nombre;
                                break;
                            }
                       }
               
                        if($region!="" && $comuna!=""){   
                        echo '<div class="row top-spaced">
                                <div class="col-3">
                                    <label class="control-label ">Direccion Consulta '.$indice.':</label>
                                </div>
                                <div class="col-9">
                                    <input readonly type="text" class="form-control" value="'.$consulta->gl_direccion.', '.$comuna.', '.$region.' (FONO: '.$consulta->gl_telefono.')" />  
                                </div>
                            </div>';
                        $indice++;
                        }
                   }
                       
               }else{
               echo    '<div class="row">
                           <div class="col-12">
                               <span>No posee Consultas registradas</span>
                           </div>
                       </div>';
               }
               
               ?>
         </div>
      </div>
   </div>
</div>
