<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class profile_model extends CI_Model {

    public function checkUser($blogId) {
        $this->db->where('blog_id', $blogId);
        $this->db->select('user_id');
        $this->db->from('blog');
        $query = $this->db->get();
        //print_r($query->row());die;
        if ($query->row()) {
            return $query->row()->user_id;
        } else
            return false;
    }

    public function insertIntoTable($table, $data) {
        // print_r($table);
        //  die;
        $this->db->insert($table, $data);
        return ($this->db->insert_id());
    }

    public function updateTable($table, $data, $blogId) {
        //print_r($table);die;
        $this->db->update($table, $data, $blogId);
        return (true);
    }

    public function insertValues($table, $data) {
        $this->db->insert_batch($table, $data);
        // $test = $this->db->query('Insert Into cities (citi_name) values ("Chicago"),("chi")', true,true);
        $insertData['insertId'] = $this->db->insert_id();
        $insertData['affectedRows'] = $this->db->affected_rows();

        return ($insertData);
    }

    public function insertBatch($table, $data) {
        $this->db->insert_batch($table, $data);
        return $this->db->affected_rows();
    }

    public function updateBatch($table, $data, $where) {
        $this->db->update_batch($table, $data, $where);
        return $this->db->affected_rows();
    }

    public function insertLocations($data) {
        $this->db->insert_batch('location_tags', $data);
        // $test = $this->db->query('Insert Into cities (citi_name) values ("Chicago"),("chi")', true,true);
        $insertData['insertId'] = $this->db->insert_id();
        $insertData['affectedRows'] = $this->db->affected_rows();

        return ($insertData);
    }

    public function insertLocationsIntoCitiBlog($table, $data) {
        $this->db->insert_batch($table, $data);
        return $this->db->affected_rows();
    }

    public function getSummaryData($blogId, $userId) {
        $this->db->where('blog_id', $blogId);
        $this->db->where('user_id', $userId);
        $this->db->select('blog.*,con.name as continent_name, co.name as country_name,s.* ');
        $this->db->from('blog');
        $this->db->join('continents con', "con.code = blog.continent", "left");
        $this->db->join('countries co', "co.country_id = blog.country", "left");
        $this->db->join('states s', "s.state_id = blog.state", "left");
        $query = $this->db->get();
        //print_r($query->row());die;
        return $query->row();
    }

    public function getAttractionsData($blogId, $userId) {
        $this->db->where('ba.blog_id', $blogId);
        $this->db->where('user_id', $userId);
        $this->db->select('attr_id,attr_name,attr_description');
        $this->db->from('blog_attractions ba');
        $this->db->join('blog b', 'b.blog_id = ba.blog_id');
        $this->db->join('attractions a', 'a.attractions_id = ba.attr_id', "left");
        $query = $this->db->get();
        //print_r($query->row());die;
        return $query->row();
    }

    public function getRestaurantData($blogId, $userId) {
        $this->db->where('br.blog_id', $blogId);
        $this->db->where('user_id', $userId);
        $this->db->select('br.*, r.rest_name as rest_name_name,lt.*');
        $this->db->from('blog_restaurants br');
        $this->db->join('blog b', 'b.blog_id = br.blog_id');
        $this->db->join('restaurants r', 'r.restaurants_id = br.rest_id', "left");
        $this->db->join('location_tags lt', 'lt.location_tags_id = br.location_id', "left");

        $query = $this->db->get();
        //print_r($query->row());die;
        return $query->result_array();
    }

    public function getWorstPartsData($blogId, $userId) {
        $this->db->where('bwp.blog_id', $blogId);
        $this->db->where('user_id', $userId);
        $this->db->select('bwp.*');
        $this->db->from('blog_worst_parts bwp');
        $this->db->join('blog b', 'b.blog_id = bwp.blog_id');
        // $this->db->join('cities c', 'c.citi_id = bwp.city');
        $query = $this->db->get();
        //print_r($query->row());die;
        return $query->result_array();
    }

    public function getAdviceData($blogId, $userId) {
        $this->db->where('ba.blog_id', $blogId);
        $this->db->where('user_id', $userId);
        $this->db->select('ba.*');
        $this->db->from('blog_advice ba');
        $this->db->join('blog b', 'b.blog_id = ba.blog_id');
        // $this->db->join('cities c', 'c.citi_id = bwp.city');
        $query = $this->db->get();
        //print_r($query->row());die;
        return $query->result_array();
    }

    public function getPhotosData($blogId, $userId) {
        $this->db->where('bp.blog_id', $blogId);
        $this->db->where('user_id', $userId);
        $this->db->select('bp.*');
        $this->db->from('blog_photos bp');
        $this->db->join('blog b', 'b.blog_id = bp.blog_id');
        // $this->db->join('cities c', 'c.citi_id = bwp.city');
        $query = $this->db->get();
        //print_r($query->row());die;
        return $query->result();
    }

    public function getProfileData($userId) {
        //   $this->db->where('bp.blog_id', $blogId);
        $this->db->where('id', $userId);
        $this->db->select('users.*,con.name as continent_name, co.name as country_name,s.*');
        $this->db->from('users');
        $this->db->join("continents con", "con.code=users.continent_from", "left");
        $this->db->join("countries co", "co.country_id=users.country_from", "left");
        $this->db->join("states s", "s.state_id=users.state_from", "left");
        $query = $this->db->get();
        //print_r($query->row());die;
        return $query->row();
    }

    public function getRestCities($blogId) {
        $this->db->where('br.blog_id', $blogId);
        $this->db->select('city');
        $this->db->from('blog_restaurants br');
        $this->db->join('blog b', 'b.blog_id = br.blog_id');
        $query = $this->db->get();
        //print_r($query->row());die;
        return $query->result();
    }

    public function getAttractionsLocations($blogId) {
        $this->db->where('blog_id', $blogId);
        $this->db->select('lc.location_tags_id id , location_tags_name text');
        $this->db->from('blog_attractions_locations bal');
        $this->db->join('location_tags lc', 'bal.location_tags_id = lc.location_tags_id');
        //$this->db->join('blog_attractions ba ', 'ba.blog_attractions_id =bal.blog_attractions_id');
        // $this->db->join('blog_attractions ba ', 'ba.blog_attractions_id =bal.blog_attractions_id');

        $query = $this->db->get();
        return $query->result();
    }

    public function getSummaryDataLocations($blogId) {
        $this->db->where('blog_id', $blogId);
        $this->db->select('lc.location_tags_id id , location_tags_name text');
        $this->db->from('blog_locations bl');
        $this->db->join('location_tags lc', 'bl.location_tags_id = lc.location_tags_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function getSummaryDataCities($blogId) {
        $this->db->where('blog_id', $blogId);
        $this->db->select('c.citi_id id , cities_name text');
        $this->db->from('blog_cities bc');
        $this->db->join('cities c', 'bc.cities_id = c.citi_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function deleteById($table, $blogId) {
        $this->db->where('blog_id', $blogId);
        $this->db->delete($table);
        return true;
    }

    public function deleteBlogLocationsById($blogId) {
        $this->db->where('blog_id', $blogId);
        $this->db->delete('blog_locations');
        return true;
    }

    public function getAllBLogsByUser($limit, $start, $userId, $searchstring) {

        if (isset($searchstring['title'])) {
            $this->db->like('blog_title', $searchstring['title']);
        }
        if (isset($searchstring['dates'])) {
            $this->db->like('blog_dates', $searchstring['dates']);
        }
        if (isset($searchstring['published'])) {
            $this->db->where('publish', $searchstring['published']);
        }


        $this->db->limit($limit, $start);
        $this->db->where('user_id', $userId);
        if (!empty($searchstring['blog_ids'])) {
            $this->db->where_in('blog_id', $searchstring['blog_ids']);
        }
        $this->db->select('*');
        $this->db->from('blog');
        $query = $this->db->get();
        //  die;
        return $query->result();
    }

    public function getBlogCount($userId, $searchstring) {
        if (isset($searchstring['title'])) {
            $this->db->like('blog_title', $searchstring['title']);
        }
        if (isset($searchstring['dates'])) {
            $this->db->like('blog_dates', $searchstring['dates']);
        }
        if (isset($searchstring['published'])) {
            $this->db->where('publish', $searchstring['published']);
        }
        $this->db->where('user_id', $userId);
        if (!empty($searchstring['blog_ids'])) {
            $this->db->where_in('blog_id', $searchstring['blog_ids']);
        }
        $this->db->select('count(*) as count');
        $this->db->from('blog');
        $query = $this->db->get();
        //  die;
        return $query->row()->count;
    }

    public function delete($table, $id) {
        $this->db->where('blog_photos_id', $id);

        $this->db->delete($table);
        return true;
    }

    public function deleteMultipleById($table, $ids, $columnName) {
        $this->db->where_in($columnName, $ids);
        $this->db->delete($table);
        return true;
    }

    public function getLikedBlogsByUser($userId, $searchstring) {
        if (isset($searchstring['title'])) {
            $this->db->like('blog_title', $searchstring['title']);
        }
        if (isset($searchstring['user'])) {
            $this->db->where('b.user_id', $searchstring['user']);
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
        //$this->db->where('user_id', $userId);
        if (!empty($searchstring['blog_ids'])) {
            $this->db->where_in('b.blog_id', $searchstring['blog_ids']);
        }
        $this->db->where('publish', 1);


        $this->db->where('bl.user_id', $userId);
        $this->db->select('*,co.name as country_name');
        $this->db->from('blog_likes bl');
        $this->db->join('blog b', "b.blog_id=bl.blog_id");
        $this->db->join('users u', "u.id=b.user_id");
        $this->db->join('countries co', "co.country_id=b.country", "left");
        $this->db->join('states s', "s.state_id=b.state", "left");

        $query = $this->db->get();
        return $query->result_array();
    }

    public function getLikedAttractionsByUser($userId, $searchstring) {
        if (isset($searchstring['title'])) {
            $this->db->like('attr_name', $searchstring['title']);
        }
        if (isset($searchstring['user'])) {
            $this->db->where('b.user_id', $searchstring['user']);
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
        //$this->db->where('user_id', $userId);
        if (!empty($searchstring['blog_ids'])) {
            $this->db->where_in('b.blog_id', $searchstring['blog_ids']);
        }
        $this->db->where('publish', 1);


        $this->db->where('al.user_id', $userId);
        $this->db->select('*,co.name as country_name');
        $this->db->from('attraction_likes al');
        $this->db->join('blog_attractions ba', "ba.blog_attractions_id=al.blog_attractions_id");
        $this->db->join('attractions a', "a.attractions_id = ba.attr_id");
        $this->db->join('blog b', "b.blog_id=ba.blog_id");
        $this->db->join('users u', "u.id=b.user_id");
        $this->db->join('countries co', "co.country_id=b.country", "left");
        $this->db->join('states s', "s.state_id=b.state", "left");

        $query = $this->db->get();
        //    print_r($query->result());die;
        return $query->result_array();
    }

    public function getLikedRestaurantsByUser($userId, $searchstring) {
        if (isset($searchstring['title'])) {
            $this->db->like('rest_name', $searchstring['title']);
        }
        if (isset($searchstring['user'])) {
            $this->db->where('b.user_id', $searchstring['user']);
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
        //$this->db->where('user_id', $userId);
        if (!empty($searchstring['blog_ids'])) {
            $this->db->where_in('b.blog_id', $searchstring['blog_ids']);
        }
        $this->db->where('publish', 1);


        $this->db->where('rl.user_id', $userId);
        $this->db->select('*,co.name as country_name');
        $this->db->from('restaurant_likes rl');
        $this->db->join('blog_restaurants br', "br.blog_restaurants_id=rl.blog_restaurants_id");
        $this->db->join('restaurants r', "r.restaurants_id = br.rest_id");
        $this->db->join('blog b', "b.blog_id=br.blog_id");
        $this->db->join('users u', "u.id=b.user_id");
        $this->db->join('countries co', "co.country_id=b.country", "left");
        $this->db->join('states s', "s.state_id=b.state", "left");

        $query = $this->db->get();
        // print_r($query->result());die;
        return $query->result_array();
    }

    public function getBlogsSimilarToLikedBlogs($stateId, $countryId, $userId) {
        $query = $this->db->query("CALL getBlogsSimilarToLikedBlogs($stateId,$countryId,$userId)");
        $results = $query->result();
        $query->next_result();
        $query->free_result();
        return $results;
    }

}
