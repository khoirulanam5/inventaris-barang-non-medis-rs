<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distribusi extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Data Permintaan Barang';

        $this->db->select('tb_distribusi.*, tb_user.nm_pengguna, tb_barang.nm_barang');
        $this->db->from('tb_distribusi');
        $this->db->join('tb_user', 'tb_distribusi.id_user = tb_user.id_user');
        $this->db->join('tb_barang', 'tb_distribusi.id_barang = tb_barang.id_barang');
        $data['distribusi'] = $this->db->get()->result();

        $data['barang'] = $this->db->get('tb_barang')->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/distribusi', $data);
        $this->load->view('template/footer');
    }

    public function generateId() {
        $unik = 'D';
        $kode = $this->db->query("SELECT MAX(id_distribusi) LAST_NO FROM tb_distribusi WHERE id_distribusi LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 1, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function add() {
        $this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
        $this->form_validation->set_rules('jml_distribusi', 'Jumlah Barang', 'required');

        if($this->form_validation->run() == FALSE) {
            redirect('gudang/distribusi');
        } else {
            $data = [
                'id_distribusi' => $this->generateId(),
                'id_user' => $this->session->userdata('id_user'),
                'id_barang' => $this->input->post('id_barang'),
                'tgl_distribusi' => date('Y-m-d'),
                'jml_distribusi' => $this->input->post('jml_distribusi'),
                'status' => 'proses'
            ];

            $this->db->insert('tb_distribusi', $data);

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

            $this->db->where('id_distribusi', $id_distribusi);
            $this->db->update('tb_distribusi', $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Update data berhasil', icon:'success'})</script>");
            redirect('gudang/distribusi');
        }
    }

    public function delete($id_distribusi) {

        $this->db->where('id_distribusi', $id_distribusi);
        $this->db->delete('tb_distribusi');

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Hapus data berhasil', icon:'success'})</script>");
        redirect('gudang/distribusi');
    }

    public function terima($id_distribusi) {
        $this->db->set('status', 'selesai');
        $this->db->where('id_distribusi', $id_distribusi);
        $this->db->update('tb_distribusi');

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Konfirmasi berhasil', icon:'success'})</script>");
        redirect('gudang/distribusi');
    }
}