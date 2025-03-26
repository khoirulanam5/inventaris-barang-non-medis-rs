<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Halaman Dashboard';

        $data['user'] = count($this->db->get('tb_user')->result());
        $data['distribusi'] = count($this->db->get('tb_distribusi')->result());
        $data['barang'] = count($this->db->get('tb_barang')->result());
        $data['pesanan'] = count($this->db->get('tb_pesanan')->result());

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('dashboard', $data);
        $this->load->view('template/footer');
    }
}