<!DOCTYPE html>
<html lang="es">
    <head>
        {include file="layout/css.tpl"}
    </head>
    <body class="body-login">

        <div class="container">
            <div class="row">
                <div class="col-md-12 col-md-offset-0">
                    <div class="login-banner text-left">
                        <h1 class="text-center"><img src="{$static}images/minsal-logo.svg" />&nbsp;&nbsp;&nbsp;&nbsp;Registro</h1>
                    </div>
                    <div class="portlet portlet-green">
                        <div class="portlet-body">
                            <div id="form-success" class="hidden">
                                <div id="mensaje-modificacion" class="alert alert-success">

                                </div>
                                <button onclick="location.href = '{$base_url}'" class="btn btn-lg btn-primary btn-block" type="button">Continuar <i class="fa fa-forward"></i></button>

                            </div>
                            <div id="form-contenedor">
                                <form id="form" name="form" role="form" method="post" enctype="multipart/form-data">
                                    <fieldset>
                                        <input type="hidden" name="id" id="id" value=""/>
                                        <div class="alert alert-warning">
                                            Complete el siguiente formulario para obtener una clave de acceso a la Plataforma del Sistema de Regristro de Animales Mordedores (SIRAM) del Ministerio de Salud.
                                            Tenga en cuenta que un encargado de Minsal deberá aprobar su solicitud antes de que pueda ingresar al sistema, por lo tanto, no omita ningún dato de este formulario.
                                        </div>
                                        <br>
                                        <br>
                                        <div class="form-horizontal row-border">
                                            <legend>Informaci&oacute;n Personal</legend>
                                            <div class="row">
                                                <div class ="col-xs-12 col-md-6">
                                                    <div class="form-group col-xs-12">
                                                        <label for="nombre" class="required">Nombre</label>
                                                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Escriba su nombre" required/>
                                                        <span class="help-block hidden"></span>
                                                    </div>
                                                </div>
                                                <div class ="col-xs-12 col-md-6">
                                                    <div class="form-group col-xs-12">
                                                        <label for="apellido" class="required">Apellido</label>
                                                        <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Escriba su apellido" required/>
                                                        <span class="help-block hidden"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class ="col-xs-12 col-md-6">
                                                    <div class="form-group col-xs-12">
                                                        <label for="rut" class="required">RUT</label>
                                                        <input type="text" name="rut" id="rut" class="form-control" placeholder="Escriba su rut" required/>
                                                        <span class="help-block hidden"></span>
                                                    </div>
                                                </div>
                                                <div class ="col-xs-12 col-md-6">
                                                    <div class="form-group col-xs-12">
                                                        <label for="email" class="required">Email</label>
                                                        <input type="email" name="email" id="email" class="form-control" placeholder="Escriba su email" required/>
                                                        <span class="help-block hidden"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class ="col-xs-12 col-md-6">
                                                    <div class="form-group col-xs-12">
                                                        <label for="celular" class="required">Celular</label>
                                                        <input type="text" name="celular" id="celular" class="form-control" placeholder="Escriba su número celular" required/>
                                                        <span class="help-block hidden"></span>
                                                    </div>
                                                </div>
                                                <div class ="col-xs-12 col-md-6">
                                                    <div class="form-group col-xs-12">
                                                        <label for="telefono" class="required">Fono Fijo</label>
                                                        <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Escriba su número de teléfono fijo" required/>
                                                        <span class="help-block hidden"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-12 col-md-6">
                                                    <div class="form-group col-xs-12">
                                                        <label for="direccion" class="required">Dirección</label>
                                                        <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Escriba su dirección" />
                                                        <span class="help-block hidden"></span>
                                                    </div>
                                                </div>
                                                <div class="col-xs-12 col-md-6">
                                                    <div class="form-group col-xs-12">
                                                        <label for="comuna"class="required">Comuna</label>
                                                        {selectComuna nombre="comuna" class="col-sm-3 form-control elemento-busqueda"}
                                                        <span class="help-block hidden"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-xs-12 col-md-12">
                                                    <div class="form-group col-xs-12">
                                                        <label for="referencia" class="required">Referencia</label>
                                                        <input type="text" name="referencia" id="referencia" class="form-control" placeholder="Indique referencias para llegar a su direección" />
                                                        <span class="help-block hidden"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class ="col-xs-12 col-md-6">
                                                    <div class="form-group col-xs-12">
                                                        <label for="password" class="required">Contraseña</label>
                                                        <input type="password" autocomplete="off" name="password" id="password" class="form-control" placeholder="Escriba una contraseña" required/>
                                                        <span class="help-block hidden"></span>
                                                    </div>
                                                </div>
                                                <div class ="col-xs-12 col-md-6">
                                                    <div class="form-group col-xs-12">
                                                        <label for="retype" class="required">Vuelva a escribir la contraseña</label>
                                                        <input type="password" autocomplete="off" name="retype" id="retype" class="form-control" placeholder="Vuelva a escribir la contraseña" required/>
                                                        <span class="help-block hidden"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <legend>Organizaci&oacute;n a la que pertence</legend>
                                            <div class="row">
                                                <div class="col-xs-12 col-md-12">
                                                    
                                                </div>
                                                <label class="control-label required">Tipo de Organización</label>
                                                <label class="radio-inline">
                                                    <input name="tipo_organizacion" id="org_tip_cli"type="radio" checked="" value="org_tip_cli" onClick="$('.classOrganizacion').hide();
                                                            $('.classDocumento').hide();
                                                            $('.classOrganizacion').show();
                                                            $('.classDocumento').show();"> Clínica veterinaria
                                                </label>
                                                <label class="radio-inline">
                                                    <input name="tipo_organizacion" id="org_tipo_muni" type="radio" value="org_tipo_muni"onClick="$('.classOrganizacion').hide();
                                                            $('.classDocumento').hide();
                                                            $('.classOrganizacion').show();"> Municipalidad
                                                </label>
                                                <label class="radio-inline">
                                                    <input name="tipo_organizacion" id="org_tipo_seremi" type="radio" value="org_tipo_seremi" onClick="$('.classOrganizacion').hide();
                                                            $('.classDocumento').hide();
                                                            $('.classOrganizacion').show();"> Seremi
                                                </label>
                                                <span class="help-block hidden"></span>
                                            </div>

                                            <div class="row">
                                                <div class ="col-xs-12 col-md-12">
                                                    <div class="form-group col-xs-12 classOrganizacion">
                                                        <label for="nom_org" class="required classOrganizacion " style="display:none">Busque su Organizaci&oacute;n</label>
                                                        {selectInstitucion nombre="nom_org" class="col-sm-3 form-control elemento-busqueda"}
                                                        <span class="help-block hidden"></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class ="col-xs-12 col-md-12">
                                                    <div class="form-group col-xs-12 classDocumento">
                                                        <label for="doc_acred" class="required classDocumento" style="display:none">Documento de Acreditaci&oacute;n</label>
                                                        Seleccione<input name="doc_acred" id="doc_acred" type="file" hidden>
                                                        <p class="help-description">
                                                            Título profesional, Cédula de Identidad (donde quede se evidencie la profesión),
                                                            Número de registro en colegio médico veterinario, Número de registro de permiso de botiquín otorgado por ISP
                                                        </p>
                                                        <span class="help-block hidden"></span>

                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="panel-footer">
                                                <div class="row">
                                                    <div class="col-sm-6 col-sm-offset-2">
                                                        <div class="btn-toolbar">
                                                            <button id="crear" class="btn btn-primary" type="button">Enviar Solicitud</button>
                                                            <a class="btn-default btn" href="javascript:history.back();">Cancelar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {include file="layout/js.tpl"}
    </body>
</html>