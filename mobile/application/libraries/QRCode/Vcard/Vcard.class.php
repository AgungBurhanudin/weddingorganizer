<?php

if (!defined('GTFW_APP_DIR'))
    exit('No direct script access allowed');

require_once 'class.vCard.inc.php';

class GT_Vcard extends vCard {

    var $filename;

    public function __construct() {
        parent::__construct('files/vcard');
    }

    function setVersion($version) {
        $this->version = $version;
        return $this;
    }

    function setFileName($filename) {
        $this->filename = $filename;
        return $this;
    }

    function getFileName() {
        if (trim($this->filename) == '')
            $this->filename = "vCard_" . date('Y-m-d_H-m-s') . ".vcf";
        $this->card_filename = $this->filename;
        return $this->filename;
    }

    function save() {
        try {
            header('Content-Type: text/x-vcard');
            header('Content-Disposition: inline; filename=' . $this->getFileName());
            echo $this->getCardOutput();
            exit;
        } catch (exception $e) {
            die($e->getMessage());
        }
    }
    
    function write($content) {
        $handle = fopen($this->download_dir . '/' . $this->getFileName(), 'w');
        fputs($handle, $content);
        fclose($handle);
        $this->deleteOldFiles(30);
        if (isset($handle)) {
            unset($handle);
        }
    }

}
