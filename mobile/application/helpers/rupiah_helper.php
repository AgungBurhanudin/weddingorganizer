<?php

function buatrp($angka) {
    $jadi = "IDR " . number_format($angka, 2, ',', '.');
    return $jadi;
}

