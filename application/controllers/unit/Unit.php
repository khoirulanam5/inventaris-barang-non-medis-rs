<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Data Unit';

        $data['unit'] = $this->db->get('tb_unit')->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('unit/unit', $data);
        $this->load->view('template/footer');
    }

    public function generateId(){
        $unik = 'UNIT';
        $kode = $this->db->query("SELECT MAX(id_unit) LAST_NO FROM tb_unit WHERE id_unit LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 4, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function add() {
        $this->form_validation->set_rules('nm_unit', 'Nama Unit', 'required|is_unique[tb_unit.nm_unit]');

        if($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Maaf', text:'Nama Unit Sudah Ada', icon:'warning'})</script>");
            redirect('unit/unit');
        } else {
            $data = [
                'id_unit' => $this->generateId(),
                'nm_unit' => $this->input->post('nm_unit')
            ];

            $this->db->insert('tb_unit', $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Tambah data berhasil', icon:'success'})</script>");
            redirect('unit/unit');
        }
    }

    public function edit($id_unit) {
        $this->form_validation->set_rules('nm_unit', 'Nama Unit', 'required');

        if($this->form_validation->run() == FALSE) {
            redirect('unit/unit');
        } else {
            $data = [
                'nm_unit' => $this->input->post('nm_unit')
            ];

            $this->db->where('id_unit', $id_unit);
            $this->db->update('tb_unit', $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Update data berhasil', icon:'success'})</script>");
            redirect('unit/unit');
        }
    }

    public function delete($id_unit) {

        $this->db->where('id_unit', $id_unit);
        $this->db->delete('tb_unit');
    
        $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data berhasil dihapus', icon:'success'})</script>");
        redirect('unit/unit');
    }
}