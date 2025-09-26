<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['BarangModel', 'KategoriModel']);
        isgudang();
    }

    public function index() {
        $data['title'] = 'Data Barang';
        $data['barang'] = $this->BarangModel->getAll()->result();
        $data['kategori'] = $this->KategoriModel->getAll()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/barang', $data);
        $this->load->view('template/footer');
    }

    public function add() {
        $this->form_validation->set_rules('id_kategori', 'ID Kategori', 'required');
        $this->form_validation->set_rules('nm_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'Required');

        if($this->form_validation->run() == FALSE) {
            redirect('gudang/barang');
        } else {
            // Konfigurasi upload
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/barang/';
            $this->load->library('upload', $config);
            $this->upload->do_upload('foto');
            $image = $this->upload->data('file_name');

            $data = [
                'id_barang' => $this->BarangModel->generateId(),
                'id_kategori' => $this->input->post('id_kategori'),
                'nm_barang' => $this->input->post('nm_barang'),
                'satuan' => $this->input->post('satuan'),
                'foto' => $image,
                'status' => '1'
            ];
            $this->BarangModel->save($data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Tambah data berhasil', icon:'success'})</script>");
            redirect('gudang/barang');
        }
    }

    public function edit($id_barang) {
        $this->form_validation->set_rules('id_kategori', 'ID Kategori', 'required');
        $this->form_validation->set_rules('nm_barang', 'Nama Barang', 'required');
        $this->form_validation->set_rules('satuan', 'Satuan', 'Required');

        if($this->form_validation->run() == FALSE) {
            redirect('gudang/barang');
        } else {
            // Konfigurasi upload
            $config['allowed_types'] = 'jpg|png|jpeg';
            $config['max_size'] = '2048';
            $config['upload_path'] = './assets/barang/';
            $this->load->library('upload', $config);
            $this->upload->do_upload('foto');
            $image = $this->upload->data('file_name');

            $data = [
                'id_kategori' => $this->input->post('id_kategori'),
                'nm_barang' => $this->input->post('nm_barang'),
                'satuan' => $this->input->post('satuan'),
                'foto' => $image,
                'status' => '1'
            ];
            $this->BarangModel->edit($id_barang, $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Tambah data berhasil', icon:'success'})</script>");
            redirect('gudang/barang');
        }
    }

    public function delete($id_barang) {
        $this->BarangModel->delete($id_barang);

        $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data berhasil dihapus', icon:'success'})</script>");
        redirect('gudang/barang');
    }
}