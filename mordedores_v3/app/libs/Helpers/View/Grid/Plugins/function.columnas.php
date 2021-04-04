<?php

/**
 * 
 * @param array $params
 * @param Smarty $smarty
 */
function smarty_function_columnas($params, &$smarty) {
    $html = "";
    fb($params);
    
    $columns = $params["columns"];
    $cantidad = count($columns);
    for($i=0;$i<$cantidad;$i++){ 
        $align = "center";
        $nowrap = true;
        $sortable = "false";

        if(isset($columns[$i]['sortable']) AND $columns[$i]['sortable']){
            $sortable = "true";
        }

        if(isset($columns[$i]['column_align'])){
            $align = ($columns[$i]['column_align']) ? $columns[$i]['column_align'] : "center";
        }

        if(isset($columns[$i]['column_nowrap'])){
            $nowrap  = ($columns[$i]['column_nowrap'] === false) ? "false" : "true";
        }

        $smarty->assign("column_name", $columns[$i]['column_name']);
        $smarty->assign("sortable", $sortable);
        $smarty->assign("align", $align);
        $smarty->assign("nowrap", $nowrap);
        $smarty->assign("width",$columns[$i]['width']);

        $html .= $smarty->fetch("grid-column.tpl");
    }
    
    return $html;
}

