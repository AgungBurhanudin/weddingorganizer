<div style="float: right">
    <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-save"></i> Simpan</button>
</div>
<h2>Data Pernikahan</h2>
<hr>
<div>
    <div class="col-md-6" style="float: left">
        <div class="form-group">
            <label class="control-label">Judul Pernikahan</label>
            <input name="title" id="title" type="text" required="required" class="form-control" placeholder="" />
        </div>
        <div class="form-group">
            <label class="control-label">Tanggal Pernikahan</label>
            <input name="tanggal_pernikahan" id="tanggal_pernikahan" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Waktu Pernikahan</label>
            <input name="waktu_pernikahan" id="waktu_pernikahan" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Lokasi Pernikahan</label>
            <input name="lokasi_pernikahan" id="lokasi_pernikahan" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Alamat Lokasi Pernikahan</label>
            <input name="alamat_pernikahan" id="alamat_pernikahan" type="text" required="required" class="form-control"  />
        </div>
    </div>
    <div class="col-md-6" style="float: left">

        <div class="form-group">
            <label class="control-label">Tema Pernikahan</label>
            <input name="tema_pernikahan" id="tema_pernikahan" type="date" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Hastag Pernikahan</label>
            <input name="hastag_pernikahan" id="hastag_pernikahan" type="text" required="required" class="form-control"  />
        </div>
        <div class="form-group">
            <label class="control-label">Penyelenggara</label>
            <select class="form-control" name="penyelenggara" id="penyelenggara">
                <option value="">-- Pilih Penyelenggara --</option>
                <option value="PRIA">Pihak Pria</option>
                <option value="WANITA">Pihak Wanita</option>
                <option value="KEDUA">Kedua Pihak</option>
            </select>
        </div>
        <div class="form-group">
            <label class="control-label">Jumlah Undangan</label>
            <input name="jumlah_undangan" id="jumlah_undangan" type="text" required="required" class="form-control"  />
        </div>
    </div>
</div>