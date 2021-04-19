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
        $this->db->select('attr_id,attr_name,attr_description,b.publish');
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
        $this->db->select('br.*, r.rest_name as rest_name_name,lt.*,b.publish');
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
        $this->db->select('ba.*,b.publish');
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
        $this->db->select('bp.*,b.publish');
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

    public function getSubscriptions($userId, $searchstring) {
        if (isset($searchstring['user'])) {
            $this->db->where('bs.blogger_id', $searchstring['user']);
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
        // $this->db->limit($limit, $start);
        //$this->db->where('user_id', $userId);
        if (!empty($searchstring['blog_ids'])) {
            $this->db->where_in('b.blog_id', $searchstring['blog_ids']);
        }
        $this->db->where("publish", 1);
        $this->db->where("bs.user_id", $userId);

        $this->db->distinct();
        $this->db->select("*");
        $this->db->from("blogger_subscribers bs");
        $this->db->join("blog b", "b.user_id = bs.blogger_id");
        $this->db->join("users u", "u.id = bs.blogger_id");

        $this->db->group_by("u.id");
        //$this->db->order_by("TotalClicks desc");

        $query = $this->db->get();
        // print_r($this->db->last_query());die;
        return $query->result_array();
    }

    public function getMessagesSubjects($limit, $start, $userId, $searchstring) {
        if (isset($searchstring['date'])) {
            $this->db->like('date_sent', $searchstring['date']);
        }
        if (isset($searchstring['from'])) {
            $this->db->like('u.username', $searchstring['from']);
        }
        if (isset($searchstring['subject'])) {
            $this->db->like('subject', $searchstring['subject']);
        }
        if (isset($searchstring['unread'])) {
            $this->db->group_start();
            $this->db->where('to_id', $userId);
            $this->db->where('is_read_by_to', 0);
            $this->db->group_end();
            $this->db->or_group_start();
            $this->db->where('from_id', $userId);
            $this->db->where('is_read_by_from', 0);
            $this->db->group_end();
        }

        $this->db->group_start();
        $this->db->where('to_id', $userId);
        $this->db->or_where('from_id', $userId);
        $this->db->group_end();
        $this->db->where('date_sent in (select max(date_sent) date from (select blog_messages.blog_messages_id,blog_messages.date_sent,if(conversation_id=0,blog_messages_id,conversation_id) as conversation_id from blog_messages ) t group by conversation_id)');

        $this->db->select("*,u.username as from_name,to.username as to_name");
        $this->db->from("blog_messages bm");
        $this->db->join("users u", "u.id = bm.from_id", 'left');
        $this->db->join("users to", "to.id = bm.to_id", 'left');
        $this->db->order_by('date_sent desc ');
        $count = $this->db->count_all_results('', false);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        //  print_r($this->db->last_query());die;
        $result['resultSet'] = $query->result();
        $result['count'] = $count;
        return $result;
    }

    public function getMessageConversations($userId, $conversationId) {
        $query = $this->db->select('b.blog_title,bm.*,u.username as from_name,to.username as to_name,u.profile_pic_path as from_pic,to.profile_pic_path as to_pic')
                ->from("blog_messages bm")
                ->where("conversation_id", $conversationId)
                ->group_start()
                ->where("to_id", $userId)
                ->or_where('from_id', $userId)
                ->group_end()
                ->or_where("blog_messages_id", $conversationId)
                ->join('users u', 'u.id=bm.from_id')
                ->join('users to', 'to.id=bm.to_id')
                ->join('blog b', 'b.blog_id=bm.blog_about_id', "left")
                ->order_by('date_sent ')
                ->get();
        // print_r($this->db->last_query());die;

        return $query->result();
    }

    public function markMessagesAsRead($table, $data, $id) {
        //print_r($table);die;
        $this->db->where('conversation_id', $id)
                ->or_where("blog_messages_id", $id)
                ->update($table, $data);
        return (true);
    }

    public function getUnreadMessagesCount($userId) {
        $query = $this->db->select('count(*) as totalUnread')
                ->from('blog_messages ')
                ->group_start()
                ->where('to_id', $userId)
                ->where('is_read_by_to', 0)
                ->group_end()
                ->or_group_start()
                ->where('from_id', $userId)
                ->where('is_read_by_from', 0)
                ->group_end()
                ->where('date_sent in (select max(date_sent) date from (select blog_messages.blog_messages_id,blog_messages.date_sent,if(conversation_id=0,blog_messages_id,conversation_id) as conversation_id from blog_messages ) t group by conversation_id)')
                ->get();
        return $query->row()->totalUnread;
        //print_r($this->db->last_query());
        //    die;
    }

    public function getTotalsForDashboard($userId) {
        $query = $this->db->query('SELECT (select count(*) as totalblogs from blog where user_id= ' . $userId . ' and publish = 1) totalBlogs,
  (select count(*) as totalLikes from blog_likes bl join blog b on b.blog_id = bl.blog_id where b.user_id=' . $userId . ') totalLikes,
  (select sum(clicked_count) as totalViews from blog  where blog.user_id=' . $userId . ') totalViews,
  (select count(*) as numSubscribers from blogger_subscribers bs  where bs.user_id=' . $userId . ') numSubscribers,
  count(*) blogsPerMonth, MONTH(publish_date) as month, Year(publish_date) year
  FROM `blog` WHERE user_id = ' . $userId . ' and publish_date is not null
  group by month,year order by year asc,month asc limit 10');

        return $query->result();
    }

    public function getTopBlogsPerUser($userId) {
        $query = $this->GetMultipleQueryResult("CALL getTopBlogsPerUser($userId)");
        //print_r($query[0][0]['blog_id']);
        //  $results = $query->result();
        //$query->next_result();
        //$query->free_result();
        return $query;


        return 1;
    }

    private function GetMultipleQueryResult($queryString) {
        if (empty($queryString)) {
            return false;
        }

        $index = 0;
        $ResultSet = array();

        /* execute multi query */
        if (mysqli_multi_query($this->db->conn_id, $queryString)) {
            while (true) {

                if (false != $result = mysqli_store_result($this->db->conn_id)) {
                    $rowID = 0;
                    while ($row = $result->fetch_assoc()) {
                        $ResultSet[$index][$rowID] = $row;
                        $rowID++;
                    }
                }
                $index++;
                if (mysqli_more_results($this->db->conn_id)) {
                    mysqli_next_result($this->db->conn_id);
                } else {
                    break;
                }
            }
        }

        return $ResultSet;
    }

    

}
