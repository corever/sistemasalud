<?php

include_once('mpdf/mpdf.php');

class Pdf{

	public static function getInstanceMpdf($typeInstance){

		switch ($typeInstance) {
			case 'default'  : return new mPDF(['mode' => 'utf-8', 'format' => 'A4', 'orientation' => 'L']);break;
			//case 'instance1': return new mPDF('UTF-8','A4', 12, '', 15, 10, 10, 15, 9, 5, 'L');break;
			default         : return die('Error en el tipo de instancia de mpdf, favor revisar.');
		}	
	}
	
	public static function GenerarPDF($dHtml, $fileName, $typeInstance = 'default', $typeOutput = 'I'){

		$mpdf                      = self::getInstanceMpdf($typeInstance);
		$mpdf->ignore_invalid_utf8 = true;

		/*
		  $mpdf->debug = true;
		  $mpdf->SetHTMLFooter($gl_footer);
		  $mpdf->defaultfooterfontsize = 2;
		  $mpdf->defaultfooterfontstyle = 'BI';
		  $mpdf->showWatermarkImage = $bo_water_image;
		*/

		$mpdf->SetCreator('Farmacia'.date('Y'));
		$mpdf->WriteHTML($dHtml);

		#return $mpdf->Output($filename, 'I');	//inline.		Ver en navegador
		#return $mpdf->Output($filename, 'D');	//Download.		Descargar PDF.
		#return $mpdf->Output($filename, 'F');	//File write.	Guarda en el server. Necesita permisos en carpeta
		#return $mpdf->Output($filename, 'S');	//String.		Retorno PDF como string. Necesitará base64_encode
		return $mpdf->Output($fileName, $typeOutput);
	}
}