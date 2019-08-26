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
<div style="float: right">
    <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-save"></i> Simpan</button>
</div>
<h2>Biodata Pengantin Wanita</h2>
<hr>
<div>
    <div class="col-md-6" style="float: left">
        <div class="form-group">
            <!--<label class="control-label">Foto</label>-->
            <!--<input name="nama_lengkap_wanita" id="nama_lengkap_wanita" type="file" required="required" class="form-control" placeholder="" />-->
            <!--<div class="col-sm-3" style="float: left"></div>-->
            <div class="col-sm-6 imgUp" style="margin: 0 auto;">
                <div class="imagePreview" id="photoWanita"></div>
                <label class="btn btn-upload btn-primary">
                    Foto Pengantin Wanita
                    <input type="file" class="uploadFile img" value="Upload Photo" accept="image/png, image/jpeg, image/gif" style="width: 0px;height: 0px;overflow: hidden;">
                </label>
            </div>
            <!--<div class="col-sm-3" style="float: left"></div>-->
        </div>
        <div class="form-group">
            <label class="control-label">Nama Lengkap Pengantin Wanita</label>
            <input name="nama_lengkap_wanita" id="nama_lengkap_wanita" type="text" required="required" class="form-control" placeholder="" />
        </div>
        <div class="form-group">
            <label class="control-label">Nama Panggilan Pengantin Wanita</label>
            <input name="nama_panggilan_wanita" id="nama_panggilan_wanita" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Alamat Sekarang Pengantin Wanita</label>
            <input name="alamat_sekarang_wanita" id="alamat_sekarang_wanita" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Alamat setelah nikah Pengantin Wanita</label>
            <input name="alamat_nikah_wanita" id="alamat_nikah_wanita" type="text" required="required" class="form-control"  />
        </div>
    </div>
    <div class="col-md-6" style="float: left">
        <div class="form-group">
            <label class="control-label">Tempat Lahir Pengantin Wanita</label>
            <input name="tempat_lahir_wanita" id="tempat_lahir_wanita" type="text" required="required" class="form-control"  />
        </div>

        <div class="form-group">
            <label class="control-label">Tanggal Lahir Pengantin Wanita</label>
            <input name="tanggal_lahir_wanita" id="tanggal_lahir_wanita" type="date" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">No Hp Pengantin Wanita</label>
            <input name="no_hp_wanita" id="no_hp_wanita" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Agama Pengantin Wanita</label>
            <input name="agama_wanita" id="agama_wanita" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Pendidikan Pengantin Wanita</label>
            <input name="pendidikan_wanita" id="pendidikan_wanita" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Hobi Pengantin Wanita</label>
            <input name="nama_lengkap_wanita" id="nama_lengkap_wanita" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Sosmed Pengantin Wanita</label>
            <input name="sosmed_wanita" id="sosmed_wanita" type="text" required="required" class="form-control"  />
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