<?php

/*
 * Type         = Controller
 * File name    = Admin.php
 * Slug         = admin
 * Description
 *      This controller is for handling user view when
 *      'role_id' = 'administrator'
 *  
*/

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function index() {

        $data['title'] = "Dashboard | MECIN.co";
        $data['user'] = $this->db->get_where( 'user', ['email' => $this->session->userdata('email')] )->row_array();
        
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/user_footer', $data);
    }

}