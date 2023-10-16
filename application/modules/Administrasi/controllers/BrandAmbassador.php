<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BrandAmbassador extends CI_Controller
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
        $dataHeader['title'] = "Data Brand Ambassador";
        $dataHeader['menu'] = 'Data Brand Ambassador';
        $dataHeader['file'] = 'Administrasi/BrandAmbassador';
        $dataHeader['link'] = 'index';

        $data['brand_ambassador'] = $this->db->query("SELECT A.*, B.nama AS cabang FROM brand_ambassador A left join toko B on A.toko_id = B.id")->result_array();
        $data['cabang']	= $this->db->query("SELECT id, nama FROM toko")->result_array();
		$data['arrcabang'] = '<option value="99">NASIONAL</option>';
		foreach ($data['cabang'] as $index => $value) {
			$data['arrcabang'] .= '<option value="' . $value['id'] . '">' . $value['nama'] . '</option>';
		}

        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('list_brand_ambassador', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function add()
    {
        $data = $_POST['input'];
        $data['created_at'] = date('Y-m-d H:i:s');
        
        $this->db->insert('brand_ambassador', $data);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function edit($id)
    {
        $data = $_POST['input'];
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        $this->db->update('brand_ambassador', $data, ['id' => $id]);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete($id, $status)
    {
        if($status==1){
            $data['is_delete'] = 1;
        } else {
            $data['is_delete'] = 0;
        }
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->update('brand_ambassador', $data, ['id' => $id]);
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function excel_ba()
    {
        ob_end_clean();

		$data_ba = $this->model->Code("SELECT A.*, B.nama AS cabang FROM brand_ambassador A left join toko B on A.toko_id = B.id");

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
		$sheet->setCellValue($kolom++ . $baris, 'NAMA BA');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'CABANG BA');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom . $baris++, 'STATUS BA');
		$sheet->getStyle($kolom_awal . $baris_awal . ':' . $kolom . $baris_awal)->applyFromArray($styleBold);

		foreach ($data_ba as $key => $value) {
			$sheet->setCellValue($kolom_awal++ . $baris, $no);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['nama']);
			$sheet->setCellValue($kolom_awal++ . $baris, ($value['toko_id'] == 99) ? 'NASIONAL' : $value['cabang']);
			$sheet->setCellValue($kolom_awal++ . $baris, ($value['is_delete'] == 0) ? 'Aktif' : 'Tidak Aktif');

			$kolom_awal = 'A';
			$baris++;
            $no++;
		}

		$writer = new Xlsx($spreadsheet);
		header("Content-Type: application/vnd.ms-excel charset=utf-8");
		header("Content-Disposition: attachment; filename=\"DATA BRAND AMBASSADOR " . date('d m Y') . ".xlsx\"");
		header("Cache-Control: max-age=0");
		$writer->save('php://output');
    }
}
