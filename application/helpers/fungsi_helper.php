<?php



    function getEnvironment()
    {
        return 'prod'; //prod or dev
    }

    function getCurlResult($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        return curl_exec($ch);
    }

    function randomString($length = 12)
    {
        $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ123456789';

        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    function randomNumber($length = 12)
    {
        $chars = '0123456789';

        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    function randomNumberTiket($length = 12)
    {
        $chars = '123456789';

        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    function merchantCode($merchant)
    {
        switch ($merchant) {
            case "DESKTOP":
                $kode = '6025'; //6021
                break;
            case "WEB":
                $kode = '6025'; //6021
                break;
            case "ANDROID":
                $kode = '6025';
                break;
            case "SMS":
                $kode = '6025'; //6023
                break;
            case "H2H":
                $kode = '6025';
            case "MOBILE":
                $kode = '6025';
            case "YM":
                $kode = '6025';
            case "JABBER":
                $kode = '6025';
                break;
        }
        return $kode;
    }

    function getNamaBulanShort($bulan)
    {
        switch ($bulan) {
            case "01":
                $kode = 'JAN';
                break;
            case "02":
                $kode = 'FEB';
                break;
            case "03":
                $kode = 'MAR';
                break;
            case "04":
                $kode = 'APR';
                break;
            case "05":
                $kode = 'MEI';
                break;
            case "06":
                $kode = 'JUN';
                break;
            case "07":
                $kode = 'JUL';
                break;
            case "08":
                $kode = 'AGU';
                break;
            case "09":
                $kode = 'SEP';
                break;
            case "10":
                $kode = 'OKT';
                break;
            case "11":
                $kode = 'NOV';
                break;
            case "12":
                $kode = 'DES';
                break;
        }
        return $kode;
    }

    function getNamaBulan($bulan)
    {
        switch ($bulan) {
            case "01":
                $kode = 'Januari';
                break;
            case "02":
                $kode = 'Februari';
                break;
            case "03":
                $kode = 'Maret';
                break;
            case "04":
                $kode = 'April';
                break;
            case "05":
                $kode = 'Mei';
                break;
            case "06":
                $kode = 'Juni';
                break;
            case "07":
                $kode = 'Juli';
                break;
            case "08":
                $kode = 'Agustus';
                break;
            case "09":
                $kode = 'September';
                break;
            case "10":
                $kode = 'Oktober';
                break;
            case "11":
                $kode = 'November';
                break;
            case "12":
                $kode = 'Desember';
                break;
        }
        return $kode;
    }

    function rupiah($rup)
    {
        $rup = number_format($rup + 0, 0, '', '.');
        return $rup;
    }

    function rupiahd($rup)
    {
        //rupiah desimal 2 digit
        $rup = number_format($rup + 0, 2, ',', '.');
        return $rup;
    }

    function rupiaht($rup)
    {
        //rupiah desimal 1 digit
        $rup = number_format($rup + 0, 1, ',', '.');
        return $rup;
    }

    function rupiahb($rup)
    {
        //rupiah lebih dari 1m
        if ($rup < 1000000000) {
            $rups = number_format($rup + 0, 0, '', '.');
        } else {
            $rups = substr($rup, 0, 1) . '.' . substr($rup, 1, 3) . '.' . substr($rup, 4, 3) . '.' . substr($rup, 7, 3);
        }
        return $rups;
    }

    function spasi($jml, $char)
    {
        $result  = '';
        $selisih = $jml - strlen($char);

        if ($selisih < 0) {
            $result = substr($char, 0, $jml);
        } else {
            $result = $char;

            for ($x = 1; $x <= $selisih; $x++) {
                $result = $result . ' ';
            }
        }

        return $result;
    }

    function spasiKanan($jml, $char)
    {
        $result  = '';
        $spasi   = '';
        $selisih = $jml - strlen($char);

        if ($selisih < 0) {
            $result = substr($char, 0, $jml);
        } else {
            $result = $char;

            for ($x = 1; $x <= $selisih; $x++) {
                $spasi = $spasi . ' ';
            }

            $result = $spasi . $result;
        }

        return $result;
    }

    // FUNGSI TERBILANG KE RUPIAH => http://harviacode.com/2014/09/23/membuat-fungsi-terbilang-php/
    function kekata($x)
    {
        $x     = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($x < 12) {
            $temp = " " . $angka[$x];
        } else if ($x < 20) {
            $temp = self::kekata($x - 10) . " belas";
        } else if ($x < 100) {
            $temp = self::kekata($x / 10) . " puluh" . self::kekata($x % 10);
        } else if ($x < 200) {
            $temp = " seratus" . self::kekata($x - 100);
        } else if ($x < 1000) {
            $temp = self::kekata($x / 100) . " ratus" . self::kekata($x % 100);
        } else if ($x < 2000) {
            $temp = " seribu" . self::kekata($x - 1000);
        } else if ($x < 1000000) {
            $temp = self::kekata($x / 1000) . " ribu" . self::kekata($x % 1000);
        } else if ($x < 1000000000) {
            $temp = self::kekata($x / 1000000) . " juta" . self::kekata($x % 1000000);
        } else if ($x < 1000000000000) {
            $temp = self::kekata($x / 1000000000) . " milyar" . self::kekata(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $temp = self::kekata($x / 1000000000000) . " trilyun" . self::kekata(fmod($x, 1000000000000));
        }
        return $temp;
    }

    function terbilang($x, $style = 4)
    {
        if ($x < 0) {
            $hasil = "minus " . trim(self::kekata($x));
        } else {
            $hasil = trim(self::kekata($x));
        }
        switch ($style) {
            case 1:
                $hasil = strtoupper($hasil);
                break;
            case 2:
                $hasil = strtolower($hasil);
                break;
            case 3:
                $hasil = ucwords($hasil);
                break;
            default:
                $hasil = ucfirst($hasil);
                break;
        }
        return $hasil;
    }

    function namaStrukKanan()
    {
        return '';
    }

    function namaStrukKiri()
    {
        return '';
    }

    function removeElementWithValue($array, $key, $value)
    {
        foreach ($array as $subKey => $subArray) {
            foreach ($subArray as $key => $val) {
                if ($val == $value) {
                    unset($array[$subKey][$key]);
                }
            }
        }
        return $array;
    }

    function get_unique_id($index = null)
    {
        if (!empty($index)) {
            $unique = uniqid($index);
        } else {
            $unique = uniqid('SUP');
        }
        return $unique;
    }

    function getNoHpEmail($nohpemail, $tipe){
        $data = explode("#", $nohpemail);
        $return = "";
        if(strtoupper($tipe) == "MEMBER"){
            $return = $data[0]; 
        }else if(strtoupper($tipe == "NOHP")){
            $return = $data[1];
        }
        return $return;

    }

    function getNumberOfDay($tanggal)
    {
        $arr_day  = array('Monday' => '1', 'Thursday' => '2', 'Wednesday' => '3', 'Tuesday' => '4', 'Friday' => '5', 'Saturday' => '6', 'Sunday' => '7');
        $arr_hari = array('Senin' => '1', 'Selasa' => '2', 'Rabu' => '3', 'Kamis' => '4', 'Jumat' => '5', 'Sabtu' => '6', 'Minggu' => '7');
        $hari     = date('l', strtotime($tanggal));
        $num_hari = $arr_day[$hari];
        if (empty($num_hari) || !isset($num_hari) || $num_hari == "") {
            $num_hari = $arr_hari[$hari];
        }
        return $num_hari;

    }


