
<main class="main">
    <!-- Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Wedding</li>
        <li class="breadcrumb-item active">
            <a href="#">Data</a>
        </li>
        <!--<li class="breadcrumb-item active">Data</li>-->
        <!-- Breadcrumb Menu-->
    </ol>
    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <!-- /.col-->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> Form Pendaftaran Wedding</div>
                        <div class="card-body">
                            <div class="container">
                                <div class="stepwizard">
                                    <div class="stepwizard-row setup-panel">
                                        <div class="stepwizard-step col-xs-3"> 
                                            <!--<a href="#step-1" class="active">-->
                                            <button onclick="moveTab('step-1', 'step-2', 'step-3', 'step-4', 'step-5')" id="btn_step-1" type="button" class="btn btn-success btn-circle">1</button>
                                            <!--</a>-->
                                            <p><small>Data Pribadi Pengantin Wanita</small></p>
                                        </div>
                                        <div class="stepwizard-step col-xs-3"> 
                                            <button onclick="moveTab('step-2', 'step-1', 'step-3', 'step-4', 'step-5')" id="btn_step-2" href="#step-2" type="button" class="btn btn-primary btn-circle" disabled="disabled">2</button>
                                            <p><small>Data Pribadi Pengantin Wanita</small></p>
                                        </div>
                                        <div class="stepwizard-step col-xs-3"> 
                                            <button onclick="moveTab('step-3', 'step-2', 'step-1', 'step-4', 'step-5')" id="btn_step-3" href="#step-3" type="button" class="btn btn-primary btn-circle" disabled="disabled">3</button>
                                            <p><small>Data Pernikahan</small></p>
                                        </div>
                                        <div class="stepwizard-step col-xs-3"> 
                                            <button onclick="moveTab('step-4', 'step-2', 'step-1', 'step-3', 'step-5')" id="btn_step-4" href="#step-4" type="button" class="btn btn-primary btn-circle" disabled="disabled">4</button>
                                            <p><small>Paket Pernikahan</small></p>
                                        </div>
                                        <div class="stepwizard-step col-xs-3"> 
                                            <button onclick="finish()" id="btn_step-5" href="#step-5" type="button" class="btn btn-primary btn-circle" disabled="disabled">5</button>
                                            <p><small>Selesai</small></p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div id="form_daftar_wedding">
                                    <form method="POST" action="#" enctype="multipart/form-data">
                                        <div class="active_form panel panel-primary setup-content" id="step-1">
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
                                                <button class="btn btn-primary nextBtn pull-right" type="button" onclick="moveStep('step-1', 'step-2')">Next</button>
                                            </div>
                                        </div>
                                        <div class="hide panel panel-primary setup-content" id="step-2">
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
                                                            <input name="nama_lengkap_pria" id="nama_lengkap_pria" type="text" required="required" class="form-control"  />
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Sosmed Pengantin Wanita</label>
                                                            <input name="sosmed_wanita" id="sosmed_wanita" type="text" required="required" class="form-control"  />
                                                        </div>
                                                    </div>
                                                </div>
                                                <button onclick="moveStep('step-2', 'step-3')" class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                                            </div>
                                        </div>

                                        <div class="hide panel panel-primary setup-content" id="step-3">
                                            <div class="panel-body">
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
                                                            <select class="form-control" name="penyelenggara" id="penyelenggara"></select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Jumlah Undangan</label>
                                                            <input name="jumlah_undangan" id="jumlah_undangan" type="text" required="required" class="form-control"  />
                                                        </div>
                                                    </div>
                                                </div>
                                                <button onclick="moveStep('step-3', 'step-4')" class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                                            </div>
                                        </div>
                                        <div class="hide panel panel-primary setup-content" id="step-4">
                                            <div class="panel-body">
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
                                                            <select class="form-control" name="penyelenggara" id="penyelenggara"></select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Jumlah Undangan</label>
                                                            <input name="jumlah_undangan" id="jumlah_undangan" type="text" required="required" class="form-control"  />
                                                        </div>
                                                    </div>
                                                </div>
                                                <button onclick="finish()" class="btn btn-primary nextBtn pull-right" type="button">Next</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-->
            </div>
        </div>
    </div>
</main>
</div>
<script>
    $(function () {
        $("#step-2").attr('class', 'hide');
    });
    function moveStep(from, to) {
        $("#btn_" + to).removeAttr('disabled');
        $("#btn_" + to).removeClass('btn-primary');
        $("#btn_" + to).addClass('btn-success');


//        $("#btn_" + from).attr('disabled','disabled');
//        $("#btn_" + from).removeClass('btn-success');
//        $("#btn_" + from).addClass('btn-primary');

        $("#" + to).removeClass('hide');
        $("#" + to).addClass('active_form');

        $("#" + from).removeClass('active_form');
        $("#" + from).addClass('hide');
    }
    function moveTab(tab, hideTab, hideTab2, hideTab3, hideTab4) {

        $("#" + tab).removeClass('hide');
        $("#" + tab).addClass('active_form');

        $("#" + hideTab).removeClass('active_form');
        $("#" + hideTab).addClass('hide');

        $("#" + hideTab2).removeClass('active_form');
        $("#" + hideTab2).addClass('hide');

        $("#" + hideTab3).removeClass('active_form');
        $("#" + hideTab3).addClass('hide');

        $("#" + hideTab4).removeClass('active_form');
        $("#" + hideTab4).addClass('hide');
    }
    function finish() {
        var to = "step-5";
        $("#btn_" + to).removeAttr('disabled');
        $("#btn_" + to).removeClass('btn-primary');
        $("#btn_" + to).addClass('btn-success');

        $("#" + to).removeClass('hide');
        $("#" + to).addClass('active_form');

        $("#step-2").removeClass('active_form');
        $("#step-2").addClass('hide');

        $("#step-3").removeClass('active_form');
        $("#step-3").addClass('hide');

        $("#step-1").removeClass('active_form');
        $("#step-1").addClass('hide');

        $("#step-4").removeClass('active_form');
        $("#step-4").addClass('hide');
    }
</script>