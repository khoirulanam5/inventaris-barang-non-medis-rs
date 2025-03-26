<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Riwayat Data Pemesanan';

        $this->db->select('tb_pesanan.*, tb_user.nm_pengguna, tb_barang.nm_barang, tb_unit.nm_unit');
        $this->db->from('tb_pesanan');
        $this->db->join('tb_user', 'tb_pesanan.id_user = tb_user.id_user');
        $this->db->join('tb_barang', 'tb_pesanan.id_barang = tb_barang.id_barang');
        $this->db->join('tb_unit', 'tb_pesanan.id_unit = tb_unit.id_unit');
        $data['pesanan'] = $this->db->get()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/laporan/pemesanan', $data);
        $this->load->view('template/footer');
    }

    public function cetak_pemesanan() {
        $data['title'] = 'Riwayat Data Pemesanan';

        $this->db->select('tb_pesanan.*, tb_user.nm_pengguna, tb_barang.nm_barang, tb_unit.nm_unit');
        $this->db->from('tb_pesanan');
        $this->db->join('tb_user', 'tb_pesanan.id_user = tb_user.id_user');
        $this->db->join('tb_barang', 'tb_pesanan.id_barang = tb_barang.id_barang');
        $this->db->join('tb_unit', 'tb_pesanan.id_unit = tb_unit.id_unit');
        $data['pesanan'] = $this->db->get()->result();

        $this->load->view('gudang/laporan/cetak_pemesanan', $data);
    }

    public function distribusi() {
        $data['title'] = 'Riwayat Permintaan Barang';

        $this->db->select('tb_distribusi.*, tb_user.nm_pengguna, tb_barang.nm_barang');
        $this->db->from('tb_distribusi');
        $this->db->join('tb_user', 'tb_distribusi.id_user = tb_user.id_user');
        $this->db->join('tb_barang', 'tb_distribusi.id_barang = tb_barang.id_barang');
        $data['distribusi'] = $this->db->get()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/laporan/distribusi', $data);
        $this->load->view('template/footer');
    }

    public function cetak_distribusi() {
        $data['title'] = 'Riwayat Permintaan Barang';

        $this->db->select('tb_distribusi.*, tb_user.nm_pengguna, tb_barang.nm_barang');
        $this->db->from('tb_distribusi');
        $this->db->join('tb_user', 'tb_distribusi.id_user = tb_user.id_user');
        $this->db->join('tb_barang', 'tb_distribusi.id_barang = tb_barang.id_barang');
        $data['distribusi'] = $this->db->get()->result();

        $this->load->view('gudang/laporan/cetak_distribusi', $data);
    }
}