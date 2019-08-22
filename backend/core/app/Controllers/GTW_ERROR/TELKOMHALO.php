<?php

switch ($response_code) {
    case "0001":
        $response_message = 'TAGIHAN SUDAH TERBAYAR';
        break;
    case "0014":
        $response_message = 'NOMOR HANDPHONE YANG ANDA MASUKKAN SALAH, MOHON TELITI KEMBALI';
        break;
    case "0015":
        $response_message = 'NOMOR HANDPHONE YANG ANDA MASUKKAN SALAH, MOHON TELITI KEMBALI';
        break;
    case "0016":
        $response_message = "KONSUMEN $idpel DIBLOKIR HUBUNGI PLN";
        break;
    case "0077":
        $response_message = "KONSUMEN $idpel DIBLOKIR HUBUNGI PLN";
        break;
    case "0088":
        $response_message = 'TAGIHAN SUDAH TERBAYAR';
        break;
    case "0089":
        $response_message = 'TAGIHAN BELUM TERSEDIA';
        break;
    case "0099":
        $response_message = 'TRANSAKSI MASIH DALAM PROSES, TERJADI KESALAHAN SISTEM, TUNGGU INFO SELANJUTNYA';
        break;
    default :
        $response_message = "UNKNOWN ERROR $response_code";
        break;
}