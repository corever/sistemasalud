<?php

class Error{

    const DATABASE_ERROR	= '1';
    const SYSTEM_ERROR		= '2';

    public static function errorLog($message,$type){        
        $root		= ROOT;
        $dirLogs	= $root.'tmp'.DS.'logs';

        if(!is_dir($dirLogs)){
          mkdir($dirLogs,0775,true);
        }
        
        if($type == self::DATABASE_ERROR){
                self::errorLogDatabase($message);
        }elseif($type == self::SYSTEM_ERROR){
                self::errorLogSystem($message);
        }
    }

    private static function errorLogDatabase($msg){
        $msgError	= date("d-m-Y H:i:s")." - Error SQL : ".$msg."\n";
        error_log($msgError,3,ERROR_LOG_FILE.'_'.date("Y-m-d").'.log');
		
		chmod(ERROR_LOG_FILE.'_'.date("Y-m-d").'.log', 0664);
    }

    private static function errorLogSystem($msg){
        $msgError	= date("d-m-Y H:i:s")." - Error System : ".$msg."\n";
        error_log($msgError,3,ERROR_LOG_FILE."_".date("Y-m-d").'.log');

		chmod(ERROR_LOG_FILE.'_'.date("Y-m-d").'.log', 0664);
    }
}