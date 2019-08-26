<div class="panel-body">
    <div>
        <div class="col-md-6" style="float: left">
            <fieldset>
                <h2>Paket Acara</h2>
                <hr>
                <?php
                $parent = '0';
                foreach ($acara as $val) {
                    $value = $val->id;
                    $nama = $val->nama_acara;
                    $id = strtolower(str_replace(array(" ","/"), array("_","_"), $nama)) . "_" . $value;
                    ?>
                    <div class="form-check form-check-inline mr-1">
                        <input class="form-check-input" id="<?= $id ?>" name="acara[]" type="checkbox" value="<?= $value ?>">
                        <label class="form-check-label" for="<?= $id ?>"><?= $nama ?></label>
                    </div>
                    <br>
                    <?php
                }
                ?>
            </fieldset>
        </div>
        <div class="col-md-6" style="float: left">
            <fieldset>
                <h2>Paket Upacara</h2>
                <hr>
                <?php
                $parent = '0';
                foreach ($upacara as $val) {
                    $value = $val->id;
                    $id_parent_child = $val->parent_id;
                    $nama = $val->child_name;
                    $id = strtolower(str_replace(array(" ","/"), array("_","_"), $nama)) . "_" . $value;
                    if ($parent == '0' || $parent == '00') {
                        ?>
                        <b><?= $val->parent_name ?></b><br>
                        <?php
                    }
                    ?>
                    <div class="form-check form-check-inline mr-1" style="margin-left: 10px">
                        <input class="form-check-input" id="<?= $id ?>" name="upacara[]" type="checkbox" value="<?= $value ?>">
                        <label class="form-check-label" for="<?= $id ?>"><?= $nama ?></label>
                    </div><br>
                    <?php
                    if ($parent == '0') {
                        $parent = $val->parent_id;
                    } else if ($parent != $id_parent_child) {
                        $parent = '0';
                    }
                }
                ?>
            </fieldset>
        </div>
        <div style="clear: both"></div>
        <hr>
        <br>
        <div class="col-md-6" style="float: left">
            <fieldset>
                <h2>Paket Panitia</h2>
                <hr>
                <?php
                $parent = '0';
                foreach ($panitia as $val) {
                    $value = $val->id;
                    $nama = $val->nama_panitia;
                    $id = strtolower(str_replace(array(" ","/"), array("_","_"), $nama)) . "_" . $value;
                    ?>
                    <div class="form-check form-check-inline mr-1">
                        <input class="form-check-input" id="<?= $id ?>" name="panitia[]" type="checkbox" value="<?= $value ?>">
                        <label class="form-check-label" for="<?= $id ?>"><?= $nama ?></label>
                    </div>
                    <br>
                    <?php
                }
                ?>
            </fieldset>
        </div>
        <div class="col-md-6" style="float: left">
            <fieldset>
                <h2>Paket Tambahan</h2>
                <hr>
                <?php
                $parent = '0';
                foreach ($tambahan as $val) {
                    $value = $val->id;
                    $nama = $val->nama_tambahan_paket;
                    $id = strtolower(str_replace(array(" ","/"), array("_","_"), $nama)) . "_" . $value;
                    ?>
                    <div class="form-check form-check-inline mr-1">
                        <input class="form-check-input" id="<?= $id ?>" name="tambahan[]" type="checkbox" value="<?= $value ?>">
                        <label class="form-check-label" for="<?= $id ?>"><?= $nama ?></label>
                    </div>
                    <br>
                    <?php
                }
                ?>
            </fieldset>
        </div>
    </div>
    <div style="clear: both"></div>
    <button onclick="finish()" class="btn btn-primary nextBtn pull-right" type="button">Next</button>
</div>