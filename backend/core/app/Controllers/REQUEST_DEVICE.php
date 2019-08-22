<?php

namespace Controllers;

use Resources,
    Models,
    Libraries;

class REQUEST_DEVICE extends Resources\Controller {

    public function __construct() {
        parent::__construct();
        set_time_limit(150);
    }

    //proteksi ip
    public function act($tipe_file, $tipe_request, $interface, $noid, $username, $token, $nfc_id) {
        $fungsi = new Libraries\Fungsi;
        $wLog = new Libraries\WriteLog;
        $konfig = new Libraries\Konfigurasi;
        $error = new Libraries\ResponseError;
        
        $db = new Models\Databases();
        $param = file_get_contents('php://input');
        $jreq = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '',$param));
//        $noid = $jreq->noid;
//        $username = $jreq->username;
//        $token = $jreq->token;
        $time_sess = '60';
        $ip = 'X';
        $ref = date("ymdH").$fungsi->randomNumber(8);
        $wLog->writeLog($interface, $tipe_file.'_'.$tipe_request, $param.' >> '.$ip);

        //cek session
        $db->cekSessionDevice($noid, $interface, $username, $token, $time_sess, $ip);

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
                include "DEVICE/$tipe_request.php";
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
    
    public function CEKTOKENDEVICE($interface,$id_device) {
        $db = new Models\Databases();
        $reply = new Models\LoginRespon();
        $fungsi = new \Libraries\Fungsi();

        $reply->tipe = 'CEKTOKENDEVICE';
        $reply->interface = $interface;
        
        $param = file_get_contents('php://input');
        $jreq = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '',$param));
//        $id_device = $jreq->id_device;
        $alias = substr($id_device, 0,5);
        $token = substr($id_device, 5,5);

        $sql = "select id,noid,alias,appid from tbl_member_channel where "
                . "substring(token from 1 for 5) = '$token' and interface = '$interface' "
                . "and substring(token from 1 for 5) = '$token' "
                . "and last_used > now() - interval '60 minutes';";
        $arr_cek = $db->singleRow($sql);

        if (isset($arr_cek->alias)) {
            $reply->status = "SUKSES";
            $reply->noid = $arr_cek->noid;
            $reply->nama = $arr_cek->alias;
            $reply->token = $token;
            $reply->message = 'Berhasil Cek ID Device';
        } else {
            $reply->message = 'Gagal Cek ID Device';
        }
        echo $reply->status.'#'.$reply->noid.'#'.$reply->nama.'#'.$reply->token.'#'.$reply->message;
    }

}
