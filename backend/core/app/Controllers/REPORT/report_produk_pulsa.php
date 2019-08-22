<?php

$operator = strtoupper($jreq->detail->operator);
$data = $db->cekProdukPulsa($operator, $noid);
$reply = json_encode($data);