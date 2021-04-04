<?php

/**
 ******************************************************************************
 * Sistema           : SUMARIOS V4
 *
 * Descripción       : Lib para manejo de archivos
 *
 * Plataforma        : PHP
 *
 * Creación          : 29/01/2020
 *
 * @name             Adjunto.php
 *
 * @version          1.0.1
 *
 * @author           Víctor Retamal <victor.retamal@cosof.cl>
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
class Adjunto {

    private static $extensions	= array(
										"office"			=> array('.doc', '.docx', '.ppt', '.pptx', '.xls', '.xlsx'),
										"imagen"			=> array('.jpeg', '.jpg', '.png', '.gif', '.tiff', '.bmp'),
                                        "otros_formatos"	=> array('.pdf', '.txt','.csv'),
                                        "documento"	=> array('.pdf', '.docx','.png','.jpeg', '.jpg'),
										"otros"  			=> array()
                                    );
    private static $arrTipo     = array(
                                        "1"			=> array( "gl_nombre" => "Beneficio PYME", "gl_tabla" => "medico_adjunto", "id_tipo" => "1"),
                                        "2"	    => array("gl_nombre" => "Firma Imagen", "gl_tabla" => "seremi", "id_tipo" => "2"),
                                        "3"	    => array("gl_nombre" => "Ticket Soporte", "gl_tabla" => "", "id_tipo" => "3"),
                                        "4"	    => array("gl_nombre" => "Certificado", "gl_tabla" => "", "id_tipo" => "4"),
                                    //"4"  			=> array("gl_nombre" => "", "gl_tabla" => "", "id_tipo" => "4")
                                    );
    private static $debug		= TRUE;

    protected function __construct() {

    }

    /**
     * [getAdjuntosFormulario description]
     * @param  string $id_formulario [description]
     * @return [type]                [description]
     * @todo  agregarle diferenciación por modulo
     */
    public static function getAdjuntosFormulario($id_formulario = 'adjuntos'){
        $adjuntos_formulario = array();

        //valido si existe el campo en la sesión del usuario
        if(!empty($_SESSION[\Constantes::SESSION_BASE]['sesion_formulario'])){
            $sesion_formulario =  $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario'];

            //verifico si el formulario tiene adjuntos en sesion
            if(isset($sesion_formulario[$id_formulario])){
                //si tiene adjuntos en sesion, los cargo
                $adjuntos_formulario = $sesion_formulario[$id_formulario]["adjuntos"];
            }else{
                //si no tiene adjuntos en sesion, creo un array vacío
                $sesion_formulario[$id_formulario] = array("adjuntos" => []);
                $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario'] = $sesion_formulario;
            }
        }
        else{
            //si no existe, creo el campo que guarda los datos de formularios en sesion
            $sesion_formulario[$id_formulario] = array("adjuntos" => []);
            $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario'] = $sesion_formulario;
        }

        return $adjuntos_formulario;
    }

    /**
     * [setAdjuntoFormulario description]
     * @param [type] $adjunto       [description]
     * @param string $id_formulario [description]
     * @todo  agregarle diferenciación por modulo
     */
    public static function setAdjuntoFormulario($adjunto, $id_formulario = 'adjuntos'){
        //cargo los adjuntos del formulario, creo el array si no existe
        $adjuntos_formulario = Adjunto::getAdjuntosFormulario($id_formulario);

        /**
         * como array_key_last solo funciona en php 7, se
         * reemplaza con la función count, que al contar los 
         * elementos de un array, el valor devuelto es equivalente
         * al último indice del adjunto que se agregará
         */
        $index = count($adjuntos_formulario);
        //agrego el adjunto al listado de adjuntos del formulario
        $adjuntos_formulario[] = $adjunto;
        //cargo los datos de formularios guardados en sesion
        $sesion_formulario = $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario'];

        //actualizo los datos guardados en sesion
        $sesion_formulario[$id_formulario]["adjuntos"] = $adjuntos_formulario;
        $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario'] = $sesion_formulario;
        return $index; 
    }

    /**
     * [setAdjuntoFormulario description]
     * @param [type] $adjunto       [description]
     * @param string $id_formulario [description]
     * @todo  agregarle diferenciación por modulo
     */
    public static function setArrAdjuntoFormulario($adjuntos = [], $id_formulario = 'adjuntos'){
        //cargo los adjuntos del formulario, creo el array si no existe
        $adjuntos_formulario = Adjunto::getAdjuntosFormulario($id_formulario);
        //reemplazo el listado de adjuntos del formulario
        $adjuntos_formulario = $adjuntos;
        //cargo los datos de formularios guardados en sesion
        $sesion_formulario = $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario'];

        //actualizo los datos guardados en sesion
        $sesion_formulario[$id_formulario]["adjuntos"] = $adjuntos_formulario;
        $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario'] = $sesion_formulario;
        return $index; 
    }


    public static function deleteAdjuntosFormulario($key = 0, $id_formulario = 'adjuntos'){
        //cargo los datos de formularios guardados en sesion
        $sesion_formulario = $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario'];
        //actualizo los datos guardados en sesion
        if(!empty($sesion_formulario[$id_formulario]["adjuntos"]) && 
            isset($sesion_formulario[$id_formulario]["adjuntos"][$key])){
            unset($sesion_formulario[$id_formulario]["adjuntos"][$key]);
            $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario'] = $sesion_formulario;
        }
        return true;
    }

    public static function killAdjuntosFormulario($id_formulario = 'adjuntos'){
        //cargo los datos de formularios guardados en sesion
        $sesion_formulario = $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario'];
        //actualizo los datos guardados en sesion
        $sesion_formulario[$id_formulario]["adjuntos"] = array();
        $_SESSION[\Constantes::SESSION_BASE]['sesion_formulario'] = $sesion_formulario;
    }


    private static function displayMsg ($msg) {
        if (self::$debug) {
            file_put_contents('php://stderr', PHP_EOL . print_r($msg, true). PHP_EOL, FILE_APPEND);
        }
    }


    public static function setDebugMode ($val = TRUE) {

        self::$debug = $val;

    }


    public static function setValidExtensions ($ext = array()) {

        self::$extensions = $ext;

    }


    public static function addValidExtension ($ext = "") {

        if (trim($ext) !== "") {
            self::$extensions["otros"] = $ext;
        }

    }


    public static function getValidExtensions () {

        return self::$extensions;

    }


    public static function getFileExtension ($name) {
        $extension   = "";

        if (!empty($name)) {
            $name       = strtolower($name);
            $extension  = substr($name, strpos($name, "."));
        }

        return $extension;
    }


    public static function validate ($file = array(),$extAdjunto = null) {
        $msg	= "";

        if (!empty($file)) {
            $extension_adjunto  = self::getFileExtension($file['name']);
            $bo_valido          = false;
            $extensiones        = (empty($extAdjunto))?self::$extensions:self::$extensions[$extAdjunto];
            file_put_contents('php://stderr', PHP_EOL . "Array Extensiones : ". print_r($extensiones, TRUE). PHP_EOL, FILE_APPEND);
            file_put_contents('php://stderr', PHP_EOL . "Extension Adjunto : ". print_r($extension_adjunto, TRUE). PHP_EOL, FILE_APPEND);
            if(empty($extAdjunto)){
                foreach($extensiones as $arrExtensiones){

                    if(in_array($extension_adjunto,$arrExtensiones)){
                        $bo_valido = true;
                        break;
                    }
                }
            }else{
                if(in_array($extension_adjunto,$extensiones)){
                    $bo_valido = true;
                }
            }

            if(!$bo_valido){
                $msg  = "Estimado Usuario<br><br>";
                $msg .= "El archivo que intenta adjuntar no está permitido. Los archivos permitidos son:<br><br>";
                $msg .= "<table>";

                if(empty($extAdjunto)){
                    foreach($extensiones as $tipo => $arrExtensiones){
                        $msg .= "<tr><td width='30%'>- " . ucwords(str_replace("_"," ",$tipo)) .  "</td><td width='1%'></td><td> [" . implode(" ",$arrExtensiones) . "]</td></tr>";
                    }
                }else{
                    $msg .= "<tr><td width='30%'>- " . ucwords(str_replace("_"," ",$extAdjunto)) .  "</td><td width='1%'></td><td> [" . implode(" ",$extensiones) . "]</td></tr>";
                }
                

                $msg .= "</table>";


            } elseif (!filesize($file['tmp_name'])) {
                $msg    = "<h4>El archivo que intenta subir está vacío.</h4><br><br>";
            }
        }else{
           $msg    = "<h4>Debe adjuntar un archivo.</h4><br><br>";
        }

        self::displayMsg($msg);

        return $msg;
    }


    public static function formatName ($input = "") {
        $name = NULL;

        if ($input !== "") {

            $name = $input;
            $name = trim($name, ".");
			
			$arr_buscar 	= array(' ','  ','  ','á','é','í','ó','ú','ñ','Á','É','Í','Ó','Ú','Ñ','°',"'",'"','=','!','.ini','*',',');
			$arr_reemplazar = array('_','_' ,'_' ,'a','e','i','o','u','n','A','E','I','O','U','N','-','_','_', '', '', '_'  ,'' ,'');
			$name			= str_replace($arr_buscar,$arr_reemplazar,$name);
            $name			= strtolower(trim($name));
	
        }

        return $name;
    }


    public static function checkDir ($path = "", $make = true, $mode = 0777) {
        $response   = false;
        $msg        = "";
        
        if ($path !== "") {
            if (is_dir($path)) {

                self::displayMsg("Directorio/Fichero existente: " . $path);
                $response = true;

            } elseif ($make) {
                $dir	= mkdir($path, $mode, true);
                if ($dir) {
                    chmod($path, $mode);
                    $msg		= "Creando Directorio: " . $path;
                    $path		.= "index.html";
                    $response	= self::writeFile($path);
                    self::displayMsg($msg);
                }else{
                    self::displayMsg("No se logró crear el directorio: ".$path);
                }
            }
        }
        else{
            self::displayMsg("No se reciben datos del path");
        }

        return $response;
    }


    public static function checkFile ($path) {
        $response	= false;

        if (!empty($path)) {
            $response = file_exists($path);
        }

        return $response;
    }


    public static function writeFile ($gl_path, $txt = "") {

        $response   = false;
        $data       = (!isset($txt)) ? "<html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>" : $txt;
        $msg        = "";

        $out = fopen($gl_path, "w");

        if ($out) {

            $in = fwrite($out, $data);
            $msg = "Abriendo Archivo. ";

            if (is_numeric($in)) {
                $msg .= "Creando Archivo " . $gl_path;
                $response = chmod($gl_path, 0664);
            }

            fclose($out);
        }else{
            $msg = "No se pudo abrir el path: " . $gl_path;
        }

        self::displayMsg($msg);

        return $response;
    }


    public static function readFile ($file) {
        $content	= NULL;

        if (!empty($file)) {

            $filename   = $file['tmp_name'];
            $file       = fopen($filename, 'r+b');
            $content	= fread($file, filesize($filename));
            fclose($file);
        }

        return $content;
    }


    public static function openFile ($path) {
        $msg	= "Archivo no encontrado";

        if (self::checkFile($path)) {

            $contentType    = mime_content_type($path);
            $fileName       = basename($path);
            $fileSize       = filesize($path);

            header("Content-Type: " . $contentType);
            header("Content-Disposition: inline; filename=".$fileName); //)$header['name']
            header("Content-Transfer-Encoding: binary");
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . $fileSize);

            ob_end_clean();
            readfile($path);
            self::displayMsg("Archivo " . $fileName . " abierto.");

        } else {

            echo $msg;
            self::displayMsg($msg . " en ruta " . $path);
        }
    }


    public static function saveFile ($path = "", $file, $name){

        $response	= FALSE;
        $content	= NULL;
        $dir		= self::checkDir($path);

        if ($dir) {

            $full_path = $path.$name;
            self::displayMsg("full_path: ".$full_path);

            if (is_array($file)) {
                // adj
                $content = self::readFile($file);
            }elseif (is_string($file)) {
                // pdf
                $content = $file;
            }

            if (!empty($content)) {
                $response = self::writeFile($full_path, $content);
            }
            else{
                self::displayMsg("No se recibe datos de adjunto");
            }
        }

        return $response;
    }

    public static function validarArchivoCompleto($file) {
        $response	= "";

        for($i = 0; $i < 3; $i++){
            usleep(125000);
            self::checkFile($file['tmp_name']);
            self::validate($file);
            file_put_contents('php://stderr', PHP_EOL . print_r(date('Y-m-d H:i:s') . " - " .  $i, TRUE). PHP_EOL, FILE_APPEND);
        }


        return $response;

    }

    public static function obtTipoAdjunto($idTipo) {
        
        if($idTipo > 0) {
            $arrTipo = self::$arrTipo[$idTipo];
        }else{
            $arrTipo = self::$arrTipo;
        }
        
        return $arrTipo;

    }

    public static function getNombreTipo($idTipo) {

        $nombre = '';
        
        if($idTipo > 0) {
            $nombre = self::$arrTipo[$idTipo]['gl_nombre'];
        }
        
        return $nombre;

    }

}