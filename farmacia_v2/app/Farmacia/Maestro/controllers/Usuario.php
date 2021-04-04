<?php

/**
 ******************************************************************************
 * Sistema           : Mis Fiscalizaciones
 *
 * Descripción       : Controlador de Mantenedor:Usuario
 *
 * Plataforma        : PHP
 *
 * Creación          : 24/07/2019
 *
 * @name             Usuario.php
 *
 * @version          1.0.0
 *
 * @author           David Guzmán <david.guzman@cosof.cl>
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador							Fecha		Descripción
 * ----------------------------------------------------------------------------
 *
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */

namespace App\Farmacia\Maestro;

use Pan\Utils\ValidatePan as validatePan;

class Usuario extends \pan\Kore\Controller
{
	private $_DAORegion;
	private $_DAOComuna;
	private $_DAORol;
	private $_DAOUsuario;
	private $_DAOUsuarioRol;
	private $_DAOUsuarioHistorial;
	private $_DAOProfesion;
	private $_DAOCodigoRegion;
	private $_DAOTerritorio;
	private $_DAOBodega;
    private $_DAOLocal;
    private $_DAOFarmacia;
    private $_DAODirectorTecnico;

	public function __construct()
	{
		parent::__construct();
		$this->session->isValidate();

		$this->_DAORegion				=	new \App\_FuncionesGenerales\General\Entity\DAODireccionRegion;
		$this->_DAOComuna				=	new \App\_FuncionesGenerales\General\Entity\DAODireccionComuna;
		$this->_DAORol					=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoRol;
		$this->_DAOUsuario				=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuario;
		$this->_DAOUsuarioRol			=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioRol;
		$this->_DAOUsuarioHistorial		=	new \App\Usuario\Entity\DAOUsuarioHistorial();
		$this->_DAOIdioma				=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoIdioma;
		$this->_DAOOpcion				=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoOpcion;
		$this->_DAOUsuarioOpcion		=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoUsuarioOpcion;
		$this->_DAORolOpcion			=	new \App\_FuncionesGenerales\General\Entity\DAOAccesoRolOpcion;
		$this->_DAOProfesion			=	new \App\_FuncionesGenerales\General\Entity\DAOProfesion;
		$this->_DAOCodigoRegion			=	new \App\_FuncionesGenerales\General\Entity\DAOCodigoRegion;
		$this->_DAOTerritorio			=	new \App\_FuncionesGenerales\General\Entity\DAOTerritorio;
		$this->_DAOBodega				=	new \App\_FuncionesGenerales\General\Entity\DAOBodega;
        $this->_DAODirectorTecnico		=	new \App\_FuncionesGenerales\General\Entity\DAODirectorTecnico;
		
		$this->_DAOLocal				=	new \App\Farmacias\Farmacia\Entities\DAOLocal;
		$this->_DAOFarmacia				=	new \App\Farmacias\Farmacia\Entities\DAOFarmacia;
	}

    public function index(){

        //$this->session->isValidate();
        $arrRegion  = $this->_DAORegion->getLista();
        $arrComuna  = $this->_DAOComuna->getLista();
		$arrRoles	= $this->_DAORol->getLista(1);

		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrComuna', $arrComuna);
		$this->view->set('arrRoles', $arrRoles);
		$this->view->set('arrFiltros', $_SESSION[\Constantes::SESSION_BASE]['mantenedor_usuario']['filtros']);

		$this->view->addJS('regiones.js','pub/js/helpers');
        $this->view->addJS('maestroUsuario.js');

		$this->view->set('filtros',   $this->view->fetchIt('usuario/filtros'));
		$this->view->set('grilla',    $this->view->fetchIt('usuario/grilla'));
		$this->view->set('contenido', $this->view->fetchIt('usuario/index'));
		$this->view->render();
	}

    /**
	* Descripción	: Grilla usuarios
	* @author		: <david.guzman@cosof.cl> - 05/08/2020
	*/
    public function grillaUsuarios(){

        $params     = $this->request->getParametros();
		$arrUsuario = $this->_DAOUsuario->getListaMantenedor($params);
        $arrGrilla  = array('data'=>array());

        //Guardo Filtros en SESSION
        $_SESSION[\Constantes::SESSION_BASE]['mantenedor_usuario']['filtros']   = $params;

		if(!empty($arrUsuario)){
            foreach($arrUsuario as $item){
                $arr    = array();

                $arr['rut']         = $item->gl_rut;
                $arr['nombre']      = $item->gl_nombre_completo;
                $arr['email']       = $item->gl_email;
                $arr['telefono']    = $item->gl_telefono;
                $arr['genero']      = $item->gl_genero;
                $arr['direccion']   = $item->gl_direccion;
                //$arr['rol']         = $item->gl_roles;
                /*
                if($item->bo_activo == 1){
                    $arr['estado']  = '<div style="color:green;"> '.\Traduce::texto("Activo").' </div>';
                }else{
                    $arr['estado']  = '<div style="color:red;"> '.\Traduce::texto("Inactivo").' </div>';
                }
                */
                $arr['opciones']    = ' <button type="button" class="btn btn-xs btn-success"
                                            onclick="xModal.open(\''.\pan\uri\Uri::getHost().'Farmacia/Maestro/Usuario/editarUsuario/'.$item->gl_token.'\',\''. addslashes(\Traduce::texto("Editar Usuario")) .' <b>'.$item->gl_nombre_completo.'</b>\',\'90\');"
                                            data-toggle="tooltip" title="'.\Traduce::texto("Editar Usuario").'"><i class="fa fa-edit"></i>
                                        </button>
                                        <button type="button" class="btn btn-xs bg-purple"
                                            onclick="xModal.open(\''.\pan\uri\Uri::getHost().'Farmacia/Maestro/Usuario/editarRol/'.$item->gl_token.'\',\''.\Traduce::texto("Rol de").' <b>'.$item->gl_nombre_completo.'</b>\',\'90\');"
                                            data-toggle="tooltip" title="'.\Traduce::texto("Editar Rol").'"><i class="fa fa-table"></i>
                                        </button>
                                        ';

                                        /*
                                        <button type="button" class="btn btn-xs btn-warning"
                                            onclick="xModal.open(\''.\pan\uri\Uri::getHost().'Farmacia/Maestro/Usuario/historialUsuario/'.$item->gl_token.'\',\''.\Traduce::texto("Historial de").' <b>'.$item->gl_nombre_completo.'</b>\',\'lg\');"
                                            data-toggle="tooltip" title="'.\Traduce::texto("Historial de Usuario").'"><i class="fa fa-list-ul"></i>
                                        </button>
                                        <button type="button" class="btn btn-xs btn-info"
                                            onclick="xModal.open(\''.\pan\uri\Uri::getHost().'Farmacia/Maestro/Usuario/editarRoles/'.$item->gl_token.'\',\''.\Traduce::texto("Editar Roles").' de <b>'.$item->gl_nombre_completo.'</b>\',\'lg\');"
                                            data-toggle="tooltip" title="'.\Traduce::texto("Editar Roles").'"><i class="fa fa-table"></i>
                                        </button>
                                        */
                
                if($_SESSION[\Constantes::SESSION_BASE]['bo_cambio_usuario'] == 1 && $item->gl_token != $_SESSION[\Constantes::SESSION_BASE]['gl_token'] && $item->bo_activo == 1 && $item->gl_roles != ""){
                    $arr['opciones']    .= ' <button type="button" class="btn btn-xs btn-primary"
                                                onclick="MantenedorUsuario.cambiarUsuario(\''.$item->gl_token.'\');"
                                                data-toggle="tooltip" title="'.\Traduce::texto("Utilizar Usuario").'"><i class="fa fa-user"></i>
                                            </button>
                                            ';
                }
                
                if($item->bo_activo == 1){
                    $arr['opciones']    .= ' <button type="button" class="btn btn-xs btn-danger"
                                                onclick="MantenedorUsuario.habilitarUsuario(\''.$item->gl_token.'\',0);"
                                                data-toggle="tooltip" title="'.\Traduce::texto("Deshabilitar").'"><i class="fas fa-ban"></i>
                                            </button>
                                            ';
                }else{
                    $arr['opciones']    .= ' <button type="button" class="btn btn-xs btn-success"
                                                onclick="MantenedorUsuario.habilitarUsuario(\''.$item->gl_token.'\',1);"
                                                data-toggle="tooltip" title="'.\Traduce::texto("Habilitar").'"><i class="fas fa-check"></i>
                                            </button>
                                            ';
                }

                $arrGrilla['data'][] = $arr;
            }
        }

        echo json_encode($arrGrilla);
	}

	/**
	 * Descripción	: Cargar vista agregar Usuario
	 * @author		: <david.guzman@cosof.cl>        - 05/08/2020
	 */
	public function agregarUsuario()
	{
		$this->session->isValidate();

		$arrProfesion   = $this->_DAOProfesion->getListaOrdenada();
        $arrRegion      = $this->_DAORegion->getLista();
        $arrComuna      = $this->_DAOComuna->getLista();
        $arrCodRegion   = $this->_DAOCodigoRegion->getLista();

        $this->view->addJS('$("#fc_nacimiento_usuario").datepicker({language:"es", format: "dd/mm/yyyy", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
		$this->view->addJS('$(".labelauty").labelauty();');
		$this->view->set('arrProfesion', $arrProfesion);
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrComuna', $arrComuna);
		$this->view->set('arrCodRegion', $arrCodRegion);

		$this->view->set('datosUsuario',   $this->view->fetchIt('usuario/datos_usuario'));
		$this->view->render('usuario/agregar_usuario.php');
	}

	/**
	 * Descripción : Guardar Nuevo Usuario
	 * @author     : <david.guzman@cosof.cl>    - 05/08/2020
	 */
	public function agregarUsuarioBD()
	{
		$this->session->isValidate();
        $params 	        = $this->request->getParametros();
		$correcto           = false;
        $error              = false;
        $gl_rut             = trim($params['gl_rut_usuario']);
        $gl_email           = trim($params['gl_email_usuario']);
		$pass               = "123"; //mb_substr($gl_email, 0, 4);
		$gl_password        = \Seguridad::generar_sha512($pass);
		$mu_pass            = \Seguridad::generar_sha1($pass);
		$gl_token           = \Seguridad::generaTokenUsuario($gl_rut);
        $idUsuario          = (isset($_SESSION[\Constantes::SESSION_BASE]['id']))?$_SESSION[\Constantes::SESSION_BASE]['id']:0;
        $msgError           = "";
        //$gl_valida_email    = \Seguridad::generar_sha1($gl_email);
        $gl_rut_2           = \DataValidator::formatearRut($gl_rut); //(con puntos y guion)

        if ($gl_rut == "") {
            $msgError .= "- Rut es Obligatorio. <br>";
        }
        if (!\Validar::validarRutPersona($gl_rut)) {
            $msgError .= "- Rut es Incorrecto. <br>";
        }
        if ($gl_email == "") {
            $msgError .= "- Email es Obligatorio. <br>";
        }
        if (!\Email::validar_email($gl_email)) {
            $msgError .= "- Email es Incorrecto. <br>";
        }
        if (trim($params['gl_nombre_usuario']) == "") {
            $msgError .= "- Nombre es Obligatorio. <br>";
        }
        if (trim($params['gl_apellido_paterno_usuario']) == "") {
            $msgError .= "- Apellido Paterno es Obligatorio. <br>";
        }
        if (trim($params['gl_apellido_materno_usuario']) == "") {
            $msgError .= "- Apellido Materno es Obligatorio. <br>";
        }
        if ($params['id_profesion_usuario'] == 0) {
            //$msgError .= "- Profesión es Obligatorio. <br>";
        }
        if (!isset($params['chk_genero_usuario'])) {
            $msgError .= "- Género es Obligatorio. <br>";
        }
        if (trim($params['fc_nacimiento_usuario']) == "") {
            $msgError .= "- Fecha Nacimiento es Obligatorio. <br>";
        }
        if ($params['id_region_usuario'] == 0) {
            $msgError .= "- Región es Obligatorio. <br>";
        }
        if ($params['id_comuna_usuario'] == 0) {
            $msgError .= "- Comuna es Obligatorio. <br>";
        }
        if (trim($params['gl_direccion_usuario']) == "") {
            $msgError .= "- Dirección es Obligatorio. <br>";
        }

        if ($msgError == "") {

            $datosUsuario   = array(
                                    $gl_token,
                                    $gl_rut_2,
                                    $gl_rut,
                                    trim($params['gl_nombre_usuario']),
                                    trim($params['gl_apellido_paterno_usuario']),
                                    trim($params['gl_apellido_materno_usuario']),
                                    //intval($params['id_profesion_usuario']),
                                    ($params['chk_genero_usuario']=="M")?"Masculino":"Femenino",
                                    (!empty($params['fc_nacimiento_usuario']))?\Fechas::formatearBaseDatosSinComilla($params['fc_nacimiento_usuario']):"0000-00-00 00:00:00",
                                    $gl_email,
                                    $params['id_region_usuario'],
                                    $params['id_comuna_usuario'],
                                    $params['gl_direccion_usuario'],
                                    $params['id_codregion_usuario'],
                                    $params['gl_telefono_usuario'],
                                    $gl_password,
                                    $mu_pass,
                                    1 //activo
                                );

            $id_usuario     = $this->_DAOUsuario->insertNuevo($datosUsuario);

            if($id_usuario > 0){
                $correcto       = true;

                //Guardar profesion de usuario
                if($params['id_profesion_usuario'] > 0){
                    $this->_DAOProfesion->insertar(array($id_usuario,$params['id_profesion_usuario']));
                }

                /*
                $arr_tag        = array("[TAG_NOMBRE_CREADOR]");
                $arr_replace    = array($_SESSION[\Constantes::SESSION_BASE]['gl_nombre_completo']);
                \Evento::eventoUsuario(1,$id_usuario,"",$arr_tag,$arr_replace);

                //Envio de Email para confirmar creacion de usuario
                $arrInfo        = array(
                                        "gl_nombre"     => trim($params['gl_nombre_usuario']),
                                        "gl_apellido"   => trim($params['gl_apellido_usuario']),
                                        "gl_url"        => \pan\uri\Uri::getHost()."Farmacia/Usuario/Login/validarEmail/".$gl_valida_email,
                                        "gl_hash"       => $gl_valida_email,
                                        "fecha"         => \Fechas::fechaHoyVista(),
                );
                $asunto         = "Confirmar Email - HOPE OPS WEB";
                $html_email     = $this->view->fetchIt('email/validar_creacion_usuario', $arrInfo, '_FuncionesGenerales');
                $respuestaEmail = \Email::sendEmail($gl_email, $asunto, $html_email);

                if($respuestaEmail['correcto']){
                    $this->_DAOUsuario->marcarEmailEnviado($id_usuario);
                }
                */
            }else{
                $error      = true;
                $msgError   = "Hubo un problema al guardar. Favor Comunicarse con Mesa de Ayuda.";
            }
        }

		$json   = array("correcto" => $correcto, "error" => $error, "msgError" => $msgError);

        echo json_encode($json);
	}

    /**
	* Descripción	: Desplegar Formulario para Editar Usuario
	* @author		: David Guzmán <david.guzman@cosof.cl> - 05/08/2020
	*/
	public function editarUsuario($gl_token){

        $arrUsuario     = $this->_DAOUsuario->getByToken($gl_token);
        $arrProfesion   = $this->_DAOProfesion->getListaOrdenada();
        $arrRegion      = $this->_DAORegion->getLista();
        $arrComuna      = $this->_DAOComuna->getLista();
        $arrCodRegion   = $this->_DAOCodigoRegion->getLista();

        $this->view->addJS('$("#fc_nacimiento_usuario").datepicker({language:"es", format: "dd/mm/yyyy", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
		$this->view->addJS('$(".labelauty").labelauty();');
		$this->view->set('arrProfesion', $arrProfesion);
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrComuna', $arrComuna);
		$this->view->set('arrCodRegion', $arrCodRegion);
		$this->view->set('arr', $arrUsuario);
		$this->view->set('boEditar', 1);
		$this->view->set('gl_token', 1);

		$this->view->set('datosUsuario',   $this->view->fetchIt('usuario/datos_usuario'));
        $this->view->render('usuario/agregar_usuario.php');

	}

	/**
	* Descripción : Guardar Datos Editados de Usuario
	* @author David Guzmán <david.guzman@cosof.cl> - 05/08/2020
	*/
	public function editarUsuarioBD(){

		$params         = $this->request->getParametros();
		$correcto       = false;
		$error          = false;
        $gl_rut         = trim($params['gl_rut_usuario']);
        $gl_email       = trim($params['gl_email_usuario']);
        $idUsuario      = (isset($_SESSION[\Constantes::SESSION_BASE]['id']))?$_SESSION[\Constantes::SESSION_BASE]['id']:0;
        $msgError       = "";
        $arrUsuario     = $this->_DAOUsuario->getByToken($params['gl_token_usuario']);

        if ($gl_rut == "") {
            $msgError .= "- Rut es Obligatorio. <br>";
        }
        if (!\Validar::validarRutPersona($gl_rut)) {
            $msgError .= "- Rut es Incorrecto. <br>";
        }
        if ($gl_email == "") {
            $msgError .= "- Email es Obligatorio. <br>";
        }
        if (!\Email::validar_email($gl_email)) {
            $msgError .= "- Email es Incorrecto. <br>";
        }
        if (trim($params['gl_nombre_usuario']) == "") {
            $msgError .= "- Nombre es Obligatorio. <br>";
        }
        if (trim($params['gl_apellido_paterno_usuario']) == "") {
            $msgError .= "- Apellido Paterno es Obligatorio. <br>";
        }
        if (trim($params['gl_apellido_materno_usuario']) == "") {
            $msgError .= "- Apellido Materno es Obligatorio. <br>";
        }
        if ($params['id_profesion_usuario'] == 0) {
            //$msgError .= "- Profesión es Obligatorio. <br>";
        }
        if (!isset($params['chk_genero_usuario'])) {
            $msgError .= "- Género es Obligatorio. <br>";
        }
        if (trim($params['fc_nacimiento_usuario']) == "") {
            $msgError .= "- Fecha Nacimiento es Obligatorio. <br>";
        }
        if ($params['id_region_usuario'] == 0) {
            $msgError .= "- Región es Obligatorio. <br>";
        }
        if ($params['id_comuna_usuario'] == 0) {
            $msgError .= "- Comuna es Obligatorio. <br>";
        }
        if (trim($params['gl_direccion_usuario']) == "") {
            $msgError .= "- Dirección es Obligatorio. <br>";
        }

        if ($msgError == "") {

            $datosUsuario   = array(
                                    trim($params['gl_nombre_usuario']),
                                    trim($params['gl_apellido_paterno_usuario']),
                                    trim($params['gl_apellido_materno_usuario']),
                                    //intval($params['id_profesion_usuario']),
                                    ($params['chk_genero_usuario']=="M")?"Masculino":"Femenino",
                                    (!empty($params['fc_nacimiento_usuario']))?\Fechas::formatearBaseDatosSinComilla($params['fc_nacimiento_usuario']):"0000-00-00 00:00:00",
                                    $gl_email,
                                    $params['id_region_usuario'],
                                    $params['id_comuna_usuario'],
                                    $params['gl_direccion_usuario'],
                                    $params['id_codregion_usuario'],
                                    $params['gl_telefono_usuario']
            );

            $correcto       = $this->_DAOUsuario->modificar($params['gl_token_usuario'],$datosUsuario);

            if($correcto){
                $arr_tag        = array("[TAG_NOMBRE_CREADOR]");
                $arr_replace    = array($_SESSION[\Constantes::SESSION_BASE]['gl_nombre_completo']);
                //\Evento::eventoUsuario(2,$arrUsuario->id_usuario,"",$arr_tag,$arr_replace);
            }
        }else{
            $error      = true;
            $msgError   = "Hubo un problema al guardar. Favor Comunicarse con Mesa de Ayuda.";
        }

		$json			= array("correcto" => $correcto, "error" => $error);

        echo json_encode($json);
	}

	/**
	* Descripción	: Guardar datos rol de Usuario en BD
	* @author		: David Guzmán <david.guzman@cosof.cl> - 05/08/2020
	*/
	public function agregarRolUsuarioBD(){

		$params             = $this->request->getParametros();
        $boModificado       = false;
        $mensaje            = '';
        $arrRegionRol       = array("2","3","5","9","12","13","15");
        $arrTerritorioRol   = array("3","5","13");
        $gl_token_usuario   = $params['gl_token_usuario'];
        $id_rol_usuario     = (isset($params['chk_institucional']) && $params['chk_institucional'] == 1)?$params['id_rol_institucional_usuario']:$params['id_rol_no_institucional_usuario'];
		$arrUsuario         = $this->_DAOUsuario->getByToken($gl_token_usuario);
        $bo_activo          = 1;
        $id_farmacia        = ($id_rol_usuario == 6)?$params['id_local_farmaceutico_usuario']:(($id_rol_usuario == 15)?$params['id_empresa_farmaceutica_usuario']:0);
        $id_local           = ($id_rol_usuario == 4 || $id_rol_usuario == 6)?$params['id_local_farmaceutico_usuario']:0;
        $id_bodega          = ($id_rol_usuario == 5)?$params['id_bodega_usuario']:0;
        $id_region          = (in_array($id_rol_usuario,$arrRegionRol))?$params['id_region_usuario']:0;
        $id_territorio      = (in_array($id_rol_usuario,$arrTerritorioRol))?$params['id_territorio_usuario']:0;
        $fc_inicio          = $params['fc_inicio_usuario'];
        $fc_termino         = $params['fc_termino_usuario'];
        $id_comuna          = 0;
        $id_localidad       = 0;
        $id_usuario         = $arrUsuario->id_usuario;
        
        //Si es Director Tecnico o Quimico Recepcionante
        if($id_rol_usuario == 4 || $id_rol_usuario == 6){
            $arrLocal       = $this->_DAOLocal->getById($id_local);
            $id_region      = $arrLocal->id_region_midas;
            $id_territorio  = $arrLocal->fk_territorio;
            $id_comuna      = $arrLocal->id_comuna_midas;
            $id_localidad   = $arrLocal->fk_localidad;
        }

        //Insertar o Actualizar Director Tecnico según el caso
        if($id_rol_usuario == 4){
            $arrDT = $this->_DAODirectorTecnico->getByLocalUsuario($id_local,$id_usuario,1);

            if($arrDT){
                if($fc_inicio <= $arrDT->direccion_fecha_termino){
                    $mensaje = "El Usuario Seleccionado corresponde al mismo DT actual</br>Pero su fecha de inicio no puede ser Menor a su Fecha de Termino";
                }else{
                    $this->_DAODirectorTecnico->setDTFechaTerminoyEstado($arrDT->DT_id,\Fechas::formatearBaseDatosSinComilla($fc_inicio),0);
                    $this->_DAOUsuarioRol->setActivoByLocalUsuarioRol($id_local,$arrDT->fk_usuario,$id_rol_usuario,0);
                }
            }else{
                //si no existe deshabilita al ultimo DT y su fecha de termino es fecha de inicio
            }

            $dataDT = array(
                                $id_local,
                                $id_usuario,
                                $fc_inicio,
                                $fc_termino,
                                1
            );
            //Inserto DT
            $this->_DAODirectorTecnico->insertar($dataDT);
        }

        $data               = array(
                                    $id_usuario,
                                    intval($id_rol_usuario),
                                    $bo_activo,
                                    intval($id_farmacia),
                                    intval($id_local),
                                    intval($id_bodega),
                                    intval($id_region),
                                    intval($id_territorio),
                                    intval($id_comuna),
                                    intval($id_localidad)
                                );

        //Verifico si existe rol asociado a usuario
        $arrUsuarioRol      = $this->_DAOUsuarioRol->obtRolUsuario($id_usuario,$id_rol_usuario);

		if(!empty($arrUsuarioRol)){

            if($arrUsuarioRol->mur_estado_activado == 0){
				$boActivado = $this->_DAOUsuarioRol->setActivo($arrUsuarioRol->mur_id,1);
            }else{
				$boModificado = $this->_DAOUsuarioRol->modificar($arrUsuarioRol->id_usuario_rol,$data);
			}

        }else{
			$boAgregado     = $this->_DAOUsuarioRol->insertar($data);
		}

		if($boModificado || $boActivado || $boAgregado > 0){
			$correcto	= true;
			$mensaje	= 'El rol se ha guardado exitosamente';
		}else{
			$correcto	= false;
			$mensaje	= 'Problemas al ingresar el nuevo rol';
		}

		$json	= array('correcto' => $correcto, 'mensaje' => $mensaje);
        echo json_encode($json);
	}

	/**
	* Descripción : Elimina Rol de Usuario
	* @author David Guzmán <david.guzman@cosof.cl> - 05/08/2020
	*/
	public function eliminaRolUsuario(){
		$json       = array("correcto" => false, "mensaje" => "Error: Hubo problemas para eliminar Rol");
        $params     = $this->request->getParametros();

        $bo_activo_upd  = $this->_DAOUsuarioRol->setActivo($params['id'],0);

        if($bo_activo_upd){
            $json	= array("correcto" => true, "mensaje" => "Rol Eliminado con Éxito");
        }

        echo json_encode($json);
	}

    /**
	* Descripción : Cargar Grilla Roles Usuario
	* @author David Guzmán <david.guzman@cosof.cl> - 05/08/2020
	*/
	public function grillaRolesUsuario(){
        $params         = $this->request->getParametros();
		$arrUsuario     = $this->_DAOUsuario->getByToken($params['gl_token']);
        $arrRolUsuario  = $this->_DAOUsuarioRol->obtRolesUsuario($arrUsuario->id_usuario);
		$this->view->set('arrRolUsuario',$arrRolUsuario);
		echo $this->view->render('usuario/grillaRolesUsuario.php');
	}

    /**
	* Descripción	: Desplegar Formulario para editar datos menu de Usuario
	* @author		: David Guzmán <david.guzman@cosof.cl> - 05/08/2020
	*/
	public function historialUsuario($gl_token){
        $arrHistorial   = $this->_DAOUsuarioHistorial->getByToken($gl_token);

		$this->view->set('arrHistorial',$arrHistorial);
		$this->view->set('gl_token',$gl_token);
        $this->view->addJS('Mantenedor_usuario.initTablaHistorial();');
		$this->view->render('usuario/historialUsuario.php');
	}

	/**
	* Descripción : Habilitar Usuario
	* @author David Guzmán <david.guzman@cosof.cl> - 05/08/2020
	*/
	public function habilitarUsuario(){
		$json       = array("correcto" => false);
        $params     = $this->request->getParametros();

        $bo_update  = $this->_DAOUsuario->setActivoByToken($params['gl_token'],$params['bo_activo']);

        if($bo_update){
            $json	= array("correcto" => true);
        }

        echo json_encode($json);
	}

    /**
	* Descripción	: Desplegar Formulario para Editar Modulos a los que puede acceder Usuario
	* @author		: David Guzmán <david.guzman@cosof.cl> - 05/08/2020
	*/
	public function editarRol($gl_token){

        $arrRolIns          = $this->_DAORol->getByIN("11,9,2,3,5,12,13"); //Roles Institucional
        $arrRolNoIns        = $this->_DAORol->getByIN("4,6,10,14,15"); //Roles No Institucional
        $arrRegion          = $this->_DAORegion->getLista();
        $arrTerritorio      = $this->_DAOTerritorio->getLista();
        $arrBodega          = $this->_DAOBodega->getLista();
        $arrProfesion       = $this->_DAOProfesion->getLista();
        $arrLocal           = $this->_DAOLocal->getLista();
        $arrFarmacia        = $this->_DAOFarmacia->getListaOrdenadaBy();
        $arrUsuario         = $this->_DAOUsuario->getByToken($gl_token);
        $id_usuario         = $arrUsuario->id_usuario;
        $arrRolUsuario      = $this->_DAOUsuarioRol->obtRolesUsuario($id_usuario);

        $this->view->addJS('$(".datepicker").datepicker({language:"es", format: "dd/mm/yyyy", autoclose: true}).on("hide", function(e) { e.stopPropagation();});');
		$this->view->addJS('$(".labelauty").labelauty();');
        $this->view->set("gl_token", $gl_token);
		$this->view->set('arrRolIns', $arrRolIns);
		$this->view->set('arrRolNoIns', $arrRolNoIns);
		$this->view->set('arrRegion', $arrRegion);
		$this->view->set('arrTerritorio', $arrTerritorio);
		$this->view->set('arrBodega', $arrBodega);
		$this->view->set('arrProfesion', $arrProfesion);
        $this->view->set('arrLocal', $arrLocal);
        $this->view->set('arrFarmacia', $arrFarmacia);
		$this->view->set('arrRolUsuario', $arrRolUsuario);

		$this->view->render('usuario/editar_rol.php');
	}

    /**
     * Despliega el rol de usuario
     */
    public function rol(){

        $this->view->addJS('maestroUsuario.js');
        $this->view->addJS('MantenedorUsuario.cargarActividad()');

        $getUsuario = $this->_DAOUsuario->getById($_SESSION['hope']['id_usuario']);
        $this->view->set('usuario', $getUsuario);

		$this->view->set('contenido', $this->view->fetchIt('usuario/rol_usuario'));
		$this->view->render();
    }

    /**
     * Realiza la carga de actividades y eventos
     * al rol de usuario
     */
    public function cargarGrillaActividad(){
        $params  = $this->request->getParametros();
        $getData = null;

        $this->view->set('arrDatos', ($getData != NULL ? $getData : array()));
        $this->view->render("usuario/grilla_actividad");
    }

    /*
        * Carga datos de rut persona por medio de WS
        * Creador: <david.guzman@cosof.cl> 07-08-2020
    */
    public function cargarPersonaWS(){

        $params         = $this->request->getParametros();
        $rut_dv         = $params['rut'];
        $data           = array();

        if (!is_null($rut_dv)) {

            $rut = explode('-',$rut_dv);
            if ($rut[0] && $rut[1]){
                $data = \Utils::getPersonaWS($rut);
                //$data = file_get_contents(URL_WS_RUT . '?rut='.$rut[0].'&dv='.$rut[1]);
            }
        }

        return json_encode($data);
    }

	/*
	 * Carga datos de rut persona por medio de WS
	 * Creador: <david.guzman@cosof.cl> 07-08-2020
	*/
	public function cargarPersonaWSJS(){

		$params				=	$this->request->getParametros();
		$rut_dv				=	$params['rut'];
		$data				=	array();

		if (!is_null($rut_dv)) {
			$rut			=	explode('-',$rut_dv);
			if ($rut[0] && $rut[1]){
				$data		=	\Utils::getPersonaWS($rut);
				if($data){
					$data	=	array(
						"persona"	=>	json_decode($data,TRUE)
					);
				}
			}
		}

		echo	json_encode($data);
	}
    
}
