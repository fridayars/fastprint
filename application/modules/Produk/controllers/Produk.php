<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load->model('M_Produk');
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['produk'] = $this->db->select("A.*, B.nama_status, C.nama_kategori")->from("produk A")->join("status B", "A.status_id = B.id_status")->join("kategori C", "A.kategori_id = C.id_kategori")->where(["B.nama_status" => "bisa dijual"])->get()->result_array();

        $data['status'] = $this->db->get("status")->result_array();
        $data['kategori'] = $this->db->get("kategori")->result_array();

        $this->load->view('Master/container/header');
        $this->load->view('v_produk', $data);
        $this->load->view('Master/container/footer');
    }

    public function create()
    {
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required', 
        array(
            'required' => '%s wajib diisi!'
        ));
        $this->form_validation->set_rules('harga', 'Harga', 'is_natural', 
        array(
            'is_natural' => ' Masukkan %s dengan format angka yang benar dan bulat!'
        ));

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $dt_produk = array(
                'nama_produk' => $this->input->post('nama_produk'),
                'harga' => $this->input->post('harga'),
                'kategori_id' => $this->input->post('kategori_id'),
                'status_id' => $this->input->post('status_id'),
            );
            $this->db->insert("produk", $dt_produk);
            $this->session->set_flashdata('berhasil', 'Data produk berhasil ditambahkan.');

            redirect($this->index(),'refresh');
            
        }
    }

    public function getDataProduk()
    {
        $id_produk = $this->input->post("id_produk");
        $data = $this->db->get_where("Produk", (['id_produk' => $id_produk]))->row_array();

        echo json_encode($data);
    }

    public function edit($id)
    {
        $this->form_validation->set_rules('nama_produk', 'Nama Produk', 'required', 
        array(
            'required' => '%s wajib diisi!'
        ));
        $this->form_validation->set_rules('harga', 'Harga', 'is_natural', 
        array(
            'is_natural' => ' Masukkan %s dengan format angka yang benar dan bulat!'
        ));

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            $dt_produk = array(
                'nama_produk' => $this->input->post('nama_produk'),
                'harga' => $this->input->post('harga'),
                'kategori_id' => $this->input->post('kategori_id'),
                'status_id' => $this->input->post('status_id'),
            );
            $this->db->update("Produk", $dt_produk, (['id_produk' => $id]));
            $this->session->set_flashdata('berhasil', 'Data produk berhasil diubah.');

            redirect($this->index(),'refresh');
        }
    }

    public function delete($id)
    {
        $this->db->delete("Produk", (['id_produk' => $id]));
        $this->session->set_flashdata('berhasil', 'Data produk berhasil dihapus.');

        redirect($this->index(),'refresh');
    }

}
