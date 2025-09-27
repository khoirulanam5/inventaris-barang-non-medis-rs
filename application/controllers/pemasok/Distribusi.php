<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribusi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['DistribusiModel', 'BarangModel', 'StokModel']);
        ispemasok();
    }

    public function index() {
        $data['title'] = 'Data Permintaan Barang';
        $data['distribusi'] = $this->DistribusiModel->getAll()->result();
        $data['barang'] = $this->BarangModel->getSelect()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('pemasok/distribusi', $data);
        $this->load->view('template/footer');
    }

    public function kirim($id_distribusi) {
        // Ambil daftar barang yang dipesan berdasarkan id_pesanan
        $distribusi = $this->DistribusiModel->getBarang($id_distribusi)->result();
    
        foreach ($distribusi as $item) {
            // Ambil stok barang dari tabel tb_stok
            $stok = $this->StokModel->getJumlah($item->id_barang)->row();
        }
    
        // Jika stok cukup, lanjutkan update stok
        foreach ($distribusi as $item) {
            $this->StokModel->up($item);
        }
    
        // Update status pesanan menjadi 'dikirim'
        $this->DistribusiModel->update($id_distribusi);
        // Notifikasi sukses
        $this->session->set_flashdata("pesan", "<script> Swal.fire({title:'Berhasil', text:'Pesanan barang berhasil dikirim ke staf gudang', icon:'success'})</script>");
        redirect('pemasok/distribusi');
    }
}