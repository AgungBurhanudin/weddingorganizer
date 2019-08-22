<?php

namespace Controllers;

use Libraries;
use Models;
use Resources;

class XREQUEST extends Resources\Controller
{

    public function __construct()
    {
        parent::__construct();
        set_time_limit(150);
    }

    //proteksi ip
    public function act($folder_name, $file_name, $action_request, $interface)
    {
        $fungsi = new Libraries\Fungsi;
        $wLog   = new Libraries\WriteLog;
        $konfig = new Libraries\Konfigurasi;
        $error  = new Libraries\ResponseError;

        $db            = new Models\Databases();
        $param         = file_get_contents('php://input');
        $jreq          = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '', $param));
        $noid          = $jreq->noid;
        $username      = strtoupper($jreq->username);
        $token         = $jreq->token;
        $tipebrowser   = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        $appid_browser = $jreq->appid;
        $secClient     = substr(base64_encode($appid_browser . $tipebrowser), 15, 50) . '#' . $appid_browser;
        $appid         = $secClient;
        $time_sess     = '60';
        $ip            = getenv('REMOTE_ADDR');
        $ref           = date("ymdH") . $fungsi->randomNumber(8);
        $reply         = '';
        $wLog->writeLog($interface, $folder_name . '_' . $file_name, $param);

        //cek session
        $db->cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip);

        $arr_member        = $db->cekNoidMember($noid);
        $nama_member       = $arr_member->nama;
        $tipe_member       = $arr_member->tipe;
        $jenis_member      = $arr_member->jenis;
        $saldo_member      = $arr_member->saldo;
        $nohp_email_member = $arr_member->nohp_email;

        //cek menu status hak akses
        $arr_menu = $db->singleRow("SELECT id,perintah,aturan,hak_akses,validasi,status,keterangan FROM tbl_menu WHERE perintah = '$file_name'");
        if (!isset($arr_menu->status)) {
            $error->menuTidakAda($saldo_member);
        }
        $status_menu     = $arr_menu->status;
        $hak_akses       = $arr_menu->hak_akses;
        $otorisasi       = $arr_menu->validasi;
        $keterangan_menu = $arr_menu->keterangan;

        //validasi hak akses
        if ($status_menu != 1) {
            $error->menuTidakBerhak($saldo_member);
        }

        $cdbl = $db->singleRow("select id from log_channel where noid='$noid' and "
            . "tipe_request ='$file_name' and "
            . "waktu > now() - interval '1 seconds' order by waktu desc limit 1");

        if($file_name != "tbl_contents"){
            if (isset($cdbl->id)) {
                $error->requestTerlaluCepat($saldo_member);
            }
        }

        if (strpos($hak_akses, $tipe_member) !== false || strlen($hak_akses) < 2) {
            if (strlen($otorisasi) < 2 || strpos($otorisasi, $tipe_member) !== false) {
                include "$folder_name/$file_name.php";
            } else {
                $kode_validasi = $fungsi->randomString(12);
                $jreqdetail    = json_encode($jreq->detail);
                $sql_cek_otor  = "select id from log_otorisasi where tipe_request ='$file_name' and "
                . "tipe_file ='$folder_name' and date(waktu) = date(now()) and "
                . "status = 0 and replace(jrequest::jsonb->>'detail',' ','') = replace('$jreqdetail',' ','') order by id desc limit 1";
                $cek_otor = $db->singleRow($sql_cek_otor);
                if (isset($cek_otor->id)) {
                    $error->otorisasiSudahAda($saldo_member);
                }
                unset($jreq->token);
                unset($jreq->appid);
                $new_param     = json_encode($jreq);
                $sql_otorisasi = "insert into log_otorisasi (noid,tipe_file, tipe_request,jrequest,kode_validasi,tipe_validator,keterangan) values "
                . "('$noid','$folder_name','$file_name','$new_param','$kode_validasi','$otorisasi','$keterangan_menu');";
                $db->singleRow($sql_otorisasi);
                $error->otorisasiButuh($saldo_member);
            }
        } else {
            $error->menuTidakBerhak($saldo_member);
        }

        if ($folder_name != 'REPORT') {
            $sql_log_channel = "insert into log_channel(noid, tipe_file, tipe_request, djson_request, djson_reply,status) "
            . "values ('$noid','$folder_name','$file_name','$param','$reply',2);";
            $db->singleRow($sql_log_channel);
        }
        $wLog->writeLog($interface, $folder_name . '_' . $file_name, $reply);
        echo $reply;

    }

}
