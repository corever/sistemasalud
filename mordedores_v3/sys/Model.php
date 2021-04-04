<?php if(!defined('BASE_PATH')) exit('No se permite acceder a este script');

require_once (APP_PATH . "libs/Helpers/Cache.php");

class Model{
    /**
     *
     * @var string 
     */
    protected $_tabla;
    
    /**
     *
     * @var string 
     */
    protected $_primaria = "id";
    
    /**
     * Si la tabla cambia en el tiempo
     * si no cambia en el tiempo (false) 
     * se utiliza cache
     * @var boolean 
     */
    protected $_transaccional = true;
    
    /**
     *
     * @var Database
     */
    protected $db;
    
    /**
     *
     * @var Zend_Cache 
     */
    protected $cache;

    /**
     * 
     */
    public function __construct()
    {
        $this->cache = Cache::iniciar();
        $this->db = Database::_instance();
    }
    
    /**
     * Busca por clave primaria
     * @param int $id
     * @return array
     */
    public function getById($id){
        
        if(!$this->_transaccional){
            $cadena = "id_" . $this->_tabla . "_" . $id;
            if(!($resultado = $this->cache->load($cadena))){
                $resultado = $this->_getById($id);
                $this->cache->save($resultado, $cadena);
            }
        } else {
            $resultado = $this->_getById($id);
        }
        
        return $resultado;
    }
    
    /**
     * 
     * @param int $id
     * @return array
     */
    protected function _getById($id){
        $clave = $this->_tabla . "_id_" . $id;
        if(Zend_Registry::isRegistered($clave)){
            return Zend_Registry::get($clave);
        } else {
            $resultado = $this->db->select("*")
                                    ->from($this->_tabla)
                                    ->whereAND($this->_primaria, $id)
                                    ->getResult();
            if($resultado->numRows == 1){
                $salida = $resultado->rows->row_0;
            } else $salida = null;
            
            Zend_Registry::set($clave, $salida);
            return $salida;
        }
    }

    //x BC
     public function getByIdPrioridad($id){
        
        if(!$this->_transaccional){
            $cadena = "id_" . $this->_tabla . "_" . $id;
            if(!($resultado = $this->cache->load($cadena))){
                $resultado = $this->_getByIdPrioridad($id);
                $this->cache->save($resultado, $cadena);
            }
        } else {
            $resultado = $this->_getByIdPrioridad($id);
        }
        
        return $resultado;
    }
    
    /**
     * Lista la tabla
     * @param string $order_by
     * @return array
     */
    public function listar($order_by = null, $limit = null){
        if(!$this->_transaccional){
            $cadena = "lista_" . $this->_tabla . "_" . $order_by;
       
            if(!($resultado = $this->cache->load($cadena))){
                $resultado = $this->_listar($order_by, $limit);
                $this->cache->save($resultado, $cadena);
            }
        } else {
            $resultado = $this->_listar($order_by, $limit);
        }
        return $resultado;
    }
    
    /**
     * Lista la tabla
     * @param string $order_by
     * @return array
     */
    protected function _listar($order_by, $limit = null){
        $query = $this->db->select("*")
                          ->from($this->_tabla)
                          ->orderBy($order_by);

        if(!is_null($limit)){
            $query->limit($limit["comienzo"], $limit["total"]);
        }
        
        
        
        
        $lista = $query->getResult();
        
        if($lista->numRows > 0){
            $salida = $lista->rows;
        } else{
            $salida = null;
        }
        return $salida;
    }
    
    protected function _getByIdPrioridad($id){
        $clave = $this->_tabla . "_id_" . $id;
        if(Zend_Registry::isRegistered($clave)){
            return Zend_Registry::get($clave);
        } else {
            $resultado = $this->db->select("*")
                                    ->from($this->_tabla)
                                    ->whereAND($this->_primaria, $id)
                                    ->getResult();
            if($resultado->numRows == 1){
                $salida = $resultado->rows->row_0;
            } else $salida = null;
            
            Zend_Registry::set($clave, $salida);
            return $salida;
        }
    }
    
    /**
     * 
     * @param array $data
     * @return int
     */
    public function insert($data){
       // $this->_mayusculas($data);
        $data = $this->_eliminarNulos($data);
        return $this->db->insert($this->_tabla, $data);
    }
    
    /**
     * 
     * @param array $data
     * @param int $id
     */
    public function update($data, $id, $campo_id){
       // $this->_mayusculas($data);
        
        return $this->db->update($this->_tabla, $data, $campo_id, $id);
    }
    
    /**
     * Pasa a mayuscula
     * @param type $data
     */
    protected function _mayusculas(&$data){
        if(     $this->_tabla != "sum_comentario" 
            and $this->_tabla !="sum_resolucion_email"
            and $this->_tabla !="sum_memo" 
            and $this->_tabla!="sum_propuesta" 
            and $this->_tabla!="sum_archivo")
            {
            foreach($data as $campo => $valor){
                if($campo!= "img_firma_ruta_relativa" and $valor != null){
                    $data[$campo] = strtoupper($valor);
                }
            }
        }
    }
    
    protected function _eliminarNulos($data){
        foreach($data as $campo => $valor){
            if($valor == null){
                unset($data[$campo]);
            }
        }
        return $data;
    }
    
    /**
     * 
     * @param int $id
     */
    public function delete($id){
        //return $this->db->delete($this->_tabla, $this->_primaria, $id);
    }

    public function insertar($tabla,$campos){
      $this->db->insert($tabla,$campos);
    }

    public function actualizar($tabla,$campos,$id,$where){
      $this->db->update($tabla,$campos,$id,$where);
    }
}
