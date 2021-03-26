<?php $user = $this->ion_auth->user()->row(); ?>


<div class="container-fluid">
    <?php require_once(APPPATH . "views/site/blogs/listing_header.php"); ?>

    <div class="row">
        <div class="col-md-10 offset-2">
            <div class="row">
                <?php
                $count = 0;
                foreach ($getBlogRestaurantsList as $restaurant) {
                    $count++;
                    ?>
                    <div class="col-md-3">
                        <div class="flip-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <div style="height: 25%"></div>
                                    <h3><?php echo $restaurant->rest_name; ?></h3>
                                    <!--<h4><?php // echo $restaurant->username;        ?></h4>-->
                                    <p><?php echo $restaurantsDetailsArray[$restaurant->restaurants_id]->location_tags_name; ?></p>
    <!--                                    <p><?php //echo $restaurant->attr_id;        ?></p>-->
                                                                        <!--<p><?php // echo $restaurant->blog_restaurants_id;        ?></p>-->


                                    <div class="rest-likes">
                                        <p class="rest-likes-p"><strong>Total Likes:</strong> <?php echo $restaurant->totallikes ?></p>
                                    </div>
                                </div>
                                <div class="flip-card-back">
                                    <?php
                                    if (isset($_COOKIE['sw'])) {
                                        if ($_COOKIE['sw'] > 1350) {
                                            $charMax = 250;
                                        } else {
                                            $charMax = 150;
                                        }
                                    } else {
                                        $charMax = 150;
                                    }
                                    $descriptionLength = strlen($restaurantsDetailsArray[$restaurant->restaurants_id]->description);
                                    $max = round($descriptionLength * .67) + 15;
                                    if ($max < $charMax) {
                                        $charMax = $max;
                                    }
                                    echo character_limiter("<p>Summary by: " . $restaurantsDetailsArray[$restaurant->restaurants_id]->username . "</p>" .
                                            $restaurantsDetailsArray[$restaurant->restaurants_id]->description . "<p><a style='color:white' href='" .
                                            base_url("blog-details/") . $restaurantsDetailsArray[$restaurant->restaurants_id]->blog_id . "'>originally seen on: " .
                                            $restaurantsDetailsArray[$restaurant->restaurants_id]->blog_title . "</a></p>", $charMax, '<span> </span><span class="rest-desc"  data-toggle="modal" data-target="#read_more_modal" '
                                            . 'data-desc="' . $restaurantsDetailsArray[$restaurant->restaurants_id]->description . '"data-title="' . $restaurantsDetailsArray[$restaurant->restaurants_id]->blog_title
                                            . '"data-rest-name="' . $restaurantsDetailsArray[$restaurant->restaurants_id]->rest_name
                                            . '"data-user-id="' . $restaurantsDetailsArray[$restaurant->restaurants_id]->user_id
                                            . '"data-mostlikes="' . $restaurantsDetailsArray[$restaurant->restaurants_id]->mostlikes
                                            . '"data-id="' . $restaurantsDetailsArray[$restaurant->restaurants_id]->blog_id
                                            . '"data-username="' . $restaurantsDetailsArray[$restaurant->restaurants_id]->username
                                            . '"data-rest-id="' . $restaurantsDetailsArray[$restaurant->restaurants_id]->rest_id .
                                            '"> read more...</span>');
                                    ?>
                                    </br>
    <!--                                    <p  id="like_text<?php echo $restaurantsDetailsArray[$restaurant->restaurants_id]->blog_restaurants_id ?>" class="like" style="float: none;margin: 0;color: "data-id="<?php echo $restaurantsDetailsArray[$restaurant->restaurants_id]->blog_restaurants_id ?>" >
                                        Like <?php echo $restaurantsDetailsArray[$restaurant->restaurants_id]->username ?>'s description
                                        <i id="like_icon" class="far fa-thumbs-up like"  style="float: none;margin: 0;"></i></p>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($count == 3) {
                        $count = 0;
                        ?>
                    </div>
                    <div class="row top-row">

                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <div class="row" style="font-size:20px">
        <div class="col-md-10 offset-md-2" >
            <div class="col-md-3 offset-md-3" align='center'>
                <p ><?php echo $links; ?></p>

            </div>

        </div>
    </div>

</div>
<!-- Trigger the modal with a button -->

<!-- Modal -->
<div id="read_more_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content desc-modal" style="height:auto !important;display:block;padding:35px;padding-bottom: 50px; " >
            <button type="button" class="close" data-dismiss="modal" style="margin-left: 95%">&times;</button>
            <h4 id="rest_name" style="margin-bottom: 20px;"></h4>
            <h5 class="d-inline-block" >Description by: </h5> <h5 class="d-inline-block" ><a style="color:white"id="username"></a> </h5>
            <p id="modal-likes" style="float:right;"></p>
            </br>           
 <!--<p  id="like_text" class="like" style="float: right;margin: 0;margin-right:  10%;color: ">Like-->
                <!--<i id="like_icon" class="far fa-thumbs-up like"  style="float: none;margin: 0;"></i></p>-->  
            <p id="desc" style="margin-top: 20px;border: 1px white dashed; padding: 10px"></p>
            <a id="read_more_blog_title"></a>
            </br>            </br>

            <h5><a style="display:block;color: white" id="see_more">See all Summaries</a></h5> 
            <button type="button" class="btn btn-outline-light" data-dismiss="modal" style="width: 33%;float: right">Close</button>

        </div>


    </div>
</div>

<script>
    $('#read_more_modal').on('show.bs.modal', function (event) {

        var modal = $(event.relatedTarget) // image that triggered the modal
        var desc = modal.data('desc');
        var title = modal.data('title');
        var restName = modal.data('rest-name');
        var id = modal.data('id');
        var restId = modal.data('rest-id');
        var username = modal.data('username');
        var userId = modal.data('user-id');
        var mostLikes = modal.data('mostlikes');

        $("#desc").text(desc);
        $("#read_more_blog_title").text("Originally seen on: " + title);
        $("#read_more_blog_title").attr("href", "<?php echo base_url("blog-details/") ?>" + id);

        $("#rest_name").text(restName);
        $("#username").text(username);
        $("#username").attr("href", "<?php echo base_url("bloggers/details/") ?>" + userId);
        $("#modal-likes").text("Likes: " + mostLikes);
        $("#see_more").attr("href", "<?php echo base_url("restaurants/descriptions/") ?>" + restId);
        $("#see_more").text("See All Summaries for " + restName);

    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script type=text/javascript>
    var likedRestArray = [];
    var index = 0;
    function setScreenHWCookie() {
        $.cookie('sw', screen.width);
        $.cookie('sh', screen.height);
        return true;
    }
    $(document).ready(function () {
        setScreenHWCookie();


    });
</script>


