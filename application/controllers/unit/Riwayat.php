<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['PesananModel']);
        isunit();
    }

    public function index() {
        $data['title'] = 'Riwayat Pesanan Barang';
        $data['pesanan'] = $this->PesananModel->getHistory()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('unit/riwayat', $data);
        $this->load->view('template/footer');
    }
}