<?php $user = $this->ion_auth->user()->row(); ?>

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
        <div class="col-md-6">
            <h3>About <?php echo $bloggerDetails->full_name ?></h3>
            <p><strong>From:</strong> <?php
                if ($bloggerDetails->state_from == 0) {
                    echo $bloggerDetails->city . ", " . $bloggerDetails->country_name;
                } else {
                    echo $bloggerDetails->city . ", " . $bloggerDetails->state_name . ", " . $bloggerDetails->country_name;
                }
                ?></p>
            <?php if ($bloggerDetails->website != "https://www." && strpos($bloggerDetails->website, ".")) { ?>
                <span><strong>Website: </strong><a href="<?php echo $bloggerDetails->website ?>" target="blank"><?php echo $bloggerDetails->website ?></a></span>
                <br>          
                <br>


            <?php } ?>

            <p><?php echo $bloggerDetails->about ?></p>
        </div>
        <div class="col-md-2" style="margin: auto auto;text-align: center">
            <div style="border: 3px #47c4e1 solid;padding: 25px;">
                <span>Want to get the latest from <strong><?php echo $bloggerDetails->username ?></strong></span>
                <a href="" class="subscribe"> <h5>Click Here To Subscribe</h5></a>
                <p>You will receive all of their latest blog posts and more!</p>

            </div>
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
                        <label style="display:block;margin-top: 15px;">Subject</label>
                        <input class="form-control" style="width:70%" placeholder="Subject" id="subject"/>
                        <span style="display:none;"class="error-span">This field is required</span>
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
        var subscribe = false;
<?php if (($bloggerDetails->blogger_id) != null) { ?>
            subscribe = true;
<?php } ?>

        if (subscribe) {
            $('.subscribe').text("Unsubscribe");
            $('.subscribe').wrap('<h5></h5>');
        }
    });

<?php if ($user->id != $bloggerDetails->user_id) { ?>

    $("#messgae-form").on('submit', function (event) {
        event.preventDefault();

        var mess = $('#message-text').val();
        var select = $('#is_this_blog').val();
        var subject = $('#subject').val();

        // alert(select);

            if (mess != '' && subject != '') {
                if (<?php echo empty($this->ion_auth->user()->row()) ? 0 : 1; ?> == 1) {
                    $.ajax({
                        url: '<?php echo base_url("blog-messages") ?>',
                        cache: false,
                        type: 'post',
                        data: {message: mess, select: select, blog_id: '0', subject: subject, to_blogger:<?php echo $this->uri->segment(3) ?>, from_user:<?php echo $this->ion_auth->user()->row()->id ?>, is_read_by_from: 1},
                        datatype: 'json',
                        success: function (result) { //we got the response
                            $('#modal-header').text('Thank you');
                            $('#modal-p').text("Your message has been sent.");
                            $('#modal-btn').trigger('click');
                            $('#message-text').val('');
                            $('#subject').val('');

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
<?php } else { ?>
        $("#messgae-form").on('submit', function (event) {
            event.preventDefault();
            $('#modal-header').text('Error');
            $('#modal-p').text("You cannot send yourself a message.");
            $('#modal-btn').trigger('click');
        });
<?php } ?>
    $(".subscribe").on('click', function (event) {
        event.preventDefault();
        if (<?php echo empty($this->ion_auth->user()->row()) ? 0 : 1; ?> == 1) {
            $.ajax({
                url: '<?php echo base_url("subscribe") ?>',
                cache: false,
                type: 'post',
                data: {subscribe: <?php echo empty($bloggerDetails->blogger_id) ? 1 : 0 ?>, blogger_id: '<?php echo $bloggerDetails->user_id ?>', userId: <?php echo!empty($user->id) ? $user->id : -1 ?>},
                datatype: 'json',
                success: function (response) {

                    location.reload();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }


            });
        } else {
            $('#modal-p').text("You need to login in order to subscribe to this blogger.");
            $('#modal-header').text('Login');
            // $('#take-to-blog-btn').show();
            $('#modal-btn').trigger('click');
            $('#sign-in-form').show();
            //$('.modal-footer').hide();
            $('#modal-a').show();
            $('.modal-content').height('425px')
        }

    });

</script>