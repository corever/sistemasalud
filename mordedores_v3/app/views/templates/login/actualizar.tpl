<section class="content-header">
    <h1><i class="fa fa-user"></i> <span>Cuenta</span></h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Datos de Usuario</h3>
                </div>
                <div class="box-body">
                    <label class="control-label required">Nombre</label><br>
                    {$nombre}
                    <br/><br/>
                    <label class="control-label required">RUT</label><br>
                    {$rut}
                    <br/><br/>
                    <label class="control-label required">Email</label><br>
                    {$mail}
                    <br/><br/>
                    <label class="control-label required">Fono Fijo</label><br>
                    {$fono}
                    <br/><br/>
                    <label class="control-label required">Celular</label><br>
                    {$celular}
                    <br/><br/>
                    <label class="control-label required">Comuna</label><br>
                    {$comuna}
                    <br/><br/>
                    <label class="control-label required">Provincia</label><br>
                    {$provincia}
                    <br/><br/>
                    <label class="control-label required">Regi&oacute;n</label><br>
                    {$region}
                    <br/><br/>
                </div>
            </div>
        </div>
        
        <div class="col-xs-12 col-md-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Actualización de Contraseña</h3>
                </div>
                
                <div class="box-body">
                    {if $primer_login == 1}
                    <div class="col-sm-12">
                        <div class="alert alert-warning">
                             &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No ha actualizado su contraseña inicial.
                        </div>
                    </div>
                    {/if}
                    <form  id="form" name="form" enctype="application/x-www-form-urlencoded" action="" method="post">
                        <input type="hidden" name="id" id="id" value="{$id_usuario}"/>
						<div class="col-md-6 text-left">
                            <div class="form-group clearfix">
                                <label class="control-label">Restricciones para el cambio de contraseña :
									
								</label>
								<ul>
									<li>No debe ser igual a la contraseña actual</li>
									<li>Debe tener al menos 8 caracteres</li>
									<li>No puede tener más de 16 caracteres</li>
									<li>Debe tener al menos una letra mayúscula</li>
									<li>Debe tener al menos una letra minúscula</li>
									<li>Debe tener al menos un caracter numérico</li>
								</ul>
                            </div>
                        </div>
						<div class="col-md-6 text-left">
                            <div class="form-group clearfix">
                                <label for="password_ant" class="control-label required">Contraseña Actual (*)</label>
                                <input type="password" name="password_ant" id="password_ant" value="" class="form-control"/>
								<span class="help-block hidden"></span>
                            </div>
                        </div>
						<div class="col-md-6 text-left">
                            <div class="form-group clearfix">
                                <label for="password" class="control-label required">Nueva contraseña (*)</label>
                                <input type="password" name="password" id="password" value="" class="form-control"/>
                                <span class="help-block" id="result">Incluya números, mayúsculas, minúsculas y símbolos</span>
                            </div>
                        </div>
                        <div class="col-md-6 text-left">
                            <div class="form-group clearfix">
                                <label for="password_repetido" class="control-label required">Repita la nueva contraseña (*)</label>
                                <input type="password" name="password_repetido" id="password_repetido" value="" class="form-control"/>
                                <span class="help-block hidden"></span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div id="form-error" class="alert alert-danger hidden">
                            <i class="fa fa-warning fa-2x"></i> &nbsp;
                            <strong> ¡Error! </strong> Existen problemas en los datos, revise los campos en rojo.
                        </div>
                        <div class="col-md-12 text-right">
                            <button type="button" id="guardar" class="btn btn-success btn-sm">
                                <i class="fa fa-save"></i> Guardar
                            </button>
                            <button type="button" id="cancelar" onclick="location.href='{$base_url}/Home/dashboard'" class="btn btn-default btn-sm">
                                <i class="fa fa-remove"></i> Cancelar 
                            </button>
                            <br/><br/>
                        </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</section>