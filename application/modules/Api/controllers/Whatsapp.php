<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Whatsapp extends CI_Controller
{
    public function __construct()
    {

        parent::__construct();

        $this->load->model('Model');
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('download');
        date_default_timezone_set('Asia/Jakarta');
		if (!$_SESSION['logged_in']) redirect(site_url() . "Login");
    }

    public function cek_curl()
    {
        if (function_exists('curl_version')) {
            echo "cURL is installed on this server.";
        } else {
            echo "cURL is not installed on this server.";
        }
    }

    public function post_request($url, $data)
    {
        $api_whatsapp = $this->db->get('api_whatsapp', 1)->row_array();
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . $api_whatsapp['access_token'],
            "Content-Type: application/json"
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    function get_request($url){
        $api_whatsapp = $this->db->get('api_whatsapp', 1)->row_array();
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => [
            "Authorization: Bearer " . $api_whatsapp['access_token'],
            "Content-Type: application/json"
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
        
	}

    public function send_undian($id, $pasien_new_id)
    {
        $api_whatsapp = $this->db->get('api_whatsapp', 1)->row_array();
        $url = 'https://service-chat.qontak.com/api/open/v1/broadcasts/whatsapp/direct';
        /* data pasien */
        $dt_pasien = $this->db->get_where('pasien', ['new_id' => $pasien_new_id])->row_array();
        $to_number = $dt_pasien['no_hp'];
        if(substr($to_number,0,1) == 0 ){
            $to_number = '62'.substr($to_number,1);
        }elseif (substr($to_number,0,1) == 8) {
            $to_number = '62'.$to_number;
        }
        /* data undian */
        $dt_undian = $this->db->query("SELECT A.*, B.nama FROM undian A JOIN toko B ON A.toko_id = B.id WHERE A.pembayaran_id = $id AND A.toko_id = ".$_SESSION['toko_id']."")->result_array();
        
        /* group sizing */
        $group_size = 20;

        for ($i = 0; $i < count($dt_undian); $i++) {
            if ($i % $group_size == 0) {
                // memulai bagian baru setiap kali $i memenuhi kondisi ini
                $group_index = floor($i / $group_size);
                $groups[$group_index] = [];
            }

            $groups[$group_index][] = $dt_undian[$i];
        }

        for ($i=0; $i < count($groups) ; $i++) {

            $nomor = '';
            foreach ($groups[$i] as $key => $value) {
                $nomor .= $value['nomor_undian'];
                if($key < count($groups[$i])-1){
                    $nomor .= ", ";
                }
            }

            $data = array(
                "to_name"				=> ucwords(strtolower($dt_pasien['nama'])),
                "to_number"				=> $to_number,
                "message_template_id"	=> $api_whatsapp['template_id'],
                "channel_integration_id"=> $api_whatsapp['channel_id'],
                "language"				=> [
                    "code" => "id"
                ],
                'parameters' => array(
                    'body' => array(
                        array(
                            "key"        => "1",
                            "value_text" => ucwords(strtolower($dt_pasien['nama'])),
                            "value"      => "pasien"
                        ),
                        array(
                            "key"        => "2",
                            "value_text" => ucwords(strtolower($dt_undian[0]['nama'])),
                            "value"      => "cabang"
                        ),
                        array(
                            "key"        => "3",
                            "value_text" => count($groups[$i]),
                            "value"      => "jumlah"
                        ),
                        array(
                            "key"        => "4",
                            "value_text" => $nomor,
                            "value"      => "nomor"
                        ),
                    )
                )
            );
            $data['parameters']['body'] = array_values($data['parameters']['body']);

            $data = json_encode($data);

            $response = $this->post_request($url, $data);
            $response = json_decode($response, true);

            /* cek validasi nomor */
            if($response['status'] == 'success')
            {
                sleep(1);
                $url_log = 'https://service-chat.qontak.com/api/open/v1/broadcasts/'.$response['data']['id'].'/whatsapp/log';
                $response_log = $this->get_request($url_log);
                $response_log = json_decode($response_log, true);

                /* cek log */
                if($response_log['data'][0]['status'] == 'failed')
                {
                    $log = array(
                        'uuid'          => $response['data']['id'],
                        'send_at'       => date('Y-m-d H:i:s'),
                        'pembayaran_id' => $id,
                        'pasien_new_id' => $pasien_new_id,
                        'status'        => $response_log['data'][0]['status'],
                        'message'       => $response_log['data'][0]['whatsapp_error_message'],
                        'toko_id'       => $_SESSION['toko_id']
                    );
                    $this->db->insert('log_whatsapp', $log);
                    $this->session->set_flashdata('error', $response_log['data'][0]['whatsapp_error_message']);
                }else{
                    $log = array(
                        'uuid'          => $response['data']['id'],
                        'send_at'       => date('Y-m-d H:i:s'),
                        'pembayaran_id' => $id,
                        'pasien_new_id' => $pasien_new_id,
                        'status'        => $response['status'],
                        'toko_id'       => $_SESSION['toko_id']
                    );
                    $this->db->insert('log_whatsapp', $log);
                    $this->session->set_flashdata('success', 'Pesan berhasil terkirim!');
                }
            }else{
                $log = array(
                    'send_at'       => date('Y-m-d H:i:s'),
                    'pembayaran_id' => $id,
                    'pasien_new_id' => $pasien_new_id,
                    'status'        => $response['status'],
                    'message'       => $response['error']['messages'][0],
                    'toko_id'       => $_SESSION['toko_id']
                );
                // print_r($log);die;
                $this->db->insert('log_whatsapp', $log);
                $this->session->set_flashdata('error', $response['error']['messages'][0]);
            }

        }
        
        
		redirect($_SERVER['HTTP_REFERER']);
    }

    public function settings()
    {
        $api_whatsapp = $this->db->get('api_whatsapp', 1)->row_array();
        $data['api'] = $api_whatsapp;

        $dataHeader['title']    = 'Setting API Whatsapp';
        $dataHeader['menu']     = 'Setting API Whatsapp';
        $dataHeader['file']     = 'Whatsapp';
        $dataHeader['link']     = 'Api/Whatsapp/settings';

        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('whatsapp/settings', $data);
        $this->load->view('Master/back-end/container/footer');
    }

    public function edit_settings($id)
    {
        $data = array(
            'access_token' => $this->input->post('access_token', true),
            'channel_id' => $this->input->post('channel_id', true),
            'template_id' => $this->input->post('template_id', true),
        );
        $this->db->update('api_whatsapp', $data, ['id' => $id]);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function log_kirim_undian()
    {
        $dataHeader['title']    = 'Status Kirim Undian';
        $dataHeader['menu']     = 'Status Kirim Undian';
        $dataHeader['file']     = 'Whatsapp';
        $dataHeader['link']     = 'Api/Whatsapp/log_kirim_undian';

        $this->load->view('Master/back-end/container/header', $dataHeader);
        $this->load->view('whatsapp/log_kirim_undian');
        $this->load->view('Master/back-end/container/footer');
    }

    public function get_log_kirim_undian()
    {
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->Model->getLogKirimUndian($postData);

        echo json_encode($data);
    }

    public function get_log_wa($uuid)
    {
        $url = 'https://service-chat.qontak.com/api/open/v1/broadcasts/'.$uuid.'/whatsapp/log';
        $response = $this->get_request($url);
        
        echo $response;
    }
    
}
