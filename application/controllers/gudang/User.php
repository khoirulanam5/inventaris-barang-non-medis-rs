<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['title'] = 'Data User';

        $data['user'] = $this->db->get('tb_user')->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/user', $data);
        $this->load->view('template/footer');
    }

    public function generateIdUser(){
        $unik = 'U';
        $kode = $this->db->query("SELECT MAX(id_user) LAST_NO FROM tb_user WHERE id_user LIKE '".$unik."%'")->row()->LAST_NO;
        $urutan = (int) substr($kode, 1, 3);
        $urutan++;
        $huruf = $unik;
        $kode = $huruf . sprintf("%03s", $urutan);
        return $kode;
    }

    public function add() {
        $this->form_validation->set_rules('nm_pengguna', 'Nama Pengguna', 'required');
        $this->form_validation->set_rules('no_hp', 'Nomer Handpone', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[tb_user.username]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('level', 'Level', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Maaf', text:'Username Sudah Digunakan', icon:'warning'})</script>");
            redirect('gudang/user');
        } else {
            $user = [
                'id_user' => $this->generateIdUser(),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'level' => $this->input->post('level'),
                'nm_pengguna' => $this->input->post('nm_pengguna'),
                'email' => $this->input->post('email'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat'),
                'status' => '1'
            ];

            $this->db->insert('tb_user', $user);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Tambah data berhasil', icon:'success'})</script>");
            redirect('gudang/user');
        }
    }

    public function edit($id_user) {
        $this->form_validation->set_rules('nm_pengguna', 'Nama Pengguna', 'required');
        $this->form_validation->set_rules('no_hp', 'Nomer Handpone', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('level', 'Level', 'required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');

        if($this->form_validation->run() == FALSE) {
            redirect('gudang/user');
        } else {
            $user = [
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'level' => $this->input->post('level'),
                'nm_pengguna' => $this->input->post('nm_pengguna'),
                'email' => $this->input->post('email'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat'),
                'status' => '1'
            ];

            $this->db->where('id_user', $id_user);
            $this->db->update('tb_user', $user);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Update data berhasil', icon:'success'})</script>");
            redirect('gudang/user');
        }
    }

    public function delete($id_user) {

        $this->db->where('id_user', $id_user);
        $this->db->delete('tb_user');
    
        $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data berhasil dihapus', icon:'success'})</script>");
        redirect('gudang/user');
    }

    public function aktivasi($id_user) {

        $this->db->set('status', '1');
        $this->db->where('id_user', $id_user);
        $this->db->update('tb_user');

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Aktivasi berhasil', icon:'success'})</script>");
        redirect('gudang/user');
    }    

    public function nonaktivasi($id_user) {

        $this->db->set('status', '0');
        $this->db->where('id_user', $id_user);
        $this->db->update('tb_user');

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Akun berhasil dinonaktifkan', icon:'success'})</script>");
        redirect('gudang/user');
    }    
}