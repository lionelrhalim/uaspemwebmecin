<?php

/*
 * Type         = Controller
 * File name    = Project.php
 * Slug         = project
 * Description
 *      This controller is for handling PROJECT
 *
*/

defined('BASEPATH') or exit('No direct script access allowed');

class Project extends CI_Controller {

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
    }



    /*
     * Name = index() method
     * Description
     *      $data['employer'] for storing employer profile
     *      $data['developer'] for storing developer profile
    */
    public function index() {

        $data['title'] = "Project";

        $data['user'] = $this->model_user->get_user();
        $data['user']['profile'] = $this->model_user->get_user_profile($data['user']['id']);

        $sort = 0;
        if(isset($_GET['sort'])) {
            $sort = $_GET['sort'];
            $sort = intval($sort);

            if($sort < 0 OR $sort > 2)
                $sort = 0;
        }

        $data['project'] = $this->model_project->get_project($sort);

        $data['employer'] = [];
        $data['developer'] = [];
        $data['countProposedEmployer'] = 0;
        $data['countNeedPaidEmployer'] = 0;
        $data['countNeedReviewEmployer'] = 0;

        $data['countRequestedAgent'] = 0;
        $data['countOngoingAgent'] = 0;
        $data['countComplainedAgent'] = 0;
        $data['countFinishedAgent'] = 0;

        //Get Employer Profile
        foreach ($data['project'] as $project) {
            array_push($data['employer'], $this->model_user->get_user_profile($project['employer_id']));
        }

        //Get Agent Profile
        foreach ($data['project'] as $project) {
            array_push($data['developer'], $this->model_user->get_user_profile($project['agent_id']));
        }

        //Load the header
        $this->load->view('templates/user_header_datatables', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('templates/user_navbar', $data);

        $this->load->view('project/index', $data);

        //Load the footer
        $this->load->view('templates/user_footer_datatables', $data);

    }



    /*
     * Name = propose() method
     * Description
     *      For handling propose project form
     *      and insert to the database
    */
    public function propose() {

        $data['user'] = $this->model_user->get_user();

        $contact_id = $_GET['id'];

        if($contact_id == NULL)
            redirect('user');

        $this->form_validation->set_rules('projectname', 'Project Name', 'required');
        $this->form_validation->set_rules('desc', 'Description', 'required');
        $this->form_validation->set_rules('field_category', 'Field Category', 'required');
        $this->form_validation->set_rules('job_category', 'Job Category', 'required');
        $this->form_validation->set_rules('times', 'Deadline', 'required|callback_date_check');
        $this->form_validation->set_rules('price', 'Price', 'required');

        if($this->form_validation->run() == false){
            
            $data['title'] = 'Project | MECIN.co';
            $data['field'] = $this->db->get('field_category')->result_array();
            $data['job'] = $this->db->get('job_category')->result_array();
            $data['user']['contact_id'] = $contact_id;
            $data['user']['contact_name'] = $this->model_user->get_agent_profile($contact_id);
    
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('templates/user_navbar', $data);
            $this->load->view('project/propose', $data);
            $this->load->view('templates/user_footer', $data);

        } else{
            
            $employer_id = $data['user']['id'];
            $agent_id = $this->input->get('id');

            $data = [
                'project_name'      => $this->input->post('projectname', TRUE),
                'field_category'    => $this->input->post('field_category', TRUE),
                'job_category'      => $this->input->post('job_category', TRUE),
                'deadline'          => $this->input->post('times', TRUE),
                'bid'               => $this->input->post('price', TRUE),
                'description'       => $this->input->post('desc', TRUE),
                'employer_id'       => $employer_id,
                'agent_id'          => $agent_id,
            ];

            $cart_id = $this->model_project->add_to_cart($data);
            redirect('project/cart?id='.$cart_id);
            
        }
    }
    
    public function cart() {
                
        if(isset($_GET['id'])) {
            
            if(is_can_access_cart()) {

                $data['user'] = $this->model_user->get_user();
                $cart_id = $_GET['id'];
                $data['project'] = $this->model_project->get_from_cart($cart_id);

                $data['title'] = 'Cart | MECIN.co';

                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('templates/user_navbar', $data);
                $this->load->view('project/cart', $data);
                $this->load->view('templates/user_footer', $data);

            } else {
                
                msg_check_url();
                redirect('project/my_cart');
            
            }
        }

        else
            redirect('project/my_cart');
    
    }






    public function my_cart() {

        $data['title'] = "Cart";

        $data['user'] = $this->model_user->get_user();
        $data['user']['profile'] = $this->model_user->get_user_profile($data['user']['id']);

        $sort = 0;
        if(isset($_GET['sort'])) {
            $sort = $_GET['sort'];
            $sort = intval($sort);

            if($sort < 0 OR $sort > 2)
                $sort = 0;
        }

        $data['cart'] = $this->model_project->get_all_cart($sort);
        $data['countCart'] = 0;

        //Load the header
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('templates/user_navbar', $data);

        $this->load->view('project/my_cart', $data);

        //Load the footer
        $this->load->view('templates/user_footer', $data);
        
    }



    public function cancel_cart() {

        if(isset($_GET['id'])) {

            if(is_can_access_cart()){

                $this->model_project->delete_cart($_GET['id']);
                redirect('project/my_cart');

            } else {
                
                msg_check_url();
                redirect('project/my_cart');
            
            }
        }

        else
            redirect('project/my_cart');

    }





    public function post() {

        $data['user'] = $this->model_user->get_user();

        $this->form_validation->set_rules('agent_id', 'Agent', 'required');
        $this->form_validation->set_rules('projectname', 'Project Name', 'required');
        $this->form_validation->set_rules('desc', 'Description', 'required');
        $this->form_validation->set_rules('field_category', 'Field Category', 'required');
        $this->form_validation->set_rules('job_category', 'Job Category', 'required');
        $this->form_validation->set_rules('times', 'Deadline', 'required|callback_date_check');
        $this->form_validation->set_rules('price', 'Price', 'required');

        
        if($this->form_validation->run() == false){

            $data['title'] = 'Project | MECIN.co';
            $data['field'] = $this->db->get('field_category')->result_array();
            $data['job'] = $this->db->get('job_category')->result_array();
            $data['user']['contact_id'] = $this->input->post('agent_id', TRUE);
            $data['user']['contact_name'] = $this->model_user->get_agent_profile($this->input->post('agent_id', TRUE));
    
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('templates/user_navbar', $data);
            $this->load->view('project/propose', $data);
            $this->load->view('templates/user_footer', $data);

        } else{

            $data = [
                'project_name'      => $this->input->post('projectname', TRUE),
                'field_category'    => $this->input->post('field_category', TRUE),
                'job_category'      => $this->input->post('job_category', TRUE),
                'deadline'          => $this->input->post('times', TRUE),
                'bid'               => $this->input->post('price', TRUE),
                'description'       => $this->input->post('desc', TRUE),
                'status'            => 0,
                'employer_id'       => $data['user']['id'],
                'agent_id'          => $this->input->post('agent_id', TRUE)
            ];

            $this->model_project->post_project($data);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <small>Your Project Has Been Proposed</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );

            $project_id = $this->model_project->get_latest_project();
            $project = $this->model_project->get_project_by_id($project_id['project_id']);
            $send_result = $this->send_inbox($project);

            if($send_result) {
                redirect('user');
            } else {
                var_dump('Gagal Send Inbox');
            }

        }

    }



    public function date_check($date) {

        $now = now('Asia/Jakarta');
        $timeNow = date('d F Y', gmt_to_local($now, FALSE));
        $deadline = date('d F Y', strtotime($timeNow . '+3 day'));
        $get_time = date('d F Y', strtotime($date));

        if ($get_time > $deadline) {
            return TRUE;
        } else {
            $this->form_validation->set_message('date_check', 'Please set the deadline 3 days from now');
            return FALSE;
        }
    }




    /*
     * Name = send_inbox() method
     * Description
     *      For send inbox to update the agent
    */
    public function send_inbox($project) {
        $inbox_title = '';
        $inbox_description = '';
        $project_id = $project['project_id'];
        $user_id = '';
        $from_id = '';

        $employer = $this->model_user->get_user_profile($project['employer_id']);
        $agent = $this->model_user->get_user_profile($project['agent_id']);

        if($project['status'] == -4) {
            $inbox_title = $project['project_name'] . ' [Not Satisfied / Complain]';
            $inbox_description = $employer['name'] .
                ' is not satisfied with the result. Here is their complain description: <br> ' .
                $project['project_complain'];
            $user_id = $project['agent_id'];
            $from_id = $project['employer_id'];
        } elseif($project['status'] == -3) {
            $inbox_title = $project['project_name'] . ' [Not Finished]';
            $inbox_description = $agent['name'] .' Cannot meet the project deadline';
            $user_id = $project['employer_id'];
            $from_id = $project['agent_id'];
        } elseif($project['status'] == -2) {
            $inbox_title = $project['project_name'] . ' [Not Paid]';
            $inbox_description = $employer['name'] .' Does not pay for the project. The project has been cancelled.';
            $user_id = $project['agent_id'];
            $from_id = $project['employer_id'];
        } elseif($project['status'] == -1) {
            $inbox_title = $project['project_name'] . ' [Refused]';
            $inbox_description = $agent['name'] .' Refuse your project proposal.';
            $user_id = $project['employer_id'];
            $from_id = $project['agent_id'];
        } elseif($project['status'] == 0) {
            $inbox_title = $project['project_name'] . ' [New Proposal]';
            $inbox_description = $employer['name'] .' Propose a new project to you.';
            $user_id = $project['agent_id'];
            $from_id = $project['employer_id'];
        } elseif($project['status'] == 1) {
            $inbox_title = $project['project_name'] . ' [Accepted]';
            $inbox_description = $agent['name'] .' Accept your project proposal.';
            $user_id = $project['employer_id'];
            $from_id = $project['agent_id'];
        } elseif($project['status'] == 2) {
            $inbox_title = $project['project_name'] . ' [Paid]';
            $inbox_description = $employer['name'] .' Has complete the payment for this project. You may begin this project.';
            $user_id = $project['agent_id'];
            $from_id = $project['employer_id'];
        } elseif($project['status'] == 3) {
            $inbox_title = $project['project_name'] . ' [Finished]';
            $inbox_description = $agent['name'] .' Finished this project. Please check it, and give a complain within 2 days.';
            $user_id = $project['employer_id'];
            $from_id = $project['agent_id'];
        } elseif($project['status'] == 4) {
            $inbox_title = $project['project_name'] . ' [Satisfied]';
            $inbox_description = $employer['name'] .' Accept your work. Well Done!';
            $user_id = $project['agent_id'];
            $from_id = $project['employer_id'];
        }

        return $this->model_user->set_inbox($inbox_title, $inbox_description, $project_id, $user_id, $from_id);
    }
    

    /*
     * Name = cancel() method
     * Description
     *      User cancel the project
    */
    public function cancel() {

        if(isset($_GET['id'])) {

            if(is_can_access_project()){

                $this->model_project->cancel_project($_GET['id']);
                redirect('project');

            } else {
                
                msg_check_url();
                redirect('project');
            
            }
        }

        else
            redirect('project');

    }


    /*
     * Name = edit() method
     * Description
     *      User edit the project details
    */
    public function edit() {

        if(isset($_GET['id'])) {

            if(is_can_access_cart()){

                $data['user'] = $this->model_user->get_user();

                $this->form_validation->set_rules('projectname', 'Project Name', 'required');
                $this->form_validation->set_rules('desc', 'Description', 'required');
                $this->form_validation->set_rules('field_category', 'Field Category', 'required');
                $this->form_validation->set_rules('job_category', 'Job Category', 'required');
                $this->form_validation->set_rules('times', 'Deadline', 'required|callback_date_check');
                $this->form_validation->set_rules('price', 'Price', 'required');

                if($this->form_validation->run() == false){
                    
                    $data['title'] = 'Project | MECIN.co';
                    $data['field'] = $this->db->get('field_category')->result_array();
                    $data['job'] = $this->db->get('job_category')->result_array();

                    $cart_id = $_GET['id'];
                    $data['project'] = $this->model_project->get_from_cart($cart_id);
            
                    $this->load->view('templates/user_header', $data);
                    $this->load->view('templates/user_topbar', $data);
                    $this->load->view('templates/user_navbar', $data);
                    $this->load->view('project/edit', $data);
                    $this->load->view('templates/user_footer', $data);

                } else{

                    $cart_id = $_GET['id'];
                    $data['project'] = $this->model_project->get_from_cart($cart_id);
                    
                    $employer_id = $data['user']['id'];
                    $agent_id = $data['project']['agent_id'];

                    $data = [
                        'project_name'      => $this->input->post('projectname', TRUE),
                        'field_category'    => $this->input->post('field_category', TRUE),
                        'job_category'      => $this->input->post('job_category', TRUE),
                        'deadline'          => $this->input->post('times', TRUE),
                        'bid'               => $this->input->post('price', TRUE),
                        'description'       => $this->input->post('desc', TRUE),
                        'employer_id'       => $employer_id,
                        'agent_id'          => $agent_id,
                    ];

                    $cart_id = $this->model_project->edit_cart($cart_id, $data);
                    redirect('project/cart?id='.$cart_id);
                    
                }

            } else {
                msg_check_url();
                redirect('project');
            
            }
        }

        else
            redirect('project');

    }
}