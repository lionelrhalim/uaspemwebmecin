<?php

/*
 * Type         = Controller
 * File name    = Menu.php
 * Slug         = admin
 * Description
 *      This controller is for handling user view when
 *      'role_id' = 'Menu'
 *  
*/

defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller {

    // Constructor
    public function __construct() {

        parent::__construct();
        is_logged_in();
    }

    public function index() {
        $data['title'] = "Menu Management";
        $data['user'] = $this->db->get_where( 'user', ['email' => $this->session->userdata('email')] )->row_array();


        $data['menu'] = $this->db->get('user_menu')->result_array();
        
        $this->form_validation->set_rules('menu', 'Menu', 'required');
        if($this->form_validation->run() == false){
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/user_footer', $data);
        } else{
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <small>New Menu Added</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('menu');
        }

        
    }

    //Submenu method
    public function submenu(){
        $data['title'] = "Submenu Management";
        $data['user'] = $this->db->get_where( 'user', ['email' => $this->session->userdata('email')] )->row_array();
        
        $this->load->model('Menu_model', 'menu');

        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'icon', 'required');
       
        if($this->form_validation->run() == false){
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/user_footer', $data);
        }else{
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')

            ];

            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <small>New Sub Menu Added</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('menu/submenu');
        }
    }
}