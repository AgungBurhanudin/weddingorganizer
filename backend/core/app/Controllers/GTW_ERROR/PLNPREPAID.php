<?php

switch ($response_code) {
    case "0014":
        $response_message = 'NOMOR METER YANG ANDA MASUKKAN SALAH, MOHON TELITI KEMBALI';
        break;
    case "0015":
        $response_message = 'IDPEL YANG ANDA MASUKKAN SALAH, MOHON TELITI KEMBALI';
        break;
    case "0077":
        $response_message = "KONSUMEN $idpel DIBLOKIR HUBUNGI PLN";
        break;
    case "0047":
        $response_message = 'TOTAL KWH MELEBIHI BATAS MAKSIMUM';
        break;
    case "0013":
        $response_message = 'NOMINAL PEMBELIAN TIDAK TERDAFTAR';
        break;
    case "0041":
        $response_message = 'PEMBELIAN MINIMAL RP. 20 RIBU';
        break;
    case "0099":
        $response_message = 'TRANSAKSI MASIH DALAM PROSES, TERJADI KESALAHAN SISTEM, TUNGGU INFO SELANJUTNYA';
        break;
    default :
        $response_message = "UNKNOWN ERROR $response_code";
        break;
}