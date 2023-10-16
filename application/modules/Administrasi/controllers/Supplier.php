<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
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
        $dataHeader['title'] = "Data Supplier Klinik " . $namatoko['nama'];
        $dataHeader['menu'] = 'Data Supplier';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';
        $data['suppliers'] = $this->model->Code("SELECT * FROM supplier WHERE is_delete = 0 AND toko_id = ".$_SESSION['toko_id']." ORDER BY created_date ASC");
        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('list_supplier', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function add()
    {
        $dataHeader['title'] = "Tambah Supplier";
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'NO. HP', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Tambah Supplier';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_supplier');
            $this->load->view('Master/back-end/container/footer');
        } else {
            $no = $this->model->Code("SELECT id FROM supplier where toko_id = ".$_SESSION['toko_id']." ORDER BY created_date DESC");
            $max_id = $this->db->query("SELECT id FROM supplier WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY id DESC LIMIT 0, 1")->row()->id;
            $data = array(
                'id' => $max_id+1,
                'toko_id' => $_SESSION['toko_id'],
                'kode' => 'AS-' . (count($no) + 1),
                'alamat' => $this->input->post('alamat', true),
                'no_telp' => $this->input->post('no_telp', true),
                'nama' => $this->input->post('nama', true),
                'kontak' => $this->input->post('kontak', true),
                'created_by' => $_SESSION['id'],
                'created_date' => $this->DateStamp()
            );
            $this->db->insert('supplier', $data);
            redirect('Administrasi/Supplier');
        }
    }
    public function edit($kode)
    {
        $dataHeader['title'] = "Edit Supplier";
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'NO. HP', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Edit Supplier';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $data['supplier'] = $this->db->get_where('supplier', ['kode' => $kode, 'toko_id' => $_SESSION['toko_id']])->row_array();
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_supplier', $data);
            $this->load->view('Master/back-end/container/footer');
        } else {
            $data = array(
                'alamat' => $this->input->post('alamat', true),
                'no_telp' => $this->input->post('no_telp', true),
                'nama' => $this->input->post('nama', true),
                'kontak' => $this->input->post('kontak', true),
                'updated_by' => $_SESSION['id'],
                'updated_date' => $this->DateStamp()
            );
            $this->db->update('supplier', $data, ['kode'  => $kode, 'toko_id' => $_SESSION['toko_id']]);
            redirect('Administrasi/Supplier');
        }
    }

    public function delete($kode)
    {
        $data = array(
            'is_delete' => 1,
            'updated_by' => $_SESSION['id'],
            'updated_date' => $this->DateStamp()
        );
        $this->db->update('supplier', $data, ['kode'  => $kode, 'is_delete' => 0]);
        redirect('Administrasi/Supplier');
    }
}
