<?php

$id_group = $jreq->detail->id_group;
$admin_bank = $jreq->detail->admin_bank;

$sql_cek = "select id,idpel from tbl_group_kolektif_detail where id_group = $id_group;";
$arr = $db->multipleRow($sql_cek);

$jenis = 'PLN';

if (isset($arr[0]->id)) {
    $json_request = '{"noid":"'.$noid.'","username":"'.$username.'",'
            . '"token":"'.$token.'","appid":"'.$appid_browser.'",'
            . '"detail": {"admin_bank": "'.$admin_bank.'"}}';
    if ($jenis == 'PLN') {
        $jenis = 'PLN/POSTPAID';
    } elseif ($jenis == 'TELEPON') {
        $jenis = 'TELKOM/TELEPON';
    } else {
        $jenis = 'PDAM';
    }

    $datakolektif = array();
    
    foreach ($arr as $data) {
        $traceId = date("mdHis") . $fungsi->randomNumber(6);
        $idpel = $data->idpel;
        $url_request = "https://igt.co.id/framework/core/public/index.php/TRXINQUIRY/act/$jenis/$idpel/$traceId/MULTIKOLEKTIF";
        $response_kolektif = $fungsi->getCurlResult($url_request, $json_request);
        $arr = json_decode($response_kolektif);
        if (isset($arr->response_code)) {

            if ($arr->response_code == '0000') {
                unset($arr->response_html);
                $sql_update_kolektif = "update tbl_group_kolektif_detail set status = -1, idpel_name = '$arr->idpel_name', "
                        . "tagihan = $arr->tagihan, admin_bank = $arr->admin_bank, total_tagihan = $arr->total_tagihan, "
                        . "bulan = $arr->lembar, trace_id = '$traceId', reff = '$arr->reff', "
                        . "last_update = now(), keterangan='' where id=$data->id";
                $db->singleRow($sql_update_kolektif);
            } else {
                $db->singleRow("update tbl_group_kolektif_detail set idpel_name = '$arr->response_message', keterangan='inquiry gagal, $arr->response_message' where id=$data->id");
            }
            array_push($datakolektif, $arr);
        }
    }
    $response = array(
        'response_code' => '0000',
        'response_message' => 'Proses Inquiry Kolektif Berhasil',
        'data' => $datakolektif,
        'saldo' => $fungsi->rupiah($saldo_member)
    );
} else {
    $response = array(
        'response_code' => '0076',
        'response_message' => 'Inquiry Kolektif Gagal, Group Kolektif belum memiliki IDPEL',
        'saldo' => $fungsi->rupiah($saldo_member)
    );
}
$reply = json_encode($response);
