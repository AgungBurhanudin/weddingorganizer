<?php

namespace Controllers;

use Resources,
    Models,
    Libraries;

class REQUEST_OPEN extends Resources\Controller {

    public function __construct() {
        parent::__construct();
        set_time_limit(150);
    }

    //proteksi ip
    public function act($tipe_file, $tipe_request, $interface, $action = NULL) {
        $fungsi = new Libraries\Fungsi;
        $wLog = new Libraries\WriteLog;
        $konfig = new Libraries\Konfigurasi;
        $error = new Libraries\ResponseError;

        $db = new Models\Databases();
        $param = file_get_contents('php://input');
        $jreq = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '', $param));
        $nohp_email = strtoupper($jreq->nohp_email);
        $ref = date("ymdH") . $fungsi->randomNumber(8);
        $wLog->writeLog($interface, $tipe_file . '_' . $tipe_request, $param);

        $tipebrowser = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');

        $nama_aplikasi = $konfig->namaAplikasi();

        //cek menu status hak akses
        $arr_menu = $db->singleRow("SELECT id,perintah,aturan,hak_akses,validasi,status,keterangan FROM tbl_menu WHERE perintah = '$tipe_request'");
        if (!isset($arr_menu->status)) {
            $error->menuTidakAda(0);
        }
        $status_menu = $arr_menu->status;
        $hak_akses = $arr_menu->hak_akses;
        $otorisasi = $arr_menu->validasi;
        $keterangan_menu = $arr_menu->keterangan;

        //validasi hak akses
        if ($status_menu != 1) {
            $error->menuTidakBerhak(0);
        }

        $cdbl = $db->singleRow("select id from log_channel where noid='$nohp_email' and "
                . "tipe_request ='$tipe_request' and "
                . "waktu > now() - interval '1 seconds' order by waktu desc limit 1");

        if (isset($cdbl->id)) {
            $error->requestTerlaluCepat(0);
        }

        include "$tipe_file/$tipe_request.php";

        if ($tipe_request != 'cek_new_message') {
            $sql_log_channel = "insert into log_channel(noid, tipe_file, tipe_request, djson_request, djson_reply,status) "
                    . "values ('$nohp_email','$tipe_file','$tipe_request','$param','$reply',2);";
            $db->singleRow($sql_log_channel);
        }
        echo $reply;
        $wLog->writeLog($interface, $tipe_file . '_' . $tipe_request, $reply);
    }

}
