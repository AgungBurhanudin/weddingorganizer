<?php

namespace Models;

use Resources,
    Libraries;

class DbAlamat {

    public function __construct() {
        $this->dbAlamat = new Resources\Database('alamat');
        
    }

    public function singleRow($sql) {
        return $this->dbAlamat->row($sql);
    }

    public function multipleRow($sql) {
        return $this->dbAlamat->results($sql);
    }

}
