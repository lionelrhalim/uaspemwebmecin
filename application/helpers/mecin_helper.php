<?php


/*
 * Type         = Helper
 * File name    = mecin_helper.php 
*/


function is_logged_in(){
     //pada helper ga kenal this, jadi untuk dapat ambil data-datanya panggil fungsi berikut
    $ci = get_instance();
    
    if(!$ci->session->userdata('email')){
        
        redirect('auth');

    } else {
        
        $role_id = $ci->session->userdata('role_id');
        //untuk dapetin urlnya
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('user_access_menu', ['role_id' => $role_id, 'menu_id' => $menu_id]);


        if($userAccess->num_rows() < 1){
            
            redirect('auth/blocked');
        
        } else {

            $email = $ci->session->userdata('email');
            $user = $ci->db->get_where('user', ['email' => $email])->row_array();
            
            if($user['is_complete'] == 0){
                
                redirect('auth/form_completion');
            
            }
        } 
    }

    function check_access($role_id, $menu_id){
        $ci = get_instance();
        $ci->db->where('role_id', $role_id);
        $ci->db->where('menu_id', $menu_id);
        $result = $ci->db->get('user_access_menu');


        if($result->num_rows() > 0){
            return "checked='checked'";
        }
    }
}

function is_can_access_cart() {

    $th1s = get_instance();

    /*
     * ambil user model
     * ambil get id
     * ambil tabel cart dengan id
     * cek apakah bisa akses
    */

    $data['user'] = $th1s->model_user->get_user();
    $cart_id = $_GET['id'];
    $cart_data = $th1s->model_project->get_from_cart($cart_id);
    
    if($cart_data['employer_id'] === $data['user']['id'])
        return TRUE;
    else
        return FALSE;


}

function is_can_access_project() {

    $th1s = get_instance();

    /*
     * ambil user model
     * ambil get id
     * ambil tabel project dengan id
     * cek apakah bisa akses
    */

    $data['user'] = $th1s->model_user->get_user();
    $project_id = $_GET['id'];
    $project_data = $th1s->model_project->get_project_by_id($project_id);
    
    if($project_data['employer_id'] === $data['user']['id'])
        return TRUE;
    else
        return FALSE;


}


function is_can_access_payment() {


    $th1s = get_instance();

    $data['user'] = $th1s->model_user->get_user();
    $project_id = $_GET['id'];
    $project_data = $th1s->model_project->get_check_payment($project_id);
    
    if (($project_data['employer_id'] === $data['user']['id'] && $project_data['check_status'] == 0) OR ($project_data['employer_id'] === $data['user']['id'] && $project_data['check_status'] == 2) OR ($project_data == NULL))
        return TRUE;
    else
        return FALSE;

}


function is_can_update_status($status) {

    $th1s = get_instance();

    /*
     * ambil user model
     * ambil get id
     * ambil tabel project dengan id
     * cek apakah bisa akses
    */

    $data['user'] = $th1s->model_user->get_user();
    $project_id = $_GET['id'];
    $project_data = $th1s->model_project->get_project_by_id($project_id);

    if ($project_data['status'] == -1 OR $project_data['status'] == 4 OR $project_data['status'] == -99)
        return FALSE;

    if (($status == 1 && $project_data['status'] == 0) OR $status == -1 OR ($status == 3 && $project_data['status'] == 2)) {
        
        if($project_data['agent_id'] === $data['user']['id'])
            return TRUE;
        else
            return FALSE;
        
    } elseif ($status == 4) {

        
        if($project_data['employer_id'] === $data['user']['id'])
            return TRUE;
        else
            return FALSE;

    } else {

        return FALSE;

    }


}


function msg_check_url() {

    $th1s = get_instance();

    $th1s->session->set_flashdata(
        'message',
        '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            <small>Uhh, something went wrong...</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>'
    );

}