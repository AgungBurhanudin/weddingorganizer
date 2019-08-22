<?php

namespace Controllers;

use Resources,
    Models,
    Libraries;

class OTORISASI extends Resources\Controller {

    public function __construct() {
        parent::__construct();
        set_time_limit(150);
    }

    //proteksi ip
    public function act($tipe_request, $kode_validasi, $interface) {
        $fungsi = new Libraries\Fungsi;
        $wLog = new Libraries\WriteLog;
        $konfig = new Libraries\Konfigurasi;
        $error = new Libraries\ResponseError;

        $db = new Models\Databases();
        $param = file_get_contents('php://input');
        $jreq = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '',$param));
        $noid = $jreq->noid;
        $username = strtoupper($jreq->username);
        $token = $jreq->token;
        $tipebrowser = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        $appid_browser = $jreq->appid;
        $secClient = substr(base64_encode($appid_browser . $tipebrowser), 15, 50) . '#' . $appid_browser;
        $appid = $secClient;
        $time_sess = '60';
        $ip = getenv('REMOTE_ADDR');
        $ref = date("ymdH").$fungsi->randomNumber(8);

        //cek session
        $db->cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip);

        $arr_member = $db->cekNoidMember($noid);
        $nama_member = $arr_member->nama;
        $tipe_member = $arr_member->tipe;
        $jenis_member = $arr_member->jenis;
        $saldo_member = $arr_member->saldo;

        //cek menu status hak akses
        $arr_menu = $db->singleRow("SELECT id,perintah,aturan,hak_akses,validasi,status FROM tbl_menu WHERE perintah = '$tipe_request'");
        if (!isset($arr_menu->status)) {
            $error->menuTidakAda($saldo_member);
        }
        $status_menu = $arr_menu->status;
        $hak_akses = $arr_menu->hak_akses;

        //validasi hak akses
        if ($status_menu != 1) {
            $error->menuTidakBerhak($saldo_member);
        }

        $sql_cek_otor = "select id,noid,tipe_file,tipe_request,jrequest,tipe_validator,keterangan from log_otorisasi where "
                . "kode_validasi ='$kode_validasi' and status = 0 order by id desc;";
        $cek_otor = $db->singleRow($sql_cek_otor);
        
        if (!isset($cek_otor->id)) {
            $error->otorisasiTidakAda($saldo_member);
        }
        
        $noid_maker = $cek_otor->noid;
        $tipe_file_otor = $cek_otor->tipe_file;
        $tipe_request_otor = $cek_otor->tipe_request;
        $keterangan_menu = $cek_otor->keterangan;
        $jrequest = json_decode($cek_otor->jrequest);

        if (strpos($cek_otor->tipe_validator, $tipe_member) !== false) {
            include "$tipe_file_otor/$tipe_request_otor.php";
        } else {
            $error->menuTidakBerhak($saldo_member);
        }
        
        $req_detail = json_encode($jrequest->detail);
        $message = "Request anda terkait $keterangan_menu $req_detail telah BERHASIL diproses oleh $nama_member";
        $db->kirimMessage($noid_maker, $message);
        $sql_log_channel = "update log_otorisasi set status = 1, noid_validator = '$noid', waktu_validasi = now(), jresult = '$reply' where id = $cek_otor->id;"
                . "insert into log_channel(noid, tipe_file, tipe_request, djson_request, djson_reply,status) "
               . "values ('$noid','OTORISASI','$tipe_request','$param','$reply',2);";
        
        $db->singleRow($sql_log_channel);
        $wLog->writeLog($interface, 'OTORISASI_'.$tipe_request_otor, $param.$reply);
        echo $reply;
    }

}
