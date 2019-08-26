
<div style="float: right">
    <button type="button" class="btn btn-mini btn-dark"><i class="fa fa-pencil"></i> Edit Daftar Paket Upacara</button>
</div>
<h2>Paket Upacara</h2>
<hr>

<div class="col-md-12" style="padding: 0">
    <?php
    foreach ($upacara_parent as $v) {
        ?>
        <div class="accordion" id="acordionParent_<?= $v->id ?>">
            <div class="card" style="margin: 0">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#parent_<?= $v->id ?>" aria-expanded="true" aria-controls="collapseOne">
                            <?= $v->nama_upacara ?>
                        </button>
                    </h2>
                </div>

                <div id="parent_<?= $v->id ?>" class="collapse show" aria-labelledby="headingOne" data-parent="#acordionParent_<?= $v->id ?>" style="padding: 0">
                    <div class="card-body" style="padding: 0">
                        <!--<div class="wrapper">-->
                        <ul class="nav nav-tabs" role="tablist" id="tabUpacara">
                            <?php
                            foreach ($upacara as $val) {
                                if ($val->id_upacara == $v->id) {
                                    ?>
                                    <li class="nav-item" onclick="getFieldUpacara('<?= $val->id_field ?>', '<?= $v->id ?>')">
                                        <a class="nav-link" data-toggle="tab" href="#upacara_<?= $v->id ?>_<?= $val->id_field ?>" role="tab" aria-controls="upacara_<?= $val->id ?>" aria-selected="true"><?= $val->nama_upacara ?></a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <!--</div>-->
                        <div class="tab-content">
                            <?php
                            foreach ($upacara as $val) {
                                ?>
                                <div class="tab-pane" id="upacara_<?= $v->id ?>_<?= $val->id_field ?>" role="tabpanel">

                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
<script>
    function getFieldUpacara(id, parent) {
        $.ajax({
            url: "<?= base_url() ?>Wedding/upacara/field?id=" + id,
            success: function (data) {
                $("#upacara_" + parent + "_" + id).html(data);
            }
        });
    }
</script>