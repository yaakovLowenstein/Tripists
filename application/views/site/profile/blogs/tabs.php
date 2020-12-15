<?php
$uri4 = $this->uri->segment(4);

//if ($this->session->userdata('blog_id')){
//    $blogId = $this->session->userdata('blog_id');
//    //print_r($blogId);die;
//}
//else {$blogId = null;}

if (!isset($blogId) ) {
$blogId = $this->uri->segment(5);}
//} else {
//    $blogId = $this->uri->segment(5);
//
//}
?>

<div class="container tabs-container" >
    <ul class="nav nav-tabs tabs">
        <li class=" nav-item" ><a class="nav-link <?php if ($uri4 == 'overview') { ?> active<?php } ?>"  href="<?php  echo base_url('profile/blogs/add/overview/'). $blogId ?>">Overview</a></li>
        <li class=" nav-item" ><a class="nav-link <?php if ($uri4 == 'summary') { ?> active<?php } ?>"  href="<?php echo base_url('profile/blogs/add/summary/') . $blogId ?>">summary</a></li>
        <li class=" nav-item" ><a class="nav-link <?php if ($uri4 == 'attractions') { ?> active<?php } ?>"  href="<?php echo base_url('profile/blogs/add/attractions/') . $blogId ?>">Attractions</a></li>
        <li class=" nav-item" ><a class="nav-link <?php if ($uri4 == 'restaurants') { ?> active<?php } ?>"  href="<?php echo base_url('profile/blogs/add/restaurants/') . $blogId ?>">Restaurants</a></li>
        <li class=" nav-item" ><a class="nav-link <?php if ($uri4 == 'best_day') { ?> active<?php } ?>"  href="<?php echo base_url('profile/blogs/add/best_day/') . $blogId ?>">Best Day</a></li>
        <!--<li class=" nav-item" ><a class="nav-link <?php if ($uri4 == 'worst_parts') { ?> active<?php } ?>"  href="<?php echo base_url('profile/blogs/add/worst_parts/') . $blogId ?>">Worst Parts</a></li>-->
        <li class=" nav-item" ><a class="nav-link <?php if ($uri4 == 'advice') { ?> active<?php } ?>"  href="<?php echo base_url('profile/blogs/add/advice/') . $blogId ?>">Advice</a></li>
        <li class=" nav-item" ><a class="nav-link <?php if ($uri4 == 'photos') { ?> active<?php } ?>"  href="<?php echo base_url('profile/blogs/add/photos/') . $blogId ?>">Photos</a></li>

    </ul>
</div>
