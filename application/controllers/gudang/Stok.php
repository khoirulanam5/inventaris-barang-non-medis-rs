<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['StokModel', 'BarangModel']);
        isgudang();
    }

    public function index() {
        $data['title'] = 'Data Stok Barang';
        $data['stok'] = $this->StokModel->getAll()->result();
        $data['barang'] = $this->BarangModel->getSelect()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/stok', $data);
        $this->load->view('template/footer');
    }

    public function add() {
        $this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Stok', 'required');

        if($this->form_validation->run() == FALSE) {
            redirect('gudang/stok');
        } else {
            $data = [
                'id_stok' => $this->StokModel->generateId(),
                'id_barang' => $this->input->post('id_barang'),
                'jumlah'=> $this->input->post('jumlah')
            ];
            $this->StokModel->save($data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Tambah data berhasil', icon:'success'})</script>");
            redirect('gudang/stok');
        }
    }

    public function edit($id_stok) {
        $this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Stok', 'required');

        if($this->form_validation->run() == FALSE) {
            redirect('gudang/stok');
        } else {
            $data = [
                'id_barang' => $this->input->post('id_barang'),
                'jumlah'=> $this->input->post('jumlah')
            ];
            $this->StokModel->edit($id_stok, $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Update data berhasil', icon:'success'})</script>");
            redirect('gudang/stok');
        }
    }

    public function delete($id_stok) {
        $this->StokModel->delete($id_stok);

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Hapus data berhasil', icon:'success'})</script>");
        redirect('gudang/stok');
    }
}