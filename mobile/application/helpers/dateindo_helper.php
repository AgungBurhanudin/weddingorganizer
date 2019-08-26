<?php

function DateToIndo($date) {
    if(($date=="0000-00-00")or($date==NULL)){
        return($date);
    }
    $BulanIndo = array("Januari", "Februari", "Maret",
        "April", "Mei", "Juni",
        "Juli", "Agustus", "September",
        "Oktober", "November", "Desember");

    $tahun = substr($date, 0, 4);
    $bulan = substr($date, 5, 2);
    $tgl = substr($date, 8, 2);
    $jam = substr($date, 11, 2);
    $menit = substr($date, 14, 2);

    if ($jam == "" || $menit == "") {
        $result = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun;
    } else {
        $result = $tgl . " " . $BulanIndo[(int) $bulan - 1] . " " . $tahun . " Jam " . $jam . ":" . $menit;
    }
    return($result);
}
