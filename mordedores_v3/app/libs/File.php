<?php

/*
******************************************************************************
*!ControlCambio
*--------------
*!cProgramador				!cFecha		     !cDescripcion
*-----------------------------------------------------------------------------
* luis.estay@cosof.cl       22/03/2019      Helper Archivos
*-----------------------------------------------------------------------------
******************************************************************************
*/

class File {

    private static $extensions = array('.jpeg', '.jpg', '.png', '.gif', '.tiff', '.bmp', '.pdf', '.txt','.csv', '.doc', '.docx', '.ppt', '.pptx', '.xls', '.xlsx');
    private static $debug = FALSE;

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
            self::$extensions[] = $ext;
        }
    }

    public static function getValidExtensions () {

        return self::$extensions;
    }

    public static function getFileExtension ($name) {

        $extension   = "";

        if (!empty($name)) {

            $extension  = explode(".",$name);
            $extension  = substr($name, strpos($name, "."));
        }

        return $extension;
    }

    public static function validate ($file = array()) {

        $msg = "";

        if (!empty($file)) {

            $extension_adjunto  = explode(".",$file['name']);
            $extension_adjunto  = substr($file['name'],strpos($file['name'],"."));

            if (!in_array($extension_adjunto, self::$extensions)) {
                $msg    = "El Tipo de archivo que intenta subir no está permitido.<br><br>";
                $msg    .= "Favor elija un archivo con las siguientes extensiones: <br>";
                $msg    .= implode(" ",self::$extensions)."<br>";

            }elseif (!filesize($file['tmp_name'])) {
                $msg    = "El archivo que intenta subir está vacío.<br><br>";
            }
        }

        self::displayMsg($msg);

        return $msg;
    }

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

    public static function checkDir ($path = "", $make = true) {

        $response = false;
        $msg = "";

        if ($path !== "") {

            if (is_dir($path)) {

                self::displayMsg("Directorio/Fichero existente: " . $path);
                $response = true;

            }elseif ($make) {

                $dir = mkdir($path, 0775, true);

                if ($dir) {

                    chmod($path, 0775);
                    $msg = "Creando Directorio: " . $path;
                    self::displayMsg($msg);
                    $path .= "index.html";
                    $response = self::writeFile($path);
                }
            }
        }

        return $response;
    }

    public static function checkFile ($path) {

        $response   = TRUE;

        if (!empty($path)) {
            $response = file_exists($path);
        }
        
        return $response;
    }

    public static function writeFile ($gl_path, $txt = "") {

        $response = false;
        $data = (!isset($txt)) ? "<html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>" : $txt;
        $msg = "";

        $out = fopen($gl_path, "w");

        if ($out) {

            $in = fwrite($out, $data);
            $msg = "Abriendo Archivo... \n";

            if (is_numeric($in)) {

                $msg .= "Creando Archivo: " . $gl_path;
                $response = chmod($gl_path, 0664);
            }

            fclose($out);
        }

        self::displayMsg($msg);

        return $response;
    }

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

}

?>
