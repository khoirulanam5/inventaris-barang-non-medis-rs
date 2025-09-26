<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model(['UserModel']);
        isgudang();
    }

    public function index() {
        $data['title'] = 'Data User';
        $data['user'] = $this->UserModel->getAll()->result();

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('gudang/user', $data);
        $this->load->view('template/footer');
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
            $data = [
                'id_user' => $this->UserModel->generateId(),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'level' => $this->input->post('level'),
                'nm_pengguna' => $this->input->post('nm_pengguna'),
                'email' => $this->input->post('email'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat'),
                'status' => '1'
            ];
            $this->UserModel->save($data);

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
            $data = [
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'level' => $this->input->post('level'),
                'nm_pengguna' => $this->input->post('nm_pengguna'),
                'email' => $this->input->post('email'),
                'no_hp' => $this->input->post('no_hp'),
                'alamat' => $this->input->post('alamat'),
                'status' => '1'
            ];
            $this->UserModel->edit($id_user, $data);

            $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Update data berhasil', icon:'success'})</script>");
            redirect('gudang/user');
        }
    }

    public function delete($id_user) {
        $this->UserModel->delete($id_user);
    
        $this->session->set_flashdata("pesan", "<script>Swal.fire({title:'Berhasil', text:'Data berhasil dihapus', icon:'success'})</script>");
        redirect('gudang/user');
    }

    public function aktivasi($id_user) {
        $this->UserModel->active($id_user);

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Aktivasi berhasil', icon:'success'})</script>");
        redirect('gudang/user');
    }    

    public function nonaktivasi($id_user) {
        $this->UserModel->nonactive($id_user);

        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Akun berhasil dinonaktifkan', icon:'success'})</script>");
        redirect('gudang/user');
    }    
}