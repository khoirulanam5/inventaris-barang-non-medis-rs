<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribusi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['DistribusiModel', 'BarangModel']);
        isgudang();
    }

    public function index() {
        $data['title'] = 'Data Permintaan Barang';
        $data['distribusi'] = $this->DistribusiModel->getAll()->result();
        $data['barang'] = $this->BarangModel->getSelect()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/distribusi', $data);
        $this->load->view('template/footer');
    }

    public function add() {
        $this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
        $this->form_validation->set_rules('jml_distribusi', 'Jumlah Barang', 'required');

        if($this->form_validation->run() == FALSE) {
            redirect('gudang/distribusi');
        } else {
            $data = [
                'id_distribusi' => $this->DistribusiModel->generateId(),
                'id_user' => $this->session->userdata('id_user'),
                'id_barang' => $this->input->post('id_barang'),
                'tgl_distribusi' => date('Y-m-d'),
                'jml_distribusi' => $this->input->post('jml_distribusi'),
                'status' => 'proses'
            ];
            $this->DistribusiModel->save($data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Pesanan barang ke pemasok berhasil', icon:'success'})</script>");
            redirect('gudang/distribusi');
        }
    }

    public function edit($id_distribusi) {
        $this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
        $this->form_validation->set_rules('jml_distribusi', 'Jumlah Barang', 'required');

        if($this->form_validation->run() == FALSE) {
            redirect('gudang/distribusi');
        } else {
            $data = [
                'id_user' => $this->session->userdata('id_user'),
                'id_barang' => $this->input->post('id_barang'),
                'tgl_distribusi' => date('Y-m-d'),
                'jml_distribusi' => $this->input->post('jml_distribusi'),
                'status' => 'proses'
            ];
            $this->DistribusiModel->edit($id_distribusi, $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Update data berhasil', icon:'success'})</script>");
            redirect('gudang/distribusi');
        }
    }

    public function delete($id_distribusi) {
        $this->DistribusiModel->delete($id_distribusi);

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Hapus data berhasil', icon:'success'})</script>");
        redirect('gudang/distribusi');
    }

    public function terima($id_distribusi) {
        $this->DistribusiModel->acc($id_distribusi);

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Konfirmasi berhasil', icon:'success'})</script>");
        redirect('gudang/distribusi');
    }
}