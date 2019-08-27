<?php

function Form($nameInputPrefix, $id, $name, $value, $type, $ukuran, $is_wajib, $form = '') {
    $number_format = 'id';
    $addToInputHtml = '';
    if ($number_format = 'id') {
        $addToInputHtml = 'data-dec=","  data-sep="."';
    } else {
        $addToInputHtml = 'data-dec="."  data-sep=","';
    }

    $tagWajib = '';
    $tagBintang = '';
    if ($is_wajib) {
        $tagWajib = ' required="required" ';
        $tagBintang = ' <font color="red">*</font>';
    }
    switch ($type) {
        case 'text':
            $size_field = !empty($ukuran) ? $ukuran : 100;
            $field_input = '<input name="' . $nameInputPrefix . '" id="' . $nameInputPrefix . $id . '" type="text" class="form_input" data-role="none" onkeyup="save' . $form . '(' . $id . ',this.value)" value="' . $value . '" size="' . $size_field . '" ' . $tagWajib . ' />' . $tagBintang;
            break;
        case 'textarea':
            $field_size = '';
            $arr_field_size = explode('|', $ukuran);
            if (!empty($ukuran) && count($arr_field_size) == 2) {
                $field_size = ' cols="' . $arr_field_size[0] . '" rows="' . $arr_field_size[1] . '" ';
            }
            $field_input = '<textarea name="' . $nameInputPrefix . '" id="' . $nameInputPrefix . $id . '" type="text" class="form_input" data-role="none" ' . $field_size . '  ' . $tagWajib . ' >' . $value . '</textarea>' . $tagBintang;
            break;
        case 'combobox':
            $field_option = '';
            $arr_field_option = explode('||', $ukuran);
            if (!empty($ukuran) && !empty($arr_field_option)) {
                foreach ($arr_field_option as $i => $item) {
                    $selected = "";
                    if ($item == $value) {
                        $selected = 'selected="selected"';
                    }
                    $field_option .= '<option value="' . $item . '" ' . $selected . '>' . $item . '</option>';
                }
            }

            $field_input = '
        		<select onchange="save' . $form . '(' . $id . ',this.value)" value="' . $value . '" class="form_input" data-role="none" name="' . $nameInputPrefix . '" id="' . $nameInputPrefix . $id . '"  ' . $tagWajib . ' >
        			<option value="">-- Pilih --</option>
        			' . $field_option . '
        		</select>
        		' . $tagBintang;

            break;
        case 'desimal':
            $size_field = !empty($ukuran) ? $ukuran : 15;
            $field_input = '<input style="text-align:right;" class="form_input" data-role="none" type="decimal" ' . $addToInputHtml . ' class="" name="' . $nameInputPrefix . $id . '" id="' . $nameInputPrefix . $id . '" value="' . number_format($value, 2) . '" size="' . $size_field . '"  ' . $tagWajib . ' />' . $tagBintang;

            break;
        case 'angka':
            $value = $value != "" ? number_format($value, 2) : 0;
            $size_field = !empty($ukuran) ? $ukuran : 15;
            $field_input = '<input style="text-align:right;" onkeyup="save' . $form . '(' . $id . ',this.value)" value="' . $value . '" class="form_input" data-role="none" type="number" ' . $addToInputHtml . ' class="" name="' . $nameInputPrefix . $id . '" id="' . $nameInputPrefix . $id . '" value="' . $value . '" size="' . $size_field . '"  ' . $tagWajib . ' />' . $tagBintang;

            break;
        case 'tanggal':
            $field_input = '<input type="date" onkeyup="save' . $form . '(' . $id . ',this.value)" value="' . $value . '" class="form_input" data-role="none" data-force="true" name="' . $nameInputPrefix . $id . '" id="' . $nameInputPrefix . $id . '" value="' . $value . '" size="35"  ' . $tagWajib . ' />' . $tagBintang;

            break;
        case 'checkbox':
            $checked = "";
            if ($ukuran == $value) {
                $checked = "checked='checked'";
            }
            $field_input = '<br><label><input type="checkbox" ' . $checked . ' onchange="save' . $form . '(' . $id . ', ' . "'$nameInputPrefix" . "$id '" . ', ' . "'checkbox'" . ')" value="' . $ukuran . '"  name="' . $nameInputPrefix . $id . '" id="' . $nameInputPrefix . $id . '" value="' . $value . '" ' . $tagWajib . ' />  ' . $ukuran . $tagBintang . '</label>';

            break;
        case 'addabletext':
            $arr_values = array(array());
            if (!empty($value)) {
                $arr_values = json_decode($value);
            }

            $size_field = 100;
            $columns = explode("||", $ukuran);
            $field_input = "<button type='button' onclick='add$nameInputPrefix()'>+</button>"
                    . "<form action='#' id='form$nameInputPrefix'><table class='table' width='100%'><thead><tr>";
            foreach ($columns as $v) {
                $field_input .= "<td>$v</td>";
            }
            $field_input .= "<td>Aksi</td>";
            $field_input .= "</tr></thead><tbody id='add$nameInputPrefix'>";
            $index = 0;
            foreach ($arr_values as $k => $val) {

                $field_input .= "<tr>";
                foreach ($columns as $k => $v) {
                    $tag = strtolower(str_replace(array(" ", "/"), array("_", "_"), $v));
                    $isi = isset($val[$k]) ? $val[$k] : "";
                    $field_input .= "<td>";
                    $field_input .= '<input value="' . $isi . '" onkeyup="save' . $form . '(' . $id . ',' . "'$nameInputPrefix'" . ', ' . "'addabletext'" . ')" name=' . $nameInputPrefix . "[$index][]" . ' id=' . $nameInputPrefix . $id . ' type=text class=form_input data-role=none />';

                    $field_input .= "</td>";
                }
                $field_input .= "<td><button type='button' onclick='remove$nameInputPrefix(this)'>-</button></td>";
                $field_input .= "<tr>";
                $index++;
            }
            $field_input .= "</tbody></table></form>";
            $field_input .= "<script>";
            $field_input .= "function add$nameInputPrefix(){";
            $field_input .= "var baris = $('#add$nameInputPrefix tr').length;";
            $field_input .= 'var data = "<tr>';
            foreach ($columns as $v) {
                $tag = strtolower(str_replace(array(" ", "/"), array("_", "_"), $v));
                $field_input .= "<td>";
                $field_input .= '<input onkeyup=save' . $form . '(' . $id . ',' . "'$nameInputPrefix'" . ",'addabletext'" . ') name=' . $nameInputPrefix . '["+baris+"][]' . ' id=' . $nameInputPrefix . $id . ' type=text class=form_input data-role=none />';

                $field_input .= '</td>';
            }
            $field_input .= "<td><button type='button' onclick='remove$nameInputPrefix(this)'>-</button></td>";
            $field_input .= '</tr>";';
            $field_input .= "$('#add$nameInputPrefix').append(data);";
            $field_input .= "};";

            $field_input .= "function remove$nameInputPrefix(e){";
            $field_input .= "$(e).parent().parent().remove();";
            $field_input .= "};";

            $field_input .= "</script>";
            break;
    }


    return $field_input;
}
