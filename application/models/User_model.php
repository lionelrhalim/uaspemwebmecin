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
                            user_profile.is_dev, ";

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
}
