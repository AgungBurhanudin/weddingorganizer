<?php

namespace Controllers;

use Resources,
    Libraries,
    Models;

class PRINTS extends Resources\Controller {

    public function __construct() {
        parent::__construct();
    }

    public function REQUEST($printType, $traceId) {
        $arr_data = explode('_', $traceId);
        foreach ($arr_data as $data) {
            if (is_numeric($data)) {
                echo $this->PREVIEW($printType, $data);
            } else {
                echo $this->DOCUMENTS($printType, $data);
            }
        }
    }

    public function PREVIEW($printType, $traceId) {
        $db = new Models\Databases();
        $sql = "update log_detail_trx set cetak = cetak + 1 where reff = '$traceId';"
                . "select noid,waktu::timestamp(0),cetak,struk,product,product_detail from log_detail_trx where reff = '$traceId' order by id desc limit 1";
        $arr_trx = $db->singleRow($sql);
        $content = '';
        if (isset($arr_trx->noid)) {
            if ($printType == 'DOTMATRIX') {
                $sql_tambah = "update tbl_member_account set printing = printing * -1 where noid = '$arr_trx->noid' returning printing;";
                $arr_tambah = $db->singleRow($sql_tambah);
                $tambah = $arr_tambah->printing;
                $tambahan = '';
                if ($tambah == 1) {
                    $tambahan = '
0x0';
                } else {
                    $tambahan = '';
                }
            }
            if ($arr_trx->product == 'PULSA') {
                include 'PRINTS/PULSA.php';
            } else {
                $operator = $arr_trx->product . '_' . $arr_trx->product_detail;
                include 'PRINTS/' . $operator . '.php';
            }
        } else {
            $content = "DATA TIDAK DITEMUKAN";
        }
        return $content;
    }

    public function DOCUMENTS($printType, $data) {
        //data = kolektif-4
        $arr_jenis = explode('-', preg_replace('/[^a-zA-Z0-9\-\_\#\@\ \.\,\:\"\]\[\}\{]/', '', $data));
        $jenis = $arr_jenis[0];
        include "DOCUMENTS/$jenis.php";
        echo $content;
    }

    public function CASHOUT($traceId) {
        $db = new Models\Databases();
        $fungsi = new Libraries\Fungsi();
        $config = new Libraries\Konfigurasi();
        $sql = "select waktu::timestamp(0) as waktu,saldo,detail from log_data_trx "
                . "where reff = '$traceId' and amount < 0 order by id desc limit 1";
        $arr_trx = $db->singleRow($sql);
        $content = '';
        if (isset($arr_trx->waktu)) {
            $jdetail = json_decode($arr_trx->detail);
            $content = ""
                    . "\n" . $config->namaAplikasi()
                    . "\n"
                    . "\n================================"
                    . "\nSTRUK TRANSAKSI"
                    . "\n--------------------------------"
                    . "\nMERCHANT  : " . $jdetail->idpel
                    . "\nWAKTU     : " . $arr_trx->waktu
                    . "\nNOMINAL   : " . $fungsi->rupiah($jdetail->amount)
                    . "\nSISA LIMIT: " . $fungsi->rupiah($jdetail->limit)
                    . "\nREFF      : " . $traceId
                    . "\nSISA SALDO: " . $fungsi->rupiah($arr_trx->saldo)
                    . "\n================================"
                    . "\n\n\n";
        }
        echo $content;
    }

    public function EXPORT($id_pembayaran){     
        require_once '../app/vendor/struk/Common/Func.php';
        $dbSekolah     = new Models\DbSekolah();
        
        $jenis         = isset($_GET['jenis']) ? $_GET['jenis'] : "";
        $query         = "SELECT a.*,b.nama,b.alamat,b.nama_wali,b.nohp_wali
                            FROM   tbl_tagihan a
                            LEFT JOIN tbl_siswa b ON a.id_pel = b.id
                            WHERE  a.pembayaran @> ANY (ARRAY ['[{\"id_pembayaran\":\"$id_pembayaran\"}]'::jsonb]);";

        $data_tagihan    = $dbSekolah->singleRow($query);
        $tanggal_tagihan = date('d-m-Y',strtotime($data_tagihan->tanggal));
        $jatuh_tempo     = date('d-m-Y',strtotime($data_tagihan->jatuh_tempo));
        $nama_wali       = $data_tagihan->nama_wali;
        $nohp_wali       = $data_tagihan->nohp_wali;
        $alamat          = $data_tagihan->alamat;
        $nama_tagihan    = $data_tagihan->nama_tagihan;
        $sisa_tagihan    = $data_tagihan->sisa_tagihan;
        $pembayaran      = $data_tagihan->pembayaran;
        $keterangan      = $data_tagihan->keterangan;

        $pembayaran       = json_decode($pembayaran, true);
        // print_r($pembayaran);
        $riwayat          = array();
        $total_bayar      = "";
        $tanggal_bayar    = "";
        $keterangan_bayar = "";
        foreach ($pembayaran as $key => $value) {
            if ($value['id_pembayaran'] == $id_pembayaran) {
                $total_bayar      = $value['total_bayar'];
                $tanggal_bayar    = date('d-m-Y',strtotime($value['tanggal_bayar']));
                $keterangan_bayar = $value['keterangan'];
            }
        }

        foreach ($pembayaran as $key => $value) {
            if (date('d-m-Y',strtotime($value['tanggal_bayar'])) <= $tanggal_bayar) {
                $value['tanggal_bayar'] = date('d-m-Y',strtotime($value['tanggal_bayar']));
                $riwayat[]      = $value;

            }
        }

        //$obj = json_decode($obj);


        $createdat = date('Y-m-d');//date_format(date('Y-m-d'), "Y-m-d H:i:s");

        $footer = "RESI INI ADALAH";
        $footer1 = "BUKTI PEMBAYARAN YANG SAH";
        if($sisa_tagihan == 0){
            $im = imagecreatefrompng("../app/vendor/struk/images/unpaid.png");
        }else{
            $im = imagecreatefrompng("../app/vendor/struk/images/unpaid.png");    
        }
        
        $black = imagecolorallocate($im, 0, 0, 0);
        $grey = imagecolorallocate($im, 211, 211, 211);

        // imagestring($im, 1, (imagesx($im) - 4 * strlen($id_trx)) / 2, 85, $id_trx, $black);
        // imagestring($im, 1, (imagesx($im) - 5 * strlen($createdat)) / 2, 95, $createdat, $black);
        // include '../app/vendor/struk/Template/invoice.php';
        include 'DOCUMENTS/invoice.php';



        imagestring($im, 1, (imagesx($im) + 20 ) / 2.5, imagesy($im) - 25, $footer, $black);
        imagestring($im, 1, (imagesx($im) + 50 ) / 3.5, imagesy($im) - 15, $footer1, $black);

        // echo $id_struk = $obj->product . $obj->product_detail . $id_trx;
        $image = '../app/vendor/struk/tmp_struk/' . $id_pembayaran . '.png';
        imagepng($im, $image);
        imagedestroy($im);
        //
        header("Content-type: image/png");
        readfile($image);
    }

}
