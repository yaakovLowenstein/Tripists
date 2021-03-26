<?php $user = $this->ion_auth->user()->row(); ?>

<div class="fluid-containter" style="width: 100%">
    <div class="title-con col-md-3">
        <h2 class="title-image" style="">Liked Blogs</h2>
    </div>
    <?php require_once(APPPATH . "views/site/profile/liked/liked_header.php"); ?>

    <?php for ($i = 0; $i < sizeof($blogs); $i++) { ?>
        <div class="row top-row" >
            <div class="col-md-10 offset-md-1">                
                <div class="row ">
                    <?php
                    for ($j = 0; $j < 3; $j++) {
                        if ($i + $j < sizeof($blogs)) {
                            ?>
                            <div class="col-md-4 col-sm-12 load" style="text-align: left">
                                <a href="<?php echo base_url('blog-details/') . $blogs[$i + $j]['blog_id'] ?>">    <?php if (!empty($blogs[$i + $j]['cover_pic_path'])) { ?>
                                        <div class="image-con-cover-thumb" style="margin-bottom: 10px !important;">  
                                            <img class="blog-cover-image img-cover-thumb" src="<?php echo base_url() . $blogs[$i + $j]['cover_pic_path'] ?>">
                                        </div>
                                    <?php } else { ?> 
                                        <div class="image-con-cover-thumb" style="margin-bottom: 10px !important;"> 
                                            <img class="blog-cover-image img-cover-thumb"  src="<?php echo base_url('uploads/1/default.jpg') ?>">   
                                        </div>
                                    <?php } ?>
                                    <h4 style="color:black;display: inline"><?php echo $blogs[$i + $j]['blog_title'] ?></h4></a>  
                                <span  id="like_text" class="like " data-blog_id="<?php echo $blogs[$i + $j]['blog_id'] ?>" >Unlike</span>  

                                <h5 style="margin-top: 10px;"><strong>Destination: </strong><?php
                                    if ($blogs[$i + $j]['country'] == '230') {
                                        echo $blogs[$i + $j]['state_name'] . ", USA";
                                    } else {
                                        echo $blogs[$i + $j]['country_name']; //. ", " . $blogs[$i + $j]['continent_name'];
                                    }
                                    ?></h5>
                                <h5><strong>By: </strong><?php echo $blogs[$i + $j]['username'] ?></h5>
                                <!--<p><strong>Dates:</strong> <?php echo $blogs[$i + $j]['blog_dates'] ?></p>-->
                            </div>
                            <?php
                        }
                    }
                    $i += $j - 1;
                    ?>
                </div>           

            </div>

        </div>
    <?php }
    ?>
    <div class="offset-3 col-md-3">
        <?php
        if (sizeof($blogs) == 0) {
            if ($this->input->get('search')) {
                ?>
                <p>No Matches for your search.</p>
            <?php } else { ?>
                <p>You don't have any liked blogs.</p>

            <?php }
        }
        ?>

    </div>  


    <div class="row" style="font-size:20px;margin-bottom: 60px;">
        <div class="col-md-10 offset-md-1" style="text-align: center" >

            <div class="" align='center'>
                <p ><?php // echo $links;                ?></p>
                <?php if (sizeof($blogs) > 9) { ?>
                    <a href="#" id="loadMore">Load More</a>
<?php } ?>
            </div>

        </div>
    </div>
    <div class="row ">
        <div class="offset-1 col-md-10 ">
          <h3 style="display: inline">Because You Liked Those Blogs</h3>
<!--              <a href="<?php echo base_url() . 'blogs?user=' . $similarBlogs->id ?>" style="display: inline;float: right">See All</a>-->

            <div class="owl-carousel">
<?php foreach  ($similarBlogs as $similarBlog) { ?>
                    <div class="item">   
                        <a style="text-decoration: none;color:#47c4e1 !important" href="<?php echo base_url('blog-details/') . $similarBlog->blog_id ?>">   
                            <div class="blog-image-carousel-con">
    <?php if (!empty($similarBlog->cover_pic_path)) { ?>


                                    <img class="blog-image-carousel"  src="<?php echo base_url() . $similarBlog->cover_pic_path ?>">
    <?php } else echo '<img class="blog-image-carousel" src="' . base_url('uploads/1/default.jpg') . '">'; ?>
                            </div>           
                            <h5 ><?php echo $similarBlog->blog_title ?></h5></a>  
                    </div>


<?php } ?>
            </div>
        </div>

    </div>

</div>




</div>
<style>
    .no-js .owl-carousel, .owl-carousel.owl-loaded{
        display: inline-grid !important;
    }
    
</style>
<script>

    $(".like").on('click', function () {
        var blogId = this.getAttribute('data-blog_id');
        //       / alert(blogId);
        $.ajax({
            url: '<?php echo base_url("blog-likes") ?>',
            cache: false,
            type: 'post',
            data: {like: 0, blogId: blogId, userId: <?php echo $user->id ?>},
            datatype: 'json',
            success: function (response) {


                location.reload();
            }

        });

    });




</script>

<link rel="stylesheet" href="<?php echo base_url() . 'bower_components/' ?>owlCarousel/dist/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url() . 'bower_components/' ?>owlCarousel/dist/assets/owl.theme.default.min.css">
<script src="<?php echo base_url() . 'bower_components/' ?>owlCarousel/dist/owl.carousel.min.js"></script>
<script>
    $(document).ready(function () {
        $('.owl-carousel').owlCarousel({
            items: 5,
            loop: true,
            margin: 20,
            autoplay: true,
            autoplayTimeout: 2000,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 1,
                },
                600: {
                    items: 3,
                },
                1000: {
                    items: 5,
                }
            }
        })
    });
</script>
