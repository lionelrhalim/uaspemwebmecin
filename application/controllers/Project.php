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
        $data['project'] = $this->model_user->get_project();

        $data['employer'] = [];
        $data['developer'] = [];
        $data['countProposedEmployer'] = 0;
        $data['countNeedPaidEmployer'] = 0;
        $data['countRequestedAgent'] = 0;
        $data['countOngoingAgent'] = 0;
        $data['countComplainedAgent'] = 0;

        //Get Employer Profile
        foreach ($data['project'] as $project) {
            array_push($data['employer'], $this->model_user->get_user_profile($project['employer_id']));
        }

        //Get Agent Profile
        foreach ($data['project'] as $project) {
            array_push($data['developer'], $this->model_user->get_user_profile($project['agent_id']));
        }

        //Load the header
        $this->load->view('templates/user_header', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('templates/user_navbar', $data);

        $this->load->view('project/index', $data);

        //Load the footer
        $this->load->view('templates/user_footer', $data);

    }



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
            
            $status = 0;
            $employer_id = $data['user']['id'];
            $agent_id = $this->input->get('id');

            $data = [
                'project_name'      => $this->input->post('projectname', TRUE),
                'field_category'    => $this->input->post('field_category', TRUE),
                'job_category'      => $this->input->post('job_category', TRUE),
                'deadline'          => $this->input->post('times', TRUE),
                'bid'               => $this->input->post('price', TRUE),
                'description'       => $this->input->post('desc', TRUE),
                'status'            => $status,
                'employer_id'       => $employer_id,
                'agent_id'          => $agent_id,
            ];

            $this->db->insert('project', $data);

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <small>Your Project Has Been Proposed</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );

            redirect('user');
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
    
}