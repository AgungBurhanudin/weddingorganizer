<?php

header('Content-Type: application/json');
require_once 'config_url.php';

$detail = '{
		"create_time" : "2018-01-01 00:00:00",
		"noid" :"0001010000000",
		"title" : "Lorem Ipsum Dolor Sit Amet",
		"highlight" : "Lorem",
		"content" :{"":""},
		"tags" :{"":""},
		"title_image" : "lorem",
		"images" :{"":""},
		"files" :{"":""},
		"status" : 1,
		"viewed" : 0,
		"rating" : 0
  }';

$param = array(
    'detail' => json_decode($detail),
    'noid' => $_SESSION['noid'],
    'username' => USERNAME,
    'token' => $_SESSION['token'],
    'appid' => APPID
);

echo $json_request = json_encode($param);
echo '

';
echo $url_request = BASE_URL . 'REQUEST/act/TABLE/tbl_content_add/WEB';
$response = getCurlResult($url_request, $json_request);

echo '

';
echo $response;
