<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['PesananModel', 'StokModel']);
        isgudang();
    }

    public function index() {
        $data['title'] = 'Data Pesanan';
        $data['pesanan'] = $this->PesananModel->getAll()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/pesan', $data);
        $this->load->view('template/footer');
    }

    public function kirim($id_pesanan) {
        // Ambil daftar barang yang dipesan berdasarkan id_pesanan
        $pesanan = $this->PesananModel->getBarang($id_pesanan)->result();
    
        foreach ($pesanan as $item) {
            // Ambil stok barang dari tabel tb_stok
            $stok = $this->StokModel->getJumlah($item->id_barang)->row();
    
            // Cek jika stok kurang dari jumlah pesanan
            if ($stok && $stok->jumlah < $item->jml_pesan) {
                $this->session->set_flashdata("pesan", "<script> Swal.fire({title:'Gagal', text:'Stok barang tidak mencukupi!', icon:'error'})</script>");
                redirect('gudang/pesan');
                return; // Hentikan proses agar tidak lanjut update
            }
        }
    
        // Jika stok cukup, lanjutkan update stok
        foreach ($pesanan as $item) {
            $this->StokModel->down($item);
        }
    
        // Update status pesanan menjadi 'dikirim'
        $this->PesananModel->update($id_pesanan);
    
        // Notifikasi sukses
        $this->session->set_flashdata("pesan", "<script> Swal.fire({title:'Berhasil', text:'Pesanan barang berhasil dikirim ke unit', icon:'success'})</script>");
        redirect('gudang/pesan');
    }        
}