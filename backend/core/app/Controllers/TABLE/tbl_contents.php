<?php

$fungsi       = new Libraries\fungsi;
$dbSekolah    = new Models\DbSekolah;
$table        = "tbl_contents";
$noid         = $jreq->noid;
$data_member  = $db->singleRow("SELECT * FROM tbl_member_channel WHERE noid = '$noid' AND interface = 'MOBILE'");
$kode_sekolah = $data_member->kode_sekolah;
$cek_sekolah  = $dbSekolah->cekId('tbl_sekolah', 'kode_sekolah', $kode_sekolah);
$id_sekolah   = $cek_sekolah->id;

if($action_request == "add"){
        $noid       = $jreq->noid;
        $id_content = uniqid();
        $title      = ucwords($jreq->detail->title);
        $highlight  = $jreq->detail->highlight;

        $content = json_encode($jreq->detail->content);
        $tags    = json_encode($jreq->detail->tags);
        $images  = "{}";
        $files   = "{}";
        

        $query = "INSERT INTO $table (id_content, noid, title, highlight, contents, tags, images, files, created_by) "
            . " VALUES ('$id_content', '$noid','$title', '$highlight', '$content', '$tags', '$images', '$files', '$noid') RETURNING id;";

        $arr = $dbSekolah->cekId($table, 'id_content', $id_content);

        if (!isset($arr->id)) {
            $return   = $dbSekolah->singlerow($query);
            $response = array(
                'response_code'    => '0000',
                'response_message' => 'Tambah data Contents Berhasil',
                'detail'           => array(
                    'id' => $return->id,
                ),
            );
        } else {
            $response = array(
                'response_code'    => '0099',
                'response_message' => 'Tambah data Contents Gagal',
            );
        }
        $reply = json_encode($response);
}else if($action_request == "pollQuestion"){
        $page   = $jreq->page != '' ? $jreq->page : 0;
        $limit  = $jreq->limit != '' ? $jreq->limit : 2;
        $offset = $page * $limit;
        $main   = isset($jreq->filter_search->main) ? "$jreq->filter_search->main" : "$action_request";

        $sort  = 'title';
        $order = 'desc';
		
		$paging          = "";
        $filter_def_noid = '';
        $filter_search   = "";
        if (!empty($main)) {
            $filter_search .= "AND tags->>'main' = '$main'";
        }
        if (!empty($id_sekolah)) {
            $filter_search .= "AND contents->>'id_sekolah' = '$id_sekolah'";
        }
		if($jreq->limit != '' && $jreq->page != ''){
			$paging = "limit $limit offset $page";
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
            tbl_contents.created_by,
			tbl_contents.create_time AS date_created
            FROM tbl_contents
            where 1=1 $filter_search $filter_def_noid order by $sort $order $paging;";
			
        
        $sql_count = "SELECT
            count(tbl_contents.title) as jml
            
            FROM tbl_contents
            where 1=1 $filter_search;";

        $data = $dbSekolah->multipleRow($sql);
        $no   = $offset + 1; // add number
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $data_author        = $db->cekId('tbl_member_account', 'noid', $value->created_by);
                $data[$key]->author = isset($data_author->nama) ? $data_author->nama : "";
                $data[$key]->no     = $no++;
                $images             = $value->images;
                $files              = $value->files;

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
        $arr_count                 = $dbSekolah->singleRow($sql_count);        
        $result['recordsTotal']    = $arr_count->jml;
        $result['recordsFiltered'] = $arr_count->jml;
        $result['data']            = $data; //$dbSekolah->multipleRow($sql);
        $reply = json_encode($result);
}else if($action_request == "homeroomteacher2"){
        $page   = $jreq->page != '' ? $jreq->page : 0;
        $limit  = $jreq->limit != '' ? $jreq->limit : 2;
        $offset = $page * $limit;
        $main   = isset($jreq->filter_search->main) ? "$jreq->filter_search->main" : "$action_request";

        $sort  = 'create_time';
        $order = 'desc';
		
		$paging          = "";
        $filter_def_noid = '';
        $filter_search   = "";
        if (!empty($main)) {
            $filter_search .= "AND tags->>'main' = '$main'";
        }
        if (!empty($id_sekolah)) {
            $filter_search .= "AND contents->>'id_sekolah' = '$id_sekolah'";
        }
		if($jreq->limit != '' && $jreq->page != ''){
			$paging = "limit $limit offset $page";
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
            tbl_contents.created_by,
			tbl_contents.create_time AS date_created
            FROM tbl_contents
            where 1=1 $filter_search $filter_def_noid order by $sort $order $paging;";
			
        $sql_count = "SELECT
            count(tbl_contents.title) as jml
            
            FROM tbl_contents
            where 1=1 $filter_search;";

        $data = $dbSekolah->multipleRow($sql);
        $no   = $offset + 1; // add number
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $data_author        = $db->cekId('tbl_member_account', 'noid', $value->created_by);
                $data[$key]->author = isset($data_author->nama) ? $data_author->nama : "";
                $data[$key]->no     = $no++;
                $images             = $value->images;
                $files              = $value->files;

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
        $arr_count                 = $dbSekolah->singleRow($sql_count);        
        $result['recordsTotal']    = $arr_count->jml;
        $result['recordsFiltered'] = $arr_count->jml;
        $result['data']            = $data; //$dbSekolah->multipleRow($sql);
        $reply = json_encode($result);
	
}else if($action_request == "homeroomteacher"){
        $filter_search   = "";
        $noid        = $jreq->noid;
        $data_member = $db->cekId('tbl_member_channel', 'noid', $noid);
        $id_sekolah  = $data_member->kode_sekolah;
        $cek_sekolah = $dbSekolah->cekId('tbl_sekolah','kode_sekolah',$id_sekolah);
        $id_sekolah_ = $cek_sekolah->id;
        $id_siswa    = (isset($jreq->detail->id_siswa)) ? $jreq->detail->id_siswa : '';
        $status      = (isset($jreq->detail->status)) ? $jreq->detail->status : '';

        $sql_cek_siswa = "SELECT kode_sekolah, nis FROM tbl_member_channel WHERE noid = '$noid' AND interface = 'NFC' $filter_search";
        $data_siswa    = $db->multipleRow($sql_cek_siswa);
        $w_siswa = "";
        if(count($data_siswa) > 1){            
            foreach ($data_siswa as $key => $value) {
                $data_siswa_ = $dbSekolah->cekId('tbl_siswa', 'nis', $value->nis);
                $id_siswa    = $data_siswa_->id;
                $w_siswa .= "OR contents->>'siswa' = '$id_siswa'";
            }
        }else{
            $data_siswa_ = $dbSekolah->cekId('tbl_siswa', 'nis', $data_siswa[0]->nis);
            $id_siswa    = $data_siswa_->id;
            $w_siswa = "AND contents->>'siswa' = '$id_siswa'";
        }
        $page   = $jreq->page != '' ? $jreq->page : 0;
        $limit  = $jreq->limit != '' ? $jreq->limit : 2;
        $offset = $page * $limit;
        $main   = isset($jreq->filter_search->main) ? "$jreq->filter_search->main" : "$action_request";

        $sort  = 'create_time';
        $order = 'desc';
        
        $paging          = "";
        $filter_def_noid = '';
        if (!empty($main)) {
            $filter_search .= "AND tags->>'main' = '$main'";
        }
        if (!empty($id_sekolah_)) {
            $filter_search .= "AND contents->>'id_sekolah' = '$id_sekolah_'";
        }
        if($jreq->limit != '' && $jreq->page != ''){
            $paging = "limit $limit offset $page";
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
            tbl_contents.created_by,
            tbl_contents.create_time AS date_created
            FROM tbl_contents
            where 1=1 $w_siswa $filter_search $filter_def_noid order by $sort $order $paging;";
            
        $sql_count = "SELECT
            count(tbl_contents.title) as jml
            
            FROM tbl_contents
            where 1=1 $filter_search;";

        $data = $dbSekolah->multipleRow($sql);
        $no   = $offset + 1; // add number
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $data_author        = $db->cekId('tbl_member_account', 'noid', $value->created_by);
                $data[$key]->author = isset($data_author->nama) ? $data_author->nama : "";
                $data[$key]->no     = $no++;
                $images             = $value->images;
                $files              = $value->files;

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
        $arr_count                 = $dbSekolah->singleRow($sql_count);        
        $result['recordsTotal']    = $arr_count->jml;
        $result['recordsFiltered'] = $arr_count->jml;
        $result['data']            = $data; //$dbSekolah->multipleRow($sql);
        $reply = json_encode($result);
    
}else{
        $page   = $jreq->page != '' ? $jreq->page : 0;
        $limit  = $jreq->limit != '' ? $jreq->limit : 2;
        $offset = $page * $limit;
        $main   = isset($jreq->filter_search->main) ? "$jreq->filter_search->main" : "$action_request";

        $sort  = 'create_time';
        $order = 'desc';
        
        $paging          = "";
        $filter_def_noid = '';
        $filter_search   = "";
        if (!empty($main)) {
            $filter_search .= "AND tags->>'main' = '$main'";
        }
        if (!empty($id_sekolah)) {
            $filter_search .= "AND contents->>'id_sekolah' = '$id_sekolah'";
        }
        if($jreq->limit != '' && $jreq->page != ''){
            $paging = "limit $limit offset $page";
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
            tbl_contents.created_by,
            tbl_contents.create_time AS date_created
            FROM tbl_contents
            where 1=1 $filter_search $filter_def_noid order by $sort $order $paging;";
            
        $sql_count = "SELECT
            count(tbl_contents.title) as jml
            
            FROM tbl_contents
            where 1=1 $filter_search;";

        $data = $dbSekolah->multipleRow($sql);
        $no   = $offset + 1; // add number
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $data_author        = $db->cekId('tbl_member_account', 'noid', $value->created_by);
                $data[$key]->author = isset($data_author->nama) ? $data_author->nama : "";
                $data[$key]->no     = $no++;
                $images             = $value->images;
                $files              = $value->files;

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
        $arr_count                 = $dbSekolah->singleRow($sql_count);        
        $result['recordsTotal']    = $arr_count->jml;
        $result['recordsFiltered'] = $arr_count->jml;
        $result['data']            = $data; //$dbSekolah->multipleRow($sql);
        $reply = json_encode($result);
    
}