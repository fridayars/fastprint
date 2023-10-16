<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Discount extends CI_Model
{

    function get_vDirect($postData = null)
    {

        $response = array();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        ## Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery = "( nama like '%" . $searchValue . "%' or deskripsi like '%" . $searchValue . "%'or kode_voucher like '%" . $searchValue . "%' ) ";
        }

        ## Total number of records without filtering
        if($_SESSION['toko_id'] == 99){
            $records = $this->db->select('count(*) as allcount')->from('tb_voucher_diskon A')
            ->join('tb_voucher_kode B', 'A.id = B.voucher_diskon_id')->join('tb_voucher_jenis C', 'A.voucher_jenis_id = C.id')
            ->where(['A.is_delete' => 0, 'A.voucher_kategori_id' => 1])->get()->result();
        }else{
            $records = $this->db->select('count(*) as allcount')->from('tb_voucher_diskon A')
            ->join('tb_voucher_kode B', 'A.id = B.voucher_diskon_id')->join('tb_voucher_jenis C', 'A.voucher_jenis_id = C.id')->join('tb_voucher_toko D', 'A.id = D.voucher_diskon_id')
            ->where(['A.is_delete' => 0, 'A.voucher_kategori_id' => 1, 'D.toko_id' => $_SESSION['toko_id']])->get()->result();
        }

        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        if($_SESSION['toko_id'] == 99){
            $this->db->select('count(*) as allcount')->from('tb_voucher_diskon A')
            ->join('tb_voucher_kode B', 'A.id = B.voucher_diskon_id')->join('tb_voucher_jenis C', 'A.voucher_jenis_id = C.id')
            ->where(['A.is_delete' => 0, 'A.voucher_kategori_id' => 1]);
            if ($searchQuery != '') $this->db->where($searchQuery);
            $records = $this->db->get()->result();
        }else{
            $this->db->select('count(*) as allcount')->from('tb_voucher_diskon A')
            ->join('tb_voucher_kode B', 'A.id = B.voucher_diskon_id')->join('tb_voucher_jenis C', 'A.voucher_jenis_id = C.id')->join('tb_voucher_toko D', 'A.id = D.voucher_diskon_id')
            ->where(['A.is_delete' => 0, 'A.voucher_kategori_id' => 1, 'D.toko_id' => $_SESSION['toko_id']]);
            if ($searchQuery != '') $this->db->where($searchQuery);
            $records = $this->db->get()->result();
        }
    
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        if($_SESSION['toko_id'] == 99){
            $this->db->select('A.*, B.kode_voucher, C.opsi')->from('tb_voucher_diskon A')
            ->join('tb_voucher_kode B', 'A.id = B.voucher_diskon_id')->join('tb_voucher_jenis C', 'A.voucher_jenis_id = C.id')
            ->where(['A.is_delete' => 0, 'A.voucher_kategori_id' => 1]);
            if ($searchQuery != '') $this->db->where($searchQuery);
            $this->db->order_by($columnName, $columnSortOrder);
            $this->db->limit($rowperpage, $start);
            $records = $this->db->get()->result();
        }else{
            $this->db->select('A.*, B.kode_voucher, C.opsi')->from('tb_voucher_diskon A')
            ->join('tb_voucher_kode B', 'A.id = B.voucher_diskon_id')->join('tb_voucher_jenis C', 'A.voucher_jenis_id = C.id')->join('tb_voucher_toko D', 'A.id = D.voucher_diskon_id')
            ->where(['A.is_delete' => 0, 'A.voucher_kategori_id' => 1, 'D.toko_id' => $_SESSION['toko_id']]);
            if ($searchQuery != '') $this->db->where($searchQuery);
            $this->db->order_by($columnName, $columnSortOrder);
            $this->db->limit($rowperpage, $start);
            $records = $this->db->get()->result();
        }

        $no = 1;
        $data = array();
        foreach ($records as $record) { 
            $tokos = $this->db->query("SELECT B.* FROM tb_voucher_toko A join toko B on A.toko_id = B.id where A.voucher_diskon_id = $record->id")->result_array();
            $nama_toko = "";
            foreach($tokos as $key => $toko){
                $nama_toko .= $toko['nama'];
                if($key < count($tokos)-1){
                    $nama_toko .= ", ";
                }
            }
            $data[] = array(
                "no"           => $no++,
                "nama"         => $record->nama,
                "deskripsi"    => $record->deskripsi,
                "opsi"         => $record->opsi,
                "kode_voucher" => $record->kode_voucher,
                "berlaku"      => $nama_toko,
                "button"       => '<a href="'. base_url(). 'Administrasi/Diskon/edit/'. $record->id .'" class="btn btn-info btn-sm"><i class="fa fa-pen"></i></a>&nbsp;&nbsp;'.
                '<a href="'. base_url(). 'Administrasi/Diskon/listItem/'. $record->id .'" class="btn btn-warning btn-sm"><i class="fa fa-list"></i></a>&nbsp;&nbsp;'.
                '<a href="'. base_url(). 'Administrasi/Diskon/delete/'. $record->id .'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;'.
                '<a href="'. base_url(). 'Administrasi/Diskon/downloadTemplate/'. $record->kode_voucher .'" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-download"></i></a>'
            );
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        return $response;
    }

    function get_vGenerate($postData = null)
    {

        $response = array();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        ## Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery = "( nama like '%" . $searchValue . "%' or deskripsi like '%" . $searchValue . "%'or kode_voucher like '%" . $searchValue . "%' ) ";
        }

        ## Total number of records without filtering
        if($_SESSION['toko_id'] == 99){
            $records = $this->db->select('count(*) as allcount')->from('tb_voucher_diskon A')
            ->join('tb_voucher_kode B', 'A.id = B.voucher_diskon_id')->join('tb_voucher_jenis C', 'A.voucher_jenis_id = C.id')
            ->where(['A.is_delete' => 0, 'A.voucher_kategori_id' => 2])->get()->result();
        }else{
            $records = $this->db->select('count(*) as allcount')->from('tb_voucher_diskon A')
            ->join('tb_voucher_kode B', 'A.id = B.voucher_diskon_id')->join('tb_voucher_jenis C', 'A.voucher_jenis_id = C.id')->join('tb_voucher_toko D', 'A.id = D.voucher_diskon_id')
            ->where(['A.is_delete' => 0, 'A.voucher_kategori_id' => 2, 'D.toko_id' => $_SESSION['toko_id']])->get()->result();
        }

        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        if($_SESSION['toko_id'] == 99){
            $this->db->select('count(*) as allcount')->from('tb_voucher_diskon A')
            ->join('tb_voucher_kode B', 'A.id = B.voucher_diskon_id')->join('tb_voucher_jenis C', 'A.voucher_jenis_id = C.id')
            ->where(['A.is_delete' => 0, 'A.voucher_kategori_id' => 2]);
            if ($searchQuery != '') $this->db->where($searchQuery);
            $records = $this->db->get()->result();
        }else{
            $this->db->select('count(*) as allcount')->from('tb_voucher_diskon A')
            ->join('tb_voucher_kode B', 'A.id = B.voucher_diskon_id')->join('tb_voucher_jenis C', 'A.voucher_jenis_id = C.id')->join('tb_voucher_toko D', 'A.id = D.voucher_diskon_id')
            ->where(['A.is_delete' => 0, 'A.voucher_kategori_id' => 2, 'D.toko_id' => $_SESSION['toko_id']]);
            if ($searchQuery != '') $this->db->where($searchQuery);
            $records = $this->db->get()->result();
        }
    
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        if($_SESSION['toko_id'] == 99){
            $this->db->select('A.*, B.kode_voucher, C.opsi')->from('tb_voucher_diskon A')
            ->join('tb_voucher_kode B', 'A.id = B.voucher_diskon_id')->join('tb_voucher_jenis C', 'A.voucher_jenis_id = C.id')
            ->where(['A.is_delete' => 0, 'A.voucher_kategori_id' => 2]);
            if ($searchQuery != '') $this->db->where($searchQuery);
            $this->db->order_by($columnName, $columnSortOrder);
            $this->db->limit($rowperpage, $start);
            $records = $this->db->get()->result();
        }else{
            $this->db->select('A.*, B.kode_voucher, C.opsi')->from('tb_voucher_diskon A')
            ->join('tb_voucher_kode B', 'A.id = B.voucher_diskon_id')->join('tb_voucher_jenis C', 'A.voucher_jenis_id = C.id')->join('tb_voucher_toko D', 'A.id = D.voucher_diskon_id')
            ->where(['A.is_delete' => 0, 'A.voucher_kategori_id' => 2, 'D.toko_id' => $_SESSION['toko_id']]);
            if ($searchQuery != '') $this->db->where($searchQuery);
            $this->db->order_by($columnName, $columnSortOrder);
            $this->db->limit($rowperpage, $start);
            $records = $this->db->get()->result();
        }

        $no = 1;
        $data = array();
        foreach ($records as $record) { 
            $tokos = $this->db->query("SELECT B.* FROM tb_voucher_toko A join toko B on A.toko_id = B.id where A.voucher_diskon_id = $record->id")->result_array();
            $nama_toko = "";
            foreach($tokos as $key => $toko){
                $nama_toko .= $toko['nama'];
                if($key < count($tokos)-1){
                    $nama_toko .= ", ";
                }
            }
            $data[] = array(
                "no"           => $no++,
                "nama"         => $record->nama.'&nbsp;&nbsp;<a href="'. base_url(). 'Administrasi/Diskon/bulkDownloadTemplate/'. $record->id .'" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-download"> download zip</i></a>',
                "deskripsi"    => $record->deskripsi,
                "opsi"         => $record->opsi,
                "kode_voucher" => $record->kode_voucher.'&nbsp;&nbsp;<a href="'. base_url(). 'Administrasi/Diskon/downloadTemplate/'. $record->kode_voucher .'" class="btn btn-primary btn-sm" target="_blank"><i class="fa fa-download"></i></a>',
                "berlaku"      => $nama_toko,
                "button"       => '<a href="'. base_url(). 'Administrasi/Diskon/edit/'. $record->id .'" class="btn btn-info btn-sm"><i class="fa fa-pen"></i></a>&nbsp;&nbsp;'.
                '<a href="'. base_url(). 'Administrasi/Diskon/listItem/'. $record->id .'" class="btn btn-warning btn-sm"><i class="fa fa-list"></i></a>&nbsp;&nbsp;'.
                '<a href="'. base_url(). 'Administrasi/Diskon/delete/'. $record->id .'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>'
            );
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        return $response;
    }

    function jsonListItemProduct($voucher_id, $postData = null)
	{
		$response = array();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        ## Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery = "( C.nama like '%" . $searchValue . "%' or C.harga_jual like '%" . $searchValue . "%' ) ";
        }

        ## Total number of records without filtering
        $records = $this->db->select('count(*) as allcount')->from('tb_voucher_detail_item A')
        ->join('tb_voucher_diskon B', 'A.voucher_diskon_id = B.id')->join('master_produk C', 'A.produk_id = C.id')
        ->where(['B.id' => $voucher_id])->get()->result();

        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount')->from('tb_voucher_detail_item A')
        ->join('tb_voucher_diskon B', 'A.voucher_diskon_id = B.id')->join('master_produk C', 'A.produk_id = C.id')
        ->where(['B.id' => $voucher_id]);
        if ($searchQuery != '') $this->db->where($searchQuery);
        $records = $this->db->get()->result();
    
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('A.id, A.diskon_item, C.nama, C.harga_jual, B.voucher_jenis_id')->from('tb_voucher_detail_item A')
        ->join('tb_voucher_diskon B', 'A.voucher_diskon_id = B.id')->join('master_produk C', 'A.produk_id = C.id')
        ->where(['B.id' => $voucher_id]);
        if ($searchQuery != '') $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();

        $no = 1;
        $data = array();
        foreach ($records as $record) { 

            if($record->voucher_jenis_id == 3){
                $diskon_item = number_format($record->diskon_item) . ' <button type="button" class="btn btn-primary btn-sm" onclick="modalDiskonItem('. $record->id . ','. $record->diskon_item .')"><i class="fa fa-pen"></i></button>';
            }else{
                $diskon_item = "~";
            }

            $data[] = array(
                "no"           => $no++,
                "nama"         => $record->nama,
                "harga_jual"   => number_format($record->harga_jual),
                "diskon_item"  => $diskon_item,
                "button"       => '<a href="'. base_url(). 'Administrasi/Diskon/deleteItem/'. $record->id .'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>'
            );
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        return $response;
	}

    function jsonListItemTreatment($voucher_id, $postData = null)
	{
		$response = array();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        ## Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery = "( C.nama_treatment like '%" . $searchValue . "%' or C.tarif like '%" . $searchValue . "%' ) ";
        }

        ## Total number of records without filtering
        $records = $this->db->select('count(*) as allcount')->from('tb_voucher_detail_item A')
        ->join('tb_voucher_diskon B', 'A.voucher_diskon_id = B.id')->join('master_treatment C', 'A.treatment_id = C.id')
        ->where(['B.id' => $voucher_id])->get()->result();

        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount')->from('tb_voucher_detail_item A')
        ->join('tb_voucher_diskon B', 'A.voucher_diskon_id = B.id')->join('master_treatment C', 'A.treatment_id = C.id')
        ->where(['B.id' => $voucher_id]);
        if ($searchQuery != '') $this->db->where($searchQuery);
        $records = $this->db->get()->result();
    
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('A.id, A.diskon_item, C.nama_treatment, C.tarif, B.voucher_jenis_id')->from('tb_voucher_detail_item A')
        ->join('tb_voucher_diskon B', 'A.voucher_diskon_id = B.id')->join('master_treatment C', 'A.treatment_id = C.id')
        ->where(['B.id' => $voucher_id]);
        if ($searchQuery != '') $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();

        $no = 1;
        $data = array();
        foreach ($records as $record) { 

            if($record->voucher_jenis_id == 3){
                $diskon_item = number_format($record->diskon_item) . ' <button type="button" class="btn btn-primary btn-sm" onclick="modalDiskonItem('. $record->id . ','. $record->diskon_item .')"><i class="fa fa-pen"></i></button>';
            }else{
                $diskon_item = "~";
            }

            $data[] = array(
                "no"             => $no++,
                "nama_treatment" => $record->nama_treatment,
                "tarif"          => number_format($record->tarif),
                "diskon_item"    => $diskon_item,
                "button"         => '<a href="'. base_url(). 'Administrasi/Diskon/deleteItem/'. $record->id .'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>'
            );
        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        return $response;
	}

    function get_template($postData = null)
    {

        $response = array();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        ## Search 
        $searchQuery = "";
        if ($searchValue != '') {
            $searchQuery = "( nama_template like '%" . $searchValue . "%' or file_url like '%" . $searchValue . "%' ) ";
        }

        ## Total number of records without filtering
        $records = $this->db->select('count(*) as allcount')->from('tb_voucher_template')
        ->where(['is_delete' => 0])->get()->result();

        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount')->from('tb_voucher_template')->where(['is_delete' => 0]);
        if ($searchQuery != '') $this->db->where($searchQuery);
        $records = $this->db->get()->result();

        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('*')->from('tb_voucher_template')->where(['is_delete' => 0]);
        if ($searchQuery != '') $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();

        $no = 1;
        $data = array();
        foreach ($records as $record) {

            $data[] = array(
                "no"            => $no++,
                "nama_template" => $record->nama_template,
                "file_url"      => '<a href="'. base_url(). 'assets/template/'. $record->file_url . '" target="_blank">'. $record->file_url .'</a>',
                "button"        => '<a href="'. base_url(). 'Administrasi/Diskon/edit_template/'. $record->id .'" class="btn btn-info btn-sm"><i class="fa fa-pen"></i></a>&nbsp;&nbsp;'.
                '<a href="'. base_url(). 'Administrasi/Diskon/delete_template/'. $record->id .'" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>'
            );

        }

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        return $response;
    }
}
