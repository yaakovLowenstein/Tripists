<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['Home'] = 'Home/index';
$route['profile'] = 'profile/index';
//$route['profile/blogs/(:num)'] = 'profile/blogsList/$1';

$route['profile/blogs'] = 'profile/blogsList';
$route['profile/blogs/add'] = 'profile/blogsAddEdit';
$route['cities'] = 'profile/getCities';
$route['location_tags'] = 'Functions/getLocationTags';
$route['users-select2'] = 'Functions/getUsersForSelect2';

$route['unset_blog_id'] = 'profile/unsetBlogId';



//*******for editing*********
$route['profile/blogs/add/overview/(:num)'] = 'profile/blogsAddEditOverview/$1';
$route['profile/blogs/add/summary/(:num)'] = 'profile/blogsAddEditSummary/$1';
$route['profile/blogs/add/attractions/(:num)'] = 'profile/blogsAddEditAttractions/$1';
$route['profile/blogs/add/restaurants/(:num)'] = 'profile/blogsAddEditRestaurants/$1';
$route['profile/blogs/restaurants/validate'] = 'profile/restaurantValidation';

$route['profile/blogs/add/best_day/(:num)'] = 'profile/blogsAddEditBestDay/$1';
$route['profile/blogs/add/worst_parts/(:num)'] = 'profile/blogsAddEditWorstParts/$1';
$route['profile/blogs/add/advice/(:num)'] = 'profile/blogsAddEditAdivce/$1';
$route['profile/blogs/add/photos/(:num)'] = 'profile/blogsAddEditPhotos/$1';
//*****for adding new************
$route['profile/blogs/add/overview'] = 'profile/blogsAddEditOverview';
$route['profile/blogs/add/summary'] = 'profile/blogsAddEditSummary';
$route['profile/blogs/add/attractions'] = 'profile/blogsAddEditAttractions';
$route['profile/blogs/add/restaurants'] = 'profile/blogsAddEditRestaurants';
$route['profile/blogs/add/best_day'] = 'profile/blogsAddEditBestDay';
$route['profile/blogs/add/worst_parts'] = 'profile/blogsAddEditWorstParts';
$route['profile/blogs/add/advice'] = 'profile/blogsAddEditAdivce';
$route['profile/blogs/add/photos'] = 'profile/blogsAddEditPhotos';
$route['profile/blogs/image/(:num)'] = 'profile/editImages/$1';

$route['publish/(:num)'] = 'profile/publish/$1';

$route['register'] = 'Auth/create_user';
$route['login'] = 'Auth/login';
$route['logout'] = 'Auth/logout';
$route['forgot_password'] = 'auth/forgot_password';
$route['change_password'] = 'auth/change_password';
$route['upload'] = 'Upload';
$route['editorImage/(:num)'] = 'profile/editorImage/$1';
$route['deleteImages'] = 'profile/deleteImages';


//*******blogs front end***************
$route['blogs'] = 'Blogs/blogsListing';
$route['blog-details/(:num)'] = 'Blogs/blogDetails/$1';
$route['blog-likes'] = 'Blogs/blogLikes';
$route['blog-messages'] = 'Blogs/blogMessages';
$route['abuse'] = 'Blogs/abuse';
$route['blog-clicked'] = 'Blogs/countClicks';
