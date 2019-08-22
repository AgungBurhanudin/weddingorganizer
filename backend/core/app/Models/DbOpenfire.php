<?php

namespace Models;

use Resources,
    Libraries;

class DbOpenfire {

    public function __construct() {
        $this->dbVa = new Resources\Database('openfire');
    }

    public function singleRow($sql) {
        return $this->dbVa->row($sql);
    }

    public function multipleRow($sql) {
        return $this->dbVa->results($sql);
    }
    
}
