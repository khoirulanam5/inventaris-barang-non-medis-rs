<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Data Pesanan';

        $this->db->select('tb_pesanan.*, tb_user.nm_pengguna, tb_barang.nm_barang, tb_unit.nm_unit');
        $this->db->from('tb_pesanan');
        $this->db->join('tb_user', 'tb_pesanan.id_user = tb_user.id_user');
        $this->db->join('tb_barang', 'tb_pesanan.id_barang = tb_barang.id_barang');
        $this->db->join('tb_unit', 'tb_pesanan.id_unit = tb_unit.id_unit');
        $data['pesanan'] = $this->db->get()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/pesan', $data);
        $this->load->view('template/footer');
    }

    public function kirim($id_pesanan) {
        // Ambil daftar barang yang dipesan berdasarkan id_pesanan
        $pesanan = $this->db->select('id_barang, jml_pesan')
                            ->from('tb_pesanan') // Asumsi tabel pesanan
                            ->where('id_pesanan', $id_pesanan)
                            ->get()->result();
    
        foreach ($pesanan as $item) {
            // Ambil stok barang dari tabel tb_stok
            $stok = $this->db->select('jumlah')
                             ->from('tb_stok')
                             ->where('id_barang', $item->id_barang)
                             ->get()->row();
    
            // Cek jika stok kurang dari jumlah pesanan
            if ($stok && $stok->jumlah < $item->jml_pesan) {
                $this->session->set_flashdata("pesan", "<script> Swal.fire({title:'Gagal', text:'Stok barang tidak mencukupi!', icon:'error'})</script>");
                redirect('gudang/pesan');
                return; // Hentikan proses agar tidak lanjut update
            }
        }
    
        // Jika stok cukup, lanjutkan update stok
        foreach ($pesanan as $item) {
            $this->db->set('jumlah', 'jumlah - ' . (int)$item->jml_pesan, FALSE);
            $this->db->where('id_barang', $item->id_barang);
            $this->db->update('tb_stok');
        }
    
        // Update status pesanan menjadi 'dikirim'
        $this->db->set('status', 'dikirim');
        $this->db->where('id_pesanan', $id_pesanan);
        $this->db->update('tb_pesanan');
    
        // Notifikasi sukses
        $this->session->set_flashdata("pesan", "<script> Swal.fire({title:'Berhasil', text:'Pesanan barang berhasil dikirim ke unit', icon:'success'})</script>");
        redirect('gudang/pesan');
    }        
}