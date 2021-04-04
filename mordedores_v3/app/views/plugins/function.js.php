<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function smarty_function_js($params, &$smarty) {
    $salida = "";
    if(Zend_Registry::isRegistered("js")){
        $add = Zend_Registry::get("js");
        foreach($add as $js){
            $salida .= $js;
        }
    }
    return $salida;
}

