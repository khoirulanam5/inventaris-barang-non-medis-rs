<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['PesananModel', 'DistribusiModel']);
        isgudang();
    }

    public function index() {
        $data['title'] = 'Riwayat Data Pemesanan';
        $data['pesanan'] = $this->PesananModel->getAll()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/laporan/pemesanan', $data);
        $this->load->view('template/footer');
    }

    public function cetak_pemesanan() {
        $data['title'] = 'Riwayat Data Pemesanan';
        $data['pesanan'] = $this->PesananModel->getAll()->result();

        $this->load->view('gudang/laporan/cetak_pemesanan', $data);
    }

    public function distribusi() {
        $data['title'] = 'Riwayat Permintaan Barang';
        $data['distribusi'] = $this->DistribusiModel->getAll()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/laporan/distribusi', $data);
        $this->load->view('template/footer');
    }

    public function cetak_distribusi() {
        $data['title'] = 'Riwayat Permintaan Barang';
        $data['distribusi'] = $this->DistribusiModel->getAll()->result();

        $this->load->view('gudang/laporan/cetak_distribusi', $data);
    }
}