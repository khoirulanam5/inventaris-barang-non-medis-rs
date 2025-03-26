<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Data Barang';

        $this->db->select('tb_barang.*, tb_kategori.*');
        $this->db->from('tb_barang');
        $this->db->join('tb_kategori', 'tb_barang.id_kategori = tb_kategori.id_kategori');
        $data['barang'] = $this->db->get()->result();

        $data['kategori'] = $this->db->get('tb_kategori')->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/barang', $data);
        $this->load->view('template/footer');
    }

    public function generateId(){
        $unik = 'B';
        $kode = $this->db->query("SELECT MAX(id_barang) LAST_NO FROM tb_barang WHERE id_barang LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 1, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
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
                'id_barang' => $this->generateId(),
                'id_kategori' => $this->input->post('id_kategori'),
                'nm_barang' => $this->input->post('nm_barang'),
                'satuan' => $this->input->post('satuan'),
                'foto' => $image,
                'status' => '1'
            ];

            $this->db->insert('tb_barang', $data);

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

            $this->db->where('id_barang', $id_barang);
            $this->db->update('tb_barang', $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Tambah data berhasil', icon:'success'})</script>");
            redirect('gudang/barang');
        }
    }

    public function delete($id_barang) {

        $this->db->where('id_barang', $id_barang);
        $this->db->delete('tb_barang');

        $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data berhasil dihapus', icon:'success'})</script>");
        redirect('gudang/barang');
    }
}