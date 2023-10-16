<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Pasien extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load->model('model');
        $this->load->model('Pasien_model');
        $this->load->model('relasi');
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('download');
        $this->load->helper('html');
        $this->load->library('form_validation');
        if (!$_SESSION['logged_in']) redirect(site_url() . "Login");
        
        if ($_SESSION['role_id'] == 6 || $_SESSION['role_id'] == 4) {            
            redirect('Dashboard','refresh');            
        }
    }
    public  function Date2String($dTgl)
    {
        //return 2012-11-22
        list($cMount, $cDate, $cYear)    = explode("/", $dTgl);
        if (strlen($cDate) == 2) {
            $dTgl    = $cYear . "-" . $cMount . "-" . $cDate;
        }
        return $dTgl;
    }

    public  function String2Date($dTgl)
    {
        //return 22-11-2012  
        list($cYear, $cMount, $cDate)    = explode("-", $dTgl);
        if (strlen($cYear) == 4) {
            $dTgl    = $cMount . "/" . $cDate . "/" . $cYear;
        }
        return $dTgl;
    }

    public function TimeStamp()
    {
        date_default_timezone_set("Asia/Jakarta");
        $Data = date("H:i:s");
        return $Data;
    }

    public function DateStamp()
    {
        date_default_timezone_set("Asia/Jakarta");
        $Data = date("Y-m-d");
        return $Data;
    }

    public function DateTimeStamp()
    {
        date_default_timezone_set("Asia/Jakarta");
        $Data = date("Y-m-d h:i:s");
        return $Data;
    }

    public function exact_length_validation($str)
    {
        $length = strlen(str_replace(' ','',$str));
        if ($length == 7 || $length == 12 || $length == 14 || $length == 16) {
            return true;
        } else {
            $this->form_validation->set_message('exact_length_validation', '%s harus memiliki panjang persis 16, 14, 12, atau 7 digit/karakter');
            return false;
        }
    }

    public function first_number_validation($str)
    {
        if (substr($str, 0, 1) == 8) {
            return true;
        } else {
            $this->form_validation->set_message('first_number_validation', 'Format %s harus sesuai diawali dengan angka 8');
            return false;
        }
    }

    public function index()
    {
        $dataHeader['title'] = "Data Pasien Klinik";
        $dataHeader['menu'] = 'Data Pasien Klinik';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';
        $data['cabang'] = $this->model->Code("SELECT id, nama FROM toko");
        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('list_pasien', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function get_pasien()
    {
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->Pasien_model->getPasiens($postData);

        echo json_encode($data);
    }

    public function riwayat_pasien($id)
    {
        $dataHeader['title'] = "Data Riwayat Pasien Klinik";
        $dataHeader['menu'] = 'Data Riwayat Pasien Klinik';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';
        $data['pasien'] = $this->db->get_where("pasien", ['new_id' => $id])->row_array();
        
        // ini tambahan
        
        $data['member'] = $this->db->query("SELECT no_member FROM pasien WHERE new_id = '$id'")->row()->no_member;
        $data['poin'] = $this->db->query("SELECT jumlah as point_treatment FROM stock_poin_pasien WHERE pasien_new_id = '".$id."'")->row_array();
        $pasien = $data['pasien']['no_rm']; //ambil nama pasien

        // ini tambahan

		$data['arr_rm_treatment'] = $this->Pasien_model->get_rm_treatment($pasien); // ambil rm treatment dr tabel rm migrasi
		$data['arr_rm_obat'] = $this->Pasien_model->get_rm_obat($pasien); // ambil rm treatment dr tabel rm migrasi

        // $data['riwayats'] = $this->model->Code("SELECT B.*, A.*,C.nama as treatment , D.nama AS dokter  FROM perawatan A LEFT JOIN perawatan_detail B ON B.perawatan_id = A.id LEFT JOIN treatment C ON C.id = B.treatment_id LEFT JOIN karyawan AS D ON A.dokter_id = D.id WHERE A.pasien_id = '".$data['pasien']['id']."'");
        $data['arrpembayaran'] = $this->Pasien_model->get_history_pembayaran($id);
        $data['arrperawatan'] = $this->Pasien_model->get_history_perawatan($id);
        $data['arrpenjualan'] = $this->Pasien_model->get_history_penjualan($id);
        $data['arrperawatan2'] = array();
        foreach ($data['arrperawatan'] as $index => $value) {
            $data['arrperawatan2'][$value['pembayaran_id']][] = $value;
        }
        $data['arrpenjualan2'] = array();
        foreach ($data['arrpenjualan'] as $index => $value) {
            $data['arrpenjualan2'][$value['pembayaran_id']][] = $value;
        }
        // print_r($data['arrpenjualan']);die;
        // ini tambahan 
        
        $path_to_file = getcwd(). '/assets/image/' .$data['member'].'.png';

        if (file_exists($path_to_file)) {
            unlink($path_to_file);;
        } 

        // ini tambahan

        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('list_riwayat_pasien', $data);
        $this->load->view('Master/back-end/container/footer');
    }
    public function riwayat_paket($id)
    {
        $dataHeader['title'] = "Data Riwayat Pasien Klinik";
        $dataHeader['menu'] = 'Data Riwayat Pasien Klinik';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';
        $data['pasien'] = $this->db->get_where("pasien", ['id' => $id])->row_array();
        $data['riwayats'] = $this->model->Code("SELECT B.*, A.*, C.nama as obat FROM penjualan A LEFT JOIN penjualan_detail B ON B.penjualan_id = A.id LEFT JOIN produk_obat_bahan C ON C.id = B.obat_id WHERE A.pasien_id = $id AND obat_id != '0'  GROUP BY obat_id");
        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('list_riwayat_paket', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function delete($kode)
    {
        $data = array(
            'is_delete'     => 1,
            'no_hp'         => 0,
            'updated_by'    => $_SESSION['id'],
            'updated_date'  => $this->DateStamp(),
        );
        $this->db->update('pasien', $data, ['new_id'  => $kode, 'is_delete' => 0]);
        redirect('Administrasi/Pasien');
    }

    public function pindah($kode)
    {
        $data = array(
            'is_active' => 1,
            'updated_by' => $_SESSION['id'],
            'updated_date' => $this->DateStamp(),
        );
        $this->db->update('pasien', $data, ['no_rm'  => $kode]);
        redirect('Administrasi/Pasien');
    }

    public function edit($kode)
    {
        $data['title'] = "Edit Pasien Klinik";
        $data['pasien'] = $this->db->get_where('pasien', ['new_id' => $kode])->row_array();

        if($this->input->post('no_hp') != $data['pasien']['no_hp']) {
            $nohp_unique =  '|is_unique[pasien.no_hp]';
        } else {
            $nohp_unique =  '';
        }

        if($this->input->post('email') != $data['pasien']['email']) {
            $email_unique =  'is_unique[pasien.email]';
        } else {
            $email_unique =  '';
        }

        if($this->input->post('ktp_passport') != $data['pasien']['ktp_passport']) {
            $ktp_unique =  '|is_unique[pasien.ktp_passport]';
        } else {
            $ktp_unique =  '';
        }
        
        $this->form_validation->set_rules('no_hp', 'No. HP', 'min_length[9]'.$nohp_unique.'|callback_first_number_validation', 
            array(
                'is_unique'     => '%s sudah terdaftar, masukkan %s lain',
                'min_length'    => '%s minimal harus 9 digit'
            )
        );
        $this->form_validation->set_rules('email', 'Email', $email_unique,
            array(
                'is_unique' => '%s sudah terdaftar, masukkan %s lain',
            )
        );
        $this->form_validation->set_rules('ktp_passport', 'KTP/SIM/Passport', 'callback_exact_length_validation'.$ktp_unique, 
            array(
                'is_unique'     => '%s sudah terdaftar, masukkan %s lain',
            )
        );

        if ($this->form_validation->run() == FALSE) {
            $data['menu'] = 'Edit Pasien Klinik';
            $data['file'] = 'Administrasi';
            $data['link'] = 'index';
            $data['form'] = 'ok';
            $this->load->view('Master/back-end/container/header', $data);
            $this->load->view('Resepsionis/form_pasien', $data);
            $this->load->view('Master/back-end/container/footer');
        } else {
            $year = date('Y', strtotime($this->input->post('tgl_lahir')));
            $data = array(
                'reseller_id'       => $this->input->post('reseller_id', true),
                'is_active'         => $this->input->post('is_active', true),
                'alamat'            => $this->input->post('alamat', true),
                'no_telp'           => $this->input->post('no_telp', true),
                'nama'              => $this->input->post('nama', true),
                'ktp_passport'      => $this->input->post('ktp_passport', true),
                'no_reseller'       => $this->input->post('no_reseller', true),
                'alamat'            => $this->input->post('alamat', true),
                'kota'              => $this->input->post('kota', true),
                'jenis_kelamin'     => $this->input->post('jenis_kelamin', true),
                'pekerjaan'         => $this->input->post('pekerjaan', true),
                'status_pernikahan' => $this->input->post('status_pernikahan', true),
                'agama'             => $this->input->post('agama', true),
                'tempat_lahir'      => $this->input->post('tempat_lahir', true),
                'tgl_lahir'         => date('Y-m-d', strtotime($this->input->post('tgl_lahir'))),
                'umur'              => date("Y") - $year,
                'no_telp'           => $this->input->post('no_telp', true),
                'no_hp'             => $this->input->post('no_hp', true),
                'email'             => $this->input->post('email', true),
                'no_wa'             => $this->input->post('no_wa', true),
                'img'               => $this->input->post('img', true),
                'sumber_info'       => $this->input->post('sumber_info', true),
                'alergi_obat'       => $this->input->post('alergi_obat', true),
                'masalah_kulit'     => $this->input->post('masalah_kulit', true),
                'catatan'           => $this->input->post('catatan', true),
                'note'           => $this->input->post('note', true),
                'updated_by'        => $_SESSION['id'],
                'updated_date'      => $this->Date2String(date("m/d/Y"))
            );
            $this->db->update('pasien', $data, ['new_id'  => $kode]);
            redirect('Administrasi/Pasien');
        }
    }
    public function non()
    {
        $dataHeader['title'] = "Data non-pasien Klinik";
        $dataHeader['menu'] = 'Data non-pasien Klinik';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';
        $data['pasiens'] = $this->model->Code("SELECT * FROM pasien WHERE toko_id = ".$_SESSION['toko_id']." AND is_active = 0 AND is_delete = 0 ORDER BY created_date ASC");
        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('list_non_pasien', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function testing()
    {
        if ($_SESSION['toko_id'] == 1) {
            $kode_toko = 'MLG';
        } elseif ($_SESSION['toko_id'] == 2) {
            $kode_toko = 'SBY';
        } elseif ($_SESSION['toko_id'] == 3) {
            $kode_toko = 'BDG';
        } elseif ($_SESSION['toko_id'] == 4) {
            $kode_toko = 'SDA';
        } elseif ($_SESSION['toko_id'] == 5) {
            $kode_toko = 'BKS';
        } elseif ($_SESSION['toko_id'] == 6) {
            $kode_toko = 'MDN';
        } elseif ($_SESSION['toko_id'] == 7) {
            $kode_toko = 'DPK';
        } elseif ($_SESSION['toko_id'] == 8) {
            $kode_toko = 'YGK';
        } 
    }

    // ini tambahan 

    public function cetakKartuBaru($no_rm, $b)
    {
        $dataHeader['title'] = "Cetak Kartu Pasien Klinik";
        $dataHeader['menu'] = 'Data Pasien Klinik';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';

        $no = $no_rm;

        $cekSpasi = $this->db->query("SELECT RIGHT(nama, 1) as nama FROM pasien WHERE no_rm = '$no'")->row()->nama;
        if ($cekSpasi == ' ') {
            $namaP = $this->db->query("SELECT LEFT(nama, LENGTH(nama)-1) as nama FROM pasien WHERE no_rm = '$no'")->row()->nama;
        } else {
            $namaP = $this->db->query("SELECT nama from pasien where no_rm = '$no'")->row()->nama;
        }

        $pasien_id = $this->db->query("SELECT id from pasien where no_rm = '$no'")->row()->id;
        $namaP = str_replace( array( '\'', '"', ',' , ';', '<', '>', '&', '#', 'HJ.', ' (M)', ' (ENDORS)', ' (KONSUL)', ' (WAJIB KONSUL)', ' OFFICE', ' (KONSUL WAJIB)', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' ), '', $namaP);
        $namaP = str_replace( array( '(', ')' ), '', $namaP);
        $words = explode(" ", $namaP);

        $nol = 0;
        $satu = 1;
        $delapan = 8;

        if (array_key_exists(3,$words)){
            $n1 = strlen($words[0]);
            $n2 = strlen($words[1]);
            $n3 = strlen($words[2]);
            $n4 = strlen($words[3]);
            $w1 = $n1 + $n2 + $n3;
            $w2 = $n1 + $n2;
            $w3 = $n2 + $n3;

            if ($n4 != 0) {
                if($w1 <= 16){
                    $data['nama'] = $words[0] . ' ' . $words[1] . ' ' . $words[2] . ' ' . substr($words[3], $nol, $satu) . '.';
                } else{
                    if ($n1 <= 7 ) {
                        if ($w2 <= 16) {
                            $data['nama'] = $words[0] . ' ' . $words[1] . ' ' . substr($words[2], $nol, $satu) . '. ' . substr($words[3], $nol, $satu) . '.';
                        } else {
                            $data['nama'] = $words[0] . ' ' . substr($words[1], $nol, $satu) . '. ' . substr($words[2], $nol, $satu) . '. ' . substr($words[3], $nol, $satu . '.');
                        }
                    } else {
                        if($w3 <= 12) {
                            $data['nama'] = substr($words[0], $nol, $satu) . ' ' . $words[1] . ' ' . $words[2] . ' ' . substr($words[3], $nol, $satu) . '.';
                        } else {
                            $data['nama'] = substr($words[0], $nol, $satu) . ' ' . $words[1] . ' ' . substr($words[2], $nol, $satu) . '. ' . substr($words[3], $nol, $satu) . '.';
                        }
                    }
                }
            }
        } else if (array_key_exists(2, $words)){
            $n1 = strlen($words[0]);
            $n2 = strlen($words[1]);
            $n3 = strlen($words[2]);
            $w1 = $n1 + $n2 + $n3;
            $w2 = $n1 + $n2;

            if($w1 <= 16){
                $data['nama'] = $words[0] . ' ' . $words[1] . ' ' . $words[2];
            } else{
                if ($n1 <= 7 ) {
                    if ($w2 <= 16) {
                        $data['nama'] = $words[0] . ' ' . $words[1] . ' ' . substr($words[2], $nol, $satu) . '.';
                    } else {
                        $data['nama'] = $words[0] . ' ' . substr($words[1], $nol, $satu) . '. ' . substr($words[2], $nol, $satu) . '.';
                    }
                } else {
                    if($n3 <= 12) {
                        $data['nama'] = substr($words[0], $nol, $satu) . ' ' . $words[1] . ' ' . $words[2];
                    } else {
                        $data['nama'] = substr($words[0], $nol, $satu) . ' ' . $words[1] . ' ' . substr($words[2], $nol, $satu);
                    }
                }
            }
        } else if (array_key_exists(1, $words)){
            $n1 = strlen($words[0]);
            $n2 = strlen($words[1]);
            $w2 = $n1 + $n2;

            if($w2 <= 16){
                $data['nama'] = $words[0] . ' ' . $words[1];
            } else{
                if ($n1 <= 7 ) {
                    if ($n2 < 9) {
                        $data['nama'] = $words[0] . ' ' . $words[1];
                    } else {
                        $data['nama'] = $words[0] . ' ' . substr($words[1], $nol, $satu) . '.';
                    }
                } else {
                    $data['nama'] = substr($words[0], $nol, $satu) . ' ' . $words[1];
                }
            }
        } else {
            $data['nama'] = $words[0];
        }
        
        if ($_SESSION['toko_id'] == 1) {
            $kode_toko = 'MLG';
        } elseif ($_SESSION['toko_id'] == 2) {
            $kode_toko = 'SBY';
        } elseif ($_SESSION['toko_id'] == 3) {
            $kode_toko = 'BDG';
        } elseif ($_SESSION['toko_id'] == 4) {
            $kode_toko = 'SDA';
        } elseif ($_SESSION['toko_id'] == 5) {
            $kode_toko = 'BKS';
        } elseif ($_SESSION['toko_id'] == 6) {
            $kode_toko = 'MDN';
        } elseif ($_SESSION['toko_id'] == 7) {
            $kode_toko = 'DPK';
        } elseif ($_SESSION['toko_id'] == 8) {
            $kode_toko = 'YGK';
        } 

        $no_rm = $this->db->query("select right('$no_rm', 9) as no_rm")->row()->no_rm;
        
        $data['gambar'] = $kode_toko.$no_rm.'.png';
        $data['kode_member'] = $kode_toko.$no_rm;

        $path_to_file = './assets/image/'.$data['gambar'];

        if ($b == "m_lama") {
            $cekAda = $this->db->query("SELECT count(pasien_id) as pasien_id from stock_poin_pasien where pasien_id = $pasien_id")->row()->pasien_id;
            // print_r($cekAda);die();
            if($cekAda == 0){
                $dataIN = array(
                    'pasien_id' => $pasien_id,
                    'update_date' => $this->DateStamp(),
                    'jumlah' => 0,
                    'toko_id' => $_SESSION['toko_id']
                );
                $this->db->insert('stock_poin_pasien', $dataIN);
                // $this->db->query("INSERT INTO stock_poin_pasien VALUES (NULL, $pasien_id, CURDATE(), 0, ".$_SESSION['toko_id'].");");
            }
        }
        
        $data['b'] = $b;

        if (file_exists($path_to_file)) {
            $check = $this->db->query('UPDATE pasien set no_member = "'.$data['kode_member'].'" WHERE no_rm = "'.$no.'"');
            if ($check) {
                $this->load->view('membercard', $data);
            }
        } 
        else {
            $params['errorlog'] = FCPATH.'application/logs/';
            $config['cacheable']    = true; //boolean, the default is true
	        $config['cachedir']     = 'assets/'; //string, the default is application/cache/
	        $config['errorlog']     = 'assets/'; //string, the default is application/logs/
	        $config['imagedir']     = 'assets/image/'; //direktori penyimpanan qr code
	        $config['quality']      = true; //boolean, the default is true
	        $config['size']         = '1024'; //interger, the default is 1024
	        $config['black']        = array(30, 31, 36); // array, default is array(255,255,255)
	        $config['white']        = array(191, 154, 86); // array, default is array(0,0,0)
	        $this->ciqrcode->initialize($config);
	 
	        $data['gambar'] = $kode_toko.$no_rm.'.png';
	 
	        $params['data'] = $kode_toko.$no_rm; //data yang akan di jadikan QR CODE
	        $params['level'] = 'H'; //H=High
	        $params['size'] = 10;
	        $params['savename'] = FCPATH.$config['imagedir'].$data['gambar']; //simpan image QR CODE ke folder assets/images/
	        $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
            
            $check = $this->db->query('UPDATE pasien set no_member = "'.$data['kode_member'].'" WHERE no_rm = "'.$no.'"');
            
            if ($check) {
                $this->load->view('membercard', $data);
            }
        }
    }

    public function barutransaksi($no_rm)
    {
        if ($_SESSION['toko_id'] == 1) {
            $kode_toko = 'MLG';
        } elseif ($_SESSION['toko_id'] == 2) {
            $kode_toko = 'SBY';
        } elseif ($_SESSION['toko_id'] == 3) {
            $kode_toko = 'BDG';
        } elseif ($_SESSION['toko_id'] == 4) {
            $kode_toko = 'SDA';
        } elseif ($_SESSION['toko_id'] == 5) {
            $kode_toko = 'BKS';
        } elseif ($_SESSION['toko_id'] == 6) {
            $kode_toko = 'MDN';
        } elseif ($_SESSION['toko_id'] == 7) {
            $kode_toko = 'DPK';
        } elseif ($_SESSION['toko_id'] == 8) {
            $kode_toko = 'YGK';
        } 

        $no = $no_rm;
        $no_rm = $this->db->query("select right('$no_rm', 9) as no_rm")->row()->no_rm;
        $data['gambar'] = $kode_toko.$no_rm.'.png';
        $data['kode_member'] = $kode_toko.$no_rm;
        $this->db->query('UPDATE pasien set no_member = "'.$data['kode_member'].'" WHERE no_rm = "'.$no.'"');
        redirect(site_url() . "Pembayaran_akun/table_lunas");
    }
    
    public function cetakKartuDepan()
    {
        $this->load->view('membercardBack');
    }

    //ini tambahan

    public function excel_pasien(){
        ob_end_clean();

        $data = $_POST['input'];
        $arrtanggal = explode(' - ', $data['tanggal']);
		$tanggal1 = $this->Date2String($arrtanggal[0]);
		$tanggal2 = $this->Date2String($arrtanggal[1]);
        // $toko = $this->db->query("SELECT nama from toko where id = ".$_SESSION['toko_id']."")->row()->nama;

        if($data['cabang'] == 0) {
            if($data['status'] == 0){
                if($_POST['tipe_tanggal'] == 'reg') {
                    $result = $this->db->query("SELECT B.nama as cabang, A.* FROM pasien A INNER JOIN toko B ON A.toko_id = B.id WHERE A.is_delete = 0 AND (A.no_rm IS NOT NULL) AND (A.jenis_kelamin IS NOT NULL) AND A.created_date BETWEEN '".$tanggal1."' AND '".$tanggal2."' ")->result_array();
                }else{
                    $result = $this->db->query("SELECT B.nama as cabang, A.* FROM pasien A INNER JOIN toko B ON A.toko_id = B.id WHERE A.is_delete = 0 AND (A.no_rm IS NOT NULL) AND (A.jenis_kelamin IS NOT NULL) AND (MONTH( A.`tgl_lahir` ) BETWEEN MONTH('".$tanggal1."') AND MONTH('".$tanggal2."')) AND (dayofmonth( A.`tgl_lahir` ) BETWEEN dayofmonth('".$tanggal1."') AND dayofmonth('".$tanggal2."')) ORDER BY RIGHT(A.tgl_lahir, 5)")->result_array();
                }
            }else{
                if($_POST['tipe_tanggal'] == 'reg') {
                    $result = $this->db->query("SELECT B.nama as cabang, A.* FROM pasien A INNER JOIN toko B ON A.toko_id = B.id WHERE A.is_delete = 0 AND (A.no_rm IS NOT NULL) AND (A.jenis_kelamin IS NOT NULL) AND (A.created_date BETWEEN '".$tanggal1."' AND '".$tanggal2."') AND LENGTH(A.no_member) > 1 ")->result_array();
                }else{
                    $result = $this->db->query("SELECT B.nama as cabang, A.* FROM pasien A INNER JOIN toko B ON A.toko_id = B.id WHERE A.is_delete = 0 AND (A.no_rm IS NOT NULL) AND (A.jenis_kelamin IS NOT NULL) AND LENGTH(A.no_member) > 1 AND (MONTH( A.`tgl_lahir` ) BETWEEN MONTH('".$tanggal1."') AND MONTH('".$tanggal2."')) AND (dayofmonth( A.`tgl_lahir` ) BETWEEN dayofmonth('".$tanggal1."') AND dayofmonth('".$tanggal2."')) ORDER BY RIGHT(A.tgl_lahir, 5)")->result_array();
                }
            }
        }else{
            if($data['status'] == 0){
                if($_POST['tipe_tanggal'] == 'reg') {
                    $result = $this->db->query("SELECT B.nama as cabang, A.* FROM pasien A INNER JOIN toko B ON A.toko_id = B.id WHERE A.is_delete = 0 AND (A.no_rm IS NOT NULL) AND (A.jenis_kelamin IS NOT NULL) AND (A.created_date BETWEEN '".$tanggal1."' AND '".$tanggal2."') AND A.toko_id = ".$data['cabang']." ")->result_array();
                }else{
                    $result = $this->db->query("SELECT B.nama as cabang, A.* FROM pasien A INNER JOIN toko B ON A.toko_id = B.id WHERE A.is_delete = 0 AND (A.no_rm IS NOT NULL) AND (A.jenis_kelamin IS NOT NULL) AND A.toko_id = ".$data['cabang']." AND (MONTH( A.`tgl_lahir` ) BETWEEN MONTH('".$tanggal1."') AND MONTH('".$tanggal2."')) AND (dayofmonth( A.`tgl_lahir` ) BETWEEN dayofmonth('".$tanggal1."') AND dayofmonth('".$tanggal2."')) ORDER BY RIGHT(A.tgl_lahir, 5)")->result_array();
                }
            }else{
                if($_POST['tipe_tanggal'] == 'reg') {
                    $result = $this->db->query("SELECT B.nama as cabang, A.* FROM pasien A INNER JOIN toko B ON A.toko_id = B.id WHERE A.is_delete = 0 AND (A.no_rm IS NOT NULL) AND (A.jenis_kelamin IS NOT NULL) AND (A.created_date BETWEEN '".$tanggal1."' AND '".$tanggal2."') AND A.toko_id = ".$data['cabang']." AND LENGTH(A.no_member) > 1 ")->result_array();
                }else{
                    $result = $this->db->query("SELECT B.nama as cabang, A.* FROM pasien A INNER JOIN toko B ON A.toko_id = B.id WHERE A.is_delete = 0 AND (A.no_rm IS NOT NULL) AND (A.jenis_kelamin IS NOT NULL) AND A.toko_id = ".$data['cabang']." AND LENGTH(A.no_member) > 1 AND (MONTH( A.`tgl_lahir` ) BETWEEN MONTH('".$tanggal1."') AND MONTH('".$tanggal2."')) AND (dayofmonth( A.`tgl_lahir` ) BETWEEN dayofmonth('".$tanggal1."') AND dayofmonth('".$tanggal2."')) ORDER BY RIGHT(A.tgl_lahir, 5)")->result_array();
                }
            }
        }

        $spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$styleBold = array(
			'font' => array(
				'bold' => true
			)
		);

		$kolom = 'A';
		$baris = 1;
		$kolom_awal = $kolom;
		$baris_awal = $baris;

		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'CABANG');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'NAMA');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'NO. REKAM MEDIS');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'NO. MEMBER');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'ALAMAT');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'KOTA');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'JENIS KELAMIN');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'PEKERJAAN');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'STATUS PERNIKAHAN');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'AGAMA');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'TEMPAT LAHIR');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'TANGGAL LAHIR');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'NO HP');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom . $baris++, 'TANGGAL PENDAFTARAN');
		$sheet->getStyle($kolom_awal . $baris_awal . ':' . $kolom . $baris_awal)->applyFromArray($styleBold);

		foreach ($result as $key => $value) {
			$sheet->setCellValue($kolom_awal++ . $baris, $value['cabang']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['nama']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['no_rm']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['no_member']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['alamat']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['kota']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['jenis_kelamin']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['pekerjaan']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['status_pernikahan']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['agama']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['tempat_lahir']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['tgl_lahir']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['no_hp']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['created_date']);

			$kolom_awal = 'A';
			$baris++;
		}

		$writer = new Xlsx($spreadsheet);
		header("Content-Type: application/vnd.ms-excel charset=utf-8");
		header("Content-Disposition: attachment; filename=\"DATA PASIEN MS GLOW AESTHETIC CLINIC " . date('d m Y') . ".xlsx\"");
		header("Cache-Control: max-age=0");
		$writer->save('php://output');
    }

    public function export_full()
    {
        ob_end_clean();

		$data_pasien = $this->db->query("SELECT B.nama AS cabang, A.* FROM pasien A INNER JOIN toko B ON A.toko_id = B.id WHERE (A.is_delete = 0) AND (A.no_rm IS NOT NULL) AND (A.jenis_kelamin IS NOT NULL)")->result_array();

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$styleBold = array(
			'font' => array(
				'bold' => true
			)
		);

		$kolom = 'A';
		$baris = 1;
		$kolom_awal = $kolom;
		$baris_awal = $baris;

		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'CABANG');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'NAMA');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'NO. REKAM MEDIS');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'NO. MEMBER');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'ALAMAT');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'KOTA');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'JENIS KELAMIN');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'PEKERJAAN');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'STATUS PERNIKAHAN');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'AGAMA');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'TEMPAT LAHIR');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'TANGGAL LAHIR');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'NO HP');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom . $baris++, 'TANGGAL PENDAFTARAN');
		$sheet->getStyle($kolom_awal . $baris_awal . ':' . $kolom . $baris_awal)->applyFromArray($styleBold);

		foreach ($data_pasien as $key => $value) {
			$sheet->setCellValue($kolom_awal++ . $baris, $value['cabang']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['nama']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['no_rm']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['no_member']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['alamat']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['kota']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['jenis_kelamin']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['pekerjaan']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['status_pernikahan']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['agama']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['tempat_lahir']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['tgl_lahir']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['no_hp']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['created_date']);

			$kolom_awal = 'A';
			$baris++;
		}

		$writer = new Xlsx($spreadsheet);
		header("Content-Type: application/vnd.ms-excel charset=utf-8");
		header("Content-Disposition: attachment; filename=\"DATA PASIEN MS GLOW AESTHETIC CLINIC " . date('d m Y') . ".xlsx\"");
		header("Cache-Control: max-age=0");
		$writer->save('php://output');
    }

    public function deleteAjax()
    {
        $this->db->trans_begin();

        $new_id = $this->input->post('new_id');
        $data = array(
            'is_delete' => 1,
            'updated_by' => $_SESSION['id'],
            'updated_date' => $this->DateStamp(),
        );
        $this->db->update('pasien', $data, ['new_id'  => $new_id, 'is_delete' => 0]);

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $response = 500;
        } else {
            $this->db->trans_commit();
            $response = 200;
        }
        echo json_encode($response);
    }

    public function print_label($id)
    {
        $data['pasien'] = $this->db->get_where("pasien", ["new_id" => intval($id)])->row_array();
        $data['provinsi'] = $this->db->get_where("wilayah_2020", ["kode" => $data['pasien']['provinsi']])->row()->nama;
        $data['kabkota'] = $this->db->get_where("wilayah_2020", ["kode" => $data['pasien']['kabkota']])->row()->nama;
        $data['kecamatan'] = $this->db->get_where("wilayah_2020", ["kode" => $data['pasien']['kecamatan']])->row()->nama;
        $data['desa'] = $this->db->get_where("wilayah_2020", ["kode" => $data['pasien']['desa']])->row()->nama;
    
        $birthDate = new \DateTime($data['pasien']['tgl_lahir']);
        $today = new \DateTime("today");

        $data['y'] = $today->diff($birthDate)->y;
        $data['m'] = $today->diff($birthDate)->m;
        $data['d'] = $today->diff($birthDate)->d;

        $this->load->view('print_label', $data);
    }

    public function qrcode_label($data)
	{
		$params['data'] 	= $data; //data yang akan di jadikan QR CODE
		$params['level'] 	= 'H'; //H=High
		$params['size'] 	= 10;
		$params['savename'] = null; //simpan image QR CODE ke folder assets/images/
		echo $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
	}
}
