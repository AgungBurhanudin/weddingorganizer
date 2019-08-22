<?php

$id_add = strtoupper(trim($jreq->detail->id));
$arr = $db->singleRow("select id,create_time, update_time, noid, title, highligth, contents, tags, title_image, images, files, status, viewed, rating"
		. " from tbl_contents where id = $id_add");

if (isset($arr->id)) {
	$response = array(
		'response_code' => '0000',
		'response_message' => 'CEK DATA CONTENT BERHASIL',
		'create_time' => $arr->create_time,
		'update_time' => $arr->update_time,
		'noid' => $arr->noid,
		'title' => $arr->title,
		'hightligth' => $arr->highligth,
		'contents' => $arr->contents,
		'tags' => $arr->tags,
		'title_images' => $arr->title_image,
		'images' => $arr->images,
		'files' => $arr->files,
		'status' => $arr->status,
		'viewed' => $arr->viewed,
		'rating' => $arr->rating
	);
} else {
	$error->dataTidakAda($saldo_member);
}

$reply = json_encode($response);
