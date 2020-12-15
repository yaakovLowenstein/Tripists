<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class blogs_model extends CI_Model {

    public function getPublishedBlogsForListing($limit, $start, $searchstring, $orderBy, $orderByDirection) {
        if (isset($searchstring['title'])) {
            $this->db->like('blog_title', $searchstring['title']);
        }
        if (isset($searchstring['dates'])) {
            $this->db->like('blog_dates', $searchstring['dates']);
        }
        if (isset($searchstring['user'])) {
            $this->db->where('user_id', $searchstring['user']);
        }
        $this->db->limit($limit, $start);
        //$this->db->where('user_id', $userId);
        if (!empty($searchstring['blog_ids'])) {
            $this->db->where_in('blog_id', $searchstring['blog_ids']);
        }
        $this->db->where('publish', 1);
        $this->db->select('b.blog_id,blog_title,blog_dates,cover_pic_path,username,TotalLikes');
        $this->db->from('blog b');
        $this->db->join('users u', 'b.user_id=u.id');
        $this->db->join('(select count(*) as TotalLikes,blog_id  from blog_likes group by blog_id) likes', 'b.blog_id=likes.blog_id', 'left');
        $this->db->order_by($orderBy . ' ' . $orderByDirection);
        $query = $this->db->get();
        //   print_r($this->db->last_query());die;

        return $query->result_array();
    }

    public function getPublishedBlogCount($searchstring) {
        if (isset($searchstring['title'])) {
            $this->db->like('blog_title', $searchstring['title']);
        }
        if (isset($searchstring['dates'])) {
            $this->db->like('blog_dates', $searchstring['dates']);
        }
        if (isset($searchstring['user'])) {
            $this->db->where('user_id', $searchstring['user']);
        }
        $this->db->where('publish', 1);
        if (!empty($searchstring['blog_ids'])) {
            $this->db->where_in('blog_id', $searchstring['blog_ids']);
        }
        $this->db->select('count(*) as count');
        $this->db->from('blog');
        $this->db->join('users u', 'u.id = blog.user_id');

        $query = $this->db->get();
        //  die;
        return $query->row()->count;
    }

    public function getLikedBlog($blogId) {
        if (($this->ion_auth->user()->row() != null)) {
            $userId = $this->ion_auth->user()->row()->id;
        } else {
            $userId = null;
        }
        $this->db->where('bl.user_id', $userId);
        $this->db->where('bl.blog_id', $blogId);
        $this->db->select('*');
        $this->db->from('blog_likes bl');
        $query = $this->db->get();
        // print_r( $this->db->last_query());die;
        // print_r($query->result());die;
        return $query->result();
    }

    public function getBlogDetails($id) {
        $user = $this->ion_auth->user()->row();
        if (empty($user->id)) {
            $userId = 0;
        } else {
            $userId = $user->id;
        }
        // print_r($userId);die;
        $this->db->where('b.blog_id', $id);
        $this->db->select('*,b.blog_id, br.description as rest_description, br.name as rest_name,bp.description as photos_description,'
                . 'ba.name as advice_name,ba.description as advice_description');
        $this->db->from('blog b');
        $this->db->join('users u', 'b.user_id=u.id');
        $this->db->join('blog_attractions bat', 'b.blog_id=bat.blog_id', 'left');
        $this->db->join('blog_locations bl', 'b.blog_id=bl.blog_id', 'left');
        $this->db->join('location_tags lt', 'lt.location_tags_id=bl.location_tags_id', 'left');
        $this->db->join('blog_photos bp', 'b.blog_id=bp.blog_id', 'left');
        $this->db->join('blog_restaurants br', 'b.blog_id=br.blog_id', 'left');
        $this->db->join('blog_advice ba', 'b.blog_id=ba.blog_id', 'left');
        $this->db->join('(select count(*) as TotalLikes,blog_id  from blog_likes group by blog_id) likes', 'b.blog_id=likes.blog_id', 'left');
        $this->db->join('(select blog_abuse_id,blog_id bid  from blog_abuse where user_id=' . $userId . ' and blog_id=' . $id . ')abuse', 'b.blog_id=abuse.bid', 'left');


//  $this->db->where('bl.user_id', $userId);
        // $this->db->join('blog_likes bl', 'u.id = bl.user_id', 'left');
        $query = $this->db->get();
        //   print_r( $this->db->last_query());die;
        //  print_r($query->result_array()); die;
        return $query->result();
    }

    public function getBlogAttractionsDetails($id) {
        $this->db->where('b.blog_id', $id);
        $this->db->select('*');
        $this->db->from('blog b');
        $this->db->join('blog_attractions bat', 'b.blog_id=bat.blog_id');
        $query = $this->db->get();
        //    print_r( $this->db->last_query());die;
        //  print_r($query->result());die;
        return $query->result();
    }

    public function getBlogAdviceDetails($id) {
        $this->db->where('b.blog_id', $id);
        $this->db->select('*');
        $this->db->from('blog b');
        $this->db->join('blog_advice ba', 'b.blog_id=ba.blog_id');
        $query = $this->db->get();
        //    print_r( $this->db->last_query());die;
        //   print_r($query->result());die;
        return $query->result();
    }

    public function getBlogLocationsDetails($id) {
        $this->db->where('b.blog_id', $id);
        $this->db->select('*');
        $this->db->from('blog b');
        $this->db->join('blog_locations bl', 'b.blog_id=bl.blog_id');
        $this->db->join('location_tags lt', 'lt.location_tags_id=bl.location_tags_id');
        $query = $this->db->get();
        //    print_r( $this->db->last_query());die;
        //   print_r($query->result());die;
        return $query->result();
    }

    public function getBlogPhotosDetails($id) {
        $this->db->where('b.blog_id', $id);
        $this->db->select('*');
        $this->db->from('blog b');
        $this->db->join('blog_photos bp', 'b.blog_id=bp.blog_id');
        $query = $this->db->get();
        //    print_r( $this->db->last_query());die;
        //   print_r($query->result());die;
        return $query->result();
    }

    public function getBlogRestaurnatsDetails($id) {
        $this->db->where('b.blog_id', $id);
        $this->db->select('*');
        $this->db->from('blog b');
        $this->db->join('blog_restaurants br', 'b.blog_id=br.blog_id');
        $query = $this->db->get();
        //    print_r( $this->db->last_query());die;
        //   print_r($query->result());die;
        return $query->result();
    }

    public function getAllBLogsByUser($userId) {
        $this->db->where('user_id', $userId);
        $this->db->select('*');
        $this->db->from('blog');
        $this->db->order_by('blog_id', 'RANDOM');


        $query = $this->db->get();
        //  die;
        return $query->result();
    }

    public function getRelatedBlogs($locationIds, $id) {
        $this->db->where_in('location_tags_id', $locationIds);
        $this->db->where('b.blog_id !=' . $id);
        $this->db->select('*');
        $this->db->from('blog b');
        $this->db->join('blog_locations bl', 'b.blog_id=bl.blog_id');
        $this->db->join('users u', 'u.id=b.user_id');

        $this->db->order_by('blog_id', 'RANDOM');

        $query = $this->db->get();
        //  print_r($this->db->last_query());die;        
        return $query->result();
    }

    public function insert($table, $data) {
        $this->db->insert($table, $data);
        return $this->db->affected_rows();
    }

    public function updateTable($table, $data, $blogId) {
        //print_r($table);die;
        $this->db->update($table, $data, $blogId);
        return (true);
    }

    public function delete($table, $blogId, $userId) {
        $this->db->where('blog_id', $blogId);
        $this->db->where('user_id', $userId);
        $this->db->delete($table);
        return true;
    }

    public function getBlogLikes($id) {
        $this->db->where('b.blog_id', $id);
        $this->db->select('count(*) as count');
        $this->db->from('blog b');
        $this->db->join('blog_likes bl', 'b.blog_id=bl.blog_id');
        $query = $this->db->get();
        //  print_r($this->db->last_query());die;        
        return $query->row();
    }

}
