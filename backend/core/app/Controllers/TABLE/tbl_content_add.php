<?php

$create_time = $jreq->detail->create_time;
$noid = $jreq->detail->noid;
$title = $jreq->detail->title;
$highlight = $jreq->detail->highlight;
$contents = json_encode($jreq->detail->content);
$tags = json_encode($jreq->detail->tags);
$title_image = $jreq->detail->title_image;
$images = json_encode($jreq->detail->images);
$files = json_encode($jreq->detail->files);
$status = $jreq->detail->status;
$viewed = $jreq->detail->viewed;
$rating = $jreq->detail->rating;

$arr_cek = $db->cekId('tbl_contents','title',$title);

if (!isset($arr_cek->id)) {
    $sql = "BEGIN TRANSACTION;"
            . "INSERT INTO tbl_contents (create_time, noid, title, highligth, contents, tags, title_image, images, files, status, viewed, rating) VALUES "
            . "('$create_time','$noid','$title','$highlight','$contents','$tags','$title_image','$images','$files','$status','$viewed','$rating');"
            . "COMMIT;";
    $db->singleRow($sql);
    $response = array(
        'response_code' => '0000',
        'response_message' => "Sukses Penambahan Konten $title",
        'saldo' => $saldo_member
    );
} else {
    $error->contentTerdaftar($title);
}
$reply = json_encode($response);
