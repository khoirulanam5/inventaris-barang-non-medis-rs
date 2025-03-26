<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('landing/header');
        $this->load->view('auth/login');
        $this->load->view('landing/footer');
    }

    public function login() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == false) {
            redirect('auth');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $cek = $this->db->get_where("tb_user", array("username" => $username, "password" => $password))->row();

                if(!empty($cek)) {
                    $ses = [
                        'id_user' => $cek->id_user,
                        'username' => $cek->username,
                        'password' => $cek->password,
                        'level' => $cek->level
                    ];
                    
                    $this->session->set_userdata($ses);

                    if ($cek->level == 'staf gudang') {
                        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Login Berhasil', icon:'success'})</script>");
                        redirect('dashboard');
                    } else if ($cek->level == 'staf unit') {
                        $this->session->set_flashdata("pesan","<script>Swal.fire({title:'Berhasil', text:'Login Berhasil!', icon:'success'})</script>");
                        redirect('dashboard');
                    } else {
                        $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Berhasil', text:'Login Berhasil', icon:'success'})</script>");
                        redirect('dashboard');
                    }
                } else {
                    $this->session->set_flashdata("pesan","<script> Swal.fire({title:'Gagal', text:'username / password salah', icon:'error'})</script>");
                    redirect('auth');
                }
        }   
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth');
    }
}