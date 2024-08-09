<?php
require '../vendor/autoload.php'; // Pastikan path ini benar jika menggunakan composer

use Dompdf\Dompdf;
use Dompdf\Options;

include '../config.php';

// Mengambil semua barang keluar
$sql = "SELECT bk.*, b.namabrg FROM barang_keluar bk JOIN barang b ON bk.idbrg = b.idbrg";
$barang_keluar = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Inisialisasi DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Generate HTML untuk laporan
$html = '<h1 style="text-align: center;">Laporan Data Barang Keluar</h1>';
$html .= '<table border="1" width="100%" style="border-collapse: collapse; text-align: center;">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>ID Keluar</th>';
$html .= '<th>Barang</th>';
$html .= '<th>Tanggal</th>';
$html .= '<th>Jumlah</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

foreach ($barang_keluar as $keluar) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($keluar['idkeluar']) . '</td>';
    $html .= '<td>' . htmlspecialchars($keluar['namabrg']) . '</td>';
    $html .= '<td>' . htmlspecialchars($keluar['tgl']) . '</td>';
    $html .= '<td>' . htmlspecialchars($keluar['jumlah']) . '</td>';
    $html .= '</tr>';
}

$html .= '</tbody>';
$html .= '</table>';

// Load HTML ke DOMPDF
$dompdf->loadHtml($html);

// Set ukuran dan orientasi halaman
$dompdf->setPaper('A4', 'portrait');

// Render PDF
$dompdf->render();

// Kirimkan output PDF ke browser
$dompdf->stream("laporan_barang_keluar.pdf", ["Attachment" => false]);
