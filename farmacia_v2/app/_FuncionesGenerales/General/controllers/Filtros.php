<?php

namespace App\_FuncionesGenerales\General;

use Pan\Kore\Controller;
use Pan\Utils\SessionPan;


// TODO: Mover a LIBRERIA
class Filtros extends \pan\Kore\Controller
{

    public function __construct(){
		parent::__construct();
		$this->session->isValidate();
	}

	/**
	 * Descripción  :   Obtiene los filtros segun perfil de usuario para aplicar en la búsqueda.
	 * @author      :   Francisco Valdés <francisco.valdes@cosof.cl>
	 * @return          array $params
	 */
	public static function getFiltros($params = null) 
	{
        // --- Recibe datos de Usuario --- //
		$filtros                    = array();
		$filtros['id_region']       = SessionPan::getSession('id_region');
		$filtros['id_oficina']      = SessionPan::getSession('id_oficina');
		$filtros['id_comuna']       = SessionPan::getSession('id_comuna');

		// --- Sobreescribe datos si tiene los permisos --- //
		if (SessionPan::getSession('bo_nacional')) {
			$filtros['id_region']   = $params['region'];
			$filtros['id_oficina']  = $params['id_oficina'];
			$filtros['id_comuna']   = $params['comuna'];
		}
		if (SessionPan::getSession('bo_regional')) {
			$filtros['id_oficina']  = $params['id_oficina'];
			$filtros['id_comuna']   = $params['comuna'];
		}
		if (SessionPan::getSession('bo_oficina')) {
			$filtros['id_comuna']   = $params['comuna'];
		}

		return $filtros;
	}

    /**
     * Descripción  :   Obtiene los array correspondientes a los filtros de búsqueda segun perfil.
     * @author      :   Francisco Valdés <francisco.valdes@cosof.cl>
     * @return          array $params
     */
    public static function getArrayFiltros($filtros)
    {
        $_DAORegion                = new \App\General\Entity\DAODireccionRegion;
        $_DAOComuna                = new \App\General\Entity\DAODireccionComuna;
        $_DAOOficina               = new \App\General\Entity\DAODireccionOficina;

        $data = array();

        function validarFiltro($filtro)
        {
            return  !isset($filtro) || empty($filtro) || $filtro == '0' ? null : $filtro;
        }

        if (validarFiltro($filtros['id_region']) != null) {
            $data['arrRegiones'][0]     = $_DAORegion->getByPK($filtros['id_region']);
        } else {
            $data['arrRegiones']        = $_DAORegion->getLista();
        }

        if (validarFiltro($filtros['id_oficina'])  != null) {
            $data['arrOficina'][0]      = $_DAOOficina->getByPK($filtros['id_oficina']);
        } else if (validarFiltro($filtros['id_region'])  != null) {
            $data['arrOficina']         = $_DAOOficina->getByIdRegion($filtros['id_region']);
            // Cargar comunas por region si no hay oficina escogida
            $data['arrComuna']          = $_DAOComuna->getByIdRegion($filtros['id_region']);
        }

        if (validarFiltro($filtros['id_comuna'])   != null) {
            $data['arrComuna'][0]       = $_DAOComuna->getByPK($filtros['id_comuna']);
        } else if (validarFiltro($filtros['id_oficina']) != null) {
            $data['arrComuna']          = $_DAOComuna->getByIdOficina($filtros['id_oficina']);
        }

        return $data;
    }
}
