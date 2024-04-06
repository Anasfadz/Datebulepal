<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DashboardController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Auth');
        $this->load->model('UserSetting');
        $this->load->library('session');
        $this->load->helper('url');
    }

	public function index()
	{
        if(count($this->session->userdata()) <= 1 || $this->session->userdata('logged_in') == FALSE)
        {
            redirect('login');
        }

        $currentTimestamp = time();
        // $gmtOffset = 6 * 3600;
        // $adjustedTimestamp = $currentTimestamp + $gmtOffset;
        // $date = date('Y-m-d H:i:s', $adjustedTimestamp);
        $adjustedTimestamp = $currentTimestamp;
        $date = date('Y-m-d', $adjustedTimestamp);

        $user = $this->Auth->get_user_by_username($this->session->userdata('name'));
        $user_setting = $this->UserSetting->get_user_by_id($user["id"]);

        $data = array('user' => $user, 'user_setting' => $user_setting, 'date' => $date);


		$this->load->view('dashboard_old', $data);
	}

    public function user_setting()
    {
        $user_id = $this->input->post('user_id');
        $last_period = $this->input->post('last_period');
        $last_period = date("Y-m-d", strtotime($last_period));
        $day_last = $this->input->post('day_last');
        $day_length = $this->input->post('day_length');

        $data = array("user_id" => $user_id, "last_period" => 
        $last_period, "day_last" => $day_last, "day_length" => $day_length);

        $validation = $this->UserSetting->get_user_by_id($user_id);

        if($validation)
        {
            $where = array("id" => $user_id);
            $this->Auth->reset_first_time($where);
            $where = array("user_id" => $user_id);
            $validation = $this->UserSetting->update($data, $where);

            redirect('dashboard');
        }
        else
        {
            $where = array("id" => $user_id);
            $this->Auth->reset_first_time($where);
            $validation = $this->UserSetting->new_data($data);

            redirect('dashboard');

        }
    }
}
