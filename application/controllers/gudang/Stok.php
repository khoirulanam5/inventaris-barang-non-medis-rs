<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Data Stok Barang';

        $this->db->select('tb_stok.*, tb_barang.*');
        $this->db->from('tb_stok');
        $this->db->join('tb_barang', 'tb_stok.id_barang = tb_barang.id_barang');
        $data['stok'] = $this->db->get()->result();

        $data['barang'] = $this->db->get('tb_barang')->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/stok', $data);
        $this->load->view('template/footer');
    }

    public function generateId(){
        $unik = 'S';
        $kode = $this->db->query("SELECT MAX(id_stok) LAST_NO FROM tb_stok WHERE id_stok LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 1, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function add() {
        $this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
        $this->form_validation->set_rules('jumlah', 'Jumlah Stok', 'required');

        if($this->form_validation->run() == FALSE) {
            redirect('gudang/stok');
        } else {
            $data = [
                'id_stok' => $this->generateId(),
                'id_barang' => $this->input->post('id_barang'),
                'jumlah'=> $this->input->post('jumlah')
            ];

            $this->db->insert('tb_stok', $data);

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

            $this->db->where('id_stok', $id_stok);
            $this->db->update('tb_stok', $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Update data berhasil', icon:'success'})</script>");
            redirect('gudang/stok');
        }
    }

    public function delete($id_stok) {
        $this->db->where('id_stok', $id_stok);
        $this->db->delete('tb_stok');

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Hapus data berhasil', icon:'success'})</script>");
        redirect('gudang/stok');
    }
}