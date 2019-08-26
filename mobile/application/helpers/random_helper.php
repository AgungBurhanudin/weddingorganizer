<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function genRandomString($length) { // fungsi random
    $characters = '0123456789abc45de012fg78hijklmno45pqrstuvwxyzABCDEFG123HIJKLM45NOPQRST6789UVWXYZ';
    $string = '';
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
}

/* End of file random_helper.php */
/* Location: ./application/helpers/random_helper.php */