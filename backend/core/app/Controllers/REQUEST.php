<?php

namespace Controllers;

use Libraries;
use Models;
use Resources;

class REQUEST extends Resources\Controller
{

    public function __construct()
    {
        parent::__construct();
        set_time_limit(150);
    }

    //proteksi ip
    public function act($tipe_file, $tipe_request, $interface)
    {
        $fungsi = new Libraries\Fungsi;
        $wLog   = new Libraries\WriteLog;
        $konfig = new Libraries\Konfigurasi;
        $error  = new Libraries\ResponseError;

        $db    = new Models\Databases();
        $param = file_get_contents('php://input');
        // untuk beberapa kasus malah bikin error
        // $jreq = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '',$param));

        if (empty($param) || $param == "[]" || $param == "" || $param == null || (empty(json_encode($param)))) {
            $param = json_encode($_POST);
            // untuk beberapa kasus malah bikin error
            // $jreq = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '',$param));

        }

        //untuk kasus upload dari frontend request 2 kali, request pertama harus di stop dulu karena data yang di kirimkan kosong
        //request ke dua datanya ada, jadi skip request yang pertama jika data dari php://input dan $_POST kosong
        if (empty($param) || $param == "[]" || $param == "" || $param == null || (empty(json_encode($param)))) {
            exit();
            die();
        }
        $jreq          = json_decode($param);
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
        $reply         = '{}';
        $wLog->writeLog($interface, $tipe_file . '_' . $tipe_request, $param);

        //cek session
        $db->cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip);

        $arr_member        = $db->cekNoidMember($noid);
        $nama_member       = $arr_member->nama;
        $tipe_member       = $arr_member->tipe;
        $jenis_member      = $arr_member->jenis;
        $saldo_member      = $arr_member->saldo;
        $nohp_email_member = $arr_member->nohp_email;

        //cek menu status hak akses
        $arr_menu = $db->singleRow("SELECT id,perintah,aturan,hak_akses,validasi,status,keterangan FROM tbl_menu WHERE perintah = '$tipe_request'");
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
            . "tipe_request ='$tipe_request' and "
            . "waktu > now() - interval '1 seconds' order by waktu desc limit 1");

        if (isset($cdbl->id)) {
            $error->requestTerlaluCepat($saldo_member);
        }

        if (strpos($hak_akses, $tipe_member) !== false || strlen($hak_akses) < 2) {
            if (strlen($otorisasi) < 2 || strpos($otorisasi, $tipe_member) !== false) {
                include "$tipe_file/$tipe_request.php";
            } else {
                $kode_validasi = $fungsi->randomString(12);
                $jreqdetail    = json_encode($jreq->detail);
                $sql_cek_otor  = "select id from log_otorisasi where tipe_request ='$tipe_request' and "
                    . "tipe_file ='$tipe_file' and date(waktu) = date(now()) and "
                    . "status = 0 and replace(jrequest::jsonb->>'detail',' ','') = replace('$jreqdetail',' ','') order by id desc limit 1";
                $cek_otor = $db->singleRow($sql_cek_otor);
                if (isset($cek_otor->id)) {
                    $error->otorisasiSudahAda($saldo_member);
                }
                unset($jreq->token);
                unset($jreq->appid);
                $new_param     = json_encode($jreq);
                $sql_otorisasi = "insert into log_otorisasi (noid,tipe_file, tipe_request,jrequest,kode_validasi,tipe_validator,keterangan) values "
                    . "('$noid','$tipe_file','$tipe_request','$new_param','$kode_validasi','$otorisasi','$keterangan_menu');";
                $db->singleRow($sql_otorisasi);
                $error->otorisasiButuh($saldo_member);
            }
        } else {
            $error->menuTidakBerhak($saldo_member);
        }

        if ($tipe_file != 'REPORT') {
            $sql_log_channel = "insert into log_channel(noid, tipe_file, tipe_request, djson_request, djson_reply,status) "
                . "values ('$noid','$tipe_file','$tipe_request','$param','$reply',2);";
            $db->singleRow($sql_log_channel);
        }
        $wLog->writeLog($interface, $tipe_file . '_' . $tipe_request, $reply);
        echo $reply;

    }

    public function report_by_tgl($tgl = null)
    {
        if ($tgl == null) {
            exit;
        }
        $this->db = new Resources\Database;
        $tgl      = date('Y-m-d', strtotime($tgl));

        $sql = "select id,to_char(waktu,'YYYY-MM-DD HH24:MI:SS') as waktu,"
        . "noid, "
        . "reff, "
        . "amount, "
        . "saldo, "
        . "detail::jsonb->>'interface' as interface, " //WEB / MOBILE
         . "detail::jsonb->>'product' as product, "
        . "detail::jsonb->>'product_detail' as product_detail, "
        . "detail::jsonb->>'idpel' as idpel, " //noid
         . "detail::jsonb->>'idpel_name' as idpel_name, " //nama
         . "detail::jsonb->>'response_code' as response_code, "
            . "detail::jsonb->>'lembar' as lembar, "
            . "detail::jsonb->>'trace_id' as trace_id, "
            . "detail::jsonb->>'total_tagihan' as total_tagihan, "
            . "CASE WHEN stat=0 THEN 'INQUIRY' "
            . "WHEN stat=1 THEN 'SUKSES' "
            . "WHEN stat=2 THEN 'GAGAL' "
            . "WHEN stat=3 THEN 'PENDING' "
            . "ELSE 'REFUND' END as status "
            . "from log_data_trx where to_char(waktu,'YYYY-MM-DD') = '{$tgl}'";

        $data = $this->db->results($sql);

        echo json_encode($data);
    }

    public function report_excel()
    {
        $param         = file_get_contents('php://input');
        $jreq          = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '', $param));
        $start         = $jreq->detail->start;
        $end           = $jreq->detail->end;
        $produk        = 'PLN'; //$jreq->detail->produk;
        $produk_detail = 'POSTPAID'; //$jreq->detail->produk_detail;
        if ($start == null && $end == null) {
            exit;
        }
        $w_produk = "";
        if ($produk != "") {
            $w_produk = "AND detail::jsonb->>'product' = '$produk'";
        }
        $w_produk_detail = "";
        if ($produk != "" && $produk_detail != "") {
            $w_produk_detail = "AND detail::jsonb->>'product_detail' = '$produk_detail'";
        }
        $this->db = new Resources\Database;
        $start    = date('Y-m-d', strtotime($start));
        $end      = date('Y-m-d', strtotime($end));

        $sql = "select id,to_char(waktu,'YYYY-MM-DD HH24:MI:SS') as waktu,"
        . "noid, "
        . "reff, "
        . "amount, "
        . "saldo, "
        . "detail::jsonb->>'interface' as interface, " //WEB / MOBILE
         . "detail::jsonb->>'product' as product, "
        . "detail::jsonb->>'product_detail' as product_detail, "
        . "detail::jsonb->>'idpel' as idpel, " //noid
         . "detail::jsonb->>'idpel_name' as idpel_name, " //nama
         . "detail::jsonb->>'response_code' as response_code, "
            . "detail::jsonb->>'lembar' as lembar, "
            . "detail::jsonb->>'trace_id' as trace_id, "
            . "detail::jsonb->>'total_tagihan' as total_tagihan, "
            . "CASE WHEN stat=0 THEN 'INQUIRY' "
            . "WHEN stat=1 THEN 'SUKSES' "
            . "WHEN stat=2 THEN 'GAGAL' "
            . "WHEN stat=3 THEN 'PENDING' "
            . "ELSE 'REFUND' END as status "
            . "from log_data_trx where to_char(waktu,'YYYY-MM-DD') BETWEEN '$start' AND '$end' $w_produk $w_produk_detail";
        // echo "$sql";

        $data = $this->db->results($sql);

        echo json_encode($data);
    }

}
