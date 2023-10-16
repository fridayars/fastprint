<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pasien_model extends CI_Model
{

    function getPasiens($postData = null)
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
            $searchQuery = " (no_rm like '%" . $searchValue . "%' or no_member like '%" . $searchValue . "%' or nama like'%" . $searchValue . "%' or alamat like'%" . $searchValue . "%' or no_hp like'%" . $searchValue . "%' or jenis_kelamin like'%" . $searchValue . "%' or id like'%" . $searchValue . "%' or prev_rm like'%" . $searchValue . "%' or note like'%" . $searchValue . "%' or tgl_lahir like'%" . $searchValue . "%' ) ";
            // $searchQuery = " (no_rm like '%" . $searchValue . "%' or no_member like '%" . $searchValue . "%' or nama like'%" . $searchValue . "%' or alamat like'%" . $searchValue . "%' or no_wa like'%" . $searchValue . "%' or jenis_kelamin like'%" . $searchValue . "%' ) ";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $records = $this->db->get_where('pasien', [ 'is_delete' => 0, 'is_active' => 1, 'no_rm !=' => NULL, 'jenis_kelamin != ' => NULL])->result();
        // $records = $this->db->get_where('pasien', ['toko_id' => $_SESSION['toko_id'], 'is_delete' => 0, 'is_active' => 1])->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        if ($searchQuery != '')
            $this->db->where($searchQuery);
        $records = $this->db->get_where('pasien', [ 'is_delete' => 0, 'is_active' => 1, 'no_rm !=' => NULL, 'jenis_kelamin != ' => NULL])->result();
        // $records = $this->db->get_where('pasien', ['toko_id' => $_SESSION['toko_id'], 'is_delete' => 0, 'is_active' => 1])->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('*');
        if ($searchQuery != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get_where('pasien', [ 'is_delete' => 0, 'is_active' => 1, 'no_rm !=' => NULL, 'jenis_kelamin != ' => NULL])->result();
        // $records = $this->db->get_where('pasien', ['toko_id' => $_SESSION['toko_id'], 'is_delete' => 0, 'is_active' => 1])->result();

        $data = array();

        foreach ($records as $record) { 

            if($record->note == '') {
                $note = $record->note;
            } else {
                $note = '<br><b>nb:</b> ['.$record->note.']';
            }

            if ($record->prev_rm == '') {
                $prev_rm = $record->prev_rm;
            } else {
                $prev_rm = '<b>RM Lama : </b>' . $record->prev_rm;
            }

            if($_SESSION['role_id'] == 3){
                $button = '<div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">Riwayat
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="' . base_url() . 'Administrasi/Pasien/riwayat_pasien/' . $record->new_id . '">Riwayat Pasien</a>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">Proses
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="' . base_url() . 'Administrasi/Pasien/edit/' . $record->new_id . '">Edit pasien</a>
                        <button class="dropdown-item" onclick="deletePasien('. $record->new_id .')">Hapus Pasien</button>
                    </div>
                </div>';
            }else{
                $button = '<div class="btn-group">
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-icon" data-toggle="dropdown">Riwayat
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="' . base_url() . 'Administrasi/Pasien/riwayat_pasien/' . $record->new_id . '">Riwayat Pasien</a>
                    </div>
                </div>';
            }

            $data[] = array(
                "no_rm" => $record->no_rm . '<br>' . $prev_rm,
                "id" => '<p hidden="true">'.$record->new_id.'</p>',
                "note" => '<p hidden="true">'.$record->note.'</p>',
                "prev_rm" => '<p hidden="true">'.$record->prev_rm.'</p>',
                "no_member" => $record->no_member,
                "nama" => $record->nama . $note,
                "alamat" => $record->alamat,
                "tgl_lahir" => $record->tempat_lahir . ', ' . $record->tgl_lahir,
                "jenis_kelamin" => $record->jenis_kelamin,
                "button" => $button,
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

    function get_history_pembayaran($id) { 
        $id_lama = $this->db->query("SELECT id from pasien where new_id = $id")->row()->id;
        $toko_id_pasien = $this->db->query("SELECT toko_id from pasien where new_id = $id")->row()->toko_id;
        // print_r($id_lama ." - ". $toko_id_pasien);die;

        $Query = $this->db->query("SELECT
            G.point_treatment,
            A.*,
            B.nama AS dokter,
            E.nama AS perawat,
            F.catatan as catatan_dokter,
            F.alergi,
            F.masalah,
            H.nama as pasien, T.nama as toko
        FROM
            pembayaran A
            left JOIN karyawan B ON B.id = A.dokter_id 
            AND B.toko_id = A.toko_id
            left JOIN perawatan C ON C.pembayaran_id = A.id 
            AND C.toko_id = A.toko_id
            LEFT JOIN perawatan_detail D ON D.perawatan_id = C.id 
            AND D.toko_id = A.toko_id
            LEFT JOIN karyawan E ON E.id = D.karyawan_id 
            AND E.toko_id = A.toko_id
            left JOIN konsultasi F ON F.pembayaran_id = A.id 
            AND F.toko_id = A.toko_id
            left JOIN poin_reward G ON G.id_pembayaran = A.id 
            AND G.toko_id = A.toko_id
            left JOIN pasien H ON H.new_id = A.pasien_new_id 
            left join toko T on T.id = A.toko_id
        WHERE
            A.pasien_new_id = '$id' 
            AND A.STATUS >= 2 
        GROUP BY
            A.id 
        ORDER BY
            A.id DESC")->result_array(); 
        // $Query = $this->db->query("SELECT A.*, B.nama as dokter, E.nama as perawat, F.catatan FROM pembayaran A LEFT JOIN karyawan B ON B.id = A.dokter_id LEFT JOIN perawatan C ON C.pembayaran_id = A.id LEFT JOIN perawatan_detail D ON D.perawatan_id = C.id LEFT JOIN karyawan E ON E.id = D.karyawan_id LEFT JOIN konsultasi F ON F.pembayaran_id = A.id WHERE A.pasien_id = $id AND A.status >= 2 GROUP BY A.id ORDER BY A.id DESC"); 
        return $Query; 
    }

	function get_history_perawatan($id)
	{
        $id_lama = $this->db->query("SELECT id from pasien where new_id = $id")->row()->id;
        $toko_id_pasien = $this->db->query("SELECT toko_id from pasien where new_id = $id")->row()->toko_id;

		$Query = $this->db->query("SELECT
            G.point_treatment,
            C.jumlah,
            D.nama,
            A.id AS pembayaran_id 
        FROM
            pembayaran A
            left JOIN perawatan B ON B.pembayaran_id = A.id 
            AND B.toko_id = A.toko_id
            left JOIN perawatan_detail C ON C.perawatan_id = B.id 
            AND C.toko_id = A.toko_id
            LEFT JOIN treatment D ON D.id = C.treatment_id 
            AND D.toko_id = A.toko_id
            left JOIN poin_reward G ON G.id_pembayaran = A.id 
            AND G.toko_id = A.toko_id
            left JOIN pasien H ON H.new_id = A.pasien_new_id
        WHERE
            A.pasien_new_id = '$id' 
            AND A.STATUS >= 2 
        ORDER BY
            A.id DESC");
		// $Query = $this->db->query("SELECT C.jumlah, D.nama, A.id as pembayaran_id FROM pembayaran A JOIN perawatan B ON B.pembayaran_id = A.id LEFT JOIN perawatan_detail C ON C.perawatan_id = B.id LEFT JOIN treatment D ON D.id = C.treatment_id WHERE A.pasien_id = $id AND A.status >= 2 ORDER BY A.id DESC");
		return $Query->result_array();
	}

	function get_history_penjualan($id)
	{
        $id_lama = $this->db->query("SELECT id from pasien where new_id = $id")->row()->id;
        $toko_id_pasien = $this->db->query("SELECT toko_id from pasien where new_id = $id")->row()->toko_id;

		$Query = $this->db->query("SELECT
            A.pasien_id,
            G.point_treatment,
            C.jumlah,
            C.cara_pakai,
            D.nama,
            A.id AS pembayaran_id, H.nama as pasien
        FROM
            pembayaran A
            left JOIN penjualan B ON B.pembayaran_id = A.id and B.toko_id = A.toko_id
            left JOIN penjualan_detail C ON C.penjualan_id = B.id and C.toko_id = A.toko_id
            left JOIN produk_obat_bahan D ON D.id = C.obat_id and D.toko_id = A.toko_id
            left JOIN poin_reward G ON G.id_pembayaran = A.id and G.toko_id = A.toko_id
            left JOIN pasien H ON H.new_id = A.pasien_new_id
        WHERE
            A.pasien_new_id = '$id' AND A.STATUS >= 2
        ORDER BY
            A.id DESC");
		// $Query = $this->db->query("SELECT C.jumlah, D.nama, A.id as pembayaran_id FROM pembayaran A JOIN penjualan B ON B.pembayaran_id = A.id LEFT JOIN penjualan_detail C ON C.penjualan_id = B.id LEFT JOIN produk_obat_bahan D ON D.id = C.obat_id WHERE A.pasien_id = $id AND A.status >= 2 ORDER BY A.id DESC");
		return $Query->result_array();
	}
    function get_rm_treatment($pasien)
    {
        $Query = $this->db->query("SELECT * FROM rm_treatment_migrasi WHERE paid = 1 AND code = '$pasien'")->result_array();
        return $Query;
    }

    function get_rm_obat($pasien)
    {
        $Query = $this->db->query("SELECT * FROM rm_obat_migrasi WHERE `code` = '$pasien'")->result_array();
        return $Query;
    }
    
    public function updateMember($object)
    {
        $this->db->update('Table', $object);
    }
}
