<?php

namespace Models;

use Resources,
    Libraries;

class DbBmt {

    public function __construct() {
        $this->dbBmt = new Resources\Database('xbmt');
        
    }

    public function singleRow($sql) {
        return $this->dbBmt->row($sql);
    }

    public function multipleRow($sql) {
        return $this->dbBmt->results($sql);
    }

}
