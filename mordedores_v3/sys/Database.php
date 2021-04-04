<?php if(!defined('BASE_PATH')) exit('No se permite acceder a este script');

class Database extends PDO{

    private $select		= "";
    private $from		= "";
    private $where		= "";
    private $orderBy	= "";
    private $groupBy	= "";
    private $join		= "";
    private $limit		= "";
    private $valores	= array();
    private static $instance;

    public function __construct()
    {
        try{
        switch (DB_TYPE) {
            case 'MYSQL':
                parent::__construct(
                    'mysql:host=' . DB_HOST .
                    ';dbname=' . DB_NAME,
                    DB_USER,
                    DB_PASS,
                    array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '. DB_CHAR,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                        ));
                 self::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
                break;

            case 'PGSQL':
                 parent::__construct(
                    'pgsql:host=' . DB_HOST .
                    ';port=' . DB_PORT .
                    ';dbname=' . DB_NAME .
                    ';user=' . DB_USER .
                    ';password=' . DB_PASS
                    );
                 self::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                 self::setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
                break;
        }
    }catch(PDOException $e){
        Error::errorLog($e->getMessage(),Error::DATABASE_ERROR);
        die("Error al conectar a Base de Datos");
    }

    }

    static function _instance(){
        if(Zend_Registry::isRegistered("coneccion")){
            return Zend_Registry::get("coneccion");
        } else {
            $database = New Database();
            Zend_Registry::set("coneccion", $database);
            return $database;
        }
    }

    public function getInstance()
    {
        if(!isset(self::$instance)){
            $object = __CLASS__;
            self::$instance = new $object;
        }

        return self::$instance;
    }

    /**
     * Prepara la query para ejecutarla
     * @param [type] $sql [description]
     */
    private function setQuery($sql){
        return self::prepare($sql);
    }

    /**
     * Obtener todos los registros de la query entregada
     * @param  [type]  $query  [description]
     * @param  boolean $format [description]
     * @return [type]          [description]
     */
    private function getAllResult($query,$format=true){

        $result = $query->fetchAll(PDO::FETCH_OBJ);

        $resultado = array();
        if($format){
            $tmp = array();
            $i = 0;
            foreach($result as $row){
                $tmp['row_'.$i] = (object) $row;
                $i++;
            }
            $resultado['rows'] = (object) $tmp;
        }

        $resultado['numRows'] = $i;

        $resultado = (object) $resultado;
        return $resultado;
    }

    /**
     * Retorna datos de error en caso de generarse uno
     * @return array Arreglo que contiene informacion del error
     */
    public function getError(){
        return self::errorInfo();
    }

    /**
     * Retorna el ID del ultimo registro ingresado
     * Para PostgreSQL hay que indicar en el parámetro $name el nombre de la secuencia asociada al Id insertado
     * @param string $name nombre de la secuencia en caso de usarse para generacion de Id
     * @return [type] [description]
     */
    public function getLastId($name=null){
        if($name){
            return self::lastInsertId($name);
        }
        return self::lastInsertId();
    }

    /**
     * [select description]
     * @param  [type] $campos [description]
     * @return [type]         [description]
     */
    public function select($campos, $append = true){
        $sql = '';
        if(empty($this->select) or $append == false){
            $sql = 'SELECT ';
        }else{
            $sql = $this->select.',';
        }

        if(is_array($campos)){
            foreach($campos as $campo){
                $sql .= $campo.',';
            }
            $sql = trim(',',$sql);
        }else{
            $sql .= ' '.$campos;
        }

        $this->select = $sql . " ";
        return $this;
    }

    /**
     * [from description]
     * @param  [type] $tabla [description]
     * @return [type]        [description]
     */
    public function from($tabla){
        $sql = ' FROM '.$tabla.' ';
        $this->from .= $sql;
        return $this;
    }

    public function whereCondOr($array){
        
        if(empty($this->where)){
            $this->where = " WHERE ";
        }else{
            $this->where .= " AND ";
        }
        
        $sql = " (";
        $or = "";
        foreach($array as $where){
             $sql.= $or . $this->_condiciones($where["campo"], $where["condicion"], $where["valor"]);
             $or = " OR ";
             $this->_valores($where["condicion"], $where["valor"]);
        }
        $sql .=") ";
        $this->where .= $sql;
        return $this;
    }

    /**
     * [whereAnd description]
     * @param  string $campo     
     * @param  mixed $valor     
     * @param  string $condicion 
     * @return Database            
     */
    public function whereAND($campo,$valor,$condicion='='){
        $agregar_valores = true;
        
        $sql = '';

        if(empty($this->where)){
            $this->where = " WHERE ";
        }else{
            $this->where .= " AND ";
        }
                
        $this->where .= $this->_condiciones($campo, $condicion, $valor);
        $this->_valores($condicion, $valor);
        
        return $this;
    }
    
    protected function _valores($condicion, $valor){
        if($condicion == "IS NULL" OR $condicion == "IS NOT NULL"){
            $agregar_valores = false;
        } else {
            $agregar_valores = true;
        }
        
        
        if($agregar_valores){
            if(is_array($valor)){
                foreach($valor as $key => $value){
                    $this->valores[] = $value;
                }
            } else {
                $this->valores[] = $valor;
            }
        }
    }
    
    protected function _condiciones($campo, $condicion, $valor){
        $sql = "";
        switch ($condicion) {
            case $condicion == "IN" OR $condicion == "NOT IN":
                $arreglo = "";
                $coma = "";
                if(count($valor)>0){
                    foreach($valor as $field){
                        $arreglo .= $coma." ? ";
                        $coma = ",";
                    }
                $sql .= $campo. " ".$condicion." (".$arreglo.")";
                }
                break;
            case $condicion == "IS NULL" OR $condicion == "IS NOT NULL":
                $agregar_valores = false;
                $sql .= $campo. " " . $condicion;
                break;
            default:
                $sql .= $campo. " " . $condicion . " ? ";
                break;
        }
        return $sql;
    }

    /**
     * 
     * @param string $campo
     * @param string $condicion
     * @param string $valor
     * @return \Database
     */
    public function where($campo, $condicion, $valor = null){
        $sql = " WHERE " . $campo . " " . $condicion;
        if(!empty($valor)){
            $sql .= " ? ";
            $this->valores[] = $valor;
        }
        $this->where .= $sql;
        
        return $this;
    }
    
    /**
     * Añade un WHERE complejo
     * @param string $where
     */
    public function addWhere($where){
         if(empty($this->where)){
            $sql = " WHERE " .$where;
        }else{
            $sql = " AND " . $where;
        }
        $this->where .= $sql;
        return $this;
    }

    /**
     * [whereAnd description]
     * @param  [type] $campo     [description]
     * @param  [type] $valor     [description]
     * @param  string $condicion [description]
     * @return [type]            [description]
     */
    public function whereOR($campo,$valor,$condicion='='){
        $sql = '';

        if(empty($this->where)){
            $sql = " WHERE $campo $condicion ? ";
        }else{
            $sql = " OR $campo $condicion ? ";
        }

        $this->where .= $sql;
        $this->valores[] = $valor;
        return $this;
    }

    /**
     * [orderBy description]
     * @param  [type] $campo [description]
     * @param  string $orden [description]
     * @return [type]        [description]
     */
    public function orderBy($campo, $orden='ASC', $append = true){
        $sql = '';

        if(empty($this->orderBy)){
            $sql = " ORDER BY $campo $orden";
        }else{
            if($append){
                $sql = $this->orderBy . ", $campo $orden";
            } else {
                if($campo == ""){
                    $sql = "";
                }else {
                    $sql = " ORDER BY $campo $orden";
                }
            }
        }

        $this->orderBy = $sql;
        return $this;
    }

    /**
     * [groupBy description]
     * @param  [type] $campo [description]
     * @return [type]        [description]
     */
    public function groupBy($campo, $append = true){
        $sql = '';

        if(empty($this->groupBy) OR !$append){
            if($campo!=""){
                $sql = " GROUP BY $campo";
            } else {
                $sql = "";
            }
        }else{
            $sql = $this->groupBy . ", $campo";
        }


        $this->groupBy = $sql;
        return $this;
    }

    /**
     * [join description]
     * @param  [type] $tabla     [description]
     * @param  [type] $condicion [description]
     * @param  string $tipo      [description]
     * @return [type]            [description]
     */
    public function join($tabla,$condicion,$tipo='LEFT'){
        $sql = '';

        if(empty($this->join)){
            $sql = " $tipo JOIN $tabla ON $condicion ";
        }else{
            $sql = $this->join . " $tipo JOIN $tabla ON $condicion ";
        }

        $this->join = $sql;
        return $this;
    }

    /**
     * [limit description]
     * @param  [type] $comienzo [description]
     * @param  string $total    [description]
     * @return [type]           [description]
     */
    public function limit($comienzo,$total=''){
        $sql = " LIMIT $comienzo";

        if(!empty($total) && is_numeric($total)){
            $sql .= ",$total ";
        }

        $this->limit = $sql;
        return $this;
    }

    /**
     * Obtener resultado de query general formada
     * @return array resultado de la query
     */
    public function getResult(){
        global $config;

        $query = $this->select . $this->from . $this->join . $this->where  . $this->groupBy . $this->orderBy . $this->limit;

        $result = $this->setQuery($query);
        $result->execute($this->valores);

        $this->select = $this->from = $this->join = $this->where = $this->groupBy = $this->orderBy = $this->limit = "";
        $this->valores = null;

        return $this->getAllResult($result);

    }
    
    public function query(){
        return $query = $this->select . $this->from . $this->join . $this->where . $this->orderBy . $this->groupBy . $this->limit;
    }

    /**
     * [selectAll description]
     * @param  [type] $tabla  [description]
     * @param  [type] $campos [description]
     * @param  [type] $order  [description]
     * @return [type]         [description]
     */
    public function selectAll($tabla,$campos=null,$order=null){
        $sql = '';
        if($campos){
            $sql = "SELECT ";
            if(is_array($campos)){
                foreach($campos as $campo){
                    $sql .= "$campo,";
                }
                $sql = trim(',',$sql);
            }else{
                $sql = "$campos";
            }
            $sql .= " FROM $tabla";
        }else{
            $sql = "SELECT * FROM $tabla";
        }

        if($order){
            $sql .= ' ORDER BY ';
            if(is_array($order)){
                foreach($order as $ord){
                    $sql .= "$ord,";
                }
                $sql = trim(',',$sql);
            }else{
                $sql .= "$order";
            }
        }

        $selectAll = $this->setQuery($sql);
        $selectAll->execute();

        return $this->getAllResult($selectAll);
    }

    /**
     * [selectBy description]
     * @param  [type] $tabla      [description]
     * @param  [type] $parametros [description]
     * @param  [type] $campos     [description]
     * @param  [type] $order      [description]
     * @return [type]             [description]
     */
    public function selectBy($tabla,$parametros,$condicion='AND',$campos=null,$order=null){
        $sql = 'SELECT ';

        if($campos){
            if(is_array($campos)){
                foreach($campos as $campo){
                    $sql .= " $campo,";
                }
                $sql = trim(',',$sql);
            }else{
                $sql .= "$campo";
            }
            $sql .= " FROM $tabla ";
        }else{
            $sql .= " * FROM $tabla ";
        }

        $valores = array();
        $sql .= " WHERE ";
        if(count($parametros) > 1){
            foreach($parametros as $key => $value){
                $sql .= "$key = ? $condicion ";
                $valor[] = $value;
            }
            $sql = trim($condicion,$sql);
        }else{
            foreach ($parametros as $key => $value) {
                $sql .= "$key = ? ";
                $valores[] = $value;
            }
        }

        if($order){
            $sql .= ' ORDER BY ';
            if(is_array($order)){
                foreach($order as $ord){
                    $sql .= "$ord,";
                }
                $sql = trim(',',$sql);
            }else{
                $sql .= "$order";
            }
        }

        $selectBy = $this->setQuery($sql);
        $selectBy->execute($valores);

        return $this->getAllResult($selectBy);
    }

    /**
     * Ejecutar sql de consulta
     * @param  [type] $query      [description]
     * @param  [type] $parametros [description]
     * @return [type]             [description]
     */
    public function getQuery($query,$parametros=null){

        $tiempo_inicial = microtime(true);
        try{
            $result = self::prepare($query);

            if($parametros){
                if(is_array($parametros)){
                    $result->execute($parametros);
                }else{
                    $result->execute(array($parametros));
                }
                

            }else{
                $result->execute();
            }

           // if(defined('ENVIROMENT') and ENVIROMENT != "PROD"){
            if(defined('ENVIROMENT')){
                $tiempo_total = ((microtime(true) - $tiempo_inicial));
                $this->queryLog($tiempo_total,$this->getQueryString($query,$parametros));
            }
			
            $retorno				= $this->getAllResult($result);
            $retorno->printQuery	= $this->getQueryString($query,$parametros);

            return $retorno;
        }catch (PDOException $e){
            if(defined('ENVIROMENT')){
                $tiempo_total = ((microtime(true) - $tiempo_inicial));
                $this->queryLog($tiempo_total,$this->getQueryString($query,$parametros));
            }
            if(defined("ERROR_LOG_FILE")){
                Error::errorLog($e->getMessage(),Error::DATABASE_ERROR);
                Error::errorLog("Query: ".$this->getQueryString($query,$parametros),Error::DATABASE_ERROR);
                Error::errorLog("Datos: ".print_r($parametros,true),Error::DATABASE_ERROR);
            }else{
                error_log($e->getMessage());
            }
            if(ENVIROMENT!="PROD"){
                echo $e->getMessage() . "<br>";
                echo "<pre>";
                var_dump(debug_backtrace());
                echo "</pre>";
                die();
                //throw new Exception($e->getMessage());
            }
        }

    }


    /**
     * Obtener un solo registro en consulta sql
     * @param  string   $query      consulta SQL
     * @param  array    $parameters parametros para la consulta SQL
     * @return object               registro obtenido de la consulta SQL
     */
    public function getSingleQuery($query, $parameters=null){
        $result = self::prepare($query);
        if($parameters)
            $result->execute($parameters);
        else
            $result->execute();

        $result = $query->fetch();
        $result = (object) $result;

        return $result;

    }

    /**
     * Ingresa 
     * @param string $tabla
     * @param array $parametros
     * @return integer
     */
    public function insert($tabla, $parametros = array()){
        $campos_tabla = "";
        $valores_tabla = "";
        $coma = "";
        foreach($parametros as $campo => $valor){
            $campos_tabla  .= $coma . $campo;
            $valores_tabla .= $coma . "?";
            $coma = ",";
        }
        
        $sql = "INSERT INTO " . $tabla. "(". $campos_tabla .") VALUES(". $valores_tabla .")";
        $this->execQuery($sql, array_values($parametros));
        return $this->getLastId();
    }
    
    /**
     * 
     * @param string $tabla
     * @param array $parametros
     * @param string $primaria
     * @param int $id
     */
    public function update($tabla,$parametros = array(), $primaria, $id ){
        $sql = "UPDATE " . $tabla . " SET ";
        $set = "";
        $coma = "";
        foreach($parametros as $campo => $valor){
            $set .= $coma. $campo . " = ?";
            $coma = ",";
        }
        
        $where = " WHERE " . $primaria . " = ?";
        
        return $this->execQuery($sql . $set . $where, array_merge(array_values($parametros), array($id)));
    }
    
    /**
     * 
     * @param string $tabla
     * @param string $primaria
     * @param int $id
     */
    public function delete($tabla, $primaria, $id){
        $sql = "DELETE FROM " . $tabla . " WHERE " . $primaria . " = ?";
        return $this->execQuery($sql, $id);
    }

    /**
     * Ejecutar una sentencia SQL
     * @param  string $query      [description]
     * @param  array $parametros [description]
     * @return [type]             [description]
     */
    public function execQuery($query,$parametros=null){
        $tiempo_inicial = microtime(true);
        try{
            
            $result = self::prepare($query);
            if($parametros){
                if(is_array($parametros)){
                    $result->execute($parametros);
                }else{
                    $result->execute(array($parametros));
                }
                

            }else{
                $result->execute();
            }

            if(defined('ENVIROMENT')){
                $tiempo_total = ((microtime(true) - $tiempo_inicial));
                $this->queryLog($tiempo_total,$this->getQueryString($query,$parametros));    
            }

            if($result->rowCount() >= 0){
                return true;
            }else{
                return false;
            }
        }catch (PDOException $e){
            if(defined('ENVIROMENT')){
                $tiempo_total = ((microtime(true) - $tiempo_inicial));
                $this->queryLog($tiempo_total,$this->getQueryString($query,$parametros));    
            }

			if(defined("ERROR_LOG_FILE")){
				Error::errorLog($e->getMessage(),Error::DATABASE_ERROR);
				Error::errorLog("Query: ".$this->getQueryString($query,$parametros),Error::DATABASE_ERROR);
				Error::errorLog("Datos: ".print_r($parametros,true),Error::DATABASE_ERROR);
			}else{
				error_log($e->getMessage());
			}
        }


    }

    /**
     * obtener query con parametros incluidos
     * @param  [type] $query [description]
     * @param  [type] $data  [description]
     * @return [type]        [description]
     */
    public function getQueryString($query,$data=null){
        if($data){
            if(is_array($data)){
                $indexed = $data==array_values($data);
                foreach($data as $k=>$v) {
                    if(is_string($v)) $v="'$v'";
                    if($indexed) $query = preg_replace('/\?/',$v,$query,1);
                    else $query = str_replace(":$k",$v,$query);
                }   
            }else{
                if(is_string($data)) $data="'$data'";
                $query = preg_replace('/\?/',$data,$query,1);
                
            }
             
        }
        
        return $query;
           
    }

	/**
	* queryLog($tiempo,$gl_query) Registrar en Tabla mor_auditoria las querys de Insert y Update realizadas en el sistema
	* @param  string $tiempo Tiempo de Ejecución
	* @param  string $gl_query Query utilizada
	*/
    private function queryLog($gl_tiempo, $gl_query){
		$gl_query	= trim ($gl_query);
        $fecha		= date('Y-m-d H:i:s');
        $gl_tipo	= strtoupper(substr(trim($gl_query),0,6));
		$ip			= '';

        if($gl_tipo != "SELECT" ){
            if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $ip .= ' - '.$_SERVER["HTTP_CLIENT_IP"];
            }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $ip .= ' - '.$_SERVER["HTTP_X_FORWARDED_FOR"];
            }elseif (isset($_SERVER["HTTP_X_FORWARDED"])){
                $ip .= ' - '.$_SERVER["HTTP_X_FORWARDED"];
            }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])){
                $ip .= ' - '.$_SERVER["HTTP_FORWARDED_FOR"];
            }elseif (isset($_SERVER["HTTP_FORWARDED"])){
                $ip .= ' - '.$_SERVER["HTTP_FORWARDED"];
            }
            $ip		= $_SERVER['REMOTE_ADDR'] . $ip;

            if(!isset($_SESSION[SESSION_BASE]['id'])){
                $id_usuario	= 0;
                $gl_rut     = "";
            }else{
                $id_usuario	= $_SESSION[SESSION_BASE]['id'];
                $gl_rut     = (isset($_SESSION[SESSION_BASE]['rut']))?$_SESSION[SESSION_BASE]['rut']:"";
            }

			$conn = new PDO(
							'mysql:host=' . DB_HOST .
							';dbname=' . DB_NAME,
							DB_USER,
							DB_PASS,
							array(
								PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '. DB_CHAR,
								PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
								)
						);
            
            $query_log	= "INSERT INTO mor_auditoria values(DEFAULT,?,?,?,?,?,?,?,now())";
            $parametros = array($id_usuario,$gl_rut,$gl_tipo,$gl_query,$ip,$gl_tiempo,$id_usuario);
            $log		= $conn->prepare($query_log);
            $log->execute($parametros);
        }
    }

}
