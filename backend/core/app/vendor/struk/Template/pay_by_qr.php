<?php

$trx = $obj->trx;
$paylog = $obj->paylog;

$merchant = $trx->product_detail;
$invoiceid = $trx->idpel;
$nominal = $trx->nominal;
$discount = $paylog->content->responseContent->discountAmount;
$tip = $paylog->content->responseContent->tippingAmount;
$totalBayar = ($nominal-$discount) + $tip;

imagestring($im, 3, (imagesx($im) - 7.5 * strlen("Pay by QR")) / 1.9, 110, "Pay by QR", $black);
imagestring($im, 2, 18, 130, "MERCHANT   : ", $black); imagestring($im, 2, strlen("INVOICE ID : ")*6+20, 130, $merchant, $black);
imagestring($im, 2, 18, 145, "INVOICE ID : ", $black); imagestring($im, 2, strlen("INVOICE ID : ")*6+20, 145, $invoiceid, $black);
imagestring($im, 2, 18, 160, "NOMINAL    : ", $black); imagestring($im, 2, strlen("INVOICE ID : ")*6+20, 160, "  Rp".rupiah($nominal), $black);
imagestring($im, 2, 18, 175, "DISCOUNT   : ", $black); imagestring($im, 2, strlen("INVOICE ID : ")*6+20, 175, "- Rp".rupiah($discount), $black);
imagestring($im, 2, 18, 190, "TIP        : ", $black); imagestring($im, 2, strlen("INVOICE ID : ")*6+20, 190, "  Rp".rupiah($tip), $black);
imagestring($im, 2, 18, 205, "-------------------------- +", $black); 
imagestring($im, 2, 18, 220, "TOTAL      : ", $black); imagestring($im, 2, strlen("INVOICE ID : ")*6+20, 220, "Rp".rupiah($totalBayar), $black);
