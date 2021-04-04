<?php

namespace App\General\Entity;

class DAODocumento extends \pan\Kore\Entity
{

    protected $table = TABLA_DOCUMENTO;
    protected $primary_key        = "id_documento";


    function __construct()
    {
        parent::__construct();
    }


    public function getAllByPerfil($id_perfil, $retornaLista = FALSE)
    {

        $query = "  SELECT      *
                    FROM         " . $this->table . "
                    WHERE       id_perfil    = ?
                    AND         bo_estado    = 1
                    AND         bo_mostrar   = 1
                    ";

        $param    = array($id_perfil);

        $result    = $this->db->getQuery($query, $param)->runQuery();


        $rows   = $result->getRows();

        if (!empty($rows) && !$retornaLista) {
            return $rows[0];
        } else {
            return $rows;
        }
    }

    /**
     * Descripción : Obtiene por Id_Perfil el gl_token, gl_nombre_documento, gl_nombre
     * @author   Sebastián Carroza - <sebastian.carroza@cosof.cl> - 12/07/2019
     */
    public function getDatosVista($id_perfil, $retornaLista = FALSE)
    {
        $query = "  SELECT      gl_token, gl_nombre_documento, gl_nombre
                    FROM         " . $this->table . "
                    WHERE       id_perfil    = ?
                    AND         bo_estado    = 1
                    AND         bo_mostrar   = 1
                    ";

        $param    = array($id_perfil);
        $result    = $this->db->getQuery($query, $param)->runQuery();
        $rows       = $result->getRows();

        if (!empty($rows) && !$retornaLista) {
            return $rows[0];
        } else {
            return $rows;
        }
    }
    /**
     * Descripción : Obtiene por Token el gl_nombre y gl_path
     * @author  David Guzmán - <david.guzman@cosof.cl> - 11/05/2018
     * @Updater Sebastián Carroza - <sebastian.carroza@cosof.cl> - 12/07/2019
     */
    public function getByToken($gl_token)
    {
        $query    = "	SELECT gl_nombre, gl_path
                        FROM " . $this->table . "
                        WHERE gl_token = ?";

        $param = array($gl_token);

        $result    = $this->db->getQuery($query, $param)->runQuery();

        $rows       = $result->getRows();

        if (!empty($rows)) {
            return $rows[0];
        } else {
            return NULL;
        }
    }

    /**
     * Descripcion  :   Obtiene los adjuntos de una fiscalizacion por su token
     * @author          Francisco Valdés <francisco.valdes@cosof.cl>
     * @param           string $gl_token_fiscalizacion
     */
    public function getByTokenFiscalizacion($gl_token)
    {
        $query    = "	SELECT  gl_nombre_documento,  
                                documento.gl_nombre,                                                          
                                documento.gl_path,
                                documento.gl_token,
                                doctipo.gl_nombre as gl_nombre_tipo
                        FROM    " . $this->table . " documento
                        JOIN    " . TABLA_FISCALIZACION . " fiscalizacion       USING(id_fiscalizacion)
                        LEFT OUTER JOIN    " . TABLA_DOCUMENTO_TIPO . " doctipo USING(id_documento_tipo)
                        WHERE fiscalizacion.gl_token = ?";

        $result   = $this->db->getQuery($query, $gl_token)->runQuery();

        if ($result->getNumRows() > 0) {
            return $result->getRows();
        } else {
            return NULL;
        }
    }

    /**
     * Descripcion  :   Devuelve TRUE si una fiscalizacion contiene documentos adjuntos
     * @author          Francisco Valdés <francisco.valdes@cosof.cl>
     * @param           $id_fiscalizacion
     */
    public function comprobarAdjuntos($id_fiscalizacion)
    {
        $query  =   "   SELECT  id_documento
                        FROM    mfis_documento
                        WHERE   id_fiscalizacion = ?
                        LIMIT   1";
        $result   = $this->db->getQuery($query, $id_fiscalizacion)->runQuery();
        return $result->getNumRows() > 0;
    }

    public function insertNuevo($parametros)
    {
        $id = \pan\utils\SessionPan::getSession('id');

        $query    = "	INSERT INTO " . $this->table . " (
                        id_documento_tipo,
                        id_fiscalizacion,
                        gl_token,
                        gl_nombre_documento,
                        gl_nombre,
                        gl_path,
                        id_usuario_crea,
                        fc_crea
                        ) VALUES (?,?,?,?,?,now())";
        $params = array(
            $parametros['id_documento_tipo'],
            $parametros['id_fiscalizacion'],
            $parametros['gl_token'],
            $parametros['gl_nombre_documento'],
            $parametros['gl_nombre'],
            $parametros['gl_path'],
            $id
        );

        $response = $this->db->execQuery($query, $params);

        if ($response) {
            return $this->db->getLastId();
        } else {
            return NULL;
        }
    }
}
