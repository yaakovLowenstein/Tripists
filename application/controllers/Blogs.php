<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Blogs extends CI_Controller {

    private $user = null;

    function __construct() {
        parent::__construct();
//        if (!$this->ion_auth->logged_in()) {
//            redirect('login', 'refresh');
//        }
        $this->load->model('blogs_model');
//        $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
//        $this->user = $this->ion_auth->user()->row();
    }

    public function blogsListing() {
        $pageName = $this->uri->segment(1);
        //  print_r($page);
        if ($this->input->get('view_all')) {
            redirect($pageName, 'refresh');
            //$this->input->get('title') = '';
        }

        $query = '';
        $searchstring = array();
//         if ($this->input->get('search')!='') {
//             die;
//    }
        if (($this->input->get('orderBy') != '')) {
            //      print_r($this->input->get('orderBy'));
            //   $searchstring['title'] = $this->input->get('title');
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'orderBy=' . $this->input->get('orderBy');
        }

        if (($this->input->get('title') != '')) {
            $searchstring['title'] = $this->input->get('title');
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'title=' . $this->input->get('title');
        }
        if (($this->input->get('dates') != '')) {
            $searchstring['dates'] = $this->input->get('dates');
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'dates=' . $this->input->get('dates');
        }
        //  if (($this->input->get('published') != '--------Select----------') && ($this->input->get('published') != '')) {
        //    $searchstring['published'] = $this->input->get('published') == 'Published' ? 1 : $this->input->get('published') == 'Not Published' ? '0' : '';
        if (($this->input->get('user') != '')) {
            $searchstring['user'] = $this->input->get('user');
            $searchstring['username'] = $this->function_model->getUserById($searchstring['user']);
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'user=' . $this->input->get('user');
        }
        if (($this->input->get('continent') != '')) {
            $searchstring['continent'] = $this->input->get('continent');
            $searchstring['continent_name'] = $this->function_model->getContinentById($searchstring['continent']);
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'continent=' . $this->input->get('continent');
        }
        if (($this->input->get('country') != '')) {
            $searchstring['country'] = $this->input->get('country');
            $searchstring['country_name'] = $this->function_model->getCountryById($searchstring['country']);
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'country=' . $this->input->get('country');
        }
        if (($this->input->get('state') != '')) {
            $searchstring['state'] = $this->input->get('state');
            $searchstring['state_name'] = $this->function_model->getStateById($searchstring['state']);
            if ($query != '') {
                $query .= '&';
            }
            $query .= 'state=' . $this->input->get('state');
        }
        //   }   
        if (($this->input->get('locations') != '')) {
            $searchstring['locations'] = $this->input->get('locations');
            $searchstring['locationIds'] = $searchstring['locations'];
            foreach ($searchstring['locations'] as $id) {
                $query .= 'locations%5B%5D=' . $id . '&';
            }

            $idsArrays = $this->function_model->locationSearch($searchstring);
            $blogIds = array();
            foreach ($idsArrays as $id) {
                array_push($blogIds, $id->blog_id);
            }

            $searchstring['blog_ids'] = $blogIds;
            $searchstring['locations'] = $this->function_model->getLocationTagsId($searchstring['locations']);
        }
        $data['searchstring'] = $searchstring;

        $this->load->library('pagination');
        if ($pageName == 'blogs') {
            $count = $this->blogs_model->getPublishedBlogCount($searchstring);
            $url = 'blogs';
        } else if ($pageName == 'attractions') {
            $count = $this->blogs_model->getAttractionsCount($searchstring);
            $url = 'attractions';
        } else if ($pageName == 'restaurants') {
            $count = $this->blogs_model->getRestaurantsCount($searchstring);
            $url = 'restaruarnts';
        }

        $config['total_rows'] = $count;
        $config['per_page'] = 21;
        // $url = 'blogs';
        if (!empty($query)) {
            $url .= '?' . $query;
        }
        $config['base_url'] = base_url($url); //. 'profile/blogs' . $query;
        $config['page_query_string'] = TRUE;
        $config["uri_segment"] = 2;
        //$config["num_links"] = 3;
        $config['first_tag_open'] = '<div class="page">';
        $config['first_tag_close'] = '</div>';
        $config['last_tag_close'] = '</div>';
        $config['last_tag_open'] = '<div class="page">';
        $config['last_link'] = '>>';
        $config['first_link'] = '<<';
        $config['next_tag_open'] = '<div class="page">';
        $config['next_tag_close'] = '</div>';
        $config['prev_tag_open'] = '<div class="page">';
        $config['prev_tag_close'] = '</div>';
        $config['full_tag_open'] = '<div class="page">';
        $config['full_tag_close'] = '</div>';
        $config['num_tag_open'] = '<div class="page">';
        $config['num_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<div class="page">';
        $config['cur_tag_close'] = '</div>';

        $page = $this->input->get('per_page') ? $this->input->get('per_page') : 0;

        //   $data['getAllBLogsByUser'] = $this->profile_model->getAllBLogsByUser($config["per_page"], $page, $this->user->id, $searchstring);
        $this->pagination->initialize($config);
        $data["links"] = $this->pagination->create_links();


        //sort 
        //search
        //list all blogs with cover photo and title and author

        if (!empty($this->input->get('orderBy'))) {
            if ($this->input->get('orderBy') == 'Oldest') {
                $orderBy = 'publish_date';
                $orderByDirection = 'asc';
            } else if ($this->input->get('orderBy') == 'Newest') {
                $orderBy = 'publish_date';
                $orderByDirection = 'desc';
            } else if ($this->input->get('orderBy') == 'Most Popular') {
                $orderBy = 'clicked_count';
                if ($pageName != "blogs") {
                    $orderBy = 'mostpopular';
                    $orderByDirection = 'desc';
                }
                $orderByDirection = 'desc';
            } else if ($this->input->get('orderBy') == 'Most Liked') {
                $orderBy = 'TotalLikes';
                $orderByDirection = 'desc';
            }
        } else {
            $orderBy = 'publish_date';
            $orderByDirection = 'desc';
        }
        if ($pageName == "blogs") {
            $data['blogs'] = $this->blogs_model->getPublishedBlogsForListing($config["per_page"], $page, $searchstring, $orderBy, $orderByDirection);
            $data['main_content'] = 'site/blogs/blogs_listing.php';
            $this->load->view('lib-site/template', $data);
        } else if ($pageName == "attractions") {
            if ($orderBy == 'publish_date') {
                $orderBy = 'mostpopular';
                $orderByDirection = 'desc';
            }
            $data['getBlogAttractions'] = $this->blogs_model->getBlogAttractionsList($config["per_page"], $page, $searchstring, $orderBy, $orderByDirection);
            $blogAttractionsWithDetails = $this->blogs_model->getBlogAttractionsWithDetails();
            $prevAttrId = 0;
            //$max = 0;
            $attractionsDetailsArray = array();
            foreach ($blogAttractionsWithDetails as $row) {
                if ($prevAttrId != $row->attr_id) {
                    $max = 0;
                }
                if ($max <= $row->mostlikes) {
                    $max = $row->mostlikes;
                    unset($attractionsDetailsArray[$row->attr_id]);
                    $attractionsDetailsArray += [$row->attr_id => $row];
                }
                $prevAttrId = $row->attr_id;
            }
            $data['attractionsDetailsArray'] = $attractionsDetailsArray;
            $data['getAttractionLikes'] = $this->blogs_model->getAttractionLikes();
            $data['main_content'] = 'site/blogs/attractions.php';
            $this->load->view('lib-site/template', $data);
        } else if ($pageName == "restaurants") {
            if ($orderBy == 'publish_date') {
                $orderBy = 'mostpopular';
                $orderByDirection = 'desc';
            }
            $data['getBlogRestaurantsList'] = $this->blogs_model->getBlogRestaurantsList($config["per_page"], $page, $searchstring, $orderBy, $orderByDirection);
            $blogRestaurantsWithDetails = $this->blogs_model->getBlogRestaurantsWithDetails();
            $prevRestId = 0;
            //$max = 0;
            $restaurantsDetailsArray = array();
            foreach ($blogRestaurantsWithDetails as $row) {
                if ($prevRestId != $row->rest_id) {
                    $max = 0;
                }
                if ($max <= $row->mostlikes) {
                    $max = $row->mostlikes;
                    unset($restaurantsDetailsArray[$row->rest_id]);
                    $restaurantsDetailsArray += [$row->rest_id => $row];
                }
                $prevRestId = $row->rest_id;
            }
            $data['restaurantsDetailsArray'] = $restaurantsDetailsArray;
            $data['getRestaurantLikes'] = $this->blogs_model->getRestaurantLikes();
            $data['main_content'] = 'site/blogs/restaurants.php';
            $this->load->view('lib-site/template', $data);
        }
    }

    public function blogDetails($id) {
        //  print_r($id);die;
        // $this->load->model('profile_model');

        $allBlogDetails = $this->blogs_model->getBlogDetails($id);
        $restaurantArray = array();
        $attractiontArray = array();
        $locationArray = array();
        $photoArray = array();
        $adviceArray = array();

        foreach ($allBlogDetails as $row) {
            if ($row->blog_restaurants_id != '') {
                $restaurantArray += [$row->blog_restaurants_id => $row];
            }
            if ($row->blog_attractions_id != '') {
                $attractiontArray += [$row->blog_attractions_id => $row];
            }
            $locationArray += [$row->blog_locations_id => $row];
            if ($row->blog_photos_id != '') {
                $photoArray += [$row->blog_photos_id => $row];
            }
            if ($row->blog_advice_id != '') {
                $adviceArray += [$row->blog_advice_id => $row];
            }
        }
        // print_r(sizeof($restaurantArray));

        $data['getBlogDetails'] = $allBlogDetails[0];
        $data['getBlogAttractionsDetails'] = $attractiontArray;
        $data['getBlogAdviceDetails'] = $adviceArray;
        $data['getBlogLocationsDetails'] = $locationArray;
        $data['getBlogPhotosDetails'] = $photoArray;
        $data['getBlogRestaurnatsDetails'] = $restaurantArray;
        $data['totalLikes'] = $allBlogDetails[0]->TotalLikes;
        $data['getAllBLogsByUser'] = $this->blogs_model->getAllBLogsByUser($allBlogDetails[0]->id);
        $data['getLikedBlog'] = $this->blogs_model->getLikedBlog($id);
        $data['getCountriesByContinent'] = $this->function_model->getCountriesByContinent($allBlogDetails[0]->continent);

        $this->countClicks($id, $allBlogDetails[0]->clicked_count);

        $loArray = array();
        foreach ($data['getBlogLocationsDetails'] as $row) {
            array_push($loArray, $row->location_tags_id);
        }
        $data['getRelatedBlogs'] = $this->blogs_model->getRelatedBlogs($loArray, $id, "");
        if ($data['getRelatedBlogs'] < 3) {
            $data['getRelatedBlogs'] = $this->blogs_model->getRelatedBlogs($loArray, $id, $allBlogDetails[0]->country);
        }
        $data['main_content'] = 'site/blogs/blog_details.php';
        $this->load->view('lib-site/template', $data);
    }

    public function blogLikes() {
        $like = $this->input->post('like');
        $blogId = $this->input->post('blogId');
        $userId = $this->input->post('userId');
        $liked = false;
        if ($like == 1) {
            $insertData = array(
                'blog_id' => $blogId,
                "user_id" => $userId
            );
            $this->blogs_model->insert('blog_likes', $insertData);
            $liked = true;
        } else {
            $this->blogs_model->delete('blog_likes', $blogId, $userId);
            $liked = FALSE;
        }
        echo json_encode($liked);
    }

    public function attractionLikes() {
        $like = $this->input->post('like');
        $attractinoId = $this->input->post('attractions_id');
        $userId = $this->input->post('userId');
        $liked = false;
        if ($like == 1) {
            $insertData = array(
                'blog_attractions_id' => $attractinoId,
                "user_id" => $userId
            );
            $this->blogs_model->insert('attraction_likes', $insertData);
            $liked = true;
        } else {
            $this->blogs_model->deleteAttrLike('attraction_likes', $attractinoId, $userId);
            $liked = FALSE;
        }
        echo json_encode($liked);
    }

    public function restaurantLikes() {
        $like = $this->input->post('like');
        $restaurantsId = $this->input->post('restaurant_id');
        $userId = $this->input->post('userId');
        $liked = false;
        if ($like == 1) {
            $insertData = array(
                'blog_restaurants_id' => $restaurantsId,
                "user_id" => $userId
            );
            $this->blogs_model->insert('restaurant_likes', $insertData);
            $liked = true;
        } else {
            $this->blogs_model->deleteRestLike('restaurant_likes', $restaurantsId, $userId);
            $liked = FALSE;
        }
        echo json_encode($liked);
    }

    public function blogMessages() {

        $aboutThisBlog = $this->input->post('select');
        $message = $this->input->post('message');
        $blogId = $this->input->post('blog_id');
//   $userId = $this->input->post('userId');
        // $liked = false;
        if ($aboutThisBlog == 1) {
            $insertData = array(
                'blog_about_id' => $blogId,
                "message" => $message
            );
            $this->blogs_model->insert('blog_messages', $insertData);
            //$liked = true;
        } else {
            $insertData = array(
                'blog_about_id' => 0,
                "message" => $message
            );
            $this->blogs_model->insert('blog_messages', $insertData);
            //$liked = FALSE;
        }
        echo json_encode('$liked');
    }

    public function abuse() {

        $userId = $this->input->post('userId');
        $abuse = $this->input->post('counter');
        $blogId = $this->input->post('blog_id');
        if ($abuse == '') {
            $insertData = array(
                'blog_id' => $blogId,
                "user_id" => $userId,
            );
            $this->blogs_model->insert('blog_abuse', $insertData);
            echo json_encode($abuse);
        } else
            json_encode(false);
    }

    public function countClicks($blogId, $counter) {
//        $counter = $this->input->post('counter');
//        $blogId = $this->input->post('blog_id');

        $insertData = array(
            'clicked_count' => $counter + 1
        );
        $setWhere = array('blog_id' => $blogId);
        $this->blogs_model->updateTable('blog', $insertData, $setWhere);
    }

    public function attractions() {
        $data['getBlogAttractions'] = $this->blogs_model->getBlogAttractionsDetails();


        $data['main_content'] = 'site/blogs/attractions.php';
        $this->load->view('lib-site/template', $data);
    }

    public function attrDescriptions($attrId) {
        $data['getAttrDescriptions'] = $this->blogs_model->getAttrDescriptions($attrId);
        $data['getAttractionLikes'] = $this->blogs_model->getAttractionLikes();

        $data['main_content'] = 'site/blogs/attractions_descriptions.php';
        $this->load->view('lib-site/template', $data);
    }
    
    public function restDescriptions($restId) {
        $data['getRestDescriptions'] = $this->blogs_model->getRestDescriptions($restId);
        $data['getRestaurantLikes'] = $this->blogs_model->getRestaurantLikes();

        $data['main_content'] = 'site/blogs/restaurants_descriptions.php';
        $this->load->view('lib-site/template', $data);
    }

}
