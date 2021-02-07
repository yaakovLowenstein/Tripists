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

    public function getLocationTags($q,$country) {
        $this->db->select('location_tags_id as id, location_tags_name as text');
        $this->db->from('location_tags');
        if (!empty($q)) {
            $this->db->like('location_tags_name', trim($q));
        }
       // $this->db->where('country_id', $country);
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

    public function getContinents($q) {
        $this->db->select('code as id, name as text');
        $this->db->from('continents');
        if (!empty($q)) {
            $this->db->like('name', trim($q));
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
    public function getCountries($q,$continent) {
            

        $this->db->where('continent_code',$continent );
       
        $this->db->select('country_id as id, name as text');
        $this->db->from('countries');
        if (!empty($q)) {
            $this->db->like('name', trim($q));
        }
        $this->db->limit(30);
        $query = $this->db->get();


        //$this->db->select('citi_id id, citi_name text');
        // $this->db->from('cities');
        // $query =  $this->db->get();
        // print_r($query->result());die;

        return $query->result();
    }

    public function getContinentById($id) {
        $this->db->select("name");
        $this->db->from('continents');
        $this->db->where_in('code', $id);
        $query = $this->db->get();
        return $query->row()->name;
    }
     public function getCountryById($id) {
        $this->db->select("name");
        $this->db->from('countries');
        $this->db->where_in('country_id', $id);
        $query = $this->db->get();
        return $query->row()->name;
    }
    public function getCountriesByContinent($continentCode){
         $this->db->select("*");
        $this->db->from('countries');
        $this->db->where('continent_code', $continentCode);
        $query = $this->db->get();
        return $query->result();
    }
    public function getStates($q) {                
        $this->db->select('state_id as id, state_name as text');
        $this->db->from('states');
        if (!empty($q)) {
            $this->db->like('state_name', trim($q));
        }
        $query = $this->db->get();
        return $query->result();
    }
     public function getStateById($id) {
        $this->db->select("state_name");
        $this->db->from('states');
        $this->db->where('state_id', $id);
        $query = $this->db->get();
        return $query->row()->state_name;
    }
    public function getAttractions($q) {                
        $this->db->select('attractions_id as id, attr_name as text');
        $this->db->from('attractions');
        if (!empty($q)) {
            $this->db->like('attr_name', trim($q));
        }
        $query = $this->db->get();
        return $query->result();
    }
     public function getAttractionsById($id) {
        $this->db->select("attr_name");
        $this->db->from('attractions');
        $this->db->where('attractions_id', $id);
        $query = $this->db->get();
        return $query->row()->attr_name;
    }

}
