<?php

namespace Libraries;

use Resources;

class WriteLog {

    public static function writeLog($interface, $name, $request) {
        date_default_timezone_set("Asia/Bangkok");
        $tgl = date("Y-m-d");
        //$path = 'C:\\logs\\';
        $path = '/var/www/log_request/';
        if (!is_dir($path . $tgl)) {
            mkdir($path.$tgl, 0777, true);
        }

        $filename = $path.$tgl.'\\'.$interface . '_' . $name . '.txt';
        $fh = fopen($filename, "a") or fopen($filename, "w");
        fwrite($fh, date("d-m-Y, H:i") . "\n$request\n\n") or die("Could not write file!");
        fclose($fh);
    }

}
