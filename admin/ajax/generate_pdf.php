<?php
require 'lib/db.php';
require 'vendor/autoload.php';
use Dompdf\Dompdf;

ob_start();

// ... your existing code ...

// Generate and save the PDF
$html = ob_get_clean();
$html = preg_replace('/<button.*?>(.*?)<\/button>/i', '', $html);
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('invoice ' . $_GET['booking_id'] . '.pdf', array("Attachment" => false));

return $dompdf;
?>