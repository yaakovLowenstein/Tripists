<?php //print_r($getBlogDetails[0]->blog_likes_id);die;                                  ?>

<?php $user = $this->ion_auth->user()->row(); ?>
<div class="fluid-containter">
    <div class="row top-row">
        <div class="col-md-6 offset-md-2" style="padding-right: 20px;">     
            <?php
            //     print_r($getBlogDetails[0]->blog_id);die;
            //  foreach ($getBlogDetails as $getBlogDetails) {
            ?>
            <h2><?php echo $getBlogDetails->blog_title ?></h2>
            <h4 style="display: inline">Written By: <?php echo $getBlogDetails->username ?></h4>
            <p  id="like_text" class="like ">Like this Blog</p>  
            <i id="like_icon" class="far fa-thumbs-up like" style="margin: 0"></i>
            <div><p style="color:blue;margin-right: -10%"><strong>Likes:</strong> <?php echo $totalLikes ?></p>
            </div>
            <?php if (!empty($getBlogDetails->cover_pic_path)) { ?>      
                <div class="image-con">
                    <img class="top-row img"  src="<?php echo base_url($getBlogDetails->cover_pic_path) ?>">
                </div> 
            <?php } ?>
            <p><strong>Published On:</strong> <?php echo date('m/d/y', strtotime($getBlogDetails->publish_date)) ?></p>
            <!--<p>Destination Tags: <?php
//                foreach ($getBlogLocationsDetails as $location) {
//                    echo $location->location
            ?> </p>-->
            <p><strong>Dates of Trip:</strong> <?php echo $getBlogDetails->blog_dates ?></p>
            <p><strong>Destination:</strong>
                <?php
                $locationString = '';
                foreach ($getBlogLocationsDetails as $location) {
                    $locationString .= $location->location_tags_name . ', ';
                }
                $locationString = rtrim($locationString, ', ');
                echo $locationString;
                ?>
            </p>
            <div class="col-md-4 table-of-contents">
                <h3>Table of Contents</h3>
                <a href="#blog-post">Blog Post</a>  </br>
                <?php if (!empty($getBlogAttractionsDetails)) { ?>
                    <a href="#attractions">Top Attraction</a>  </br>
                <?php } ?>
                <?php if (!empty($getBlogRestaurnatsDetails)) { ?>
                    <a href="#restaurants">Top Restaurants</a>  </br>
                <?php } ?>
                <?php if (!empty($getBlogAdviceDetails)) { ?>
                    <a href="#advice">Advice</a>  </br>
                <?php } ?>
                <?php if (!empty($getBlogDetails->best_day)) { ?>
                    <a href="#best-day">Best Day of My Trip</a>  </br>
                <?php } ?>
                <?php if (!empty($getBlogPhotosDetails)) { ?>
                    <a href="#photos">Photos</a>  </br>
                <?php } ?>

            </div>
            <div id="blog-post" class="spacer">
                <?php echo $getBlogDetails->blog_summary ?>


            </div>
            <div id="attractions" class="spacer">
                <?php
                if (sizeof($getBlogAttractionsDetails) > 0) {
                    // print_r($getBlogAttractionsDetails);
                    //  die;
                    foreach ($getBlogAttractionsDetails as $attraction) {
                        ?>
                        <div class="page-break">
                            <h4 ><i class="far fa-laugh"></i><i class="fas fa-campground"></i><i class="fas fa-trophy"></i></h4>
                            <h1>Top Attraction</h1>
                            <h4><i class="fas fa-trophy"></i><i class="fas fa-campground"></i><i class="far fa-laugh"></i></h4>
                        </div>       
                        <h3 class="title top-row"><?php echo $attraction->attr_name ?> </h3>  
                        <p><?php echo $attraction->attr_description ?></p>
                        <?php
                    }
                }
                ?>

            </div>
            <div id="restaurants" class="spacer">
                <?php
                if (!empty($getBlogRestaurnatsDetails)) {
                    ?> 
                    <div class="page-break">
                        <h4 ><i class="fas fa-utensils"></i><i class="fas fa-hamburger"></i><i class="fas fa-pizza-slice"></i></h4>
                        <h1>Top Restaurants</h1>
                        <h4><i class="fas fa-pizza-slice"></i><i class="fas fa-hamburger"></i><i class="fas fa-utensils"></i></h4>
                    </div>
                    <!--<h2>Top Restaurants!</h2>-->   
                    <?php foreach ($getBlogRestaurnatsDetails as $restaurant) {
                        ?>

                        <h3 class="title top-row"><?php echo $restaurant->rest_name ?> </h3>  
                        <p><?php echo $restaurant->rest_description ?></p>
                        <?php
                    }
                }
                ?>
            </div>
            <div id="advice" class="spacer">
                <?php if (!empty($getBlogAdviceDetails)) { ?>
                    <div class="page-break">
                        <h4 ><i class="far fa-comment-dots"></i><i class="fas fa-paste"></i><i class="fas fa-pen"></i></h4>
                        <h1>Advice from the Blogger</h1>
                        <h4><i class="fas fa-pen"></i><i class="fas fa-paste"></i><i class="far fa-comment-dots"></i></h4>
                    </div>
                    <?php foreach ($getBlogAdviceDetails as $advice) {
                        ?>
                        <h3 class="top-row title"><?php echo $advice->advice_name ?> </h3>  
                        <p><?php echo $advice->advice_description ?></p>
                        <?php
                    }
                }
                ?>

            </div>
            <div id="best-day" class="spacer">
                <div class="page-break" style="margin-bottom:25px;">
                    <h4 ><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></h4>
                    <h1>Best Day of the Trip</h1>
                    <h4><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></h4>
                </div>
                <?php echo $getBlogDetails->best_day ?>

            </div>
            <div id="photos" class="spacer">
                <?php
                if (!empty($getBlogPhotosDetails)) {
                    // print_r("asdg");die;
                    ?>                         
                    <div class="page-break" style="margin-bottom:25px;">
                        <h4 ><i class="fas fa-images"></i><i class="fas fa-camera"></i><i class="fas fa-images"></i></h4>
                        <h1>Pictures of the Trip</h1>
                        <h4><i class="fas fa-images"></i><i class="fas fa-camera"></i><i class="fas fa-images"></i></h4>
                    </div>
                    <div class="row">


                        <?php
                        $i = 0;
                        $num = 0;
                        foreach ($getBlogPhotosDetails as $photo) {
                            $num++;
                            if ($i == 0) {
                                ?>
                                <div class = "col-md-12">
                                <?php } ?>

                                <div class="image-wrapper-front-end top-row">

                                    <img  id="myImg<?php echo $num ?>" src="<?php echo base_url() . $photo->path ?>" data-toggle="modal" data-target="#imageModal" 
                                          data-whatever="<?php echo $num ?>" data-name="<?php echo $photo->original_name ?>" data-description="<?php echo $photo->photos_description ?>" >
                                    <p><?php echo $photo->original_name ?></p>
                                </div>
                                <?php if ($i == 2 || sizeof($getBlogPhotosDetails) == $num) {
                                    ?>
                                </div>
                                <?php
                            }$i++;
                            if ($i == 3) {
                                $i = 0;
                            }
                            ?>
                        <?php }
                        ?>

                    </div>
                    <?php
                }
                ?>
            </div>             
            <div class="spacer send-message">
                <div class=" ">
                    <h3>Send a message to the Author of this blog.</h3>
                    <p>Have a question or comment about this blog? Have a comment about something random? Send it here!</p>
                    <form class="top-row" id="messgae-form">
                        <label>Sending a message about this blog?</label>
                        <select id='is_this_blog'>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
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
            <div style="text-align:center">
                <div class="blog-issue spacer ">
                    <h4>Click here to report abuse or misconduct by this blog. Thank you.</h4>
                    <input id="abuse-button" type="button" class="btn btn-dark" value="Report Abuse" />
                </div>
            </div>
            <?php // }
            ?>

        </div>
        <div class="col-md-2 " >
            <div class="right-side-bar">
                <div class="prof-image-con">
                    <img class="prof-img" src="<?php echo base_url() . $getBlogDetails->profile_pic_path ?>" style="margin-top: 25px;">
                </div>
                <h3>About the Author</h3>
                <h5><?php echo $getBlogDetails->username ?></h5>
                <p><?php echo character_limiter($getBlogDetails->about, 100, '<a href="#"> more...</a>') ?></p>
                <?php if (sizeof($getAllBLogsByUser) > 1) { ?>
                    <h5>Other Blogs by <?php echo $getBlogDetails->username ?></h5>
                    <ul style="text-align: left">
                        <?php for ($i = 0; $i < 3 && $i + 1 < sizeof($getAllBLogsByUser); $i++) {      //    $randd = (rand(10,100));   ?>
                            <li><a href="<?php echo base_url() . 'blog-details/' . $getAllBLogsByUser[$i]->blog_id ?>"><?php echo $getAllBLogsByUser[$i]->blog_title ?> </a> </li>

                        <?php } ?>

                    </ul>
                <?php } ?>
            </div>
            <h2 align="center" class="basic-border">Related Blogs</h2>
            <?php for ($i = 0; $i < 3 && $i < sizeof($getRelatedBlogs); $i++) { ?>
                <a style="     text-decoration: none !important; "href="<?php echo base_url('blog-details/') . $getRelatedBlogs[$i]->blog_id ?>">
                    <div class="related-blogs top-row">
                        <div class="image-con-cover top-row">
                            <img class="img-cover"src="<?php echo base_url() . $getRelatedBlogs[$i]->cover_pic_path; ?>">
                        </div>       
                        <h3><?php echo $getRelatedBlogs[$i]->blog_title; ?></h3>
                        <p>By: <?php echo $getRelatedBlogs[$i]->username; ?></p>
                    </div>  
                </a>  
                <?php
            }
            ?>
            <div align="center" class="basic-border">
                <h3 >Like this blog?
                    </br>
                    <i id="like_icon" class="far fa-thumbs-up " style="color: blue"></i>

                    </br>
                    Click the Like button at the top of the page!
                    </br></h3>
                <a href="#like_icon"><h1> <i class="fas fa-arrow-up"></i></h1></a>
            </div>

        </div>

    </div>
</div>

<div class="modal fade image-modal-content center" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog image-modal-dialog " role="document">
        <div class="modal-content image-modal-content">
            <div class="modal-header">
                <!--<h5 class="modal-title" id="exampleModalLabel">Edit name and description</h5>-->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="image-modal-body">
                <div class="modal-image-wrapper">
                    <img class="modal-images" id="modal-image" src="" alt="Image" style="max-width:80%;max-height: 60%" />
                </div>
                <div>
                    <h3 id="title">Title of image</h3>
                </div>
                <div>
                    <p id="description">No Description</p>
                </div>
            </div>

        </div>
    </div>
</div>
<!--<script type="text/javascript" src="<?php echo base_url() . 'bower_components/amcharts4/core.js'; ?>"></script>

<script type="text/javascript" src="<?php echo base_url() . 'bower_components/amcharts4/maps.js'; ?>"></script>-->
<script>

    $('#imageModal').on('show.bs.modal', function (event) {
        //    alert("sdf");
        //    alert("asdf");
        var image = $(event.relatedTarget) // image that triggered the modal
        var num = image.data('whatever') // Extract info from data-* attributes
        var name = image.data('name');
        var desc = image.data('description');
//alert(desc);

        var modal = $(this)
        var img = document.getElementById("myImg" + num);

        //        modal.find('.modal-title').text($('#myImg' + num).src);
        // modal.find('.modal-body #title').val($('#myImgName' + num).text());
        //     /document.write(img.src);
        modal.find('#modal-image').attr("src", img.src);
        //$('#modal-form').attr('action',"<?php //echo base_url() . 'profile/blogs/image/' . $blogId                          ?>"  );
        $('#title').text(name);
        if (desc == "") {
            desc = 'No Description';
        }
        $('#description').text(desc);

    });



    var abuse = false;
    $(document).ready(function () {
//        $.ajax({
//            url: '<?php echo base_url("blog-clicked") ?>',
//            cache: false,
//            type: 'post',
//            data: {counter: <?php //echo $getBlogDetails->clicked_counter ?>, blog_id: '<?php echo $getBlogDetails->blog_id ?>'},
//            datatype: 'json',
//            success: function (response) {
//
//            }
//        });

        if (<?php echo empty($getLikedBlog[0]->blog_likes_id) ? 1 : 0 ?> == 0) {
            $('#like_text').text('Unlike this Blog');
            $('#like_icon').hide();
        }
//        var valid = true;
//        if (<?php echo!empty($this->input->get('like')) ? 1 : 0 ?> == 1 && valid) {
//            valid = false;
//            $('.like').trigger('click');
//
//        }
    });


    $(".like").on('click', function () {
        if (<?php echo empty($this->ion_auth->user()->row()) ? 0 : 1; ?> == 1) {
            $.ajax({
                url: '<?php echo base_url("blog-likes") ?>',
                cache: false,
                type: 'post',
                data: {like: <?php echo empty($getLikedBlog[0]->blog_likes_id) ? 1 : 0 ?>, blogId: '<?php echo $getBlogDetails->blog_id ?>', userId: <?php echo!empty($user->id) ? $user->id : -1 ?>},
                datatype: 'json',
                success: function (response) {
                    if (response) {
                        $('#like_text').text('Unlike this Blog');
                        $('#like_icon').hide();
                        location.reload();

                    } else {
                        $('#like_text').text('Like this Blog');
                        $('#like_icon').show();
                        location.reload();
                    }
                }
            });
        } else {
            $('#modal-p').text("You need to login in order to like this blog.");
            $('#modal-header').text('Login');
            // $('#take-to-blog-btn').show();
            $('#modal-btn').trigger('click');
            $('#sign-in-form').show();
            //$('.modal-footer').hide();
            $('#modal-a').show();
            $('.modal-content').height('425px')
        }

    });
    $(".fa-arrow-up").click(function () {
        $("html, body").animate({scrollTop: 0}, "slow");
        return false;
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
                    data: {message: mess, select: select, blog_id: '<?php echo $getBlogDetails->blog_id ?>'},
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
    $("#abuse-button").on('click', function (event) {

        if (<?php echo empty($this->ion_auth->user()->row()) ? 0 : 1; ?> == 1) {
            if (!abuse) {
                $.ajax({
                    url: '<?php echo base_url("abuse") ?>',
                    cache: false,
                    type: 'post',
                    data: {counter: '<?php echo $getBlogDetails->blog_abuse_id ?>', blog_id: '<?php echo $getBlogDetails->blog_id ?>', userId: <?php echo!empty($user->id) ? $user->id : -1 ?>},
                    datatype: 'json',
                    success: function (result) { //we got the response
                        if (result) {
                            abuse = true;
                            $('#modal-header').text('Thank you');
                            $('#modal-p').text("Thank you for reporting the misconduct/ abuse.");
                            $('#modal-btn').trigger('click');
                            //  $('#message-text').val('');
                            //  $('.error-span').hide();

                        } else {
                            $('#modal-header').text('Sorry');
                            $('#modal-p').text("Can only submit one time per user.");
                            $('#modal-btn').trigger('click');

                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(JSON.stringify(jqXHR));
                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    }
                });
            } else {
                $('#modal-header').text('Sorry');
                $('#modal-p').text("Can only submit one time per user.");
                $('#modal-btn').trigger('click');
            }
        } else {

            //  $('#modal-p').text("You need to login in order to send a
            $('#modal-p').text("You need to login to report abuse.");
            $('#modal-header').text('Login');
            // $('#take-to-blog-btn').show();
            $('#modal-btn').trigger('click');
            $('#sign-in-form').show();
            //$('.modal-footer').hide();
            $('#modal-a').show();
            $('.modal-content').height('425px')
        }
    }
    );
</script>
