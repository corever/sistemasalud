<?php
/**
 ******************************************************************************
 * Sistema           : ANIMALES MORDEDORES
 * 
 * Descripción       : Controller para trabajar con Regiones
 *
 * Plataforma        : PHP
 * 
 * Creación          : 14/02/2017
 * 
 * @name             Paciente.php
 * 
 * @version          1.0.0
 *
 * @author           David Guzmán <david.guzman@cosof.cl>
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
class Regiones extends Controller{

	protected $_DAOComuna;
	protected $_DAOOficina;
	protected $_DAOServicioSalud;
	
	function __construct(){
		parent::__construct();
		$this->load->lib('Fechas', false);
		$this->_DAOComuna           = $this->load->model('DAODireccionComuna');
		$this->_DAOOficina          = $this->load->model('DAODireccionOficina');
		$this->_DAOServicioSalud    = $this->load->model('DAOServicioSalud');
	}

	/**
	* Descripción	: Carga comunas por región
	* @author		:  David Guzmán <david.guzman@cosof.cl>
	*/
    public function cargarComunasPorRegion(){
		$region		= $_POST['region'];
		$comunas	= $this->_DAOComuna->getByIdRegion($region);
		$json		= array();
		$i			= 0;

		foreach($comunas as $comuna){
			$json[$i]['id_comuna']			= $comuna->id_comuna;
			$json[$i]['nombre_comuna']		= $comuna->gl_nombre_comuna;
			$json[$i]['gl_latitud_comuna']	= $comuna->gl_latitud_comuna;
			$json[$i]['gl_longitud_comuna']	= $comuna->gl_longitud_comuna;
			$i++;
		}

		echo json_encode($json);
    }

	/**
	* Descripción	: Carga comunas por oficina
	* @author		:  David Guzmán <david.guzman@cosof.cl>
	*/
    public function cargarComunaporOficina(){
		$oficina    = $_POST['oficina'];
		$comunas	= $this->_DAOComuna->getByIdOficina($oficina);
		$json		= array();
		$i			= 0;

		foreach($comunas as $comuna){
			$json[$i]['id_comuna']			= $comuna->id_comuna;
			$json[$i]['nombre_comuna']		= $comuna->gl_nombre_comuna;
			$json[$i]['gl_latitud_comuna']	= $comuna->gl_latitud_comuna;
			$json[$i]['gl_longitud_comuna']	= $comuna->gl_longitud_comuna;
			$i++;
		}

		echo json_encode($json);
    }

	/**
	* Descripción	: Carga servicio por región
	* @author		:  David Guzmán <david.guzman@cosof.cl>
	*/
    public function cargarServicioPorRegion(){
		$region     = $_POST['region'];
		$servicios	= $this->_DAOServicioSalud->getByRegion($region);
		$json		= array();
		$i			= 0;

		foreach($servicios as $servicio){
			$json[$i]['id_servicio']    = $servicio->id_servicio;
			$json[$i]['gl_nombre']      = $servicio->gl_nombre_servicio;
			$i++;
		}

		echo json_encode($json);
    }

	/**
	* Descripción	: Carga oficinas por región
	* @author		:  David Guzmán <david.guzman@cosof.cl> 10/05/2018
	*/
    public function cargarOficinasPorRegion(){
		$region		= $_POST['region'];
		$oficinas	= $this->_DAOOficina->getByIdRegion($region);
		$json		= array();
		$i			= 0;

		foreach($oficinas as $oficina){
			$json[$i]['id_oficina']			= $oficina->id_oficina;
			$json[$i]['nombre_oficina']		= $oficina->gl_nombre_oficina;
			$i++;
		}

		echo json_encode($json);
    }
    
    /**
	* Descripción	: Carga Establecimiento de Salud por región
	* @author		:  David Guzmán <david.guzman@cosof.cl> 16/05/2018
	*/
    public function cargarEstablecimientoSaludporRegion() {
		$json	= array();

		if (!empty($_POST['region'])) {
			$id_region          = $_POST['region'];
			$daoEstableSalud	= $this->load->model('DAOEstablecimientoSalud');
            $establesalud       = $daoEstableSalud->getByIdRegion($id_region);
            
            if($_SESSION[SESSION_BASE]['perfil'] == 15){ //ENCARGADO SERVICIO SALUD
                $establesalud   = $daoEstableSalud->getByIdRegionAndServicio($id_region,$_SESSION[SESSION_BASE]['id_servicio']);
            }

			if(!empty($establesalud)){
				$i = 0;
				foreach ($establesalud as $eSalud) {
					$json[$i]['id_establecimiento']			= $eSalud->id_establecimiento;
					$json[$i]['gl_nombre_establecimiento']	= $eSalud->gl_nombre_establecimiento;
					$i++;
				}
			}
		}

		echo json_encode($json);
	}
    
    /**
	* Descripción	: Carga Establecimiento de Salud por oficina
	* @author		:  David Guzmán <david.guzman@cosof.cl> 04/06/2018
	*/
    public function cargarEstablecimientoSaludporOficina() {
		$json	= array();

		if (!empty($_POST['oficina'])) {
			$id_oficina          = $_POST['oficina'];
			$daoEstableSalud	= $this->load->model('DAOEstablecimientoSalud');
            $establesalud       = $daoEstableSalud->getByIdOficina($id_oficina);
            
            if($_SESSION[SESSION_BASE]['perfil'] == 13){
                $establesalud   = $daoEstableSalud->getByEncargadoComunal($_SESSION[SESSION_BASE]['id_comuna']);
            }

			if(!empty($establesalud)){
				$i = 0;
				foreach ($establesalud as $eSalud) {
					$json[$i]['id_establecimiento']			= $eSalud->id_establecimiento;
					$json[$i]['gl_nombre_establecimiento']	= $eSalud->gl_nombre_establecimiento;
					$i++;
				}
			}
		}

		echo json_encode($json);
	}
    
    /**
	* Descripción	: Carga Establecimiento de Salud por Servicio
	* @author		:  David Guzmán <david.guzman@cosof.cl> 08/07/2019
	*/
    public function cargarEstablecimientoSaludporServicio() {
		$json	= array();

		if (!empty($_POST['servicio'])) {
			$id_servicio         = $_POST['servicio'];
			$daoEstableSalud	= $this->load->model('DAOEstablecimientoSalud');
            $establesalud       = $daoEstableSalud->getByIdServicio($id_servicio);
            
            if($_SESSION[SESSION_BASE]['perfil'] == 13){ //ENCARGADO COMUNAL
                $establesalud   = $daoEstableSalud->getByIdComunaAndServicio($id_servicio,$_SESSION[SESSION_BASE]['id_comuna']);
            }

			if(!empty($establesalud)){
				$i = 0;
				foreach ($establesalud as $eSalud) {
					$json[$i]['id_establecimiento']			= $eSalud->id_establecimiento;
					$json[$i]['gl_nombre_establecimiento']	= $eSalud->gl_nombre_establecimiento;
					$i++;
				}
			}
		}

		echo json_encode($json);
	}
    
    /**
	* Descripción	: Carga Fiscalizador por Región
	* @author		:  David Guzmán <david.guzman@cosof.cl> 10/08/2018
	*/
    public function cargarFiscalizadorporRegion() {
		$json	= array();

		if (!empty($_POST['region'])) {
			$id_region      = $_POST['region'];
			$daoUsuario     = $this->load->model('DAOAccesoUsuario');
            $fiscalizador   = $daoUsuario->obtenerFiscalizadores($id_region);

			if(!empty($fiscalizador)){
				$i = 0;
				foreach ($fiscalizador as $item) {
					$json[$i]['id_fiscalizador']    = $item->id_usuario;
					$json[$i]['gl_fiscalizador']	= $item->gl_nombres." ".$item->gl_apellidos." (".$item->gl_rut.")";
					$i++;
				}
			}
		}

		echo json_encode($json);
	}
    
    /**
	* Descripción	: Carga Fiscalizador por Oficina
	* @author		:  David Guzmán <david.guzman@cosof.cl> 10/08/2018
	*/
    public function cargarFiscalizadorporOficina() {
		$json	= array();

		if (!empty($_POST['oficina'])) {
			$id_oficina     = $_POST['oficina'];
			$daoUsuario     = $this->load->model('DAOAccesoUsuario');
            $fiscalizador   = $daoUsuario->obtenerFiscalizadores(null,null,$id_oficina);

			if(!empty($fiscalizador)){
				$i = 0;
				foreach ($fiscalizador as $item) {
					$json[$i]['id_fiscalizador']    = $item->id_usuario;
					$json[$i]['gl_fiscalizador']	= $item->gl_nombres." ".$item->gl_apellidos." (".$item->gl_rut.")";
					$i++;
				}
			}
		}

		echo json_encode($json);
	}
    
    /**
	* Descripción	: Carga Fiscalizador por Comuna
	* @author		:  David Guzmán <david.guzman@cosof.cl> 10/08/2018
	*/
    public function cargarFiscalizadorporComuna() {
		$json	= array();

		if (!empty($_POST['comuna'])) {
			$id_comuna      = $_POST['comuna'];
			$daoUsuario     = $this->load->model('DAOAccesoUsuario');
            $fiscalizador   = $daoUsuario->obtenerFiscalizadores(null,$id_comuna);

			if(!empty($fiscalizador)){
				$i = 0;
				foreach ($fiscalizador as $item) {
					$json[$i]['id_fiscalizador']    = $item->id_usuario;
					$json[$i]['gl_fiscalizador']	= $item->gl_nombres." ".$item->gl_apellidos." (".$item->gl_rut.")";
					$i++;
				}
			}
		}

		echo json_encode($json);
	}

}