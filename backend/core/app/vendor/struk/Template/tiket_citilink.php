<?php

$citilink = $obj->paylog;

$lembar = (int)$citilink->content->jmlFlight;
$idpel = (string)$citilink->content->kodeBayar;

$inq = $obj->inqlog;

$tagihan = (int)$citilink->content->totalAmount;

$nama = trim($inq->content->passangerName);

$no = 1;

imagestring($im, 3, (imagesx($im) - 7.5 * strlen("TIKET CITILINK")) / 1.9, 110, "TIKET CITILINK", $black);
imagestring($im, 2, 18, 130, "ID BOOKING : ", $black); imagestring($im, 2, strlen("ID BOOKING : ")*6+13, 130, $idpel, $black);
imagestring($im, 2, 18, 140, "NAMA       : ", $black); imagestring($im, 2, strlen("ID BOOKING : ")*6+13, 140, $nama, $black);
imagestring($im, 2, 18, 150, "TOTAL      : ", $black); imagestring($im, 2, strlen("ID BOOKING : ")*6+13, 150, rupiah($tagihan), $black);
imagestring($im, 2, 18, 160, "JML FLIGHT : ", $black); imagestring($im, 2, strlen("ID BOOKING : ")*6+13, 160, $lembar, $black);
imagestring($im, 1, 18, 180, "JML KURSI", $black); 
imagestring($im, 1, 13+strlen("JML KURSI")*6+5, 180, "CARIER/KLS", $black); 
imagestring($im, 1, 7+(strlen("JML KURSI")+strlen("CARIER/KELAS"))*6+5, 180, "TGL/JAM", $black); 
imagestring($im, 1, 17+(strlen("JML KURSI")+strlen("CARIER/KELAS")+strlen("TGL/JAM"))*6+5, 180, "FRM/TO", $black);

$yPos = 190;
for ($i = 0; $i < $lembar; $i++) {
	$jumlah = (string)$citilink->content->flights->flightInfo[$i]->jmlPenumpang;
	$carier = (string)$citilink->content->flights->flightInfo[$i]->carier;
	$kelas = (string)$citilink->content->flights->flightInfo[$i]->kelas;
	$from = (string)$citilink->content->flights->flightInfo[$i]->from;
	$to = (string)$citilink->content->flights->flightInfo[$i]->to;

	$waktu = (string)$citilink->content->flights->flightInfo[$i]->extHariBulan;
	$waktu = substr($waktu, 0, 2) . "-" . substr($waktu, 2, 2);
	$jams = (string)$citilink->content->flights->flightInfo[$i]->extJam;
	$jams = substr($jams, 0, 2) . ":" . substr($jams, 2, 2);
	
	imagestring($im, 1, 25, $yPos, $jumlah, $black); 
	imagestring($im, 1, 13+strlen("JML KURSI")*6+5, $yPos, $carier.'/'.$kelas , $black); 
	imagestring($im, 1, (strlen("JML KURSI")+strlen("CARIER/KELAS"))*6, $yPos, $waktu.'/'.$jams , $black); 
	imagestring($im, 1, 17+(strlen("JML KURSI")+strlen("CARIER/KELAS")+strlen("TGL/JAM"))*6+5, $yPos, $from.'-'.$to , $black);

	$yPos = $yPos + 10;
}

