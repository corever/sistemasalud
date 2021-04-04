<?php  if(!defined('BASE_PATH')) exit('No se permite acceder a este script');

/**
*****************************************************************************
* Sistema		: ANIMALES MORDEDORES
* Descripcion	: class para crear archivos PDF
* Plataforma	: !PHP
* Creacion		: 06/03/2017
* @name			Mpdf.php
* @version		1.0
* @author		Victor Retamal <victor.retamal@cosof.cl>
*=============================================================================
*!ControlCambio
*--------------
*!cProgramador				!cFecha		!cDescripcion 
*-----------------------------------------------------------------------------
*
*-----------------------------------------------------------------------------
*****************************************************************************
*/
	

	/**
	* Crear PDF a partir de un HTML
	*
	* @author Victor Retamal <victor.retamal@cosof.cl>
	*
	* @param  string 	$html			HTML para ser convertido a PDF
	* @param  string 	$filename		Nombre del Archivo
	* @param  string 	$gl_footer		Pie de pagina del PDF
	* @param  string 	$tipo_return	Define que devolverá la función. 
	*									'I' Ver en navegador.
	*									'D' Descargar PDF.
	*									'F' Guarda en el Server. Necesita Permisos en carpeta.
	*									'S' Retorno PDF como string. Puede que Necesite usar base64_encode.
	*
	* @return pdf	Devuelve un archivo PDF, según $tipo_return
	*/
	include('mpdf/mpdf.php');
	function crear_mpdf($html, $filename, $footer, $tipo_return, $gl_folio = '', $fc_mordedura = '') {
		#$mpdf = new mPDF('UTF-8','Legal', 10, '', 20, 15, 10, 25, 9, 10, 'L');
		$mpdf = new mPDF('UTF-8','', 12, '', 15, 10, 10, 15, 9, 5, 'L');
		$mpdf->ignore_invalid_utf8 = true;
		
		if($footer){
			
			$gl_footer = '	<div style="width:100%;margin-top:5px;padding-top:3px;border-top:0.5px solid #959595;font-size:10px;font-weight:bold"></div>
					<div style="font-size:9px;font-weight:normal">
						<div style="font-size: 13px;color: #959595;text-align:center;width:100%;">Ministerio de Salud / FOLIO: '.$gl_folio.' / Página {PAGENO} de {nb}</div>
					</div>';
					
			$footer	= $gl_footer;
		}else{
			$footer = 'MINISTERIO DE SALUD <div style="text-align:right;width:100%;font-weight:bold">{PAGENO} / {nb}</div>';
			
		}
        
        $mpdf->SetWatermarkImage("static/images/watermark-chile.jpg",0.1);
        $mpdf->showWatermarkImage = true;

        //$mpdf->debug = true;
		$mpdf->SetHTMLFooter($footer);
		$mpdf->defaultfooterfontsize = 2;
		$mpdf->defaultfooterfontstyle = 'BI';
		$mpdf->SetCreator('MIDAS');		
		$mpdf->WriteHTML($html);

		#return $mpdf->Output($filename, 'I');	//inline.		Ver en navegador
		#return $mpdf->Output($filename, 'D');	//Download.		Descargar PDF.
		#return $mpdf->Output($filename, 'F');	//File write.	Guarda en el server. Necesita permisos en carpeta
		#return $mpdf->Output($filename, 'S');	//String.		Retorno PDF como string. Necesitará base64_encode
		return $mpdf->Output($filename, $tipo_return);
	}

?>