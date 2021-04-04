<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripción       : Controlador de Mantenedor
 *
 * Plataforma        : PHP
 * 
 * Creación          : 08/05/2018
 * 
 * @name             Mantenedor.php
 * 
 * @version          1.0.0
 *
 * @author           Victor Retamal <victor.retamal@cosof.cl>
 * 
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha		Descripción 
 * ----------------------------------------------------------------------------
 *
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
class Mantenedor extends Controller{

    protected $_DAOPerfil;
    protected $_DAOPerfilOpcion;
	protected $_DAOOpcion;
    protected $_DAOUsuario;
    protected $_DAOWebService;
    protected $_DAORegion;
    protected $_DAOComuna;
    protected $_DAOEstablecimientoSalud;
    protected $_DAOTipoEspecialidad;
    protected $_DAOUsuarioPerfil;
    protected $_DAOServicioSalud;
    protected $_DAOEstablecimientoSaludTipo;
    protected $_Evento;
    protected $_DAORegularizar;
	
	function __construct(){
		parent::__construct();
        $this->load->lib('Seguridad', false);
		$this->load->lib('Fechas', false);
		$this->load->lib('Evento', false);
		$this->load->lib('UsuarioWS', false);
		$this->load->lib('Helpers/Validar', false);

        $this->_Evento                          = new Evento();
        $this->_DAOPerfil                       = $this->load->model("DAOAccesoPerfil");
		$this->_DAOOpcion                       = $this->load->model("DAOAccesoOpcion");
        $this->_DAOPerfilOpcion                 = $this->load->model("DAOAccesoPerfilOpcion");
        $this->_DAOUsuario                      = $this->load->model("DAOAccesoUsuario");
        $this->_DAOWebService                   = $this->load->model("DAOWebService");
        $this->_DAORegion                       = $this->load->model("DAODireccionRegion");
        $this->_DAOComuna                       = $this->load->model("DAODireccionComuna");
        $this->_DAOEstablecimientoSalud         = $this->load->model("DAOEstablecimientoSalud");
        $this->_DAOTipoEspecialidad             = $this->load->model("DAOTipoEspecialidad");
        $this->_DAOUsuarioPerfil                = $this->load->model("DAOAccesoUsuarioPerfil");
        $this->_DAOServicioSalud                = $this->load->model("DAOServicioSalud");
        $this->_DAOEstablecimientoSaludTipo     = $this->load->model("DAOEstablecimientoSaludTipo");
        $this->_DAORegularizar                  = $this->load->model("DAORegularizar");
	}

	/****************************** USUARIO ***********************************/
	/**
	* Descripción	: Cargar Grilla de Usuarios
	* @author		: Víctor Retamal <victor.retamal@cosof.cl>
	*/
	public function usuario(){
        Acceso::redireccionUnlogged($this->smarty);
        $arrRegiones	= $this->_DAORegion->getLista();
        $arrPerfiles	= $this->_DAOPerfil->getLista(1);
        $bo_nacional	= $_SESSION[SESSION_BASE]['bo_nacional'];
        $region         = ($_SESSION[SESSION_BASE]['id_region'] > 0 && !$bo_nacional)?$_SESSION[SESSION_BASE]['id_region']:0;
        $params         = array("id_region"=>$region);
        $jscode         = "setTimeout(function(){ $('#id_region').trigger('change'); $('#buscar').trigger('click'); },100);";
        
		$this->smarty->assign("region", $region);
		$this->smarty->assign("arrRegiones", $arrRegiones);
		$this->smarty->assign("arrPerfiles", $arrPerfiles);
		$this->smarty->assign('arr_data',$this->_DAOUsuario->getListaJoinPerfil($params));
        $this->_addJavascript($jscode);
		$this->_display('mantenedor_usuario/bandeja.tpl');
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_usuario.js');
		$this->load->javascript(STATIC_FILES.'js/regiones.js');
	}
    /**
	* Descripción	: Desplegar Grilla de Establecimiento
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function buscarUsuario(){
        $params     = $this->_request->getParams();
        $arrUsuario = $this->_DAOUsuario->getListaJoinPerfil($params);
        $arrGrilla  = array("data"=>array());
        
        if(!empty($arrUsuario)){
            foreach($arrUsuario as $item){
                $arr    = array();
                if($item->bo_activo == 1){
                    $arr['estado']  = '<div style="color:green;"> Activo </div>';
                }else{
                    $arr['estado']  = '<div style="color:red;"> Inactivo </div>';
                }
                
                $arr['rut']         = $item->gl_rut;
                $arr['nombre']      = $item->gl_nombres." ".$item->gl_apellidos;
                $arr['email']       = $item->gl_email;
                $arr['opciones']    = ' <button type="button" class="btn btn-xs btn-success"
                                            onclick="xModal.open(\''.BASE_URI.'/Mantenedor/editarUsuario/'.$item->gl_token.'\',\'Editar Usuario\',70);"
                                            data-toggle="tooltip" data-title="Editar Usuario"><i class="fa fa-edit"></i>
                                        </button>';
                
                $arrGrilla['data'][] = $arr;
            }
        }
        
        echo json_encode($arrGrilla);
	}

	/**
	* Descripción	: Desplegar Formulario para Agregar Usuario
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function agregarUsuario(){
		$arrRegiones		= $this->_DAORegion->getLista();
		$perfiles			= $this->_DAOPerfil->getLista(1);
		$tipoEspecialidad	= $this->_DAOTipoEspecialidad->getLista();
		$arrEstableSalud  	= $this->_DAOEstablecimientoSalud->getLista();
		
		$this->smarty->assign("arrRegiones", $arrRegiones);
		$this->smarty->assign('perfiles',$perfiles);
		$this->smarty->assign('tipoEspecialidad',$tipoEspecialidad);
		$this->smarty->assign('arrEstableSalud',$arrEstableSalud);
		
		$this->smarty->display('mantenedor_usuario/agregar.tpl');
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
        //$this->load->javascript('setTimeout(function(){$("#id_centro_salud_perfil").select2();},500);');
		$this->load->javascript(STATIC_FILES . "js/regiones.js");
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_usuario.js');
	}
	
	/**
	* Descripción : Verificar si Usuario Existe
	* @author David Guzmán <david.guzman@cosof.cl>
	*/
	public function existeUsuario(){
		header('Content-type: application/json');
		$rut			= $_POST['rut'];
		$correcto		= false;
		$no_valido		= false;
		$bool_get		= $this->_DAOUsuario->getByRut($rut);
        $arrWS          = UsuarioWS::cargarPersona($rut);
        $gl_nombres     = "";
        $gl_apellidos   = "";
        
        if(!(Validar::validarRut($rut))){$no_valido = true;}
		if($bool_get)                   {$correcto  = true;}
        
		if($arrWS){
            $gl_nombres     = $arrWS->nombresPersona;
            $gl_apellidos   = $arrWS->primerApellidoPersona ." ". $arrWS->segundoApellidoPersona;
        }
        
		$salida = array("correcto" => $correcto, "no_valido" => $no_valido, "gl_nombres" => $gl_nombres, "gl_apellidos" => $gl_apellidos);
        $json   = Zend_Json::encode($salida);

        echo $json;
	}
    
    /*funcion para cambiar password a usuarios produccion*/
/*
    public function cambioPassTodos(){
        $arr        = array();
        $usuarios   = $this->_DAOUsuario->getLista();
        
        if($usuarios){
            foreach($usuarios as $item){
                $password       = substr($item->gl_rut,0,4);
                $gl_password    = Seguridad::generar_sha512($password);
                $datos			= array($gl_password, $item->id_usuario);
                $upd			= $this->_DAOUsuario->setSoloPassword($datos);
                
                if($upd){
                    $arr[$item->id_usuario]['id_usuario']       = $item->id_usuario;
                    $arr[$item->id_usuario]['gl_rut']           = $item->gl_rut;
                    $arr[$item->id_usuario]['gl_password']      = $password;
                    $arr[$item->id_usuario]['gl_password_hash'] = $gl_password;
                }
            }
        }
        
        echo json_encode($arr);
    }
*/
    
    /*REGULARIZA DIRECCION EXPEDIENTE_MORDEDOR*/
    public function regularizaDireccionExpediente(){
        $arr        = array();
        $direccion  = $this->_DAORegularizar->getJsonDireccionMordedura();
        
        if($direccion){
            foreach($direccion as $item){
                $gl_direccion   = "";
                $gl_latitud     = "";
                $gl_longitud    = "";
                
                //CASO 1: con gl_referencia
                $json_original      = $item->json_direccion_mordedura;
                
                $json_referencia    = @explode('"gl_datos_referencia":"',$item->json_direccion_mordedura);
                if(isset($json_referencia[1])){
                    $json_referencia    = @str_replace('","gl_latitud":null,"gl_longitud":null}','',$json_referencia[1]);
                    $json_referencia    = @json_decode($json_referencia);
                
                
                    if(isset($json_referencia->direccion)){
                        $arr_direccion      = @explode('","gl_datos_referencia":"',$item->json_direccion_mordedura);
                        if(isset($arr_direccion[0])){
                            $direccion      = @explode('{"gl_direccion":"',$arr_direccion[0]);

                            $gl_direccion = (isset($arr_direccion[1])&&$arr_direccion[1]!="")?$arr_direccion[1]:$json_referencia->direccion;

                            $gl_latitud     = (isset($json_referencia->coords->lat))?$json_referencia->coords->lat:"";
                            $gl_longitud    = (isset($json_referencia->coords->lng))?$json_referencia->coords->lng:"";

                        }
                    }
                }
                
                //CASO 2: con direccion json
                $json           = @str_replace('{"gl_direccion":"','',$item->json_direccion_mordedura);
                $json           = @str_replace('","gl_datos_referencia":"","gl_latitud":null,"gl_longitud":null}','',$json);
                $json           = @json_decode($json);

                if(isset($json->direccion)){
                    $gl_direccion   = $json->direccion;

                    $gl_latitud     = (isset($json->coords->lat))?$json->coords->lat:"";
                    $gl_longitud    = (isset($json->coords->lng))?$json->coords->lng:"";

                }
                
                if($gl_direccion != ""){
                    $json_direccion = array("gl_direccion"          => $gl_direccion,
                                            "gl_datos_referencia"   => "",
                                            "gl_latitud"            => $gl_latitud,
                                            "gl_longitud"           => $gl_longitud,
                                            "img_direccion"         => "");

                    //Edito json_direccion_mordedura expediente
                    $this->_DAORegularizar->setJsonDireccionMordedura($item->id_expediente,json_encode($json_direccion));
                }
                error_log("ID:".$item->id_expediente);
            }
        }
        
        error_log("FIN");
        echo json_encode($arr);
    }
    
    /*REGULARIZA DIRECCION ANIMAL_MORDEDOR*/
    public function regularizaDireccionAnimalMordedor(){
        $arr        = array();
        $mordedor   = $this->_DAORegularizar->getJsonDireccion();
        
        if($mordedor){
            foreach($mordedor as $item){
                
                $id_mordedor    = $item->id_mordedor;
                
                $json       = str_replace('{"gl_direccion":"','',$item->json_direccion);
                $json       = str_replace('","gl_direccion_coordenadas":null,"gl_direccion_detalles":null}','',$json);
                $json       = json_decode($json);
                
                if(isset($json->direccion)){
                    $json_direccion     = array("gl_direccion"              =>  $json->direccion,
                                                "gl_direccion_coordenadas"  =>  "",
                                                "gl_direccion_detalles"     =>  "");
                    
                    //Edito json_direccion animal_mordedor
                    $this->_DAORegularizar->setJsonDireccion($id_mordedor,json_encode($json_direccion));
                }
            }
        }
        
        error_log("FIN");
        echo json_encode($arr);
    }
    
    /*REGULARIZA DIRECCION ANIMAL_MORDEDOR*/
    public function regularizaDireccionPacienteContacto(){
        $arr        = array();
        $mordedor   = $this->_DAORegularizar->getJsonDireccionPaciente();
        
        if($mordedor){
            foreach($mordedor as $item){
                
                $id_paciente_contacto   = $item->id_paciente_contacto;
                
                $json       = @explode(',"gl_direccion":"',$item->json_dato_contacto);
                
                $json1      = $json[0]."}";
                $json1      = json_decode($json1);
                
                $json2      = @explode('","gl_datos_referencia":',$json[1]);
                $json2      = substr($json2[0], 0, strpos($json2[0],"}")+2);
                $json2      = json_decode($json2);
                
                if(isset($json1->region_contacto) && isset($json2->direccion)){
                    $region = $this->_DAORegion->getById($json1->region_contacto);
                    $comuna = $this->_DAOComuna->getById($json1->comuna_contacto);
                    $json_direccion = array("region_contacto"       =>$json1->region_contacto,
                                            "comuna_contacto"       =>$json1->comuna_contacto,
                                            "gl_direccion"          =>$json2->direccion,
                                            "gl_datos_referencia"   =>"",
                                            "gl_latitud"            =>$json2->coords->lat,
                                            "gl_longitud"           =>$json2->coords->lng,
                                            "gl_region"             =>$region->gl_nombre_region,
                                            "gl_comuna"             =>$comuna->gl_nombre_comuna,
                                            "id_tipo_contacto"      =>3,
                                            "gl_tipo_contacto"      =>"Dirección",
                                            "img_direccion"         =>"");
                    
                    //Edito json_direccion animal_mordedor
                    $this->_DAORegularizar->setJsonDireccionPaciente($id_paciente_contacto,json_encode($json_direccion));
                    
                    error_log("ID: ".$id_paciente_contacto);
                }
            }
        }
        
        error_log("FIN");
        echo json_encode($arr);
    }
    
    /*REGULARIZA DIRECCION EXPEDIENTE_MORDEDOR*/
    public function regularizaDireccionExpedienteMordedor(){
        $arr            = array();
        $arrMordedor    = $this->_DAORegularizar->getListaExpedienteMordedor();
        
        if($arrMordedor){
            foreach($arrMordedor as $item){
                
                $id_expediente_mordedor = $item->id_expediente_mordedor;
                $json_mordedor          = $item->json_mordedor;
                
                if(empty($json_mordedor)){
                    $mordedor       = $this->_DAORegularizar->getAnimalMordedorById($item->id_mordedor);
                    
                    if($mordedor){
                        $direccion              = json_decode($mordedor->json_direccion);
                        $otros_datos            = json_decode($mordedor->json_otros_datos);
                        
                        $arrAnimalEspecie  		= $this->_DAORegularizar->getAnimalEspecieById($mordedor->id_animal_especie);
                        $arrAnimalRaza  		= $this->_DAORegularizar->getAnimalRazaById($mordedor->id_animal_raza);
                        $arrAnimalTamano  		= $this->_DAORegularizar->getAnimalTamanoById($mordedor->id_animal_tamano);
                        $animal_grupo           = $this->_DAORegularizar->getAnimalGrupoById($mordedor->id_animal_grupo);
                        $region             	= $this->_DAORegion->getById($mordedor->id_region);
                        $comuna             	= $this->_DAOComuna->getById($mordedor->id_comuna);
                        
                        $id_animal_especie      = $mordedor->id_animal_especie;
                        $id_animal_raza         = $mordedor->id_animal_raza;
                        $gl_especie_animal      = (!empty($arrAnimalEspecie))?$arrAnimalEspecie->gl_nombre:'';;
                        $nombre_animal          = $mordedor->gl_nombre;
                        $gl_color_animal        = (isset($otros_datos->gl_color_animal))?$otros_datos->gl_color_animal:"";
                        $id_animal_tamano       = $mordedor->id_animal_tamano;
                        $bo_vive_con_paciente   = ($mordedor->id_dueno==$item->id_paciente)?1:0;
                        $bo_paciente_dueno      = $mordedor->bo_vive_con_dueno;
                        $gl_direccion           = $direccion->gl_direccion;
                        $id_region_animal       = (!empty($region))?$region->id_region:'';
                        $id_comuna_animal       = (!empty($comuna))?$comuna->id_comuna:'';
                        $bo_domicilio_conocido  = $mordedor->bo_domicilio_conocido;
                        $id_animal_grupo        = $mordedor->id_animal_grupo;
                        $gl_grupo_animal        = (!empty($animal_grupo))?$animal_grupo->gl_nombre:"";
                        $gl_observaciones_mordedor  = (isset($otros_datos->gl_apariencia))?$otros_datos->gl_apariencia:"";
                        
                        $gl_raza_animal         = (!empty($arrAnimalRaza))?$arrAnimalRaza->gl_nombre:'';
                        $gl_tamano_animal       = (!empty($arrAnimalTamano))?$arrAnimalTamano->gl_nombre:'';
                        $gl_region              = (!empty($region))?$region->gl_nombre_region:'';
                        $gl_comuna              = (!empty($comuna))?$comuna->gl_nombre_comuna:'';
                    
                    
                        $arr_mordedor   = array("id_animal_especie"         =>  $id_animal_especie,
                                                "id_animal_raza"            =>  $id_animal_raza,
                                                "nombre_animal"             =>  $nombre_animal,
                                                "gl_color_animal"           =>  $gl_color_animal,
                                                "id_animal_tamano"          =>  $id_animal_tamano,
                                                "bo_vive_con_paciente"      =>  $bo_vive_con_paciente,
                                                "bo_paciente_dueno"         =>  $bo_paciente_dueno,
                                                "gl_direccion"              =>  $gl_direccion,
                                                "gl_referencias_animal"     =>  "",
                                                "gl_latitud_animal"         =>  "",
                                                "gl_longitud_animal"        =>  "",
                                                "id_region_animal"          =>  $id_region_animal,
                                                "id_comuna_animal"          =>  $id_comuna_animal,
                                                "bo_domicilio_conocido"     =>  $bo_domicilio_conocido,
                                                "gl_especie_animal"         =>  $gl_especie_animal,
                                                "gl_raza_animal"            =>  $gl_raza_animal,
                                                "gl_tamano_animal"          =>  $gl_tamano_animal,
                                                "gl_region"                 =>  $gl_region,
                                                "gl_comuna"                 =>  $gl_comuna,
                                                "id_animal_grupo"           =>  $id_animal_grupo,
                                                "gl_grupo_animal"           =>  $gl_grupo_animal,
                                                "gl_observaciones_mordedor" =>  $gl_observaciones_mordedor,
                                                "gl_folio_mordedor"         =>  $item->gl_folio_mordedor,
                                                "img_direccion"             =>  "");

                        //Edito json_direccion animal_mordedor
                        $this->_DAORegularizar->setJsonExpedienteMordedor($id_expediente_mordedor,json_encode($arr_mordedor));
                        
                        error_log("ID: ".$id_expediente_mordedor);
                    }
                    
                }
            }
        }
        
        error_log("FIN");
        echo json_encode($arr);
    }
	
	/**
	* Descripción : Guardar Nuevo Usuario
	* @author David Guzmán <david.guzman@cosof.cl>
	*/
	public function agregarUsuarioBD(){
		header('Content-type: application/json');
		$parametros     = $this->_request->getParams();
		$correcto       = false;
		$error          = false;
        $password       = substr($parametros['gl_rut'],0,4);
        $gl_password    = Seguridad::generar_sha512($password);
	//$gl_password    = Seguridad::generar_sha512('123');
        $gl_token       = Seguridad::generaTokenUsuario($parametros['gl_rut']);

        $datosUsuario   = array(
								$gl_token,
								trim($parametros['gl_rut']),
								$gl_password,
								$parametros['gl_nombres'],
								$parametros['gl_apellidos'],
								$parametros['gl_email'],
								$parametros['bo_cambio_usuario'],
								$parametros['bo_informar_web']
							);
        
		$id_usuario     = $this->_DAOUsuario->insertNuevo($datosUsuario);

        $datosPerfil    = array(
								"id_usuario"            => $id_usuario,
								"id_region"             => $parametros['id_region_perfil'],
								"id_oficina"            => $parametros['id_oficina'],
								"id_comuna"             => $parametros['id_comuna'],
								"id_establecimiento"    => $parametros['id_establecimiento'],
								"id_servicio"           => $parametros['id_servicio'],
								"id_perfil"             => $parametros['id_perfil'],
								"nr_correlativo"        => 1,
								"bo_principal"          => 1
							);

        $id_usu_perfil	= $this->_DAOUsuarioPerfil->insPerfilUsuario($datosPerfil);

        if($id_usuario > 0 && $id_usu_perfil > 0){
            $correcto			= true;
			$gl_rut				= trim($parametros['gl_rut']);
			$gl_nombres			= urlencode($parametros['gl_nombres']);
			$gl_apellidos		= urlencode($parametros['gl_apellidos']);
			$gl_email			= $parametros['gl_email'];
			$id_region			= $parametros['id_region_perfil'];
			
			$url_usuario_midas	= URL_USUARIO_MIDAS.'?rut='.$gl_rut.'&nombres='.$gl_nombres.'&apellidos='.$gl_apellidos.'&email='.$gl_email.'&region='.$id_region;
			@file_get_contents($url_usuario_midas);
        }else{
            $error = true;
        }
        
		$salida			= array("correcto" => $correcto, "error" => $error);
        $json			= Zend_Json::encode($salida);

        echo $json;
	}

	/**
	* Descripción	: Editar Usuario
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	* @param string $gl_token Token del usuario a Editar
	*/
	public function editarUsuario(){
		Acceso::redireccionUnlogged($this->smarty);
		
		$parametros	= $this->request->getParametros();
		$gl_token	= $parametros[0];
        
		$arrRegiones		= $this->_DAORegion->getLista();
		$arrComunas			= $this->_DAOComuna->getLista();
		$arrEstableSalud    = $this->_DAOEstablecimientoSalud->getLista();
		$perfiles           = $this->_DAOPerfil->getLista(1);
		$data				= $this->_DAOUsuario->getDetalleByToken($gl_token);
		$perfiles_usuario  	= $this->_DAOUsuarioPerfil->getByUsuario($data->id_usuario);
		
		$this->smarty->assign("arrRegiones", $arrRegiones);
		$this->smarty->assign("arrComunas", $arrComunas);
		$this->smarty->assign("arrEstableSalud", $arrEstableSalud);
		$this->smarty->assign('itm',$data);
		$this->smarty->assign('perfiles_usuario',$perfiles_usuario);
		$this->smarty->assign('perfiles',$perfiles);
		$this->smarty->assign('bo_ver',0);
		
		$this->smarty->display('mantenedor_usuario/editar.tpl');
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
		$this->load->javascript(STATIC_FILES . "js/regiones.js");
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_usuario.js');
	}

	/**
	* Descripción : Guardar los datos Editados del Usuario
	* @author David Guzmán <david.guzman@cosof.cl>
	*/
	public function editarUsuarioBD(){
		header('Content-type: application/json');
		$parametros	= $this->_request->getParams();
		$correcto	= false;
		$error		= false;
        $usuario    = $this->_DAOUsuario->getDetalleByToken($parametros['gl_token']);
        $parametros['id_usuario'] = $usuario->id_usuario;
        
        if(isset($parametros['id_principal'])){
            $this->_DAOUsuarioPerfil->uptPrincipalTodos($usuario->id_usuario,0);
            $this->_DAOUsuarioPerfil->uptPrincipal($parametros['id_principal'],1);
            unset($parametros['id_principal']);
        }
        unset($parametros['region']);
        
		$bool_update	= $this->_DAOUsuario->updateUsuario($parametros);
		if($bool_update){
			$correcto	= true;
		}else{
			$error		= true;
		}

		$salida			= array("correcto" => $correcto, "error" => $error);
        $json			= Zend_Json::encode($salida);

        echo $json;
	}
    
    /**
	* Descripción : Guardar los datos Editados del Usuario
	* @author David Guzmán <david.guzman@cosof.cl>
	*/
	public function guardaPerfilUsuario(){
		header('Content-type: application/json');
		$params         = $this->_request->getParams();
		$correcto       = false;
		$error          = false;
        $json           = array("correcto" => false, "mensaje" => "Error: Hubo problemas para insertar nuevo Rol");
        $id_uora        = 0;
        $nr_correlativo = 0;
        $usuario        = $this->_DAOUsuario->getDetalleByToken($params['gl_token']);
        
        $data       = array($usuario->id_usuario,$params['id_region'],$params['id_oficina'],$params['id_comuna'],$params['id_establecimiento'],$params['id_servicio'],$params['id_perfil'],0);
        $perfil_usu = $this->_DAOUsuarioPerfil->getSimilarInactivo($data);

        //Si ya existe Perfil => activa el que está inhabilitado o si no lo crea
        if(isset($perfil_usu->id_usuario_perfil)){
            $this->_DAOUsuarioPerfil->uptActivo($perfil_usu->id_usuario_perfil,1);
            $id_usu_perfil  = $perfil_usu->id_usuario_perfil;
        }else{
            //Inserto correlativo (si ya tiene mismo usuario con misma region se guarda ese o se crea nuevo)
            $arr_corr_uora			= $this->_DAOUsuarioPerfil->getByRegionAndUsuario(array($usuario->id_usuario,$params['id_region']));
            
            if(isset($arr_corr_uora->row_0->nr_correlativo)){
                $nr_correlativo     = $arr_corr_uora->row_0->nr_correlativo;
            }else{
                $correlativo_uora	= $this->_DAOUsuarioPerfil->getMaxCorrelativoByRegion($params['id_region']);
                $nr_correlativo		= (isset($correlativo_uora->max_correlativo)) ? $correlativo_uora->max_correlativo+1 : 1;
            }

			$data       = array("id_usuario"            => $usuario->id_usuario,
								"id_region"             => $params['id_region'],
								"id_oficina"            => $params['id_oficina'],
								"id_comuna"             => $params['id_comuna'],
								"id_establecimiento"    => $params['id_establecimiento'],
								"id_servicio"           => $params['id_servicio'],
								"id_perfil"             => $params['id_perfil'],
								"nr_correlativo"        => $nr_correlativo,
								"bo_principal"          => 0);
            $id_usu_perfil	= $this->_DAOUsuarioPerfil->insPerfilUsuario($data);
        }
        
        if($id_usu_perfil > 0){
            $rol_secundario     = $this->_DAOUsuarioPerfil->getByUsuario($usuario->id_usuario);
            if(!isset($rol_secundario->row_1)){
                $this->_DAOUsuarioPerfil->uptPrincipal($id_usu_perfil,1);
            }
            $json = array("correcto" => true, "mensaje" => "Rol Insertado con Éxito");
        }

        echo Zend_Json::encode($json);
	}

	/**
	* Descripción : Cargar Grilla Perfiles Usuario
	* @author David Guzmán <david.guzman@cosof.cl> 10/05/2018
	*/
	public function grillaPerfilesUsuario(){
        $params     = $this->_request->getParams();
        $usuario    = $this->_DAOUsuario->getDetalleByToken($params['gl_token']);
		$this->smarty->assign('perfiles_usuario',$this->_DAOUsuarioPerfil->getByUsuario($usuario->id_usuario));
		echo $this->smarty->display('mantenedor_usuario/grilla-perfiles-usuario.tpl');
	}

	/**
	* Descripción : Elimina Perfil de Usuario
	* @author David Guzmán <david.guzman@cosof.cl> 11/05/2018
	*/
	public function eliminaPerfilUsuario(){
		$json       = array("correcto" => false, "mensaje" => "Error: Hubo problemas para eliminar Perfil");
        $params     = $this->_request->getParams();
        
        $usuario        = $this->_DAOUsuario->getDetalleByToken($params['gl_token']);
        $perfil_usu     = $this->_DAOUsuarioPerfil->getById($params['id']);
        $bo_delete      = $this->_DAOUsuarioPerfil->uptActivo($params['id'],0);
        $bo_update      = $this->_DAOUsuarioPerfil->uptPrincipal($params['id'],0);
        $perfiles_usu   = $this->_DAOUsuarioPerfil->getByUsuario($usuario->id_usuario);

        if($bo_delete && $bo_update){
            if($perfil_usu->bo_principal==1 && isset($perfiles_usu->row_0)){
                //Si era bo_principal=1, dejar bo_principal = 1 al perfil siguiente
                $this->_DAOUsuarioPerfil->uptPrincipal($perfiles_usu->row_0->id_usuario_perfil,1);
            }
            $json	= array("correcto" => true, "mensaje" => "Perfil Eliminado con Éxito");
        }

        echo json_encode($json);
	}

	/**
	* Descripción : Actualizar Grilla Usuario
	* @author S/N
	*/
	public function updateGrillaUsuario(){
		$this->smarty->assign('arr_data',$this->_DAOUsuario->getLista());
		echo $this->view->fetch('mantenedor_usuario/grilla.tpl');
	}

	/**
	* Descripción	: Mostrar Formulario para Cambiar Usuario
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function cambiarUsuario(){
		$where		= array('bo_activo' => 1);
		
		if($_SESSION[SESSION_BASE]['id_usuario_original'] == 0){
			$this->smarty->assign('gl_token',$_SESSION[SESSION_BASE]['gl_token']);
		}else{
			$this->smarty->assign('gl_token',$_SESSION[SESSION_BASE]['gl_token_original']);
		}

		$this->smarty->assign('arr_data',$this->_DAOUsuario->getListaJoinPerfil($where));
		$this->smarty->display('mantenedor_usuario/cambiar_usuario.tpl');
        $this->load->javascript(STATIC_FILES . "js/plugins/select2/select2.full.min.js");
		$this->load->javascript(STATIC_FILES . "js/plugins/select2/i18n/es.js");
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_usuario.js');
	}

	/**
	* Descripción	: Procesar Cambio de Usuario
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	* @param int $id_usuario ID del Usuario
	* @param int $id_usuario_cambio ID del Usuario por el cual se cambiará
	*/
	public function procesarCambio(){
		$correcto				= false;
		$mensaje				= '';
		$parametros				= $this->_request->getParams();

		if(isset($parametros['gl_token'])){
            $usuario_original   = $this->_DAOUsuario->getDetalleByToken($parametros['gl_token']);
			$id_usuario			= $usuario_original->id_usuario;
			$bo_cambio_usuario  = $usuario_original->bo_cambio_usuario;
			$gl_token			= $usuario_original->gl_token;
			$gl_token_cambio	= $parametros['id_usuario_cambio'];
		}else{
			$parametros			= $_REQUEST;
			$usuario_original   = $this->_DAOUsuario->getDetalleByToken($parametros['gl_token']);
			$id_usuario			= $usuario_original->id_usuario;
			$bo_cambio_usuario  = $usuario_original->bo_cambio_usuario;
			$gl_token			= $usuario_original->gl_token;
			$gl_token_cambio	= $parametros['id_usuario_cambio'];
		}

		//revisar que id_usuario sea ADMIN

		$usu_cambio				= $this->_DAOUsuario->getDetalleByToken($gl_token_cambio);
        $usuario				= $this->_DAOUsuario->getLoginByID($usu_cambio->id_usuario);
		if($usuario){
			$correcto			= true;
            
			$_SESSION[SESSION_BASE]['id']						= $usuario->id_usuario;
			$_SESSION[SESSION_BASE]['id_usuario_original']      = $id_usuario;
			$_SESSION[SESSION_BASE]['gl_token_original']        = $gl_token;
			$_SESSION[SESSION_BASE]['perfil']					= $usuario->id_perfil;
            $_SESSION[SESSION_BASE]['id_usuario_perfil']        = $usuario->id_usuario_perfil;
            $_SESSION[SESSION_BASE]['id_establecimiento']       = $usuario->id_establecimiento;
			$_SESSION[SESSION_BASE]['id_servicio']              = $usuario->id_servicio;
			$_SESSION[SESSION_BASE]['id_laboratorio']			= $usuario->id_laboratorio;
			$_SESSION[SESSION_BASE]['id_oficina']				= $usuario->id_oficina;
			$_SESSION[SESSION_BASE]['id_comuna']				= $usuario->id_comuna;
			$_SESSION[SESSION_BASE]['bo_establecimiento']		= $usuario->bo_establecimiento;
			$_SESSION[SESSION_BASE]['bo_nacional']				= $usuario->bo_nacional;
            $_SESSION[SESSION_BASE]['bo_regional']				= $usuario->bo_regional;
            $_SESSION[SESSION_BASE]['bo_oficina']				= $usuario->bo_oficina;
            $_SESSION[SESSION_BASE]['bo_comunal']				= $usuario->bo_comunal;
			$_SESSION[SESSION_BASE]['bo_seremi']				= $usuario->bo_seremi;
			$_SESSION[SESSION_BASE]['gl_nombres']				= $usuario->gl_nombres;
			$_SESSION[SESSION_BASE]['gl_apellidos']				= $usuario->gl_apellidos;
			$_SESSION[SESSION_BASE]['nombre']					= $usuario->gl_nombres . ' ' . $usuario->gl_apellidos;
			$_SESSION[SESSION_BASE]['rut']                      = $usuario->gl_rut;
			$_SESSION[SESSION_BASE]['mail']                     = $usuario->gl_email;
			$_SESSION[SESSION_BASE]['id_region']				= $usuario->id_region;
            $_SESSION[SESSION_BASE]['bo_cambio_usuario']        = $usuario->bo_cambio_usuario;
            $_SESSION[SESSION_BASE]['bo_informar_web']          = ($usuario->id_perfil == 14)?1:$usuario->bo_informar_web;
            $_SESSION[SESSION_BASE]['bo_cambio_usuario_real']   = $bo_cambio_usuario;
			$_SESSION[SESSION_BASE]['primer_login']             = FALSE;
			$_SESSION[SESSION_BASE]['autenticado']              = TRUE;
            
            //Guarda historial Evento
            $id_evento_tipo = 6; //Cambio de Usuario
            $gl_descripcion = "Se cambia de Usuario: ".$usuario_original->gl_nombres." a Usuario: ".$usuario->gl_nombres;
			$this->_Evento->guardar($id_evento_tipo,0,0,0,$gl_descripcion);
		}else{
			$mensaje	= 'Hubo un problema.</b><br>Favor intentar nuevamente o contactarse con Soporte.';
		}
        
		$salida	= array("correcto" => $correcto, "mensaje" => $mensaje);
        $json	= Zend_Json::encode($salida);
        echo $json;
	}

	/**
	* Descripción	: Volver al Usuario Admin
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	* @param int $id_usuario_original ID del Usuario
	*/
	public function volver_usuario(){
		$correcto				= false;
		$mensaje				= '';
		$parametros				= $this->_request->getParams();
		$id_usuario_anterior	= $_SESSION[SESSION_BASE]['id'];
		$id_usuario_original	= $_SESSION[SESSION_BASE]['id_usuario_original'];
		
		$usuario_anterior   	= $this->_DAOUsuario->getLoginByID($id_usuario_anterior);
		$usuario				= $this->_DAOUsuario->getLoginByID($id_usuario_original);
		if($usuario){
			$correcto			= true;

            $_SESSION[SESSION_BASE]['id']					= $usuario->id_usuario;
            $_SESSION[SESSION_BASE]['id_usuario_original']	= 0;
			$_SESSION[SESSION_BASE]['gl_token_original']    = 0;
            $_SESSION[SESSION_BASE]['perfil']               = $usuario->id_perfil;
            $_SESSION[SESSION_BASE]['id_usuario_perfil']    = $usuario->id_usuario_perfil;
            $_SESSION[SESSION_BASE]['gl_token']             = $usuario->gl_token;
            $_SESSION[SESSION_BASE]['id_establecimiento']   = $usuario->id_establecimiento;
            $_SESSION[SESSION_BASE]['id_servicio']          = $usuario->id_servicio;
            $_SESSION[SESSION_BASE]['id_laboratorio']       = $usuario->id_laboratorio;
			$_SESSION[SESSION_BASE]['id_oficina']			= $usuario->id_oficina;
			$_SESSION[SESSION_BASE]['id_comuna']			= $usuario->id_comuna;
			$_SESSION[SESSION_BASE]['bo_establecimiento']	= $usuario->bo_establecimiento;
			$_SESSION[SESSION_BASE]['bo_nacional']			= $usuario->bo_nacional;
            $_SESSION[SESSION_BASE]['bo_regional']			= $usuario->bo_regional;
            $_SESSION[SESSION_BASE]['bo_oficina']			= $usuario->bo_oficina;
            $_SESSION[SESSION_BASE]['bo_comunal']			= $usuario->bo_comunal;
			$_SESSION[SESSION_BASE]['bo_seremi']			= $usuario->bo_seremi;
			$_SESSION[SESSION_BASE]['gl_nombres']			= $usuario->gl_nombres;
			$_SESSION[SESSION_BASE]['gl_apellidos']			= $usuario->gl_apellidos;
            $_SESSION[SESSION_BASE]['nombre']               = $usuario->gl_nombres . " " . $usuario->gl_apellidos;
            $_SESSION[SESSION_BASE]['rut']					= $usuario->gl_rut;
            $_SESSION[SESSION_BASE]['mail']					= $usuario->gl_email;
            $_SESSION[SESSION_BASE]['id_region']            = $usuario->id_region;
            $_SESSION[SESSION_BASE]['bo_cambio_usuario']    = $usuario->bo_cambio_usuario;
            $_SESSION[SESSION_BASE]['bo_informar_web']      = ($usuario->id_perfil == 14)?1:$usuario->bo_informar_web;
            $_SESSION[SESSION_BASE]['primer_login']			= FALSE;
            $_SESSION[SESSION_BASE]['autenticado']			= TRUE;
            
            //Guarda historial Evento
            $id_evento_tipo = 7; //Volver Usuario
            $gl_descripcion = "Se vuelve de Usuario: ".$usuario_anterior->gl_nombres." a Usuario: ".$usuario->gl_nombres;
			$this->_Evento->guardar($id_evento_tipo,0,0,0,$gl_descripcion);
		}else{
			$mensaje	= 'Hubo un problema.</b><br>Favor intentar nuevamente o contactarse con Soporte.';
		}

		$salida	= array("correcto" => $correcto, "mensaje" => $mensaje);
        $json	= Zend_Json::encode($salida);
        echo $json;
	}
    
	/**
	* Descripción	: Mostrar Formulario para Cambiar Perfil
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function cambiarPerfil(){
        $id_usuario         = $_SESSION[SESSION_BASE]['id'];
        $id_perfil          = $_SESSION[SESSION_BASE]['perfil'];
        $id_usuario_perfil  = $_SESSION[SESSION_BASE]['id_usuario_perfil'];
        $perfiles			= $this->_DAOUsuarioPerfil->getByUsuario($id_usuario);

		$this->smarty->assign('id_perfil',$id_perfil);
		$this->smarty->assign('perfiles',$perfiles);
		$this->smarty->assign('id_usuario_perfil',$id_usuario_perfil);
		$this->smarty->display('mantenedor_usuario/cambiar_perfil.tpl');
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_usuario.js');
	}

	/**
	* Descripción	: Procesar Cambio de Usuario
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param int $id_perfil_cambio
	*/
	public function procesarCambioPerfil(){
		$correcto   = false;
		$mensaje    = '';
		$params     = $this->_request->getParams();
        
		if($params){
            $usuario_perfil     = $this->_DAOUsuarioPerfil->getDetalleById($params['id_perfil_cambio']);
            $usuario            = $this->_DAOUsuario->getLoginByID($usuario_perfil->id_usuario);

			if(!empty($usuario_perfil)){
				$correcto										= true;
				$id_perfil_anterior                             = $_SESSION[SESSION_BASE]['perfil'];
				$_SESSION[SESSION_BASE]['perfil']               = $usuario_perfil->id_perfil;
				$_SESSION[SESSION_BASE]['id_usuario_perfil']    = $usuario_perfil->id_usuario_perfil;
				$_SESSION[SESSION_BASE]['id_region']            = $usuario_perfil->id_region;
				$_SESSION[SESSION_BASE]['id_oficina']           = $usuario_perfil->id_oficina;
				$_SESSION[SESSION_BASE]['id_comuna']            = $usuario_perfil->id_comuna;
				$_SESSION[SESSION_BASE]['id_establecimiento']   = $usuario_perfil->id_establecimiento;
				$_SESSION[SESSION_BASE]['id_servicio']          = $usuario_perfil->id_servicio;
                $_SESSION[SESSION_BASE]['bo_nacional']			= $usuario_perfil->bo_nacional;
                $_SESSION[SESSION_BASE]['bo_regional']			= $usuario_perfil->bo_regional;
                $_SESSION[SESSION_BASE]['bo_oficina']			= $usuario_perfil->bo_oficina;
                $_SESSION[SESSION_BASE]['bo_comunal']			= $usuario_perfil->bo_comunal;
                $_SESSION[SESSION_BASE]['bo_informar_web']  	= ($usuario_perfil->id_perfil == 14)?1:$usuario->bo_informar_web;
				
				$perfil_principal   = $this->_DAOPerfil->getById($_SESSION[SESSION_BASE]['perfil']);
				$perfil_anterior    = $this->_DAOPerfil->getById($id_perfil_anterior);
				
				//Guarda historial Evento
				$id_evento_tipo = 10; //Cambio de Perfil
				$gl_descripcion = "Se cambia de Perfil el usuario id: ".$_SESSION[SESSION_BASE]['nombre']." Perfil: ".$perfil_anterior->gl_nombre_perfil." a Perfil:".$perfil_principal->gl_nombre_perfil;
				$this->_Evento->guardar($id_evento_tipo,0,0,0,$gl_descripcion);
			}else{
				$mensaje	= 'Hubo un problema al buscar Perfil.</b><br>Favor intentar nuevamente o contactarse con Soporte.';
			}
		}else{
			$mensaje	= 'Hubo un problema.</b>
							<br>Favor Revise que no intenta cambiar a su Perfil Actual.
							<br>Si el problema persiste contactarse con Soporte.';
		}
        
		$salida	= array("correcto" => $correcto, "mensaje" => $mensaje);
        $json	= Zend_Json::encode($salida);
        echo $json;
	}

	/****************************** PERFIL ************************************/
	/**
	* Descripción	: Desplegar Grilla de Perfil
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function perfil(){
        Acceso::redireccionUnlogged($this->smarty);
		$this->smarty->assign('arr_data',$this->_DAOPerfil->getLista());
		$this->_display('mantenedor_perfil/bandeja.tpl');
	}

	/**
	* Descripción	: Mostrar Formulario para Agregar Perfil
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function agregarPerfil(){
		$arr_padre	= $this->_DAOOpcion->getAllOpcionPadre();
		$arr_opcion	= $this->_DAOOpcion->getAllOpcionHijo();

		$this->smarty->assign('arr_padre',$arr_padre);
		$this->smarty->assign('arr_opcion',$arr_opcion);
		$this->smarty->display('mantenedor_perfil/agregar.tpl');
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_perfil.js');
	}

	/**
	* Descripción	: Guardar Perfil en la Base de Datos
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	* @param array $parametros con los datos a guardar
	*/
	public function agregarPerfilBD(){
		header('Content-type: application/json');
		$parametros         = $this->_request->getParams();
		$gl_nombre          = $parametros['gl_nombre'];
		$gl_descripcion     = $parametros['gl_descripcion'];
		$arr_opcion         = json_decode($parametros['arr_opcion']);
        $bo_nacional        = ($parametros['bo_tipo_perfil']==1)?1:0;
        $bo_regional        = ($parametros['bo_tipo_perfil']==2)?1:0;
        $bo_oficina         = ($parametros['bo_tipo_perfil']==3)?1:0;
        $bo_comunal         = ($parametros['bo_tipo_perfil']==4)?1:0;
        $bo_seremi          = ($parametros['bo_institucion']==1)?1:0;
        $bo_establecimiento = ($parametros['bo_institucion']==2)?1:0;

		$parameters		= array('gl_token'              => Seguridad::generar_sha1($gl_nombre),
								'gl_nombre_perfil'      => $gl_nombre,
								'gl_descripcion'        => $gl_descripcion,
                                'bo_nacional'           => $bo_nacional,
                                'bo_regional'           => $bo_regional,
                                'bo_oficina'            => $bo_oficina,
                                'bo_comunal'            => $bo_comunal,
                                'bo_seremi'             => $bo_seremi,
                                'bo_establecimiento'    => $bo_establecimiento,
								'id_usuario_crea'       => $_SESSION[SESSION_BASE]['id']
								);

		$id_perfil		= $this->_DAOPerfil->insert($parameters);
		if($id_perfil){
			$correcto	= true;
			$mensaje	= 'El perfil se ha creado exitosamente';

			foreach($arr_opcion as $opcion){
				$param	= array(
								'id_perfil'			=> $id_perfil,
								'id_opcion'			=> $opcion->name,
								'id_usuario_crea'	=> $_SESSION[SESSION_BASE]['id']
								);
				$this->_DAOPerfilOpcion->insert($param);
			}
		}else{
			$correcto	= false;
			$mensaje	= 'Hubo problemas al crear el perfil nuevo.';
		}

		$salida	= array('correcto' => $correcto, 'mensaje' => $mensaje);
        $json	= Zend_Json::encode($salida);
        echo $json;
	}

	/**
	* Descripción	: Mostrar Formulario para Editar Perfil
	* @author		: David Guzmán <david.guzman@cosof.cl> 11/05/2018
	* @param string $gl_token Token del perfil a Editar
	*/
	public function editarPerfil(){
		$parametros	= $this->request->getParametros();
		$gl_token	= $parametros[0];
		$perfil		= $this->_DAOPerfil->getByToken($gl_token);
		$arr_padre	= $this->_DAOOpcion->getAllOpcionPadreByIdPerfil($perfil->id_perfil);
		$arr_opcion	= $this->_DAOOpcion->getAllOpcionHijoByIdPerfil($perfil->id_perfil);

		$this->smarty->assign('arr_padre',$arr_padre);
		$this->smarty->assign('arr_opcion',$arr_opcion);
		$this->smarty->assign('itm',$perfil);
		$this->smarty->display('mantenedor_perfil/editar.tpl');
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_perfil.js');
	}
	
	/**
	* Descripción	: Guardar el Perfil editado en Base de Datos
	* @author		: David Guzman <david.guzman@cosof.cl>
	* @param int $id_perfil ID del Perfil Editado
	*/
	public function editarPerfilBD(){
		header('Content-type: application/json');
		$parametros			= $this->_request->getParams();
        $gl_token           = $parametros['gl_token'];
		$perfil             = $this->_DAOPerfil->getByToken($gl_token);
		$id_perfil			= $perfil->id_perfil;
		$gl_nombre_perfil	= $parametros['gl_nombre_perfil'];
		$gl_descripcion		= $parametros['gl_descripcion'];
		$bo_activo			= $parametros['bo_activo'];
        $bo_nacional        = ($parametros['bo_tipo_perfil']==1)?1:0;
        $bo_regional        = ($parametros['bo_tipo_perfil']==2)?1:0;
        $bo_oficina         = ($parametros['bo_tipo_perfil']==3)?1:0;
        $bo_comunal         = ($parametros['bo_tipo_perfil']==4)?1:0;
        $bo_seremi          = ($parametros['bo_institucion']==1)?1:0;
        $bo_establecimiento = ($parametros['bo_institucion']==2)?1:0;
		$arr_opcion			= json_decode($parametros['arr_opcion']);
		$arr_upt			= array('gl_nombre_perfil'=>$gl_nombre_perfil,'bo_estado'=>$bo_activo,
                                    'bo_nacional'=>$bo_nacional,'bo_regional'=>$bo_regional,'bo_oficina'=>$bo_oficina,'bo_comunal'=>$bo_comunal,
                                    'bo_seremi'=>$bo_seremi,'bo_establecimiento'=>$bo_establecimiento,'gl_descripcion'=>$gl_descripcion);

		$estado				= $this->_DAOPerfil->update($arr_upt, $id_perfil, 'id_perfil');

		if($estado){
			$correcto		= true;
			$mensaje		= 'Los datos han sido Actualizados correctamente.';
			
			$this->_DAOPerfilOpcion->deleteByIdPerfil($id_perfil);
			foreach($arr_opcion as $opcion){
				$param	= array(
								'id_perfil'			=> $id_perfil,
								'id_opcion'			=> $opcion->name,
								'id_usuario_crea'	=> $_SESSION[SESSION_BASE]['id']
								);
				$this->_DAOPerfilOpcion->insert($param);
			}
		}else{
			$correcto		= false;
			$mensaje		= 'Hubo un problema al Actualizar.</b><br>Favor intentar nuevamente o contactarse con Soporte.';
		}

		$salida	= array("correcto" => $correcto, "mensaje" => $mensaje);
        $json	= Zend_Json::encode($salida);
        echo $json;
	}

	/**
	* Descripción	: Editar Opción de Perfil
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	* @param int $id_perfil ID del Perfil
	*/
	public function editarPerfilOpcion(){
		$parametros		= $this->request->getParametros();
		$id_perfil		= $parametros[0];

		$data			= $this->_DAOPerfil->getById($id_perfil);
		$arr_padre		= $this->_DAOOpcion->getAllOpcionPadre();
		$arr_opcion		= $this->_DAOOpcion->getAllOpcionHijo($id_perfil);
		$arr_opcion_act	= $this->_DAOPerfilOpcion->getAllMenuPerfilPorID($id_perfil);

		$this->smarty->assign('itm',$data);
		$this->smarty->assign('arr_opcion_act',(array)$arr_opcion_act);
		$this->smarty->assign('arr_padre',$arr_padre);
		$this->smarty->assign('arr_opcion',$arr_opcion);
		$this->smarty->display('mantenedor_perfil/editar_menu.tpl');
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_perfil.js');
	}
    
    /****************************** ESTABLECIMIENTO ************************************/
	/**
	* Descripción	: Desplegar Grilla de Establecimiento
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function establecimiento(){
        Acceso::redireccionUnlogged($this->smarty);
        $arrRegiones	= $this->_DAORegion->getLista();
        $bo_nacional	= $_SESSION[SESSION_BASE]['bo_nacional'];
        $region         = ($_SESSION[SESSION_BASE]['id_region'] > 0 && !$bo_nacional)?$_SESSION[SESSION_BASE]['id_region']:0;
        $params         = array("region"=>$region);
        $jscode         = "setTimeout(function(){ $('#region').trigger('change'); $('#buscar').trigger('click'); },100);";
        
		$this->smarty->assign("region", $region);
		$this->smarty->assign("arrRegiones", $arrRegiones);
		$this->smarty->assign('arr_data',$this->_DAOEstablecimientoSalud->getListaParams($params));
        $this->_addJavascript($jscode);
		$this->_display('mantenedor_establecimiento/bandeja.tpl');
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_establecimiento.js');
		$this->load->javascript(STATIC_FILES.'js/regiones.js');
	}
	/**
	* Descripción	: Desplegar Grilla de Establecimiento
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function buscarEstablecimiento(){
        $params             = $this->_request->getParams();
		$arrEstablecimiento = $this->_DAOEstablecimientoSalud->getListaParams($params);
        $arrGrilla          = array("data"=>array());
        
        if(!empty($arrEstablecimiento)){
            foreach($arrEstablecimiento as $item){
                $arr    = array();
                if($item->bo_estado == 1){
                    $arr['estado']  = '<div style="color:green;"> Activo </div>';
                }else{
                    $arr['estado']  = '<div style="color:red;"> Inactivo </div>';
                }
                
                $arr['establecimiento']     = $item->gl_nombre_establecimiento;
                $arr['dir_establecimiento'] = $item->gl_direccion_establecimiento;
                
                $arr['opciones']    = ' <button type="button" class="btn btn-xs btn-success"
                                            onclick="xModal.open(\''.BASE_URI.'/Mantenedor/editarEstablecimiento/?token='.$item->gl_token.'\',\'Editar Establecimiento\',45);"
                                            data-toggle="tooltip" data-title="Editar Establecimiento"><i class="fa fa-edit"></i>
                                        </button>';
                
                $arrGrilla['data'][] = $arr;
            }
        }
        
        echo json_encode($arrGrilla);
	}

	/**
	* Descripción	: Mostrar Formulario para Agregar Establecimiento
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	public function agregarEstablecimiento(){
        $arrRegiones            = $this->_DAORegion->getLista();
        $arrServicio            = $this->_DAOServicioSalud->getLista();
        $arrTipoEstablecimiento = $this->_DAOEstablecimientoSaludTipo->getLista();
        
		$this->smarty->assign('arrRegiones',$arrRegiones);
		$this->smarty->assign('arrTipoEstablecimiento',$arrTipoEstablecimiento);
		$this->smarty->assign('arrServicio',$arrServicio);
		$this->smarty->display('mantenedor_establecimiento/agregar.tpl');
	}
    
    /**
	* Descripción	: Guardar Establecimiento en la Base de Datos
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param array $parametros con los datos a guardar
	*/
	public function agregarEstablecimientoBD(){
		header('Content-type: application/json');
		$params         = $this->_request->getParams();
		$gl_nombre		= $params['gl_nombre'];
        $gl_nuevo_token = Seguridad::generar_sha1($gl_nombre);
		$data			= array($gl_nuevo_token,
                                $gl_nombre,
                                $params['tipo_establecimiento'],
                                $params['servicio'],
                                $params['region_establecimiento'],
                                $params['comuna_establecimiento'],
                                $params['gl_direccion'],
                                $params['gl_telefono']);

		$id_establecimiento = $this->_DAOEstablecimientoSalud->insertNuevo($data);
        
		if($id_establecimiento){
            $gl_private_key = Seguridad::generaTokenEstablecimiento($id_establecimiento,$gl_nombre);
            $this->_DAOEstablecimientoSalud->updateKey($id_establecimiento,$gl_private_key);
			$correcto	= true;
			$mensaje	= 'El establecimiento se ha creado exitosamente';
		}else{
			$correcto	= false;
			$mensaje	= 'Hubo problemas al crear el establecimiento nuevo.';
		}

		$salida	= array('correcto' => $correcto, 'mensaje' => $mensaje);
        $json	= Zend_Json::encode($salida);
        echo $json;
	}
    
    /**
	* Descripción	: Mostrar Formulario para Editar Establecimiento
	* @author		: David Guzmán <david.guzman@cosof.cl> 18/06/2018
	* @param string $gl_token Token del establecimiento a Editar
	*/
	public function editarEstablecimiento(){
        $params                 = $this->_request->getParams();
        $arrEstablecimiento     = $this->_DAOEstablecimientoSalud->getByToken($params['token']);
		$arrRegiones            = $this->_DAORegion->getLista();
        $arrServicio            = $this->_DAOServicioSalud->getLista();
        $arrTipoEstablecimiento = $this->_DAOEstablecimientoSaludTipo->getLista();
        
        if(isset($arrEstablecimiento) && $arrEstablecimiento->id_region>0){
            $arrComunas = $this->_DAOComuna->getByIdRegion($arrEstablecimiento->id_region);
        }
        
		$this->smarty->assign('itm',$arrEstablecimiento);
		$this->smarty->assign('arrComunas',$arrComunas);
		$this->smarty->assign('arrRegiones',$arrRegiones);
		$this->smarty->assign('arrTipoEstablecimiento',$arrTipoEstablecimiento);
		$this->smarty->assign('arrServicio',$arrServicio);
		$this->smarty->display('mantenedor_establecimiento/editar.tpl');
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_establecimiento.js');
	}
    
    /**
	* Descripción	: Guardar el Establecimiento editado en Base de Datos
	* @author		: David Guzman <david.guzman@cosof.cl>
	* @param int $id_establecimiento ID del Establecimiento Editado
	*/
	public function editarEstablecimientoBD(){
		header('Content-type: application/json');
		$parametros			= $this->_request->getParams();
        $gl_token           = $parametros['gl_token'];
		$establecimiento    = $this->_DAOEstablecimientoSalud->getByToken($gl_token);
		$id_establecimiento = $establecimiento->id_establecimiento;
        $gl_nombre          = $parametros['gl_nombre'];
        //$gl_nuevo_token		= Seguridad::generar_sha1($gl_nombre);
        //$gl_nuevo_key		= Seguridad::generaTokenEstablecimiento($id_establecimiento,$gl_nombre);
		$arr_upt			= array('gl_nombre_establecimiento'     => $gl_nombre,
                                    'id_establecimiento_tipo'       => $parametros['tipo_establecimiento'],
                                    'gl_direccion_establecimiento'  => $parametros['gl_direccion'],
                                    'gl_telefono'                   => $parametros['gl_telefono'],
                                    'id_servicio'                   => $parametros['servicio'],
                                    'id_region'                     => $parametros['region_establecimiento'],
                                    'id_comuna'                     => $parametros['comuna_establecimiento']);

		$bo_update  		= $this->_DAOEstablecimientoSalud->uptEstablecimiento($id_establecimiento,$arr_upt);

		if($bo_update){
			$correcto		= true;
			$mensaje		= 'Los datos han sido Actualizados correctamente.';
		}else{
			$correcto		= false;
			$mensaje		= 'Hubo un problema al Actualizar.</b><br>Favor intentar nuevamente o contactarse con Soporte.';
		}

		$salida	= array("correcto" => $correcto, "mensaje" => $mensaje);
        $json	= Zend_Json::encode($salida);
        echo $json;
	}

	/**************************** WEBSERVICE **********************************/
	/**
	* Descripción	: Mostrar Grilla Webservice
	* @author		Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function webservice(){
		$this->smarty->assign('arr_data',$this->_DAOWebService->getLista());
		$this->_display('mantenedor_ws/bandeja.tpl');
	}

	/**
	* Descripción	: Mostrar Formulario para Agregar Webservice
	* @author		Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function agregarWebService(){
		$this->_display('mantenedor_ws/agregar.tpl');
	}

	/**
	* Descripción	: Mostrar Formulario para Editar Webservice
	* @author		Victor Retamal <victor.retamal@cosof.cl>
	* @param int $id_web_service ID del WebService a Editar
	*/
	public function editarWebService(){
		$parametros		= $this->request->getParametros();
		$id_web_service	= $parametros[0];
		$data			= $this->_DAOWebService->getById($id_web_service);

		$this->smarty->assign('itm',$data);
		$this->_display('mantenedor_ws/editar.tpl');
	}

	/******************************* MENU *************************************/
	/**
	* Descripción	: Mostrar Grilla Menú
	* @author		Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function menu(){
        Acceso::redireccionUnlogged($this->smarty);
		$arr_data = $this->_DAOOpcion->getListaDetalle();
		$this->smarty->assign('arr_data',$arr_data);
		
		$this->_display('mantenedor_menu/bandeja.tpl');
	}

	/**
	* Descripción	: Mostrar Formulario para Agregar Menú Padre
	* @author		Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function agregarMenuPadre(){
		$this->smarty->display('mantenedor_menu/agregar_padre.tpl');
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_menu.js');
	}

	/**
	* Descripción	: Mostrar Formulario para Agregar Menú Opción
	* @author		Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function agregarMenuOpcion(){
		$arr_padre	= $this->_DAOOpcion->getAllMenuPadre();
		$arr_perfil	= $this->_DAOPerfil->getLista(1);

		$this->smarty->assign('arr_padre',$arr_padre);
		$this->smarty->assign('arr_perfil',$arr_perfil);
		$this->smarty->display('mantenedor_menu/agregar_opcion.tpl');
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_menu.js');
	}

	/**
	* Descripción	: Mostrar Formulario para Editar Menú Opción
	* @author		Victor Retamal <victor.retamal@cosof.cl>
	* @param int $id_opcion ID del MenuOpcion
	*/
	public function editarMenuOpcion(){
		$parametros	= $this->request->getParametros();
		$id_opcion	= $parametros[0];

		$data		= $this->_DAOOpcion->getById($id_opcion);
		$arr_padre	= $this->_DAOOpcion->getAllMenuPadre();

		$this->smarty->assign('itm',$data);
		$this->smarty->assign('arr_padre',$arr_padre);
		$this->smarty->display('mantenedor_menu/editar_opcion.tpl');
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_menu.js');
	}

	/**
	* Descripción	: Editar Menú Perfil
	* @author		Victor Retamal <victor.retamal@cosof.cl>
	* @param int $id_opcion ID del MenuOpcion
	*/
	public function editarMenuPerfil(){
		$parametros	= $this->request->getParametros();
		$id_opcion	= $parametros[0];

		$data		= $this->_DAOPerfilOpcion->getMenuOpcionPorID($id_opcion);
		$arr_perfil	= $this->_DAOPerfilOpcion->getAllMenuOpcionPorID($id_opcion);

		$this->smarty->assign('itm',$data);
		$this->smarty->assign('arr_perfil',$arr_perfil);
		$this->_display('mantenedor_menu/editar_menu.tpl');
		$this->load->javascript(STATIC_FILES.'js/templates/mantenedor/mantenedor_menu.js');
	}
	
	/**
	* Descripción	: Guardar Menu Padre en la Base de Datos
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param array $parametros con los datos a guardar
	*/
	public function agregarMenuPadreBD(){
		header('Content-type: application/json');
		$parametros		= $this->_request->getParams();
		
		$id_opcion		= $this->_DAOOpcion->insertMenuPadre($parametros);
		
		if($id_opcion){
			$correcto	= true;
			$mensaje	= 'La Opción se ha creado exitosamente';
		}else{
			$correcto	= false;
			$mensaje	= 'Hubo problemas al crear la opción nuevo.';
		}

		$salida	= array('correcto' => $correcto, 'mensaje' => $mensaje);
        $json	= Zend_Json::encode($salida);
        echo $json;
	}
	
	/**
	* Descripción	: Guardar Menu Opción en la Base de Datos
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param array $parametros con los datos a guardar
	*/
	public function agregarMenuOpcionBD(){
		header('Content-type: application/json');
		$parametros		= $this->_request->getParams();

		$id_opcion		= $this->_DAOOpcion->insertMenuOpcion($parametros);
		
		if($id_opcion){
			$correcto	= true;
			//Si Padre tiene URL -> borrarla??? Cambiar bo_tiene_hijo a -> 1
			if($parametros['id_padre'] != 0){
				$this->_DAOOpcion->updatePadreById($parametros['id_padre']);
			}
			$mensaje	= 'La Opción se ha creado exitosamente';
		}else{
			$correcto	= false;
			$mensaje	= 'Hubo problemas al crear la opción nuevo.';
		}

		$salida	= array('correcto' => $correcto, 'mensaje' => $mensaje);
        $json	= Zend_Json::encode($salida);
        echo $json;
	}
	
	/**
	* Descripción	: Editar Opción en la Base de Datos
	* @author		: David Guzmán <david.guzman@cosof.cl>
	* @param array $parametros con los datos a guardar
	*/
	public function editarOpcionBD(){
		header('Content-type: application/json');
		$parametros		= $this->_request->getParams();

		$id_opcion		= $this->_DAOOpcion->editarOpcion($parametros);
		
		if($id_opcion){
			$correcto	= true;
			//Si Padre tiene URL -> borrarla??? Cambiar bo_tiene_hijo a -> 1
			if($parametros['id_padre'] != 0){
				$this->_DAOOpcion->updatePadreById($parametros['id_padre']);
			}
			$mensaje	= 'La Opción se ha Editado exitosamente';
		}else{
			$correcto	= false;
			$mensaje	= 'Hubo problemas al Editar la opción.';
		}

		$salida	= array('correcto' => $correcto, 'mensaje' => $mensaje);
        $json	= Zend_Json::encode($salida);
        echo $json;
	}
	
	public function regularizarKeyEstablecimiento(){
		$arr_lista	= $this->_DAOEstablecimientoSalud->getListaSinKey();

		if(!empty($arr_lista)){
			foreach($arr_lista as $e){
				$id_establecimiento	= $e->id_establecimiento;
				$gl_nombre			= $e->gl_nombre_establecimiento;
				$gl_key				= Seguridad::generaTokenEstablecimiento($id_establecimiento,$gl_nombre);
				
				$this->_DAOEstablecimientoSalud->updateKey($id_establecimiento,$gl_key);
			}
		}
		
		echo 'OK - '.count($arr_lista);

	}
}