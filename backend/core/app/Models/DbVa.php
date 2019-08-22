<?php

namespace Models;

use Resources,
    Libraries;

class DbVa {

    public function __construct() {
        $this->dbVa = new Resources\Database('xva');
    }

    public function singleRow($sql) {
        return $this->dbVa->row($sql);
    }

    public function multipleRow($sql) {
        return $this->dbVa->results($sql);
    }
    
    public function cekNomorVaBnis($nova) {
        $sql_cek = "select * from tbl_nomor_va_bnis where nomor_va = '$nova';";
        return $this->dbVa->row($sql_cek);
    }
    
}
