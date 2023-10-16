<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Treatment extends CI_Controller
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
        $dataHeader['title'] = "Data Treatment " . $namatoko['nama'];
        $dataHeader['menu'] = 'Data Treatment';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';
        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('menu_treatment');
        $this->load->view('Master/back-end/container/footer');
    }
    public function list_treatment()
    {
        $namatoko = $this->db->query("SELECT id, nama from toko where id = " . $_SESSION['toko_id'] . "")->row_array();
        $dataHeader['title'] = "Data Treatment " . $namatoko['nama'];
        $dataHeader['menu'] = 'Data Treatment';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';
        $data['treatments'] = $this->model->Code("SELECT * FROM v_treatment WHERE toko_id = ".$_SESSION['toko_id']." AND is_delete = 0 ORDER BY created_date ASC");
        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('list_treatment', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function add()
    {
        $dataHeader['title'] = "Tambah Treatment";
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('unit_id', 'unit', 'required');
        $this->form_validation->set_rules('tipe_id', 'Tindakan', 'required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'required');
        $this->form_validation->set_rules('tarif_umum', 'tarif_umum', 'required');
        $this->form_validation->set_rules('biaya_modal', 'biaya_modal', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Tambah Treatment';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $data['units'] = $this->model->Code("SELECT * FROM unit_treatment where toko_id = ".$_SESSION['toko_id']."");
            $data['tipes'] = $this->model->Code("SELECT * FROM tipe_treatment where toko_id = ".$_SESSION['toko_id']."");
            $data['master_treatment'] = $this->model->Code("SELECT * FROM master_treatment where is_delete = 0");
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_treatment', $data);
            $this->load->view('Master/back-end/container/footer');
        } else {
            $no = $this->model->Code("SELECT id FROM treatment where toko_id = ".$_SESSION['toko_id']." ORDER BY created_date DESC");
            $max_id = $this->db->query("SELECT id FROM treatment WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY id DESC LIMIT 0, 1")->row()->id;
            $data = array(
                'id' => $max_id+1,
                'toko_id' => $_SESSION['toko_id'],
                'kode' => 'AKK-' . (count($no) + 1),
                'unit_id' => $this->input->post('unit_id', true),
                'tipe_id' => $this->input->post('tipe_id', true),
                'nama' => $this->input->post('nama', true),
                'waktu' => $this->input->post('waktu', true),
                'tarif_umum' => $this->input->post('tarif_umum', true),
                'tarif_member' => $this->input->post('tarif_member', true),
                'tarif_dokter' => $this->input->post('tarif_dokter', true),
                'tarif_beautician' => $this->input->post('tarif_beautician', true),
                'tarif_sales' => $this->input->post('tarif_sales', true),
                'biaya_modal' => $this->input->post('biaya_modal', true),
                'created_by' => $_SESSION['id'],
                'master_treatment_id' => $this->input->post('master_treatment_id', true),
            );
            $this->db->insert('treatment', $data);
            redirect('Administrasi/Treatment/list_treatment');
        }
    }

    public function read($kode)
    {
        $dataHeader['menu'] = 'Detail Treatment';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';
        $dataHeader['form'] = 'ok';
        $data['treatment'] = $this->db->query("SELECT * FROM v_treatment WHERE toko_id = ".$_SESSION['toko_id']." AND is_delete = 0 AND kode = '".$kode."'")->row_array();
        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('view_treatment', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function edit($kode)
    {
        $dataHeader['title'] = "Tambah Treatment";
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('unit_id', 'unit', 'required');
        $this->form_validation->set_rules('tipe_id', 'Tindakan', 'required');
        $this->form_validation->set_rules('waktu', 'Waktu', 'required');
        $this->form_validation->set_rules('tarif_umum', 'tarif_umum', 'required');
        $this->form_validation->set_rules('biaya_modal', 'biaya_modal', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Tambah Treatment';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $data['units'] = $this->model->Code("SELECT * FROM unit_treatment where toko_id = ".$_SESSION['toko_id']."");
            $data['tipes'] = $this->model->Code("SELECT * FROM tipe_treatment where toko_id = ".$_SESSION['toko_id']."");
            $data['master_treatment'] = $this->model->Code("SELECT * FROM master_treatment where is_delete = 0");
            $data['treatment'] = $this->db->get_where("treatment", ['kode' => $kode , 'toko_id' => $_SESSION['toko_id']])->row_array();
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_treatment', $data);
            $this->load->view('Master/back-end/container/footer');
        } else {
            $data = array(
                'unit_id' => $this->input->post('unit_id', true),
                'tipe_id' => $this->input->post('tipe_id', true),
                'nama' => $this->input->post('nama', true),
                'waktu' => $this->input->post('waktu', true),
                'tarif_umum' => $this->input->post('tarif_umum', true),
                'tarif_member' => $this->input->post('tarif_member', true),
                'tarif_dokter' => $this->input->post('tarif_dokter', true),
                'tarif_beautician' => $this->input->post('tarif_beautician', true),
                'tarif_sales' => $this->input->post('tarif_sales', true),
                'biaya_modal' => $this->input->post('biaya_modal', true),
                'updated_by' => $_SESSION['id'],
                'updated_date' => $this->DateStamp(),
                'master_treatment_id' => $this->input->post('master_treatment_id', true),
            );
            $this->db->update('treatment', $data, ['kode'  => $kode, 'toko_id' => $_SESSION['toko_id']]);
            redirect('Administrasi/Treatment/list_treatment');
        }
    }
    public function delete($kode)
    {
        $data = array(
            'is_delete' => 1,
            'updated_by' => $_SESSION['id'],
            'updated_date' => $this->DateStamp(),
        );
        $this->db->update('treatment', $data, ['kode'  => $kode, 'is_delete' => 0, 'toko_id' => $_SESSION['toko_id']]);
        redirect('Administrasi/Treatment/list_treatment');
    }
    public function delete_bahan($id)
    {
        $bahan = $this->db->get_where('obat_treatment', ['id' => $id, 'toko_id' => $_SESSION['toko_id']])->row_array();
        $treatment = $this->db->get_where('treatment', ['id' => $bahan['treatment_id'], 'toko_id' => $_SESSION['toko_id']])->row_array();
        $data = array(
            'is_delete' => 1,
            'updated_by' => $_SESSION['id'],
            'updated_date' => $this->DateStamp(),
        );
        $this->db->update('obat_treatment', $data, ['id'  => $id, 'toko_id' => $_SESSION['toko_id']]);
        redirect('Administrasi/Treatment/edit_bahan/' . $treatment['kode']);
    }

    public function edit_bahan($kode)
    {
        $dataHeader['title'] = "Edit Bahan Treatment";
        $treatment = $this->db->get_where('treatment', ['kode' => $kode])->row_array();
        $this->form_validation->set_rules('obat_id', 'Obat', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Edit Bahan Treatment';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $data['obats'] = $this->model->Code("SELECT id, nama FROM produk_obat_bahan WHERE tempat_id = 2 AND is_delete = 0 AND toko_id = ".$_SESSION['toko_id']." ORDER BY created_date DESC");
            $data['bahans'] = $this->model->Code("SELECT * FROM v_obat_treatment WHERE treatment_id = " . $treatment['id'] . " AND is_delete = 0 AND toko_id = ".$_SESSION['toko_id']." ORDER BY created_date DESC");
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_edit_bahan', $data);
            $this->load->view('Master/back-end/container/footer');
        } else {
            $data = array(
                'treatment_id' => $treatment['id'],
                'obat_id' => $this->input->post('obat_id', true),
                'jumlah' => $this->input->post('jumlah', true),
                'created_by' => $_SESSION['id'],
            );
            $this->db->insert('obat_treatment', $data);
            redirect('Administrasi/Treatment/edit_bahan/' . $treatment['kode']);
        }
    }

    public function setup_promo()
    {
        $dataHeader['title'] = "Setup Promo";
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jenis_id', 'Jenis', 'required');
        $this->form_validation->set_rules('start_promo', 'start_promo', 'required');
        $this->form_validation->set_rules('end_promo', 'end_promo', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Setup Promo';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $data['promos'] = $this->model->Code("SELECT * FROM v_promo WHERE toko_id = ".$_SESSION['toko_id']." AND is_delete = 0 ORDER BY created_date DESC");
            $data['jenises'] = $this->model->Code("SELECT * FROM jenis_promo");
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_setup_promo', $data);
            $this->load->view('Master/back-end/container/footer');
        } else {

            $no = $this->model->Code("SELECT id FROM promo WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY created_date DESC");
            $max_id = $this->db->query("SELECT id FROM promo WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY id DESC LIMIT 0, 1")->row()->id;
            $data = array(
                'id' => $max_id+1,
                'jenis_id' => $this->input->post('jenis_id', true),
                'toko_id' => $_SESSION['toko_id'],
                'kode' => 'P-' . (count($no) + 1),
                'nama' => $this->input->post('nama', true),
                'start_promo' => $this->Date2String(substr($_POST['start_promo'], 0, 10)),
                'end_promo' => $this->Date2String(substr($_POST['end_promo'], 0, 10)),
                'created_by' => $_SESSION['id'],
            );
            $this->db->insert('promo', $data);
            redirect('Administrasi/Treatment/setup_promo/');
        }
    }
    public function edit_promo($kode)
    {
        $dataHeader['title'] = "Setup Promo";
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jenis_id', 'Jenis', 'required');
        $this->form_validation->set_rules('start_promo', 'start_promo', 'required');
        $this->form_validation->set_rules('end_promo', 'end_promo', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Setup Promo';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $data['promo'] = $this->db->get_where('promo', ['kode' => $kode])->row_array();
            $data['promos'] = $this->model->Code("SELECT * FROM v_promo WHERE toko_id = ".$_SESSION['toko_id']." AND is_delete = 0 ORDER BY created_date DESC");
            $data['jenises'] = $this->model->Code("SELECT * FROM jenis_promo WHERE toko_id = ".$_SESSION['toko_id']."");
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_setup_promo', $data);
            $this->load->view('Master/back-end/container/footer');
        } else {
            $data = array(
                'jenis_id' => $this->input->post('jenis_id', true),
                'nama' => $this->input->post('nama', true),
                'start_promo' => $this->input->post('start_promo', true),
                'end_promo' => $this->input->post('end_promo', true),
                'updated_by' => $_SESSION['id'],
                'updated_date' => date('dd-mm-yyyy'),
            );
            $this->db->update('promo', $data, ['kode' => $kode, 'toko_id' => $_SESSION['toko_id']]);
            redirect('Administrasi/Treatment/setup_promo/');
        }
    }
    public function delete_promo($kode)
    {
        $data = array(
            'is_delete' => 1,
            'updated_by' => $_SESSION['id'],
            'updated_date' => $this->DateStamp(),
        );
        $this->db->update('promo', $data, ['kode'  => $kode, 'toko_id' => $_SESSION['toko_id']]);
        redirect('Administrasi/Treatment/setup_promo');
    }

    public function point_reward()
    {
        $dataHeader['title'] = "Setup Point Reward";
        $datas['poin'] = $this->db->get_where('poin_reward', ['toko_id' => $_SESSION['toko_id']])->row_array();
        $this->form_validation->set_rules('transaksi_treatment', 'transaksi_treatment', 'required');
        $this->form_validation->set_rules('pembelian_produk', 'Jenis', 'required');
        $this->form_validation->set_rules('reward_treatment', 'reward_treatment', 'required');
        $this->form_validation->set_rules('reward_produk', 'reward_produk', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Setup Point Reward';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_setup_poin', $datas);
            $this->load->view('Master/back-end/container/footer');
        } else {
            $data = array(
                'pembelian_produk' => $this->input->post('pembelian_produk', true),
                'transaksi_treatment' => $this->input->post('transaksi_treatment', true),
                'reward_treatment' => $this->input->post('reward_treatment', true),
                'reward_produk' => $this->input->post('reward_produk', true),
                'updated_by' => $_SESSION['id'],
                'updated_date' => date('dd-mm-yyy'),
            );
            $this->db->update('poin_reward', $data, ['id' => $datas['poin']['id'], 'toko_id' => $_SESSION['toko_id']]);
            redirect('Administrasi/Treatment/point_reward/');
        }
    }

    public function excel_treatments()
    {
        ob_end_clean();

		$data_treatment = $this->model->Code("SELECT * FROM v_treatment WHERE toko_id = ".$_SESSION['toko_id']." AND is_delete = 0 ORDER BY nama");
		$toko = $this->db->query("SELECT nama from toko where id = ".$_SESSION['toko_id']."")->row()->nama;

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
		$sheet->setCellValue($kolom++ . $baris, 'KODE');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'NAMA TREATMENT');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'BAGIAN');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'JENIS');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'TARIF');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'FEE DOKTER');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom . $baris++, 'FEE BEAUTICIAN');
		$sheet->getStyle($kolom_awal . $baris_awal . ':' . $kolom . $baris_awal)->applyFromArray($styleBold);

		foreach ($data_treatment as $key => $value) {
			$sheet->setCellValue($kolom_awal++ . $baris, $value['kode']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['nama']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['nama_unit']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['nama_tipe']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['tarif_umum']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['tarif_dokter']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['tarif_beautician']);

			$kolom_awal = 'A';
			$baris++;
		}

		$writer = new Xlsx($spreadsheet);
		header("Content-Type: application/vnd.ms-excel charset=utf-8");
		header("Content-Disposition: attachment; filename=\"DATA TREATMENT " . $toko . " " . date('d M Y') . ".xlsx\"");
		header("Cache-Control: max-age=0");
		$writer->save('php://output');
    }
}
