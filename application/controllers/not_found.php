<?php

/*
 * Type         = Controller
 * File name    = not_fount.php
 * Slug         = 404
 *  
*/

defined('BASEPATH') or exit('No direct script access allowed');

class not_found extends CI_Controller {

    public function index() {

        $this->load->view('auth/404');

    }
}