<?php
/**
 ******************************************************************************
 * Sistema           : MORDEDORES
 *
 * Descripción       : Controller para Manual
 *
 * Plataforma        : PHP
 *
 * Creación          : 28/05/2018
 *
 * @name             Manual.php
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
class Manual extends Controller {

	//protected $_Evento;
	protected $_DAOPerfil;
	protected $_DAOPerfilDocumento;

	function __construct() {
		parent::__construct();
		//$this->load->lib('Fechas', false);

		//$this->_Evento                = new Evento();
		$this->_DAOPerfil               = $this->load->model("DAOAccesoPerfil");
		$this->_DAOPerfilDocumento 		= $this->load->model("DAOPerfilDocumento");
	}

	/**
	* Descripción	: Carga vista manuales
	* @author		: Victor Retamal <victor.retamal@cosof.cl>
	*/
	public function index() {
		Acceso::redireccionUnlogged($this->smarty);

        $id_perfil      = ($_SESSION[SESSION_BASE]['perfil'] == 14)?6:$_SESSION[SESSION_BASE]['perfil'];
        $perfil_actual  = $this->_DAOPerfil->getById($id_perfil);
        $token_perfil   = $perfil_actual->gl_token;
        $nombre_perfil  = $perfil_actual->gl_nombre_perfil;
        
        if($id_perfil == 1){
            $arrDocumento   = $this->_DAOPerfilDocumento->getListaActivo();
        }
        else{
            $arrDocumento   = $this->_DAOPerfilDocumento->getByPerfil($id_perfil);
        }

        $this->smarty->assign('arrDocumento', $arrDocumento);
        $this->smarty->assign('nombre_perfil', $nombre_perfil);
		$this->smarty->assign('origen', ($id_perfil==3)?'Descargas':'Manual');

		$this->_display('manual/index.tpl');
	}

    /**
	* Descripción	: Descargar Manual
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	// public function descargarManual($token_perfil) {
	//
	// 	Acceso::redireccionUnlogged($this->smarty);
	//
    //     $perfil         = $this->_DAOPerfil->getByToken($token_perfil);
	// 	$nombre_perfil 	= $perfil->gl_nombre_perfil;
    //     $nombre_manual  = "Manual_".$perfil->gl_nombre_perfil.".pdf";
	//
	// 	//Ver por ID de perfil
    //     $sufijo_documento = strtolower($nombre_perfil);
    //     $sufijo_documento = str_replace(" ","_", $sufijo_documento);
	//
	// 	$manual = $this->_DAOPerfilDocumento->getByToken($token);
	// 	$token_manual = $manual->gl_token;
	//
    //     $fp = fopen(BASE_DIR."/static/docs/manual_mordedores_".$sufijo_documento.".pdf", 'rb');
    //     header("Content-Type: application/pdf");
    //     header("filename=".$nombre_manual);
    //     header("Content-Transfer-Encoding: binary");
    //     header("Content-Disposition: ; filename=\"".$nombre_manual."\"");
    //     ob_end_clean();
    //     fpassthru($fp);
    //     exit;
	// }

    /**
	* Descripción	: Descargar Ficha Notificación para Establecimiento Salud
	* @author		: David Guzmán <david.guzman@cosof.cl>
	*/
	// public function descargarFicha() {
	// 	Acceso::redireccionUnlogged($this->smarty);
	//
    //     $nombre_manual  = "Ficha_notificacion_mordedores.pdf";
	//
    //     $fp = fopen(BASE_DIR."/static/docs/ficha_notificacion_mordedores.pdf", 'rb');
    //     header("Content-Type: application/pdf");
    //     header("filename=".$nombre_manual);
    //     header("Content-Transfer-Encoding: binary");
    //     header("Content-Disposition: ; filename=\"".$nombre_manual."\"");
    //     ob_end_clean();
    //     fpassthru($fp);
    //     exit;
	//
	// }

	public function descargarDocumento($token = NULL) {

		Acceso::redireccionUnlogged($this->smarty);

		if (!is_null($token)) {

			$documento = $this->_DAOPerfilDocumento->getByToken($token);
			$token_documento = $documento->gl_token;

			if (!empty($documento)) {
				$nombre_doc = $documento->gl_nombre;
				$ruta_doc = $documento->gl_path;
				$fp = fopen($ruta_doc, 'rb');
				header("Content-Type: application/pdf");
				header("filename=".$nombre_doc);
				header("Content-Transfer-Encoding: binary");
				header("Content-Disposition: attachment; filename=\"".$nombre_doc.".pdf\"");
				ob_end_clean();
				fpassthru($fp);
				exit;
			}
		}
	}

}