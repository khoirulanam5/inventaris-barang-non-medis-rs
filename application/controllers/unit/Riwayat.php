<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Riwayat extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Riwayat Pesanan Barang';

        $this->db->select('tb_pesanan.*, tb_user.nm_pengguna, tb_barang.nm_barang, tb_unit.nm_unit');
        $this->db->from('tb_pesanan');
        $this->db->join('tb_user', 'tb_pesanan.id_user = tb_user.id_user');
        $this->db->join('tb_barang', 'tb_pesanan.id_barang = tb_barang.id_barang');
        $this->db->join('tb_unit', 'tb_pesanan.id_unit = tb_unit.id_unit');
        $this->db->where('tb_pesanan.status', 'selesai');
        $data['pesanan'] = $this->db->get()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('unit/riwayat', $data);
        $this->load->view('template/footer');
    }
}