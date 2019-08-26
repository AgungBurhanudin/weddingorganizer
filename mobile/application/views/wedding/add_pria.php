<div class="panel-body">
    <div>
        <div class="col-md-6" style="float: left">
            <div class="form-group">
                <!--<label class="control-label">Foto</label>-->
                <!--<input name="nama_lengkap_pria" id="nama_lengkap_pria" type="file" required="required" class="form-control" placeholder="" />-->
                <!--<div class="col-sm-3" style="float: left"></div>-->
                <div class="col-sm-6 imgUp" style="margin: 0 auto;">
                    <div class="imagePreview"></div>
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
                <input name="nama_panggilan_pria" id="nama_panggilan_pria" type="text" required="required" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label">Alamat Sekarang Pengantin Pria</label>
                <input name="alamat_sekarang_pria" id="alamat_sekarang_pria" type="text" required="required" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label">Alamat setelah nikah Pengantin Pria</label>
                <input name="alamat_nikah_pria" id="alamat_nikah_pria" type="text" required="required" class="form-control" />
            </div>
        </div>
        <div class="col-md-6" style="float: left">
            <div class="form-group">
                <label class="control-label">Tempat Lahir Pengantin Pria</label>
                <input name="tempat_lahir_pria" id="tempat_lahir_pria" type="text" required="required" class="form-control" />
            </div>

            <div class="form-group">
                <label class="control-label">Tanggal Lahir Pengantin Pria</label>
                <input name="tanggal_lahir_pria" id="tanggal_lahir_pria" type="date" required="required" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label">No Hp Pengantin Pria</label>
                <input name="no_hp_pria" id="no_hp_pria" type="text" required="required" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label">Agama Pengantin Pria</label>
                <input name="agama_pria" id="agama_pria" type="text" required="required" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label">Pendidikan Pengantin Pria</label>
                <input name="pendidikan_pria" id="pendidikan_pria" type="text" required="required" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label">Hobi Pengantin Pria</label>
                <input name="hobi_pria" id="hobi_pria" type="text" required="required" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label">Sosmed Pengantin Pria</label>
                <input name="sosmed_pria" id="sosmed_pria" type="text" required="required" class="form-control" />
            </div>
        </div>
    </div>
    <button onclick="moveStep('step-2', 'step-3')" class="btn btn-primary nextBtn pull-right" type="button">Next</button>
</div>