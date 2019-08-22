<?php

$fungsi = new Libraries\fungsi;
$dbSekolah = new Models\DbSekolah();
$table  = "tbl_buku";

switch ($action_request) {

    case "add": // Start Add data

        $noid           = $jreq->noid;
        $noid_content   = $fungsi->get_unique_id('BOOK');
        $title          = strtoupper($jreq->detail->title);
        $highlight      = $jreq->detail->highlight;
        $stock          = $jreq->detail->stock;

        $content        = json_encode($jreq->detail->content);
        $tags           = json_encode($jreq->detail->tags);

        if (isset($_FILES['images'])) {
            foreach ($_FILES['images']['name'] as $key => $val) {
                //echo $key;
                $line = count($_FILES['images']['name'][$key]);
                //echo $line;
                for ($i = 0; $i < $line; $i++) {
                    //$file = $this->upload->now($_FILES['images'][$i]);
                    $ext       = explode(".", $_FILES["images"]["name"][$key][$i]);
                    $file_name = $key . "_" . $title . "_" . $i . "." . end($ext);
                    $file_name = str_replace(" ", "_", $file_name);
                    if (move_uploaded_file($_FILES["images"]["tmp_name"][$key][$i], "../../public/images/" . $file_name)) {
                        $foto_name[$key][] = $file_name;
                        //echo $this->upload->getFileInfo()['images'][$i];
                    } else {
                        //print_r($this->upload->getError('message'));
                    }
                }
            }
        }

        if (isset($foto_name)) {
            $images = json_encode($foto_name);
        } else {
            $images = "{}";
        }

        if (isset($_FILES['files'])) {
            foreach ($_FILES['files']['name'] as $key => $val) {
                //echo $key;
                $line = count($_FILES['files']['name'][$key]);
                //echo $line;
                for ($i = 0; $i < $line; $i++) {
                    //$file = $this->upload->now($_FILES['files'][$i]);
                    $ext       = explode(".", $_FILES["files"]["name"][$key][$i]);
                    $file_name = $key . "_" . $title . "_" . $i . "." . end($ext);
                    $file_name = str_replace(" ", "_", $file_name);
                    if (move_uploaded_file($_FILES["files"]["tmp_name"][$key][$i], "../../public/files/" . $file_name)) {
                        $name_file[$key][] = $file_name;
                        //echo $this->upload->getFileInfo()['files'][$i];
                    } else {
                        //print_r($this->upload->getError('message'));
                    }
                }
            }
        }

        if (isset($name_file)) {
            $files = json_encode($name_file);
        } else {
            $files = "{}";
        }

        $query = "BEGIN TRANSACTION;"
            . "INSERT INTO $table (id_buku, noid, title, highligth, contents, tags, images, files, stock) "
            . " VALUES ('$noid_content', '$noid','$title', '$highlight', '$content', '$tags', '$images', '$files' ,'$stock');"
            . "COMMIT;";

        $arr = $dbSekolah->cekId($table, 'id_buku', $noid_content);

        if (!isset($arr->id)) {
            $dbSekolah->singlerow($query);
            $response = array(
                'response_code'    => '0000',
                'response_message' => 'Tambah data Buku Berhasil',
            );
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => 'Tambah data Buku Gagal',
            );
        }
        $reply = json_encode($response);
        break; // End Add Data

    case "edit": // Start Update Data

        $noid_content  = $jreq->detail->noid_content;
        $title     = strtoupper($jreq->detail->title);
        $highlight = $jreq->detail->highlight;
        $stock          = $jreq->detail->stock;

        $content   = json_encode($jreq->detail->content);
        $tags      = json_encode($jreq->detail->tags);

        $images = $jreq->detail->images;

        $query = "BEGIN TRANSACTION;"
            . "UPDATE $table SET  title='$title', highligth='$highlight', contents ='$content', tags = '$tags', stock = '$stock'"
            . " WHERE (id_buku='$noid_content');"
            . "COMMIT;";

        $arr = $dbSekolah->cekId($table, 'id_buku', $noid_content);

        if (isset($arr->id)) {
            $dbSekolah->singlerow($query);
            $response = array(
                'response_code'    => '0000',
                'response_message' => 'Edit data Buku Berhasil',
            );
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => 'Edit data Buku Gagal',
            );
        }
        $reply = json_encode($response);
        break; // End Update Data

    case "delete": // Start Delete Data

        $noid_content = $jreq->detail->noid_content;

        $arr = $dbSekolah->cekId($table, 'id_buku', $noid_content);

        if (isset($arr->id)) {
            $dbSekolah->deleteRow($table, 'id_buku', $noid_content);
            $response = array(
                'response_code'    => '0000',
                'response_message' => "Berhasil Menghapus Data Buku",
            );
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => 'Gagal Menghapus Buku.',
            );
        }
        $reply = json_encode($response);
        break; // end delete Data

    case "add_foto":
        $noid_content = $jreq->detail->noid_content;
        $arr      = $dbSekolah->cekId($table, 'id_buku', $noid_content);

        if (isset($arr->id)) {
            $title    = $arr->title;
            $old_foto = $arr->images;
            $old_foto = json_decode($old_foto);
            $old_foto = (array) $old_foto;

            if (isset($_FILES['images'])) {
                foreach ($_FILES['images']['name'] as $key => $val) {
                    $line = count($_FILES['images']['name'][$key]);
                    for ($i = 0; $i < $line; $i++) {
                        $ext       = explode(".", $_FILES["images"]["name"][$key][$i]);
                        $file_name = $key . "_" . $title . "_" . rand(0, 1000) . "." . end($ext);
                        $file_name = str_replace(" ", "_", $file_name);
                        if ($_FILES["images"]["name"][$key][$i] != "") {
                            if (move_uploaded_file($_FILES["images"]["tmp_name"][$key][$i], "../../public/images/" . $file_name)) {
                                $old_foto[$key][] = $file_name;
                            }
                        }
                    }
                }
            }
        }

        $jnew_foto = json_encode($old_foto);
        $query     = "BEGIN TRANSACTION;"
            . "UPDATE $table SET images = '$jnew_foto' "
            . "WHERE id_buku = '$noid_content'; "
            . "COMMIT;";

        $arr = $dbSekolah->cekId($table, 'id_buku', $noid_content);

        if (isset($arr->id)) {
            $dbSekolah->singlerow($query);
            $response = array(
                'response_code'    => '0000',
                'response_message' => 'Tambah Foto Contents Berhasil',
            );
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => 'Tambah Foto Contents Gagal',
            );
        }
        $reply = json_encode($response);
        break; // End Add Foto

    case "delete_foto":
        $noid_content   = $jreq->detail->noid_content;
        $nama_foto      = $jreq->detail->nama_foto;
        $grup_foto      = $jreq->detail->grup_foto;

        $arr            = $dbSekolah->cekId($table, 'id_buku', $noid_content);
        $new_foto       = array();
        if (isset($arr->id)) {
            $old_foto   = $arr->images;
            $old_foto   = json_decode($old_foto);
            $old_foto   = (array) $old_foto;
            $new_foto   = $fungsi->removeElementWithValue($old_foto, $grup_foto, $nama_foto);
            $jnew_foto  = json_encode($new_foto);

            $query = "BEGIN TRANSACTION;"
                . "UPDATE $table SET images = '$jnew_foto' "
                . "WHERE id_buku = '$noid_content'; "
                . "COMMIT;";

            if (file_exists("../../public/images/" . $nama_foto)) {
                unlink("../../public/images/" . $nama_foto);
            }

            $dbSekolah->singlerow($query);
            $response = array(
                'response_code'    => '0000',
                'response_message' => "Berhasil Menghapus Data Buku",
            );
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => 'Gagal Menghapus Data Buku.',
            );
        }
        $reply = json_encode($response);

        break;

        
    case "add_file":
        $noid_content = $jreq->detail->noid_content;
        $arr      = $dbSekolah->cekId($table, 'id_buku', $noid_content);

        if (isset($arr->id)) {
            $title    = $arr->title;
            $old_file = $arr->files;
            $old_file = json_decode($old_file);
            $old_file = (array) $old_file;

            if (isset($_FILES['files'])) {
                foreach ($_FILES['files']['name'] as $key => $val) {
                    $line = count($_FILES['files']['name'][$key]);
                    for ($i = 0; $i < $line; $i++) {
                        $ext       = explode(".", $_FILES["files"]["name"][$key][$i]);
                        $file_name = $key . "_" . $title . "_" . rand(0, 1000) . "." . end($ext);
                        $file_name = str_replace(" ", "_", $file_name);
                        if ($_FILES["files"]["name"][$key][$i] != "") {
                            if (move_uploaded_file($_FILES["files"]["tmp_name"][$key][$i], "../../public/files/" . $file_name)) {
                                $old_file[$key][] = $file_name;
                            }
                        }
                    }
                }
            }
        }

        $jnew_file = json_encode($old_file);
        $query     = "BEGIN TRANSACTION;"
            . "UPDATE $table SET files = '$jnew_file' "
            . "WHERE id_buku = '$noid_content'; "
            . "COMMIT;";

        //$arr = $dbSekolah->cekId($table, 'id', $noid_content);

        if (isset($arr->id)) {
            $dbSekolah->singlerow($query);
            $response = array(
                'response_code'    => '0000',
                'response_message' => 'Perubahan file Buku Berhasil',
            );
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => 'Perubahan file Buku Gagal',
            );
        }
        $reply = json_encode($response);
        break; // End Add file

    case "delete_file":
        $noid_content   = $jreq->detail->noid_content;
        $nama_file      = $jreq->detail->nama_file;
        $grup_file      = $jreq->detail->grup_file;

        $arr            = $dbSekolah->cekId($table, 'id_buku', $noid_content);
        $new_file       = array();
        if (isset($arr->id)) {
            $old_file   = $arr->files;
            $old_file   = json_decode($old_file);
            $old_file   = (array) $old_file;
            $new_file   = $fungsi->removeElementWithValue($old_file, $grup_file, $nama_file);
            $jnew_file  = json_encode($new_file);

            $query = "BEGIN TRANSACTION;"
                . "UPDATE $table SET files = '$jnew_file' "
                . "WHERE id_buku = '$noid_content'; "
                . "COMMIT;";

            if (file_exists("../../public/files/" . $nama_file)) {
                unlink("../../public/files/" . $nama_file);
            }

            $dbSekolah->singlerow($query);
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
        $reply = json_encode($response);

        break;

    case "search" : 
        $search = $jreq->detail->key_search;

        $query = "SELECT * FROM tbl_buku WHERE title LIKE '%$search%' 
                    OR highlight LIKE '%$search%'";

        $data_buku = $dbSekolah->multipleRow($query);
        if (!empty($data_pinjaman)) {
            $response = array(
                'response_code'    => '0000',
                'response_message' => "Data Di temukan",
                'detail'           => json_encode($data_buku),
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
