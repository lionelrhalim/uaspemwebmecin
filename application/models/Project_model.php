<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Project_model extends CI_Model{

    public function get_project($sort) {

        if($sort == 1) {
            $sort = 'project_id';
            $sort_by = 'DESC';
        }
        elseif($sort == 2) {
            $sort = 'project_name';
            $sort_by = 'ASC';
        } else {
            $sort = 'project_id';
            $sort_by = 'ASC';
        }    

        $this->db->select("*");
        $this->db->from('project');
        $this->db->join('field_category', 'field_category.id = project.field_category');
        $this->db->join('job_category', 'job_category.id = project.job_category');
        $this->db->order_by($sort, $sort_by);
        $result = $this->db->get();

        return $result->result_array();
    }

    public function get_latest_project() {
        $this->db->select("*");
        $this->db->from('project');
        $this->db->order_by('project_id', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get();

        return $result->row_array();
    }

    public function get_project_by_id($project_id) {

        $this->db->select("*");
        $this->db->from('project');
        $this->db->join('field_category', 'field_category.id = project.field_category');
        $this->db->join('job_category', 'job_category.id = project.job_category');
        $this->db->where('project_id', $project_id);
        $result = $this->db->get();

        return $result->row_array();
    }

}