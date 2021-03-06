<?php $user = $this->ion_auth->user()->row(); ?>

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
?>
<div class="container-fluid">
    <?php require_once(APPPATH . "views/site/blogs/listing_header.php"); ?>

    <div class="row">
        <div class="col-md-10 offset-2">
            <div class="row">
                <?php
                $count = 0;
                foreach ($getBlogAttractions as $attraction) {
                    $count++;
                    ?>
                    <div class="col-md-3">
                        <div class="flip-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <div style="height: 25%"></div>
                                    <h3><?php echo $attraction->attr_name; ?></h3>
                                    <!--<h4><?php // echo $attraction->username;      ?></h4>-->
                                    <p><?php echo $attractionsDetailsArray[$attraction->attractions_id]->location_tags_name; ?></p>
    <!--                                    <p><?php //echo $attraction->attr_id;      ?></p>-->
                                                                        <!--<p><?php // echo $attraction->blog_attractions_id;      ?></p>-->


                                    <div class="attr-likes">
                                        <p class="attr-likes-p"><strong>Total Likes:</strong> <?php echo $attraction->totallikes ?></p>
                                    </div>
                                </div>
                                <div class="flip-card-back">
                                    <?php
                                    $descriptionLength = strlen($attractionsDetailsArray[$attraction->attractions_id]->attr_description);
                                    $max = round($descriptionLength*.67)+15;
                                    if ($max <$charMax){
                                        $charMax = $max;
                                    }
                                    echo character_limiter("<p>Description by: " . $attractionsDetailsArray[$attraction->attractions_id]->username . "</p>" .
                                            $attractionsDetailsArray[$attraction->attractions_id]->attr_description . "<p><a style='color:white' href='" .
                                            base_url("blog-details/") . $attractionsDetailsArray[$attraction->attractions_id]->blog_id . "'>originally seen on: " .
                                            $attractionsDetailsArray[$attraction->attractions_id]->blog_title . "</a></p>", $charMax, '<span> </span><span class="attr-desc"  data-toggle="modal" data-target="#read_more_modal" '
                                            . 'data-desc="' . $attractionsDetailsArray[$attraction->attractions_id]->attr_description . '"data-title="' . $attractionsDetailsArray[$attraction->attractions_id]->blog_title
                                            . '"data-attr-name="' . $attractionsDetailsArray[$attraction->attractions_id]->attr_name
                                            . '"data-user-id="' . $attractionsDetailsArray[$attraction->attractions_id]->user_id
                                            . '"data-mostlikes="' . $attractionsDetailsArray[$attraction->attractions_id]->mostlikes
                                            . '"data-id="' . $attractionsDetailsArray[$attraction->attractions_id]->blog_id
                                            . '"data-username="' . $attractionsDetailsArray[$attraction->attractions_id]->username
                                            . '"data-attr-id="' . $attractionsDetailsArray[$attraction->attractions_id]->attr_id .
                                            '"> read more...</span>');
                                    ?>
                                    </br>
    <!--                                    <p  id="like_text<?php echo $attractionsDetailsArray[$attraction->attractions_id]->blog_attractions_id ?>" class="like" style="float: none;margin: 0;color: "data-id="<?php echo $attractionsDetailsArray[$attraction->attractions_id]->blog_attractions_id ?>" >
                                        Like <?php echo $attractionsDetailsArray[$attraction->attractions_id]->username ?>'s description
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
            <h4 id="attr_name" style="margin-bottom: 20px;"></h4>
            <h5 class="d-inline-block" >Description by: </h5> <h5 class="d-inline-block" ><a style="color:white"id="username"></a> </h5>
            <p id="modal-likes" style="float:right;"></p>
            </br>           
 <!--<p  id="like_text" class="like" style="float: right;margin: 0;margin-right:  10%;color: ">Like-->
                <!--<i id="like_icon" class="far fa-thumbs-up like"  style="float: none;margin: 0;"></i></p>-->  
            <p id="desc"></p>
            <a id="read_more_blog_title"></a>
            </br>            </br>

            <a style="display:block;color: white" id="see_more">See all descriptions</a>
            <button type="button" class="btn btn-outline-light" data-dismiss="modal" style="width: 33%;float: right">Close</button>

        </div>


    </div>
</div>

<script>
    $('#read_more_modal').on('show.bs.modal', function (event) {

        var modal = $(event.relatedTarget) // image that triggered the modal
        var desc = modal.data('desc');
        var title = modal.data('title');
        var attrName = modal.data('attr-name');
        var id = modal.data('id');
        var attractionId = modal.data('attr-id');
        var username = modal.data('username');
        var userId = modal.data('user-id');
        var mostLikes = modal.data('mostlikes');

        $("#desc").text(desc);
        $("#read_more_blog_title").text("Originally seen on: " + title);
        $("#read_more_blog_title").attr("href", "<?php echo base_url("blog-details/") ?>" + id);

        $("#attr_name").text(attrName);
        $("#username").text(username);
        $("#username").attr("href", "<?php echo base_url("bloggers/details/") ?>" + userId);
        $("#modal-likes").text("Likes: " + mostLikes);
        $("#see_more").attr("href", "<?php echo base_url("attractions/descriptions/") ?>" + attractionId);


    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script type=text/javascript>
    var likedAttrArray = [];

    function setScreenHWCookie() {
        $.cookie('sw', screen.width);
        $.cookie('sh', screen.height);
        return true;
    }
    $(document).ready(function () {
        setScreenHWCookie();
<?php foreach ($getAttractionLikes as $likedAttr) { ?>
            var attrId = <?php echo $likedAttr->blog_attractions_id; ?>;
            $("#like_text" + attrId).text("Unlike");
            $("#like_text" + attrId).find('i').hide();
            likedAttrArray[attrId] = attrId;
<?php } ?>
    });

    $(".like").on('click', function (event) {

        if (<?php echo empty($this->ion_auth->user()->row()) ? 0 : 1; ?> == 1) {
            //var attraction = $(event.relatedTarget); // image that triggered the modal
            //alert(attraction);   
            //    var id = attraction.dataset.id//('id');

            var id = this.getAttribute("data-id");
            if (likedAttrArray[id] == id) {
                var like = 0;
            } else
                var like = 1;

            // alert(id);
            $.ajax({
                url: '<?php echo base_url("attraction-likes") ?>',
                cache: false,
                type: 'post',
                data: {like: like, attractions_id: id, userId: <?php echo!empty($user->id) ? $user->id : -1 ?>},
                datatype: 'json',
                success: function (response) {
                    if (response) {
                        $(this).text('Unlike this Blog');
                        $(this).find('i').hide();
                        location.reload();

                    } else {
                        $(this).text('Like this Blog');
                        this.find('i').show();
                        location.reload();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                },
            });
        } else {
            $('#modal-p').text("You need to login in order to like this attraction.");
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


