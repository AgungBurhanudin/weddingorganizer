GAMPANG FRAMEWORK
=======
Gampang `framework`.
### _introduction_
Bismillahirrahmanirrahim /|\

1. LOGIN
------
### 1a-cek_login
`index.php/LOGIN/LOGIN/WEB`
<br>Jika Login OTP : `token` diisi dengan OTP yang dikirim ke Email atau SMS
```js
{
    "tipe": "LOGIN",
    "username": "MIZAZA8622",
    "password": "123123",
    "token": "",
    "appid": "1RLXE27DNYKXFPTN",
    "website": "laporan"
}
```
### 1b-cek_session
`index.php/LOGIN/CEKSESSION/WEB`
```js
{
    "tipe": "CEKSESSION",
    "noid": "0000000000010002",
    "username": "ARIFAR1212",
    "token": "9JXCBKDCEK7DM67ZY2HW",
    "appid": "1RLXE27DNYKXFPTN ",
    "website": "laporan"
}
```
### 1c-cek_device
`index.php/LOGIN/CEKUSERNAME/WEB`
```js
{
    "tipe": "CEKUSERNAME",
    "token": "",
    "appid": "9HDEKSHZVZ2JUH39",
    "website": "laporan"
}
```
### 1d-logout
`index.php/LOGIN/LOGOUT/WEB`
```js
{
    "tipe": "LOGOUT",
    "noid": "",
    "username": "ARIFAR1212",
    "token": "9JXCBKDCEK7DM67ZY2HW",
    "appid": "1RLXE27DNYKXFPTN",
    "website": "laporan"
}
```

2. WEB ADMIN
-----------
### 2a-cek_saldo
`index.php/REQUEST/act/PROCESS/menu_cek_saldo/WEB`
```js
{
    "noid": "0000000000010003",
    "username": "MIZAZA8622",
    "token": "QLRE43TBS3A4JXMNVHRV",
    "appid": "1RLXE27DNYKXFPTN "
}
```
### 2a-transfer_saldo
`index.php/REQUEST/act/PROCESS/menu_transfer_saldo/WEB`
```js
{
    "detail": {
        "nohp_email": "EMAILKU@DSYARIAH.CO.ID",
        "action": "inq atau exec",
        "nominal": "25000",
        "keterangan": "COBA"
    }
}
```
### 2a-cek_token
`index.php/REQUEST/act/PROCESS/menu_cek_token/WEB`
```js
{
    "detail": {
        "idpel": "671393297155"
    }
}
```
### 2a-cek_transaksi
`index.php/REQUEST/act/PROCESS/menu_cek_transaksi/WEB`
```js
{
    "detail": {
        "idpel": "671393297155"
    }
}
```
### 2b-member_account_data
`index.php/RPAGING/act/REPORT_PAGING/rpaging_member_account/WEB`
```js

```
### 2b-member_account_add
`index.php/REQUEST/act/TABLE/tbl_member_account_add/WEB`
```js
{
    "detail": {
        "jenis": "PEGAWAI",
        "tipe": "SALES",
        "nama": "MIZA ZAKI",
        "nik": "3373042512840005",
        "tgl_lahir": "1984-12-25",
        "alamat": "salatiga",
        "provinsi": "JAWA TENGAH",
        "kota_kabupaten": "KOTA SALATIGA",
        "kecamatan": "SIDOMUKTI",
        "kelurahan": "MANGUNSARI",
        "provinsi_value": "33",
        "kota_kabupaten_value": "3373",
        "kecamatan_value": "3373030",
        "kelurahan_value": "3373030003",
        "rt": "2",
        "rw": "11",
        "kodepos": "50721",
        "nohp_email": "MIZAZAKII@DSYARIAH.CO.ID"
    }
}
```
### 2b-member_account_detail
`index.php/REQUEST/act/TABLE/tbl_member_account_check/WEB`
```js
{
    "detail": {
        "noid": "0030000000000000"
    }
}
```
### 2b-member_account_edit
`index.php/REQUEST/act/TABLE/tbl_member_account_edit/WEB`
```js
{
    "detail": {
        "noid": "0030000000000000",
        "nama": "MIZA ZAKI",
        "nik": "3373042512840005",
        "tgl_lahir": "1984-12-25",
        "alamat": "salatiga",
        "provinsi": "JAWA TENGAH",
        "kota_kabupaten": "KOTA SALATIGA",
        "kecamatan": "SIDOMUKTI",
        "kelurahan": "MANGUNSARI",
        "provinsi_value": "33",
        "kota_kabupaten_value": "3373",
        "kecamatan_value": "3373030",
        "kelurahan_value": "3373030003",
        "rt": "2",
        "rw": "11",
        "kodepos": "50721"
    }
}
```
### 2b-member_account_delet
`index.php/REQUEST/act/TABLE/tbl_member_account_delete/WEB`
```js
{
    "detail": {
        "noid": "0020000000000000"
    }
}
```
### 2b-member_account_topup
`index.php/REQUEST/act/PROCESS/menu_topup_saldo/WEB`
```js
{
    "detail": {
        "noid": "0030000000000000",
        "action": "inq atau exec",
        "nominal": "25000",
        "keterangan": "COBA",
        "tujuan": "CASH"
    }
}
```
### 2b-member_account_blokir
`index.php/REQUEST/act/TABLE/tbl_member_account_block/WEB`
```js
{
    "detail": {
        "noid": "0030000000000000",
		"jenis": "block or unblock"
    }
}
```
### 2c-member_channel_data
`index.php/RPAGING/act/REPORT_PAGING/rpaging_member_channel/WEB`
```js

```
### 2c-member_channel_add
`index.php/REQUEST/act/TABLE/tbl_member_channel_add/WEB`
```js
{
    "detail": {
        "interface": "WEB atau NFC atau H2H",
        "noid": "0000000000010004",
        "nama": "MIZA ZAKI",
        "alias": "NFC_ID",
        "passw": "123456",
        "limit_trx": "20000"
    }
}
```
### 2c-member_channel_detail
`index.php/REQUEST/act/TABLE/tbl_member_channel_check/WEB`
```js
{
    "detail": {
        "alias": "alias"
    }
}
```
### 2c-member_channel_edit
`index.php/REQUEST/act/TABLE/tbl_member_channel_edit/WEB`
```js
{
    "detail": {
        "id": 30,
        "nama": "PAIJO",
        "alias": "NFC_IDXX",
        "passw": "123123",
        "limit_trx": 5000
    }
}
```
### 2c-member_channel_delet
`index.php/REQUEST/act/TABLE/tbl_member_channel_delete/WEB`
```js
{
    "detail": {
        "alias": "alias"
    }
}
```
### 2c-member_channel_reset
`index.php/REQUEST/act/TABLE/tbl_member_channel_reset/WEB`
```js
{
    "detail": {
        "id": 27
    }
}
```
### 2d-rekap_transaksi_bulan
`index.php/REQUEST/act/REPORT/web_transaksi_bulan/WEB`
```js
{
    "detail": {
        "bulan": "02",
        "tahun": "2018"
    }
}
```
### 2d-rekap_transaksi_hari
`index.php/REQUEST/act/REPORT/web_transaksi_hari/WEB`
```js
{
    "detail": {
        "tanggal": "2018-02-15"
    }
}
```
### 2d-trx_hari_detail
`index.php/REQUEST/act/REPORT/web_transaksi_hari_detail/WEB`
```js
{
    "detail": {
        "tanggal": "2018-02-15",
        "product": "PLN POSTPAID"
    }
}
```
### 2e-jaringan_member
`index.php/RPAGING/act/REPORT_PAGING/rpaging_jaringan_member/WEB`
```js

```
### 2f-data_transaksi
`index.php/RPAGING/act/REPORT_PAGING/rpaging_log_data_trx/WEB`
```js

```
### 2f-data_trx_cek
`index.php/RPAGING/act/LOG/log_data_trx_check/WEB`
```js
{
  "detail": {
    "id": 469
  }
}
```
### 2f-data_trx_cetak
`index.php/RPAGING/act/LOG/log_data_trx/WEB`
```js

```
### 2f-data_trx_reversal
`index.php/RPAGING/act/LOG/log_data_trx/WEB`
```js

```
### 2f-data_trx_inject
`index.php/RPAGING/act/LOG/log_data_trx/WEB`
```js

```
### 2g-log_channel
`index.php/RPAGING/act/REPORT_PAGING/rpaging_log_channel/WEB`
```js

```
### 2h-log_chan_trx
`index.php/RPAGING/act/REPORT_PAGING/rpaging_log_channel_trx/WEB`
```js

```
### 2h-log_chan_trx_detail
`index.php/REQUEST/act/LOG/log_channel_trx_check/WEB`
```js
{
  "detail": {
    "id": 469
  }
}
```
### 2i-log_message_data
`index.php/RPAGING/act/REPORT_PAGING/rpaging_log_message/WEB`
```js

```
### 2i-log_message_resend
`index.php/REQUEST/act/LOG/log_message_resend/WEB`
```js
{
  "detail": {
    "id": 469
  }
}
```
### 2i-log_message_delete
`index.php/REQUEST/act/LOG/log_message_delete/WEB`
```js
{
  "detail": {
    "id": 469
  }
}
```
### 2i-log_msg_broadcast
`index.php/REQUEST/act/LOG/log_message_broadcast/WEB`
```js
{
  "detail": {
    "message": "ini adalah pesan yang dibroadcast"
  }
}
```
### 2j-data_otorisasi
`index.php/RPAGING/act/REPORT_PAGING/rpaging_otorisasi/WEB`
```js

```
### 2j-data_otorisasi_valid
`index.php/OTORISASI/act/validasi/XXXXXXXX/WEB`
<br>XXXXXXXX = KODE VALIDASI OTORISASI
```js
{
    "noid": "0000000000010003",
    "username": "MIZAZA8622",
    "token": "QLRE43TBS3A4JXMNVHRV",
    "appid": "1RLXE27DNYKXFPTN "
}
```
### 2k-data_topup
`index.php/RPAGING/act/REPORT_PAGING/rpaging_log_konfirmasi_topup/WEB`
```js

```
### 2k-data_topup_valid
`index.php/REQUEST/act/LOG/log_konfirmasi_tiket_validasi/WEB`
```js
{
  "detail": {
    "action": "inq atau exec",
    "id": 5,
	"bukti": "serial transaksi 12312312321"
  }
}
```
### 2k-data_topup_abaikan
`index.php/REQUEST/act/LOG/log_konfirmasi_tiket_abaikan/WEB`
```js
{
  "detail": {
    "id": 5
  }
}
```
### 2k-data_topup_create
`index.php/REQUEST/act/LOG/log_konfirmasi_tiket_add/WEB`
```js
{
  "detail": {
    "tujuan": "BCA",
    "nominal": "30000"
  }
}
```
### 2l-menu
`index.php/RPAGING/act/REPORT_PAGING/rpaging_menu/WEB`
```js

```
### 2m-product_map
`index.php/RPAGING/act/REPORT_PAGING/rpaging_product_map/WEB`
```js

```
### 2n-product_price
`index.php/RPAGING/act/REPORT_PAGING/rpaging_product_price/WEB`
```js

```
### 2o-product_admin
`index.php/RPAGING/act/REPORT_PAGING/rpaging_product_admin/WEB`
```js

```
BILLING
-----------
### 2p-nomor_va
`index.php/RPAGING /act/XBILLING/rpaging_nomor_va/WEB`
```js

```
### 2q-data_tagihan
`index.php/ RPAGING /act/XBILLING/rpaging_tagihan/WEB`
```js

```
### 2q-data_tagihan_add
`index.php/REQUEST/act/XBILLING/tbl_tagihan_add/WEB`
```js
{
  "detail": {
    "jenis_tagihan": "IMB",
    "idtagihan": "12341234",
    "idtagihan_name": "IMB ARIF ARINTO",
    "jatuh_tempo": "2018-03-01",
    "tagihan": 100000,
    "admin": 3000
  }
}
```
### 2q-data_tagihan_detail
`index.php/REQUEST/act/XBILLING /tbl_tagihan_check/WEB`
```js
{
  "detail": {
       "idtagihan":"123412341"
  }
}
```
### 2q-data_tagihan_edit
`index.php/REQUEST/act/XBILLING /tbl_tagihan_edit/WEB`
```js
{
  "detail": {
    "jenis_tagihan": "IMB",
    "idtagihan": "12341234",
    "idtagihan_name": "IMB ARIF ARINTO",
    "jatuh_tempo": "2018-03-01",
    "tagihan": 100000,
    "admin": 3000
  }
}
```
### 2r-mutasi
`index.php/RPAGINGPOS/act/XBILLING/rpaging_mutasi/WEB`
```js

```
### 2r-mutasi_add
`index.php/XREQUEST/act/XBILLING/tbl_mutasi/add/WEB`
```js
{  
   "detail":{  
      "id_mutasi": "7159654673",
      "nama": "Joko Maruf",
      "pangkat": "2B",
      "tempat_lahir": "Kab.Semarang",
      "tanggal_lahir": "tes",
      "agama": "islam",
      "ijasah": "s1",
      "ijasah_a": "2017",
      "ijasah_b": "9",
      "jabatan": "Guru",
      "alamat": "Ds.klero Rt 15 rw 09 kec.tengaran, kab.semarang",
      "nama_istri_suami": "melati",
      "tempat_lahir_istri_suami": "kab.semarang",
      "tanggal_lahir_istri_suami": "2001-09-09",
      "agama_istri_suami": "islam",
      "tgl_nikah_istri_suami": "2010-01-01",
      "pekerjaan_istri_suami": "wiraswasta",
      "foto_ktp" : "ambil name file dari upload foto_ktp",
      "foto_ijasah" : "ambil name file dari upload foto_ijasah"
   }
}
```
### 2r-mutasi_delete
`index.php/XREQUEST/act/XBILLING/tbl_mutasi/delete/WEB`
```js
{  
   "detail":{  
      "id_mutasi":"7213445486"
   }
}
```
### 2r-mutasi_cek
`index.php/XREQUEST/act/XBILLING/tbl_mutasi/check/WEB`
```js
{  
   "detail":{  
      "id_mutasi":"7213445486"
   }
}
```
### 2r-mutasi_update
`index.php/XREQUEST/act/XBILLING/tbl_mutasi/update/WEB`
```js
{  
   "detail":{  
      "nama":"Joko Maruf tes",
      "pangkat":"2B",
      "tempat_lahir":"Kab.Semarang",
      "tanggal_lahir":"1995-20-20",
      "agama":"islam",
      "ijasah":"s1",
      "ijasah_a":"2017",
      "ijasah_b":"9",
      "jabatan":"Guru",
      "alamat":"Ds.klero Rt 15 rw 09 kec.tengaran, kab.semarang",
      "nama_istri_suami":"melati",
      "tempat_lahir_istri_suami":"Kab.Semarang",
      "tanggal_lahir_istri_suami":"2001-09-09",
      "agama_istri_suami":"islam",
      "tgl_nikah_istri_suami":"2010-01-01",
      "pekerjaan_istri_suami":"wiraswasta",
      "foto_ktp" : "ambil name file dari upload foto_ktp",
      "foto_ijasah" : "ambil name file dari upload foto_ijasah",
      "id_mutasi":"7213445486"
   }
}
```
### 2r-mutasi_sk
`index.php/RPAGINGPOS/act/XBILLING/rpaging_mutasi_sk/WEB`
```js

```
### 2r-mutasi_sk_add
`index.php/XREQUEST/act/XBILLING/tbl_mutasi_sk/add/WEB`
```js
{  
	"detail":{  
      "tgl_sk":"2017-01-01",
      "nomor_sk":"001\/001\/2017",
      "golongan":"2a",
      "tahun":"2017",
      "bulan":"01",
      "gaji":"400000",
      "keterangan":"lorem ipsum dolor",
      "id_mutasi":"7213445486"
   }
   
}
```
### 2r-mutasi_sk_delete
`index.php/XREQUEST/act/XBILLING/tbl_mutasi_sk/delete/WEB`
```js
{  
	"detail":{  
      "id":"1"
   }
}
```
### 2r-mutasi_sk_cek
`index.php/XREQUEST/act/XBILLING/tbl_mutasi_sk/check/WEB`
```js
{  
	"detail":{  
      "id":"1"
   }
}
```
### 2r-mutasi_sk_update
`index.php/XREQUEST/act/XBILLING/tbl_mutasi_sk/update/WEB`
```js
{  
	"detail":{  
      "tgl_sk":"2017-02-02",
      "nomor_sk":"001\/001\/2018",
      "golongan":"2a",
      "tahun":"2017",
      "bulan":"01",
      "gaji":"400000",
      "keterangan":"lorem ipsum dolor",
      "id":"2"
   }
}
```
### 2r-mutasi_kg
`index.php/RPAGINGPOS/act/XBILLING/rpaging_mutasi_kenaikan_gaji/WEB`
```js

```
### 2r-mutasi_kg_add
`index.php/XREQUEST/act/XBILLING/tbl_mutasi_kg/add/WEB`
```js
{  	
   "detail":{  
      "tanggal_kenaikan":"2011-01-11",
      "no_sk":"001\/001\/2017",
      "gaji":"3000000",
      "tanggal_penempatan":"2017-01-01",
      "ket_penempatan":"lorem ipsum dolor",
      "masa_kerja":"2",
      "keterangan":"lorem ipsum dolor",
      "id_mutasi":"7213445486"
   }
}
```
### 2r-mutasi_kg_delete
`index.php/XREQUEST/act/XBILLING/tbl_mutasi_kg/delete/WEB`
```js
{  	
   "detail":{  
      "id":"3"
   }
}
```
### 2r-mutasi_kg_cek
`index.php/XREQUEST/act/XBILLING/tbl_mutasi_kg/check/WEB`
```js
{  	
   "detail":{  
      "id":"3"
   }
}
```
### 2r-mutasi_kg_update
`index.php/XREQUEST/act/XBILLING/tbl_mutasi_kg/update/WEB`
```js
{  	
   "id":"2",
   "detail":{  
      "tanggal_kenaikan":"2011-02-12",
      "no_sk":"001\/001\/2019",
      "gaji":"6000000",
      "tanggal_penempatan":"2017-01-01",
      "ket_penempatan":"lorem ipsum dolor",
      "masa_kerja":"2",
      "keterangan":"lorem ipsum dolor"
   }
}
```
### 2r-mutasi_anak
`index.php/RPAGINGPOS/act/XBILLING/rpaging_mutasi_anak/WEB`
```js

```
### 2r-mutasi_anak_add
`index.php/XREQUEST/act/XBILLING/tbl_mutasi_anak/add/WEB`
```js
{  	
   "detail":{  
      "nama":"Diana",
      "jenkel":"Perempuan",
      "tempat_lahir":"Kab.Semarang",
      "tanggal_lahir":"2010-01-01",
      "status_sekolah":"Sekolah",
      "keterangan":"Lorem Ipsum dolor",
      "id_mutasi":"7213445486"
   }
}
```
### 2r-mutasi_anak_delete
`index.php/XREQUEST/act/XBILLING/tbl_mutasi_anak/delete/WEB`
```js
{  	
   "detail":{  
      "id":"3"
   }
}
```
### 2r-mutasi_anak_cek
`index.php/XREQUEST/act/XBILLING/tbl_mutasi_anak/check/WEB`
```js
{  	
   "detail":{  
      "id":"3"
   }
}
```
### 2r-mutasi_anak_update
`index.php/XREQUEST/act/XBILLING/tbl_mutasi_anak/update/WEB`
```js
{  	
   "detail":{  
      "nama":"Joko Maruf",
      "jenkel":"Laki-Laki",
      "tanggal_lahir":"1992-02-02",
      "status_sekolah":"TIDAK",
      "keterangan":"Lorem ipsum dolor",
      "tempat_lahir":"Kab.Semarang",
      "id":"4"
   }
   
}
```
### 2q-data_tagihan_delete
`index.php/REQUEST/act/XBILLING/tbl_tagihan_delete/WEB`
```js
{
  "detail": {
    " idtagihan": "12341234"
  }
}
```

3. WEB TRANSAKSI
-----------
### 3a-cek_produk_pulsa
`index.php/REQUEST/act/REPORT/report_produk_pulsa/WEB`
```js
{
  "detail": {
    "operator": "XL"
  }
}
```
### 3a-inquiry_pulsa
`index.php/TRXINQUIRY/act/PULSA/XL/081712341234/123412341234/WEB`
```js
{
  "detail": {
    "nominal": "20000",
    "admin_bank": "2000"
  }
}
```
### 3a-inquiry_tagihan
`index.php/TRXINQUIRY/act/PLN/POSTPAID/1111111111111/123412341234/WEB`
```js
{
  "detail": {
    "nominal": "20000",
    "admin_bank": "2000"
  }
}
```
### 3a-payment
`index.php/TRXPAYMENT/act/1111111111111/1802141539737427/WEB`
```js
1802141539737427 = reff
```
### 3a-pos_main_tag

```js

```
### 3a-pos_search_tag
``
```js

```
### 3a-pos_search_id_name
``
```js

```
### 3a-pos_save_get_temp
``
```js

```
### 3a-pos_payment
``
```js

```
### 3b-pemberitahuan
`index.php/RPAGING/act/REPORT_PAGING/rpaging_log_message/WEB`
```js

```
### 3b-pemberitahuan_hapus
`index.php/REQUEST/act/LOG/log_message_delete/WEB`
```js
{
  "detail": {
    "id": 72
  }
}
```
### 3b-message_delete_all
`index.php/REQUEST/act/LOG/log_message_delete_all/WEB`
```js

```
### 3c-data_tiket_topup
`index.php/RPAGING/act/REPORT_PAGING/rpaging_log_konfirmasi_topup/WEB`
```js

```
### 3c-tiket_create
`index.php/REQUEST/act/LOG/log_konfirmasi_tiket_add/WEB`
```js
{
  "detail": {
    "tujuan": "BCA",
    "nominal": "30000"
  }
}
```
### 3d-mutasi_saldo
`index.php/RPAGING/act/REPORT_PAGING/rpaging_log_data_saldo/WEB`
```js

```
### 3d-transfer_saldo
`index.php/REQUEST/act/PROCESS/menu_transfer_saldo/WEB`
```js
{
  "detail": {
    "nohp_email": "ARIFARINTOP@GMAIL.COM",
    "action": "exec / inq",
    "nominal": "25000",
    "keterangan": "COBA",
    "tujuan": "CASH"
  }
}
```
### 3d_nfc_reader_token
`index.php/REQUEST/act/REPORT/web_nfc_reader_token/WEB`
```js

```
### 3d-cash_out_nfc_req
`index.php/REQUEST/act/PROCESS/menu_cash_out_nfc_web/WEB`
dapat response : 
{
  "response_code": "0000",
  "saldo": "189900",
  "nfc_id": "NFC1234",
  "response_message": "?"
}
```js
{
  "detail": {
    "action": "request",
    "passw": "",
    "nominal": 1200,
    "keterangan": "COBA"
  },
  "noid": "0000000000010001",
  "username": "ARIFAR1234",
  "token": "19QBVYF4EW358TD6XMNB",
  "appid": "1RLXE27DNYKXFPTN"
}
```
### 3d-cash_out_nfc_exec
`index.php/REQUEST/act/PROCESS/menu_cash_out_nfc_web/WEB`
```js
{
  "detail": {
    "alias": "NFC1234",
    "action": "exec",
    "passw": "",
    "nominal": 1200,
    "keterangan": "COBA"
  }
}
```
### 3e-rekap_transaksi_bulan
`index.php/REQUEST/act/REPORT/web_transaksi_bulan/WEB`
```js
{
  "detail": {
    "bulan": "02",
    "tahun": "2018"
  }
}
```
### 3e-rekap_transaksi_hari
`index.php/REQUEST/act/REPORT/web_transaksi_hari/WEB`
```js
{
    "detail": {
        "tanggal": "2018-02-15"
    }
}
```
### 3e-trx_hari_detail
`index.php/REQUEST/act/REPORT/web_transaksi_hari_detail/WEB`
```js
{
    "detail": {
        "tanggal": "2018-02-15",
        "product": "PLN POSTPAID"
    }
}
```
### 3f-mutasi_saldo_bulan
`index.php/REQUEST/act/REPORT/web_mutasi_saldo_bulan/WEB`
```js
{
  "detail": {
    "bulan": "02",
    "tahun": "2018"
  }
}
```
### 3f-mutasi_saldo_hari
`index.php/REQUEST/act/REPORT/web_mutasi_saldo_hari_detail/WEB`
```js
{
    "detail": {
        "tanggal": "2018-02-15"
    }
}
```
### 3g-info_token
`index.php/REQUEST/act/PROCESS/menu_cek_token/WEB`
```js
{
    "detail": {
        "idpel": "671393297155"
    }
}
```
### 3h-cek_transaksi
`index.php/REQUEST/act/PROCESS/menu_cek_transaksi/WEB`
```js
{
    "detail": {
        "idpel": "671393297155"
    }
}
```
### 3i-log_transaksi
`index.php/RPAGING/act/REPORT_PAGING/rpaging_log_channel_trx/WEB`
```js

```
### 3j-produk_layanan
Produk Pulsa
<br>`index.php/RPAGING/act/REPORT_PAGING/rpaging_product_price/WEB`
Layanan Pembayaran Online
<br>`index.php/RPAGING/act/REPORT_PAGING/rpaging_product_admin/WEB`
```js

```
### 3k-master_kolektif
``
```js

```
### 3k-master_kolektif_add
``
```js

```
### 3k-master_kolektif_detail
``
```js

```
### 3k-master_kolektif_edit
``
```js

```
### 3k-master_kolektif_delete
``
```js

```
### 3k-kolektif_detail
``
```js

```
### 3k-kolektif_detail_add
``
```js

```
### 3k-kolektif_detail_detail
``
```js

```
### 3k-kolektif_detail_edit
``
```js

```
### 3k-kolektif_detail_delete
``
```js

```
### 3l-ganti_password
`index.php/REQUEST/act/PROCESS/menu_ganti_password/WEB`
```js
{
  "detail": {
    "old_password": "123456",
    "new_password1": "123123",
    "new_password2": "123123"
  }
}
```
### 3m-testprint_dot
``
```js

```
### 3m-testprint_pdf
``
```js

```
### 3n-data_barang
``
```js

```
### 3o-inventory
``
```js

```
### 3p-laporan_penjualan
``
```js

```
4. OPEN REGISTRATION
-----------
### 4a-validasi_nohp_email
`index.php/REQUEST_OPEN/act/PROCESS_OPEN/validasi_nohp/WEB`
```js
{
  "nohp_email": "ARIFARINTO@GMAIL.COM"
}
```
### 4b-validasi_kode_agen
`index.php/REQUEST_OPEN/act/PROCESS_OPEN/validasi_kode_agen/WEB`
```js
{
  "nohp_email": "ARIFARINTOP@GMAIL.COM",
  "kode_agen":"0000"
}
```
### 4c-cek_kode
`index.php/REQUEST_OPEN/act/PROCESS_OPEN/validasi_cek_kode/WEB`
```js
{
  "nohp_email": "ARIFARINTOP@GMAIL.COM",
  "kode_validasi":"1062"
}
```
### 4d-validasi_update
`index.php/REQUEST_OPEN/act/PROCESS_OPEN/validasi_update/WEB`
Jika Aplikasi Android index.php/REQUEST_OPEN/act/PROCESS_OPEN/validasi_update/MOBILE tambahkan password (6 digit numerik) dan appid (diisi imei HP minimal 12 karakter) pada detail. 

```js
{
  "nohp_email": "ARIFARINTOP@GMAIL.COM",
  "token_aktivasi": "XXXXXXXXXXXXX",
  "detail": {
    "nama": "MIZA ZAKI",
    "nik": "3373042512840005",
    "tgl_lahir": "1984-12-25",
    "alamat": "salatiga",
    "provinsi": "JAWA TENGAH",
    "kota_kabupaten": "KOTA SALATIGA",
    "kecamatan": "SIDOMUKTI",
    "kelurahan": "MANGUNSARI",
    "provinsi_value": "33",
    "kota_kabupaten_value": "3373",
    "kecamatan_value": "3373030",
    "kelurahan_value": "3373030003",
    "rt": "2",
    "rw": "11",
    "kodepos": "50721"
  }
}
```
5. API H2H
-----------
### 5a-va_callback
`index.php/REQUEST_H2H/act/PROCESS/service_callback_bni/H2H`
```js
{
  "detail": {
    "nomor_va": "8612000000000004",
    "noid": "0020000000000000",
    "action": "exec",
    "nominal": "25000",
    "keterangan": "TOPUP_VA",
    "tujuan": "BNIS"
  },
  "noid": "0000000000010001",
  "username": "ARIFAR123",
  "token": "WWZXP8RDWV75AKWJS6UX",
  "appid": "1RLXE27DNYKXFPTN"
}
```
### 5b-topup_tiket_deposit
``
```js

```
### 5c-inquiry
``
```js

```
### 5d-payment
``
```js

```
### 5e-purchase
``
```js

```
### 5f-login_device
`index.php/REQUEST_DEVICE/CEKTOKENDEVICE/WEB`
```js
{"id_device":"MIZAZKNATS"}
```
### 5g-send_nfc_id
`/index.php/REQUEST_DEVICE/act/DEVICE/web_insert_nfc_id/WEB`
```js
{
  "detail": {
    "nfc_id": "NFC1234"
  },
  "noid": "0000000000010001",
  "username": "ARIFAR1234",
  "token": "19QBV"
}
```

6. ANDROID
-----------
### 6a-topup_tiket_deposit
`index.php/REQUEST/act/LOG/log_konfirmasi_tiket_add/MOBILE`
```js
{
  "detail": {
    "tujuan": "BCA",
    "nominal": "30000"
  }
}
```
### 6a-data_tiket_deposit
`index.php/REQUEST/act/REPORT/mob_home_tiket_deposit/MOBILE`
```js

```
### 6b-cek_saldo
`index.php/REQUEST/act/PROCESS/menu_cek_saldo/MOBILE`
```js

```
### 6c-list_daftar_idpel
`index.php/RPAGINGPOS/act/REPORT/mob_daftar_idpel/MOBILE`
```js
"detail":{  
      "action":"list",
      "noid":"8188468291",
      "product":"lorem ipsum",
      "product_detail":"lorem ipsum dolor"
   }
```

### 6c-transaksi_inquiry
``
```js

```
### 6c-transaksi_payment
``
```js

```

### 6c-trx_finish_save_idpel
`index.php/REQUEST/act/REPORT/mob_daftar_idpel/MOBILE`
```js
"detail":{  
      "action":"add",
      "product":"lorem ipsum",
      "product_detail":"lorem ipsum dolor",
      "idpel":"89",
      "nama":"lorem ipsum"
   }
```
### 6d-merchant_cash_out
`PROCESS/menu_cash_out_nfc`
```js
   "detail":{  
      "action":"inq/exec",
      "alias":"ARIFAR1234NFC",
      "passw":"123123",
      "nominal":"1000",
      "keterangan":""
   }
```
### 6d-merchant_pembayaran
`PROCESS/menu_cash_out_nfc`
```js

```
### 6d-merchant_cek_kartu
`index.php/REQUEST/act/TABLE/tbl_member_channel_check/NFC`
```js
 "detail":{  
      "alias":"ARIFAR1234MOBILE"
   }
```
### 6e-kredit_info_NEXT
``
```js

```
### 6e-kredit_simulasi_NEXT
``
```js

```
### 6e-kredit_pengajuan_NEXT
``
```js

```
### 6e-data_kredit_NEXT
``
```js

```
### 6f-online_shop_NEXT
``
```js

```
### 6g-ticketing_NEXT
``
```js

```
### 6h-rekap_transaksi
`index.php/REQUEST/act/REPORT/mob_hist_rekap_trx/MOBILE`
```js
{  
   "noid":"0000000000010001",
   "username":"ARIFAR1234MOBILE",
   "token":"BG1GE3BM988AV96MP665",
   "appid":"1RLXE27DNYKXFPTK"
}
```
### 6i-history_trx
`REPORT/mob_hist_detail_trx`
```js

```
### 6j-history_ticket_NEXT
``
```js

```
### 6k-shop_cart_NEXT
``
```js

```
### 6l-inbox
`REPORT/mob_inbox`
```js

```
### 6m-transfer_saldo
`index.php/REQUEST/act/PROCESS/menu_transfer_saldo/MOBILE`
```js
"detail":{  
      "action":"inq / exec",
      "nohp_email":"0818181881",
      "nominal":"3000",
      "keterangan":"lorem ipsum dolor",
      "passw":"123123",
      "limit_trx":"20000"
   }
```
### 6n-virtual_account
`REPORT/mob_acc_data_va`
```js

```
### 6o-tambah_kartu_nfc
`UPLOAD_NFC/addMOBILE`
```js
	"detail":{  
		"detail":{  
		   "interface":"NFC",
		   "noid":"0000000000010003",
		   "nama":"JOKO123",
		   "alias":"JOKO123",
		   "passw":"123123",
		   "limit_trx":"20000"
		},
		"noid":"0000000000010001",
		"username":"arifar1234MOBILE",
		"token":"AYDGVLKBJ86W26J3P5R1",
		"appid":"1RLXE27DNYKXFPTK"
	},
	"upload_image":"file"
```
### 6o-edit_kartu_nfc
`UPLOAD_NFC/updateMOBILE`
```js
  "detail":{  
      "id":30,
      "nama":"PAIJO",
      "limit_trx":5000
   }
```
### 6o-delete_kartu_nfc
`index.php/REQUEST/act/TABLE/tbl_member_channel_delete_nfc/NFC`
```js
  "detail":{  
   "alias":"NFC_IDXX"
}
```
### 6o-cek_kartu_nfc
`index.php/REQUEST/act/TABLE/tbl_member_channel_cek_nfc/NFC`
```js
  "detail":{  
   "alias":"NFC_IDXX"
}
```
### 6p-data_kartu_nfc
`index.php/REQUEST/act/REPORT/mob_data_nfc/WEB`
```js

```
### 6q-daftar_idpel
`index.php/RPAGINGPOS/act/REPORT/mob_daftar_idpel_all/MOBILE`
```js

```
### 6r-test_print_blue
``
```js

```
### 6s-ganti_pin
`index.php/REQUEST/act/PROCESS/menu_ganti_password/MOBILE`
```js
"detail":{  
      "oldPassword":"oldPswd",
      "newPassword1":"newPswd",
      "newPassword2":"newPswd"
   }
```
### 6t-cek_profile
`index.php/REQUEST/act/TABLE/tbl_member_account_check/MOBILE`
```js
"detail":{  
      "noid":"0000000000010003"
   }
```
### 6t-ubah_profile
`index.php/REQUEST/act/TABLE/tbl_member_account_edit/MOBILE`
```js
"detail":{  
      "noid":"0000000000010003",
      "nama":"joko",
      "nik":"3322022140101990003",
      "tgl_lahir":"1999-01-01",
      "alamat":"salatiga",
      "provinsi":"jawa tengah",
      "provinsi_value":"33",
      "kota_kabupaten":"Semarang",
      "kota_kabupaten_value":"2202",
      "kecamatan":"Tengaran",
      "kecamatan_value":"3322022",
      "kelurahan":"klero",
      "kelurahan_value":"3322022",
      "rt":"15",
      "Rw":"04",
      "kodepos":"50775"
   }
```
### 6u-logout
`index.php/LOGIN/LOGOUT/MOBILE`
```js
{
    "tipe": "LOGOUT",
    "noid": "",
    "username": "ARIFAR1212",
    "token": "9JXCBKDCEK7DM67ZY2HW",
    "appid": "1RLXE27DNYKXFPTN",
    "website": "laporan"
}
```
### 6v-test_print_image
``
```js

```

7. TOKO ONLINE
-----------
produk
mutasi_produk 
list_order
list_order_final
### 7a-main_tag
``
```js

```
### 7b-search_tag
``
```js

```
### 7c-search_name
``
```js

```
### 7d-show_product
``
```js

```
### 7e-related_product
``
```js

```
### 7f-unregistered_cart
``
```js

```
### 7f-add_to_cart
``
```js

```
### 7g-cart_data
``
```js

```
### 7h-cart_edit_product
``
```js

```
### 7i-cart_delete
``
```js

```
### 7j-cart_history
``
```js

```
### 7k-cart_final
``
```js

```
### 7k-cart_final_login
``
```js

```
### 7l-cart_pay_confirm
``
```js

```
### 7m-order_process
``
```js

```
### 7n-order_received
``
```js

```

8. SERVICE 
-----------
### 8a-kirim_email
`index.php/SERVICE/list_message/EMAIL/token`
```js

```
### 8b-kirim_sms
`index.php/SERVICE/list_message/SMS/token`
```js

```
### 8c-create_va_bni
`index.php/SERVICE/service_add_va_bni/token`
```js

```
### 8d-create_va_bca
``
```js

```
### 8e-create_va_mandiri
``
```js

```
### 8f-create_va_bri
``
```js

```
### 8g-create_va_muamalat
``
```js

```
### 8h-refresh_trx_today
`index.php/SERVICE/refresh_today_trx/token`
```js

```
### 8i-refresh_trx_month
`index.php/SERVICE/refresh_month_trx/token`
```js

```
### 8j-capture_saldo
`index.php/SERVICE/capture_saldo/token`
```js

```
### 8k-backup_saldo
`index.php/SERVICE/backup_saldo/token`
```js

```
9. ALAMAT
-----------
### 9a-provinces
`index.php/ALAMAT/provinces`
```js

```
### 9b-regencies
`index.php/ALAMAT/regencies/33`
```js

```
### 9c-districs
`index.php/ALAMAT/districts/3373`
```js

```
### 9d-villages
`index.php/ALAMAT/villages/3373030`
```js

```
10. KOPERASI/BANK
-----------
### 10a-add_tabungan
`index.php/XREQUEST/act/XBANK/tbl_tabungan/add/WEB`
```js
"detail":{  
      "noid":"002",
      "id_tabungan":"0000000000010001",
      "nama_tabungan":"ARIFARIANTO",
      "jenis":"tabungan",
      "saldo":"100000",
      "reg_date":"2018-01-01",
      "last_date":"2019-01-01",
      "vsn":"99898898",
      "status":"1",
      "last_trx":""
   }
```
### 10a-edit_tabungan
`index.php/XREQUEST/act/XBANK/tbl_tabungan/edit/WEB`
```js
"detail":{  
      "id_tabungan":"88738274827",
      "nama_tabungan":"ARIF ARIANTO",
      "jenis":"tabungan",
      "saldo":"200",
      "reg_date":"2018-01-01",
      "last_date":"2019-01-01",
      "vsn":"99898898",
      "status":"1",
      "last_trx":"{}",
      "last_amount":"1"
   }
```
### 10a-delete_tabungan
`index.php/XREQUEST/act/XBANK/tbl_tabungan/delete/WEB`
```js
"detail":{  
      "id_tabungan":"88738274827"
   }
```
### 10a-cek_tabungan
`index.php/XREQUEST/act/XBANK/tbl_tabungan/check/WEB`
```js
"detail":{  
      "id_tabungan":"88738274827"
   }
```
### 10c-add_investasi
`index.php/XREQUEST/act/XBANK/tbl_invesasi/add/WEB`
```js
 "detail":{  
      "noid":"0000000000010001",
      "id_investasi":"88738274827",
      "jenis":"tabungan",
      "saldo":"100000",
      "jangka_waktu_bulan":"10",
      "reg_date":"2018-01-01",
      "jatuh_tempo":"2019-01-01",
      "vsn":"99898898",
      "status":"1"
   }
```
### 10c-edit_investasi
`index.php/XREQUEST/act/XBANK/tbl_investasi/edit/WEB`
```js
"detail":{  
      "id_investasi":"88738274827",
      "jenis":"investasi",
      "saldo":"100000",
      "jangka_waktu_bulan":"10",
      "reg_date":"2018-01-01",
      "jatuh_tempo":"2019-01-01",
      "vsn":"99898898",
      "status":"1"
   }
```
### 10c-delete_investasi
`index.php/XREQUEST/act/XBANK/tbl_investasi/delete/WEB`
```js
"detail":{  
      "id_investasi":"88738274827"
   }
```
### 10c-cek_investasi
`index.php/XREQUEST/act/XBANK/tbl_investasi/check/WEB`
```js
"detail":{  
      "id_investasi":"88738274827"
   }
```
### 10b-add_k_pengajuan
`index.php/XREQUEST/act/XBANK/tbl_kredit_pengajuan/add/WEB`
```js
 "detail":{  
      "noid":"8989898",
      "waktu":"2018-01-01",
      "noid_add":"808080",
      "nama_add":"joko maruf",
      "nohp_email_add":"jokom@mail.com",
      "alamat_add":"salatiga",
      "pengajuan":"{}",
      "analisa":"{}",
      "supplier":"{}",
      "jaminan":"{}",
      "dokumen":"{}"
   }
```
### 10b-edit_k_pengajuan
`index.php/XREQUEST/act/XBANK/tbl_kredit_pengajuan/edit/WEB`
```js
"detail":{  
      "noid_add":"808080",
      "waktu":"2019-02-02",
      "nama_add":"jackzhouse",
      "nohp_email_add":"jokomaruf@gmail.com",
      "alamat_add":"semarang",
      "pengajuan":"{}",
      "analisa":"{}",
      "supplier":"{}",
      "jaminan":"{}",
      "dokumen":"{}"
   }
```
### 10b-delete_k_pengajuan
`index.php/XREQUEST/act/XBANK/tbl_kredit_pengajuan/delete/WEB`
```js
"detail":{  
   "noid_add":"808080"
}
```
### 10b-cek_k_pengajuan
`index.php/XREQUEST/act/XBANK/tbl_kredit_pengajuan/check/WEB`
```js
"detail":{  
   "noid_add":"808080"
}
```
### 10d-add_kredit
`index.php/XREQUEST/act/XBANK/tbl_kredit/add/WEB`
```js
"detail":{  
      "noid":"0000000000010001",
      "id_kredit":"123345",
      "jenis":"kredit",
      "jpemohon":"{}",
      "jbarang":"{}",
      "jjaminan":"{}",
      "beli":"90909",
      "margin":"1",
      "margin_awal":"2",
      "jual":"1000",
      "down_payment":"111",
      "jangka_waktu":"1",
      "reg_date":"2019-01-01",
      "collect":"loren",
      "cicilan":"200",
      "cicilan_pokok":"100",
      "cicilan_margin":"100",
      "sisa_pinjaman":"100",
      "saldo":"5000",
      "tanggal_akad":"2019-09-10",
      "id_investasi":"123413445"
}
```
### 10d-edit_kredit
`index.php/XREQUEST/act/XBANK/tbl_kredit/edit/WEB`
```js
"detail":{  
      "id_kredit":"123345",
      "jenis":"angsuran",
      "jpemohon":"{}",
      "jbarang":"{}",
      "jjaminan":"{}",
      "beli":"90909",
      "margin":"1",
      "margin_awal":"2",
      "jual":"1000",
      "down_payment":"111",
      "jangka_waktu":"1",
      "reg_date":"2019-01-01",
      "collect":"loren",
      "cicilan":"200",
      "cicilan_pokok":"100",
      "cicilan_margin":"100",
      "sisa_pinjaman":"100",
      "saldo":"5000",
      "tanggal_akad":"2019-09-10",
      "id_investasi":"123413445"
   }
```
 ### 10d-edit_kredit
`index.php/XREQUEST/act/XBANK/tbl_kredit/edit/WEB`
```js
"detail":{  
      "id_kredit":"123345",
      "jenis":"angsuran",
      "jpemohon":"{}",
      "jbarang":"{}",
      "jjaminan":"{}",
      "beli":"90909",
      "margin":"1",
      "margin_awal":"2",
      "jual":"1000",
      "down_payment":"111",
      "jangka_waktu":"1",
      "reg_date":"2019-01-01",
      "collect":"loren",
      "cicilan":"200",
      "cicilan_pokok":"100",
      "cicilan_margin":"100",
      "sisa_pinjaman":"100",
      "saldo":"5000",
      "tanggal_akad":"2019-09-10",
      "id_investasi":"123413445"
   }
```
 ### 10d-delete_kredit
`index.php/XREQUEST/act/XBANK/tbl_kredit/delete/WEB`
```js
"detail":{  
      "id_kredit":"123345"
}
```
 ### 10d-cek_kredit
`index.php/XREQUEST/act/XBANK/tbl_kredit/check/WEB`
```js
"detail":{  
      "id_kredit":"123345"
}
```
 ### 10d-add_kredit_detail
`index.php/XREQUEST/act/XBANK/tbl_kredit/add/WEB`
```js
"detail":{  
      "id_tbl_kredit":"020202",
      "noid":"8989898",
      "jatuh_tempo":"2019-01-01",
      "angsuran_ke":"2",
      "cicilan":"200",
      "pokok":"100",
      "margin":"1",
      "saldo":"5000",
      "status":"1",
      "vsn":"j3j3j3asf",
      "waktu_bayar":"2019-01-01 00:00:00",
      "noid_pembayar":"0101",
      "nama_pembayar":"joko",
      "channel_pembayar":"0101"
   }
```
 ### 10d-edit_kredit_detail
`index.php/XREQUEST/act/XBANK/tbl_kredit/edit/WEB`
```js
"detail":{  
      "id_tbl_kredit":"020202",
      "jatuh_tempo":"2019-01-01",
      "angsuran_ke":"2",
      "cicilan":"200",
      "pokok":"100",
      "margin":"1",
      "saldo":"5000",
      "status":"1",
      "vsn":"j3j3j3asf",
      "waktu_bayar":"2019-01-01 00:00:00",
      "noid_pembayar":"0101",
      "nama_pembayar":"joko",
      "channel_pembayar":"0101"
   }
```
 ### 10d-delete_kredit_detail
`index.php/XREQUEST/act/XBANK/tbl_kredit/delete/WEB`
```js
"detail":{  
      "id_tbl_kredit":"020202"
   }
```
 ### 10d-cek_kredit_detail
`index.php/XREQUEST/act/XBANK/tbl_kredit/check/WEB`
```js
"detail":{  
      "id_tbl_kredit":"020202"
   }
```
 