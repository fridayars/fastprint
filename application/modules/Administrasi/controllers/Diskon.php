<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Diskon extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load->model('Discount');
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->library('zip');
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('download');
        $this->load->helper('html');
        $this->load->helper('file');
        $this->load->library('form_validation');
        if (!$_SESSION['logged_in']) redirect(site_url() . "Login");

        if ($_SESSION['role_id'] == 2 || $_SESSION['role_id'] == 4 || $_SESSION['role_id'] == 6) {
            redirect('Dashboard','refresh');
        }
        date_default_timezone_set("Asia/Jakarta");
    }

    public function index()
    {
        $dataHeader['title']    = "Menu Voucher Diskon";
        $dataHeader['menu']     = "Menu Voucher Diskon";
        $dataHeader['file']     = "Administrasi";
        $dataHeader['link']     = "index";

        if($_SESSION['toko_id'] == 99){
            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('diskon/menu_diskon');
            $this->load->view('Master/back-end/container/footer');
        }else{
            $this->list_diskon();
        }
    }

    public function list_diskon()
    {
        $dataHeader['title']    = "Data Voucher Diskon";
        $dataHeader['menu']     = "Data Voucher Diskon";
        $dataHeader['file']     = "Administrasi";
        $dataHeader['link']     = "index";

        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('diskon/list_diskon');
        $this->load->view('Master/back-end/container/footer');
    }

    public function list_template()
    {
        $dataHeader['title']    = "Data Template Diskon";
        $dataHeader['menu']     = "Data Template Diskon";
        $dataHeader['file']     = "Administrasi";
        $dataHeader['link']     = "index";

        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('diskon/list_template');
        $this->load->view('Master/back-end/container/footer');
    }

    public function get_vDirect()
    {
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->Discount->get_vDirect($postData);

        echo json_encode($data);
    }

    public function get_vGenerate()
    {
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->Discount->get_vGenerate($postData);

        echo json_encode($data);
    }

    public function get_template()
    {
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->Discount->get_template($postData);

        echo json_encode($data);
    }

    public function create()
    {
        $data['title'] = 'Form Tambah Voucher Diskon';
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('kode_voucher', 'Kode Voucher', 'is_unique[tb_voucher_kode.kode_voucher]', array('is_unique' => '%s sudah digunakan, masukkan %s yang lain!'));

        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu']     = 'Form Voucher Diskon';
            $dataHeader['file']     = 'Voucher Diskon';
            $dataHeader['link']     = 'Administrasi/Diskon';
            $dataHeader['title']    = 'Tambah Voucher Diskon';

            $data['v_kategori'] = $this->db->query("SELECT * FROM tb_voucher_kategori WHERE is_delete=0")->result_array();
            $data['v_jenis']    = $this->db->query("SELECT * FROM tb_voucher_jenis WHERE is_delete=0")->result_array();
            $data['v_template'] = $this->db->query("SELECT * FROM tb_voucher_template WHERE is_delete=0")->result_array();
            $data['v_toko']     = $this->db->query("SELECT * FROM toko")->result_array();

            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('diskon/form_diskon', $data);
            $this->load->view('Master/back-end/container/footer');
        } else {
            $this->db->trans_begin();

            $toko_id = $_POST['toko_id'];
            $arrtanggal = explode(' - ', $this->input->post('date'));
		    $start_date = date('Y-m-d', strtotime($arrtanggal[0]));
		    $exp_date   = date('Y-m-d', strtotime($arrtanggal[1]));

            $is_unlimited_date = '';
            isset($_POST['is_unlimited_date']) ? $is_unlimited_date = 1 : $is_unlimited_date = 0;

            $is_unlimited_qty = '';
            isset($_POST['is_unlimited_qty']) ? $is_unlimited_qty = 1 : $is_unlimited_qty = 0;

            $is_combine = '';
            isset($_POST['is_combine']) ? $is_combine = 1 : $is_combine = 0;

            $dt_voucher = array(
                'nama'                  => $this->input->post('nama', true),
                'deskripsi'             => $this->input->post('deskripsi', true),
                'voucher_jenis_id'      => $this->input->post('voucher_jenis_id', true),
                'voucher_kategori_id'   => $this->input->post('voucher_kategori_id', true),
                // 'toko_id'               => $this->input->post('toko_id', true),
                'start_date'            => $start_date,
                'exp_date'              => $exp_date,
                'is_unlimited_date'     => $is_unlimited_date,
                'tipe_diskon'           => $this->input->post('tipe_diskon', true),
                'total_diskon'          => $this->input->post('total_diskon', true),
                'total_diskon_max'      => $this->input->post('total_diskon_max', true),
                'quantity'              => $this->input->post('quantity', true),
                'is_unlimited_qty'      => $is_unlimited_qty,
                'is_combine'            => $is_combine,
                'created_by'            => $_SESSION['new_id'],
                'created_at'            => date('Y-m-d H:i:s'),
                'voucher_template_id'   => $this->input->post('voucher_template_id', true),
            );

            $this->db->insert("tb_voucher_diskon", $dt_voucher);
            $insert_id = $this->db->insert_id();

            foreach($toko_id as $toko){
                $dt_voucher_toko = array(
                    'voucher_diskon_id' => $insert_id,
                    'toko_id'           => $toko
                );
                $this->db->insert("tb_voucher_toko", $dt_voucher_toko);
            }

            if ($_POST['voucher_kategori_id'] == 1) {
                $dt_voucher_kode = array(
                    'voucher_diskon_id' => $insert_id,
                    'kode_voucher'      => $this->input->post('kode_voucher', true),
                );
                $this->db->insert("tb_voucher_kode", $dt_voucher_kode);
            } elseif ($_POST['voucher_kategori_id'] == 2) {
                for ($i = 0; $i < $dt_voucher['quantity']; $i++) {
                    $isUnique = false;
                    $kode_voucher = '';
                
                    while (!$isUnique) {
                        // Generate kode acak 6 karakter
                        $seed = str_split('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
                        shuffle($seed);
                        $kode_voucher = '';
                        foreach (array_rand($seed, 6) as $k) {
                            $kode_voucher .= $seed[$k];
                        }
                
                        // Cek keunikan kode_voucher
                        $this->db->where('kode_voucher', $kode_voucher);
                        $existingVoucher = $this->db->get('tb_voucher_kode')->row();
                
                        if (!$existingVoucher) {
                            // Kode_voucher unik, keluar dari loop
                            $isUnique = true;
                        }
                    }
                
                    $dt_voucher_kode = array(
                        'voucher_diskon_id' => $insert_id,
                        'kode_voucher'      => $kode_voucher,
                    );
                
                    $this->db->insert("tb_voucher_kode", $dt_voucher_kode);
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Gagal diproses, mohon ulangi beberapa saat lagi.');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('success', 'Perubahan berhasil disimpan.');
                $this->db->trans_commit();
            }
            redirect("Administrasi/Diskon/listItem/".$insert_id);
        }
    }

    public function create_template()
    {
        $data['title'] = 'Form Tambah Template Diskon';
        $this->form_validation->set_rules('nama_template', 'Nama Template', 'required');
        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu']     = 'Form Template Diskon';
            $dataHeader['file']     = 'Template Diskon';
            $dataHeader['link']     = 'Administrasi/Diskon';
            $dataHeader['title']    = 'Tambah Template Diskon';

            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('diskon/form_template');
            $this->load->view('Master/back-end/container/footer');
        } else {
            $this->db->trans_begin();

            $file = $_FILES['file_url'];
            $filename = time().'_'. str_replace(' ', '_', $file['name']);

            $config['upload_path']          = './assets/template/';
            $config['allowed_types']        = 'jpg|png|jpeg';
            $config['max_size']             = 2048;
            $config['file_name']            = $filename;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('file_url'))
            {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('error', $error['error']);
                    redirect($_SERVER['HTTP_REFERER']);
            }
            else
            {
                    $data = array('upload_data' => $this->upload->data());
                    $dt_template = array(
                        "nama_template" => $this->input->post("nama_template"),
                        "file_url"      => $filename
                    );
                    $this->db->insert("tb_voucher_template", $dt_template);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Gagal diproses, mohon ulangi beberapa saat lagi.');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('success', 'Perubahan berhasil disimpan.');
                $this->db->trans_commit();
            }
            redirect("Administrasi/Diskon/list_template");
        }
    }

    public function delete($id)
    {
        $data = array(
            'updated_by' => $_SESSION['new_id'],
            'updated_at' => date("Y-m-d H:i:s"),
            'is_delete'  => 1,
        );
        $this->db->update("tb_voucher_diskon", $data, ["id" => $id]);
        
        redirect('Administrasi/Diskon/list_diskon','refresh');
    }

    public function delete_template($id)
    {
        $this->db->update("tb_voucher_template", ['is_delete' => 1], ['id' => $id]);
        $this->session->set_flashdata('success', 'Perubahan berhasil disimpan.');
        redirect("Administrasi/Diskon/list_template");
    }

    public function listItem($id)
    {
            $data['voucher']        = $this->db->query("SELECT * FROM tb_voucher_diskon WHERE id = $id")->row_array();

            $dataHeader['menu']     = 'List Voucher Diskon';
            $dataHeader['file']     = 'Voucher Diskon';
            $dataHeader['link']     = 'Administrasi/Diskon';
            if($data['voucher']['voucher_jenis_id'] == 3){
                $dataHeader['title']    = $data['voucher']['nama'].' ('.number_format($data['voucher']['total_diskon']). ')';
            }else{
                $dataHeader['title']    = $data['voucher']['nama'];
            }

            $data['treatments'] = $this->db->query("SELECT A.id, A.nama_treatment, A.tarif FROM master_treatment A WHERE A.id not in (SELECT B.treatment_id as id FROM tb_voucher_detail_item B WHERE B.voucher_diskon_id = $id AND B.treatment_id is not null) AND A.is_delete = 0")->result_array();
            $data['products']   = $this->db->query("SELECT A.id, A.nama, A.harga_jual FROM master_produk A WHERE A.id not in (SELECT B.produk_id as id FROM tb_voucher_detail_item B WHERE B.voucher_diskon_id = $id AND B.produk_id is not null) AND A.is_delete = 0")->result_array();

            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('diskon/list_item', $data);
            $this->load->view('Master/back-end/container/footer');
    }

    public function jsonListItemProduct($voucher_id)
	{
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->Discount->jsonListItemProduct($voucher_id, $postData);

        echo json_encode($data);
	}

    public function jsonListItemTreatment($voucher_id)
	{
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->Discount->jsonListItemTreatment($voucher_id, $postData);

        echo json_encode($data);
	}

    public function deleteItem($id)
    {
        $this->db->delete('tb_voucher_detail_item', ['id' => $id]);

        redirect($_SERVER['HTTP_REFERER']);        
    }

    public function addItemTreatment($id)
    {
        $treatment_id = $this->input->post('treatment_id');
		
        if($treatment_id == 0)
        {
            $arr_treatment = $this->db->query("SELECT A.id FROM master_treatment A WHERE A.id not in (SELECT B.treatment_id as id FROM tb_voucher_detail_item B WHERE B.voucher_diskon_id = $id AND B.treatment_id is not null) AND A.is_delete = 0")->result_array();
            foreach($arr_treatment as $tr){
                $data = array(
                    'voucher_diskon_id' => $id,
                    'treatment_id'      => $tr['id']
                );
                $this->db->insert("tb_voucher_detail_item", $data);
            }
            $status = 200;
        }else{
            $existingItem = $this->db->get_where("tb_voucher_detail_item", ['voucher_diskon_id' => $id, 'treatment_id' => $treatment_id])->row();
            
            if(!$existingItem){
                $data = array(
                    'voucher_diskon_id' => $id,
                    'treatment_id'      => $treatment_id
                );
                $this->db->insert("tb_voucher_detail_item", $data);
            }
            
            $status = 200;
        }

		echo json_encode($status);
    }

    public function addItemProduct($id)
    {
        $product_id = $this->input->post('product_id');
		
        if($product_id == 0)
        {
            $arr_product = $this->db->query("SELECT A.id FROM master_produk A WHERE A.id not in (SELECT B.produk_id as id FROM tb_voucher_detail_item B WHERE B.voucher_diskon_id = $id AND B.produk_id is not null) AND A.is_delete = 0")->result_array();
            foreach($arr_product as $pr){
                $data = array(
                    'voucher_diskon_id' => $id,
                    'produk_id'         => $pr['id']
                );
                $this->db->insert("tb_voucher_detail_item", $data);
            }
            $status = 200;
        }else{
            $existingItem = $this->db->get_where("tb_voucher_detail_item", ['voucher_diskon_id' => $id, 'produk_id' => $product_id])->row();

            if(!$existingItem){
                $data = array(
                    'voucher_diskon_id' => $id,
                    'produk_id'         => $product_id
                );
                $this->db->insert("tb_voucher_detail_item", $data);
            }
            
            $status = 200;
        }

		echo json_encode($status);
    }

    public function edit($id)
    {
        $data['title']      = 'Form Edit Voucher Diskon';
        $data['voucher']    = $this->db->query("SELECT A.*, B.kode_voucher FROM `tb_voucher_diskon` A JOIN tb_voucher_kode B ON A.id = B.voucher_diskon_id WHERE A.id = $id LIMIT 1")->row_array();

        if($this->input->post('kode_voucher') != $data['voucher']['kode_voucher']) {
            $kode_unique =  '|is_unique[tb_voucher_kode.kode_voucher]';
        } else {
            $kode_unique =  '';
        }
        
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('kode_voucher', 'Kode Voucher', 'required'.$kode_unique, array('is_unique' => '%s sudah digunakan, masukkan %s yang lain!'));

        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu']     = 'Form Voucher Diskon';
            $dataHeader['file']     = 'Voucher Diskon';
            $dataHeader['link']     = 'Administrasi/Diskon';
            $dataHeader['title']    = 'Edit Voucher Diskon';

            $data['v_kategori'] = $this->db->query("SELECT * FROM tb_voucher_kategori WHERE is_delete=0")->result_array();
            $data['v_jenis']    = $this->db->query("SELECT * FROM tb_voucher_jenis WHERE is_delete=0")->result_array();
            $data['v_template'] = $this->db->query("SELECT * FROM tb_voucher_template WHERE is_delete=0")->result_array();
            $data['v_toko']     = $this->db->query("SELECT B.* FROM tb_voucher_toko A join toko B on A.toko_id = B.id where A.voucher_diskon_id = $id")->result_array();

            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('diskon/form_edit_diskon', $data);
            $this->load->view('Master/back-end/container/footer');
        } else {
            $this->db->trans_begin();

            $arrtanggal = explode(' - ', $this->input->post('date'));
		    $start_date = date('Y-m-d', strtotime($arrtanggal[0]));
		    $exp_date   = date('Y-m-d', strtotime($arrtanggal[1]));

            $is_unlimited_date = '';
            isset($_POST['is_unlimited_date']) ? $is_unlimited_date = 1 : $is_unlimited_date = 0;

            $is_unlimited_qty = '';
            isset($_POST['is_unlimited_qty']) ? $is_unlimited_qty = 1 : $is_unlimited_qty = 0;

            $dt_voucher = array(
                'nama'                  => $this->input->post('nama', true),
                'deskripsi'             => $this->input->post('deskripsi', true),
                'start_date'            => $start_date,
                'exp_date'              => $exp_date,
                'is_unlimited_date'     => $is_unlimited_date,
                'tipe_diskon'           => $this->input->post('tipe_diskon', true),
                'total_diskon'          => $this->input->post('total_diskon', true),
                'total_diskon_max'      => $this->input->post('total_diskon_max', true),
                'quantity'              => $this->input->post('quantity', true),
                'is_unlimited_qty'      => $is_unlimited_qty,
                'updated_by'            => $_SESSION['new_id'],
                'updated_at'            => date('Y-m-d H:i:s'),
                'voucher_template_id'   => $this->input->post('voucher_template_id', true),
            );

            $this->db->update("tb_voucher_diskon", $dt_voucher, ["id" => $id]);

            if ($kode_unique != "") {
                $dt_voucher_kode = array(
                    'kode_voucher'      => $this->input->post('kode_voucher', true),
                );
                $this->db->update("tb_voucher_kode", $dt_voucher_kode, ["voucher_diskon_id" => $id]);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Gagal diproses, mohon ulangi beberapa saat lagi.');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('success', 'Perubahan berhasil disimpan.');
                $this->db->trans_commit();
            }
            redirect("Administrasi/Diskon/list_diskon");
        }
    }

    public function edit_template($id)
    {
        $data['title']      = 'Form Edit Template Diskon';
        $data['template']   = $this->db->query("SELECT * FROM tb_voucher_template WHERE id = $id")->row_array();
        
        $this->form_validation->set_rules('nama_template', 'Nama Template', 'required');

        if ($this->form_validation->run() == FALSE) {
            $dataHeader['menu']     = 'Form Template Diskon';
            $dataHeader['file']     = 'Template Diskon';
            $dataHeader['link']     = 'Administrasi/Diskon';
            $dataHeader['title']    = 'Edit Template Diskon';

            $this->load->view('Master/back-end/container/header', $dataHeader);
            $this->load->view('diskon/form_edit_template', $data);
            $this->load->view('Master/back-end/container/footer');
        } else {
            $this->db->trans_begin();

            if (!file_exists($_FILES['file_url']['tmp_name']) || !is_uploaded_file($_FILES['file_url']['tmp_name'])) 
            {
                $this->db->update("tb_voucher_template", ['nama_template' => $_POST['nama_template'], ['id' => $id]]);
            }
            else
            {
                unlink( "./assets/template/". $data['template']['file_url']);
                $file = $_FILES['file_url'];
                $filename = time().'_'.str_replace(' ', '_', $file['name']);

                $config['upload_path']          = './assets/template/';
                $config['allowed_types']        = 'jpg|png|jpeg';
                $config['max_size']             = 2048;
                $config['file_name']            = $filename;

                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('file_url'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        $this->session->set_flashdata('error', $error['error']);
                        redirect($_SERVER['HTTP_REFERER']);
                }
                else
                {
                        $data = array('upload_data' => $this->upload->data());
                        $dt_template = array(
                            "nama_template" => $this->input->post("nama_template"),
                            "file_url"      => $filename
                        );
                        $this->db->update("tb_voucher_template", $dt_template, ['id' => $id]);
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error', 'Gagal diproses, mohon ulangi beberapa saat lagi.');
                redirect($_SERVER['HTTP_REFERER']);
            } else {
                $this->session->set_flashdata('success', 'Perubahan berhasil disimpan.');
                $this->db->trans_commit();
            }
            redirect("Administrasi/Diskon/list_template");
        }
    }

    public function addDiskonItem()
    {
        $id = $this->input->post("id");
        $diskon_item = $this->input->post("diskon_item");

        $this->db->update("tb_voucher_detail_item", ['diskon_item' => $diskon_item], ['id' => $id]);

        echo json_encode($data = "Diskon item berhasil disimpan!");
    }

    public function downloadTemplate($kode)
    {
        $data = $this->db->select("A.exp_date, A.nama, B.kode_voucher, C.file_url")->from("tb_voucher_diskon A")->join("tb_voucher_kode B", "A.id = B.voucher_diskon_id")->join("tb_voucher_template C", "A.voucher_template_id = C.id")->where("B.kode_voucher = '$kode'")->get()->row_array();

        $this->load->view("diskon/print_template", $data);
    }

    public function qrcode_template($kode)
    {
		$params['data'] 	= $kode; //data yang akan di jadikan QR CODE
		$params['level'] 	= 'H'; //H=High
		$params['size'] 	= 10;
		$params['savename'] = null; //simpan image QR CODE ke folder assets/images/
		echo $this->ciqrcode->generate($params); // fungsi untuk generate QR CODE
    }

    public function upload_image_voucher()
    {
        if (isset($_POST['image_data'])) {
            // Menerima data gambar dari AJAX
            $image_data = $_POST['image_data'];
      
            // Mengubah data URL menjadi file gambar
            $image_data = str_replace('data:image/png;base64,', '', $image_data);
            $decoded_image = base64_decode($image_data);

            // Lokasi penyimpanan gambar di server
            $upload_path = './assets/temp/file/';
      
            // Nama berkas untuk disimpan di server (misalnya: tangkapan-layar.png)
            $file_name = $_POST['nama_file'];
      
            // Simpan berkas di server
            file_put_contents($upload_path . $file_name, $decoded_image);
            // Lakukan tindakan lain yang diperlukan
      
            // Kirim respons ke klien (JS) bahwa unggahan berhasil
            echo "success";
        } else {
            // Kirim respons ke klien (JS) bahwa unggahan gagal
            echo "error";
        }
    }

    public function bulkDownloadTemplate($id)
    {
        $fileDir     = './assets/temp/file/';
        if (!is_dir($fileDir)) {
            mkdir($fileDir, 0777, true);
        }
        $this->rrmdir($fileDir);

        $data['voucher'] = $this->db->select("A.exp_date, A.nama, B.kode_voucher, C.file_url")->from("tb_voucher_diskon A")->join("tb_voucher_kode B", "A.id = B.voucher_diskon_id")->join("tb_voucher_template C", "A.voucher_template_id = C.id")->where("A.id = $id")->get()->result_array();

        $this->load->view("diskon/preview_template", $data);
    }

    public function download_zip($voucher)
    {
        $zipDir     = './assets/temp/zip/';
        if (!is_dir($zipDir)) {
            mkdir($zipDir, 0777, true);
        }
        $this->rrmdir($zipDir);

        $fileDir    = './assets/temp/file/';
        // Zip the files
        $zipFileName = $voucher.".zip";
        $zipFilePath = $zipDir . $zipFileName;
        $this->zip->read_dir($fileDir, FALSE);
        $this->zip->archive($zipFilePath);

        // Send the zip file as a response
        force_download($zipFilePath, NULL);

        exit;
    }

    private function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir . "/" . $object) == "dir") {
                        $this->rrmdir($dir . "/" . $object);
                    } else {
                        unlink($dir . "/" . $object);
                    }
                }
            }
            reset($objects);
            // rmdir($dir);
        }
    }
}
