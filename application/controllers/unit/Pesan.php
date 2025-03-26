<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesan extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Data Pesanan';

        $this->db->select('tb_pesanan.*, tb_user.nm_pengguna, tb_barang.nm_barang, tb_unit.nm_unit');
        $this->db->from('tb_pesanan');
        $this->db->join('tb_user', 'tb_pesanan.id_user = tb_user.id_user');
        $this->db->join('tb_barang', 'tb_pesanan.id_barang = tb_barang.id_barang');
        $this->db->join('tb_unit', 'tb_pesanan.id_unit = tb_unit.id_unit');
        $data['pesanan'] = $this->db->get()->result();

        $data['barang'] = $this->db->get('tb_barang')->result();
        
        $data['unit'] = $this->db->get('tb_unit')->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('unit/pesan', $data);
        $this->load->view('template/footer');
    }

    public function generateId() {
        $unik = 'P';
        $kode = $this->db->query("SELECT MAX(id_pesanan) LAST_NO FROM tb_pesanan WHERE id_pesanan LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 1, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function add() {
        $this->form_validation->set_rules('id_barang', 'ID Barang', 'required');
        $this->form_validation->set_rules('id_unit', 'ID Unit', 'required');
        $this->form_validation->set_rules('jml_pesan', 'Jumlah Pesan', 'required');

        if($this->form_validation->run() == FALSE) {
            redirect('unit/pesan');
        } else {
            $data = [
                'id_pesanan' => $this->generateId(),
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

            $this->db->where('id_pesanan', $id_pesanan);
            $this->db->update('tb_pesanan', $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Update data berhasil', icon:'success'})</script>");
            redirect('unit/pesan');
        }
    }

    public function delete($id_pesanan) {

        $this->db->where('id_pesanan', $id_pesanan);
        $this->db->delete('tb_pesanan');

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Hapus data berhasil', icon:'success'})</script>");
        redirect('unit/pesan');
    }

    public function terima($id_pesanan) {
        $this->db->set('status', 'selesai');
        $this->db->where('id_pesanan', $id_pesanan);
        $this->db->update('tb_pesanan');

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Konfirmasi berhasil', icon:'success'})</script>");
        redirect('unit/pesan');
    }
}