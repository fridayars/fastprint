<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Voucher extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load->model('model');
        $this->load->model('relasi');
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('download');
        $this->load->library('form_validation');
        if (!$_SESSION['logged_in']) redirect(site_url() . "Login");

        if ($_SESSION['role_id'] == 2 || $_SESSION['role_id'] == 3 || $_SESSION['role_id'] == 6) {
            redirect('Dashboard','refresh');
        }
    }
    public function Date2String($dTgl)
    {
        //return 2012-11-22
        list($cMount, $cDate, $cYear)    = explode("/", $dTgl);
        if (strlen($cDate) == 2) {
            $dTgl    = $cYear . "-" . $cMount . "-" . $cDate;
        }
        return $dTgl;
    }

    public function String2Date($dTgl)
    {
        //return 22-11-2012  
        list($cYear, $cMount, $cDate)    = explode("-", $dTgl);
        if (strlen($cYear) == 4) {
            $dTgl    = $cDate . "-" . $cMount . "-" . $cYear;
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
    
    public function index()
    {
        $namatoko = $this->db->query("SELECT id, nama from toko where id = " . $_SESSION['toko_id'] . "")->row_array();
        $dataHeader['title'] = "Data Voucher " . $namatoko['nama'];
        $dataHeader['menu'] = 'Data Voucher';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';
        $data['vouchers'] = $this->model->Code("SELECT * FROM voucher WHERE toko_id = ".$_SESSION['toko_id']." AND is_delete = 0 ORDER BY id ASC");
        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('list_voucher', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function add()
    {
        $dataHeader['title'] = "Tambah Voucher";
        $this->form_validation->set_rules('nama_voucher', 'Nama Voucher', 'required');
        $this->form_validation->set_rules('diskon', 'Diskon', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Tambah Voucher';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_voucher');
            $this->load->view('Master/back-end/container/footer');
        } else {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            $randstring = '';
            for ($i = 0; $i < 6; $i++) {
                $randstring = $randstring . $characters[rand(0, strlen($characters))];
            }
            $diskon = $this->input->post('diskon', true);

            if ($diskon > 0 && $diskon <= 100) {
                $tipe = 'pr';
            } else if ($diskon == 0 ){
                $tipe = '-';
            } else {
                $tipe = 'rp';
            }
            $max_id = $this->db->query("SELECT id FROM voucher WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY id DESC LIMIT 0, 1")->row()->id;
            $data = array(
                'id' => $max_id+1,
                'toko_id' => $_SESSION['toko_id'],
                // 'kode' => 'AS-' . (count($no) + 1),
                'nama_voucher' => $this->input->post('nama_voucher', true),
                'diskon' => $diskon,
                'diskon_tipe' => $tipe,
                'harga_poin' => $this->input->post('harga_poin', true),
                'stok_merchant' => $this->input->post('stok', true),
                'kode_voucher' => $randstring,
                'created_by' => $_SESSION['id'],
                'tgl_mulai' => $this->DateStamp()
            );
            $this->db->insert('voucher', $data);
            redirect('Administrasi/Voucher');
        }
    }
    
    public function edit($id)
    {
        $dataHeader['title'] = "Edit Voucher";
        $this->form_validation->set_rules('nama_voucher', 'Nama Voucher', 'required');
        $this->form_validation->set_rules('diskon', 'Diskon', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Edit Voucher';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $data['voucher'] = $this->db->get_where('voucher', ['id' => $id, 'toko_id' => $_SESSION['toko_id']])->row_array();
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_voucher', $data);
            $this->load->view('Master/back-end/container/footer');
        } else {
            $diskon = $this->input->post('diskon', true);
            if ($diskon > 0 && $diskon <= 100) {
                $tipe = 'pr';
            } else if ($diskon == 0 ){
                $tipe = '-';
            } else {
                $tipe = 'rp';
            }

            // ($this->input->post('diskon', true) > 100) ? $dis = 'rp' : $dis = 'pr';
            $data = array(
                // 'toko_id' => $_SESSION['toko_id'],
                // 'kode' => 'AS-' . (count($no) + 1),
                'nama_voucher' => $this->input->post('nama_voucher', true),
                'diskon' => $diskon,
                'harga_poin' => $this->input->post('harga_poin', true),
                'stok_merchant' => $this->input->post('stok', true),
                'diskon_tipe' => $tipe,
                'created_by' => $_SESSION['id'],
                'tgl_mulai' => $this->DateStamp()
            );
            $this->db->update('voucher', $data, ['id'  => $id, 'toko_id' => $_SESSION['toko_id']]);
            redirect('Administrasi/Voucher');
        }
    }

    public function delete($id)
    {
        $data = array(
            'is_delete' => 1,
            'updated_by' => $_SESSION['id'],
            'updated_date' => $this->DateStamp()
        );
        $this->db->update('voucher', $data, ['id'  => $id, 'is_delete' => 0, 'toko_id' => $_SESSION['toko_id']]);
        redirect('Administrasi/Voucher');
    }
}
