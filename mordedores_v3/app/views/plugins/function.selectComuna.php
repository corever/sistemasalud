<?php

require_once(APP_PATH . 'models/DAODireccionComuna.php');

function smarty_function_selectComuna($params, &$smarty) {
    $DAOComuna  = New DAODireccionComuna();
    $lista      = $DAOComuna->listar("com_nombre");
    
    $rel = "";
    if(!empty($params["rel"])){
        $rel = "rel=\"" . $params["rel"] . "\"";
    }
    
    $data_rel = "";
    if(!empty($params["data_rel"])){
        $data_rel = "data-rel=\"" . $params["data_rel"] . "\"";
    }
    
    $html = "<select style=\"width:100%\" name=\"" . $params["nombre"] . "\" id=\"" . $params["nombre"] . "\" " . $data_rel . " " . $rel . " class=\"" . $params["class"] . "\">";
    $html .= "<option value=\"\">Seleccione una comuna</option>";
    foreach($lista as $key => $itm){
        $selected = "";
        if($params["default"] == $itm->com_id){
            $selected = "selected";
        }
        $html .= "<option value=\"".$itm->com_id."\" " . $selected . ">"
                . $itm->com_nombre
               . "</option>";
    }
    $html .= "</select>";
    
    return $html;
}

