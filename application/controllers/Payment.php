<?php

/*
 * Type         = Controller
 * File name    = Payment.php
 * Slug         = payment
 * Description
 *      This controller is for handling PAYMENT
 *
*/

defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller {

    /*
     * Name = __construct() method
     * Description
     *      - Constructor
     *      - 
    */
    public function __construct() {

        parent::__construct();
        is_logged_in();

        $this->load->model('User_model', 'model_user');
        $this->load->model('Project_model', 'model_project');
        $this->load->model('Payment_model', 'model_payment');
    }

    public function index() {
        redirect(user);
    }

    public function check() {
        $data['title'] = "Check Payment";
        $data['user'] = $this->db->get_where( 'user', ['email' => $this->session->userdata('email')] )->row_array();
        $data['payment'] = $this->model_payment->get_check_payment();
        
        $this->load->view('templates/user_header_datatables', $data);
        $this->load->view('templates/user_sidebar', $data);
        $this->load->view('templates/user_topbar', $data);
        $this->load->view('payment/check', $data);
        $this->load->view('templates/user_footer_datatables', $data);
    }

    public function process_check() {
        
        if(isset($_GET['pck_id']) && isset($_GET['set'])){
            $process_id = $_GET['pck_id'];
            $set_status = $_GET['set'];
        } else
            redirect('user');

        $data['project'] = $this->model_payment->get_check_payment_by_id($process_id);
        $this->model_payment->set_check_payment($process_id, $set_status);
        $this->updateProjectStatus(2, $data['project']['project_id']);
        $this->check();
    }


    public function pay() {


        if(isset($_GET['id'])) {

            if(is_can_access_project()){

                $project_id = $_GET['id'];
                $data['title'] = "Project";

                $data['user'] = $this->model_user->get_user();
                $data['project'] = $this->model_project->get_project_by_id($project_id);
                $data['project']['agent'] = $this->model_user->get_agent_profile($data['project']['agent_id']);
                $data['bank'] = $this->model_payment->get_bank();

                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('templates/user_navbar', $data);

                $this->load->view('payment/pay', $data);

                //Load the footer
                $this->load->view('templates/user_footer', $data);

            } else {
                
                msg_check_url();
                redirect('project');
            
            }
        }

        else
            redirect('project');

    }

    public function processing_payment() {



        if(isset($_GET['id'])) {

            if(is_can_access_project()){

                $project_id = $_GET['id'];
                $this->form_validation->set_rules('bank', 'Payment Method', 'required');
        
                $data['project'] = $this->model_project->get_project_by_id($project_id);

                if($this->form_validation->run() == false){
                    
                    $data['title'] = "Project";

                    $data['user'] = $this->model_user->get_user();
                    $data['project']['agent'] = $this->model_user->get_agent_profile($data['project']['agent_id']);
                    $data['bank'] = $this->model_payment->get_bank();

                    $this->load->view('templates/user_header', $data);
                    $this->load->view('templates/user_topbar', $data);
                    $this->load->view('templates/user_navbar', $data);

                    $this->load->view('payment/pay', $data);

                    //Load the footer
                    $this->load->view('templates/user_footer', $data);

                } else {

                    $data['project']['bank_id'] = $this->input->post('bank');

                    $data['input'] = [
                        'project_id'        => $data['project']['project_id'],
                        'incoming'          => $data['project']['bid'],
                        'bank_id'           => $data['project']['bank_id'],
                        'employer_id'       => $data['project']['employer_id'],
                        'agent_id'          => $data['project']['agent_id'],
                        'check_status'      => 0,

                    ];

                    $this->db->insert('check_payment', $data['input']);

                    $this->session->set_flashdata(
                        'message',
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <small>Your Payment Has Been Processed</small>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>'
                    );

                    $this->updateProjectStatus(5,$data['project']['project_id']);

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
        var_dump($project_id);

        $result = $this->model_user->update_project_status($status, $project_id);

        if($result == true){
            $project = $this->model_project->get_project_by_id($project_id);
            $send_result = $this->send_inbox($project);

            if($send_result === 'no_redirect') {
                return TRUE;
            } elseif($send_result) {
                redirect('user');
            } else {
                var_dump('Gagal Send Inbox');
            }
        } else {
            var_dump('Gagal update project status');
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

        if($project['status'] == 5) {
            $inbox_title = $project['project_name'] . ' [Checking Payment in Progress]';
            $inbox_description = 'Your ' . $project['project_name'] . ' is in payment checking';
            $user_id = $project['employer_id'];
            $from_id = 0;
        } elseif($project['status'] == 2) {
            $inbox_title = $project['project_name'] . ' [Paid]';
            $inbox_description = $employer['name'] .' Has complete the payment for this project. You may begin this project.';
            $user_id = $project['agent_id'];
            $from_id = 0;
            $this->model_user->set_inbox($inbox_title, $inbox_description, $project_id, $user_id, $from_id);

            $inbox_title = $project['project_name'] . ' [Paid]';
            $inbox_description = ' Your payment status is accepted. Your project now will be on progress.';
            $user_id = $project['employer_id'];
            $from_id = 0;
            $this->model_user->set_inbox($inbox_title, $inbox_description, $project_id, $user_id, $from_id);

            return 'no_redirect';
        }

        return $this->model_user->set_inbox($inbox_title, $inbox_description, $project_id, $user_id, $from_id);
    }

}