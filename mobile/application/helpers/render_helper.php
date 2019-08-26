<?php

function render($main_content=null, $data=null) {
    $ci = & get_instance();
    $data['main_content'] = $main_content;
    $ci->load->view('include/template', $data);
}


