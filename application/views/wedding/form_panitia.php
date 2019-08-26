
<div style="float: right">
    <button type="button" class="btn btn-mini btn-dark"><i class="fa fa-pencil"></i> Edit Daftar Paket Panitia</button>
</div>
<h2>Paket Panitia</h2>
<hr>

<div class="col-md-12" style="padding: 0">
    <!--<div class="wrapper">-->
    <ul class="nav nav-tabs" role="tablist" id="tabPanitia">
        <?php
        foreach ($panitia as $val) {
            ?>
            <li class="nav-item" onclick="getFieldPanitia('<?= $val->id_field ?>')">
                <a class="nav-link" data-toggle="tab" href="#panitia_<?= $val->id_field ?>" role="tab" aria-controls="panitia_<?= $val->id ?>" aria-selected="true"><?= $val->nama_panitia ?></a>
            </li>
            <?php
        }
        ?>
    </ul>
    <!--</div>-->
    <div class="tab-content">
        <?php
        foreach ($panitia as $val) {
            ?>
            <div class="tab-pane" id="panitia_<?= $val->id_field ?>" role="tabpanel">

            </div>
            <?php
        }
        ?>
    </div>
</div>
<script>
    function getFieldPanitia(id) {
        $.ajax({
            url: "<?= base_url() ?>Wedding/panitia/field?id=" + id,
            success: function (data) {
                $("#panitia_" + id).html(data);
            }
        });
    }
</script>