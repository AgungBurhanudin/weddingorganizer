<?php

namespace Controllers;

use Resources,
    Models,
    Libraries;

class REQUEST_H2H extends Resources\Controller {

    public function __construct() {
        parent::__construct();
        set_time_limit(150);
    }

    //proteksi ip
    public function act($tipe_file, $tipe_request, $interface) {
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
        $appid = $jreq->appid;
        $time_sess = '0';
        $ip = getenv('REMOTE_ADDR');
        $ref = date("ymdH").$fungsi->randomNumber(8);
        $wLog->writeLog($interface, $tipe_file.'_'.$tipe_request, $param.' >> '.$ip);

        //cek session
        $db->cekSessionH2h($noid, $interface, $username, $token, $appid, $time_sess, 'X');

        $arr_member = $db->cekNoidMember($noid);
        $nama_member = $arr_member->nama;
        $tipe_member = $arr_member->tipe;
        $jenis_member = $arr_member->jenis;
        $saldo_member = $arr_member->saldo;

        //cek menu status hak akses
        $arr_menu = $db->singleRow("SELECT id,perintah,aturan,hak_akses,validasi,status,keterangan FROM tbl_menu WHERE perintah = '$tipe_request'");
        if (!isset($arr_menu->status)) {
            $error->menuTidakAda($saldo_member);
        }
        $status_menu = $arr_menu->status;
        $hak_akses = $arr_menu->hak_akses;
        $otorisasi = $arr_menu->validasi;
        $keterangan_menu = $arr_menu->keterangan;

        //validasi hak akses
        if ($status_menu != 1) {
            $error->menuTidakBerhak($saldo_member);
        }

        if (strpos($hak_akses, $tipe_member) !== false || strlen($hak_akses) < 2) {
            if (strlen($otorisasi) < 2 || strpos($otorisasi, $tipe_member) !== false) {
                include "$tipe_file/$tipe_request.php";
            } else {
                $kode_validasi = $fungsi->randomString(12);
                $jreqdetail = json_encode($jreq->detail);
                $sql_cek_otor = "select id from log_otorisasi where tipe_request ='$tipe_request' and "
                        . "tipe_file ='$tipe_file' and date(waktu) = date(now()) and "
                        . "status = 0 and replace(jrequest::jsonb->>'detail',' ','') = replace('$jreqdetail',' ','') order by id desc limit 1";
                $cek_otor = $db->singleRow($sql_cek_otor);
                if (isset($cek_otor->id)) {
                    $error->otorisasiSudahAda($saldo_member);
                }
                unset($jreq->token);
                unset($jreq->appid);
                $new_param = json_encode($jreq);
                $sql_otorisasi = "insert into log_otorisasi (noid,tipe_file, tipe_request,jrequest,kode_validasi,tipe_validator,keterangan) values "
                        . "('$noid','$tipe_file','$tipe_request','$new_param','$kode_validasi','$otorisasi','$keterangan_menu');";
                $db->singleRow($sql_otorisasi);
                $error->otorisasiButuh($saldo_member);
            }
        } else {
            $error->menuTidakBerhak($saldo_member);
        }
        
        $wLog->writeLog($interface, $tipe_file.'_'.$tipe_request, $reply);
        echo $reply;
    }

}
