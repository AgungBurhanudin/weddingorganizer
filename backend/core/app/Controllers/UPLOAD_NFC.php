<?php

namespace Controllers;

use Libraries;
use Models;
use Resources;

class UPLOAD_NFC extends Resources\Controller
{

    public function ADDMOBILE()
    {
        //OK
        $db = new Models\Databases();

        $fungsi = new Libraries\Fungsi;
        $wLog   = new Libraries\WriteLog;
        $konfig = new Libraries\Konfigurasi;
        $error  = new Libraries\ResponseError;

        if (!empty($_POST)) {

            $arr = $_POST;
            foreach ($arr as $v1) {
                $noid     = $v1['noid'];
                $username = strtoupper($v1['username']);
                $token    = $v1['token'];
                $appid    = $v1['appid'];

                $interface_add = 'MOBILE';
                $noid_add      = $v1['detail']['noid'];
                $nama_add      = strtoupper($v1['detail']['nama']);
                $alias_add     = strtoupper($v1['detail']['alias']);
                $passw_add     = $v1['detail']['passw'];
                $limit_trx_add = $v1['detail']['limit_trx'];
            }
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => "Terjadi Kesalahan Sistem !",
            );
            echo json_encode($response);
            die();
        }

        $tipebrowser   = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        $appid_browser = $appid;
        $secClient     = substr(base64_encode($appid_browser . $tipebrowser), 15, 50) . '#' . $appid_browser;
        $appid         = $secClient;
        $time_sess     = '60';
        $ip            = getenv('REMOTE_ADDR');
        $interface     = 'MOBILE';

        //cek session
        $db->cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip);

        $arr_member        = $db->cekNoidMember($noid);
        $nama_member       = $arr_member->nama;
        $tipe_member       = $arr_member->tipe;
        $jenis_member      = $arr_member->jenis;
        $saldo_member      = $arr_member->saldo;
        $nohp_email_member = $arr_member->nohp_email;

        $arr_cek_alias = $db->cekAliasChannel($alias_add);

        $msg_out = "Registrasi Kartu NFC " . $konfig->namaAplikasi() . " telah berhasil. UID:$alias_add a.n $nama_add "
            . "PIN Transaksi=$passw_add dengan limit transaksi per hari $limit_trx_add";

        if (($noid_add == $noid) || (substr($noid_add, 0, 7) == substr($noid, 0, 7) && $tipe_member == 'M2')) {

        } else {
            $error->regAccountTidakBerhak($saldo_member);
        }

        $nohp_email_member = '';
        //print_r($_FILES['upload_image']);
        $filetypes        = array("image/jpeg", "image/gif", "image/png");
        $MAXIMUM_FILESIZE = 5 * 1024 * 1024;

        if (!empty($_FILES['upload_image'])) {
            $arr_cek_alias = $db->cekAliasChannel($alias_add);
            $newfilename   = "photoIdentity_" . str_replace("'", "`", $nama_add) . "_" . date('dmY') . rand() . "_" . str_replace(" ", "", basename($_FILES["upload_image"]["name"]));
            //check image
            if ($_FILES['upload_image']['size'] <= $MAXIMUM_FILESIZE && in_array($_FILES['upload_image']['type'], $filetypes)) {
                move_uploaded_file($_FILES["upload_image"]["tmp_name"], "../../public/photoIdentity/" . $newfilename);
            } else {
                $response = array(
                    'response_code'    => '0099',
                    'response_message' => "Maaf,Data Yang Anda Masukkan Tidak Valid",
                );
                echo json_encode($response);
            }

            if (!isset($arr_cek_alias->id)) {

                $sql = "BEGIN TRANSACTION;"
                    . "insert into tbl_member_channel (interface,noid,alias,reg_date,last_used,passw,nama,email,limit_trx,photo_identity) values "
                    . "('NFC','$noid_add','$alias_add',now(),now(),'$passw_add','$nama_add','$nohp_email_member','$limit_trx_add','$newfilename');"
                    . "COMMIT;";

                $db->singleRow($sql);
                $db->kirimMessage($noid_add, $msg_out);
                $response = array(
                    'response_code'    => '0000',
                    'response_message' => "Sukses Registrasi $interface_add $nama_add",
                );
                echo json_encode($response);
            } else {
                $error->regAccountAliasTerdaftar($saldo_member);
            }
        } else {

            $sql = "BEGIN TRANSACTION;"
                . "insert into tbl_member_channel (interface,noid,alias,reg_date,last_used,passw,nama,email,limit_trx) values "
                . "('$interface_add','$noid_add','$alias_add',now(),now(),'$passw_add','$nama_add','$nohp_email_member',$limit_trx_add);"
                . "COMMIT;";

            $db->singleRow($sql);
            $db->kirimMessage($noid_add, $msg_out);
            $response = array(
                'response_code'    => '0000',
                'response_message' => "Sukses Registrasi $interface_add $nama_add",
            );
            echo json_encode($response);
        }
    }

    public function UPDATEMOBILE()
    {
        $db = new Models\Databases();

        $fungsi = new Libraries\Fungsi;
        $wLog   = new Libraries\WriteLog;
        $konfig = new Libraries\Konfigurasi;
        $error  = new Libraries\ResponseError;

        if (!empty($_POST)) {

            $arr = $_POST;
            foreach ($arr as $v1) {
                $noid     = $v1['noid'];
                $username = strtoupper($v1['username']);
                $token    = $v1['token'];
                $appid    = $v1['appid'];

                $id_add    = $v1['detail']['id'];
                $nama_add  = strtoupper($v1['detail']['nama']);
                $alias_add = strtoupper($v1['detail']['limit_trx']);
            }
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => "Terjadi Kesalahan Sistem !",
            );
            echo json_encode($response);
            die();
        }

        $tipebrowser   = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        $appid_browser = $appid;
        $secClient     = substr(base64_encode($appid_browser . $tipebrowser), 15, 50) . '#' . $appid_browser;
        $appid         = $secClient;
        $time_sess     = '60';
        $ip            = getenv('REMOTE_ADDR');
        $interface     = 'MOBILE';

        //cek session
        $db->cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip);

        $arr_member        = $db->cekNoidMember($noid);
        $nama_member       = $arr_member->nama;
        $tipe_member       = $arr_member->tipe;
        $jenis_member      = $arr_member->jenis;
        $saldo_member      = $arr_member->saldo;
        $nohp_email_member = $arr_member->nohp_email;

        $arr_cek_alias = $db->cekAliasChannel($alias_add);

        if (($noid_add == $noid) || (substr($noid_add, 0, 7) == substr($noid, 0, 7) && $tipe_member == 'M2')) {

        } else {
            $error->regAccountTidakBerhak($saldo_member);
        }

        $nohp_email_member = '';

        $rEFileTypes      = "/^\.(jpg|jpeg|gif|png){1}$/i";
        $MAXIMUM_FILESIZE = 5 * 1024 * 1024;
        $file             = $_FILES['upload_image'];

        if (!empty($file)) {
            $getid = $db->cekId('tbl_member_channel', 'id', $id_add);
            if (isset($getid->id)) {
                //change Image Name
                $newfilename = "photoIdentity_" . str_replace("'", "`", $nama_add) . "_" . date('dmY') . rand() . "_" . str_replace(" ", "", basename($_FILES["upload_image"]["name"]));
                //check image
                if ($_FILES['upload_image']['size'] <= $MAXIMUM_FILESIZE && in_array($_FILES['upload_image']['type'], $filetypes)) {
                    move_uploaded_file($_FILES["upload_image"]["tmp_name"], "../../public/photoIdentity/" . $newfilename);
                    unlink('../../public/photoIdentity/' . $getid->photo_identity);
                } else {
                    $response = array(
                        'response_code'    => '0099',
                        'response_message' => "Maaf,Data Yang Anda Masukkan Tidak Valid",
                    );
                    echo json_encode($response);
                }

                $query = "BEGIN TRANSACTION;"
                    . "UPDATE tbl_member_channel set nama = '$nama_add', limit_trx = '$limit_trx_add',photo_identity = '$newfilename'"
                    . "WHERE id = '$id_add';"
                    . "COMMIT;";
                $db->singleRow($query);

                $response = array(
                    'response_code'    => '0000',
                    'response_message' => 'UPDATE DATA NFC BERHASIL',
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'response_code'    => '0099',
                    'response_message' => "Terjadi Kesalahan Sistem !",
                );
                echo json_encode($response);
                die();
            }
        } else {
            $getid = $db->cekId('tbl_member_channel', 'id', $id_add);
            if (isset($getid->id)) {
                $query = "BEGIN TRANSACTION;"
                    . "UPDATE tbl_member_channel set nama = '$nama_add', limit_trx = '$limit_trx_add'"
                    . "WHERE id = '$id_add';"
                    . "COMMIT;";
                $db->singleRow($query);

                $response = array(
                    'response_code'    => '0000',
                    'response_message' => 'UPDATE DATA NFC BERHASIL',
                );
                echo json_encode($response);
            } else {
                $response = array(
                    'response_code'    => '0099',
                    'response_message' => "Terjadi Kesalahan Sistem !",
                );
                echo json_encode($response);
                die();
            }
        }
    }

    public function CHECKMOBILE()
    {
        $db = new Models\Databases();

        $fungsi = new Libraries\Fungsi;
        $wLog   = new Libraries\WriteLog;
        $konfig = new Libraries\Konfigurasi;
        $error  = new Libraries\ResponseError;

        if (!empty($_POST)) {

            $arr = $_POST;
            foreach ($arr as $v1) {
                $noid     = $v1['noid'];
                $username = strtoupper($v1['username']);
                $token    = $v1['token'];
                $appid    = $v1['appid'];

                $alias_add = strtoupper($v1['detail']['alias']);
            }
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => "Terjadi Kesalahan Sistem !",
            );
            echo json_encode($response);
            die();
        }

        $tipebrowser   = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        $appid_browser = $appid;
        $secClient     = substr(base64_encode($appid_browser . $tipebrowser), 15, 50) . '#' . $appid_browser;
        $appid         = $secClient;
        $time_sess     = '60';
        $ip            = getenv('REMOTE_ADDR');
        $interface     = 'MOBILE';

        //cek session
        $db->cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip);

        $arr_member        = $db->cekNoidMember($noid);
        $nama_member       = $arr_member->nama;
        $tipe_member       = $arr_member->tipe;
        $jenis_member      = $arr_member->jenis;
        $saldo_member      = $arr_member->saldo;
        $nohp_email_member = $arr_member->nohp_email;

        $arr_cek_alias = $db->cekAliasChannel($alias_add);

        if (($noid_add == $noid) || (substr($noid_add, 0, 7) == substr($noid, 0, 7) && $tipe_member == 'M2')) {

        } else {
            $error->regAccountTidakBerhak($saldo_member);
        }

        $arr = $db->cekId('tbl_member_channel', 'alias', $alias_add);
        if (isset($arr->id) && $arr->interface == "MOBILE") {

            $response = array(
                'response_code'    => '0000',
                'response_message' => 'CEK DATA BERHASIL',
                'noid'             => $arr->noid,
                'nama'             => $arr->nama,
                'alias'            => $arr->alias,
                'limit_trx'        => $arr->limit_trx,
                'photo_identity'   => $arr->photo_identity,
            );
        } else {
            $error->accountTidakAda($saldo_member);
        }
        echo json_encode($response);
    }

    public function DELETEMOBILE()
    {
        $db = new Models\Databases();

        $fungsi = new Libraries\Fungsi;
        $wLog   = new Libraries\WriteLog;
        $konfig = new Libraries\Konfigurasi;
        $error  = new Libraries\ResponseError;

        if (!empty($_POST)) {

            $arr = $_POST;
            foreach ($arr as $v1) {
                $noid     = $v1['noid'];
                $username = strtoupper($v1['username']);
                $token    = $v1['token'];
                $appid    = $v1['appid'];

                $alias_add = strtoupper($v1['detail']['alias']);
            }
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => "Terjadi Kesalahan Sistem !",
            );
            echo json_encode($response);
            die();
        }

        $tipebrowser   = getenv('HTTP_USER_AGENT') . getenv('HTTP_ACCEPT_LANGUAGE');
        $appid_browser = $appid;
        $secClient     = substr(base64_encode($appid_browser . $tipebrowser), 15, 50) . '#' . $appid_browser;
        $appid         = $secClient;
        $time_sess     = '60';
        $ip            = getenv('REMOTE_ADDR');
        $interface     = 'MOBILE';

        //cek session
        $db->cekSession($noid, $interface, $username, $token, $appid, $time_sess, $ip);

        $arr_member        = $db->cekNoidMember($noid);
        $nama_member       = $arr_member->nama;
        $tipe_member       = $arr_member->tipe;
        $jenis_member      = $arr_member->jenis;
        $saldo_member      = $arr_member->saldo;
        $nohp_email_member = $arr_member->nohp_email;

        $arr_cek_alias = $db->cekAliasChannel($alias_add);

        if (($noid_add == $noid) || (substr($noid_add, 0, 7) == substr($noid, 0, 7) && $tipe_member == 'M2')) {

        } else {
            $error->regAccountTidakBerhak($saldo_member);
        }

        $arr = $db->cekId('tbl_member_channel', 'alias', $alias_add);
        if (isset($arr->id) && $arr->interface == "MOBILE") {

            $query = "BEGIN TRANSACTION;"
                . "DELETE from tbl_member_channel where alias = '$alias_add';"
                . "COMMIT;";

            // remove file
            unlink('../../public/photoIdentity/' . $arr->photo_identity);
            $db->singleRow($query);

            $response = array(
                'response_code'    => '0000',
                'response_message' => "HAPUS DATA BERHASIL",
            );
            echo json_encode($response);
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => "Terjadi Kesalahan Sistem, Silahkan Hubungi Administrator",
            );
            echo json_encode($response);
        }
    }

}
