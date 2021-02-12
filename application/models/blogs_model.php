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
        $this->db->where('publish', 1);
        $this->db->select('b.blog_id,blog_title,blog_dates,cover_pic_path,username,TotalLikes,continent,country,con.name as continent_name, co.name as country_name,s.*');
        $this->db->from('blog b');
        $this->db->join('users u', 'b.user_id=u.id');
        $this->db->join('continents con', 'b.continent=con.code', 'left');
        $this->db->join('countries co', 'b.country=co.country_id', 'left');
        $this->db->join('states s', 'b.state=s.state_id', 'left');

        $this->db->join('(select count(*) as TotalLikes,blog_id  from blog_likes group by blog_id) likes', 'b.blog_id=likes.blog_id', 'left');
        $this->db->order_by($orderBy . ' ' . $orderByDirection);
        $query = $this->db->get();
        // print_r($this->db->last_query());die;

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
                . 'ba.name as advice_name,ba.description as advice_description,con.name as continent_name, co.name as country_name,co.code as country_code,s.*,IFNULL(likes.TotalLikes, 0)as TotalLikes');
        $this->db->from('blog b');
        $this->db->join('users u', 'b.user_id=u.id');
        $this->db->join('continents con', 'b.continent=con.code', 'left');
        $this->db->join('countries co', 'b.country=co.country_id', 'left');
        $this->db->join('states s', 'b.state=s.state_id', 'left');
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

//    public function getBlogAttractionsList($limit, $start, $searchstring, $orderBy, $orderByDirection) {
//        if (isset($searchstring['title'])) {
//            $this->db->like('attr_name', $searchstring['title']);
//        }
////        if (isset($searchstring['dates'])) {
////            $this->db->like('blog_dates', $searchstring['dates']);
////        }
//        if (isset($searchstring['user'])) {
//            $this->db->where('user_id', $searchstring['user']);
//        }
//        if (isset($searchstring['state'])) {
//            $this->db->where('state', $searchstring['state']);
//        }
//        if (isset($searchstring['country'])) {
//            $this->db->where('country', $searchstring['country']);
//        }
//        if (isset($searchstring['continent'])) {
//            $this->db->where('continent', $searchstring['continent']);
//        }
//        //$this->db->where('user_id', $userId);
//        if (!empty($searchstring['blog_ids'])) {
//            $this->db->where_in('b.blog_id', $searchstring['blog_ids']);
//        }
//        $this->db->where('publish', 1);
//        $this->db->select("bat.attr_id,IFNULL(max(totallikes),0"
//                . ") blogWithmostLikes,sum(totallikes) totalLikesFromAllBlogs");
//        $this->db->from("blog_attractions bat");
//        $this->db->join("(select count(*) as TotalLikes,blog_attractions_id from attraction_likes group by blog_attractions_id) likes", "bat.blog_attractions_id=likes.blog_attractions_id", "left");
//        $this->db->join('blog b', 'b.blog_id=bat.blog_id', "left");
//        $this->db->join('users u', 'b.user_id=u.id', "left");
//        $this->db->join('blog_attractions_locations bal', 'bal.blog_id=b.blog_id', "left");
//        $this->db->join('location_tags lt', 'lt.location_tags_id=bal.location_tags_id', "left");
//        $this->db->join('continents con', 'b.continent=con.code', 'left');
//        $this->db->join('countries co', 'b.country=co.country_id', 'left');
//        $this->db->join('states s', 'b.state=s.state_id', 'left');
//        $this->db->group_by("attr_id");
//        $subQuery1 = $this->db->get_compiled_select();
//
//        //query2
//        $this->db->distinct();
//        $this->db->select("a.*,t.*, ifnull(blogWithmostLikes,0) mostLikes ");
//        $this->db->from("attractions a");
//        $this->db->join("blog_attractions ba", "ba.attr_id = a.attractions_id ");
//
//        $this->db->join("($subQuery1) t", "t.attr_id = a.attractions_id ");
//        $subQuery2 = $this->db->get_compiled_select();
//
//        //query3
//        $this->db->limit($limit, $start);
//        $query = $this->db->query("SELECT `t2`.*, `ba2`.`attr_description`, `ba2`.`blog_attractions_id`, `ba2`.blog_id, u.username,b.*,lt.location_tags_name 
//                    FROM (" . $subQuery2 . ")t2  join blog_attractions ba2 on ba2.attr_id = t2.attractions_id "
//                . " left join (select IFNULL(count(*),0) as TotalLikes,blog_attractions_id from attraction_likes group by blog_attractions_id)likes on likes.blog_attractions_id=ba2.blog_attractions_id "
//                . "left join blog b on b.blog_id = ba2.blog_id "
//                . "left join users u on u.id = b.user_id "
//                . "left join blog_attractions_locations bal on bal.blog_id=b.blog_id "
//                . "left join location_tags lt on lt.location_tags_id=bal.location_tags_id " 
//                . " where t2.blogWithmostLikes = totallikes  or mostlikes=0  limit " . $start . ", " . $limit);
//        //$this->db->where("t2.blogWithmostLikes", "totallikes");
//        //$this->db->select("t2.*,ba2.attr_description,ba2.blog_attractions_id,ba2.blog_id ");
//        // $this->db->from("$subQuery2 t2");
//        // $this->db->join("(  select count(*) as TotalLikes,blog_attractions_id from attraction_likes group by blog_attractions_id)likes", "ba2.blog_attractions_id=likes.blog_attractions_id", "left");
////        $this->db->where('publish', 1);
////        $this->db->select('ba.*,u.username,lt.location_tags_name,b.blog_title,IFNULL(likes.TotalLikes, 0) as TotalLikes,a.*');
////        $this->db->from('blog_attractions ba');
////        $this->db->join('blog b', 'b.blog_id=ba.blog_id', "left");
////        $this->db->join('users u', 'b.user_id=u.id', "left");
////        $this->db->join('blog_attractions_locations bal', 'bal.blog_id=b.blog_id', "left");
////        $this->db->join('location_tags lt', 'lt.location_tags_id=bal.location_tags_id', "left");
////        $this->db->join('continents con', 'b.continent=con.code', 'left');
////        $this->db->join('countries co', 'b.country=co.country_id', 'left');
////        $this->db->join('states s', 'b.state=s.state_id', 'left');
////        $this->db->join('attractions a', 'a.attractions_id=ba.attr_id', 'left');
////
////        $this->db->join('(select count(*) as TotalLikes,blog_attractions_id  from attraction_likes group by blog_attractions_id) likes', 'ba.blog_attractions_id=likes.blog_attractions_id', 'left');
////        $this->db->order_by($orderBy . ' ' . $orderByDirection);
//        //$query = $this->db->get();
//        ;
//
////       / print_r($query->result());die;
//        //print_r($this->db->last_query());
//        //     die;
//
//        return $query->result();
//    }

    public function getBlogAttractionsList($limit, $start, $searchstring, $orderBy, $orderByDirection) {
        if (isset($searchstring['title'])) {
            $this->db->like('attr_name', $searchstring['title']);
        }
//        if (isset($searchstring['dates'])) {
//            $this->db->like('blog_dates', $searchstring['dates']);
//        }
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
        //$this->db->where('user_id', $userId);
        if (!empty($searchstring['blog_ids'])) {
            $this->db->where_in('b.blog_id', $searchstring['blog_ids']);
        }

        $this->db->where('publish', 1);
        $this->db->distinct();
        $this->db->select('a.*,ifnull(totallikes,0) totallikes');
        $this->db->from('blog_attractions ba');
        $this->db->join('attractions a', 'a.attractions_id = ba.attr_id');
        $this->db->join('blog b', 'b.blog_id=ba.blog_id', "left");
        $this->db->join('users u', 'b.user_id=u.id', "left");
        $this->db->join('blog_attractions_locations bal', 'bal.blog_id=b.blog_id', "left");
        $this->db->join('location_tags lt', 'lt.location_tags_id=bal.location_tags_id', "left");
        $this->db->join('continents con', 'b.continent=con.code', 'left');
        $this->db->join('countries co', 'b.country=co.country_id', 'left');
        $this->db->join('states s', 'b.state=s.state_id', 'left');
        //$this->db->join('attractions a', 'a.attractions_id=ba.attr_id', 'left');

        $this->db->join('( SELECT COUNT(*) AS TotalLikes, attr_id FROM attraction_likes al join blog_attractions ba2 on ba2.blog_attractions_id = al.blog_attractions_id group by attr_id) likes', 'ba.attr_id=likes.attr_id', 'left');
        $this->db->order_by($orderBy . ' ' . $orderByDirection);
        $this->db->limit($limit, $start);
        $query = $this->db->get();


//       / print_r($query->result());die;
        //print_r($this->db->last_query());
        //     die;

        return $query->result();
    }

    public function getBlogAttractionsWithDetails() {
        $this->db->select("a.*,ba.*,  ifnull(totallikes,0)mostlikes,b.*,u.username,lt.location_tags_name");
        $this->db->from("attractions a");
        $this->db->join("blog_attractions ba", "ba.attr_id= a.attractions_id");
        $this->db->join("blog b", "b.blog_id= ba.blog_id");
         $this->db->join('blog_attractions_locations bal', 'bal.blog_id=ba.blog_id', "left");
        $this->db->join('location_tags lt', 'lt.location_tags_id=bal.location_tags_id', "left");
        $this->db->join("users u", "b.user_id= u.id");
        $this->db->join('(select count(*) as TotalLikes,blog_attractions_id  from attraction_likes group by blog_attractions_id) likes', 'ba.blog_attractions_id=likes.blog_attractions_id', 'left');
        $this->db->order_by("attractions_id");
        $query = $this->db->get();
//      /    print_r($this->db->last_query());die;

        return $query->result();
    }

    public function getAttractionsCount($searchstring) {
        if (isset($searchstring['title'])) {
            $this->db->like('attr_name', $searchstring['title']);
        }
//        if (isset($searchstring['dates'])) {
//            $this->db->like('blog_dates', $searchstring['dates']);
//        }
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
        //$this->db->where('user_id', $userId);
        if (!empty($searchstring['blog_ids'])) {
            $this->db->where_in('b.blog_id', $searchstring['blog_ids']);
        }
        $this->db->where('publish', 1);
        $this->db->select("attractions_id");
        $this->db->from("blog_attractions bat");
        $this->db->join("attractions a", "a.attractions_id=bat.attr_id");
        //  $this->db->join("(select count(*) as TotalLikes,blog_attractions_id from attraction_likes group by blog_attractions_id) likes", "bat.blog_attractions_id=likes.blog_attractions_id", "left");
        $this->db->join('blog b', 'b.blog_id=bat.blog_id', "left");
        $this->db->join('users u', 'b.user_id=u.id', "left");
        $this->db->join('blog_attractions_locations bal', 'bal.blog_id=b.blog_id', "left");
        $this->db->join('location_tags lt', 'lt.location_tags_id=bal.location_tags_id', "left");
        $this->db->join('continents con', 'b.continent=con.code', 'left');
        $this->db->join('countries co', 'b.country=co.country_id', 'left');
        $this->db->join('states s', 'b.state=s.state_id', 'left');
        $this->db->group_by("attr_id");
        // $subQuery1 = $this->db->get_compiled_select();
        //query2
        //  $this->db->distinct();
        //   $this->db->select("count(*) count");
        //  $this->db->from("attractions a");
        //  $this->db->join("blog_attractions ba", "ba.attr_id = a.attractions_id ");
        //   $this->db->join("($subQuery1) t", "t.attr_id = a.attractions_id ");
        //  $this->db->group_by("attractions_id");
        $query = $this->db->get();
        //$subQuery2 = $this->db->get_compiled_select();
        //print_r($this->db->last_query());
        //  print_r($query->num_rows());

        return $query->num_rows();
    }

    public function getBlogRestaurantsList($limit, $start, $searchstring, $orderBy, $orderByDirection) {
        if (isset($searchstring['title'])) {
            $this->db->like('attr_name', $searchstring['title']);
        }
//        if (isset($searchstring['dates'])) {
//            $this->db->like('blog_dates', $searchstring['dates']);
//        }
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
        $this->db->where('publish', 1);
        $this->db->select('br.*,u.username,b.blog_title,IFNULL(likes.TotalLikes, 0) as TotalLikes'); //IFNULL(likes.TotalLikes, 0) as TotalLikes
        $this->db->from('blog_restaurants br');
        $this->db->join('blog b', 'b.blog_id=br.blog_id', "left");
        $this->db->join('users u', 'b.user_id=u.id', "left");
        // $this->db->join('blog_locations bl', 'b.blog_id=bl.blog_id', 'left');
        //$this->db->join('blog_attractions_locations bal', 'bal.blog_id=b.blog_id',"left");
        //   $this->db->join('location_tags lt', 'lt.location_tags_id=bl.location_tags_id', "left");
        $this->db->join('continents con', 'b.continent=con.code', 'left');
        $this->db->join('countries co', 'b.country=co.country_id', 'left');
        $this->db->join('states s', 'b.state=s.state_id', 'left');

        $this->db->join('(select count(*) as TotalLikes,blog_restaurants_id  from restaurant_likes group by blog_restaurants_id) likes', 'br.blog_restaurants_id=likes.blog_restaurants_id', 'left');
        $this->db->order_by($orderBy . ' ' . $orderByDirection);
        $query = $this->db->get();
//       / print_r($query->result());die;
        //   print_r($this->db->last_query());die;

        return $query->result();
    }

    public function getRestaurantsCount($searchstring) {
        if (isset($searchstring['title'])) {
            $this->db->like('blog_title', $searchstring['title']);
        }
        if (isset($searchstring['dates'])) {
            $this->db->like('blog_dates', $searchstring['dates']);
        }
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
            $this->db->where_in('b.blog_id', $searchstring['blog_ids']);
        }
        $this->db->select('count(*) as count');
        $this->db->from('blog_restaurants br');
        $this->db->join('blog b', 'b.blog_id=br.blog_id');
        $this->db->join('users u', 'u.id = b.user_id');

        $query = $this->db->get();
        //  die;
        return $query->row()->count;
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

    public function getRelatedBlogs($locationIds, $id, $countryId) {
        if (isset($countryId) && $countryId != '') {
            $this->db->where('country' . $countryId);
        } else {
            $this->db->where_in('location_tags_id', $locationIds);
        }
        $this->db->where('b.blog_id !=' . $id);
        $this->db->select('*');
        $this->db->from('blog b');
        $this->db->join('blog_locations bl', 'b.blog_id=bl.blog_id');
        $this->db->join('users u', 'u.id=b.user_id');
        // $this->db->join('countries co', 'co.country_id = b.country');
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

    public function deleteAttrLike($table, $blogId, $userId) {
        $this->db->where('blog_attractions_id', $blogId);
        $this->db->where('user_id', $userId);
        $this->db->delete($table);
        return true;
    }

    public function deleteRestLike($table, $blogId, $userId) {
        $this->db->where('blog_restaurants_id', $blogId);
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

    public function getAttractionLikes() {
        if (($this->ion_auth->user()->row() != null)) {
            $userId = $this->ion_auth->user()->row()->id;
        } else {
            $userId = null;
        }
        // $this->db->where('b.blog_id',$userId);
        $this->db->where('user_id', $userId);
        $this->db->select('*');
        $this->db->from('attraction_likes');
        //  $this->db->join('blog_likes bl', 'b.blog_id=bl.blog_id');
        $query = $this->db->get();
        //  print_r($this->db->last_query());die;        
        return $query->result();
    }

    public function getRestaurantLikes() {
        if (($this->ion_auth->user()->row() != null)) {
            $userId = $this->ion_auth->user()->row()->id;
        } else {
            $userId = null;
        }
        // $this->db->where('b.blog_id',$userId);
        $this->db->where('user_id', $userId);
        $this->db->select('*');
        $this->db->from('restaurant_likes');
        //  $this->db->join('blog_likes bl', 'b.blog_id=bl.blog_id');
        $query = $this->db->get();
        //  print_r($this->db->last_query());die;        
        return $query->result();
    }

}
