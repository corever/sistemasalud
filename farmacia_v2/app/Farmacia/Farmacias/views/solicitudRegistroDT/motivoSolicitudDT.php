<div class="card card-danger" style="border-style: solid; border-width: 1px; border-color: #ccdcf9;">
    <div class="card-header" style="background: #00a1de">
        <div class="card-title"><h6><b>MOTIVO SOLICITUD</b></h6></div>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="card-body" style="background: #ddf2ff;">
        <div class="row top-spaced">
            <div class="col-2">
                <label class="control-label required-left">Tipo de Función :</label>
            </div>
            <div class="col-2">
                <input type="radio" class="labelauty" styke="background-color:#6b1e49;" id="chk_direccion_tecnica_asume" name="chk_dt_motivo" value="ASUME"  data-labelauty="ASUME DIRECCION TÉCNICA" />
            </div>
            <div class="col-2">
                <input type="radio" class="labelauty" style="background-color:#6b1e49;" id="chk_direccion_tecnica_cese" name="chk_dt_motivo" value="CESE"  data-labelauty="CESE DIRECCION TÉCNICA" />
            </div>
        </div>
       
           
            
            <div id="div_cese_dt" class="row top-spaced" style="display:none;border-style: solid; border-width: 1px; border-color: #ced4da;background:#ffffff; ">
                <form id="form_cese_dt">
                    <?php include('ceseDT.php'); ?>
               </form> 
            </div>

            <div id="div_asume_dt" class="row top-spaced" style="display:none;border-style: solid; border-width: 1px; border-color: #ced4da; background:#ffffff;">
                <form id="form_asume_dt">
                    <?php include('asumeDT.php'); ?>
                </form>
            </div>
    </div>
</div>