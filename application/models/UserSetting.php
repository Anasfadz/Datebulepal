<?php
class UserSetting extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function new_data($data) {
        return $this->db->insert('user_setting', $data);
    }

    public function get_user_by_id($user_id) {
        $query = $this->db->get_where('user_setting', array('user_id' => $user_id));
        return $query->row_array();
    }

    public function update($data, $where) {
        $query = $this->db->update('user_setting', $data, $where);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

}
?>