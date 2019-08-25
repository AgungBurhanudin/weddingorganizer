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
            $field_input = '<input name="' . $nameInputPrefix . '" id="' . $nameInputPrefix . $id . '" type="text" class="form-control" value="' . $value . '" size="' . $size_field . '" ' . $tagWajib . ' />' . $tagBintang;
            break;
        case 'textarea':
            $field_size = '';
            $arr_field_size = explode('|', $ukuran);
            if (!empty($ukuran) && count($arr_field_size) == 2) {
                $field_size = ' cols="' . $arr_field_size[0] . '" rows="' . $arr_field_size[1] . '" ';
            }
            $field_input = '<textarea name="' . $nameInputPrefix . '" id="' . $nameInputPrefix . $id . '" type="text" class="form-control" ' . $field_size . '  ' . $tagWajib . ' >' . $value . '</textarea>' . $tagBintang;
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
        		<select class="form-control" name="' . $nameInputPrefix . '" id="' . $nameInputPrefix . $id . '"  ' . $tagWajib . ' >
        			<option value="">-- Pilih --</option>
        			' . $field_option . '
        		</select>
        		' . $tagBintang;

            break;
        case 'desimal':
            $size_field = !empty($ukuran) ? $ukuran : 15;
            $field_input = '<input style="text-align:right;" class="form-control" type="decimal" ' . $addToInputHtml . ' class="" name="' . $nameInputPrefix . $id . '" id="' . $nameInputPrefix . $id . '" value="' . number_format($value, 2) . '" size="' . $size_field . '"  ' . $tagWajib . ' />' . $tagBintang;

            break;
        case 'angka':
            $value = $value != "" ? number_format($value, 2) : 0;
            $size_field = !empty($ukuran) ? $ukuran : 15;
            $field_input = '<input style="text-align:right;" class="form-control" type="number" ' . $addToInputHtml . ' class="" name="' . $nameInputPrefix . $id . '" id="' . $nameInputPrefix . $id . '" value="' . $value . '" size="' . $size_field . '"  ' . $tagWajib . ' />' . $tagBintang;

            break;
        case 'tanggal':
            $field_input = '<input type="date" class="form-control" data-force="true" name="' . $nameInputPrefix . $id . '" id="' . $nameInputPrefix . $id . '" value="' . $value . '" size="35"  ' . $tagWajib . ' />' . $tagBintang;

            break;
        case 'checkbox':
            $field_input = '<br><label><input type="checkbox"  name="' . $nameInputPrefix . $id . '" id="' . $nameInputPrefix . $id . '" value="' . $value . '" ' . $tagWajib . ' />  ' . $ukuran . $tagBintang . '</label>';

            break;
        case 'addabletext':
            $size_field = 100;
            $columns = explode("||", $ukuran);
            $field_input = "<button type='button' onclick='add$nameInputPrefix()'><i class='fa fa-plus'></i></button>"
                    . "<table class='table'><thead><tr>";
            foreach ($columns as $v) {
                $field_input .= "<td>$v</td>";
            }
            $field_input .= "<td>Aksi</td>";
            $field_input .= "</tr></thead><tbody id='add$nameInputPrefix'><tr>";
            foreach ($columns as $v) {
                $tag = strtolower(str_replace(array(" ", "/"), array("_", "_"), $v));
                $field_input .= "<td>";
                $field_input .= '<input name="' . $nameInputPrefix . "['$tag']" . '" id="' . $nameInputPrefix . $id . '" type="text" class="form-control" value="' . $value . '" size="' . $size_field . '" ' . $tagWajib . ' />' . $tagBintang;

                $field_input .= "</td>";
            }
            $field_input .= "<td><button type='button' onclick='remove$nameInputPrefix(this)'><i class='fa fa-trash'></i></button></td>";
            $field_input .= "</tr></tbody></table>";
            $field_input .= "<script>";
            $field_input .= "function add$nameInputPrefix(){";
            $field_input .= 'var data = "<tr>';
            foreach ($columns as $v) {
                $tag = strtolower(str_replace(array(" ", "/"), array("_", "_"), $v));
                $field_input .= "<td>";
                $field_input .= '<input name=' . $nameInputPrefix . "['$tag']" . ' id=' . $nameInputPrefix . $id . ' type=text class=form-control />';

                $field_input .= '</td>';
            }
            $field_input .= "<td><button type='button' onclick='remove$nameInputPrefix(this)'><i class='fa fa-trash'></i></button></td>";
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
