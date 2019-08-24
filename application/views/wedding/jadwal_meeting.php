<h2>Jadwal Meeting</h2>
<hr>
<a href="#" data-toggle="modal" data-target="#modalJadwalMeeting">
    <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-plus"></i> Tambah Jadwal Meeting</button>
</a>
<br>
<br>
<table class="table table-responsive-sm table-hover table-outline mb-0">
    <thead class="thead-light">
        <tr>
            <th>No</th>
            <th>Kepada</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Tempat</th>
            <th>Keperluan</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        if (!empty($meeting)) {
            foreach ($meeting as $val) {
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $val->kepada ?></td>
                    <td><?= $val->tanggal ?></td>
                    <td><?= $val->waktu ?></td>
                    <td><?= $val->tempat ?></td>
                    <td><?= $val->keperluan ?></td>
                    <td>
                        <a href="<?= base_url() ?>Wedding/meeting/edit?id=<?= $val->id ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                        <a href="<?= base_url() ?>Wedding/meeting/delete?id=<?= $val->id ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Delete</a>                    
                    </td>
                </tr>
                <?php
            }
        } else {
            echo "<tr><td colspan='7'>Data Vendor Masih Kosong</td></tr>";
        }
        ?>
    </tbody>
</table>

<div class="modal fade" id="modalJadwalMeeting" tabindex="-1" role="dialog" aria-labelledby="modalJadwalMeetingLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Jadwal Meeting</h4>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" action="" method="post">
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-email">Tanggal</label>
                        <div class="col-md-9">
                            <input name="tanggal" id="tanggal" type="date" required="required" class="form-control" placeholder="" />                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password">Waktu </label>
                        <div class="col-md-9">
                            <input name="waktu" id="waktu" type="time" required="required" class="form-control"  />                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password">Tempat </label>
                        <div class="col-md-9">
                            <input name="tempat" id="tempat" type="text" required="required" class="form-control"  />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password">Materi </label>
                        <div class="col-md-9">
                            <textarea class="form-control" name="materi" id="materi"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label" for="hf-password"></label>
                        <div class="col-md-9">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" type="button">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- /.modal-content-->
    </div>
    <!-- /.modal-dialog-->
</div>