<?php

namespace App\Mantenedor\Entity;

class DAOCampanaOficinas extends \pan\Kore\Entity{

 	protected $table = 'mfis_campana_oficinas';

	protected $primary_key = 'id_campana_oficina';


	public function getInfo($params = array())
	{
		$parametros = array();
		$query = '
			select distinct 
				ofi.gl_nombre_oficina as oficina,
				ofi.id_oficina as id_oficina,
				com.gl_nombre_comuna as comuna,
				com.id_comuna as id_comuna,
				reg.gl_nombre_region as region,
				reg.id_region as id_region  
				from ' . $this->table . ' camp_ofi 
				inner join mfis_direccion_oficina ofi on ofi.id_oficina = camp_ofi.id_oficina 
				inner join mfis_direccion_oficina_comuna ofi_com on ofi_com.id_oficina = ofi.id_oficina 
				inner join mfis_direccion_comuna com on com.id_comuna = ofi_com.id_comuna 
				inner join mfis_direccion_region reg on reg.id_region = com.id_region 
		';

		$where = '';
		if (isset($params['campana']) and $params['campana'] > 0) {
			$where .= ' camp_ofi.id_campana = ? and';
			$parametros[] = $params['campana'];
		}

		if (isset($params['oficina']) and $params['oficina'] > 0) {
			$where .= ' camp_ofi.id_oficina = ? and';
			$parametros[] = $params['oficina'];
		}

		if (isset($params['comuna']) and $params['comuna'] > 0) {
			$where .= ' com.id_comuna = ? and';
			$parametros[] = $params['comuna'];
		}

		if (isset($params['estado']) and is_numeric($params['estado'])) {
			$where .= ' camp_ofi.bo_activo = ? and';
			$parametros[] = $params['estado'];
		}

		if (isset($params['region']) and is_numeric($params['region'])) {
			$where .= ' reg.id_region = ? and';
			$parametros[] = $params['region'];
		}

		if (!empty($where)) {
			$where = ' where ' . $where;
			$where = trim($where, ' and');
			$query .= $where;
		}
		
		$resultado = $this->db->getQuery($query, $parametros)->runQuery();
		if ($resultado->getNumRows() > 0) {
			return $resultado->getRows();
		} else {
			return null;
		}

	}

}