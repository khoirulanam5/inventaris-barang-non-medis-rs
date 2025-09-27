<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['PesananModel', 'BarangModel', 'UnitModel']);
        isunit();
    }

    public function index() {
        $data['title'] = 'Data Pesanan';
        $data['pesanan'] = $this->PesananModel->getAll()->result();
        $data['barang'] = $this->BarangModel->getSelect()->result();
        $data['unit'] = $this->UnitModel->getAll()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('unit/pesan', $data);
        $this->load->view('template/footer');
    }

    public function add() {
        $this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
        $this->form_validation->set_rules('id_unit', 'ID Unit', 'required');
        $this->form_validation->set_rules('jml_pesan', 'Jumlah Pesan', 'required');

        if($this->form_validation->run() == FALSE) {
            redirect('unit/pesan');
        } else {
            $data = [
                'id_pesanan' => $this->PesananModel->generateId(),
                'id_user' => $this->session->userdata('id_user'),
                'id_barang' => $this->input->post('id_barang'),
                'id_unit' => $this->input->post('id_unit'),
                'tgl_pesanan' => date('Y-m-d'),
                'jml_pesan' => $this->input->post('jml_pesan'),
                'status' => 'proses'
            ];

            $this->db->insert('tb_pesanan', $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Pesanan barang ke gudang berhasil', icon:'success'})</script>");
            redirect('unit/pesan');
        }
    }

    public function edit($id_pesanan) {
        $this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
        $this->form_validation->set_rules('id_unit', 'ID Unit', 'required');
        $this->form_validation->set_rules('jml_pesan', 'Jumlah Pesan', 'required');

        if($this->form_validation->run() == FALSE) {
            redirect('unit/pesan');
        } else {
            $data = [
                'id_user' => $this->session->userdata('id_user'),
                'id_barang' => $this->input->post('id_barang'),
                'id_unit' => $this->input->post('id_unit'),
                'tgl_pesanan' => date('Y-m-d'),
                'jml_pesan' => $this->input->post('jml_pesan'),
                'status' => 'proses'
            ];
            $this->PesananModel->edit($id_pesanan, $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Update data berhasil', icon:'success'})</script>");
            redirect('unit/pesan');
        }
    }

    public function delete($id_pesanan) {
        $this->PesananModel->delete($id_pesanan);

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Hapus data berhasil', icon:'success'})</script>");
        redirect('unit/pesan');
    }

    public function terima($id_pesanan) {
        $this->PesananModel->clear($id_pesanan);

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Konfirmasi berhasil', icon:'success'})</script>");
        redirect('unit/pesan');
    }
}