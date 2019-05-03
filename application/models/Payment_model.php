<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Payment_model extends CI_Model{

    public function get_bank() {
        $this->db->select("*");
        $this->db->from('bank');
        $result = $this->db->get();

        return $result->result_array();
    }

    public function get_bank_name(){
        $result = $this->db->query("SELECT id, bank_name FROM bank")->result_array();
        return $result;
    }

    public function get_check_payment() {
        $this->db->select(  "payment_check_id as ID, project_id as Project ID, 
                            incoming as Ammount, bank_id as Bank ID, employer_id as Emp ID, 
                            agent_id as Agt ID, check_status as Status");
        $this->db->from('check_payment');
        $result = $this->db->get();

        return $result->result_array();
    }

    public function get_check_payment_by_id($id) {
        $this->db->select("*");
        $this->db->from('check_payment');
        $this->db->where('payment_check_id', $id);
        $result = $this->db->get();

        return $result->row_array();
    }

    public function set_check_payment($id, $set) {
        $data = array(
            'check_status' => $set,
        );
        
        $this->db->where('payment_check_id', $id);
        $this->db->update('check_payment', $data);
    }
}