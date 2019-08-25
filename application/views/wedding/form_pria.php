<?php
if (!empty($pria)) {
    $id = $pria->id;
    $id_wedding = $pria->id_wedding;
    $nama_lengkap = $pria->nama_lengkap;
    $nama_panggilan = $pria->nama_panggilan;
    $gender = $pria->gender;
    $alamat_sekarang = $pria->alamat_sekarang;
    $alamat_nikah = $pria->alamat_nikah;
    $tempat_lahir = $pria->tempat_lahir;
    $tanggal_lahir = $pria->tanggal_lahir;
    $no_hp = $pria->no_hp;
    $agama = $pria->agama;
    $pendidikan = $pria->pendidikan;
    $hobi = $pria->hobi;
    $sosmed = $pria->sosmed;
    $status = $pria->status;
    $photo = $pria->photo;
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
<h2>Biodata Pengantin Pria</h2>
<hr>
<div>
    <div class="col-md-6" style="float: left">
        <div class="form-group">
            <!--<label class="control-label">Foto</label>-->
            <!--<input name="nama_lengkap_pria" id="nama_lengkap_pria" type="file" required="required" class="form-control" placeholder="" />-->
            <!--<div class="col-sm-3" style="float: left"></div>-->
            <div class="col-sm-6 imgUp" style="margin: 0 auto;">
                <div class="imagePreview" id="photoPria"></div>
                <label class="btn btn-upload btn-primary">
                    Foto Pengantin Pria
                    <input type="file" name="foto_pria" class="uploadFile img" value="Upload Photo" accept="image/png, image/jpeg, image/gif" style="width: 0px;height: 0px;overflow: hidden;">
                </label>
            </div>
            <!--<div class="col-sm-3" style="float: left"></div>-->
        </div>
        <div class="form-group">
            <label class="control-label">Nama Lengkap Pengantin Pria</label>
            <input name="nama_lengkap_pria" id="nama_lengkap_pria" type="text" required="required" class="form-control" placeholder="" />
        </div>
        <div class="form-group">
            <label class="control-label">Nama Panggilan Pengantin Pria</label>
            <input name="nama_panggilan_pria" id="nama_panggilan_pria" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Alamat Sekarang Pengantin Pria</label>
            <input name="alamat_sekarang_pria" id="alamat_sekarang_pria" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Alamat setelah nikah Pengantin Pria</label>
            <input name="alamat_nikah_pria" id="alamat_nikah_pria" type="text" required="required" class="form-control"  />
        </div>
    </div>
    <div class="col-md-6" style="float: left">
        <div class="form-group">
            <label class="control-label">Tempat Lahir Pengantin Pria</label>
            <input name="tempat_lahir_pria" id="tempat_lahir_pria" type="text" required="required" class="form-control"  />
        </div>

        <div class="form-group">
            <label class="control-label">Tanggal Lahir Pengantin Pria</label>
            <input name="tanggal_lahir_pria" id="tanggal_lahir_pria" type="date" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">No Hp Pengantin Pria</label>
            <input name="no_hp_pria" id="no_hp_pria" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Agama Pengantin Pria</label>
            <input name="agama_pria" id="agama_pria" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Pendidikan Pengantin Pria</label>
            <input name="pendidikan_pria" id="pendidikan_pria" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Hobi Pengantin Pria</label>
            <input name="hobi_pria" id="hobi_pria" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Sosmed Pengantin Pria</label>
            <input name="sosmed_pria" id="sosmed_pria" type="text" required="required" class="form-control"  />
        </div>
    </div>
</div>

<script>
    $("#id_pria").val('<?= $id ?>');
    $("#id_wedding_pria").val('<?= $id_wedding ?>');
    $("#nama_lengkap_pria").val('<?= $nama_lengkap ?>');
    $("#nama_panggilan_pria").val('<?= $nama_panggilan ?>');
    $("#gender_pria").val('<?= $gender ?>');
    $("#alamat_sekarang_pria").val('<?= $alamat_sekarang ?>');
    $("#alamat_nikah_pria").val('<?= $alamat_nikah ?>');
    $("#tempat_lahir_pria").val('<?= $tempat_lahir ?>');
    $("#tanggal_lahir_pria").val('<?= $tanggal_lahir ?>');
    $("#no_hp_pria").val('<?= $no_hp ?>');
    $("#agama_pria").val('<?= $agama ?>');
    $("#pendidikan_pria").val('<?= $pendidikan ?>');
    $("#hobi_pria").val('<?= $hobi ?>');
    $("#sosmed_pria").val('<?= $sosmed ?>');
    $("#status_pria").val('<?= $status ?>');
    $("#photoPria").attr('style','background: url(<?= base_url() ."/files/images/" .$photo ?>) no-repeat center center; background-size:cover;');
</script>