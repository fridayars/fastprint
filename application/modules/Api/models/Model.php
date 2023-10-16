<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Model extends CI_Model
{

    function getLogKirimUndian($postData = null)
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
            $searchQuery = " (`status` like '%" . $searchValue . "%' or `message` like '%" . $searchValue . "%' or tanggal like'%" . $searchValue . "%' or faktur like'%" . $searchValue . "%' or nama like'%" . $searchValue . "%' ) ";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $records = $this->db->order_by('faktur', 'DESC')->get_where('v_log_whatsapp', ['toko_id' => $_SESSION['toko_id']])->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if ($searchQuery != '')
            $this->db->where($searchQuery);
        $records = $this->db->order_by('faktur', 'DESC')->get_where('v_log_whatsapp', ['toko_id' => $_SESSION['toko_id']])->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('*');
        if ($searchQuery != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->order_by('faktur', 'DESC')->get_where('v_log_whatsapp', ['toko_id' => $_SESSION['toko_id']])->result();

        $data = array();
        $no = 1;
        foreach ($records as $record) { 

            $data[] = array(
                "no"        => $no,
                "tanggal"   => $record->tanggal,
                "nama"      => $record->nama,
                "faktur"    => $record->faktur,
                "status"    => ($record->status == 'success' || $record->status == 'belum dikirim') ? (($record->status == 'belum dikirim') ? '<span style="color:orange;font-weight:bold">belum dikirim</span>' : '<span style="color:green;font-weight:bold">'.$record->status.'</span>') : '<span style="color:red;font-weight:bold">'.$record->status.' : '.$record->message.'</span>',
                "log"       => ($record->status == 'success') ? '<a href="#" onClick="modalLog('. $record->pembayaran_id .')" id="'.$record->pembayaran_id.'" value="'. $record->uuid .'">Lihat</a>' : '',
                "button"    => '<a href="'. base_url() . 'Api/whatsapp/send_undian/'. $record->pembayaran_id . '/' . $record->pasien_new_id .'" class="btn btn-primary btn-sm">Kirim Undian</a>'
            );

            $no++;
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
