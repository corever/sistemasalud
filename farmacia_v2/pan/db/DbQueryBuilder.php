<?php

namespace Pan\Db;

use Pan\Utils\ErrorPan as ErrorPan;
use Pan\Utils\ValidatePan as validatePan;

class DbQueryBuilder
{

    protected $db;

    protected $table;

    protected $primary_key;

    private $string_query;

    private $select;

    private $from;

    private $orderBy;

    private $groupBy;
    
    private $having;

    private $order;

    private $where;

    private $limit;

    private $join;

    private $result;

    private $num_rows;

    private $query;

    private $params;

    public function __construct()
    {
        $this->db = new \pan\Db\DbConexion();
    }


    public function fields($fields = null)
    {
        if (is_null($fields)) {
            ErrorPan::_showErrorAndDie('Se deben ingresar los campos que se desean seleccionar: ' . $this->query);
        }

        if ($this->query === "")
            $this->query = "select ";

        /*if (empty($this->string_query) and validatePan::isLiteral($fields))
            $this->string_query = 'SELECT ' . $fields;*/

        if (validatePan::isArray($fields)) {
            $fields_name = '';
            foreach ($fields as $field) {
                $fields_name .= $field . ', ';
            }
            $fields = trim($fields_name, ', ');

        }
        $this->query = str_replace('*', $fields, $this->query);
        return $this->getQuery($this->query, $this->params);

    }


    public function select($fields = null)
    {

        if ($this->select == "")
            $this->select = "SELECT ";
        
        /*if (empty($this->string_query) and validatePan::isLiteral($fields))
            $this->string_query = 'SELECT ' . $fields;*/

        if (validatePan::isArray($fields)) {
            $fields_name = '';
            foreach ($fields as $field) {
                $fields_name .= $field . ', ';
            }
            $fields = trim($fields_name, ', ');
            $this->select .= $fields . ' ';

        }elseif(is_string($fields)){
            $this->select .= $fields . ' ';
        }else{
            $this->select .= ' * ';
        }

        return $this;
    }


    public function conditions($conditions = null)
    {
        if (!is_null($conditions)) {
            $this->query .= ' where ';
            if (is_array($conditions)) {
                $parameters = array();
                foreach ($conditions as $field => $value) {
                    if(is_array($value)){
                        $this->query .= $field . ' ' . $value[1] . ' ? and ';
                        $parameters[] = $value[0];
                    }else{
                        $this->query .= $field . ' = ? and ';
                        $parameters[] = $value;
                    }
                }
                $this->query = trim($this->query, 'and ');
                $this->params = $parameters;
            } elseif (is_string($conditions)) {
                //$this->query .= ' where ' . $conditions;
                $this->query .= $conditions;
            } elseif (is_numeric($conditions)) {
                $this->query .= $this->primary_key . ' = ?';
            }
        }
        return $this->getQuery($this->query, $this->params);
    }

    public function from($from, $alias = null)
    {
        $this->from = ' FROM ' . $from;
        if (!is_null($alias))
            $this->from .= ' ' . $alias . ' ';

        return $this;
    }


    public function join($table, $conditions, $position = 'LEFT')
    {
        $this->join .= ' ' . $position . ' JOIN ' . $table . ' ON ' . $conditions;

        return $this;
    }


    /*public function limit($num_limit, $total = null)
    {
        $total_limit = '';
        if (!is_null($total))
            if (strtolower(DB_TYPE) === 'mysql')
                $total_limit = ',' . $total;
            elseif (strtolower(DB_TYPE) === 'pgsql')
                $total_limit = ' offset ' . $total;

        $this->query .= ' limit ' . $num_limit . $total_limit;
        //return $this->getQuery($this->query, $this->params);
    }*/

    /**
     * 
     * @param type $comienzo
     * @param type $total
     * @return \Query
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
     * [having description]
     * @param  [type] $campo [description]
     * @return [type]        [description]
     */
    public function having($condicion){
        $sql = '';

        if(empty($this->having)){
            if($condicion!=""){
                $sql = " HAVING $condicion";
            } else {
                $sql = "";
            }
        }else{
            $sql = $this->having . " AND $condicion";
        }

        $this->having = $sql;
        return $this;
    }
    
    /*public function order($by, $order = 'ASC')
    {
        if (validatePan::isArray($by)) {
            $order_query = ' order by ';
            foreach ($by as $key => $value) {
                $order_query .= $key . ' ' . $value . ', ';
            }
            $order_query = trim($order_query, ', ');
            $this->query .= ' ' . $order_query;
        } else {
            $this->query .= ' order by ' . $by . ' ' . $order;
        }

        return $this->getQuery($this->query, $this->params);
    }*/

    /**
     * 
     * @param type $campo
     * @param type $orden
     * @param type $append
     * @return \Query
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
     * Clausula WHERE
     * @param  string $con_logic Conector logico para clausula WHERE: AND|OR
     * @param  array $params    Arreglo con el campo involucrado en clausula WHERE, formato ['campo' => 'valor']
     * @param  string $condition Condicion para la clausula. Por defecto es '='
     */
    public function where($con_logic,$params,$condition = '=')
    {
        if(empty($this->where)){
            $this->where = ' WHERE ';
        }else{
            $this->where = ' ' . strtoupper($con_logic);
        }

        if(is_array($params)){
            $parameters = array();
            foreach ($params as $field => $value) {
                $this->where .= $field . ' ' .$condition. ' ? ';
                $parameters[] = $value;
            }
            
            $this->params = $parameters;
        }

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

    /**
     * Genera condicion OR entre N operaciones
     * @param array $array array(array("campo","condicion","valor"), array("campo","condicion","valor"),...)
     * @return \Database
     */
    public function whereCondOr($array){
        if(empty($this->where)){
            $this->where = " WHERE ";
        }else{
            $this->where .= " AND ";
        }
        
        $sql = " (";
        $or = "";
        foreach($array as $where){
            if(isset($where["valor"])){
                $sql.= $or . $this->_condiciones($where["campo"], $where["condicion"], $where["valor"]);
                $this->_valores($where["condicion"], $where["valor"]);
            }
            elseif(isset($where["consulta"])){
                $sql.= $or . $where["campo"] . $where["condicion"] ." (".$this->_crearSubconsulta($where["consulta"]).") ";
            }
            else{
                $this->_valores($where["condicion"], $where["valor"]);
            }

            $or = " OR ";
            /*
            $sql.= $or . $this->_condiciones($where["campo"], $where["condicion"], $where["valor"]);
            $or = " OR ";
            $this->_valores($where["condicion"], $where["valor"]);
            */
        }
        $sql .=") ";
        $this->where .= $sql;
        return $this;
    }

    /**
     * 
     * @param type $campo
     * @param type $valor
     * @param type $condicion
     * @return \Query
     */
    public function whereOR($campo,$valor,$condicion='='){
        $sql = '';

        if(empty($this->where)){
            $sql = " WHERE $campo $condicion ? ";
        }else{
            $sql = " OR $campo $condicion ? ";
        }

        $this->where .= $sql;
        $this->_valores($condicion, $valor);
        return $this;
    }

    /**
     * Genera subquery en el where realizando las validaciones del queryByilder
     * @param array $array array(array("campo","condicion","valor"), array("campo","condicion","valor"),...)
     * @return \Database
     */
    public function whereSubQuery($subQuery){
        if(empty($this->where)){
            $this->where = " WHERE ";
        }else{
            $this->where .= " AND ";
        }
        
        $sql = " (";
        $sql .= $subQuery["campo"] . $subQuery["condicion"] ." (".$this->_crearSubconsulta($subQuery["consulta"]).") ";
        $sql .=") ";
        $this->where .= $sql;

        return $this;
    }

    protected function _crearSubconsulta($consulta = array()){
        $query = "";
        if(!empty($consulta)){
            /** EJEMPLO: ***********************************************
                "consulta" => array(
                    "select" => "id",
                    "from" => TABLA_EXPEDIENTE." ex",
                    "where" => array(
                        array(
                            "campo" => "ex.id_expediente_principal_v4",
                            "condicion" => "=",
                            "valor" => (int)$params["id_expediente"],
                        )
                    )
                )
            ************************************************************ */

            $query = "SELECT ".$consulta["select"] . " FROM " . $consulta["from"];
            if(isset($consulta["join"])){
                if(is_array($consulta["join"])){
                    foreach ($consulta["join"] as $join) {
                        $table = $join[0];
                        $conditions = [1];
                        $position = isset($join[2]) ? $join[2] : 'LEFT';

                        $query .= $position . ' JOIN ' . $table . ' ON ' . $conditions;
                    }
                }
                else{
                    $table = $$consulta["join"][0];
                    $conditions = [1];
                    $position = isset($$consulta["join"][2]) ? $$consulta["join"][2] : 'LEFT';
                    
                    $query .= $position . ' JOIN ' . $table . ' ON ' . $conditions;
                }
            }
            if(is_array($consulta["where"][0])){
                $where = "";
                foreach ($consulta["where"] as $validacion) {
                    if(empty($where)){
                        $where = " WHERE ";
                    }else{
                        $where .= " AND ";
                    }
                    $where .= $this->_condiciones($validacion["campo"], $validacion["condicion"], $validacion["valor"]);
                    $this->_valores($validacion["condicion"], $validacion["valor"]);
                }

                $query .= $where;
            }
            else{
                $query .= " WHERE " . $this->_condiciones($consulta["where"]["campo"], $consulta["where"]["condicion"], $consulta["where"]["valor"]);
                $this->_valores($consulta["where"]["condicion"], $consulta["where"]["valor"]);
            }
        }

        return $query;
    }

    /**
     * Arma condiciones para el Where
     * @param string $campo campo de la tabla
     * @param string $condicion tipo de condicion
     * @param string $valor valor a comparar
     * @return string
     */
    protected function _condiciones($campo, $condicion, $valor){
        $sql = "";

        switch ($condicion) {
            case $condicion == "IN" OR $condicion == "NOT IN":
                $arreglo = "";
                $coma = "";
                if(is_string($valor)){
                    
                    $valor = explode(',',$valor);
                }
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
     * Agrega valores de comparar a la consulta
     * @param string $condicion tipo de condicion
     * @param string $valor valor a comparar
     */
    protected function _valores($condicion, $valor){

        if($condicion == "IS NULL" OR $condicion == "IS NOT NULL"){
            $agregar_valores = false;
        } else {
            $agregar_valores = true;
        }
        
        if($agregar_valores){
            if(is_string($valor)){
                $valor = explode(',',$valor);
            }
            if(is_array($valor)){
                foreach($valor as $key => $value){
                    $this->params[] = $value;
                }
            } else {
                $this->params[] = $valor;
            }
        }
    }

    /**
     * ejecutar una sentencia SELECT
     * @param  [string] $query      [setencia SQL a ejecutar]
     * @param  [mixed] $parameters [(opcional) puede ser un array de parametros o un solo parametro]
     * @return [object]             [retorna los resultados de la sentencia como objetos]
     */
    public function getQuery($query, $parameters = null)
    {

        $this->query = $query;
        $this->params = $parameters;

        return $this;
        /*try {
            $stmt = $this->db->prepareQuery($query);
            if (!is_null($parameters)) {
                if (is_array($parameters)) {
                    $stmt->execute($parameters);
                } else {
                    $stmt->execute(array($parameters));
                }
            } else {
                $stmt->execute();
            }
            $this->num_rows = $stmt->rowCount();
            $this->result = $stmt->fetchAll();
            //return $stmt->fetchAll();
            return $this;
        } catch (\PDOException $e) {
            errorPan::_showErrorAndDie($e->getMessage());
        } catch (\Exception $e) {
            errorPan::_showErrorAndDie($e->getMessage());
        }*/
    }

    /**
     * ejecutar una sentencia DELETE, UPDATE o INSERT
     * @param  string $query sentencia SQL a ejecutar
     * @param  mixed $parameters (opcional) puede ser un array de parametros, o un solo parametro
     * @return boolean             TRUE si se ejecuto correctamente la sentencia, o de lo contrario retorna NULL
     */
    public function execQuery($query, $parameters = null)
    {
        $this->query = $query;
        $this->params = $parameters;

        try {
            $stmt = $this->db->prepareQuery($query);
            $tiempo_inicial = microtime(true);
            if (!is_null($parameters)) {
                if (is_array($parameters)) {
                    $stmt->execute($parameters);
                } else {
                    $stmt->execute(array($parameters));
                }
            } else {
                $stmt->execute();
            }

            $total_time = ((microtime(true) - $tiempo_inicial));

            $this->query = $this->select = $this->from = $this->join = $this->where = $this->orderBy = $this->groupBy = $this->limit = "";
            $this->params = null;
            
            // auditoria
            if(\pan\Kore\App::getAudit()){
                
                //Agregar BD si no existe
                $this->db->prepareQuery("CREATE DATABASE IF NOT EXISTS ".DB_NAME_AUDIT.";")->execute();
                
                $conn_auditoria = new \Pan\Db\DbConexion(DB_TYPE_AUDIT, DB_HOST_AUDIT, DB_PORT_AUDIT, DB_NAME_AUDIT, DB_USER_AUDIT, DB_PASS_AUDIT, DB_CHARSET_AUDIT);
                /*$stmt_auditoria = $conn_auditoria->prepareQuery($this->auditTable());
                $stmt_auditoria->execute();*/
                $fecha = date('Y-m-d H:i:s');
                $ip = '';
                if (isset($_SERVER["HTTP_CLIENT_IP"]))
                {
                    $ip = $_SERVER["HTTP_CLIENT_IP"];
                }
                elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
                {
                    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                }
                elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
                {
                    $ip = $_SERVER["HTTP_X_FORWARDED"];
                }
                elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
                {
                    $ip = $_SERVER["HTTP_FORWARDED_FOR"];
                }
                elseif (isset($_SERVER["HTTP_FORWARDED"]))
                {
                    $ip = $_SERVER["HTTP_FORWARDED"];
                }

                $ip = $_SERVER['REMOTE_ADDR'] . " - " . $ip;

                if(!isset($_SESSION[SESSION_BASE]['id'])){
                    $usuario = 0;
                }else{
                    $usuario = $_SESSION[SESSION_BASE]['id'];
                }

                if(trim(strtoupper($this->getTipoQuery($this->showQuery()))) != "SELECT"){
                    
                    //Crear tabla si no existe
                    $conn_auditoria->prepareQuery($this->auditTable())->execute();
                    
                    $tipo = $this->getTipoQuery($this->showQuery());
                    $insert_query_log = 'insert into '.DB_PREFIX_AUDIT.'auditoria_'.date('m').'(id_usuario,fc_ejecucion,gl_query,gl_tipo,gl_tiempo,ip_usuario) values(?,?,?,?,?,?)';
                    $parameters_log = array(
                        $usuario,
                        date('Y-m-d H:i:s'),
                        $this->showQuery(),
                        mb_strtoupper($tipo),
                        $total_time,
                        $ip
                    );
                    $stmt_auditoria = $conn_auditoria->prepareQuery($insert_query_log);
                    $stmt_auditoria->execute($parameters_log);
                }

            }

            if ($stmt->rowCount() >= 0) {
                return true;
            } else {
                return null;
            }
        } catch (\PDOException $e) {
            error_log($e->getMessage());
            ErrorPan::_showErrorAndDie($e->getMessage()."<br><pre>".$query."</pre><br>");
        } catch (\Exception $e) {
            error_log($e->getMessage());
            ErrorPan::_showErrorAndDie($e->getMessage()."<br><pre>".$query."</pre><br>");
        }
    }

    /**
     * muestra la query en formato RAW, con parametros incluidos
     * @return [string] [retorna la query formada]
     */
    public function showQuery()
    {
        $keys = array();
        $values = array();

        if (validatePan::isArray($this->params)) {
            foreach ($this->params as $key => $value) {
                if (is_string($key)) {
                    $keys[] = '/:' . $key . '/';
                } else {
                    $keys[] = '/[?]/';
                }

                if (is_numeric($value)) {
                    $values[] = (int)($value);
                } else {
                    $values[] = '"' . $value . '"';
                }
            }
        } else {
            if (is_string($this->params)) {
                $keys[] = '/:' . $this->params . '/';
            } else {
                $keys[] = '/[?]/';
            }

            if (is_numeric($this->params)) {
                $values[] = (int)($this->params);
            } else {
                $values[] = '"' . $this->params . '"';
            }
        }

        if(empty($this->query) or is_null($this->query))
            $this->query = $this->select . $this->from . $this->join . $this->where .  $this->groupBy . $this->having . $this->orderBy . $this->limit;

        $query = preg_replace($keys, $values, $this->query, 1, $count);
        
        return $query;
    }


    public function runQuery()
    {
        try {
            $store = new \Pan\Db\DbStore();

            if(empty($this->query) or is_null($this->query))
                $this->query = $this->select . $this->from . $this->join . $this->where . $this->groupBy . $this->having . $this->orderBy. $this->limit;
            
            $stmt = $this->db->prepareQuery($this->query);
            $tiempo_inicial = microtime(true);
            if (!is_null($this->params)) {
                if (is_array($this->params)) {
                    $stmt->execute($this->params);
                } else {
                    $stmt->execute(array($this->params));
                }
            } else {
                $stmt->execute();
            }
            $total_time = ((microtime(true) - $tiempo_inicial));
            
            // auditoria
            if(\pan\Kore\App::getAudit()){
                
                //Agregar BD si no existe
                $this->db->prepareQuery("CREATE DATABASE IF NOT EXISTS ".DB_NAME_AUDIT.";")->execute();
                
                $conn_auditoria = new \Pan\Db\DbConexion(DB_TYPE_AUDIT, DB_HOST_AUDIT, DB_PORT_AUDIT, DB_NAME_AUDIT, DB_USER_AUDIT, DB_PASS_AUDIT, DB_CHARSET_AUDIT);
                /*$stmt_auditoria = $conn_auditoria->prepareQuery($this->auditTable());
                $stmt_auditoria->execute();*/
                $fecha = date('Y-m-d H:i:s');
                $ip = '';
                if (isset($_SERVER["HTTP_CLIENT_IP"]))
                {
                    $ip = $_SERVER["HTTP_CLIENT_IP"];
                }
                elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
                {
                    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                }
                elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
                {
                    $ip = $_SERVER["HTTP_X_FORWARDED"];
                }
                elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
                {
                    $ip = $_SERVER["HTTP_FORWARDED_FOR"];
                }
                elseif (isset($_SERVER["HTTP_FORWARDED"]))
                {
                    $ip = $_SERVER["HTTP_FORWARDED"];
                }

                $ip = $_SERVER['REMOTE_ADDR'] . " - " . $ip;

                if(!isset($_SESSION[SESSION_BASE]['id'])){
                    $usuario = 0;
                }else{
                    $usuario = $_SESSION[SESSION_BASE]['id'];
                }

                if(trim(strtoupper($this->getTipoQuery($this->showQuery()))) != "SELECT"){
                    
                    //Crear tabla si no existe
                    $conn_auditoria->prepareQuery($this->auditTable())->execute();
                    
                    $tipo = $this->getTipoQuery($this->showQuery());
                    $insert_query_log = 'insert into '.DB_PREFIX_AUDIT.'auditoria_'.date('m').'(id_usuario,fc_fecha,gl_query,gl_tipo,gl_tiempo,ip_usuario) values(?,?,?,?,?)';
                    $parameters_log = array(
                        $usuario,
                        date('Y-m-d H:i:s'),
                        $this->showQuery(),
                        mb_strtoupper($tipo),
                        $total_time,
                        $ip
                    );
                    $stmt_auditoria = $conn_auditoria->prepareQuery($insert_query_log);
                    $stmt_auditoria->execute($parameters_log);
                }

            }

            /*if ($stmt->rowCount() === 1) {
                $this->result = $stmt->fetch();
            }else{
                $this->result = $stmt->fetchAll();    
            }*/
            $this->result = $stmt->fetchAll(); 
            $store->setRows($this->result);
            $store->setNumRows($stmt->rowCount());
            $store->setQueryString($this->showQuery());
            //$this->num_rows = $stmt->rowCount();



            //return $stmt->fetchAll();
            //
            $this->query = $this->select = $this->from = $this->join = $this->where = $this->orderBy = $this->groupBy = $this->limit = "";
            $this->params = null;

            return $store;
        } catch (\PDOException $e) {
            file_put_contents('php://stderr', PHP_EOL . "e->getMessage():" . print_r($e->getMessage(), TRUE). PHP_EOL, FILE_APPEND);
            ErrorPan::_showErrorAndDie($e->getMessage()."<br><pre>".$this->showQuery()."</pre><br>");
            return null;
        } catch (\Exception $e) {
            file_put_contents('php://stderr', PHP_EOL . "e->getMessage():" . print_r($e->getMessage(), TRUE). PHP_EOL, FILE_APPEND);
            ErrorPan::_showErrorAndDie($e->getMessage()."<br><pre>".$this->showQuery()."</pre><br>");
            return null;
        }
    }


    /**
     * Ingresa datos en tabla
     * @param string $tabla
     * @param array $parametros
     * @return int identificador del nuevo registro
     */
    /*public function insert($parametros){
        
        $campos_tabla = "";
        $valores_tabla = "";
        $coma = "";
        foreach($parametros as $campo => $valor){
            $campos_tabla  .= $coma . $campo;
            $valores_tabla .= $coma . "?";
            $coma = ",";
        }
        
        $sql = "INSERT INTO " . $this->table. "(". $campos_tabla .") VALUES(". $valores_tabla .")";
        //$this->db->query($sql, array_values($parametros));
        $this->execQuery($sql, array_values($parametros));
        //return $this->db->insert_id();
        return $this->db->lastInsertId();
    }*/
    
    /**
     * Actualiza datos de la tabla
     * @param array $parametros
     * @param int $primaria
     * @param int $id
     * @return boolean
     */
    /*public function update($parametros, $primaria, $id){
        if(empty($parametros)){
            $parametros = array();
        }
        $sql = "UPDATE " . $this->table. " SET ";
        $set = "";
        $coma = "";
        foreach($parametros as $campo => $valor){
            $set .= $coma. $campo . " = ?";
            $coma = ",";
        }
        $where = " WHERE " . $this->primary_key . " = ?";
        //return $this->db->query($sql . $set . $where, array_merge(array_values($parametros), array($id)));
        return $this->execQuery($sql . $set . $where, array_merge(array_values($parametros), array($id)));
    }*/
    
    /**
     * Retorna un registro de acuerdo al campo $primary
     * @param string $primary
     * @param string $id
     * @return mixed
     */
    public function getById($primary, $id){
        //$query = $this->db->query("SELECT * FROM " . $this->table . " WHERE " . $primary . " = ?", array($id));
        $query = $this->execQuery("SELECT * FROM " . $this->table . " WHERE " . $primary . " = ?", array($id));
        if ($query->num_rows() > 0){
           return $query->row(); 
        } else {
           return NULL;
        }
        
    }

    public function getLastId(){
        return $this->db->lastInsertId();
    }


    public function getNumRows()
    {
        return $this->num_rows;
        /*try {
            $stmt = $this->db->prepareQuery($this->query);
            if (!is_null($this->params)) {
                if (is_array($this->params)) {
                    $stmt->execute($this->params);
                } else {
                    $stmt->execute(array($this->params));
                }
            } else {
                $stmt->execute();
            }
            $this->num_rows = $stmt->rowCount();
            return $this->num_rows;
        } catch (\PDOException $e) {
            errorPan::_showErrorAndDie($e->getMessage());
        } catch (\Exception $e) {
            errorPan::_showErrorAndDie($e->getMessage());
        }*/

    }

    /*public function delete($primary, $id){
        return $this->db->execQuery("DELETE FROM " . $this->table . " WHERE " . $primary . " = ?", array($id));
    }*/
    

    private function auditTable(){
        /* query para crear o verificar si bd y tabla existen */
        $sufix = date('m');
        if(strtolower(DB_TYPE_AUDIT) == 'pgsql'){
            $query = 'CREATE TABLE IF NOT EXISTS '.DB_PREFIX_AUDIT.'auditoria_'.$sufix.' (
                id_audit serial not null primary key,
                fc_ejecucion timestamp without time zone not null,
                id_usuario varchar(10) null default 0,
                gl_tipo varchar(10) null,
                gl_query text not null,
                gl_tiempo float not null,
                ip_usuario varchar(100) null
            );';    
        }elseif(strtolower(DB_TYPE_AUDIT) == 'mysql'){
            $query = 'CREATE TABLE IF NOT EXISTS '.DB_PREFIX_AUDIT.'auditoria_'.$sufix.' (
                id_audit int(11) not null primary key auto_increment,
                fc_ejecucion datetime not null,
                id_usuario varchar(10) null default 0,
                gl_tipo varchar(10) null,
                gl_query text not null,
                gl_tiempo float not null,
                ip_usuario varchar(100) null
            ) engine=INNODB default charset='.DB_CHARSET_AUDIT.' collate='.DB_COLLATE_AUDIT.' auto_increment=1;';    
        }
        
        return $query;

        
    }


    protected function getTipoQuery($query) {

        $tipo = substr(trim($query),0,6);

        return $tipo;

    }

    public function managePDO(){
        return $this->db->getPDO();
    }

}
