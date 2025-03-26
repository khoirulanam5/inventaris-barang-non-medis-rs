<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Data Kategori Barang';

        $data['kategori'] = $this->db->get('tb_kategori')->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/kategori', $data);
        $this->load->view('template/footer');
    }

    public function generateId(){
        $unik = 'K';
        $kode = $this->db->query("SELECT MAX(id_kategori) LAST_NO FROM tb_kategori WHERE id_kategori LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 1, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function add() {
        $this->form_validation->set_rules('nm_kategori', 'Nama Kategori', 'required|is_unique[tb_kategori.nm_kategori]');

        if($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Maaf', text:'Nama Kategori Sudah Ada', icon:'warning'})</script>");
            redirect('gudang/kategori');
        } else {
            $data = [
                'id_kategori' => $this->generateId(),
                'nm_kategori' => $this->input->post('nm_kategori')
            ];

            $this->db->insert('tb_kategori', $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Tambah data berhasil', icon:'success'})</script>");
            redirect('gudang/kategori');
        }
    }

    public function edit($id_kategori) {
        $this->form_validation->set_rules('nm_kategori', 'Nama Kategori', 'required');

        if($this->form_validation->run() == FALSE) {
            redirect('gudang/kategori');
        } else {
            $data = [
                'nm_kategori' => $this->input->post('nm_kategori')
            ];

            $this->db->where('id_kategori', $id_kategori);
            $this->db->update('tb_kategori', $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Update data berhasil', icon:'success'})</script>");
            redirect('gudang/kategori');
        }
    }

    public function delete($id_kategori) {

        $this->db->where('id_kategori', $id_kategori);
        $this->db->delete('tb_kategori');
    
        $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data berhasil dihapus', icon:'success'})</script>");
        redirect('gudang/kategori');
    }
}