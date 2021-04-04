<div class="form-group">
    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">RUT/Pasaporte : </label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{if $arr->gl_rut}{$arr->gl_rut}{else if $arr->gl_pasaporte}{$arr->gl_pasaporte}{else}-{/if}" class="form-control" readonly>
        </div>
    </div>

    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">Nombre Completo : </label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{$arr->gl_nombre} {$arr->gl_apellido_paterno} {$arr->gl_apellido_materno}" class="form-control" readonly>
        </div>
    </div>
</div>
		
<div class="form-group">
    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">Email : </label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{$arr->gl_email}" class="form-control" readonly>
        </div>
    </div>

    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">Dirección : </label>
        </div>
        <div class="col-md-8">
            {assign var="json_direccion" value=$arr->json_direccion|@json_decode}
            <input type="text" value="{if $json_direccion->direccion}{$json_direccion->direccion}{/if}" class="form-control" readonly>
        </div>
    </div>
</div>
		
<div class="form-group">
    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">Región : </label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{$arr->gl_nombre_region}" class="form-control" readonly>
        </div>
    </div>

    <div class="clearfix col-md-6">
        <div class="col-md-4">
            <label class="control-label">Comuna : </label>
        </div>
        <div class="col-md-8">
            <input type="text" value="{$arr->gl_nombre_comuna}" class="form-control" readonly>
        </div>
    </div>
</div>
        
<div class="col-md-12">
    <div class="top-spaced"></div>
</div>