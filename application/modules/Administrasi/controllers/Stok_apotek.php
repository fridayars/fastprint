<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Stok_apotek extends CI_Controller
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

        date_default_timezone_set('Asia/Jakarta');

        if ($_SESSION['role_id'] == 2 || $_SESSION['role_id'] == 3 || $_SESSION['role_id'] == 6) {
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
        $dataHeader['title'] = "Menu Stok Apotek " . $namatoko['nama'];
        $dataHeader['menu'] = 'Menu Stok Apotek';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';

        $bulan = date('Y-m');
        $data['cek_so'] = $this->model->Code("SELECT * FROM tb_stock_produk_history where left(tanggal, 7) = '$bulan' AND toko_id = ".$_SESSION['toko_id']."");
        
        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('menu_apotek');
        $this->load->view('Master/back-end/container/footer');
    }
    public function list_apotek()
    {
        $namatoko = $this->db->query("SELECT id, nama from toko where id = " . $_SESSION['toko_id'] . "")->row_array();
        $dataHeader['title'] = "List Stok Apotek " . $namatoko['nama'];
        $dataHeader['menu'] = 'List Stok Apotek';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';
        // $data['supplier']   = $this->model->Code("SELECT * FROM supplier where toko_id = ".$_SESSION['toko_id']." ORDER BY created_date DESC");
        $data['obats']      = $this->model->Code("SELECT * FROM v_produk_obat_bahan WHERE is_delete = 0 AND toko_id = ".$_SESSION['toko_id']." ORDER BY created_date DESC");
        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('list_apotek', $data);
        $this->load->view('Master/back-end/container/footer');
    }



    public function pembelian_stock_apotek()
    {
        $namatoko = $this->db->query("SELECT id, nama from toko where id = " . $_SESSION['toko_id'] . "")->row_array();
        $dataHeader['title'] = "Pembelian Obat / Alkes / Bahan Klinik " . $namatoko['nama'];
        $dataHeader['menu'] = 'Pembelian Obat / Alkes / Bahan';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';
        $data['obats'] = $this->model->Code("SELECT * FROM v_produk_obat_bahan WHERE is_delete = 0 AND toko_id = ".$_SESSION['toko_id']." ORDER BY created_date DESC");
        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('form-pembelian-obat', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function add()
    {
        $dataHeader['title'] = "Tambah Obat";
        $this->form_validation->set_rules('tempat_id', 'Tempat', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('supplier_id', 'supplier_id', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
        $this->form_validation->set_rules('tipe_jumlah_id', 'tipe_jumlah_id', 'required');
        $this->form_validation->set_rules('golongan_id', 'golongan_id', 'required');
        $this->form_validation->set_rules('min_stock', 'min_stock', 'required');
        $this->form_validation->set_rules('kategori_id', 'kategori_id', 'required');
        // $this->form_validation->set_rules('harga_beli', 'harga_beli', 'required');
        $this->form_validation->set_rules('harga_jual', 'harga_jual', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Tambah Obat';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $data['tempats'] = $this->model->Code("SELECT id, nama, toko_id FROM tempat_produk WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY nama ASC");
            $data['suppliers'] = $this->model->Code("SELECT id, nama FROM supplier WHERE is_delete = 0 AND toko_id = ".$_SESSION['toko_id']." ORDER BY nama ASC");
            $data['tipe_jumlahs'] = $this->model->Code("SELECT * FROM tipe_jumlah_produk WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY nama ASC");
            $data['golongans'] = $this->model->Code("SELECT * FROM golongan_produk WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY nama ASC");
            $data['kategoris'] = $this->model->Code("SELECT * FROM kategori_produk");
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_apotek', $data);
            $this->load->view('Master/back-end/container/footer', $dataHeader);
        } else {
            $no = $this->model->Code("SELECT id FROM produk_obat_bahan WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY created_date DESC");
            $kode = $_POST['tempat_id'] == 1 ? 'AZAP-' : 'AZKA-';
            $max_id = $this->db->query("SELECT id FROM produk_obat_bahan WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY id DESC LIMIT 0, 1")->row()->id;
            isset($_POST['is_referral']) ? $is_referral = 1 : $is_referral = 0;
            $data = array(
                'id' => $max_id+1,
                'toko_id' => $_SESSION['toko_id'],
                'kode' => $kode . (count($no) + 1),
                'nama' => $this->input->post('nama', true),
                'tempat_id' => $this->input->post('tempat_id', true),
                'supplier_id' => $this->input->post('supplier_id', true),
                'jumlah' => $this->input->post('jumlah', true),
                'tipe_jumlah_id' => $this->input->post('tipe_jumlah_id', true),
                'min_stock' => $this->input->post('min_stock', true),
                'golongan_id' => $this->input->post('golongan_id', true),
                'expired_date' => date('Y-m-d', strtotime($this->input->post('expired_date', true))),
                'harga_beli' => $this->input->post('harga_beli', true),
                'harga_jual' => $this->input->post('harga_jual', true),
                'fee_dokter' => $this->input->post('fee_dokter', true),
                'fee_beautician' => $this->input->post('fee_beautician', true),
                'fee_sales' => $this->input->post('fee_sales', true),
                'is_obatresep' => $this->input->post('is_obatresep', true),
                'is_bebas' => $this->input->post('is_bebas', true),
                'kategori_id' => $this->input->post('kategori_id', true),
                'created_date' => $this->DateStamp(),
                'created_by' => $_SESSION['id'],
                'kode_dokter' => $this->input->post('kode_dokter', true),
                'diskon_referral' => $this->input->post('diskon_referral', true),
                'is_referral' => $is_referral,
            );
            $this->db->insert('produk_obat_bahan', $data);
            $max_id_stock = $this->db->query("SELECT id_stock FROM tb_stock_produk WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY id_Stock DESC LIMIT 0, 1")->row()->id_stock;
            $data2 = array(
                'id_stock' => $max_id_stock+1,
                'tanggal' => $this->DateStamp(),
                'id_barang' => $max_id+1,
                'jumlah' => $this->input->post('jumlah', true),
                'min_jumlah' => $this->input->post('min_stock', true), 
                'toko_id' => $_SESSION['toko_id']
            );
            $this->db->insert('tb_stock_produk', $data2);

            $max_id_stock2 = $this->db->query("SELECT id_stock FROM tb_stock_produk_history WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY id_Stock DESC LIMIT 0, 1")->row()->id_stock;
            $data3 = array(
                'id_stock' => $max_id_stock2+1,
                'tanggal' => date('Y-m-01'),
                'id_barang' => $max_id+1,
                'jumlah' => $this->input->post('jumlah', true),
                'min_jumlah' => $this->input->post('min_stock', true), 
                'toko_id' => $_SESSION['toko_id']
            );
            $this->db->insert('tb_stock_produk_history', $data3);
            redirect('Administrasi/Stok_apotek/list_apotek');
        }
    }

    public function read($kode)
    {
        $dataHeader['menu'] = 'Detail Produk';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'index';
        $dataHeader['form'] = 'ok';
        $data['obat'] = $this->db->query("SELECT * FROM v_produk_obat_bahan WHERE toko_id = ".$_SESSION['toko_id']." AND is_delete = 0 AND kode = '".$kode."'")->row_array();
        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('view_product', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function edit($kode)
    {
        $dataHeader['title'] = "Edit Obat";
        $this->form_validation->set_rules('tempat_id', 'Tempat', 'required');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('supplier_id', 'supplier_id', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah', 'required');
        $this->form_validation->set_rules('tipe_jumlah_id', 'tipe_jumlah_id', 'required');
        $this->form_validation->set_rules('golongan_id', 'golongan_id', 'required');
        $this->form_validation->set_rules('min_stock', 'min_stock', 'required');
        $this->form_validation->set_rules('harga_beli', 'harga_beli', 'required');
        $this->form_validation->set_rules('harga_jual', 'harga_jual', 'required');
        $this->form_validation->set_rules('kategori_id', 'kategori_id', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu'] = 'Edit Obat';
            $dataHeader['file'] = 'Administrasi';
            $dataHeader['link'] = 'index';
            $dataHeader['form'] = 'ok';
            $data['tempats'] = $this->model->Code("SELECT id, nama, toko_id FROM tempat_produk WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY nama ASC");
            $data['suppliers'] = $this->model->Code("SELECT id, nama FROM supplier WHERE is_delete = 0 AND toko_id = ".$_SESSION['toko_id']." ORDER BY nama ASC");
            $data['tipe_jumlahs'] = $this->model->Code("SELECT * FROM tipe_jumlah_produk WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY nama ASC");
            $data['golongans'] = $this->model->Code("SELECT * FROM golongan_produk WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY nama ASC");
            $data['kategoris'] = $this->model->Code("SELECT * FROM kategori_produk");
            $data['obat'] = $this->db->get_where('produk_obat_bahan', ['kode' => $kode, 'toko_id' => $_SESSION['toko_id']])->row_array();
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('form_apotek', $data);
            $this->load->view('Master/back-end/container/footer', $dataHeader);
        } else {
            $id = $this->db->query("SELECT id FROM produk_obat_bahan WHERE kode = '$kode'")->row()->id;
            isset($_POST['is_referral']) ? $is_referral = 1 : $is_referral = 0;
            $data = array(
                'nama' => $this->input->post('nama', true),
                'tempat_id' => $this->input->post('tempat_id', true),
                'supplier_id' => $this->input->post('supplier_id', true),
                'jumlah' => $this->input->post('jumlah', true),
                'tipe_jumlah_id' => $this->input->post('tipe_jumlah_id', true),
                'min_stock' => $this->input->post('min_stock', true),
                'golongan_id' => $this->input->post('golongan_id', true),
                'expired_date' => date('Y-m-d', strtotime($this->input->post('expired_date', true))),
                'harga_beli' => $this->input->post('harga_beli', true),
                'harga_jual' => $this->input->post('harga_jual', true),
                'fee_dokter' => $this->input->post('fee_dokter', true),
                'fee_beautician' => $this->input->post('fee_beautician', true),
                'fee_sales' => $this->input->post('fee_sales', true),
                'is_obatresep' => $this->input->post('is_obatresep', true),
                'is_bebas' => $this->input->post('is_bebas', true),
                'kategori_id' => $this->input->post('kategori_id', true),
                'updated_by' => $_SESSION['id'],
                'updated_date' => $this->DateStamp(),
                'toko_id' => $_SESSION['toko_id'],
                'kode_dokter' => $this->input->post('kode_dokter', true),
                'diskon_referral' => $this->input->post('diskon_referral', true),
                'is_referral' => $is_referral,

            );
            $this->db->update('produk_obat_bahan', $data, ['kode' => $kode, 'toko_id' => $_SESSION['toko_id']]);
            
            $data2 = array(
                'min_jumlah' => $this->input->post('min_stock', true)
            );
            $this->db->update('tb_stock_produk', $data2, ['id_barang' => $id, 'toko_id' => $_SESSION['toko_id']]);

            redirect('Administrasi/Stok_apotek/list_apotek');
        }
    }

    public function delete($kode)
    {
        $data = array(
            'is_delete' => 1,
            'updated_by' => $_SESSION['id'],
            'updated_date' => $this->DateStamp(),
        );
        $this->db->update('produk_obat_bahan', $data, ['kode'  => $kode, 'toko_id' => $_SESSION['toko_id']]);
        redirect('Administrasi/Stok_apotek/list_apotek');
    }

    public function kartu_stock_produk($Aksi = "")
    {

        $dataHeader['title']        = "Kartu Stock Opname";
        $dataHeader['menu']         = 'Master';
        $dataHeader['file']         = 'Kartu Stock Produk';
        $dataHeader['link']         = 'kartu_stock_kemasan';
        $data['action']             = $Aksi;

        if (empty($Aksi)) {
            $data['bulan']          = "";
            $data['tahun']          = "";
            $data['row']            = $this->model->code("SELECT * FROM v_stock_bahan WHERE tanggal = '2017-01-01' AND toko_id = ".$_SESSION['toko_id']."");
        } else {
            $data['bulan']          = $this->input->post('cBulan');
            $data['tahun']          = $this->input->post('cTahun');
            $data['row']            = $this->model->ViewAsc('v_stock_bahan', 'id_kemasan');
        }

        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('apotek/kartu-stock-apotek', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function tampil_stock_produk()
    {
        $data['bulan']          = $this->input->post('bulan');
        $data['tahun']          = $this->input->post('tahun');
        $data['row']            = $this->model->code("SELECT * FROM v_stock_bahan WHERE toko_id = ".$_SESSION['toko_id']."");
        $this->load->view('apotek/table-kartu-stock', $data);
    }

    public function tampil_stock_produk_real($idBarang = "", $Bulan = "", $Tahun = "")
    {
        $data['idbarang']       = $idBarang;
        $data['bulan']          = $Bulan;
        $data['tahun']          = $Tahun;
        
        $this->load->view('apotek/show_kartu_stock_detail-produk', $data);
    }

    public function stock_opname_produk($Aksi = "")
    {

        $dataHeader['title']        = "STOCK HARI INI" ;
        $dataHeader['menu']         = 'Master';
        $dataHeader['file']         = 'Stock Barang Jadi';
        $dataHeader['link']         = 'stock_opname_kemasan';
        $data['action']             = $Aksi;

        // $data['row']                = $this->model->ViewAsc('v_stock_bahan', 'nama');
        $data['row']                = $this->db->query("CALL get_stock_opname('".date('Y-m-d')."',".$_SESSION['toko_id'].")")->result_array();

        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('apotek/stock-harian', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function stock_opname()
    {
        $datetime = new DateTime('tomorrow');
        $besok = $datetime->format('Y-m-d');

        $get_stock = $this->model->code("SELECT * FROM tb_stock_produk WHERE toko_id = ".$_SESSION['toko_id']."");
        $max_id = $this->db->query("SELECT id FROM tb_stock_produk_history WHERE toko_id = ".$_SESSION['toko_id']." ORDER BY id DESC LIMIT 0, 1")->row()->id;
        
        foreach ($get_stock as $key => $value) {
            $data = array(
                'id' => $max_id+1,
                'tanggal' => $besok,
                'id_barang' => $value['id_barang'],
                'jumlah' => $value['jumlah'],
                'min_jumlah' => $value['min_jumlah'],
                'rusak' => $value['rusak'],
                'nama_produk' => $value['nama_produk'],
                'toko_id' => $_SESSION['toko_id']
            );
            $this->db->insert('tb_stock_produk_history', $data);
        }
        $this->session->set_flashdata('berhasil', 'STOK OPNAME UNTUK STOK AWAL BULAN DEPAN BERHASIL!!!');
        redirect('Administrasi/Stok_apotek');
    }

    public function penyesuaian_stok()
    {
        $dataHeader['title'] = "Penyesuaian Stok";
        $dataHeader['menu'] = 'Penyesuaian Stok';
        $dataHeader['file'] = 'Administrasi';
        $dataHeader['link'] = 'penyesuaian_stok';
        
        $arrobat 			= $this->model->Code("SELECT * FROM produk_obat_bahan WHERE is_delete = 0 AND toko_id = ".$_SESSION['toko_id']."");
		$data['arrobat'] = "<option></option>";
		foreach ($arrobat as $index => $value) {
			$data['arrobat'] .= '<option value="' . $value['id'] . '">' . $value['nama'] . '</option>';
		}

        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('apotek/form_penyesuaian_stok', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function edit_stok()
    {
        $bulan     = $this->input->post('bulan');
        $tahun     = $this->input->post('tahun');
        $tanggal   = $tahun.'-'.$bulan;
        $id_barang = $this->input->post('id_barang');
        $data['row'] = $this->db->query("SELECT A.*, B.nama FROM tb_stock_produk_history A JOIN produk_obat_bahan B ON A.id_barang = B.id AND A.toko_id = B.toko_id WHERE LEFT(A.tanggal, 7) = '$tanggal' AND A.id_barang = $id_barang AND A.toko_id = ".$_SESSION['toko_id']."")->row_array();
        $this->load->view('apotek/form_edit_stok', $data);
    }
    public function edit_stok2()
    {
        $id_barang = $this->input->post('id_barang');
        $data['row'] = $this->db->query("SELECT A.*, B.nama FROM tb_stock_produk A JOIN produk_obat_bahan B ON A.id_barang = B.id AND A.toko_id = B.toko_id WHERE A.id_barang = $id_barang AND A.toko_id = ".$_SESSION['toko_id']."")->row_array();
        $this->load->view('apotek/form_edit_stok2', $data);
    }
    
    public function edit_stok_awal($id)
    {
        $input = $_POST['input'];
        
        $data = array(
            'id_stock' => $id,
            'id_produk' => $input['id_barang'],
            'stok_awal' => $input['stok_awal'],
            'stok_edit' => $input['stok_edit'],
            'keterangan' => $input['keterangan'],
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $_SESSION['id'], 
            'toko_id' => $_SESSION['toko_id']
        );
        $this->db->insert('penyesuaian_stok_awal', $data);
        
        $update = array(
            'jumlah' => $input['stok_awal']-$input['stok_edit']
        );
        $this->db->update('tb_stock_produk_history', $update, ['id_stock' => $id, 'toko_id' => $_SESSION['toko_id']]);

        $minus = $input['stok_edit'];
        $id_barang = $input['id_barang'];
        $this->db->query("UPDATE tb_stock_produk SET jumlah = jumlah-$minus WHERE id_barang = $id_barang AND toko_id = ".$_SESSION['toko_id']."");
        
        redirect('Administrasi/Stok_apotek/penyesuaian_stok','refresh');
    }

    public function edit_stok_akhir($id)
    {
        $input = $_POST['input'];
        
        $data = array(
            'tanggal' => date('Y-m-d'),
            'id_barang' => $input['id_barang'],
            'stok_edit' => $input['stok_edit'],
            'keterangan' => $input['keterangan'],
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $_SESSION['id'], 
            'toko_id' => $_SESSION['toko_id']
        );
        $this->db->insert('penyesuaian_stok_akhir', $data);

        $minus = $input['stok_edit'];
        $id_barang = $input['id_barang'];
        $this->db->query("UPDATE tb_stock_produk SET jumlah = jumlah-$minus WHERE id_barang = $id_barang AND toko_id = ".$_SESSION['toko_id']."");
        
        redirect('Administrasi/Stok_apotek/penyesuaian_stok','refresh');
    }

    public function excel_products()
    {
        ob_end_clean();

		$data_produk = $this->model->Code("SELECT * FROM v_produk_obat_bahan WHERE is_delete = 0 AND toko_id = ".$_SESSION['toko_id']." ORDER BY nama");
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
		$sheet->setCellValue($kolom++ . $baris, 'KODE PRODUK');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'KODE DOKTER');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'NAMA PRODUK');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'SATUAN UNIT');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'KATEGORI');
        $sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom++ . $baris, 'HARGA BELI');
		$sheet->getColumnDimension($kolom)->setAutoSize(true);
		$sheet->setCellValue($kolom . $baris++, 'HARGA JUAL');
		$sheet->getStyle($kolom_awal . $baris_awal . ':' . $kolom . $baris_awal)->applyFromArray($styleBold);

		foreach ($data_produk as $key => $value) {
			$sheet->setCellValue($kolom_awal++ . $baris, $value['kode']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['kode_dokter']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['nama']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['unit_nama']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['kategori']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['harga_beli']);
			$sheet->setCellValue($kolom_awal++ . $baris, $value['harga_jual']);

			$kolom_awal = 'A';
			$baris++;
		}

		$writer = new Xlsx($spreadsheet);
		header("Content-Type: application/vnd.ms-excel charset=utf-8");
		header("Content-Disposition: attachment; filename=\"DATA PRODUK " . $toko . " " . date('d M Y') . ".xlsx\"");
		header("Cache-Control: max-age=0");
		$writer->save('php://output');
    }
}
