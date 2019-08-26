<?php
if (!empty($field)) {
    foreach ($field as $val) {
        $id = $val->id;
        $label = $val->nama_label;
        $nama_field = $val->nama_field;
        $value = isset($val->value) ? $val->value : "";
        $name = '';
        $type_field = $val->type;
        $ukuran = $val->ukuran;
        $is_wajib = $val->wajib;
        $nameInputPrefix = str_replace("?", "", $nama_field);
        $form = Form($nameInputPrefix, $id, $name, $value, $type_field, $ukuran, $is_wajib, $type);
        ?>
        <div class="form-group">
            <label class="control-label"><?= $label ?></label>
            <?= $form ?>
        </div>
        <?php
    }
}
?>