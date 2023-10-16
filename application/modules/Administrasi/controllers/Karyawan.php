<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Karyawan extends CI_Controller
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
            $dTgl    = $cDate . "/" . $cMount . "/" . $cYear;
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
        if ($_SESSION['toko_id'] == 99) {
            $dataHeader['title'] = "Data Karyawan Klinik All Cabang";
            $dataHeader['menu'] = 'Data Karyawan Klinik';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $data['karyawans'] = $this->model->Code("SELECT * FROM v_karyawan WHERE is_delete = 0 ORDER BY toko_id, nama ASC");
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('list_karyawan', $data);
            $this->load->view('Master/back-end/container/footer');
        } else{
            $namatoko = $this->db->query("SELECT id, nama from toko where id = " . $_SESSION['toko_id'] . "")->row_array();
            $dataHeader['title'] = "Data Karyawan Klinik " . $namatoko['nama'];
            $dataHeader['menu'] = 'Data Karyawan Klinik';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $data['karyawans'] = $this->model->Code("SELECT * FROM v_karyawan WHERE toko_id = ".$_SESSION['toko_id']." AND is_delete = 0 ORDER BY created_date ASC");
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('list_karyawan', $data);
            $this->load->view('Master/back-end/container/footer');
        }
    }
    public function add()
    {
        $toko = $this->db->query("SELECT nama FROM toko where id = ".$_SESSION['toko_id'])->row()->nama;

        $dataHeader['title'] = "Tambah Karyawan Klinik " .$toko;
        $this->form_validation->set_rules('jabatan_id', 'Jabatan', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'NO. HP', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Tambah Karyawan Klinik';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $data['jabatans'] = $this->model->Code("SELECT id, nama FROM jabatan WHERE is_delete = 0 and toko_id = ".$_SESSION['toko_id']." ORDER BY nama ASC");
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_karyawan', $data);
            $this->load->view('Master/back-end/container/footer');
        } else {
            $no = $this->model->Code("SELECT id FROM karyawan WHERE jabatan_id = " . $this->input->post('jabatan_id', true) . " and toko_id = ".$_SESSION['toko_id']." ORDER BY created_date DESC");
            $kode = $this->db->get_where("jabatan", ['id' => $this->input->post('jabatan_id'), 'toko_id' => $_SESSION['toko_id']])->row_array();
            $max_id = $this->db->query("SELECT id FROM karyawan WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY id DESC LIMIT 0, 1")->row()->id;
            $data = array(
                'id' => $max_id+1,
                'toko_id' => $_SESSION['toko_id'],
                'jabatan_id' => $this->input->post('jabatan_id', true),
                'kode' => $kode['kode'] . '-' . (count($no) + 1),
                'alamat' => $this->input->post('alamat', true),
                'no_telp' => $this->input->post('no_telp', true),
                'nama' => $this->input->post('nama', true),
                'created_by' => $_SESSION['id'],
                'created_date' => $this->DateStamp()
            );
            $this->db->insert('karyawan', $data);
            redirect('Administrasi/Karyawan');
        }
    }
    public function edit($kode)
    {
        $dataHeader['title'] = "Edit Karyawan Klinik";
        $this->form_validation->set_rules('jabatan_id', 'Jabatan', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('no_telp', 'NO. HP', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Edit Karyawan Klinik';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $data['jabatans'] = $this->model->Code("SELECT id, nama FROM jabatan WHERE is_delete = 0 and toko_id = ".$_SESSION['toko_id']." ORDER BY nama ASC");
            $data['karyawan'] = $this->db->get_where("karyawan", ['kode' => $kode, 'is_delete' => 0, 'toko_id' => $_SESSION['toko_id']])->row_array();
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_karyawan', $data);
            $this->load->view('Master/back-end/container/footer');
        } else {
            $data = array(
                'jabatan_id' => $this->input->post('jabatan_id', true),
                'alamat' => $this->input->post('alamat', true),
                'no_telp' => $this->input->post('no_telp', true),
                'nama' => $this->input->post('nama', true),
                'updated_by' => $_SESSION['id'],
                'updated_date' => $this->DateStamp()
            );
            $this->db->update('karyawan', $data, ['kode'  => $kode, 'toko_id' => $_SESSION['toko_id']]);
            redirect('Administrasi/Karyawan');
        }
    }

    public function delete($kode)
    {
        $data = array(
            'is_delete' => 1,
            'updated_by' => $_SESSION['id'],
            'updated_date' => $this->DateStamp()
        );
        $this->db->update('karyawan', $data, ['kode'  => $kode, 'is_delete' => 0, 'toko_id' => $_SESSION['toko_id']]);
        redirect('Administrasi/Karyawan');
    }
}
