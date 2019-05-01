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
        var_dump(123);
    }


    public function pay() {

        if(isset($_GET['project']))
            $project_id = $_GET['project'];
        else
            redirect('user');

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

    }

    public function processing_payment() {

        if(isset($_GET['project']))
            $project_id = $_GET['project'];
        else
            redirect('user');

        $this->form_validation->set_rules('bank', 'Payment Method', 'required');

        if($this->form_validation->run() == false){
            
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

            var_dump(
                "NUNGGU KONFIRMASI ADMIN -> ADMIN KONFIRMASI -> DUIT MASUK KE DB -> UPDATE STATUS PROJECT 
                -> KALAU UDAH BERES, PENCET OKE -> NUNGGU EMPLOYER REVIEW -> OKE -> DUIT MASUK KE AGENT
                -> FINISH");
            die;

            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <small>Your Payment Has Been Processed</small>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>'
            );

            redirect('user');

        }


    }

}