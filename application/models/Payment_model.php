<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Payment_model extends CI_Model{

    public function get_bank() {
        $this->db->select("*");
        $this->db->from('bank');
        $result = $this->db->get();

        return $result->result_array();
    }
}