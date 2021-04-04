<?php
/**
******************************************************************************
* Sistema           : MANTENEDOR ESTABLECIMIENTOS DE SALUD
*
* Descripcion       : Modelo para Tabla noti_auditoria
*
* Plataforma        : !PHP
*
* Creacion          : 25/01/2019
*
* @name             DAOAdjunto.php
*
* @version          1.0
*
* @author           Victor Retamal <victor.retamal@cosof.cl>
*
******************************************************************************
* !ControlCambio
* --------------
* !cProgramador             !cFecha     !cDescripcion
* ----------------------------------------------------------------------------
*
* ----------------------------------------------------------------------------
* ****************************************************************************
*/
namespace App\_FuncionesGenerales\Adjuntos\Entity;

class DAOAdjunto extends \pan\Kore\Entity{
    protected $table           = TABLA_ADJUNTO;
    protected $primary_key     = "id_adjunto";
    protected $_transaccional  = false;

    function __construct()
    {
        parent::__construct();
    }

    public function getById($id){
        $query  = " SELECT * FROM ".$this->table."
            WHERE ".$this->primary_key." = ?";

        $param  = array(intval($id));
        $result = $this->db->getQuery($query,$param)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows(0);
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene por Token
     * @author  David Guzmán - david.guzman@cosof.cl - 08/05/2018
     */
    public function getByToken($gl_token) {
        $query  = " SELECT *
                    FROM ".$this->table."
                    WHERE gl_token = ?";

        $params = array($gl_token);
        $result = $this->db->getQuery($query,$params)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows(0);
        }else{
            return NULL;
        }
    }

    public function getLista($filtros = []){

        $this->db->select(" adj.*,
                            DATE_FORMAT(adj.fc_crea, '%d-%m-%Y') AS fc_crea,
                            adjunto_tipo.gl_nombre AS gl_tipo,
                            CONCAT(usuario.gl_nombres,' ',usuario.gl_apellidos) AS nombre_usuario
                          ")
                ->from($this->table, "adj")
                ->join(TABLA_ADJUNTO_TIPO." adjunto_tipo", "adj.id_adjunto_tipo = adjunto_tipo.id_adjunto_tipo")
                ->join(TABLA_ACCESO_USUARIO." usuario", "adj.id_usuario_crea = usuario.id_usuario")
                ->whereAND("adj.bo_estado", 1)
                ->whereAND("adj.bo_mostrar", 1);

        if(!empty($filtros)){

            if(!empty($filtros["id_adjunto"])){
                if(is_array($filtros["id_adjunto"])){
                    $this->db->whereAND("adj.id_adjunto", $filtros["id_adjunto"], 'IN');
                }
                else{
                    $this->db->whereAND("adj.id_adjunto", $filtros["id_adjunto"]);
                }
            }

            if(!empty($filtros["id_establecimiento"])){
                if(is_array($filtros["id_establecimiento"])){
                    $this->db->whereAND("adj.id_establecimiento", $filtros["id_establecimiento"], 'IN');
                }
                else{
                    $this->db->whereAND("adj.id_establecimiento", $filtros["id_establecimiento"]);
                }
            }

            if(!empty($filtros["id_expediente"])){
                if(is_array($filtros["id_expediente"])){
                    $this->db->whereAND("adj.id_expediente", $filtros["id_expediente"], 'IN');
                }
                else{
                    $this->db->whereAND("adj.id_expediente", $filtros["id_expediente"]);
                }
            }

            if(!empty($filtros["id_visita"])){
                if(is_array($filtros["id_visita"])){
                    $this->db->whereAND("adj.id_visita", $filtros["id_visita"], 'IN');
                }
                else{
                    $this->db->whereAND("adj.id_visita", $filtros["id_visita"]);
                }
            }

            if(!empty($filtros["id_fiscalizador"])){
                if(is_array($filtros["id_fiscalizador"])){
                    $this->db->whereAND("adj.id_fiscalizador", $filtros["id_fiscalizador"], 'IN');
                }
                else{
                    $this->db->whereAND("adj.id_fiscalizador", $filtros["id_fiscalizador"]);
                }
            }

            if(!empty($filtros["id_resolucion"])){
                if(is_array($filtros["id_resolucion"])){
                    $this->db->whereAND("adj.id_resolucion", $filtros["id_resolucion"], 'IN');
                }
                else{
                    $this->db->whereAND("adj.id_resolucion", $filtros["id_resolucion"]);
                }
            }

            if(!empty($filtros["id_inhabilitado"])){
                if(is_array($filtros["id_inhabilitado"])){
                    $this->db->whereAND("adj.id_inhabilitado", $filtros["id_inhabilitado"], 'IN');
                }
                else{
                    $this->db->whereAND("adj.id_inhabilitado", $filtros["id_inhabilitado"]);
                }
            }

            if(!empty($filtros["id_adjunto_tipo"])){
                if(is_array($filtros["id_adjunto_tipo"])){
                    $this->db->whereAND("adj.id_adjunto_tipo", $filtros["id_adjunto_tipo"], 'IN');
                }
                else{
                    $this->db->whereAND("adj.id_adjunto_tipo", $filtros["id_adjunto_tipo"]);
                }
            }

            if(!empty($filtros["id_usuario_crea"])){
                if(is_array($filtros["id_usuario_crea"])){
                    $this->db->whereAND("adj.id_usuario_crea", $filtros["id_usuario_crea"], 'IN');
                }
                else{
                    $this->db->whereAND("adj.id_usuario_crea", $filtros["id_usuario_crea"]);
                }
            }

            if(!empty($filtros["gl_token"])){
                $this->db->whereAND("adj.gl_token", $filtros["gl_token"]);
            }

            if(!empty($filtros["fecha_desde"]) && !empty($filtros['fecha_hasta'])){
                $this->db->addWhere("adj.fc_crea BETWEEN '".$filtros['fecha_desde']."  00:00:00'
                                                         AND '".$filtros['fecha_hasta']. " 00:00:00'");
            }
            else if(!empty($filtros["fecha_desde"])){
                $this->db->addWhere("adj.fc_crea >= '".$filtros['fecha_desde']."  00:00:00'");
            }
            if(!empty($filtros["fecha_hasta"])){
                $this->db->addWhere("adj.fc_crea <= '".$filtros['fecha_hasta']."  23:59:59'");
            }

        }

        $result = $this->db->runQuery();

        if ($result->getNumRows() > 0) {
            return $result->getRows();
        } else {
            return NULL;
        }
    }

    
    /**
     * Descripción : Obtiene por Id de Expediente
     * @author  David Guzmán - david.guzman@cosof.cl - 08/05/2018
     */
    public function getByIdExpediente($id_expediente) {
        $query  = " SELECT
                        adj.*,
                        DATE_FORMAT(adj.fc_crea, '%d-%m-%Y') AS fc_crea,
                        at.gl_nombre_tipo_adjunto AS gl_tipo,
                        CONCAT(u.gl_nombres,' ',u.gl_apellidos) AS nombre_usuario
                    FROM ".$this->table." adj
                        LEFT JOIN ".TABLA_ADJUNTO_TIPO." at ON adj.id_adjunto_tipo = at.id_adjunto_tipo
                        LEFT JOIN ".TABLA_ACCESO_USUARIO." u ON adj.id_usuario_crea = u.id_usuario
                    WHERE adj.id_expediente = ?";

        $params = array($id_expediente);
        $result = $this->db->getQuery($query,$params)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene por Id de Expediente
     * @author  Pablo Jimenez - pablo.jimenez@cosof.cl - 20/07/2018
     */
    public function getByIdExpedienteIdFiscalizador($id_expediente, $id_fiscalizador) {
        $query  = " SELECT
                        adj.*,
                        DATE_FORMAT(adj.fc_crea, '%d-%m-%Y') AS fc_crea,
                        at.gl_nombre_tipo_adjunto AS gl_tipo,
                        CONCAT(u.gl_nombres,' ',u.gl_apellidos) AS nombre_usuario
                    FROM ".$this->table." adj
                        LEFT JOIN ".TABLA_ADJUNTO_TIPO." at ON adj.id_adjunto_tipo = at.id_adjunto_tipo
                        LEFT JOIN ".TABLA_ACCESO_USUARIO." u ON adj.id_usuario_crea = u.id_usuario
                    WHERE adj.id_expediente = ?
                        AND adj.id_fiscalizador = ?";

        $params = array($id_expediente, $id_fiscalizador);
        $result = $this->db->getQuery($query,$params)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    /**
     * Descripción : Obtiene por Expediente y Tipo adjunto
     * @author  David Guzmán - david.guzman@cosof.cl - 11/06/2018
     */
    public function getByExpedienteyTipo($id_expediente,$id_tipo=0) {
        $query  = " SELECT *
                    FROM ".$this->table."
                    WHERE id_expediente = ?
                        AND id_adjunto_tipo = ?";

        $params = array($id_expediente,$id_tipo);
        $result = $this->db->getQuery($query,$params)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    public function getByIdEstablecimiento($id_establecimiento, $id_fiscalizacion = NULL, $id_resolucion = NULL) {

        $params = array();

        $query  = " SELECT
                        adj.*,
                        DATE_FORMAT(adj.fc_crea, '%d-%m-%Y') AS fc_crea,
                        at.gl_nombre_tipo_adjunto AS gl_tipo,
                        CONCAT(u.gl_nombres,' ',u.gl_apellidos) AS nombre_usuario
                    FROM ".$this->table." adj
                        LEFT JOIN ".TABLA_ADJUNTO_TIPO." at ON adj.id_adjunto_tipo = at.id_adjunto_tipo
                        LEFT JOIN ".TABLA_ACCESO_USUARIO." u ON adj.id_usuario_crea = u.id_usuario
                    WHERE adj.id_establecimiento = ? AND adj.bo_estado = 1";

        $params[] = $id_establecimiento;

        if (!is_null($id_fiscalizacion)) {
            $query .= " AND adj.id_fiscalizacion = ?";
            $params[] = $id_fiscalizacion;
        } else if (!is_null($id_resolucion)) {
            $query .= " AND adj.id_resolucion = ?";
            $params[] = $id_resolucion;
        }

        $result = $this->db->getQuery($query,$params)->runQuery();

        if($result->getNumRows() > 0){
            return $result->getRows();
        }else{
            return NULL;
        }
    }

    public function getCorrelativoEstablecimiento($id_establecimiento) {
        $query  = " SELECT adj.*
                    FROM ".$this->table." adj
                    WHERE adj.id_establecimiento = ?";

        $params = array($id_establecimiento);
        $result = $this->db->getQuery($query,$params)->runQuery();
        
        return $result->getNumRows() + 1;
    }

}

?>
