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
        if ($this->input->get('view_all')) {
            redirect('blogs', 'refresh');
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
        //   }   
        if (($this->input->get('locations') != '')) {
            $searchstring['locations'] = $this->input->get('locations');
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

        $count = $this->blogs_model->getPublishedBlogCount($searchstring);

        $config['total_rows'] = $count;
        $config['per_page'] = 21;
        $url = 'blogs';
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
            }
            else if ($this->input->get('orderBy') == 'Most Popular') {
                $orderBy = 'clicked_count';
                $orderByDirection = 'desc';
            }
             else if ($this->input->get('orderBy') == 'Most Liked') {
                $orderBy = 'TotalLikes';
                $orderByDirection = 'desc';
            }
        } else {
            $orderBy = 'publish_date';
            $orderByDirection = 'desc';
        }
        $data['blogs'] = $this->blogs_model->getPublishedBlogsForListing($config["per_page"], $page, $searchstring, $orderBy, $orderByDirection);

        $data['main_content'] = 'site/blogs/blogs_listing.php';
        $this->load->view('lib-site/template', $data);
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

        $this->countClicks($id,$allBlogDetails[0]->clicked_count);


        $loArray = array();
        foreach ($data['getBlogLocationsDetails'] as $row) {
            array_push($loArray, $row->location_tags_id);
        }
        $data['getRelatedBlogs'] = $this->blogs_model->getRelatedBlogs($loArray, $id);

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

    public function countClicks($blogId,$counter) {
//        $counter = $this->input->post('counter');
//        $blogId = $this->input->post('blog_id');

        $insertData = array(
            'clicked_count' => $counter + 1
        );
        $setWhere = array('blog_id' => $blogId);
        $this->blogs_model->updateTable('blog', $insertData, $setWhere);
    }

}
