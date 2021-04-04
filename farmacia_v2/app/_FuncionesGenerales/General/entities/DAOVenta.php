<?php

namespace App\_FuncionesGenerales\General\Entity;

class DAOVenta extends \pan\Kore\Entity{

    protected $table       = TABLA_VENTA;
    protected $primary_key = "venta_id";

    function __construct(){
        parent::__construct();
    }

    public function getById($id_evento, $retornaLista = FALSE){

        $query	= "
        SELECT *
        FROM ".$this->table."
        WHERE ".$this->primary_key." = ?";

        $param	= array($id_evento);
        $result	= $this->db->getQuery($query,$param)->runQuery();
        $rows   = $result->getRows();

        if (!empty($rows) && !$retornaLista) {
            return $rows[0];
        }else {
            return $rows;
        }
	}

    public function getLista(){

        $query	= "SELECT * FROM ".$this->table;

        $result	= $this->db->getQuery($query)->runQuery();

        if($result->getNumRows()>0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    /*
    * Description: Obtiene las ultimas ventas asociadas al médico
    * @author: David Guzmán <david.guzman@cosof.cl> 01-09-2020
    */
	public function getLastByMedico($id_medico,$nr_cantidad=null){
		$query	= "	SELECT
                        venta.*,
						talonario.talonario_serie AS gl_serie,
						CONCAT(talonario.talonario_folio_inicial,' al ',talonario.talonario_folio_inicial) AS gl_folio,
						bodega.bodega_nombre AS gl_local_venta,
                        DATE_FORMAT(venta.fecha_transaccion,'%d-%m-%Y') AS fc_compra
                    FROM ".$this->table." venta
                    LEFT JOIN ".TABLA_TALONARIO_VENDIDOS." talonarios_vendidos ON talonarios_vendidos.fk_venta = venta.venta_id
					LEFT JOIN ".TABLA_TALONARIO." talonario ON talonarios_vendidos.fk_talonario = talonario.talonario_id
                    LEFT JOIN ".TABLA_ASIGNACION_TALONARIO." asignacion_talonario ON asignacion_talonario.fk_talonario = talonarios_vendidos.fk_talonario
                    LEFT JOIN ".TABLA_BODEGA." bodega ON bodega.bodega_id = asignacion_talonario.local_ven
                    WHERE venta.venta_id_medico = ?
                    ";

		if($nr_cantidad != null){
            $query .= " ORDER BY venta.fecha_transaccion DESC
                        LIMIT ".intval($nr_cantidad)."";
		}

		$result	= $this->db->getQuery($query,array($id_medico))->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}

	/**
	 * Descripción   : Insertar Venta
	 * @author       : David Guzmán <david.guzman@cosof.cl>
	 * @param        : $idMedico, $idUsuario, $idRegion
	 * @return       : int
	 */
	public function insertar($idMedico,$idUsuario,$idRegion)
	{

		$id     = false;
		$query  = "INSERT INTO " . $this->table . "
							(
								venta_id_medico,
								id_vendedor,
								id_region_midas
							)
							VALUES
							(
								?,?,?
							)";

		if ($this->db->execQuery($query, array($idMedico,$idUsuario,$idRegion))) {
			$id = $this->db->getLastId();
		}

		return $id;
	}

	/**
	 * Descripción : Editar Venta con datos de trámite ASD
	 * @author  David Guzmán <david.guzman@cosof.cl> - 03/09/2020
	 * @param   int   $id_venta, $gl_codigo, $nr_monto
	 */
	public function setDatosTramite($id_venta,$gl_codigo,$nr_monto)
	{
		$query	= "	UPDATE " . $this->table . "
					SET
                        gl_tramite	= ?,
                        monto       = ?
					WHERE venta_id = ?";

		$resp	= $this->db->execQuery($query, array($gl_codigo,$nr_monto,$id_venta));

		return $resp;
	}

	/**
	 * Descripción : Editar Venta Datos Boleta Generada
	 * @author  David Guzmán <david.guzman@cosof.cl> - 03/09/2020
	 * @param   int   $id_venta, $gl_codigo, $nr_monto
	 */
	public function setBoleta($id_venta,$pdf_nombre,$intentos)
	{
		$query	= "	UPDATE " . $this->table . "
					SET
                        archivo_boleta	= ?,
                        nr_intentos     = ?
					WHERE venta_id = ?";

		$resp	= $this->db->execQuery($query, array($pdf_nombre,$intentos,$id_venta));

		return $resp;
	}

    /*
    * Description: Obtener detalle datos Venta
    * @author: David Guzmán <david.guzman@cosof.cl> 01-09-2020
    */
	public function getDetalleById($id_venta){
		$query	= "	SELECT
                        venta.*,
						talonario.talonario_serie AS gl_serie,
						CONCAT(talonario.talonario_folio_inicial,' al ',talonario.talonario_folio_inicial) AS gl_folio,
						bodega.bodega_nombre AS gl_local_venta,
                        DATE_FORMAT(venta.fecha_transaccion,'%d-%m-%Y') AS fc_compra,
						medico.mu_rut_midas AS gl_rut_medico,
						medico.mu_nombre AS gl_nombre_medico,
						medico.mu_apellido_paterno AS gl_apellidop_medico,
						medico.mu_apellido_materno AS gl_apellidom_medico,
						especialidad.especialidad_nombre AS gl_especialidad_medico,
						vendedor.mu_rut_midas AS gl_rut_vendedor,
						vendedor.mu_nombre AS gl_nombre_vendedor,
						vendedor.mu_apellido_paterno AS gl_apellidop_vendedor,
						vendedor.mu_apellido_materno AS gl_apellidom_vendedor
                    FROM ".$this->table." venta
                    LEFT JOIN ".TABLA_TALONARIO_VENDIDOS." talonarios_vendidos ON talonarios_vendidos.fk_venta = venta.venta_id
					LEFT JOIN ".TABLA_TALONARIO." talonario ON talonarios_vendidos.fk_talonario = talonario.talonario_id
                    LEFT JOIN ".TABLA_ASIGNACION_TALONARIO." asignacion_talonario ON asignacion_talonario.fk_talonario = talonarios_vendidos.fk_talonario
                    LEFT JOIN ".TABLA_BODEGA." bodega ON bodega.bodega_id = asignacion_talonario.local_ven
                    LEFT JOIN ".TABLA_ACCESO_USUARIO." vendedor ON venta.id_vendedor = vendedor.mu_id
                    LEFT JOIN ".TABLA_ACCESO_USUARIO." medico ON venta.venta_id_medico = medico.mu_id
                    LEFT JOIN ".TABLA_MEDICO." medicos ON venta.venta_id_medico = medicos.id_medico
                    LEFT JOIN ".TABLA_ESPECIALIDAD." especialidad ON especialidad.especialidad_id = medicos.fk_esp
                    WHERE venta.venta_id = ?
                    ";

		$result	= $this->db->getQuery($query,array($id_venta))->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows(0);
		}else{
            return NULL;
		}
	}

    /*
    * Description: Obtener detalle datos Venta
    * @author: David Guzmán <david.guzman@cosof.cl> 01-09-2020
    */
	public function getListaDetalleByBodega($params){
		$query	= "	SELECT
                        venta.*,
						talonario.talonario_serie AS gl_serie,
						CONCAT(talonario.talonario_folio_inicial,' al ',talonario.talonario_folio_inicial) AS gl_folio,
						CONCAT(talonario.talonario_serie,' [',talonario.talonario_folio_inicial,'] [',talonario.talonario_folio_final,']') AS gl_serie,
						bodega.bodega_nombre AS gl_local_venta,
                        DATE_FORMAT(venta.fecha_transaccion,'%d-%m-%Y') AS fc_compra,
						medico.mu_rut_midas AS gl_rut_medico,
						medico.mu_nombre AS gl_nombre_medico,
						medico.mu_apellido_paterno AS gl_apellidop_medico,
						medico.mu_apellido_materno AS gl_apellidom_medico,
						especialidad.especialidad_nombre AS gl_especialidad_medico,
						vendedor.mu_rut_midas AS gl_rut_vendedor,
						vendedor.mu_nombre AS gl_nombre_vendedor,
						vendedor.mu_apellido_paterno AS gl_apellidop_vendedor,
						vendedor.mu_apellido_materno AS gl_apellidom_vendedor
                    FROM ".$this->table." venta
                    LEFT JOIN ".TABLA_TALONARIO_VENDIDOS." talonarios_vendidos ON talonarios_vendidos.fk_venta = venta.venta_id
					LEFT JOIN ".TABLA_TALONARIO." talonario ON talonarios_vendidos.fk_talonario = talonario.talonario_id
                    LEFT JOIN ".TABLA_ASIGNACION_TALONARIO." asignacion_talonario ON asignacion_talonario.fk_talonario = talonarios_vendidos.fk_talonario
                    LEFT JOIN ".TABLA_BODEGA." bodega ON bodega.bodega_id = asignacion_talonario.local_ven
                    LEFT JOIN ".TABLA_ACCESO_USUARIO." vendedor ON venta.id_vendedor = vendedor.mu_id
                    LEFT JOIN ".TABLA_ACCESO_USUARIO." medico ON venta.venta_id_medico = medico.mu_id
                    LEFT JOIN ".TABLA_MEDICO." medicos ON venta.venta_id_medico = medicos.id_medico
                    LEFT JOIN ".TABLA_ESPECIALIDAD." especialidad ON especialidad.especialidad_id = medicos.fk_esp
                    
					";
					
		if($params){
			$and = " WHERE ";
			if(isset($params['id_bodega'])){
				$query .= $and." bodega.bodega_id = ".intval($params['id_bodega']);
			}
			if(isset($params['fc_venta_talonario']) && trim($params['fc_venta_talonario']) != ""){
				$and 	= " AND ";
				$arrFechas = explode(" - ",$params['fc_venta_talonario']);
				$query .= $and." DATE_FORMAT(venta.fecha_transaccion,'%d-%m-%Y') BETWEEN '".$arrFechas[0]."' AND '".$arrFechas[1]."'";
			}
			if(isset($params['gl_nombre_medico']) && trim($params['gl_nombre_medico']) != ""){
				$and 	= " AND ";
				$query .= $and." medico.mu_nombre LIKE '%".intval($params['gl_nombre_medico'])."%'";
				$query .= $and." medico.mu_apellido_paterno LIKE '%".intval($params['gl_nombre_medico'])."%'";
				$query .= $and." medico.mu_apellido_materno LIKE '%".intval($params['gl_nombre_medico'])."%'";
				$query .= $and." CONCAT(medico.mu_nombre,medico.mu_apellido_paterno,medico.mu_apellido_materno) LIKE '%".intval($params['gl_nombre_medico'])."%'";
			}
			if(isset($params['gl_codigo_recaudacion']) && trim($params['gl_codigo_recaudacion']) != ""){
				$and 	= " AND ";
				$query .= $and." CONCAT(venta.comprobante_pago,' ',DATE_FORMAT(venta.fecha_pago,'%d-%m-%Y')) LIKE '%".intval($params['gl_codigo_recaudacion'])."%'";
			}
		}

		$result	= $this->db->getQuery($query)->runQuery();

		if($result->getNumRows()>0){
            return $result->getRows();
		}else{
            return NULL;
		}
	}

	/**
	 * Descripción : Editar Estado Venta
	 * @author  David Guzmán <david.guzman@cosof.cl> - 10/09/2020
	 * @param   int   $id_venta, $bo_estado
	 */
	public function setEstadoVenta($id_venta,$bo_estado=0)
	{
		$query	= "	UPDATE " . $this->table . "
					SET
						estado_venta	= ?
					WHERE venta_id 	= ?";

		$resp	= $this->db->execQuery($query, array($bo_estado,$id_venta));

		return $resp;
	}

}
