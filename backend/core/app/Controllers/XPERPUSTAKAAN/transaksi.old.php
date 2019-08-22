<?php

$fungsi   = new Libraries\fungsi;
$dbPerpus = new Models\DbPerpustakaan();
$table    = "tbl_buku";

switch ($action_request) {

    case "pinjam":
        $noid       = $jreq->detail->noid;
        $create     = date('Y-m-d H:i:s');
        $id_buku    = $jreq->detail->id_buku;
        $jml_pinjam = $jreq->detail->jml_pinjam;
        for ($ii = 0; $ii < count($id_buku); $ii++) {
            $arr = $dbPerpus->cekId($table, 'id_buku', $id_buku[$i]);
            if (!empty($arr)) {
                $alokasi      = $arr->stock;
                $stock_detail = $arr->stock_detail;
                $stock_detail = json_decode($stock_detail, true);

                $current_stock[$noid][] = array(
                    'pinjam'     => $create,
                    'kembali'    => "",
                    //'alokasi'    => $alokasi,
                    'jml_pinjam' => $jml_pinjam[$i],
                    //'stock'      => $alokasi - $jml_pinjam,
                );

                foreach ($stock_detail as $key => $value) {
                    foreach ($current_stock as $key2 => $value2) {
                        if ($key2 == $key) {
                            $stock_detail[$key] = array_merge($value, $value2);
                        }
                    }
                }
                //$new_stock = array_merge($stock_detail, $current_stock);

                $query = "BEGIN TRANSACTION;
		        		UPDATE $table SET stock_detail = '$stock_detail', status = 1 WHERE id_buku = '$id_buku[$i]';
						INSERT INTO tbl_transaksi(noid, id_buku, jumlah_pinjam, waktu_pinjam, status) VALUES ('$noid',' $id_buku[$i]',' $jml_pinjam[$i]' , '$create', '0');
		        		COMMIT;";

                $dbPerpus->singleRow($query);
                $response = array(
                    'response_code'    => '0000',
                    'response_message' => "Berhasil Menghapus Data Files Buku",
                );
            } else {
                $response = array(
                    'response_code'    => '0099',
                    'response_message' => 'Gagal Menghapus Files Buku.',
                );
            }
        }
        $reply = json_encode($response);
        break;

    case "cek_pinjaman":
        $noid = $jreq->detail->noid;

        $query = "SELECT a.*,b.* FROM tbl_transaksi a LEFT JOIN tbl_buku b on a.id_buku = b.id WHERE a.noid = '$noid' AND b.status = 0";

        $data_pinjaman = $dbPerpus->multipleRow($query);
        if (!empty($data_pinjaman)) {
            $response = array(
                'response_code'    => '0000',
                'response_message' => "Data Di temukan",
                'detail' => $data_pinjaman
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
        $noid       = $jreq->detail->noid;
        $create     = date('Y-m-d H:i:s');
        $id_buku    = $jreq->detail->id_buku;
        $jml_kembali= $jreq->detail->jml_kembali;
        for ($ii = 0; $ii < count($id_buku); $ii++) {
            $arr = $dbPerpus->cekId($table, 'id_buku', $id_buku[$i]);
            if (!empty($arr)) {
                //$alokasi      = $arr->stock;
                $stock_detail = $arr->stock_detail;
                $stock_detail = json_decode($stock_detail, true);

                foreach ($stock_detail as $key => $value) {
                    if($key == $noid){

                    }
                }
                //$new_stock = array_merge($stock_detail, $current_stock);

                $query = "BEGIN TRANSACTION;
		        		UPDATE $table SET stock_detail = '$stock_detail', status = 1 WHERE id_buku = '$id_buku[$i]';
						UPDATE tbl_transaksi SET status = 1 WHERE id;
		        		COMMIT;";

                $dbPerpus->singleRow($query);
                $response = array(
                    'response_code'    => '0000',
                    'response_message' => "Berhasil Menghapus Data Files Buku",
                );
            } else {
                $response = array(
                    'response_code'    => '0099',
                    'response_message' => 'Gagal Menghapus Files Buku.',
                );
            }
        }
        $reply = json_encode($response);

        break;
}
;
