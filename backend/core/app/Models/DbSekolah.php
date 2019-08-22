<?php

namespace Models;

use Resources,
    Libraries;

class DbSekolah
{

    public function __construct()
    {
        $this->dbSekolah = new Resources\Database('sekolah');
        $this->error     = new Libraries\ResponseError;
    }

    public function singleRow($sql)
    {
        return $this->dbSekolah->row($sql);
    }

    public function multipleRow($sql)
    {
        return $this->dbSekolah->results($sql);
    }

    public function cekId($table, $nameRow, $id)
    {
        $sql_cek = "select * from $table where $nameRow = '$id'";
        return $this->dbSekolah->row($sql_cek);
    }

    public function cekRowCount($table, $nameRow, $id)
    {
        $sql_cek = "select count($nameRow) as count from $table where $nameRow = '$id'";
        return $this->dbSekolah->row($sql_cek);
    }

    public function deleteRow($table, $nameRow, $value)
    {
        $sql_cek = "delete from $table where $nameRow = '$value'";
        return $this->dbSekolah->row($sql_cek);
    }
}
