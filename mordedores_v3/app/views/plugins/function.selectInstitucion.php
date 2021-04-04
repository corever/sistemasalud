<?php

require_once(APP_PATH . 'models/DAODireccionInstitucion.php');

function smarty_function_selectInstitucion($params, &$smarty) {
    $DAOInstitucion = New DAODireccionInstitucion();
    $lista          = $DAOInstitucion->listar("ins_nombre");
    
    $rel = "";
    if(!empty($params["rel"])){
        $rel = "rel=\"" . $params["rel"] . "\"";
    }

    $data_rel = "";
    if(!empty($params["data_rel"])){
        $data_rel = "data-rel=\"" . $params["data_rel"] . "\"";
    }
    
    $html = "<select style=\"width:100%\" name=\"" . $params["nombre"] . "\" id=\"" . $params["nombre"] . "\" " . $data_rel . " " . $rel . " class=\"" . $params["class"] . "\">";
    $html .= "<option value=\"\">Seleccione una organización</option>";
    foreach($lista as $key => $itm){
        $selected = "";
        if($params["default"] == $itm->ins_id){
            $selected = "selected";
        }
        $html .= "<option value=\"".$itm->ins_id."\" " . $selected . ">"
                . $itm->ins_nombre
               . "</option>";
    }
    $html .= "</select>";
    
    return $html;
}

