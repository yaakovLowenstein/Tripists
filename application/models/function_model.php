<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class function_model extends CI_Model {

    public function getCities($q) {
        $this->db->select('citi_id as id, cities_name as text');
        $this->db->from('cities');
        if (!empty($q)) {
            $this->db->like('cities_name', trim($q));
        }
        //$this->db->where('customers.status_flag', '1');
        $this->db->limit(30);
        $query = $this->db->get();


        //$this->db->select('citi_id id, citi_name text');
        // $this->db->from('cities');
        // $query =  $this->db->get();
        // print_r($query->result());die;

        return $query->result();
    }

    public function getCityID($ids) {
        $this->db->select('citi_id id, cities_name text');
        $this->db->from('cities');
        $this->db->where_in('citi_id', $ids);
        $query = $this->db->get();
        return $query->result();
    }

    public function getLocationTags($q) {
        $this->db->select('location_tags_id as id, location_tags_name as text');
        $this->db->from('location_tags');
        if (!empty($q)) {
            $this->db->like('location_tags_name', trim($q));
        }
        //$this->db->where('customers.status_flag', '1');
        $this->db->limit(30);
        $query = $this->db->get();


        //$this->db->select('citi_id id, citi_name text');
        // $this->db->from('cities');
        // $query =  $this->db->get();
        // print_r($query->result());die;

        return $query->result();
    }

    public function getLocationTagsId($ids) {
        $this->db->select('location_tags_id id, location_tags_name text');
        $this->db->from('location_tags');
        $this->db->where_in('location_tags_id', $ids);
        $query = $this->db->get();
        return $query->result();
    }

    public function getPublished($blogId) {
        //  echo "dfd";
        $this->db->where('blog_id', $blogId);
        $this->db->select('publish');
        $this->db->from('blog');
        $query = $this->db->get();
        //  print_r($query->row('publish'));die;
        return $query->row('publish');
    }

    public function locationSearch($searchstring) {

        $this->db->where_in('location_tags_id', $searchstring['locations']); //$searchstring['published']);
        $this->db->select('blog_id,location_tags_id');
        $this->db->from('blog_locations');
        $query = $this->db->get();
        $ids = $query->result();
        return $ids;
    }

    public function getUsersForSelect($q) {
        $this->db->distinct();
        $this->db->select('id as id, username as text');
        $this->db->from('users');
        if (!empty($q)) {
            $this->db->like('username', trim($q));
        }
        //$this->db->where('customers.status_flag', '1');
        $this->db->where('publish', 1);
        $this->db->join('blog b', 'b.user_id = users.id');

        $this->db->limit(30);
        $query = $this->db->get();
        return $query->result();
    }

    public function getUserById($id) {
       
        $this->db->select('username');
        $this->db->from('users');   
       
        //$this->db->where('customers.status_flag', '1');
        $this->db->where('id', $id);

        $query = $this->db->get();
        return $query->row()->username;
    }

}
