<?php

$fungsi    = new Libraries\fungsi;
$table     = "tbl_contents";
$dbSekolah = new Models\DbSekolah();

switch ($action_request) {

    case "get":

        $offset = $jreq->start != '' ? $jreq->start : 0;
        $rows   = $jreq->length != '' ? $jreq->length : 10;
        $main   = $jreq->detail->main;

        $sort  = 'title';
        $order = $jreq->order[0]->dir != '' ? $jreq->order[0]->dir : 'desc';

        $filter_def_noid = '';
        $filter_search   = "";
        if (!empty($main)) {
            $filter_search .= "AND tags->>'main' = '$main'";
        }

        $sql = "SELECT
        tbl_contents.id,
        tbl_contents.title,
        tbl_contents.highlight,
        tbl_contents.contents,
        tbl_contents.tags,
        tbl_contents.images,
        tbl_contents.files,
        tbl_contents.status,
        tbl_member_account.nama AS author
        FROM tbl_contents
        LEFT JOIN tbl_member_account on tbl_contents.created_by = tbl_member_account.noid
        where 1=1 $filter_search $filter_def_noid order by $sort $order limit $rows offset $offset;";

        $sql_count = "select count(id) as jml from tbl_sekolah where 1 = 1 $filter_search $filter_def_noid;";
//echo json_encode($sql);
        $data = $dbSekolah->multipleRow($sql);
        $no   = $offset + 1; // add number
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $data[$key]->no = $no++;
                $images         = $value->images;
                $files          = $value->files;

                //For Image
                $data_images = json_decode($images, true);
                // print_r($data_images);
                if (!empty($data_images)) {
                    for ($kk = 0; $kk < count($data_images); $kk++) {
                        if (isset($data_images[$kk]['image'])) {
                            $data_images[$kk]['images_location'] = "public/images/" . $data_images[$kk]['image'];
                        }
                    }
                } else {
                    $data_images = null;
                }
                $data[$key]->images = $data_images;

                //For Files

                $data_files = json_decode($files, true);
                // print_r($data_images);
                if (!empty($data_files)) {
                    for ($kk = 0; $kk < count($data_files); $kk++) {
                        $data_files[$kk]['files_location'] = "public/files/" . $data_files[$kk]['file'];
                    }
                } else {
                    $data_files = null;
                }
                $data[$key]->files = $data_files;
            }
        } else {
            $data = array();
        }
        $arr_count                 = count($data); //$dbSekolah->singleRow($sql_count);
        $result['draw']            = $jreq->draw;
        $result['recordsTotal']    = $arr_count; //->jml;
        $result['recordsFiltered'] = $arr_count; //->jml;
        $result['data']            = $data; //$dbSekolah->multipleRow($sql);
        $this->outputJSON($result);
        break; // End Add Data

}
;
