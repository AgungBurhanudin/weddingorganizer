<?php

namespace Controllers;

use Resources,
    Models,
    Libraries;

class TRXINQUIRY extends Resources\Controller {

    public function __construct() {
        parent::__construct();
        set_time_limit(150);
        $this->rest = new Resources\Rest;
    }

    public function act($product, $product_detail, $idpel, $traceId, $interface) {
        //traceId 12 digit
        $fungsi = new Libraries\Fungsi;
        $fHtml = new Libraries\FungsiHtml;
        $wLog = new Libraries\WriteLog;
        $db = new Models\Databases();
        $error = new Libraries\ResponseError;
        
        $environment = $fungsi->getEnvironment();
        $reply = '';
        $log_biller = '';
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
        $reff = date("ndHis") . $fungsi->randomNumber(3);
        $wLog->writeLog($interface, 'INQUIRY', $product.'_'.$product_detail.'_'.$idpel);

        $tagihan = 0;
        $admin_bank = 0;
        $total_tagihan = 0;
        $lembar = 1;
        $idpel_name = '';
        $response_code = 'XXXX';
        $response_message = '';
        $response_html = '';

        //cek session
        if($interface == 'MULTIKOLEKTIF'){
            $db->cekSessionMulti($noid, 'WEB', $username, $token, $time_sess);
        }else{
            $db->cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip);
        }
        
        $arr_member = $db->cekNoidMember($noid);
        $nama_member = $arr_member->nama;
        $tipe_member = $arr_member->tipe;
        $jenis_member = $arr_member->jenis;
        $saldo_member = $arr_member->saldo;
        $distribusi_fee = $arr_member->fee_dist;
        
        if($tipe_member != 'M3'){
            $error->tipeActionTidakValid($saldo_member);
        }

        if ($product == 'PULSA') {
            //cek produk pulsa    
            $arr_harga = $db->cekHargaPulsa($product, $product_detail, $noid, $saldo_member);
            $gtw_biller = $arr_harga['biller'];
            $kode_h2h = $arr_harga['kode_h2h'];
            $margin = $arr_harga['margin'];
            $feem1 = $arr_harga['M1'];
            $feem2 = $arr_harga['M2'];
            $feem3 = 0;
            
            $idpel_name = $product . $product_detail;

            $admin_bank = 0;
            $tagihan = $arr_harga['harga'];
            $total_tagihan =$arr_harga['harga'];
            $amount = $arr_harga['harga'];
            $operator = $arr_harga['operator'];
            $response_code = '0000';
            
            $jh = array();
            $jh[0][0] = 'PEMBELIAN';
            $jh[0][1] = $product . ' ' . $operator;
            $jh[1][0] = 'NOMINAL/JENIS';
            $jh[1][1] = $product_detail;
            $jh[2][0] = 'HARGA';
            $jh[2][1] = $fungsi->rupiah($total_tagihan);
            $jh[3][0] = 'NOMOR HP';
            $jh[3][1] = $idpel;
            $response_html = $fHtml->jsonToHtml($jh);
            $response_message = "Transaksi $product $product_detail $idpel Harga Rp. $total_tagihan";
            
            $response = array(
                'response_code' => '0000',
                'response_message' => $response_message,
                'response_html' => $response_html,
                'idpel' => $idpel,
                'idpel_name' => $product . '-' . $product_detail,
                'lembar' => $lembar,
                'tagihan' => $tagihan,
                'admin_bank' => $admin_bank,
                'total_tagihan' => $total_tagihan,
                'trace_id' => $traceId,
                'reff' => $reff,
                'saldo' => $saldo_member
            );
            $reply = json_encode($response);
        } 
        else {
            //cek produk nonpulsa
            $operator = $product . $product_detail;
            $admin_bank = isset($jreq->detail->admin_bank) && is_numeric($jreq->detail->admin_bank) ? $jreq->detail->admin_bank : 1;
            $arr_harga = $db->cekHargaAdmin($product, $product_detail, $noid, $saldo_member,$admin_bank);
            
            $gtw_biller = $arr_harga['biller'];
            $kode_h2h = $arr_harga['kode_h2h'];
            $margin = $arr_harga['margin'];
            $feem1 = $arr_harga['M1'];
            $feem2 = $arr_harga['M2'];
            $feem3 = $arr_harga['M3'];

            $admin_bank = $arr_harga['admin_bank'];
            
            if($operator == 'PLNPREPAID'){
                if(isset($jreq->detail->nominal)){
                    $nominal = $jreq->detail->nominal;
                }else{
                    $error->plnPrepaidNominal($saldo_member);
                }
            }
            include "GATEWAY/$gtw_biller/INQ/$operator.php";
            
            $amount = $total_tagihan;
            if($response_code == '0000'){
                $response_message = "Transaksi $product $product_detail $idpel $idpel_name Rp. ".$fungsi->rupiah($total_tagihan);
            }else{
                include "GTW_ERROR/$operator.php";
                $response_html = $response_message;
                $lembar = 0;
            }
            $response = array(
                'response_code' => $response_code,
                'response_message' => $response_message,
                'response_html' => $response_html,
                'idpel' => $idpel,
                'idpel_name' => $idpel_name,
                'lembar' => $lembar,
                'tagihan' => $tagihan,
                'admin_bank' => $admin_bank,
                'total_tagihan' => $total_tagihan,
                'trace_id' => $traceId,
                'reff' => $reff,
                'saldo' => $saldo_member
            );
            $reply = json_encode($response);
        }

        $sql_channel_trx = "insert into log_channel_trx(noid,product,product_detail,idpel,idpel_name,trace_id,reff,status,tagihan,admin_bank,"
                . "total_tagihan,lembar,security_id,biller,kode_h2h,feem1,feem2,feem3,amount,distribusi_fee,response_code,response_message,log_biller,margin) "
                . "values ('$noid','$product','$product_detail','$idpel','$idpel_name','$traceId','$reff',0,$tagihan,$admin_bank,"
                . "$total_tagihan,$lembar,'$noid $username $token','$gtw_biller',"
                . "'$kode_h2h', $feem1, $feem2, $feem3, $amount,$distribusi_fee,'$response_code','$response_message','$log_biller',$margin);";
        $db->singleRow($sql_channel_trx);
        $wLog->writeLog($interface, 'INQUIRY', $reply);
        echo $reply;
    }

}
