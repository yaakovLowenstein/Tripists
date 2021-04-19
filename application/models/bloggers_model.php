<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class bloggers_model extends CI_Model {

    public function getBloggers($limit, $start, $searchstring) {

        if (isset($searchstring['user'])) {
            $this->db->where('user_id', $searchstring['user']);
        }
        if (isset($searchstring['state'])) {
            $this->db->where('state', $searchstring['state']);
        }
        if (isset($searchstring['country'])) {
            $this->db->where('country', $searchstring['country']);
        }
        if (isset($searchstring['continent'])) {
            $this->db->where('continent', $searchstring['continent']);
        }
        $this->db->limit($limit, $start);
        //$this->db->where('user_id', $userId);
        if (!empty($searchstring['blog_ids'])) {
            $this->db->where_in('b.blog_id', $searchstring['blog_ids']);
        }
        $this->db->where("publish", 1);
        $this->db->distinct();
        $this->db->select("u.*,sum(clicked_count) as TotalClicks");
        $this->db->from("users u");
        $this->db->join("blog b", "b.user_id = u.id");
        $this->db->group_by("u.id");
        $this->db->order_by("TotalClicks desc");

        $query = $this->db->get();
        // print_r($this->db->last_query());die;
        return $query->result_array();
    }

    public function getBloggersCount($searchstring) {
        $this->db->distinct();

        if (isset($searchstring['user'])) {
            $this->db->where('user_id', $searchstring['user']);
        }
        if (isset($searchstring['state'])) {
            $this->db->where('state', $searchstring['state']);
        }
        if (isset($searchstring['country'])) {
            $this->db->where('country', $searchstring['country']);
        }
        if (isset($searchstring['continent'])) {
            $this->db->where('continent', $searchstring['continent']);
        }
        $this->db->where('publish', 1);
        if (!empty($searchstring['blog_ids'])) {
            $this->db->where_in('blog_id', $searchstring['blog_ids']);
        }
        $this->db->select('u.*');
        $this->db->from('blog');
        $this->db->join('users u', 'u.id = blog.user_id');

        $query = $this->db->get();
        //  die;
        return $query->num_rows();
    }

    public function getBloggersDetailsById($userId) {
        $user = $this->ion_auth->user()->row();
        $loggedinUser = !empty($user->id) ? $user->id : -1;
        //print_r($loggedinUser);die;
        $this->db->distinct();
        $this->db->where('u.id', $userId);
        $this->db->where('publish', 1);
        $this->db->select("*,con.name as continent_name, co.name as country_name,u.name as full_name");
        $this->db->from("users u");
        $this->db->join("blog b", "b.user_id = u.id");
        $this->db->join("continents con", "con.code = u.continent_from", "left");
        $this->db->join("countries co", "co.country_id = u.country_from", "left");
        $this->db->join("states s", "s.state_id = u.state_from", "left");
        $this->db->join("(select bs.user_id as loggedinUser, bs.blogger_id from users u join blogger_subscribers bs on bs.user_id =$loggedinUser ) subscriber ", "subscriber.blogger_id = u.id", "left");

        $this->db->order_by("publish_date");
        $query = $this->db->get();
        //   print_r($this->db->last_query());
        //print_r($query->result());die;
        return $query->result();
    }

    public function delete($table, $bloggerId, $userId) {
        $this->db->where('blogger_id', $bloggerId);
        $this->db->where('user_id', $userId);
        $this->db->delete($table);
        return true;
    }

}
