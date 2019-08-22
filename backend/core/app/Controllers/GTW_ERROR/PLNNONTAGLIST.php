<?php

switch ($response_code) {
    case "0014":
        $response_message = 'NOMOR REGISTRASI YANG ANDA MASUKKAN SALAH, MOHON TELITI KEMBALI';
        break;
    case "0015":
        $response_message = 'NOMOR REGISTRASI YANG ANDA MASUKKAN SALAH, MOHON TELITI KEMBALI';
        break;
    case "0048":
        $response_message = 'NOMOR REGISTRASI KADALUWARSA, MOHON HUBUNGI PLN';
        break;
    case "0099":
        $response_message = 'TRANSAKSI MASIH DALAM PROSES, TERJADI KESALAHAN SISTEM, TUNGGU INFO SELANJUTNYA';
        break;
    default :
        $response_message = "UNKNOWN ERROR $response_code";
        break;
}