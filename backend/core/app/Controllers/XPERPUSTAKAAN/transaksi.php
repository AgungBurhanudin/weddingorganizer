<?php

$fungsi   = new Libraries\fungsi;
$dbSekolah = new Models\DbSekolah();
$table    = "tbl_buku";

switch ($action_request) {

    case "pinjam":
        $noid       = $jreq->detail->noid;

        $create     = date('Y-m-d H:i:s');
        $id_buku    = $jreq->detail->id_buku;
        $jml_pinjam = $jreq->detail->jml_pinjam;
        for ($ii = 0; $ii < count($id_buku); $ii++) {
            $arr = $dbSekolah->cekId($table, 'id_buku', $id_buku[$i]);
            if (!empty($arr)) {
                $id_transaksi = $fungsi->get_unique_id('TRX');
                $stock        = $arr->stock;
                $status       = ($jml_pinjam == $stock) ? 1 : 0;

                $query = "BEGIN TRANSACTION;
		        		UPDATE $table SET stock = '$stock', status = '$status' WHERE id_buku = '$id_buku[$i]';
						INSERT INTO tbl_transaksi(id_transaksi,noid, id_buku, jumlah_pinjam, waktu_pinjam, status)
						VALUES ('$id_transaksi', '$noid',' $id_buku[$i]',' $jml_pinjam[$i]' , '$create', '0');
		        		COMMIT;";

                $dbSekolah->singleRow($query);
                $response = array(
                    'response_code'    => '0000',
                    'response_message' => "Berhasil Menambah Peminjaman Buku",
                );
            } else {
                $response = array(
                    'response_code'    => '0099',
                    'response_message' => 'Gagal Menambha Peminjaman Buku.',
                );
            }
        }
        $reply = json_encode($response);
        break;

    case "cek_pinjaman":
        $noid = $jreq->detail->noid;

        $query = "SELECT a.*,b.* FROM tbl_transaksi a LEFT JOIN tbl_buku b on a.id_buku = b.id WHERE a.noid = '$noid' AND b.status = 0";

        $data_pinjaman = $dbSekolah->multipleRow($query);
        if (!empty($data_pinjaman)) {
            $response = array(
                'response_code'    => '0000',
                'response_message' => "Data Di temukan",
                'detail'           => json_encode($data_pinjaman),
            );
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => 'Data tidak di temukan',
            );
        }
        $reply = json_encode($response);
        break;

    case "kembali":
        $id_transaksi = $jreq->detail->id_transaksi;
        $noid         = $jreq->detail->noid;
        $create       = date('Y-m-d H:i:s');
        $id_buku      = $jreq->detail->id_buku;
        $jml_kembali  = $jreq->detail->jml_kembali;
        $tgl_kembali  = $jreq->detail->tgl_kembali;
        for ($ii = 0; $ii < count($id_transaksi); $ii++) {
            $arr = $dbSekolah->cekId($table, 'id_transaksi', $id_transaksi[$i]);
            if (!empty($arr)) {
                $sisa         = $arr->sisa_pinjam;
                $sisa_pinjam  = $sisa - $jml_kembali;

                $status       = ($sisa_pinjam == 0 ) ? 1 : 0;

                $pengembalian = $arr->pengembalian;
                $pengembalian = json_decode($pengembalian, true);

                $start_date   = new DateTime($arr->waktu_pinjam);
                $end_date     = new DateTime($arr->tgl_kembali);
                $interval     = $start_date->diff($end_date);
                $lama_pinjam  = $interval->days; // hasil : 217 hari

                if($lama_pinjam > 7){ //default lama pinjam 7 hari, jika lebih akan kena denda * 1000
                    $out_date = $lama_pinjam - 7;
                    $denda    = $out_date * 1000;
                }else{
                    $denda    = 0;
                }
                $lama_pinjam  = "";
                $data_pengembalian[] = array(
                	'tanggal_kembali' => $tgl_kembali,
                	'jumlah_kembali'  => $jml_kembali,
                	'denda'			  => $denda
                );

                if (!empty($pengembalian)) {
                    foreach ($pengembalian as $key => $value) {
                    	$pengembalian[$key] = array_merge($pengembalian, $data_pengembalian);                    	
                    }
                }else{
                	$pengembalian = $data_pengembalian;
                }
                $pengembalian = json_encode($pengembalian);


                $query = "BEGIN TRANSACTION;
		        		UPDATE $table SET pengembalian = '$pengembalian', status = '$status', sisa_pinjam = '$sisa_pinjam' WHERE id_transaksi = '$id_transaksi[$i]';
		        		COMMIT;";

                $dbSekolah->singleRow($query);
                $response = array(
                    'response_code'    => '0000',
                    'response_message' => "Berhasil Melakukan Pengembalian Buku",
                );
            } else {
                $response = array(
                    'response_code'    => '0099',
                    'response_message' => 'Gagal Melakukan Pengembalian Buku.',
                );
            }
        }
        $reply = json_encode($response);

        break;
}
;
