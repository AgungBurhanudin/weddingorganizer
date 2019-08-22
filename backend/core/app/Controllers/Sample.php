<?php

namespace Controllers;

use Resources,
    Models;

class Sample extends Resources\Controller {

    public function upload() {

        $this->upload = new Resources\Upload;
        $arr_setting = array(
            'folderLocation' => 'C:\\logs\\',
            'autoRename' => true,
            'permittedFileType' => 'gif|png|jpg|pdf',
            'maximumSize' => 1000000);

        $this->upload->setOption($arr_setting);

        if (isset($_FILES['my_file'])) {
            $file = $this->upload->now($_FILES['my_file']);
            if ($file) {
                echo $this->upload->getFileInfo()['name'];
            } else {
                print_r($this->upload->getError('message'));
            }
        }
    }

    public function uploadFile() {
        $db = new Models\Databases();
        $this->upload = new Resources\Upload;
        $arr_setting = array(
            'folderLocation' => 'C:\\uploadfile\\',
            'autoRename' => true,
            'permittedFileType' => 'xls|xlsx',
            'maximumSize' => 1000000);

        $this->upload->setOption($arr_setting);

        if (isset($_FILES['my_file'])) {
            $file = $this->upload->now($_FILES['my_file']);
            if ($file) {
              $name_file = $this->upload->getFileInfo()['name'];
              $sql = "BEGIN TRANSACTION;"
                    ."INSERT INTO tbl_upload_file (nama_file,status) VALUES ('$name_file','1');"
                    ."COMMIT;";
              $db->singleRow($sql);
                echo $this->upload->getFileInfo()['name'];
            } else {
                print_r($this->upload->getError('message'));
            }
        }
    }

}
