<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribusi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Data Permintaan Barang';

        $this->db->select('tb_distribusi.*, tb_user.nm_pengguna, tb_barang.nm_barang');
        $this->db->from('tb_distribusi');
        $this->db->join('tb_user', 'tb_distribusi.id_user = tb_user.id_user');
        $this->db->join('tb_barang', 'tb_distribusi.id_barang = tb_barang.id_barang');
        $data['distribusi'] = $this->db->get()->result();

        $data['barang'] = $this->db->get('tb_barang')->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('pemasok/distribusi', $data);
        $this->load->view('template/footer');
    }

    public function kirim($id_distribusi) {
        // Ambil daftar barang yang dipesan berdasarkan id_pesanan
        $distribusi = $this->db->select('id_barang, jml_distribusi')
                            ->from('tb_distribusi') // Asumsi tabel pesanan
                            ->where('id_distribusi', $id_distribusi)
                            ->get()->result();
    
        foreach ($distribusi as $item) {
            // Ambil stok barang dari tabel tb_stok
            $stok = $this->db->select('jumlah')
                             ->from('tb_stok')
                             ->where('id_barang', $item->id_barang)
                             ->get()->row();
        }
    
        // Jika stok cukup, lanjutkan update stok
        foreach ($distribusi as $item) {
            $this->db->set('jumlah', 'jumlah + ' . (int)$item->jml_distribusi, FALSE);
            $this->db->where('id_barang', $item->id_barang);
            $this->db->update('tb_stok');
        }
    
        // Update status pesanan menjadi 'dikirim'
        $this->db->set('status', 'dikirim');
        $this->db->where('id_distribusi', $id_distribusi);
        $this->db->update('tb_distribusi');
    
        // Notifikasi sukses
        $this->session->set_flashdata("pesan", "<script> Swal.fire({title:'Berhasil', text:'Pesanan barang berhasil dikirim ke staf gudang', icon:'success'})</script>");
        redirect('pemasok/distribusi');
    }
}