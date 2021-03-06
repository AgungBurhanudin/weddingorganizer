<?php

$fungsi    = new Libraries\fungsi;
$dbSekolah = new Models\DbSekolah();
$table     = "tbl_siswa";

switch ($action_request) {

    case "add": // Start Add data

        $nis           = $jreq->detail->nis;
        $nama          = $jreq->detail->nama;
        $nfc_id        = $jreq->detail->nfc_id;
        $nama          = $jreq->detail->nama;
        $alamat        = $jreq->detail->alamat;
        $jenis_kelamin = $jreq->detail->jenis_kelamin;
        $tempat_lahir  = $jreq->detail->tempat_lahir;
        $tanggal_lahir = $jreq->detail->tanggal_lahir;
        $agama         = $jreq->detail->agama;
        $kelas         = $jreq->detail->kelas;
        $keterangan    = $jreq->detail->keterangan;

        $foto_name = "";
        if (isset($_FILES['images']) && !empty($_FILES['images'])) {
            $ext       = explode(".", $_FILES["images"]["name"]);
            $file_name = $key . "_" . $title . "_" . $i . "." . end($ext);
            $file_name = str_replace(" ", "_", $file_name);
            if (move_uploaded_file($_FILES["images"]["tmp_name"], "../../public/images/" . $file_name)) {
                $foto_name = $file_name;
                //echo $this->upload->getFileInfo()['images'][$i];
            } else {
                //print_r($this->upload->getError('message'));
            }
        }

        $query = "BEGIN TRANSACTION;"
            . "INSERT INTO $table (nis, nama, nfc_id, nama, alamat, jenis_kelamin, tempat_lahir, tanggal_lahir, agama, kelas, keterangan, images) "
            . " VALUES ('$nis', '$nama','$nfc_id', '$nama', '$alamat', '$jenis_kelamin', '$tempat_lahir', '$tanggal_lahir' ,'$agama', '$keterangan', '$foto_name');"
            . "COMMIT;";

        $arr = $dbSekolah->cekId($table, 'id_buku', $noid_content);

        if (!isset($arr->id)) {
            $dbSekolah->singlerow($query);
            $response = array(
                'response_code'    => '0000',
                'response_message' => 'Tambah data Siswa Berhasil',
            );
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => 'Tambah data Siswa Gagal',
            );
        }
        $reply = json_encode($response);
        break; // End Add Data

    case "edit": // Start Update Data

        $id            = $jreq->detail->id;
        $nis           = $jreq->detail->nis;
        $nama          = $jreq->detail->nama;
        $nfc_id        = $jreq->detail->nfc_id;
        $nama          = $jreq->detail->nama;
        $alamat        = $jreq->detail->alamat;
        $jenis_kelamin = $jreq->detail->jenis_kelamin;
        $tempat_lahir  = $jreq->detail->tempat_lahir;
        $tanggal_lahir = $jreq->detail->tanggal_lahir;
        $agama         = $jreq->detail->agama;
        $kelas         = $jreq->detail->kelas;
        $keterangan    = $jreq->detail->keterangan;

        $query = "BEGIN TRANSACTION;"
            . "UPDATE $table SET nis='$nis', nama='$nama', nfc_id ='$nfc_id', nama = '$nama', alamat = '$alamat', jenis_kelamin = '$jenis_kelamin'
            , tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', agama = '$agama', kelas = '$kelas' , keterangan = '$keterangan'"
            . " WHERE (id='$id');"
            . "COMMIT;";

        $arr = $dbSekolah->cekId($table, 'id', $id);

        if (isset($arr->id)) {
            $dbSekolah->singlerow($query);
            $response = array(
                'response_code'    => '0000',
                'response_message' => 'Edit data Siswa Berhasil',
            );
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => 'Edit data Siswa Gagal',
            );
        }
        $reply = json_encode($response);
        break; // End Update Data

    case "delete": // Start Delete Data

        $id = $jreq->detail->id;

        $arr = $dbSekolah->cekId($table, 'id', $id);

        if (isset($arr->id)) {
            $dbSekolah->deleteRow($table, 'id', $id);
            $response = array(
                'response_code'    => '0000',
                'response_message' => "Berhasil Menghapus Data Siswa",
            );
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => 'Gagal Menghapus Siswa.',
            );
        }
        $reply = json_encode($response);
        break; // end delete Data

    case "edit_foto":
        $id        = $jreq->detail->id;
        $nama_foto = $jreq->detail->images;
        $arr       = $dbSekolah->cekId($table, 'id', $id);

        if (file_exists("../../public/images/" . $nama_foto)) {
            unlink("../../public/images/" . $nama_foto);
        }
        $file_name = "";
        if (isset($arr->id)) {

            if (isset($_FILES['images'])) {
                $ext       = explode(".", $_FILES["images"]["name"]);
                $file_name = $key . "_" . $title . "_" . rand(0, 1000) . "." . end($ext);
                $file_name = str_replace(" ", "_", $file_name);
                if ($_FILES["images"]["name"] != "") {
                    if (move_uploaded_file($_FILES["images"]["tmp_name"], "../../public/images/" . $file_name)) {
                        $old_foto[$key][] = $file_name;
                    }
                }
            }
        }

        $jnew_foto = json_encode($old_foto);
        $query     = "BEGIN TRANSACTION;"
            . "UPDATE $table SET images = '$file_name' "
            . "WHERE id = '$id'; "
            . "COMMIT;";

        $arr = $dbSekolah->cekId($table, 'id', $id);

        if (isset($arr->id)) {
            $dbSekolah->singlerow($query);
            $response = array(
                'response_code'    => '0000',
                'response_message' => 'Edit Foto Siswa Berhasil',
            );
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => 'Edit Foto Siswa Gagal',
            );
        }
        $reply = json_encode($response);
        break; // End Add Foto


    case "search":
        $search = $jreq->detail->key_search;

        $query = "SELECT * FROM tbl_siswa WHERE nis LIKE '%$search%'
                    OR nama LIKE '%$search%'";

        $data_siswa = $dbSekolah->multipleRow($query);
        if (!empty($data_pinjaman)) {
            $response = array(
                'response_code'    => '0000',
                'response_message' => "Data Di temukan",
                'detail'           => json_encode($data_siswa),
            );
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => 'Data tidak di temukan',
            );
        }
        $reply = json_encode($response);
        break;

}
;
