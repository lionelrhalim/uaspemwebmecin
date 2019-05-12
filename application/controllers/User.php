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

    /*
     * Name = __construct() method
     * Description
     *      - Constructor
     *      - To load User_model as model_user
    */
    public function __construct() {

        parent::__construct();
        is_logged_in();
        $this->load->model('User_model', 'model_user');
        $this->load->model('Project_model', 'model_project');
        $this->load->model('Payment_model', 'model_payment');
    }



    /*
     * Name = index() method
     * Description
     *      To load dashboard info
    */
    public function index() {

        $get_id = $this->session->userdata('id');

        $data['title'] = "Dashboard";

        $data['user'] = $this->db->get_where( 'user', ['email' => $this->session->userdata('email')] )->row_array();
        $data['field'] = $this->db->get('field_category')->result_array();
        $data['job'] = $this->db->get('job_category')->result_array();


        $data['top_agent'] = $this->model_user->get_top_agent();

        // Load project, employer, and agent data
        $data['project'] = $this->model_project->get_project(0);
        $data['countProject'] = $this->model_project->count_project($get_id);
        $data['employer'] = [];
        $data['agent'] = [];
        foreach ($data['project'] as $project) {
            array_push($data['employer'], $this->model_user->get_user_profile($project['employer_id']));
            array_push($data['agent'], $this->model_user->get_user_profile($project['agent_id']));
        }

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('templates/user_navbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/user_footer', $data);
    }



    /*
     * Name = updateStatus() method
     * Description
     *      To update project status
    */
    public function updateStatus(){

        $projectname = $this->input->post('projectname');

        if(isset($_POST['submitDone'])){

            $this->db->set('status', 1);
            $this->db->where('status', 0);
            $this->db->where('project_name', $projectname);
            $this->db->update('createproject');
        }

        redirect('user/');
    }



    /*
     * Name = profile() method
     * Description
     *      To load information for profile view
    */
    public function profile(){

        $get_id = $this->input->get('id');
        $sid = $this->session->userdata('id');

        if (!isset($get_id))
            $get_id = $sid;

        $result = $this->model_user->get_user_profile($sid);
        $data['user'] = $result;
        $data['user']['id'] = $sid;

        // User viewing their own profile
        if ($get_id === $sid) {

            // Heading data
            $data['title'] = "Profile";
            $data['card_title'] = "Profile Info";

            // Load the heading
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('templates/user_navbar', $data);

            // Additional data
            $data['user']['headline'] = null;
            $data['user']['hide_wallet'] = 0;

            // Load the view
            $this->load->view('user/profile', $data);

            // Load the footer
            $this->load->view('templates/user_footer', $data);
        }

        // User viewing agent details
        else {

            // Heading data
            $data['title'] = "Browse";
            $data['card_title'] = "Agent Details";

            // Load the heading
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('templates/user_navbar', $data);

            // Load the agent profile data
            $result = $this->model_user->get_agent_profile($get_id);
            $data['user'] = $result['profile'];
            $data['field'] = $result['field'];
            $data['job'] = $result['job'];
            $data['skill'] = $result['skill'];

            // Additional data
            $data['user']['email'] = null;
            $data['user']['is_dev'] = 1;
            $data['user']['hide_wallet'] = 1;

            // Load the view
            $this->load->view('user/profile', $data);

            // Load the footer
            $this->load->view('templates/user_footer', $data);
        }
    }
    

    /*
     * Name = updateProjectStatus() method
     * Description
     *      To Update Project Status
     *      status = -4 [Not Satisfied / Complain]
     *      status = -3 [Not Finished]
     *      status = -2 [Not Paid]
     *      status = -1 [refused]
     *      status =  0 [waiting]
     *      status =  1 [accepted]
     *      status =  2 [Paid]
     *      status =  3 [Finished]
     *      status =  4 [Satisfied]
     *      status =  5 [Payment Checking]
    */
    public function updateProjectStatus($status, $project_id){

        if(isset($project_id) && isset($status)) {

            $_GET['id'] = $project_id;

            if(is_can_update_status($status)){

                // If status changed to finish, transfer money to Agent Wallet
                if($status == 4){

                    $project = $this->model_project->get_project_by_id($project_id);

                    if($project['status'] == 4){

                        msg_check_url();
                        redirect('project');

                    } else {

                        $get_data = $this->model_user->get_user_profile($project['agent_id']);
                        $this->model_user->update_wallet($get_data['user_id'], $project['bid']);

                    }
                    
                }

                $result = $this->model_user->update_project_status($status, $project_id);
        
                if($result == true){
                    $project = $this->model_user->get_specific_project($project_id);
                    $send_result = $this->send_inbox($project);

                    if($send_result) {
                        redirect('project');
                    } else {
                        var_dump('Gagal Send Inbox');
                    }
                } else {
                    var_dump('Gagal update project status');
                }

            } else {
                
                msg_check_url();
                redirect('project');
            
            }
        }

        else
            redirect('project');

    }



    /*
     * Name = inbox() method
     * Description
     *      To load information for inbox view
     *      $data['employer'] for storing employer profile
     *      $data['developer'] for storing developer profile
    */
    public function inbox(){
        $data['title'] = "Inbox";
        $data['user'] = $this->db->get_where( 'user', ['email' => $this->session->userdata('email')] )->row_array();
        $data['inbox'] = $this->model_user->get_inbox( $data['user']['id'] );

        $data['countInbox'] = 0;

        //Load the header
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('templates/user_navbar', $data);

        $this->load->view('user/inbox', $data);

        //Load the footer
        $this->load->view('templates/user_footer', $data);
    }

    public function send_inbox($project) {
        $inbox_title = '';
        $inbox_description = '';
        $project_id = $project[0]['project_id'];
        $user_id = '';
        $from_id = '';

        $employer = $this->model_user->get_user_profile($project[0]['employer_id']);
        $agent = $this->model_user->get_user_profile($project[0]['agent_id']);

        if($project[0]['status'] == -4) {
            $inbox_title = $project[0]['project_name'] . ' [Not Satisfied / Complain]';
            $inbox_description = $employer['name'] .
                ' is not satisfied with the result. Here is their complain description: <br> ' .
                $project[0]['project_complain'];
            $user_id = $project[0]['agent_id'];
            $from_id = $project[0]['employer_id'];
        } elseif($project[0]['status'] == -3) {
            $inbox_title = $project[0]['project_name'] . ' [Not Finished]';
            $inbox_description = $agent['name'] .' Cannot meet the project deadline';
            $user_id = $project[0]['employer_id'];
            $from_id = $project[0]['agent_id'];
        } elseif($project[0]['status'] == -2) {
            $inbox_title = $project[0]['project_name'] . ' [Not Paid]';
            $inbox_description = $employer['name'] .' Does not pay for the project. The project has been cancelled.';
            $user_id = $project[0]['agent_id'];
            $from_id = $project[0]['employer_id'];
        } elseif($project[0]['status'] == -1) {
            $inbox_title = $project[0]['project_name'] . ' [Refused]';
            $inbox_description = $agent['name'] .' Refuse your project proposal.';
            $user_id = $project[0]['employer_id'];
            $from_id = $project[0]['agent_id'];
        } elseif($project[0]['status'] == 0) {
            $inbox_title = $project[0]['project_name'] . ' [New Proposal]';
            $inbox_description = $employer['name'] .' Propose a new project to you.';
            $user_id = $project[0]['agent_id'];
            $from_id = $project[0]['employer_id'];
        } elseif($project[0]['status'] == 1) {
            $inbox_title = $project[0]['project_name'] . ' [Accepted]';
            $inbox_description = $agent['name'] .' Accept your project proposal.';
            $user_id = $project[0]['employer_id'];
            $from_id = $project[0]['agent_id'];
        } elseif($project[0]['status'] == 2) {
            $inbox_title = $project[0]['project_name'] . ' [Paid]';
            $inbox_description = $employer['name'] .' Has complete the payment for this project. You may begin this project.';
            $user_id = $project[0]['agent_id'];
            $from_id = $project[0]['employer_id'];
        } elseif($project[0]['status'] == 3) {
            $inbox_title = $project[0]['project_name'] . ' [Finished]';
            $inbox_description = $agent['name'] .' Finished this project. Please check it, and give a complain within 2 days.';
            $user_id = $project[0]['employer_id'];
            $from_id = $project[0]['agent_id'];
        } elseif($project[0]['status'] == 4) {
            $inbox_title = $project[0]['project_name'] . ' [Satisfied]';
            $inbox_description = $employer['name'] .' Accept your work. Your money has been transfered to your account! Well Done!';
            $user_id = $project[0]['agent_id'];
            $from_id = $project[0]['employer_id'];
        }

        return $this->model_user->set_inbox($inbox_title, $inbox_description, $project_id, $user_id, $from_id);
    }

    public function inbox_detail(){
        $inbox_id = $this->input->get('inbox_id');
        $project_id = $this->input->get('project_id');

        $data['title'] = "Inbox";
        $data['user'] = $this->db->get_where( 'user', ['email' => $this->session->userdata('email')] )->row_array();
        $data['inbox_detail'] = $this->model_user->get_inbox_detail($data['user']['id'], $inbox_id, $project_id);

        $data['from'] = $this->model_user->get_user_profile($data['inbox_detail'][0]['from_id']);
        $data['to'] = $this->model_user->get_user_profile($data['inbox_detail'][0]['user_id']);


        $this->model_user->update_inbox_status(1, $inbox_id);

        //Load the header
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('templates/user_navbar', $data);

        $this->load->view('user/inboxdetail', $data);

        //Load the footer
        $this->load->view('templates/user_footer', $data);
    }



    /*
     * Name = edit() method
     * Description
     *      To edit user information
    */
    public function edit(){

        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('templates/user_navbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/user_footer', $data);
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            // cek jika ada gambar yang akan diupload
            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {

                $this->load->library('upload');

                //hanya bisa upload gambar sesuai dengan ketentuan dibawah ini
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048'; //2MB
                $config['upload_path'] = './assets/img/profile/';

                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    
                    $config['image_library'] = 'gd2';
                    $config['source_image'] = './assets/img/profile/'.$this->upload->data('file_name');
                    $config['maintain_ratio'] = FALSE;
                    $config['width']         = 150;
                    $config['height']       = 150;
                    $config['new_image']= './assets/img/profile/';
                    $this->load->library('image_lib', $config);
                    $this->image_lib->resize();

                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        //untuk menghapus image lama yang sudah tidak terpakai selain default.jpg
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    
                    $new_image = $this->upload->data('file_name');
                    //set untuk dimasukan ke db new_imagenya
                    $this->db->set('image', $new_image);
                    
                } else {
                    echo $this->upload->display_errors();
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

    public function ongoing(){
        $data['title'] = 'Ongoing Project';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['createproject'] = $this->db->get('createproject')->result_array();

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('user/ongoing', $data);
        $this->load->view('templates/user_footer', $data);
    }

    public function past(){
        $data['title'] = 'Past Project';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['createproject'] = $this->db->get('createproject')->result_array();

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('user/pastproject', $data);
        $this->load->view('templates/user_footer', $data);
    }

    public function form_completion(){
        $data['title'] = 'Complete your profile';
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')]) ->row_array();
        $data['banks'] = $this->model_payment->get_bank_name();
        $data['view_bank'] = $this->load->view('opt/bank.php', $data, TRUE);

        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('user/profileform', $data);
        $this->load->view('templates/user_footer', $data);

    }

    public function form_completion_action(){

        $data['title'] = 'Complete your profile';
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')]) ->row_array();
        $data['banks'] = $this->model_payment->get_bank_name();
        $data['view_bank'] = $this->load->view('opt/bank.php', $data, TRUE);

         $this->form_validation->set_rules('phone', 'Phone', 'required|trim|is_natural');
         $this->form_validation->set_rules('bank_id', 'Bank', 'required|trim|is_natural');
         $this->form_validation->set_rules('bank_account', 'Bank Account', 'required|trim|is_natural');

         if ($this->form_validation->run() == false) {
             $this->load->view('templates/user_header', $data);
             //$this->load->view('templates/user_topbar', $data);
             $this->load->view('user/profileform', $data);
             //$this->load->view('templates/user_footer', $data);
         } else {
            $values = array(
            'user_id' => $this->session->userdata('id'),
            'phone' => $this->input->post('phone'),
            'line' => $this->input->post('line'),
            'instagram' => $this->input->post('instagram'),
            'bank_id' => $this->input->post('bank_id'), #TODO: ini masih dummy, harus diganti ambil dr database id bank nya brp.
            'bank_account' => $this->input->post('bank_account'),
            'wallet' => 0,
            'is_dev' => 0
            );
            $user_id = $this->session->userdata('id');
            $is_complete = 1;

            $result = $this->model_user->set_user_profile($user_id, $values, $is_complete);
            
            if($result){
                header('location: '.base_url('user'));
            }
            else{
                $this->index($result);
            }
         }
    }

    public function check_is_dev() {

        $user = $this->db->get_where('user_profile', ['user_id' => $this->session->userdata('id')])->row_array();
        
        if( $user['is_dev'] == 0 ){
            redirect('user/activate_developer');
        }

        else if($user['is_dev'] == 1 ){
            $user_id = $this->session->userdata('id');
            $result = $this->model_user->deletes($user_id);
            redirect('user/profile');
        }

    }

    public function activate_developer(){

        $data['title'] = 'Activate Developer';

        $user = $this->db->get_where('user_profile', ['user_id' => $this->session->userdata('id')])->row_array();

        if($this->model_user->is_previous_dev($user['user_id'])){
        
            $this->model_user->activate_developer($user['user_id']);
            redirect('user/profile');
        
        } else {   

            $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')]) ->row_array();
            $data['jobs'] = $this->model_user->get_jobs();
            $data['fields'] = $this->model_user->get_fields();
            $data['skills'] = $this->model_user->get_skills();

            $data['view_jobs'] = $this->load->view('opt/job.php', $data, TRUE);
            $data['view_fields'] = $this->load->view('opt/field.php', $data, TRUE);
            $data['view_skill'] = $this->load->view('opt/skill.php', $data, TRUE);

            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/todeveloperform', $data);
            $this->load->view('templates/user_footer', $data);
        }

    }

    public function edit_developer_profile() {

        $data['title'] = 'Developer Profile';

        $data['check_is_dev'] = $this->db->get_where('user_profile',['user_id' => $this->session->userdata('id'), 'is_dev' => 1])->row_array();
        $data['user'] = $this->db->get_where('user',['id' => $this->session->userdata('id')])->row_array();
        
        if(!$data['check_is_dev'])
            redirect('user/profile');

        $this->form_validation->set_rules('tagline', 'Headline', 'required');
        $this->form_validation->set_rules('fee', 'Bid', 'required');
        
        if($this->form_validation->run() == false) {

            $data['dev'] = $this->db->get_where('developer_profile',['user_id' => $this->session->userdata('id')])->row_array();

            $data['tagline'] = $data['dev']['headline'];
            if(!$data['tagline'])
                $data['tagline'] = "Write your headline";
                
            $data['fee'] = $data['dev']['starting_bid'];
                if(!$data['fee'])
                    $data['fee'] = "Enter your starting bid";

            $data['jobs'] = $this->model_user->get_jobs();
            $data['fields'] = $this->model_user->get_fields();
            $data['skills'] = $this->model_user->get_skills();

            $data['view_jobs'] = $this->load->view('opt/job.php', $data, TRUE);
            $data['view_fields'] = $this->load->view('opt/field.php', $data, TRUE);
            $data['view_skill'] = $this->load->view('opt/skill.php', $data, TRUE);

            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/todeveloperform', $data);
            $this->load->view('templates/user_footer', $data);

        } else {

            $fields = $this->input->post('field_list', TRUE);
            $jobs = $this->input->post('job_list', TRUE);
            $skills = $this->input->post('skill_list', TRUE);
            $user_id = $this->session->userdata('id');
            $tagline = $this->input->post('tagline', TRUE);
            $price = $this->input->post('fee', TRUE);
    
            foreach ($fields as $fields_selected) {
                
                $result = $this->model_user->set_fields($user_id, $fields_selected);
            }
    
            foreach ($jobs as $jobs_selected) {
                
                $result = $this->model_user->set_jobs($user_id, $jobs_selected);
            }
    
            foreach ($skills as $skills_selected) {
                
                $result = $this->model_user->set_skills($user_id, $skills_selected);
            }
    
            $result = $this->model_user->set_developer_profile($user_id, $tagline, $price);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <small>Your Developer Profile Has Been Updated</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );
            
            if($result){
                redirect('user?id='.$data['user']['id']);
            }
            else{
                $this->index($result);
            }

        }

    }

    public function browse(){
        $get_id = $this->session->userdata('id');

        $data['title'] = "Browse";

        $data['user'] = $this->db->get_where( 'user', ['email' => $this->session->userdata('email')] )->row_array();
        $data['field'] = $this->db->get('field_category')->result_array();
        $data['job'] = $this->db->get('job_category')->result_array();


        $data['top_agent'] = $this->model_user->get_all_agent();
    
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('templates/user_navbar', $data);
        $this->load->view('user/browse', $data);
        $this->load->view('templates/user_footer', $data);
    }

}
