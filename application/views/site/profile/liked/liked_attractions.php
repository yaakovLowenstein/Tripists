<?php $user = $this->ion_auth->user()->row(); ?>

<div class="fluid-containter" style="width: 100%">
    <div class="title-con col-md-3">
        <h2 class="title-image" style="">Liked Attractions</h2>
    </div>
    <?php require_once(APPPATH . "views/site/profile/liked/liked_header.php"); ?>

    <?php for ($i = 0; $i < sizeof($blogs); $i++) { ?>
        <div class="row top-row " >
            <div class="col-md-10 offset-md-1" >                
                <div class="row ">
                    <div class="col-md-12 load">

                        <?php
//                    $prevAttrIndex = $i-1;
//                    if($prevAttrIndex<1){
//                        $prevAttrIndex=0;
//                    }
                        if ($i == 0 || $blogs[$i]['attr_id'] != $blogs[$i - 1]['attr_id']) {
                            ?>
                            <h3 style="float: left"><?php echo $blogs[$i]['attr_name']; ?> </h3>
                        <?php } ?>
                        <div class="desc-box " style="width:100%;margin-top: 50px;padding: 20px">
                            <div class="desc-inner-box">
                                <p><?php echo $blogs[$i]['attr_description'] ?></p>

                                <p  id="like_text<?php echo $blogs[$i]['blog_attractions_id']; ?>" class="like " style="float: left;margin-right: 20px;" data-id="<?php echo $blogs[$i]['blog_attractions_id']; ?>">Unlike</p>  
                                <span style="float:right;font-size: 20px;font-weight: 600;">&mdash; <?php echo $blogs[$i]['username'] ?></span>
                            </div>
                        </div>
                    </div>
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

                <?php
            }
        }
        ?>

    </div>  


    <div class="row" style="font-size:20px;margin-bottom: 60px;">
        <div class="col-md-10 offset-md-1" >

            <div class="col-md-3 offset-md-3" align='center'>
                <p ><?php // echo $links;                   ?></p>
                <?php if (sizeof($blogs) > 9) { ?>
                    <a href="#" id="loadMore">Load More</a>
                <?php } ?>
            </div>

        </div>
    </div>
    <div class="row ">
        <div class="offset-1 col-md-10 ">
            <h3 style="display: inline">Blogs You May Like</h3>
  <!--              <a href="<?php echo base_url() . 'blogs?user=' . $similarBlogs->id ?>" style="display: inline;float: right">See All</a>-->

            <div class="owl-carousel">
                <?php foreach ($similarBlogs as $similarBlog) { ?>
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
<script>

    $(".like").on('click', function () {
        var id = this.getAttribute('data-id');
        //       / alert(blogId);
        $.ajax({
            url: '<?php echo base_url("attraction-likes") ?>',
            cache: false,
            type: 'post',
            data: {like: 0, attractions_id: id, userId: <?php echo $user->id ?>},
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
<style>
    .no-js .owl-carousel, .owl-carousel.owl-loaded{
        display: inline-grid !important;
    }

</style>