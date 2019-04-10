<?php

/*
 * Type         = Controller
 * File name    = Auth.php
 * Slug         = auth
 * Description
 *      This controller is for handling user registration,
 *      login and logout 
 *  
*/

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller {

    // Constructor
    public function __construct() {

        parent::__construct();
        $this->load->library('form_validation');    // Load 'form_validation'
    }



    // Default method
    public function index() {
        
        // Set rules for 'form_validation'
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        
        // If 'form_validation' failed
        if( $this->form_validation->run() == false ){

            $data['title'] = 'Login | MECIN.co';
    
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {

            $this->_login(); // Else success, call _login() function
        }
    }

    // Private _login() function
    private function _login() {

        // Retreive form input
        $email = htmlspecialchars($this->input->post('email', true));
        $password = $this->input->post('password', true);

        // Query to database
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        // If $user exist
        if($user){

            // If $user is active
            if( $user['is_active'] == 1 ) {
                // If password_verify is true
                if( password_verify($password, $user['password']) ) {

                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];

                    // Open session
                    $this->session->set_userdata($data);

                    // Redirect to view based on role_id
                    if( $user['role_id'] == 1 ){
                        redirect('admin');
                    }
                    else {
                        redirect('user');
                    }
                } else {

                    // ELse wrong password
                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <small>Wrong email or password</small>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>'
                    );
                    redirect('auth');
                }


            } else {

                // Else $user is not active
                $this->session->set_flashdata(
                    'message',
                    '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <small>Please activate your account</small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                );
                redirect('auth');
            }
        } else {

            // Else wrong email
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <small>Wrong email or password</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('auth');
        }
    }
    


    // Registration method
    public function registration() {

        // Set rules for 'form_validation'
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => "Password doesn't match",
            'min_length' => "Password must be 8 charactes long"
        ]);
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|min_length[8]|matches[password1]');

        // If 'form_validation' failed
        if( $this->form_validation->run() == false ){

            $data['title'] = 'Registration | MECIN.co';
    
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {

            // Else retreive form input
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'image' => 'default.jpg',
                'password' => password_hash( $this->input->post('password1'), PASSWORD_DEFAULT ),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];

            // Query to database
            $this->db->insert('user', $data);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <small>Your account has been created!</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('auth');
        }
    }



    // Logout method
    public function logout() {

        // Unset session
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata(
            'message',
            '<div class="alert alert-success alert-dismissible fade show" role="alert">
                <small>You have been logout</small>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>'
        );
        redirect('auth');
    }
}