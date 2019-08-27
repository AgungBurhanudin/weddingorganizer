<?php
if (!empty($wanita)) {
    $id = $wanita->id;
    $id_wedding = $wanita->id_wedding;
    $nama_lengkap = $wanita->nama_lengkap;
    $nama_panggilan = $wanita->nama_panggilan;
    $gender = $wanita->gender;
    $alamat_sekarang = $wanita->alamat_sekarang;
    $alamat_nikah = $wanita->alamat_nikah;
    $tempat_lahir = $wanita->tempat_lahir;
    $tanggal_lahir = $wanita->tanggal_lahir;
    $no_hp = $wanita->no_hp;
    $agama = $wanita->agama;
    $pendidikan = $wanita->pendidikan;
    $hobi = $wanita->hobi;
    $sosmed = $wanita->sosmed;
    $status = $wanita->status;
    $photo = $wanita->photo;
    if($photo == ""){
        $photo = "user.jpg";
    }
    if(!file_exists("./files/images/" . $photo)){
        $photo = "user.jpg";
    }
} else {
    $id = "";
    $id_wedding = "";
    $nama_lengkap = "";
    $nama_panggilan = "";
    $gender = "";
    $alamat_sekarang = "";
    $alamat_nikah = "";
    $tempat_lahir = "";
    $tanggal_lahir = "";
    $no_hp = "";
    $agama = "";
    $pendidikan = "";
    $hobi = "";
    $sosmed = "";
    $status = "";
    $photo = "user.jpg";
}
?>
<div role="main" class="ui-content">
    <div class="">
        <div class="loginform">
            <form method="POST" action="<?= base_url() ?>Dashboard/saveBiodataWanita" enctype="multipart/form-data">
                <input type="hidden" class="id_wedding" name="id" value="<?= $id ?>">
                <input type="hidden" class="id_wedding" name="id_wedding" value="<?= $id_wedding ?>">
                <input type="hidden" class="id_wedding" name="gender_wanita" value="<?= $gender ?>">
                Foto Pengantin Wanita
                <input type="file" name="foto_wanita" class="uploadFile img" value="Upload Photo" accept="image/png, image/jpeg, image/gif" data-role="file"  style="width: 0px;height: 0px;overflow: hidden;">

                Nama Lengkap Pengantin Wanita
                <input name="nama_lengkap_wanita" id="nama_lengkap_wanita" type="text"  class="form_input required" data-role="none" placeholder="" />


                Nama Panggilan Pengantin Wanita
                <input name="nama_panggilan_wanita" id="nama_panggilan_wanita" type="text"  class="form_input required" data-role="none" />


                Alamat Sekarang Pengantin Wanita
                <input name="alamat_sekarang_wanita" id="alamat_sekarang_wanita" type="text"  class="form_input required" data-role="none" />


                Alamat setelah nikah Pengantin Wanita
                <input name="alamat_nikah_wanita" id="alamat_nikah_wanita" type="text"  class="form_input required" data-role="none" />


                Tempat Lahir Pengantin Wanita
                <input name="tempat_lahir_wanita" id="tempat_lahir_wanita" type="text"  class="form_input required" data-role="none" />



                Tanggal Lahir Pengantin Wanita
                <input name="tanggal_lahir_wanita" id="tanggal_lahir_wanita" type="date"  class="form_input required" data-role="none" />


                No Hp Pengantin Wanita
                <input name="no_hp_wanita" id="no_hp_wanita" type="text"  class="form_input required" data-role="none" />


                Agama Pengantin Wanita
                <input name="agama_wanita" id="agama_wanita" type="text"  class="form_input required" data-role="none" />


                Pendidikan Pengantin Wanita
                <input name="pendidikan_wanita" id="pendidikan_wanita" type="text"  class="form_input required" data-role="none" />


                Hobi Pengantin Wanita
                <input name="hobi_wanita" id="hobi_wanita" type="text"  class="form_input required" data-role="none" />


                Sosmed Pengantin Wanita
                <input name="sosmed_wanita" id="sosmed_wanita" type="text"  class="form_input required" data-role="none" />
                <button type="submit">Simpan</button>
            </form>
        </div>        
    </div>

</div>

<script>
    $("#id_wanita").val('<?= $id ?>');
    $("#id_wedding_wanita").val('<?= $id_wedding ?>');
    $("#nama_lengkap_wanita").val('<?= $nama_lengkap ?>');
    $("#nama_panggilan_wanita").val('<?= $nama_panggilan ?>');
    $("#gender_wanita").val('<?= $gender ?>');
    $("#alamat_sekarang_wanita").val('<?= $alamat_sekarang ?>');
    $("#alamat_nikah_wanita").val('<?= $alamat_nikah ?>');
    $("#tempat_lahir_wanita").val('<?= $tempat_lahir ?>');
    $("#tanggal_lahir_wanita").val('<?= $tanggal_lahir ?>');
    $("#no_hp_wanita").val('<?= $no_hp ?>');
    $("#agama_wanita").val('<?= $agama ?>');
    $("#pendidikan_wanita").val('<?= $pendidikan ?>');
    $("#hobi_wanita").val('<?= $hobi ?>');
    $("#sosmed_wanita").val('<?= $sosmed ?>');
    $("#status_wanita").val('<?= $status ?>');
    $("#photoWanita").attr('style','background: url(<?= base_url() ."/files/images/" .$photo ?>) no-repeat center center; background-size:cover;');
</script>