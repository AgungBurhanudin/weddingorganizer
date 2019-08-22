<?php

namespace Libraries;
use Resources;

class ResponseError {

    public static function invalidSession() {
        $response = array('response_code' => '0111','response_message' => 'Session waktu telah habis, silahkan login kembali.');
        die(json_encode($response));
    }
    
    public static function invalidIp() {
        $response = array('response_code' => '0111','response_message' => 'IP tidak sesuai');
        die(json_encode($response));
    }
    
    public static function kesalahanSistem($tipe_request) {
        $response = array('response_code' => '0122','response_message' => 'Terjadi Kesalahan Sistem pada : '.$tipe_request);
        die(json_encode($response));
    }
    
    public static function menuTidakAda($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Menu tidak tersedia','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function menuTidakBerhak($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Anda tidak berhak mengakses menu ini','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function requestTerlaluCepat($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Request terlalu cepat','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function accountTidakAda($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Account tidak ditemukan atau sedang terblokir','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function channelTidakAda($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Channel tidak ditemukan','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function dataTidakAda($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Data tidak ditemukan','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function dataCashOutTidakAda($id_nfc) {
        $response = array('response_code' => '0501','response_message' => 'Data tidak ditemukan','nfc_id' => $id_nfc);
        die(json_encode($response));
    }
    
    public static function accountTidakValid($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Account tujuan tidak valid','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function regAccountNohpEmailTerdaftar($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Proses Gagal, Nohp atau Email telah Terdaftar','saldo' => $saldo);
        die(json_encode($response));
    }
    
    //channel alias terdaftar
    public static function regAccountAliasTerdaftar($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Ulangi dan Periksa penambahan Channel Transaksi, Alias telah Terdaftar','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function regAccountHarusEmail($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Proses Registrasi Gagal, harus menggunakan Email','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function regAccountJenisSalah($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Proses Registrasi Gagal, Jenis harus PEGAWAI atau MEMBER','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function regAccountTidakBerhak($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Proses Registrasi Gagal, Anda tidak berhak','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function globalTidakBerhak($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Anda tidak berhak','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function otorisasiButuh($saldo) {
        $response = array('response_code' => '0000','response_message' => 'Request Diterima. Permintaan anda telah masuk ke sistem otorisasi','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function otorisasiSudahAda($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Request Ditolak karena Double, sudah ada permintaan yang sama','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function otorisasiTidakAda($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Otorisasi Gagal, Kode Validasi yang anda masukkan salah','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function minimalTransaksi($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Transaksi Gagal, nominal minimal Rp. 500','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function saldoTidakCukup($saldo) {
        $response = array('response_code' => '0510','response_message' => 'Transaksi Gagal, saldo anda tidak cukup. Silahkan TopUp Saldo kembali','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function saldoTargetTidakCukup($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Transaksi Gagal, Saldo Member tidak cukup untuk Cash Out atau Pembayaran.','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function tipeActionTidakValid($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Request Gagal, tipe action tidak valid','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function gantiPasswordTidakValid($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Password Baru tidak valid, gunakan angka dan huruf saja','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function gantiPasswordBaruTidakSama($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Password Baru tidak sama, periksa inputan password baru anda','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function gantiPasswordLamaTidakSama($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Password Lama Salah, periksa inputan password lama anda','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function productTidakAda($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Produk tidak tersedia atau sedang ditutup','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function plnPrepaidNominal($saldo) {
        $response = array('response_code' => '0501','response_message' => 'PLN PREPAID, Pilih nominal','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function productDitutup($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Produk sedang ditutup. Hubungi CS untuk informasi','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function requestPayTrxInvalid($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Request Transaksi tidak valid','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function requestPayTrxInvalidCredential($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Credential Request Transaksi tidak valid','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function regIdTagihanTerdaftar($saldo) {
        $response = array('response_code' => '0501','response_message' => 'ID Tagihan telah terdaftar','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function tagihanTidakDitemukan($saldo) {
        $response = array('response_code' => '0501','response_message' => 'ID Tagihan tidak ada','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function adminBankTidakValid($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Transaksi Gagal, Biaya Admin Bank Tidak Valid','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function namaKolektifTerdaftar($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Proses Input Group Kolektif Gagal, Nama telah terdaftar','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function idpelKolektifTerdaftar($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Proses Input Group Kolektif Gagal, IDPEL telah terdaftar','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function idpelTidakValid($saldo) {
        $response = array('response_code' => '0501','response_message' => 'IDPEL tidak valid','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function saldoTarikTidakCukup($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Saldo Loket yang akan ditarik tidak mencukupi','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function passwordMinimal($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Gagal, Karakter Password Minimal 6 Karakter.','saldo' => $saldo);
        die(json_encode($response));
    }
    
    public static function resetPasswordGagal($saldo) {
        $response = array('response_code' => '0501','response_message' => 'Reset Password Gagal, Hanya interface WEB yang bisa di reset.','saldo' => $saldo);
        die(json_encode($response));
    }
	
	public static function menuTerdaftar($nama){
		$response = array('response_code' => '0501','response_message' => 'Menu '.$nama.' Sudah Terdaftar');
        die(json_encode($response));
	}
	
	public static function contentTerdaftar(){
		$response = array('response_code' => '0501','response_message' => 'Content dengan Judul '.$title.' Sudah Terdaftar');
        die(json_encode($response));
	}
}
