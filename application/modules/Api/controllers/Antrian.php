<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Antrian extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();

        $this->load->model('Model');
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('download');
    }

    public function get_antrian($toko_id)
    {
        date_default_timezone_set('Asia/Jakarta');
        $product = $this->db->query("SELECT kode, `no` FROM antrian2 WHERE toko_id = $toko_id AND `status` = 1 AND kategori_antrian = 1 AND tgl_antri = CURDATE() ORDER BY no DESC LIMIT 1")->result_array();
        $treatment = $this->db->query("SELECT kode, `no` FROM antrian2 WHERE toko_id = $toko_id AND `status` = 1 AND kategori_antrian = 2 AND tgl_antri = CURDATE() ORDER BY no DESC LIMIT 1")->result_array();
        $vip = $this->db->query("SELECT kode, `no` FROM antrian2 WHERE toko_id = $toko_id AND `status` = 1 AND kategori_antrian = 4 AND tgl_antri = CURDATE() ORDER BY no DESC LIMIT 1")->result_array();

        if ($product == null) {
            $product[0]['kode'] = 'P-';
            $product[0]['no'] = '0';
        }
        if ($treatment == null) {
            $treatment[0]['kode'] = 'T-';
            $treatment[0]['no'] = '0';
        }
        if ($vip == null) {
            $vip[0]['kode'] = 'V-';
            $vip[0]['no'] = '0';
        }

        $datas = array(
            'product'   => $product[0],
            'treatment' =>  $treatment[0],
            'vip'       =>  $vip[0],
        );

        $output = array(
            'data'      => $datas,
            'toko_id'   => $toko_id,
        );

        echo json_encode($output, true);
    }
}
