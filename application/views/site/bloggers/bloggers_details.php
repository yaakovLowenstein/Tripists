<div class="fluid-containter">
    <div class="row top-row">
        <div class="offset-1 col-md-2" style="text-align: center">
            <?php if (!empty($bloggerDetails->profile_pic_path)) { ?>
                <div class="prof-image-con">
                    <img class="prof-img"  src="<?php echo base_url() . $bloggerDetails->profile_pic_path ?>">
                </div>   
            <?php }// else echo '<img class="blog-cover-image" width="335" height="225" src="' . base_url('uploads/1/default.jpg') . '">'; //"<p>Image</p> <p>Not</p> <p>Available</p>"    ?>
            <h3><?php echo $bloggerDetails->username ?></h3> 
            <?php if ($bloggerDetails->twitter != "https://www.twitter.com/" && strpos($bloggerDetails->twitter, "twitter.com")) { ?>
                <h5 style="display: inline"><a href="<?php echo $bloggerDetails->twitter ?>"><i class="fab fa-twitter"></i></a></h5>
            <?php } ?>
            <?php if ($bloggerDetails->facebook != "https://www.facebook.com/" && strpos($bloggerDetails->facebook, "facebook.com")) { ?>
                <h5 style="display: inline"><a href="<?php echo $bloggerDetails->facebook ?>"><i class="fab fa-facebook-square"></i></a></h5>
            <?php } ?>
            <?php if ($bloggerDetails->instagram != "https://www.instagram.com/" && strpos($bloggerDetails->instagram, "instagram.com")) { ?>
                <h5 style="display: inline">  <a href="<?php echo $bloggerDetails->instagram ?>"><i class="fab fa-instagram"></i></a></h5>
            <?php } ?>
            <?php if ($bloggerDetails->youtube != "https://www.youtube.com/" && strpos($bloggerDetails->youtube, "youtube.com")) { ?>
                <h5 style="display: inline">  <a href="<?php echo $bloggerDetails->youtube ?>"><i class="fab fa-youtube"></i></a></h5>
            <?php } ?>

        </div>
        <div class="col-md-8">
            <h3>About <?php echo $bloggerDetails->full_name ?></h3>
            <p><strong>From:</strong> <?php
                if ($bloggerDetails->state_from == 0) {
                    echo $bloggerDetails->city . ", " . $bloggerDetails->country_name;
                } else {
                    echo $bloggerDetails->city . ", ". $bloggerDetails->state_name.", ". $bloggerDetails->country_name;
                }
                ?></p>
                <?php if ($bloggerDetails->website != "https://www." && strpos($bloggerDetails->website, ".")) { ?>
                <span><strong>Website: </strong><a href="<?php echo $bloggerDetails->website ?>" target="blank"><?php echo $bloggerDetails->website ?></a></span>
                <br>          
                <br>


            <?php } ?>

            <p><?php echo $bloggerDetails->about ?></p>
        </div>

    </div>
    <div class="row top-row">
        <div class="offset-1 col-md-10 top-row">
            <h3 style="display: inline">Blogs by <?php echo $bloggerDetails->username ?></h3>
            <a href="<?php echo base_url() . 'blogs?user=' . $bloggerDetails->id ?>" style="display: inline;float: right">See All</a>

            <div class="owl-carousel">
                <?php for ($i = 0; $i < 10; $i++) { ?>
                    <div class="item">   
                        <a href="<?php echo base_url('blog-details/') . $getBloggersDetailsById[$i]->blog_id ?>">   
                            <div class="blog-image-carousel-con">
                                <?php if (!empty($getBloggersDetailsById[$i]->cover_pic_path)) { ?>


                                    <img class="blog-image-carousel"  src="<?php echo base_url() . $getBloggersDetailsById[$i]->cover_pic_path ?>">
                                <?php } else echo '<img class="blog-image-carousel" src="' . base_url('uploads/1/default.jpg') . '">'; ?>
                            </div>           
                            <h3><?php echo $getBloggersDetailsById[$i]->blog_title ?></h3></a>  
                    </div>


                <?php } ?>
            </div>
        </div>

    </div>

    <div class="row top-row">
        <div class="col-md-10 offset-1">
            <div class=" send-message">
                <div class=" ">
                    <h3>Send a message to <?php echo $bloggerDetails->username ?>.</h3>
                    <p>Have a question or comment? Send it here!</p>
                    <form class="top-row" id="messgae-form">
                        <!--<label>Sending a message about this blog?</label>-->
                        <select id='is_this_blog' hidden="hidden">
                            <option value="1">Yes</option>
                            <option selected="selected"value="0">No</option>
                        </select>
                        <div style="display:block;">
                            <label>Type your message here</label>
                            <textarea name ='mess' id="message-text" class="message-txt" ></textarea>
                            <span style="display:none;"class="error-span">This field is required</span>
                        </div>
                        <input type="submit" value="Send Message" class="btn btn-primary " style=" margin-top: 5px"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<link rel="stylesheet" href="<?php echo base_url() . 'bower_components/' ?>owlCarousel/dist/assets/owl.carousel.min.css">
<link rel="stylesheet" href="<?php echo base_url() . 'bower_components/' ?>owlCarousel/dist/assets/owl.theme.default.min.css">
<script src="<?php echo base_url() . 'bower_components/' ?>owlCarousel/dist/owl.carousel.min.js"></script>
<script>
    $(document).ready(function () {
        $('.owl-carousel').owlCarousel({
            items: 5,
            loop: true,
            margin: 10,
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


    $("#messgae-form").on('submit', function (event) {
        event.preventDefault();

        var mess = $('#message-text').val();
        var select = $('#is_this_blog').val();
        // alert(select);
        if (mess != '') {
            if (<?php echo empty($this->ion_auth->user()->row()) ? 0 : 1; ?> == 1) {
                $.ajax({
                    url: '<?php echo base_url("blog-messages") ?>',
                    cache: false,
                    type: 'post',
                    data: {message: mess, select: select, blog_id: '0'},
                    datatype: 'json',
                    success: function (result) { //we got the response
                        $('#modal-header').text('Thank you');
                        $('#modal-p').text("Your message has been sent.");
                        $('#modal-btn').trigger('click');
                        $('#message-text').val('');
                        $('.error-span').hide();
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(JSON.stringify(jqXHR));
                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    }
                });
            } else {

                $('#modal-p').text("You need to login in order to send a message.");
                $('#modal-header').text('Login');
                // $('#take-to-blog-btn').show();
                $('#modal-btn').trigger('click');
                $('#sign-in-form').show();
                //$('.modal-footer').hide();
                $('#modal-a').show();
                $('.modal-content').height('425px')
            }
        } else {
            $('.error-span').show();
        }
    });
</script>