<?php
$dbSekolah     = new Models\DbSekolah();
$id_pembayaran = $_GET['id'];
$jenis         = isset($_GET['jenis']) ? $_GET['jenis'] : "";
$query         = "SELECT a.*,b.nama,b.alamat,b.nama_wali,b.nohp_wali
					FROM   tbl_tagihan a
					LEFT JOIN tbl_siswa b ON a.id_pel = b.id
					WHERE  a.pembayaran @> ANY (ARRAY ['[{\"id_pembayaran\":\"$id_pembayaran\"}]'::jsonb]);";

$data_tagihan    = $dbSekolah->singleRow($query);
$tanggal_tagihan = $data_tagihan->tanggal;
$jatuh_tempo     = $data_tagihan->jatuh_tempo;
$nama_wali       = $data_tagihan->nama_wali;
$nohp_wali       = $data_tagihan->nohp_wali;
$alamat			 = $data_tagihan->alamat;
$nama_tagihan    = $data_tagihan->nama_tagihan;
$sisa_tagihan    = $data_tagihan->sisa_tagihan;
$pembayaran      = $data_tagihan->pembayaran;
$keterangan      = $data_tagihan->keterangan;

$pembayaran       = json_decode($pembayaran, true);
// print_r($pembayaran);
$riwayat          = array();
$total_bayar      = "";
$tanggal_bayar    = "";
$keterangan_bayar = "";
foreach ($pembayaran as $key => $value) {
    if ($value['id_pembayaran'] == $id_pembayaran) {
        $total_bayar      = $value['total_bayar'];
        $tanggal_bayar    = $value['tanggal_bayar'];
        $keterangan_bayar = $value['keterangan'];
    }
}

foreach ($pembayaran as $key => $value) {
    if ($value['tanggal_bayar'] <= $tanggal_bayar) {
        $riwayat[]      = $value;
    }
}
// $html = "";
// $html .= '

// <table width="100%" style="margin:0 auto;">
// <tr>
// <td>
// <br><br>
// <!-- title row -->
// <table width="100%">
// <tr>
// <td align="right">

// </td>
// </tr>
// <tr>
// <td>

// </td>
// </tr>
// </table>
// <br>
// <table width="100%" style="border-left: 2px solid blue;background-color:#f2f2f2;">
// <tr>
// <td style="text-indent: 20px">
// <b>TAGIHAN : # '. $id_pembayaran .'</b>
// </td>
// </tr>
// <tr style="font-size: 12px">
// <td style="text-indent: 20px">
// Tanggal Tagihan : '. $tanggal_tagihan .'
// </td>
// </tr>
// <tr style="font-size: 12px">
// <td style="text-indent: 20px">
// Jatuh Tempo : '. $jatuh_tempo .'
// </td>
// </tr>
// </table>
// <br><br>
// <table width="100%" >
// <tr>
// <td style="text-indent: 20px">
// <b>KEPADA</b>
// </td>
// </tr>
// <tr style="font-size: 12px">
// <td style="text-indent: 20px">
// '. $nama_wali .'
// </td>
// </tr>
// <tr style="font-size: 12px">
// <td style="text-indent: 20px">
// '. $alamat .' , '. $nohp_wali .'
// </td>
// </tr>
// </table>
// <br><br>
// <table class="table" width="100%">
// 	<thead>
// 		<tr>
// 			<th style="width: 5%">No</th>
// 			<th style="width: 85%">Nama Tagihan</th>
// 			<th>Subtotal</th>
// 		</tr>
// 	</thead>
// 	<tbody>

// 		<tr>
// 			<td>1</td>
// 			<td>'.$nama_tagihan.'
// 			</td>
// 			<td style="text-align:right">'.number_format($total_bayar,2).'</td>
// 		</tr>
// 		<tr>
// 			<td></td>
// 			<td> Sisa Tagihan</td>
// 			<td style="text-align:right">'.number_format($sisa_tagihan,2).'</td>
// 		</tr></tbody>
// </table>
// <br>
// <b>RIWAYAT PEMBAYARAN</b>
// <br><br>
// <table class="table" width="100%">
// <thead>
// <tr>
// <th style="width: 45%">Tanggal Bayar</th>
// <th style="width: 45%">Keterangan</th>
// <th>Subtotal</th>
// </tr>
// </thead>
// <tbody>';
// $no = 1;
// foreach ($riwayat as $key => $value) {
// 	$html .='
// 	<tr>
// 		<td>' . $value['tanggal_bayar'] . '</td>
// 		<td>' . $value['keterangan'] . '</td>
// 		<td style="text-align:right">' . number_format($value['total_bayar'],2) . '</td>
// 	</tr>
// 	';
// }
	
// $html.='
// </tbody>
// </table>
// <table width="100%">
// <tr>
// <td valign="top" width="70%">
// <br><br>
// <p class="lead">Note:</p>
// <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
// '.$keterangan.'
// </p>
// </td>
// </tr>
// </table>
// </td>
// </tr>
// <tr>
// <td>

// </td>
// </tr>
// </table>';
// $pembayaran[0]['html'] = $html;
$content = json_encode($pembayaran);