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
    }



    // Default method
    public function index() {

        // If logged in, redirect to 'user'
        if($this->session->userdata('email')){
            redirect('user');
        }
        
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
                        'id' => $user['id'],
                        'email' => $user['email'],
                        'role_id' => $user['role_id'],
                        'is_complete' => $user['is_complete']
                    ];

                    // Open session
                    $this->session->set_userdata($data);

                    // Redirect to view based on role_id
                    if( $user['role_id'] == 1 ){
                        redirect('admin');
                    }
                    else if ( $user['is_complete'] == 1){
                        redirect('user');
                    } else {
                        redirect('user/form_completion');
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
        //apabila sudah login tidak bisa balik ke auth
        if($this->session->userdata('email')){
            redirect('user');
        }

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
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.jpg',
                'password' => password_hash( $this->input->post('password1'), PASSWORD_DEFAULT ),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time(),
                'is_complete' => 0
            ];

            //siapkan token berupa bilangan random 32 digit
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];
            
            // Query to database
            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);
            
            //ngirim email dengan menyertakan token untuk verify
            $this->_sendEmail($token, 'verify');

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

    // Private _sendEmail() function
    private function _sendEmail($token, $type){
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'noreply.mecinan@gmail.com',
            'smtp_pass' => 'uaspemwebmecin',
            'smtp_port' => 465, //port smtp google
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        //$this->load->library('email', $config);
        $this->email->initialize($config);

        //set ingin kirim darimana
        $this->email->from('noreply.mecinan@gmail.com', 'Mecin.an');
        
        //set ingin kirim kemana
        $this->email->to($this->input->post('email'));
        
        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify you account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    // Verify method
    public function verify(){
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        
        //jika usernya ada
        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
        
            //jika tokennya ada
            if ($user_token) {
                //token berlaku hanya selama 1 hari
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', 
                        '<div class="alert alert-success" role="alert">' 
                            . '<small>' . $email . ' has been activated! Please login. </small>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>'
                    );
                    redirect('auth');
                } else {
                    //apabila token sudah lebih dari 1 hari dan belum melakukan verify 
                    //maka token di hapus
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', 
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <small>Account activation failed! Token expired.</small>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>'
                    );
                    redirect('auth');
                }
            } else {
                //jika tokennya tidak ada
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <small>Account activation failed! Wrong token.</small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                );
                redirect('auth');
            }
        } else {
            //apabila user tidak ada
            $this->session->set_flashdata('message', 
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <small>Account activation failed! Wrong email.</small>
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
                <small>You have been loggedout</small>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>'
        );
        redirect('auth');
    }


    // Blocked method
    public function blocked(){
        //echo "access blocked";
        //tolong buat view untuk blocked ya
        $this->load->view('auth/blocked');
    }

    // ForgotPassword method
    public function forgotPassword(){
        
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();
            
            if ($user) {
                //token untuk forgotpassword
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];
                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <small>Please check your email to reset your password!</small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                );
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <small>Email is not registered or activated!<small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                );
                redirect('auth/forgotpassword');
            }
        }
    }

    //ResetPassword method
    public function resetPassword(){
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        
        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
           
            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('message', 
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <small>Reset password failed! Wrong token.</small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>'
                );
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', 
                '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <small>Reset password failed! Wrong email.</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('auth');
        }
    }

    //ChangePassword method
    public function changePassword(){
        
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[8]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|min_length[8]|matches[password1]');
        
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            //hapus session sebelum balik ke login
            $this->session->unset_userdata('reset_email');
            $this->db->delete('user_token', ['email' => $email]);
            $this->session->set_flashdata('message', 
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <small>Password has been changed! Please login.</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            redirect('auth');
        }
    }

}