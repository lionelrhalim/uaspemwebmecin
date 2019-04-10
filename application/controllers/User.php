<?php

/*
 * Type         = Controller
 * File name    = User.php
 * Slug         = user
 * Description
 *      This controller is for handling user view when
 *      'role_id' = 'member'
 *  
*/

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller {

    public function index() {

        $data['title'] = "My Profile | MECIN.co";
        $data['user'] = $this->db->get_where( 'user', ['email' => $this->session->userdata('email')] )->row_array();
        
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/user_footer', $data);
    }

}