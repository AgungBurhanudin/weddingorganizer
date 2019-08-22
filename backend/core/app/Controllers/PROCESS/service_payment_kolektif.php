<?php

$id_group = $jreq->detail->id_group;

$sql_cek = "select id,idpel,trace_id,reff from tbl_group_kolektif_detail "
        . "where status = -1 and last_update > now() - interval '90 minutes' and id_group = $id_group;";
$arr = $db->multipleRow($sql_cek);

$jenis = 'PLN';

if (isset($arr[0]->id)) {
    $param_security = array(
        'noid' => $noid,
        'username' => $username,
        'token' => $token,
        'appid' => $appid_browser
    );
    $json_request = json_encode($param_security);
    if ($jenis == 'PLN') {
        $jenis = 'PLN/POSTPAID';
    } elseif ($jenis == 'TELEPON') {
        $jenis = 'TELKOM/TELEPON';
    } else {
        $jenis = 'PDAM';
    }

    $datakolektif = array();
    
    foreach ($arr as $data) {
        $idpel = $data->idpel;
        $traceIdKolektif = $data->trace_id;
        $reffKolektif = $data->reff;
        $url_request = "https://igt.co.id/framework/core/public/index.php/TRXPAYMENT/act/$traceIdKolektif/$reffKolektif/MULTIKOLEKTIF";
        $response_kolektif = $fungsi->getCurlResult($url_request, $json_request);
        $arr = json_decode($response_kolektif);
        if (isset($arr->response_code)) {

            if ($arr->response_code == '0000') {
//                unset($arr->response_html);
                $sql_update_kolektif = "update tbl_group_kolektif_detail set status = 1, keterangan = 'BERHASIL DIBAYAR, Saldo $arr->saldo' where id=$data->id";
                $db->singleRow($sql_update_kolektif);
            } else {
                $db->singleRow("update tbl_group_kolektif_detail set status = 1, idpel_name = 'PAYMENT GAGAL', keterangan = 'PAYMENT GAGAL, $arr->response_message' where id=$data->id");
            }
            array_push($datakolektif, $arr);
        }
    }
    $response = array(
        'response_code' => '0000',
        'response_message' => 'Proses Payment Kolektif Berhasil',
        'data' => $datakolektif,
        'saldo' => $fungsi->rupiah($saldo_member)
    );
} else {
    $response = array(
        'response_code' => '0076',
        'response_message' => 'Payment Kolektif Gagal, Group Kolektif belum ada Inquiry',
        'saldo' => $fungsi->rupiah($saldo_member)
    );
}
$reply = json_encode($response);
