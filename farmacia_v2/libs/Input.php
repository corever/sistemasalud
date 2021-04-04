<?php
/*
******************************************************************************
*!ControlCambio
*--------------
*!cProgramador				!cFecha		     !cDescripcion
*-----------------------------------------------------------------------------
* luis.estay@cosof.cl       26/08/2019       Helper para generar input
*-----------------------------------------------------------------------------
******************************************************************************
*/

class Input {

	private static $type		= array(
									'select'	=> 'lista',
									'text'		=> 'texto',
									'textarea'	=> 'textarea',
									'numb' 		=> 'numero',
									'check' 	=> 'si-no',
									'multi' 	=> 'multiple',
									'date'		=> 'fecha'
								);

	private static $propHtml;

	private static function initProp () {

		self::$propHtml = array(
			'class' 		=> '',
			'name'			=> '',
			'id'			=> '',
			'data-id_campo'	=> '',
			'data-id_tipo'	=> '',
			'data-funcion'	=> '',
			'data-id_padre'	=> '', // multi
			'data-lbl_padre'=> '', // multi
		);
	}

	private static function addHeader ($input) {

		$header 	= '';

		if (!empty($input->json_funciones_campo_clasificacion) and !is_null($input->json_funciones_campo_clasificacion)) {
			$functions	= self::addFunctions($input->json_funciones_campo_clasificacion);	
		} else {
			$functions	= self::addFunctions($input->json_funciones);
		}

		if (!empty($input->gl_extras_campo_clasificacion)) {
			$extras		= self::addText($input->gl_extras_campo_clasificacion);	
		} else {
			$extras		= self::addText($input->gl_extras_campo);
		}
		
		foreach (self::$propHtml as $prop => $value) {
			$header	.= $prop . '="'.$value.'" ';
		}

		$header .= $functions . ' ' . $extras;

		return $header;
	}

	private static function addOptions ($json, $addSelect = TRUE) {

		$valores	= json_decode($json);
		$options	= '';

		if ($addSelect) {
			$options .= '<option value="0">Seleccione</option>';
		}
		if ($valores) {
		    /* ordenar alfabeticamente los valores para options de select */
            $arr_options = array();
            $otro_key = '';
            $otro_val = '';
            foreach ($valores as $key => $itm) {
                if (mb_strtolower($itm->gl_nombre) == 'otro' or mb_strtolower($itm->gl_nombre) == 'otra') {
                    $otro_key = $itm->id;
                    $otro_val = $itm->gl_nombre;
                } else {
                    $arr_options[$itm->id] = $itm->gl_nombre;
                }

            }

            asort($arr_options);
            if (!empty($otro_key)) {
                $arr_options[$otro_key] = $otro_val;
            }

            foreach ($arr_options as $key => $itm) {
                $options .= '<option value="'.$key.'">'.$itm.'</option>';
            }

			/*foreach ($valores as $key => $itm) {
				$options .= '<option value="'.$itm->id.'">'.$itm->gl_nombre.'</option>';
			}*/
		}

		return $options;
	}

	private static function addFunctions ($json) {

		$functions	= json_decode($json);
		$fns		= '';

		if ($functions) {
			foreach ($functions as $key => $fn) {
				$fns .= $fn->tipo .'="'.$fn->funcion. '" ';
				self::$propHtml['data-funcion'] .= str_replace('on', '', $fn->tipo) . ' ';
			}
			self::$propHtml['data-funcion'] = trim(self::$propHtml['data-funcion']);
		}

		return $fns;
	}

	private static function addLabel ($txt, $for = '') {

		$label	= '';

		if ($txt) {
			$label = '<label for="'.$for.'" class="control-label col-lg-2 col-md-2 col-sm-4 col-xs-12">'.$txt.'</label>';
		}

		return $label;
	}

	private static function addText ($txt) {

		$fn	= !empty($txt) ? $txt : '';

		return $fn;
	}

	public static function getHtml ($input, $group = TRUE) {

		self::initProp();

		$label		= self::addLabel($input->gl_nombre, $input->gl_id_unico);
		if (!empty($input->gl_extras_div_campos_clasificacion) and !is_null($input->gl_extras_div_campos_clasificacion)) {
			$extraDiv	= self::addText($input->gl_extras_div_campos_clasificacion);
		} else {
			$extraDiv	= self::addText($input->gl_extras_div);
		}
		

		self::$propHtml['class']			= $input->gl_clase;
		self::$propHtml['name']				= $input->gl_id_unico;
		self::$propHtml['id']				= $input->gl_id_unico;
		self::$propHtml['data-id_campo']	= $input->id_campo;
		// self::$propHtml['data-id_tipo']		= $input->id_tipo;

		$header		= self::addHeader($input);
		$body		= '';
		$boAddOtro	= FALSE;

		switch ($input->gl_tipo) {

			case self::$type['text'] :
				$body	.= '<input type="text" '.$header.' value="">';
				break;
			case self::$type['textarea'] :
				$body	.= '<textarea '.$header.'></textarea>';
				break;
			case self::$type['numb'] :
				$body	.= '<input type="number" min="0" '.$header.' value="">';
				break;
			case self::$type['date'] :
				$body	.= '<input type="date"  '.$header.' value="">';
				break;
			case self::$type['select'] :
				$body	.= '<select '.$header.'>';
				if (!empty($input->json_valores_campo_clasificacion) and !is_null($input->json_valores_campo_clasificacion)) {
					$body	.= self::addOptions($input->json_valores_campo_clasificacion);	
				} else {
					$body	.= self::addOptions($input->json_valores);
				}
				
				$body	.= '</select>';
				/* Config campo Otro */
				// 'class="form-control input_adicional" name="id_nivel_dependencia" id="id_nivel_dependencia" data-id_campo="9" data-id_tipo="" data-funcion="" ';
				$input->gl_tipo			= 'texto';
				$input->gl_nombre		= 'Otro ' . $input->gl_nombre;
				$input->gl_id_unico 	.= '_otro';
				$input->gl_extras_div 	.= ' style="display: none;"';
				$boAddOtro = TRUE;
				break;
			case self::$type['check'] :
				// '<div class="form-check form-check-inline">
				// <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
				// <label class="form-check-label" for="inlineRadio1">1</label>
				// </div>
				// <div class="form-check form-check-inline">
				// <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
				// <label class="form-check-label" for="inlineRadio2">2</label>
				// </div>';
				self::$propHtml['id']	= $input->gl_id_unico . '1';
				// self::$propHtml['name']	= $input->gl_id_unico . $itm->id;
				$header					= self::addHeader($input);
				$body	.= '<label class="control-label radio-inline">';
				$body	.= '	<input type="radio" '.$header.' value="1"> Sí';
				$body	.= '</label>';
				self::$propHtml['id']	= $input->gl_id_unico . '2';
				// self::$propHtml['name']	= $input->gl_id_unico . $itm->id;
				$header					= self::addHeader($input);
				$body	.= '<label class="control-label radio-inline">';
				$body	.= '	<input type="radio" '.$header.' value="0"> No';
				$body	.= '</label>';
				break;
			case self::$type['multi'] :

				// '<div class="form-check form-check-inline">
				//   <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
				//   <label class="form-check-label" for="inlineCheckbox1">1</label>
				// </div>
				// <div class="form-check form-check-inline">
				//   <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
				//   <label class="form-check-label" for="inlineCheckbox2">2</label>
				// </div>';
				$valores	= json_decode($input->json_valores);
				if (!empty($input->json_valores_campo_clasificacion) and !is_null($input->json_valores_campo_clasificacion)) {
					$valores	= json_decode($input->json_valores_campo_clasificacion);	
				} 
				
				//$valores	= json_decode($input->json_valores);
				if ($valores) {

					foreach ($valores as $key => $itm) {

						self::initProp();
						self::$propHtml['id']				= $input->gl_id_unico . $itm->id;
						self::$propHtml['name']				= $input->gl_id_unico . $itm->id;
						self::$propHtml['class']			= $input->gl_clase;
						self::$propHtml['data-id_padre']	= $input->gl_id_unico;
						self::$propHtml['data-lbl_padre']	= $input->gl_nombre;
						$header								= self::addHeader($input);

						$body .= '<div class="form-check form-check-inline">';
						$body .= '	<input type="checkbox" '. $header . ' value="'. $itm->id. '" >';
						$body .= '	<label class="form-check-label" for="'. self::$propHtml['id'] .'">'. $itm->gl_nombre .'</label>';
						$body .= '</div>';
					}
					self::$propHtml['id']	= $input->gl_id_unico;
					self::$propHtml['name']	= $input->gl_id_unico;
				}
				break;
			default:
				break;
		}

		$html	= '<div class="col-lg-6 col-md-8 col-sm-10 col-xs-12">'. $body .'</div>';
		$html	= '<div id="div_'.self::$propHtml['id'].'" '.$extraDiv.'>'. $label . $html .'</div>';
		$html	= ($group) ? '<div class="form-group">' .$html. '</div>' : $html;
		$html	= $boAddOtro ? $html . Input::getHtml($input) : $html;

		return $html;
	}
}

?>
