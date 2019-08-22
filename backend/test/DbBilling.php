<?php

namespace Models;

use Resources,
    Libraries;

class DbBilling {

    public function __construct() {
        $this->dbBilling = new Resources\Database('xbilling');
        
    }

    public function singleRow($sql) {
        return $this->dbBilling->row($sql);
    }

    public function multipleRow($sql) {
        return $this->dbBilling->results($sql);
    }

    public function cekIdTagihanVa($idtag) {
        $sql_cek = "select tgh.id,jenis_tagihan,idtagihan,idtagihan_name,tgh.noid,va.nomor_va,jatuh_tempo,"
                . "tgh.tagihan,tgh.admin_bank,tgh.total_tagihan,tgh.payment,tgh.open_payment,tgh.waktu_bayar "
                . "from tbl_tagihan tgh left join (select noid,nomor_va from tbl_nomor_va) as va on va.noid = tgh.idtagihan "
                . "where tgh.idtagihan = '$idtag';";
        return $this->dbBilling->row($sql_cek);
    }
    
    public function cekNomorVa($nova) {
        $sql_cek = "select * from tbl_nomor_va where nomor_va = '$nova';";
        return $this->dbBilling->row($sql_cek);
    }
    
    public function cekIdTagihan($idtag) {
        $sql_cek = "select * from tbl_tagihan where idtagihan = '$idtag';";
        return $this->dbBilling->row($sql_cek);
    }
    
}
