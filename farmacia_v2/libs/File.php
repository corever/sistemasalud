<?php

/**
 ******************************************************************************
 * Sistema           : ASD
 *
 * Descripción       : Lib para manejo de archivos
 *
 * Plataforma        : PHP
 *
 * Creación          : 05/04/2019
 *
 * @name             File.php
 *
 * @version          1.0.1
 *
 * @author           Luis Estay <luis.estay@cosof.cl>
 *
 ******************************************************************************
 * Control de Cambio
 * -----------------
 * Programador				Fecha		Descripción
 * ----------------------------------------------------------------------------
 *<luis.estay@cosof.cl>     05/04/2019  __construct
 *<luis.estay@cosof.cl>     18/04/2019  fix propiedades / mejora validacion
 *<luis.estay@cosof.cl>     02/05/2019  permisos dir opcionales / mejora logs
 *<luis.estay@cosof.cl>     12/07/2019  nueva funcion openFile
 *<luis.estay@cosof.cl>     08/10/2019  mod getFileExtension: strpos => strrpos
 * ----------------------------------------------------------------------------
 * ****************************************************************************
 */
class File {

    private static $extensions = array(
                                    "office"          => array('.doc', '.docx', '.ppt', '.pptx', '.xls', '.xlsx'),
                                    "imagen"          => array('.jpeg', '.jpg', '.png', '.gif', '.tiff', '.bmp'),
                                    "otros_formatos"  => array('.pdf', '.txt','.csv')
                                );
    private static $debug = FALSE;

    protected function __construct() {


    }

    /**
	* Descripción	: Mostrar mensajes en modo debug
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param 		string
	* @return
	*/
    private static function displayMsg ($msg) {

        if (self::$debug) {
            file_put_contents('php://stderr', PHP_EOL . print_r($msg, true). PHP_EOL, FILE_APPEND);
        }
    }

    /**
	* Descripción	: Setear modo debug
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param 		boolean
	* @return
	*/
    public static function setDebugMode ($val = TRUE) {

        self::$debug = $val;
    }

    /**
	* Descripción	: Setear extensiones válidas de archivo
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param 		array
	* @return
	*/
    public static function setValidExtensions ($ext = array()) {

        self::$extensions = $ext;
    }

    /**
	* Descripción	: Agregar extensión válida
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param 		string
	* @return
	*/
    public static function addValidExtension ($ext = "") {

        if (trim($ext) !== "") {
            self::$extensions["Otros"] = $ext;
        }
    }

    /**
	* Descripción	: Obtener extensiones válidas
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param
	* @return        array
	*/
    public static function getValidExtensions () {

        return self::$extensions;
    }

    /**
	* Descripción	: Obtener extensión de un archivo
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param         string
	* @return        string
	*/
    public static function getFileExtension ($name) {

        $extension   = "";

        if (!empty($name)) {
            $name       = strtolower($name);
            $extension  = substr($name, strrpos($name, "."));
        }

        return $extension;
    }

    /**
	* Descripción	: Validar un archivo: extensión y tamaño.
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param         array
	* @return        string
	*/
     public static function validate ($file = array(),$gl_tipo = "") {

        $msg = "";

        if (!empty($file)) {

            $extension_adjunto   = self::getFileExtension($file['name']);            
            $bo_extension_valida = false;
            $id_error            = $file["error"];

            if($gl_tipo !== ""){

                if(in_array($extension_adjunto,self::$extensions[$gl_tipo])){

                    $bo_extension_valida = true;
                }

            }else{

                foreach(self::$extensions as $arrExtensiones){

                    if(in_array($extension_adjunto,$arrExtensiones)){

                        $bo_extension_valida = true;
                        break;

                    }

                }

            }

            if(!$bo_extension_valida){

                $msg  = "Estimado Usuario<br><br>";
                $msg .= "El archivo que intenta adjuntar no está permitido. Los archivos permitidos son:<br><br>";
                $msg .= "<table>";

                foreach(self::$extensions as $tipo => $arrExtensiones){

                    if($gl_tipo !== "" && $gl_tipo === $tipo){

                        $msg .= "<tr><td width='30%'>- " . ucwords(str_replace("_"," ",$tipo)) .  "</td>";
                        $msg .= "<td width='1%'></td><td> [" . implode(" ",$arrExtensiones) . "]</td></tr>";

                    }else if($gl_tipo === ""){

                        $msg .= "<tr><td width='30%'>- " . ucwords(str_replace("_"," ",$tipo)) .  "</td>";
                        $msg .= "<td width='1%'></td><td> [" . implode(" ",$arrExtensiones) . "]</td></tr>";

                    }

                }

                $msg .= "</table>";

            }

            switch($id_error){

                case '1': 
                case '2':
                    $msg    = "<h4>El archivo que intenta adjuntar excede el peso permitido (20 MB).</h4><br><br>";
                    break;
                case '3':
                    $msg    = "<h4>La subida del archivo fue interrumpida, intente nuevamente o comun&iacute;quese con soporte.</h4><br><br>";
                    break;

            }

        }else{
           $msg    = "<h4>Debe adjuntar un archivo.</h4><br><br>";
        }

        self::displayMsg($msg);

        return $msg;
    }

    /**
    * Descripción   : Valida sí el documento es una imagen por su extension
    * @author       : Alexis Visser <alexis.visser@cosof.cl>
    * @param         String $route
    * @return        boolean
    */

    public static function isImage($route){

        $ext = self::getFileExtension($route);
        
        if(in_array($ext, self::$extensions["imagen"])){

            return true;
        }

        return false;

    }

    /**
	* Descripción	: Formatear nombre de archivo
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param         string
	* @return        string
	*/
    public static function formatName ($input = "") {

        $name = NULL;

        if ($input !== "") {
            $name = $input;
            $name = strtolower(trim($name));
            $name = str_replace(" ","_",$name);
            $name = trim($name, ".");
        }

        return $name;
    }

    /**
	* Descripción	: Revisar si existe directorio. Sino, lo crea por defecto.
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param         string
	* @return        boolean
	*/
    public static function checkDir ($path = "", $make = true, $mode = 0777) {

        $response   = false;
        $msg        = "";

        if ($path !== "") {

            if (is_dir($path)) {

                self::displayMsg("Directorio/Fichero existente: " . $path);
                $response = true;

            }elseif ($make) {

                $dir = mkdir($path, $mode, true);

                if ($dir) {

                    chmod($path, $mode);
                    $msg = "Creando Directorio: " . $path;
                    self::displayMsg($msg);
                    $path .= "index.html";
                    $response = self::writeFile($path);
                }
            }
        }

        return $response;
    }

    /**
	* Descripción	: Revisar si existe archivo.
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param         string
	* @return        boolean
	*/
    public static function checkFile ($path) {

        $response   = TRUE;

        if (!empty($path)) {
            $response = file_exists($path);
        }

        return $response;
    }

    /**
	* Descripción	: Crear archivo en directorio dado.
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param         string
	* @return        boolean
	*/
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
        }

        self::displayMsg($msg);

        return $response;
    }

    /**
	* Descripción	: Leer archivo adjuntado desde vista.
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param         array
	* @return        string
	*/
    public static function readFile ($file) {

        $content = NULL;

        if (!empty($file)) {

            $filename   = $file['tmp_name'];
            $file       = fopen($filename, 'r+b');
            $content    = fread($file, filesize($filename));
            fclose($file);
        }

        return $content;
    }

    /**
	* Descripción	: Abrir archivo desde disco para visualizacion/descarga.
	* @author		: Luis Estay <luis.estay@cosof.cl> 12-07-2019
	* @param         string $path ruta completa en disco del archivo
	* @param         array $header datos para header: tipo, nombre, tamaño.
	* @return        string
	*/
    public static function openFile ($path, $header = array()) {

        $msg    = "Archivo no encontrado";

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


    /**
	* Descripción	: Guardar archivo en disco. Recibe contenido o array tmp
	* @author		: Luis Estay <luis.estay@cosof.cl>
	* @param         array, string | array, string
	* @return        boolean
	*/
    public static function saveFile ($path = "", $file, $name){

        $response = FALSE;
        $content = NULL;

        $dir = self::checkDir($path);

        if ($dir) {

            $full_path = $path.$name;

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
        }

        return $response;
    }

    /**
    * Descripción   : Elimina un archivo sí es que existe
    * @author       : Alexis Visser <alexis.visser@cosof.cl>
    * @param         (string) path, name
    * @return        (boolean)
    */
    public static function deleteFile($path = "", $name = ""){

        $delete  = FALSE;
        $full_path = $path.$name;

        if(self::checkFile($full_path)){

            $delete = unlink($full_path);

        }

        return $delete;

    }

}

?>
