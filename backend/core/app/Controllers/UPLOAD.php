<?php

namespace Controllers;

use Resources,
    Models;

class UPLOAD extends Resources\Controller {

    public function uploadImage() {
        $db = new Models\Databases();

        $param = $_POST['detail']['detail'];
        $param2 = $_POST['detail'];

        $r = json_encode($param);
        $r2 = json_encode($param2);
        $jreq = json_decode($r);
        $req = json_decode($r2);
        //print_r ($req->noid);

        $noid = $req->noid;
        $username = strtoupper($jreq->username);
        $token = $req->token;
        $tipebrowser = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        $appid_browser = $req->appid;
        $secClient = substr(base64_encode($appid_browser . $tipebrowser), 15, 50) . '#' . $appid_browser;
        $appid = $secClient;
        $interface = 'WEB';
        $time_sess = '60';
        $ip = getenv('REMOTE_ADDR');
        //cek session
        $db->cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip);

        $table = 'tbl_mutasi';

        $response = array('cek' => 'gagal');
        // INSERT ALL
        if (!empty($_FILES['upload_ktp']) && !empty($_FILES['upload_ijasah'])) {

            $newfilename = "KTP_" . str_replace("'", "`", $jreq->nama) . "_" . date('dmY') . rand() . "_" . str_replace(" ", "", basename($_FILES["upload_ktp"]["name"]));
            $file1 = move_uploaded_file($_FILES["upload_ktp"]["tmp_name"], "../../public/images/" . $newfilename);
            $newfilename2 = "IJASAH_" . str_replace("'", "`", $jreq->nama) . "_" . date('dmY') . rand() . "_" . str_replace(" ", "", basename($_FILES["upload_ijasah"]["name"]));
            $file2 = move_uploaded_file($_FILES["upload_ijasah"]["tmp_name"], "../../public/images/" . $newfilename2);

            if ($file1 && $file2) {

                $id_mutasi = $jreq->id_mutasi;
                $nama = strtoupper(str_replace("'", "`", $jreq->nama));
                $pangkat = strtoupper($jreq->pangkat);
                $tempat_lahir = strtoupper($jreq->tempat_lahir);
                $tanggal_lahir = $jreq->tanggal_lahir;
                $agama = strtoupper($jreq->agama);
                $ijasah = $jreq->ijasah;
                $ijasah_a = $jreq->ijasah_a;
                $ijasah_b = $jreq->ijasah_b;
                $alamat = $jreq->alamat;
                $jabatan = strtoupper($jreq->jabatan);
                $nama_istri_suami = strtoupper($jreq->nama_istri_suami);
                $tempat_lahir_istri_suami = strtoupper($jreq->tempat_lahir_istri_suami);
                $tgl_lahir_istri_suami = $jreq->tanggal_lahir_istri_suami;
                $agama_istri_suami = strtoupper($jreq->agama_istri_suami);
                $tgl_nikah_istri_suami = $jreq->tgl_nikah_istri_suami;
                $pekerjaan_istri_suami = strtoupper($jreq->pekerjaan_istri_suami);
                $foto_ktp = $newfilename;
                $foto_ijasah = $newfilename2;

                $query = "BEGIN TRANSACTION;"
                        . "INSERT INTO $table (id_mutasi,nama, pangkat, tempat_lahir, tanggal_lahir, agama, ijasah, ijasah_a, ijasah_b, jabatan, alamat, nama_istri_suami, tempat_lahir_istri_suami, tanggal_lahir_istri_suami, agama_istri_suami, tgl_nikah_istri_suami, pekerjaan_istri_suami, foto_ktp,foto_ijasah) VALUES"
                        . "('$id_mutasi','$nama', '$pangkat', '$tempat_lahir', '$tanggal_lahir', '$agama', '$ijasah', '$ijasah_a', '$ijasah_b', '$jabatan', '$alamat', '$nama_istri_suami', '$tempat_lahir_istri_suami','$tgl_lahir_istri_suami', '$agama_istri_suami', '$tgl_nikah_istri_suami', '$pekerjaan_istri_suami','$foto_ktp', '$foto_ijasah');"
                        . "COMMIT;";
                $db->singleRow($query);

                $response = array(
                    'response_code' => '0000',
                    'response_message' => "Input Data Berhasil"
                );
            } else {
                $response = array(
                    'response_code' => '0099',
                    'response_message' => "Gagal Upload Foto KTP"
                );
            }
        }
        // INSERT SALAH SATU
        else if (!empty($_FILES['upload_ktp']) || !empty($_FILES['upload_ijasah'])) {

            if (isset($_FILES["upload_ktp"]["name"])) {
                $newfilename = "KTP_" . str_replace("'", "`", $jreq->nama) . "_" . date('dmY') . rand() . "_" . str_replace(" ", "", basename(@$_FILES["upload_ktp"]["name"]));
                $file1 = move_uploaded_file(@$_FILES["upload_ktp"]["tmp_name"], "../../public/images/" . $newfilename);
            } else {
                $newfilename = NULL;
                $file1 = '';
            }
            if (isset($_FILES["upload_ijasah"]["name"])) {
                $newfilename2 = "IJASAH_" . str_replace("'", "`", $jreq->nama) . "_" . date('dmY') . rand() . "_" . str_replace(" ", "", basename(@$_FILES["upload_ijasah"]["name"]));
                $file2 = move_uploaded_file(@$_FILES["upload_ijasah"]["tmp_name"], "../../public/images/" . $newfilename2);
            } else {
                $newfilename2 = NULL;
                $file2 = '';
            }

            if ($file1 || $file2) {
                $id_mutasi = $jreq->id_mutasi;
                $nama = strtoupper(str_replace("'", "`", $jreq->nama));
                $pangkat = strtoupper($jreq->pangkat);
                $tempat_lahir = strtoupper($jreq->tempat_lahir);
                $tanggal_lahir = $jreq->tanggal_lahir;
                $agama = strtoupper($jreq->agama);
                $ijasah = $jreq->ijasah;
                $ijasah_a = $jreq->ijasah_a;
                $ijasah_b = $jreq->ijasah_b;
                $alamat = $jreq->alamat;
                $jabatan = strtoupper($jreq->jabatan);
                $nama_istri_suami = strtoupper($jreq->nama_istri_suami);
                $tempat_lahir_istri_suami = strtoupper($jreq->tempat_lahir_istri_suami);
                $tgl_lahir_istri_suami = $jreq->tanggal_lahir_istri_suami;
                $agama_istri_suami = strtoupper($jreq->agama_istri_suami);
                $tgl_nikah_istri_suami = $jreq->tgl_nikah_istri_suami;
                $pekerjaan_istri_suami = strtoupper($jreq->pekerjaan_istri_suami);

                $foto_ktp = $newfilename;
                $foto_ijasah = $newfilename2;

                $query = "BEGIN TRANSACTION;"
                        . "INSERT INTO $table (id_mutasi,nama, pangkat, tempat_lahir, tanggal_lahir, agama, ijasah, ijasah_a, ijasah_b, jabatan, alamat, nama_istri_suami, tempat_lahir_istri_suami, tanggal_lahir_istri_suami, agama_istri_suami, tgl_nikah_istri_suami, pekerjaan_istri_suami, foto_ktp,foto_ijasah) VALUES"
                        . "('$id_mutasi','$nama', '$pangkat', '$tempat_lahir', '$tanggal_lahir', '$agama', '$ijasah', '$ijasah_a', '$ijasah_b', '$jabatan', '$alamat', '$nama_istri_suami', '$tempat_lahir_istri_suami','$tgl_lahir_istri_suami', '$agama_istri_suami', '$tgl_nikah_istri_suami', '$pekerjaan_istri_suami','$foto_ktp', '$foto_ijasah');"
                        . "COMMIT;";
                $db->singleRow($query);

                $response = array(
                    //'name_file' => $this->upload->getFileInfo()['name'],
                    'response_code' => '0000',
                    'response_message' => "Berhasil Input Data"
                );
            } else {
                //print_r($this->upload->getError('message'));
                $response = array(
                    'response_code' => '0099',
                    'response_message' => "Gagal Input Data"
                );
            }
        } else {

            $id_mutasi = $jreq->id_mutasi;
            $nama = strtoupper(str_replace("'", "`", $jreq->nama));
            $pangkat = strtoupper($jreq->pangkat);
            $tempat_lahir = strtoupper($jreq->tempat_lahir);
            $tanggal_lahir = $jreq->tanggal_lahir;
            $agama = strtoupper($jreq->agama);
            $ijasah = $jreq->ijasah;
            $ijasah_a = $jreq->ijasah_a;
            $ijasah_b = $jreq->ijasah_b;
            $alamat = $jreq->alamat;
            $jabatan = strtoupper($jreq->jabatan);
            $nama_istri_suami = strtoupper($jreq->nama_istri_suami);
            $tempat_lahir_istri_suami = strtoupper($jreq->tempat_lahir_istri_suami);
            $tgl_lahir_istri_suami = $jreq->tanggal_lahir_istri_suami;
            $agama_istri_suami = strtoupper($jreq->agama_istri_suami);
            $tgl_nikah_istri_suami = $jreq->tgl_nikah_istri_suami;
            $pekerjaan_istri_suami = strtoupper($jreq->pekerjaan_istri_suami);

            $query = "BEGIN TRANSACTION;"
                    . "INSERT INTO $table (id_mutasi,nama, pangkat, tempat_lahir, tanggal_lahir, agama, ijasah, ijasah_a, ijasah_b, jabatan, alamat, nama_istri_suami, tempat_lahir_istri_suami, tanggal_lahir_istri_suami, agama_istri_suami, tgl_nikah_istri_suami, pekerjaan_istri_suami) VALUES"
                    . "('$id_mutasi','$nama', '$pangkat', '$tempat_lahir', '$tanggal_lahir', '$agama', '$ijasah', '$ijasah_a', '$ijasah_b', '$jabatan', '$alamat', '$nama_istri_suami', '$tempat_lahir_istri_suami','$tgl_lahir_istri_suami', '$agama_istri_suami', '$tgl_nikah_istri_suami', '$pekerjaan_istri_suami');"
                    . "COMMIT;";

            $cekid = $db->cekIdMutasi($id_mutasi);

            if (!isset($cekid->id)) {

                $db->singleRow($query);

                $response = array(
                    'response_code' => '0000',
                    'response_message' => "Berhasil Input data Pegawai dengan nama : $nama"
                );
            } else {
                $response = array(
                    'response_code' => '0099',
                    'response_message' => "Gagal Input data Pegawai, Coba beberapa saat lagi"
                );
            }
        }
        echo json_encode($response);
    }

    public function updateImage() {

        $db = new Models\Databases();
        $param = $_POST['detail']['detail'];
        $param2 = $_POST['detail'];

        $r = json_encode($param);
        $r2 = json_encode($param2);
        $jreq = json_decode($r);
        $req = json_decode($r2);

        $noid = $req->noid;
        $username = $req->username;
        $token = $req->token;
        $tipebrowser = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        $appid_browser = $req->appid;
        $secClient = substr(base64_encode($appid_browser . $tipebrowser), 15, 50) . '#' . $appid_browser;
        $appid = $secClient;
        $interface = 'WEB';
        $time_sess = '60';
        $ip = getenv('REMOTE_ADDR');
        //cek session
        $db->cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip);

        $table = 'tbl_mutasi';



        if (!empty($_FILES['upload_ktp']) && !empty($_FILES['upload_ijasah'])) {
            if (isset($_FILES["upload_ktp"]["name"])) {
                $newfilename = "KTP_" . str_replace("'", "`", $jreq->nama) . "_" . date('dmY') . rand() . "_" . str_replace(" ", "", basename(@$_FILES["upload_ktp"]["name"]));
                $file1 = move_uploaded_file(@$_FILES["upload_ktp"]["tmp_name"], "../../public/images/" . $newfilename);
            } else {
                $newfilename = NULL;
                $file1 = '';
            }
            if (isset($_FILES["upload_ijasah"]["name"])) {
                $newfilename2 = "IJASAH_" . str_replace("'", "`", $jreq->nama) . "_" . date('dmY') . rand() . "_" . str_replace(" ", "", basename(@$_FILES["upload_ijasah"]["name"]));
                $file2 = move_uploaded_file(@$_FILES["upload_ijasah"]["tmp_name"], "../../public/images/" . $newfilename2);
            } else {
                $newfilename2 = NULL;
                $file2 = '';
            }

            if ($file1 && $file2) {
                $id_mutasi = $jreq->id_mutasi;
                $nama = strtoupper(str_replace("'", "`", $jreq->nama));
                $pangkat = strtoupper($jreq->pangkat);
                $tempat_lahir = strtoupper($jreq->tempat_lahir);
                $tanggal_lahir = $jreq->tanggal_lahir;
                $agama = strtoupper($jreq->agama);
                $ijasah = $jreq->ijasah;
                $ijasah_a = $jreq->ijasah_a;
                $ijasah_b = $jreq->ijasah_b;
                $alamat = $jreq->alamat;
                $jabatan = strtoupper($jreq->jabatan);
                $nama_istri_suami = strtoupper($jreq->nama_istri_suami);
                $tempat_lahir_istri_suami = strtoupper($jreq->tempat_lahir_istri_suami);
                $tgl_lahir_istri_suami = $jreq->tanggal_lahir_istri_suami;
                $agama_istri_suami = strtoupper($jreq->agama_istri_suami);
                $tgl_nikah_istri_suami = $jreq->tgl_nikah_istri_suami;
                $pekerjaan_istri_suami = strtoupper($jreq->pekerjaan_istri_suami);

                $foto_ktp = $newfilename;
                $foto_ijasah = $newfilename2;


                $query = "BEGIN TRANSACTION;"
                        . "UPDATE $table SET "
                        . "nama='$nama', pangkat='$pangkat', tempat_lahir='$tempat_lahir',tanggal_lahir ='$tanggal_lahir', agama='$agama', ijasah='$ijasah', ijasah_a='$ijasah_a', ijasah_b='$ijasah_b',"
                        . "jabatan='$jabatan', alamat='$alamat', nama_istri_suami='$nama_istri_suami', tempat_lahir_istri_suami='$tempat_lahir_istri_suami',tanggal_lahir_istri_suami='$tgl_lahir_istri_suami',"
                        . "agama_istri_suami='$agama_istri_suami', tgl_nikah_istri_suami='$tgl_nikah_istri_suami', pekerjaan_istri_suami='$pekerjaan_istri_suami', foto_ktp='$foto_ktp',foto_ijasah ='$foto_ijasah' WHERE (id_mutasi='$id_mutasi');"
                        . "COMMIT;";

                $getid = $db->cekId($table, 'id_mutasi', $id_mutasi);

                @unlink('../../public/images/' . $getid->foto_ktp);
                @unlink('../../public/images/' . $getid->foto_ijasah);
                $db->singleRow($query);

                $response = array(
                    'response_code' => '0000',
                    'response_message' => "Berhasil Update Data"
                );
            } else {
                $response = array(
                    'response_code' => '0099',
                    'response_message' => "Gagal Update Data"
                );
            }
        } elseif (!empty($_FILES['upload_ktp']) || !empty($_FILES['upload_ijasah'])) {
            $id_mutasi = $jreq->id_mutasi;
            if (isset($_FILES["upload_ktp"]["name"])) {
                $getid = $db->cekId($table, 'id_mutasi', $id_mutasi);
                @unlink('../../public/images/' . $getid->foto_ktp);

                $newfilename = "KTP_" . str_replace("'", "`", $jreq->nama) . "_" . date('dmY') . rand() . "_" . str_replace(" ", "", basename(@$_FILES["upload_ktp"]["name"]));
                $file1 = move_uploaded_file(@$_FILES["upload_ktp"]["tmp_name"], "../../public/images/" . $newfilename);
                $getQuery = ",foto_ktp = '$newfilename'";
            } else {
                $newfilename = NULL;
                $file1 = '';
                $getQuery = '';
            }
            if (isset($_FILES["upload_ijasah"]["name"])) {
                $getid = $db->cekId($table, 'id_mutasi', $id_mutasi);
                @unlink('../../public/images/' . $getid->foto_ijasah);

                $newfilename2 = "IJASAH_" . str_replace("'", "`", $jreq->nama) . "_" . date('dmY') . rand() . "_" . str_replace(" ", "", basename(@$_FILES["upload_ijasah"]["name"]));
                $file2 = move_uploaded_file(@$_FILES["upload_ijasah"]["tmp_name"], "../../public/images/" . $newfilename2);
                $getQuery2 = ",foto_ijasah = '$newfilename2'";
            } else {
                $newfilename2 = NULL;
                $file2 = '';
                $getQuery2 = '';
            }

            if ($file1 || $file2) {
                $nama = strtoupper(str_replace("'", "`", $jreq->nama));
                $pangkat = strtoupper($jreq->pangkat);
                $tempat_lahir = strtoupper($jreq->tempat_lahir);
                $tanggal_lahir = $jreq->tanggal_lahir;
                $agama = strtoupper($jreq->agama);
                $ijasah = $jreq->ijasah;
                $ijasah_a = $jreq->ijasah_a;
                $ijasah_b = $jreq->ijasah_b;
                $alamat = $jreq->alamat;
                $jabatan = strtoupper($jreq->jabatan);
                $nama_istri_suami = strtoupper($jreq->nama_istri_suami);
                $tempat_lahir_istri_suami = strtoupper($jreq->tempat_lahir_istri_suami);
                $tgl_lahir_istri_suami = $jreq->tanggal_lahir_istri_suami;
                $agama_istri_suami = strtoupper($jreq->agama_istri_suami);
                $tgl_nikah_istri_suami = $jreq->tgl_nikah_istri_suami;
                $pekerjaan_istri_suami = strtoupper($jreq->pekerjaan_istri_suami);

                $foto_ktp = $newfilename;
                $foto_ijasah = $newfilename2;

                $query = "BEGIN TRANSACTION;"
                        . "UPDATE $table SET "
                        . "nama='$nama', pangkat='$pangkat', tempat_lahir='$tempat_lahir',tanggal_lahir ='$tanggal_lahir', agama='$agama', ijasah='$ijasah', ijasah_a='$ijasah_a', ijasah_b='$ijasah_b',"
                        . "jabatan='$jabatan', alamat='$alamat', nama_istri_suami='$nama_istri_suami', tempat_lahir_istri_suami='$tempat_lahir_istri_suami',tanggal_lahir_istri_suami='$tgl_lahir_istri_suami',"
                        . "agama_istri_suami='$agama_istri_suami', tgl_nikah_istri_suami='$tgl_nikah_istri_suami', pekerjaan_istri_suami='$pekerjaan_istri_suami' $getQuery $getQuery2 WHERE (id_mutasi='$id_mutasi');"
                        . "COMMIT;";

                $db->singleRow($query);
                $response = array(
                    'response_code' => '0000',
                    'response_message' => "Berhasil Update Data"
                );
            } else {
                $response = array(
                    'response_code' => '0099',
                    'response_message' => "Gagal Update Data"
                );
            }
        } else {

            $id_mutasi = $jreq->id_mutasi;
            $nama = strtoupper(str_replace("'", "`", $jreq->nama));
            $pangkat = strtoupper($jreq->pangkat);
            $tempat_lahir = strtoupper($jreq->tempat_lahir);
            $tanggal_lahir = $jreq->tanggal_lahir;
            $agama = strtoupper($jreq->agama);
            $ijasah = $jreq->ijasah;
            $ijasah_a = $jreq->ijasah_a;
            $ijasah_b = $jreq->ijasah_b;
            $alamat = $jreq->alamat;
            $jabatan = strtoupper($jreq->jabatan);
            $nama_istri_suami = strtoupper($jreq->nama_istri_suami);
            $tempat_lahir_istri_suami = strtoupper($jreq->tempat_lahir_istri_suami);
            $tgl_lahir_istri_suami = $jreq->tanggal_lahir_istri_suami;
            $agama_istri_suami = strtoupper($jreq->agama_istri_suami);
            $tgl_nikah_istri_suami = $jreq->tgl_nikah_istri_suami;
            $pekerjaan_istri_suami = strtoupper($jreq->pekerjaan_istri_suami);

            $query = "BEGIN TRANSACTION;"
                    . "UPDATE $table SET "
                    . "nama='$nama', pangkat='$pangkat', tempat_lahir='$tempat_lahir',tanggal_lahir ='$tanggal_lahir', agama='$agama', ijasah='$ijasah', ijasah_a='$ijasah_a', ijasah_b='$ijasah_b',"
                    . "jabatan='$jabatan', alamat='$alamat', nama_istri_suami='$nama_istri_suami', tempat_lahir_istri_suami='$tempat_lahir_istri_suami',tanggal_lahir_istri_suami='$tgl_lahir_istri_suami',"
                    . "agama_istri_suami='$agama_istri_suami', tgl_nikah_istri_suami='$tgl_nikah_istri_suami', pekerjaan_istri_suami='$pekerjaan_istri_suami' WHERE (id_mutasi='$id_mutasi');"
                    . "COMMIT;";

            $cekid = $db->cekIdMutasi($id_mutasi);

            if (isset($cekid->id)) {

                $db->singleRow($query);

                $response = array(
                    'response_code' => '0000',
                    'response_message' => "Berhasil Update data Pegawai dengan nama : $nama"
                );
            } else {
                $response = array(
                    'response_code' => '0099',
                    'response_message' => "Gagal Update data Pegawai, Coba beberapa saat lagi"
                );
            }
        }
        echo json_encode($response);
    }

}
