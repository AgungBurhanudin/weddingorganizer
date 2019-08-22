<?php

namespace Controllers;

use Resources,
    Models,
    Libraries;

class TRXPAYMENT extends Resources\Controller {

    public function __construct() {
        parent::__construct();
        set_time_limit(150);
        $this->rest = new Resources\Rest;
    }

    //proteksi ip

    public function act($traceId, $reff, $interface) {
        //traceId 12 digit
        $fungsi = new Libraries\Fungsi;
        $fHtml = new Libraries\FungsiHtml;
        $wLog = new Libraries\WriteLog;
        $db = new Models\Databases();
        $error = new Libraries\ResponseError;
        $reply = '';
        $param = file_get_contents('php://input');
        $jreq = json_decode(preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '',$param));
        $noid = $jreq->noid;
        $username = strtoupper($jreq->username);
        $token = $jreq->token;
        $wLog->writeLog($interface, 'PAYMENT', $traceId.'>>>'.$reff);
        $environment = $fungsi->getEnvironment();
        
        //cek session
        $dtrx = $db->cekLogTrx($noid, $traceId, $reff);
        $arr_member = $db->cekNoidMember($noid);
        $nama_member = $arr_member->nama;
        $tipe_member = $arr_member->tipe;
        $jenis_member = $arr_member->jenis;
        $saldo_member = $arr_member->saldo;
        $struk="{}";
        
        if (!isset($dtrx->id)) {
            $error->requestPayTrxInvalid($saldo_member);
        }
        if ("$noid $username $token" != $dtrx->security_id) {
            $error->requestPayTrxInvalidCredential($saldo_member);
        }
//        $db->updateLogTrx($dtrx->id);

        $response_code = 'XXXX';
        $response_message = '';
        $lembar = $dtrx->lembar;
        if($dtrx->distribusi_fee == 2){
            $amount = $dtrx->amount - ($dtrx->feem3 * $lembar);
            $dtrx->feem3 = 0;
        }else{
            $amount = $dtrx->amount;
        }
        $biller = $dtrx->biller;
        $kode_h2h = $dtrx->kode_h2h;
        if($dtrx->product == 'PULSA'){
            $operator = 'PULSA';
            $idpel_name = '';
        }else{
            $operator = $dtrx->product . $dtrx->product_detail;
            $idpel_name = ' '.$dtrx->idpel_name;
        }
        if ($saldo_member >= $amount) {
            $amount_minus = $amount * -1;
            $last_trx = array(
                'interface' => $interface,
                'username' => $username,
                'trace_id' => $traceId,
                'reff' => $reff,
                'product' => $dtrx->product,
                'product_detail' => $dtrx->product_detail,
                'idpel' => $dtrx->idpel,
                'idpel_name' => $dtrx->idpel_name,
                'tagihan' => $dtrx->tagihan,
                'admin_bank' => $dtrx->admin_bank,
                'total_tagihan' => $dtrx->total_tagihan,
                'lembar' => $dtrx->lembar,
                'amount' => $amount,
                'distribusi_fee' => $dtrx->distribusi_fee,
                'response_code' => '0000',
                'response_message' => "Transaksi $dtrx->product $dtrx->product_detail $dtrx->idpel $idpel_name Rp. ".$fungsi->rupiah($dtrx->total_tagihan)." BERHASIL. SN:$dtrx->reff",
                'saldo' => ($saldo_member + $amount_minus)
            );
            
            $jfee = '{"margin": "'.$dtrx->margin*$lembar.'","fm1": "'.$dtrx->feem1*$lembar.'","fm2": "'.$dtrx->feem2*$lembar.'","fm3": "'.$dtrx->feem3*$lembar.'","distribusi": "'.$dtrx->distribusi_fee.'"}';
            $jlast_trx = json_encode($last_trx);
            $sql_kurang_saldo = "update tbl_member_account set saldo = saldo - $amount,last_trx='$jlast_trx',last_amount=$amount_minus,last_reff='$reff',last_fee='$jfee',"
                    . "last_date = now(),last_lembar=$lembar where noid = '$noid' returning saldo;";
            $saldo_noid = $db->singleRow($sql_kurang_saldo);
            $saldo_member_new = (int) $saldo_noid->saldo;

            if ($saldo_member_new < 0) {
                $sql_saldo_racukup = "BEGIN TRANSACTION;"
                        . "update tbl_member_account set saldo = saldo + $amount,last_trx='$jlast_trx',last_amount='$amount',last_reff='$reff',last_fee='$jfee',last_lembar=$lembar where noid = '$noid';"
                        . "insert into log_detail_trx (noid,reff,struk,response_code,response_message,product,product_detail) values "
                        . "('$noid','$reff','$struk','0510','SALDO TIDAK CUKUP','$dtrx->product','$dtrx->product_detail');"
                        . "update log_data_trx set stat=2 where date(now()) = date(waktu) and noid='$noid' and reff='$reff';"
                        . "update log_channel_trx set status = 2 where id=$dtrx->id;"
                        . "COMMIT;";
                $db->singleRow($sql_saldo_racukup);
                //DIE GAGAL, SEBELUM DIE, UPDATE LOG TRX
                $error->saldoTidakCukup($saldo_member);
            }
            
            include "GATEWAY/$biller/PAY/$operator.php";
            
            
            if ($response_code == '0000') {
                //sql update struk, fee, distribution_fee
                $response_message = $last_trx['response_message'];
                $sql_summary_pay = "BEGIN TRANSACTION;"
                        . "insert into log_detail_trx (noid,reff,struk,response_code,response_message,product,product_detail) "
                        . "values ('$noid','$reff','$struk','$response_code','$response_message','$dtrx->product','$dtrx->product_detail');"
                        . "update log_channel_trx set status = 1 where id=$dtrx->id;"
                        . "update tbl_member_account set today_trx = today_trx + 1, month_trx = month_trx + 1 where noid = '$noid';"
                        . "COMMIT;";
                $db->singleRow($sql_summary_pay);
                $reply = str_replace("`", "'",$jlast_trx);
            } elseif (in_array($response_code, array('0099','0068','0063','0005'))) {
                //pending selain rc sukses dan selain rc gagal
                $last_trx['response_code'] = $response_code;
                $last_trx['response_message'] = 'TRANSAKSI MASIH DALAM PROSES. ' . $response_message;
                $jlast_trx_pending = json_encode($last_trx);
                $response_message = $last_trx['response_message'];
                $sql_summary_pay = "BEGIN TRANSACTION;"
                        . "insert into log_detail_trx (noid,reff,struk,response_code,response_message,product,product_detail) "
                        . "values ('$noid','$reff','$struk','$response_code','$response_message','$dtrx->product','$dtrx->product_detail');"
                        . "update log_data_trx set stat=3,response_code='$response_code' where date(now()) = date(waktu) and noid='$noid' and reff='$reff';"
                        . "update log_channel_trx set status = 3 where id=$dtrx->id;"
                        . "COMMIT;";
                $db->singleRow($sql_summary_pay);
                $reply = $jlast_trx_pending;
            } else {
                //reversal saldo, pasti gagal wajib dengan rc gagal
                $last_trx['response_code'] = $response_code;
                $last_trx['response_message'] = 'TRANSAKSI GAGAL. ' . $response_message;
                $last_trx['saldo'] = $saldo_member;
                $jlast_trx_gagal = json_encode($last_trx);
                $response_message = $last_trx['response_message'];
                $sql_reversal_saldo = "BEGIN TRANSACTION;"
                        . "update tbl_member_account set saldo = saldo + $amount,last_trx='$jlast_trx_gagal',last_amount='$amount',last_reff='$reff',last_fee='$jfee',last_lembar=$lembar where noid = '$noid' returning saldo;"
                        . "insert into log_detail_trx (noid,reff,struk,response_code,response_message,product,product_detail) values "
                        . "('$noid','$reff','$struk','$response_code','$response_message','$dtrx->product','$dtrx->product_detail');"
                        . "update log_data_trx set stat=2,response_code='$response_code' where date(now()) = date(waktu) and noid='$noid' and reff='$reff';"
                        . "update log_channel_trx set status = 2 where id=$dtrx->id;"
                        . "COMMIT;";
                $arr_reversal_saldo = $db->singleRow($sql_reversal_saldo);
                $reply = $jlast_trx_gagal;
            }
        } else {
            $error->saldoTidakCukup($saldo_member);
        }
        $wLog->writeLog($interface, 'PAYMENT', $reply);
        echo $reply;
    }

}
