<?php
require '../vendor/autoload.php'; // Pastikan path ini benar jika menggunakan composer

use Dompdf\Dompdf;
use Dompdf\Options;

include '../config.php';

// Mengambil semua barang masuk
$sql = "SELECT bm.*, b.namabrg, s.nama_supp FROM barang_masuk bm JOIN barang b ON bm.idbrg = b.idbrg JOIN supplier s ON bm.idsupplier = s.idsupplier";
$barang_masuk = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

// Inisialisasi DOMPDF
$options = new Options();
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Generate HTML untuk laporan
$html = '<h1 style="text-align: center;">Laporan Data Barang Masuk</h1>';
$html .= '<table border="1" width="100%" style="border-collapse: collapse; text-align: center;">';
$html .= '<thead>';
$html .= '<tr>';
$html .= '<th>ID Masuk</th>';
$html .= '<th>Barang</th>';
$html .= '<th>Supplier</th>';
$html .= '<th>Jabatan</th>';
$html .= '<th>Tanggal</th>';
$html .= '<th>Jumlah</th>';
$html .= '</tr>';
$html .= '</thead>';
$html .= '<tbody>';

foreach ($barang_masuk as $masuk) {
    $html .= '<tr>';
    $html .= '<td>' . htmlspecialchars($masuk['idmasuk']) . '</td>';
    $html .= '<td>' . htmlspecialchars($masuk['namabrg']) . '</td>';
    $html .= '<td>' . htmlspecialchars($masuk['nama_supp']) . '</td>';
    $html .= '<td>' . htmlspecialchars($masuk['jabatan']) . '</td>';
    $html .= '<td>' . htmlspecialchars($masuk['tgl']) . '</td>';
    $html .= '<td>' . htmlspecialchars($masuk['jumlah']) . '</td>';
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
$dompdf->stream("laporan_barang_masuk.pdf", ["Attachment" => false]);
