<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoginController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function login()
    {
        $this->load->view('login');
    }

    public function login_submit()
    {
        $this->load->model('Auth');
        
        $username = $this->input->Post('username');
        $password = $this->input->Post('password');
        $login = $this->Auth->login($username, $password);

        if($login)
        {
            $this->session->set_userdata('logged_in', true);
            $this->session->set_userdata('logged_out', false);
            $this->session->set_userdata('name', $login["username"]);
            $this->session->set_userdata('id', $login["id"]);
            redirect('dashboard');
        }
        else
        {
            $this->session->set_userdata('logged_in', false);
            $this->session->set_userdata('logged_out', false);
            redirect('login');
        }

    }

    public function logout() {

        $this->session->set_userdata('logged_in', false);
        $this->session->set_userdata('logged_out', true);

        // Disable caching
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header('Expires: 0'); 

        redirect('login');
    }

    public function set_first_time()
    {        
        $user = $this->Auth->get_user_by_username($this->session->userdata('name'));
        $where = array("id" => $user["id"]);

        $this->Auth->set_first_time($where);

        redirect('dashboard');

    }
}
?>