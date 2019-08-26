<?php


require_once 'Vcard/class.vCard.inc.php';
require_once 'phpqrcode/qrlib.php';

class QRCodeLib extends vCard
{
    var $filename;
    
    //set it to writable location, a place for temp generated PNG files
    var $PNG_TEMP_DIR;
    
    //html PNG location prefix
    var $PNG_WEB_DIR;
    
    var $dir = 'files/qrcode';
    
    var $errorCorrectionLevel = 'L';
    var $matrixPointSize = 2; 
    var $size = 1;
    var $margin;
    
    var $error;

    public function __construct()
    {
        parent::__construct();
    }

    function setFileName($filename)
    {
        $this->filename = $filename;
        return $this;
    }

    function getFileName()
    {
        if (trim($this->filename) == '')
            $this->filename = "QRCode_" . date('Y-m-d_H-i-s') . ".png";
        return $this->filename;
    }
    
    /**
     * set error correction level
     * @param int (0-3) or string L,M,Q,H
     */
    function setErrorCorrectionLevel($errorCorrectionLevel = 'L')
    {
        $this->errorCorrectionLevel = $errorCorrectionLevel;
        return $this;
    }
    
    function setMatrixPointSize($matrixPointSize = 4)
    {
        $this->matrixPointSize = $matrixPointSize;
        return $this;
    }
    
    /**
     * set size
     * @param int (1-10)
     */
    function setSize($size)
    {
        $this->size = $size;
        return $this;
    }
    
    function setMargin($margin)
    {
        $this->margin = $margin;
        return $this;
    }
    
    function setDir($dir)
    {
        $this->dir = $dir;
        return $this;
    }
    
    function getError()
    {
        return $this->error;
    }

    /**
     * generate image file (PNG)
     * @param string data
     */
    function generateImage($data)
    {
        try {
            $this->PNG_TEMP_DIR = $this->dir.DIRECTORY_SEPARATOR;
            $this->PNG_WEB_DIR = $this->dir.'/';
            //ofcourse we need rights to create temp dir
            if (!file_exists($this->PNG_TEMP_DIR))
                mkdir($this->PNG_TEMP_DIR);
                
            QRcode::png($data, $this->PNG_TEMP_DIR.$this->getFileName(), $this->errorCorrectionLevel, $this->matrixPointSize, $this->size, $this->margin);
            return true;
        }
        catch (exception $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }
    
    public function getImageFilePath()
    {
        return $this->PNG_WEB_DIR.$this->filename;
    }
}
