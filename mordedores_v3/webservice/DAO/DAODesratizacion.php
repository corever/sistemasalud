<?php

class DAODesratizacion{
	protected $_tabla           = "mor_respaldo_desratizacion";
    protected $_primaria		= "id_respaldo";
    protected $_conn            = null;
    private $host = "http://asdigital.minsal.cl/asdigital/jsonp/updateDesratizacionesTablet.php";

    function __construct($conn = null) {
        if($conn !== null){
            $this->_conn =  $conn;
        }else{
            $this->_conn =  new MySQL();
        }
    }

	function getDesratizaciones($rut){	
		$file = file_get_contents("http://asdigital.minsal.cl/asdigital/jsonp/cargaDesratizacionesTablet_.php?rut=$rut",true);
        $file = html_entity_decode($file);
        return json_decode($file,true);
	}

	public function enviarDocs($content){
		error_log('enviarDocs');
		error_log('URL '.$this->host);

        $curl = curl_init();

        $data = array(
                CURLOPT_SSL_VERIFYPEER	=> false,
                CURLOPT_URL				=> $this->host,
                CURLOPT_RETURNTRANSFER	=> true,
                CURLOPT_ENCODING		=> "",
                CURLOPT_MAXREDIRS		=> 10,
                CURLOPT_TIMEOUT			=> 30,
                CURLOPT_HTTP_VERSION	=> CURL_HTTP_VERSION_1_1,
                CURLOPT_POST			=> 1,
                CURLOPT_CUSTOMREQUEST	=> "POST",
                CURLOPT_POSTFIELDS		=> $content,
                CURLOPT_COOKIE			=> "route=ed775c0d235fd09b4cd4fece1472ad25",
                CURLOPT_HTTPHEADER		=> array("content-type: application/json")
            );
        
        curl_setopt_array($curl, $data);

        $response	= curl_exec($curl);
        $err		= curl_error($curl);

        curl_close($curl);

        $arrRespuesta = json_decode($response);

        if ($err) {
			error_log('curl error');
            file_put_contents('php://stderr', PHP_EOL . print_r("Error solicitanto token - Paso 1", TRUE). PHP_EOL, FILE_APPEND);
            $error = Array("response"=>"ERR","msg"=>"Error solicitanto token - Paso 1");
            return json_encode($error);
        } else {
			error_log('curl OK');
            if(isset($arrRespuesta->error)){
                file_put_contents('php://stderr', PHP_EOL . print_r("Error: ".$arrRespuesta->error, TRUE). PHP_EOL, FILE_APPEND);
            }  
            return json_decode($response);
        }

    } 

    public function insert($datos_json,$id_usuario){

        $sql = "INSERT INTO ".$this->_tabla." (
                        json_desratizacion,
                        id_usuario_crea
                    )
                    VALUES (
                        '".  addslashes(json_encode($datos_json)) ."',
                         ".  $id_usuario    ."
                    )";
        
        $data = $this->_conn->consulta($sql);
        $desratizacionId = $this->_conn->getInsertId($data);
        return $desratizacionId;
    }

}

?>