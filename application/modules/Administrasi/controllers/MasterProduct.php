<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class MasterProduct extends CI_Controller
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
        $dataHeader['title'] = "Data Master Product";
        $dataHeader['menu'] = 'Data Master Product';
        $dataHeader['file'] = 'Administrasi/MasterProduct';
        $dataHeader['link'] = 'index';

        $data['master_product'] = $this->db->query("SELECT A.*, B.nama AS kategori FROM master_produk A JOIN kategori_produk B ON A.kategori_id = B.id where A.is_delete = 0")->result_array();
        $data['tempats'] = $this->model->Code("SELECT id, nama FROM tempat_produk WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY nama ASC");
        $data['suppliers'] = $this->model->Code("SELECT id, nama FROM supplier WHERE is_delete = 0 AND toko_id = ".$_SESSION['toko_id']." ORDER BY nama ASC");
        $data['tipe_jumlahs'] = $this->model->Code("SELECT * FROM tipe_jumlah_produk WHERE toko_id = ".$_SESSION['toko_id']."");
        $data['golongans'] = $this->model->Code("SELECT * FROM golongan_produk WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY nama DESC");
        $data['kategoris'] = $this->model->Code("SELECT * FROM kategori_produk");

        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('list_master_product', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function add()
    {
        $this->db->trans_begin();
        /* insert tabel Master Produk */
        $data = $_POST['input'];
        $data['created_date'] = date('Y-m-d');
        $data['created_by'] = $_SESSION['id'];
        $this->db->insert('master_produk', $data);
        $insert_id = $this->db->insert_id();

        /* insert tabel produk all branch */
        $tokos= $this->model->Code("SELECT id, kode_toko FROM toko WHERE id != 99");
        foreach ($tokos as $key => $toko) {
            $no = $this->model->Code("SELECT id FROM produk_obat_bahan where toko_id = ".$toko['id']." ORDER BY created_date DESC");
            $max_id = $this->db->query("SELECT id FROM produk_obat_bahan WHERE toko_id = ".$toko['id']." ORDER BY id DESC LIMIT 0, 1")->row()->id;
            isset($data['is_referral']) ? : $data['is_referral'] = 0;
            isset($data['is_obatresep']) ? : $data['is_obatresep'] = 0;
            $dt_produk = array(
               'id'                 => $max_id+1,
               'toko_id'            => $toko['id'],
               'tempat_id'          => $data['tempat_id'],
               'supplier_id'        => $data['supplier_id'],
               'tipe_jumlah_id'     => $data['tipe_jumlah_id'],
               'golongan_id'        => $data['golongan_id'],
               'nama'               => $data['nama'],
               'harga_jual'         => $data['harga_jual'],
               'created_date'       => date('Y-m-d'),
               'created_by'         => $_SESSION['id'],
               'kode'               => $toko['kode_toko'] . 'PR-' . (count($no) + 1),
               'jumlah'             => $data['stok_awal_baru'],
               'min_stock'          => $data['min_stock'],
               'harga_beli'         => $data['harga_beli'],
               'fee_dokter'         => $data['fee_dokter'],
               'fee_beautician'     => $data['fee_beautician'],
               'fee_sales'          => $data['fee_sales'],
               'is_obatresep'       => $data['is_obatresep'],
               'kategori_id'        => $data['kategori_id'],
               'kode_dokter'        => $data['kode_dokter'],
               'diskon_referral'    => $data['diskon_referral'],
               'is_referral'        => $data['is_referral'],
               'master_produk_id'   => $insert_id,
            );
            $this->db->insert('produk_obat_bahan', $dt_produk);
            $max_id_stock = $this->db->query("SELECT id_stock FROM tb_stock_produk WHERE toko_id = ".$toko['id']." ORDER BY id_Stock DESC LIMIT 0, 1")->row()->id_stock;
            $data_stok = array(
                'id_stock'          => $max_id_stock+1,
                'tanggal'           => date('Y-m-d'),
                'id_barang'         => $max_id+1,
                'jumlah'            => $data['stok_awal_baru'],
                'min_jumlah'        => $data['min_stock'], 
                'toko_id'           => $toko['id'],
                'master_produk_id'  => $insert_id
            );
            $this->db->insert('tb_stock_produk', $data_stok);

            $max_id_stock2 = $this->db->query("SELECT id_stock FROM tb_stock_produk_history WHERE toko_id = ".$toko['id']." ORDER BY id_Stock DESC LIMIT 0, 1")->row()->id_stock;
            $data_stock2 = array(
                'id_stock'          => $max_id_stock2+1,
                'tanggal'           => date('Y-m-d'),
                'id_barang'         => $max_id+1,
                'jumlah'            => $data['stok_awal_baru'],
                'min_jumlah'        => $data['min_stock'], 
                'toko_id'           => $toko['id'],
                'master_produk_id'  => $insert_id
            );
            $this->db->insert('tb_stock_produk_history', $data_stock2);
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
        /* update data master produk */
        $data = $_POST['input'];
        isset($data['is_referral']) ? : $data['is_referral'] = 0;
        isset($data['is_obatresep']) ? : $data['is_obatresep'] = 0;
        $data['updated_date'] = date('Y-m-d');
        $data['updated_by'] = $_SESSION['id'];
        $this->db->update('master_produk', $data, ['id' => $id]);

        /* update data produk all branch */
        $dt_produk = array(
            'tempat_id'          => $data['tempat_id'],
            'supplier_id'        => $data['supplier_id'],
            'tipe_jumlah_id'     => $data['tipe_jumlah_id'],
            'golongan_id'        => $data['golongan_id'],
            'nama'               => $data['nama'],
            'harga_jual'         => $data['harga_jual'],
            'updated_date'       => date('Y-m-d'),
            'updated_by'         => $_SESSION['id'],
            'jumlah'             => $data['stok_awal_baru'],
            'min_stock'          => $data['min_stock'],
            'harga_beli'         => $data['harga_beli'],
            'fee_dokter'         => $data['fee_dokter'],
            'fee_beautician'     => $data['fee_beautician'],
            'fee_sales'          => $data['fee_sales'],
            'is_obatresep'       => $data['is_obatresep'],
            'kategori_id'        => $data['kategori_id'],
            'kode_dokter'        => $data['kode_dokter'],
            'diskon_referral'    => $data['diskon_referral'],
            'is_referral'        => $data['is_referral'],
         );
        $this->db->update('produk_obat_bahan', $dt_produk, ['master_produk_id' => $id]);

        $produks = $this->db->query("SELECT id, toko_id from produk_obat_bahan where master_produk_id = $id")->result_array();
        foreach ($produks as $produk) {
            $data2 = array(
                'min_jumlah'        => $data['min_stock']
            );
            $this->db->update('tb_stock_produk', $data2, ['id_barang' => $produk['id'], 'toko_id' => $produk['toko_id']]);
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

    public function delete($id)
    {
        $this->db->trans_begin();
        /* delete data master produk */
        $data['is_delete']  = 1;
        $data['updated_date'] = date('Y-m-d');
        $data['updated_by'] = $_SESSION['id'];
        $this->db->update('master_produk', $data, ['id' => $id]);

        /* delete data produk all branch */
        $data2['is_delete']     = 1;
        $data2['updated_by']    = $_SESSION['id'];
        $data2['updated_date']  = date('Y-m-d');
        $this->db->update('produk_obat_bahan', $data2, ['master_produk_id' => $id]);
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
    
    public function excel_products()
    {
        ob_end_clean();

		$data_product = $this->model->Code("SELECT * FROM v_master_produk");

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
		$sheet->setCellValue($kolom++ . $baris, 'TEMPAT');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'SUPPLIER');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'TIPE JUMLAH');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'GOLONGAN');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'NAMA PRODUK');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'HARGA JUAL');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'HARGA BELI');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'KODE');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'MINIMAL STOK');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'FEE DOKTER');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'FEE BEAUTICIAN');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'FEE SALES');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'OBAT RESEP');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'KATEGORI');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'KODE DOKTER');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
        $sheet->setCellValue($kolom++ . $baris, 'DISKON REFERRAL');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom . $baris++, 'STATUS REFERRAL');
		$sheet->getStyle($kolom_awal . $baris_awal . ':' . $kolom . $baris_awal)->applyFromArray($styleBold);

		foreach ($data_product as $key => $value) {
			$sheet->setCellValue($kolom_awal++ . $baris, $no);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['tempat']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['supplier']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['tipe_jumlah']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['golongan']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['nama']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['harga_jual']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['harga_beli']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['kode']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['min_stock']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['fee_dokter']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['fee_beautician']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['fee_sales']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['is_obatresep']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['kategori']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['kode_dokter']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['diskon_referral']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['is_referral']);

			$kolom_awal = 'A';
			$baris++;
            $no++;
		}

		$writer = new Xlsx($spreadsheet);
		header("Content-Type: application/vnd.ms-excel charset=utf-8");
		header("Content-Disposition: attachment; filename=\"DATA MASTER PRODUCT " . date('d m Y') . ".xlsx\"");
		header("Cache-Control: max-age=0");
		$writer->save('php://output');
    }
}
