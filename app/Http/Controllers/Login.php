<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
// Code by: Ade Yudha Pratama
    class Login extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->model('auth_model');
        }
        public function index() {
            if($this->session->userdata('logged_in')) {
                redirect(base_url(), 'refresh'); // homepage representation
            } else {
                $this->load->view('login');
            }
        }
        public function login_process() {
            $username = $this->input->post('username');
            $password = md5($this->input->post('password'));
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if($this->form_validation->run() == true) {
                $this->load->model('auth_model', '', true);
                $login = $this->auth_model->login_check($username, $password);
                if($login) {
                    foreach($login as $l) {
                        $l_username = $l['username'];
                        $l_role = $l['role'];
                    }
                    $login_data = array(
                        'username' => $l_username,
                        'role' => $l_role,
                        'logged_in' => true
                    );
                    $this->session->set_userdata($login_data);
                    redirect(base_url(), 'refresh');
                } else {
                    $this->session->set_flashdata('msg_incorrect', 'Username atau Password  salah');
                    redirect(base_url().'login', 'refresh');
                }
            } else {
                $this->session->set_flashdata('msg_empty', 'Masukkan Username & Password!');
                redirect(base_url().'login', 'refresh');
            }
        }
    }
?>