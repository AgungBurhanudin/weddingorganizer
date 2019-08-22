<?php

namespace Libraries;

use Resources;

class Konfigurasi {

    public static function namaAplikasi() {
        return 'PSP';
    }

    public static function urlWebLogin() {
        return 'http://pro.solusinegeri.com';
    }
    
    public static function namaBank() {
        return 'BNI SYARIAH';
    }

    public static function aturanLogin($jeniswebsite, $jenis, $ip) {
        if ($jeniswebsite == "ADMINtransaksi" || $jeniswebsite == "FINANCEtransaksi" || $jeniswebsite == "CStransaksi" ||
                $jeniswebsite == "DCtransaksi" || $jeniswebsite == "SALEStransaksi" ||
                $jeniswebsite == "M1transaksi" || $jeniswebsite == "M2transaksi" || $jeniswebsite == "M3laporan") {
            $response = array('status' => 'GAGALLOGIN', 'message' => 'LOGIN GAGAL, anda tidak berhak mengakses halaman ini');
            die(json_encode($response));
        }

        $ipkantor = array('192.168.1.99');
        if (substr($jenis, 0, 1) != 'M' && in_array($ip, $ipkantor) != false) { //jika ingin proteksi dijalanan == false
            $response = array('status' => 'GAGALLOGIN', 'message' => 'LOGIN GAGAL, Silahkan login di kantor');
            die(json_encode($response));
        }
    }

}
