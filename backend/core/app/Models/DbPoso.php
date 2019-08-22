<?php

namespace Models;

use Resources,
    Libraries;

class DbPoso {

    public function __construct() {
        $this->dbPoso = new Resources\Database('xposo');
        
    }

    public function singleRow($sql) {
        return $this->dbPoso->row($sql);
    }

    public function multipleRow($sql) {
        return $this->dbPoso->results($sql);
    }

}
