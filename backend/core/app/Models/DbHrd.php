<?php

namespace Models;

use Resources,
    Libraries;

class DbHrd {

    public function __construct() {
        $this->dbHrd = new Resources\Database('xhrd');
        
    }

    public function singleRow($sql) {
        return $this->dbHrd->row($sql);
    }

    public function multipleRow($sql) {
        return $this->dbHrd->results($sql);
    }

}
