<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class MasterTreatment extends CI_Controller
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
        date_default_timezone_set('Asia/Jakarta');

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
        $dataHeader['title'] = "Data Master Treatment";
        $dataHeader['menu'] = 'Data Master Treatment';
        $dataHeader['file'] = 'Administrasi/MasterTreatment';
        $dataHeader['link'] = 'index';

        $data['master_treatment'] = $this->db->query("SELECT * FROM master_treatment where is_delete = 0")->result_array();
        $data['units'] = $this->model->Code("SELECT * FROM unit_treatment where toko_id = ".$_SESSION['toko_id']."");
        $data['tipes'] = $this->model->Code("SELECT * FROM tipe_treatment where toko_id = ".$_SESSION['toko_id']."");

        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('list_master_treatment', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function add()
    {
        $this->db->trans_begin();
        /* insert tabel Master Treatment */
        $data = $_POST['input'];
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('master_treatment', $data);
        $insert_id = $this->db->insert_id();

        /* insert tabel treatment all branch */
        $tokos= $this->model->Code("SELECT id, kode_toko FROM toko WHERE id != 99");
        foreach ($tokos as $key => $toko) {
            $no = $this->model->Code("SELECT id FROM treatment where toko_id = ".$toko['id']." ORDER BY created_date DESC");
            $max_id = $this->db->query("SELECT id FROM treatment WHERE toko_id = ".$toko['id']." ORDER BY id DESC LIMIT 0, 1")->row()->id;
            $dt_treatment = array(
                'id'                    => $max_id+1,
                'toko_id'               => $toko['id'],
                'kode'                  => $toko['kode_toko'] . 'TR-' . (count($no) + 1),
                'unit_id'               => $data['unit_id'],
                'tipe_id'               => $data['tipe_id'],
                'nama'                  => $data['nama_treatment'],
                'waktu'                 => $data['waktu'],
                'tarif_umum'            => $data['tarif'],
                'tarif_member'          => $data['tarif'],
                'tarif_dokter'          => $data['tarif_dokter'],
                'tarif_beautician'      => $data['tarif_beautician'],
                'tarif_sales'           => 0,
                'biaya_modal'           => $data['biaya_modal'],
                'created_by'            => $_SESSION['id'],
                'created_date'          => date('Y-m-d'),
                'master_treatment_id'   => $insert_id,
            );
            $this->db->insert('treatment', $dt_treatment);
        }
        if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('error', 'Gagal diproses, mohon ulangi beberapa saat lagi.');
			redirect($_SERVER['HTTP_REFERER']);
		} else {
            $this->session->set_flashdata('success', 'Perubahan berhasil disimpan.');
			$this->db->trans_commit();
		}
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function edit($id)
    {
        $this->db->trans_begin();
        /* update data master treatment */
        $data = $_POST['input'];
        isset($data['is_referral']) ? true : $data['is_referral'] = 0;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->update('master_treatment', $data, ['id' => $id]);

        /* update data treatment all branch */
        $dt_treatment = array(
            'unit_id'               => $data['unit_id'],
            'tipe_id'               => $data['tipe_id'],
            'nama'                  => $data['nama_treatment'],
            'waktu'                 => $data['waktu'],
            'tarif_umum'            => $data['tarif'],
            'tarif_member'          => $data['tarif'],
            'tarif_dokter'          => $data['tarif_dokter'],
            'tarif_beautician'      => $data['tarif_beautician'],
            'biaya_modal'           => $data['biaya_modal'],
            'updated_by'            => $_SESSION['id'],
            'updated_date'          => date('Y-m-d'),
        );
        $this->db->update('treatment', $dt_treatment, ['master_treatment_id' => $id]);
        if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('error', 'Gagal diproses, mohon ulangi beberapa saat lagi.');
			redirect($_SERVER['HTTP_REFERER']);
		} else {
            $this->session->set_flashdata('success', 'Perubahan berhasil disimpan.');
			$this->db->trans_commit();
		}
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id)
    {
        $this->db->trans_begin();
        /* delete data master treatment */
        $data['is_delete']  = 1;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->update('master_treatment', $data, ['id' => $id]);

        /* delete data treatment all branch */
        $data2['is_delete']     = 1;
        $data2['updated_by']    = $_SESSION['id'];
        $data2['updated_date']  = date('Y-m-d');
        $this->db->update('treatment', $data2, ['master_treatment_id' => $id]);
        if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$this->session->set_flashdata('error', 'Gagal diproses, mohon ulangi beberapa saat lagi.');
			redirect($_SERVER['HTTP_REFERER']);
		} else {
            $this->session->set_flashdata('success', 'Perubahan berhasil disimpan.');
			$this->db->trans_commit();
		}

        redirect($_SERVER['HTTP_REFERER']);
     }
    
    public function excel_treatments()
    {
        ob_end_clean();

		$data_treatment = $this->model->Code("SELECT A.*, B.nama AS unit, C.nama AS tipe FROM master_treatment A LEFT JOIN (SELECT * FROM unit_treatment WHERE toko_id = 99) B ON A.unit_id = B.id LEFT JOIN (SELECT * FROM tipe_treatment WHERE toko_id = 99) C ON A.tipe_id = C.id WHERE is_delete = 0 ORDER BY id");

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
        $no = 1;

		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'NO');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'NAMA TREATMENT');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'TARIF TREATMENT');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'CREATED AT');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'UPDATED AT');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'TARIF DOKTER');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'TARIF BEAUTICIAN');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'BIAYA MODAL');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'UNIT');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'TIPE');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'WAKTU');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'DISKON REFERRAL (RP)');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'STAFF FEE (RP)');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom . $baris++, 'REFERRAL STATUS');
		$sheet->getStyle($kolom_awal . $baris_awal . ':' . $kolom . $baris_awal)->applyFromArray($styleBold);

		foreach ($data_treatment as $key => $value) {
			$sheet->setCellValue($kolom_awal++ . $baris, $no);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['nama_treatment']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['tarif']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['created_at']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['updated_at']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['tarif_dokter']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['tarif_beautician']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['biaya_modal']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['unit']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['tipe']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['waktu']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['diskon_referral']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['diskon_fee']);
			$sheet->setCellValue($kolom_awal++ . $baris, ($value['is_referral']==0) ? 'Tidak Aktif': 'Aktif');

			$kolom_awal = 'A';
			$baris++;
            $no++;
		}

		$writer = new Xlsx($spreadsheet);
		header("Content-Type: application/vnd.ms-excel charset=utf-8");
		header("Content-Disposition: attachment; filename=\"DATA MASTER TREATMENT " . date('d m Y') . ".xlsx\"");
		header("Cache-Control: max-age=0");
		$writer->save('php://output');
    }
}
