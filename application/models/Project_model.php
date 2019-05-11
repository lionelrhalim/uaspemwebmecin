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
        $result = $this->db->get()->result_array();

        /*

        'project_id' => string '22' (length=2)
        'project_name' => string 'Build Me A News Blog' (length=20)
        'field_category' => string 'Information and Technology' (length=26)
        'job_category' => string 'Website' (length=7)
        'deadline' => string '2019-05-06' (length=10)
        'bid' => string '550000' (length=6)
        'description' => string 'This blog is for updating soft news, it has 2 pages, home and about. Please design it too, the main color is blue and white.' (length=124)
        'status' => string '0' (length=1)
        'employer_id' => string '6' (length=1)
        'agent_id' => string '1' (length=1)
        'complain_description' => null
        'id' => string '2' (length=1)
        'id_field' => string '1' (length=1)

        */

        foreach ($result as $key => $value) {
            
            if($value['status'] == -99) {
                $result[$key]['status_desc'] = 'Project Canceled';
                $result[$key]['status_desc_agent'] = 'Project Canceled';
                $result[$key]['color'] = 'danger';
            }
            else if($value['status'] == -4) {
                $result[$key]['status_desc'] = 'Waiting Agent for Response';
                $result[$key]['status_desc_agent'] = 'Waiting You for Response';
                $result[$key]['color'] = 'danger';
            }
            else if($value['status'] == -1) {
                $result[$key]['status_desc'] = 'Project Refused';
                $result[$key]['status_desc_agent'] = 'Project Refused';
                $result[$key]['color'] = 'danger';
            }
            else if($value['status'] == 0) {
                $result[$key]['status_desc'] = 'Waiting Agent for Response';
                $result[$key]['status_desc_agent'] = 'Waiting You for Response';
                $result[$key]['color'] = 'dark';
            }
            elseif($value['status'] == 1) {
                $result[$key]['status_desc'] = 'Waiting You for Payment';
                $result[$key]['status_desc_agent'] = 'Waiting Employer for Payment';
                $result[$key]['color'] = 'secondary';
            }
            elseif($value['status'] == 2) {
                $result[$key]['status_desc'] = 'On Going Project';
                $result[$key]['status_desc_agent'] = 'On Going Project';
                $result[$key]['color'] = 'info';
            }
            elseif($value['status'] == 3) {
                $result[$key]['status_desc'] = 'Waiting You for Review';
                $result[$key]['status_desc_agent'] = 'Waiting Employer for Review';
                $result[$key]['color'] = 'warning';
            }
            elseif($value['status'] == 4) {
                $result[$key]['status_desc'] = 'Job Done';
                $result[$key]['status_desc_agent'] = 'Job Done';
                $result[$key]['color'] = 'success';
            }
            elseif($value['status'] == 5) {
                $result[$key]['status_desc'] = 'Your Payment is under Review';
                $result[$key]['status_desc_agent'] = 'Payment under Review';
                $result[$key]['color'] = 'primary';
            }
        }

        return $result;
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

    public function count_project() {
        $query = "SELECT status, COUNT(*) as 'total' FROM project GROUP BY status";
        $data['countProject'] = $this->db->query($query)->result_array();

        foreach ($data['countProject'] as $key => $value) {

            if($value['status'] == -99) {
                $data['countProject'][$key]['status'] = 'Canceled Project';
                $data['countProject'][$key]['color'] = 'danger';
                $data['countProject'][$key]['icon'] = 'exclamation-circle';
            }
            else if($value['status'] == -4) {
                $data['countProject'][$key]['status'] = 'Complained Project';
                $data['countProject'][$key]['color'] = 'danger';
                $data['countProject'][$key]['icon'] = 'exclamation-circle';
            }
            else if($value['status'] == -1) {
                $data['countProject'][$key]['status'] = 'Project Refused';
                $data['countProject'][$key]['color'] = 'danger';
                $data['countProject'][$key]['icon'] = 'exclamation-circle';
            }
            else if($value['status'] == 0) {
                $data['countProject'][$key]['status'] = 'Requested Project';
                $data['countProject'][$key]['color'] = 'dark';
                $data['countProject'][$key]['icon'] = 'exclamation-circle';
            }
            elseif($value['status'] == 1) {
                $data['countProject'][$key]['status'] = 'Waiting for Payment';
                $data['countProject'][$key]['color'] = 'secondary';
                $data['countProject'][$key]['icon'] = 'money-bill-wave-alt';
            }
            elseif($value['status'] == 2) {
                $data['countProject'][$key]['status'] = 'On Going Project';
                $data['countProject'][$key]['color'] = 'info';
                $data['countProject'][$key]['icon'] = 'rocket';
            }
            elseif($value['status'] == 3) {
                $data['countProject'][$key]['status'] = 'Waiting for Review';
                $data['countProject'][$key]['color'] = 'warning';
                $data['countProject'][$key]['icon'] = 'search';
            }
            elseif($value['status'] == 4) {
                $data['countProject'][$key]['status'] = 'Job Done';
                $data['countProject'][$key]['color'] = 'success';
                $data['countProject'][$key]['icon'] = 'calendar-check';
            }
            elseif($value['status'] == 5) {
                $data['countProject'][$key]['status'] = 'Payment under Review';
                $data['countProject'][$key]['color'] = 'primary';
                $data['countProject'][$key]['icon'] = 'search-dollar';
            }
        }

        return $data['countProject'];
    }

    public function cancel_project($project_id) {

        $this->db->where('project_id', $project_id);
        $this->db->update('project', ['status' => -99]);

    }

    public function add_to_cart($data) {

        $this->db->insert('cart', $data);
        $cart = $this->db->get_where('cart', ['project_name' => $data['project_name']])->row_array();

        return $cart['cart_id'];

    }
    
    public function edit_cart($cart_id, $data) {


        $this->db->where('cart_id', $cart_id);
        $this->db->update('cart', $data);

        $cart = $this->db->get_where('cart', ['project_name' => $data['project_name']])->row_array();

        return $cart['cart_id'];

    }

    public function get_from_cart($cart_id) {
        
        //$result = array();
        $result = $this->db->get_where('cart', ['cart_id' => $cart_id])->row_array();
        $employer = $this->db->select('name')->get_where('user', ['id' => $result['employer_id']])->row_array();
        $agent = $this->db->select('name, image')->get_where('user', ['id' => $result['agent_id']])->row_array();
        $agent_profile = $this->db->select('headline, rating')->get_where('developer_profile', ['user_id' => $result['agent_id']])->row_array();
        $field = $this->db->select('field_category')->get_where('field_category', ['id' => $result['field_category']])->row_array();
        $job = $this->db->select('job_category')->get_where('job_category', ['id' => $result['job_category']])->row_array();
        
        $result['employer_name'] = $employer['name'];
        $result['agent_name'] = $agent['name'];
        $result['agent_photo'] = $agent['image'];
        $result['agent_headline'] = $agent_profile['headline'];
        $result['agent_rating'] = $agent_profile['rating'];
        $result['field'] = $field['field_category'];
        $result['job'] = $job['job_category'];

        return $result;

    }

    public function post_project($data) {

        $this->db->insert('project', $data);
        $this->db->delete('cart', ['project_name' => $data['project_name']]);
    
    }

    public function get_all_cart($sort) {
        
        if($sort == 1) {
            $sort = 'cart_id';
            $sort_by = 'DESC';
        }
        elseif($sort == 2) {
            $sort = 'project_name';
            $sort_by = 'ASC';
        }
        elseif($sort == 0) {
            $sort = 'cart_id';
            $sort_by = 'ASC';
        }

        $this->db->select("*");
        $this->db->from('cart');
        $this->db->order_by($sort, $sort_by);
        $result = $this->db->get()->result_array();

        if($result){
            foreach ($result as $key => $value) {
             
                $agent = $this->db->select('name, image')->get_where('user', ['id' => $value['agent_id']])->row_array();
                $result[$key]['agent_name'] = $agent['name'];

            }
        }

        return $result;

    }

    public function delete_cart($cart_id) {

        $this->db->delete('cart', ['cart_id' => $cart_id]);

    }

}