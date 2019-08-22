<?php
function EPager_selected($per_page, $b, $opt=0){
    if($per_page == $b){
        if($opt)
            return "checked='checked'";
        else
            return "selected='selected'";
    }
}