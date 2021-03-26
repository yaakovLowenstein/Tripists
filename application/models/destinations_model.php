<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class destinations_model extends CI_Model {

    public function getBlogCountries() {
        $this->db->where('publish', 1);
        $this->db->select("co.*,con.name as continent_name,s.*,b.state", "distinct");
        $this->db->from("blog b");
        $this->db->join("countries co", "co.country_id=b.country");
        $this->db->join("continents con", "co.continent_code=con.code");
        $this->db->join("states s", "s.state_id=b.state", 'left');

        $this->db->order_by("continent_code,name");

        $query = $this->db->get();
        return $query->result();
    }

    public function getBlogCountriesWithoutStates() {
        $this->db->where('publish', 1);

        $this->db->distinct();
        $this->db->select("co.*,con.name as continent_name,");
        $this->db->from("blog b");
        $this->db->join("countries co", "co.country_id=b.country");
        $this->db->join("continents con", "co.continent_code=con.code");
        $this->db->order_by("continent_code,name");

        $query = $this->db->get();

        return $query->result();
    }

    public function getBlogsInUSA() {
        $this->db->distinct();
        $this->db->where("state!=0");
        $this->db->where('publish', 1);
        $this->db->select("s.*");
        $this->db->from("blog b");
        $this->db->join("states s", "s.state_id=b.state", 'left');

        $query = $this->db->get();
            //    print_r($this->db->last_query());die;

        return $query->result();
    }

}
