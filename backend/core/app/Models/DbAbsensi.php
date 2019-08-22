<?php

namespace Models;

use Resources,
    Libraries;

class DbAbsensi {

    public function __construct() {
        $this->dbAbsensi = new Resources\Database('absensi');
        
    }

    public function singleRow($sql) {
        return $this->dbAbsensi->row($sql);
    }

    public function multipleRow($sql) {
        return $this->dbAbsensi->results($sql);
    }

}
