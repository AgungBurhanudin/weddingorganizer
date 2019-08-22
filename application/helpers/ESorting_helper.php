<?php
function ESortingColumn($url=null, $title=null, $order_by=null, $offset=null, $field=null, $order=null){
    if(!$offset)
        $offset='0';

    if(($field==$order_by)&&($order=='asc'))
        return anchor("$url/" . $offset . "/$order_by/desc", "$title", array('class' => 'asc'));
    elseif(($field==$order_by)&&($order=='desc'))
        return anchor("$url/" . $offset . "/$order_by/asc", "$title", array('class' => 'desc'));
    else
        return anchor("$url/" . $offset . "/$order_by/desc", "$title", array('class' => 'sort'));
}


