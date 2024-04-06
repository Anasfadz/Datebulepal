<?php
class Auth extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function register($data) {
        return $this->db->insert('user', $data);
    }

    public function login($username, $password) {
        $query = $this->db->get_where('user', array('username' => $username, 'password' => $password));
        return $query->row_array();
    }

    public function get_user_by_username($username) {
        $query = $this->db->get_where('user', array('username' => $username));
        return $query->row_array();
    }

    public function get_all_user() {
        $query = $this->db->get('user');
        return $query->result();
    }

    public function reset_first_time($where) {
        $data = array("first_time" => 0);
        $query = $this->db->update('user', $data, $where);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function set_first_time($where) {
        $data = array("first_time" => 1);
        $query = $this->db->update('user', $data, $where);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

}
?>