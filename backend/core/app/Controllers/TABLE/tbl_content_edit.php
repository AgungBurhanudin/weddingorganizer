<?php

$id_add = strtoupper(trim($jreq->detail->id));
$create_time = $jreq->detail->create_time;
$update_time = date("Y-m-d H:i:s");
$noid = $jreq->detail->noid;
$title = $jreq->detail->title;
$highligth = $jreq->detail->highlight;
$contents = json_encode($jreq->detail->content);
$tags = json_encode($jreq->detail->tags);
$title_image = $jreq->detail->title_image;
$images = json_encode($jreq->detail->images);
$files = json_encode($jreq->detail->files);
$status = $jreq->detail->status;
$viewed = $jreq->detail->viewed;
$rating = $jreq->detail->rating;

$arr_cek = $db->cekId('tbl_contents', 'id', $id_add);
if (isset($arr_cek->id)) {
	$title = $arr_cek->title;
	$sql = "BEGIN TRANSACTION;"
			. "update tbl_contents set create_time='$create_time',update_time='$update_time',noid='$noid',title='$title',"
			. "highligth='$highligth',contents='$contents',tags='$tags',title_image='$title_image',images='$images',"
			. "files='$files',status='$status',viewed='$viewed',rating='$rating' where id = $id_add;"
			. "COMMIT;";
	$db->singleRow($sql);
	$response = array(
		'response_code' => '0000',
		'response_message' => "Sukses Update Konten $title",
		'saldo' => $saldo_member
	);
} else {
	$error->dataTidakAda($saldo_member);
}
$reply = json_encode($response);

