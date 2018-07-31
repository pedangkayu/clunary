<?php 
ob_start();
echo $content_table;
$content = ob_get_clean();

// convert to PDF
require_once(APPPATH.'libraries/html2pdf/html2pdf.class.php');
try
{
	$name="dokumen.pdf";
	if (isset($pdf_name)) {
		$name =$pdf_name;
	}

    $html2pdf = new HTML2PDF($oriented, $size, 'fr', true, 'UTF-8', 3);
    // $html2pdf = new HTML2PDF($oriented, array(4 * 25.4, 5 * 25.4), 'fr', true, 'UTF-8', 3);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output($name);
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}

 ?>