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

    // Constructor
    public function __construct() {

        parent::__construct();
        is_logged_in();
    }

    public function index() {
        $data['title'] = "My Profile";
        $data['user'] = $this->db->get_where( 'user', ['email' => $this->session->userdata('email')] )->row_array();
        
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/user_footer', $data);
    }

    //Edit method
    public function edit(){
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/user_footer', $data);
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            // cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                //hanya bisa upload gambar sesuai dengan ketentuan dibawah ini
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048'; //2MB
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        //untuk menghapus image lama yang sudah tidak terpakai selain default.jpg
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    //set untuk dimasukan ke db new_imagenya
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->dispay_errors();
                }
            }
            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');
            $this->session->set_flashdata('message', 
                '<div class="alert alert-success" role="alert">
                    <small>Your profile has been updated!</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('user');
        }
    }

    //ChangePassword method
    public function changePassword(){
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
       
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[8]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[8]|matches[new_password1]');
        
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/user_footer', $data);
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');

            //cek password current yang diinput sama seperti yang di database atau tidak
            //apabila tidak sama
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger" role="alert">
                        <small>Wrong current password!</small>
                    </div>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>'
            );
                redirect('user/changepassword');
            } else {
                //apabila sama
                //cek apakah current password sama dengan newpassword
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password!</div>');
                    redirect('user/changepassword');
                } else {
                    // password sudah ok
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                   
                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');
                    
                    $this->session->set_flashdata('message', 
                        '<div class="alert alert-success" role="alert">
                            <small>Password changed!</small>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>'
                    );
                    redirect('user/changepassword');
                }
            }
        }
    }
}