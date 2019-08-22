<?php

class App_model extends CI_Model {
   
    function getUrutanAcaraField($id) {
        $row = $this->db->query("SELECT max(urutan) as last from acara_field WHERE id_acara_tipe = '$id'")->row();
        if(!empty($row)){
            return $row->last + 1;
        }else{
            return 1;
        }
    }
    
    function getUrutanTambahanField($id) {
        $row = $this->db->query("SELECT max(urutan) as last from tambahan_field WHERE id_tambahan_tipe = '$id'")->row();
        if(!empty($row)){
            return $row->last + 1;
        }else{
            return 1;
        }
    }
    
    function getUrutanUpacaraField($id) {
        $row = $this->db->query("SELECT max(urutan) as last from upacara_field WHERE id_upacara_tipe = '$id'")->row();
        if(!empty($row)){
            return $row->last + 1;
        }else{
            return 1;
        }
    }
    
    function getUrutanUpacaraKegiatan($id) {
        $row = $this->db->query("SELECT max(urutan) as last from upacara_tipe WHERE id_upacara = '$id'")->row();
        if(!empty($row)){
            return $row->last + 1;
        }else{
            return 1;
        }
    }
    
    function getUrutanPanitiaField($id) {
        $row = $this->db->query("SELECT max(urutan) as last from panitia_field WHERE id_panitia_tipe = '$id'")->row();
        if(!empty($row)){
            return $row->last + 1;
        }else{
            return 1;
        }
    }

}
?>
