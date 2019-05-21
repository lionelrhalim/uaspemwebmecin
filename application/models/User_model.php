<?php

defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model{

    public function get_user() {
        return $this->db->get_where( 'user', ['email' => $this->session->userdata('email')] )->row_array();
    }

    public function get_user_profile($sid) {

        // Selecting Columns
        $columns_user =    "user.name,
                            user.email,
                            user.image,
                            user.date_created, ";

        $columns_profile = "user_profile.user_id,
                            user_profile.phone,
                            user_profile.line,
                            user_profile.instagram,
                            user_profile.bank_id,
                            user_profile.bank_account,
                            user_profile.wallet,
                            user_profile.is_dev,";

        $columns_bank =    "bank.bank_name,
                            bank.bank_abv";

        $columns = $columns_user.$columns_profile.$columns_bank;

        // Database Query
        $query =    "SELECT $columns
                    FROM user, user_profile, bank
                    WHERE user.id = $sid AND user_profile.user_id = user.id AND bank.id = user_profile.bank_id
                    ";

        $res = $this->db->query($query)->row_array();

        return $res;
    }

    public function set_user_profile($user_id, $values, $is_complete){

        $this->db->trans_begin();
        $this->db->insert('user_profile', $values);

        $this->db->set('is_complete', $is_complete);
        $this->db->where('id', $user_id);
        $this->db->update('user');

        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            return TRUE;
        }
    }


    public function get_agent_profile($get_id) {

        // Selecting Columns
        $columns_user =    "user.name,
                            user.email,
                            user.image,
                            user.date_created, ";

        $columns_developer =   "developer_profile.* ";

        $columns = $columns_user.$columns_developer;

        // Database Query for Agent Profile
        $query =    "SELECT $columns
                    FROM user, developer_profile
                    WHERE user.id = $get_id AND developer_profile.user_id = user.id
                    ";

        $res = $this->db->query($query)->row_array();


        // Database Query for Agent Field
        $query =    "SELECT developer_access_field.*, field_category.field_category
                    FROM developer_access_field
                    JOIN field_category
                    ON field_category.id = developer_access_field.field_category_id
                    WHERE user_id = $get_id
                    ";
        $res_2 = $this->db->query($query)->result_array();

        // Database Query for Agent Job
        $query =    "SELECT developer_access_job.*, job_category.job_category
                    FROM developer_access_job
                    JOIN job_category
                    ON job_category.id = developer_access_job.job_category_id
                    WHERE user_id = $get_id
                    ";
        $res_3 = $this->db->query($query)->result_array();


        // Database Query for Agent Skill
        $query =    "SELECT developer_access_skill.*, developer_skill.skill
                    FROM developer_access_skill
                    JOIN developer_skill
                    ON developer_skill.id = developer_access_skill.developer_skill_id
                    WHERE user_id = $get_id
                    ";
        $res_4 = $this->db->query($query)->result_array();




        $result = array('profile' => $res, 'field' => $res_2, 'job' => $res_3, 'skill' => $res_4);

        return $result;
    }


    public function get_all_agent() {
        $this->db->select('user.id, user.name, user.image, developer_profile.headline, developer_profile.rating, developer_profile.starting_bid');
        $this->db->from('user');
        $this->db->join('developer_profile', 'developer_profile.user_id = user.id');
        $this->db->where('user.id >', 0);
        $result = $this->db->get()->result_array();

        return $result;
    }

    public function get_top_agent() {
        $this->db->select('user.id, user.name, user.image, developer_profile.headline, developer_profile.rating, developer_profile.starting_bid');
        $this->db->from('user');
        $this->db->join('developer_profile', 'developer_profile.user_id = user.id');
        $this->db->where('user.id >', 0);
        $this->db->order_by('4', 'DESC');
        $this->db->limit(6);
        $result = $this->db->get()->result_array();

        return $result;
    }


    public function update_wallet($user_id, $ammount) {

        $wallet_now = $this->db->select('wallet')->from('user_profile')->where('user_id', $user_id)->get()->row_array();
        $new_ammount = intval($wallet_now['wallet']) + intval($ammount);

        $this->db->trans_begin();
        $this->db->set('wallet', $new_ammount);
        $this->db->where('user_id', $user_id);
        $this->db->update('user_profile');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		} else {
			return TRUE;
		}
    }


    public function update_rating_and_job_done($user_id, $rating) {

        $data_now = $this->db->select('rating, job_complete')->from('developer_profile')->where('user_id', $user_id)->get()->row_array();
        $new_job_done = intval($data_now['job_complete']) + 1;

        if ($new_job_done == 1) {

            $new_rating = floatval ($rating);
        
        } else {
            
            $new_rating = floatval ((floatval ($data_now['rating']) + floatval ($rating)) / 2.0);

        }
        

        $this->db->trans_begin();
        $this->db->set('rating', $new_rating);
        $this->db->set('job_complete', $new_job_done);
        $this->db->where('user_id', $user_id);
        $this->db->update('developer_profile');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		} else {
			return TRUE;
		}
    }



    public function get_specific_project($project_id) {

        $this->db->select("*");
        $this->db->from('project');
        $this->db->join('field_category', 'field_category.id = project.field_category');
        $this->db->join('job_category', 'job_category.id = project.job_category');
        $this->db->where('project_id', $project_id);
        $result = $this->db->get();

        return $result->result_array();
    }

    public function update_project_status($status, $projectID) {

        $this->db->trans_begin();
        $this->db->set('status', $status);
        $this->db->where('project_id', $projectID);
        $this->db->update('project');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		} else {
			return TRUE;
		}
    }


    public function get_inbox($user_id) {

        $this->db->select("*");
        $this->db->from('inbox');
        $this->db->where('inbox.user_id', $user_id);
        $this->db->order_by('inbox_date', 'DESC');
        $result = $this->db->get();

        return $result->result_array();
    }

    public function get_unread_inbox($user_id) {

        $this->db->select("*");
        $this->db->from('inbox');
        $this->db->where('inbox.user_id', $user_id);
        $this->db->where('inbox.inbox_status', 0);
        $this->db->order_by('inbox_date', 'DESC');
        $result = $this->db->get();

        return $result->result_array();
    }

    public function set_inbox($inbox_title, $inbox_description, $project_id, $user_id, $from_id) {

        $this->db->trans_begin();
        $this->db->set('inbox_title', $inbox_title);
        $this->db->set('inbox_description', $inbox_description);
        $this->db->set('project_id', $project_id);
        $this->db->set('user_id', $user_id);
        $this->db->set('from_id', $from_id);
        $this->db->insert('inbox');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		} else {
			return TRUE;
		}
    }

    public function get_inbox_detail($user_id, $inbox_id, $project_id) {

        $this->db->select('*');
        $this->db->from('inbox');
        $this->db->join('project', 'project.project_id = inbox.project_id', 'project.field_category = inbox.user_id');
        $this->db->join('field_category', 'field_category.id = project.field_category');
        $this->db->join('job_category', 'job_category.id = project.job_category');
        $this->db->where('inbox.inbox_id', $inbox_id);
        $this->db->where('inbox.user_id', $user_id);
        $this->db->where('project.project_id', $project_id);
        $result = $this->db->get();

        return $result->result_array();
    }

    public function update_inbox_status($status, $inbox_id) {
        
        $this->db->trans_begin();
        $this->db->set('inbox_status', $status);
        $this->db->where('inbox_id', $inbox_id);
        $this->db->update('inbox');
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return FALSE;
		} else {
			return TRUE;
		}
    }

    public function get_jobs(){
        $result = $this->db->query("SELECT id, job_category FROM job_category")->result_array();
        return $result;
    }

    public function set_jobs($id, $job_id){

        $this->db->trans_begin();

        $this->db->set('user_id', $id);
        $this->db->set('job_category_id', $job_id);
        $this->db->insert('developer_access_job');
 
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            return TRUE;
        }
        
    }

    public function get_fields(){
        $result = $this->db->query("SELECT id, field_category FROM field_category")->result_array();
        return $result;
    }

    public function set_fields($id, $field_id){
        $this->db->trans_begin();
        
        $this->db->set('user_id', $id);
        $this->db->set('field_category_id', $field_id);
        $this->db->insert('developer_access_field');
 
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_skills(){
        $result = $this->db->query("SELECT id, skill FROM developer_skill")->result_array();
        return $result;
    }

    public function set_skills($id, $skill_id){
        $this->db->trans_begin();
        
        $this->db->set('user_id', $id);
        $this->db->set('developer_skill_id', $skill_id);
        $this->db->insert('developer_access_skill');
 
        $this->db->trans_complete();
        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function set_developer_profile($id, $headline, $price){



        $check_id = $this->db->get_where('developer_profile', ['user_id' => $id])->result_array();

        if(!$check_id) {

            $this->db->trans_begin();
        
            $this->db->set('user_id', $id);
            $this->db->set('headline', $headline);
            $this->db->set('starting_bid', $price);
            $this->db->set('rating', 0);
            $this->db->set('job_complete', 0);
            $this->db->insert('developer_profile');

            $this->db->set('is_dev', 1);
            $this->db->where('user_id',$id);
            $this->db->update('user_profile');

    
            $this->db->trans_complete();

            if($this->db->trans_status() === FALSE) {

                $this->db->trans_rollback();
                return FALSE;
            
            } else 
                return TRUE;

        } else {

            $this->db->trans_begin();
        
            $this->db->set('headline', $headline);
            $this->db->set('starting_bid', $price);
            $this->db->set('rating', 0);
            $this->db->where('user_id',$id);
            $this->db->update('developer_profile');

            $this->db->trans_complete();

            if($this->db->trans_status() === FALSE) {

                $this->db->trans_rollback();
                return FALSE;
            
            } else 
                return TRUE;

        }
    }

    public function activate_developer($id) {

        $this->db->set('is_dev', 1);
        $this->db->where('user_id',$id);
        $this->db->update('user_profile');
        
    }

    public function deletes($id) {

        $this->db->trans_begin();
        
        $this->db->set('is_dev', 0);
        $this->db->where('user_id',$id);
        $this->db->update('user_profile');

        $this->db->trans_complete();

        if($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();
            return FALSE;

        } else {
            return TRUE;
        }
    }

    public function is_previous_dev($id) {

        $result = $this->db->get_where('developer_profile', ['user_id' => $id])->row_array();

        if($result > 0)
            return TRUE;
        else
            return FALSE;
    }

}
