
<div style="float: right">
    <button type="button" class="btn btn-mini btn-primary"><i class="fa fa-save"></i> Simpan</button>
</div>
<h2>Paket Tambahan</h2>
<hr>

<div class="col-md-12" style="padding: 0">
    <!--<div class="wrapper">-->
    <ul class="nav nav-tabs" role="tablist" id="tabTambahan">
        <?php
        foreach ($tambahan as $val) {
            ?>
            <li class="nav-item" onclick="getFieldTambahan('<?= $val->id_field ?>')">
                <a class="nav-link" data-toggle="tab" href="#tambahan_<?= $val->id_field ?>" role="tab" aria-controls="tambahan_<?= $val->id ?>" aria-selected="true"><?= $val->nama_tambahan ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
    <!--</div>-->
    <div class="tab-content">
        <?php
        foreach ($tambahan as $val) {
            ?>
            <div class="tab-pane" id="tambahan_<?= $val->id_field ?>" role="tabpanel">

            </div>
            <?php
        }
        ?>
    </div>
</div>
<script>
    function getFieldTambahan(id) {
        $.ajax({
            url: "<?= base_url() ?>Wedding/tambahan/field?id=" + id,
            success: function (data) {
                $("#tambahan_" + id).html(data);
            }
        });
    }
</script>