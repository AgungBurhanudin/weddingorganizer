<?php

namespace Models;

use Resources,
    Libraries;

class DbPerpustakaan {

    public function __construct() {
        $this->dbPerpustakaan = new Resources\Database('perpustakaan');
        
    }

    public function singleRow($sql) {
        return $this->dbPerpustakaan->row($sql);
    }

    public function multipleRow($sql) {
        return $this->dbPerpustakaan->results($sql);
    }

    public function cekId($table, $nameRow, $id) {
        $sql_cek = "select * from $table where $nameRow = '$id'";
        return $this->db->row($sql_cek);
    }

}
