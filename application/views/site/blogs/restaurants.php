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
                foreach ($getBlogRestaurantsList as $restaurant) {
                    $count++;
                    ?>
                    <div class="col-md-3">
                        <div class="flip-card">
                            <div class="flip-card-inner">
                                <div class="flip-card-front">
                                    <div style="height: 25%"></div>
                                    <h3><?php echo $restaurant->name; ?></h3>
                                    <h4><?php echo $restaurant->username; ?></h4>
                                    <div class="attr-likes">
                                        <p class="attr-likes-p"><strong>Likes:</strong> <?php echo $restaurant->TotalLikes ?></p>
                                    </div>
                                </div>
                                <div class="flip-card-back">
                                    <?php
                                    echo character_limiter($restaurant->description . "<p><a style='color:white' href='" . base_url("blog-details/") . $restaurant->blog_id . "'>originally seen on: " . $restaurant->blog_title . "</a></p>", $charMax, '<span> </span><span class="attr-desc"  data-toggle="modal" data-target="#read_more_modal" '
                                            . 'data-desc="' . $restaurant->description . '"data-title="' . $restaurant->blog_title
                                            . '"data-attr-name="' . $restaurant->name
                                            . '"data-id="' . $restaurant->blog_id .
                                            '"> read more...</span>');
                                    ?>
                                    </br>
                                    <p  id="like_text<?php echo $restaurant->blog_restaurants_id ?>" class="like" style="float: none;margin: 0;color: "data-id="<?php echo $restaurant->blog_restaurants_id ?>" >Like  
                                        <i id="like_icon" class="far fa-thumbs-up like"  style="float: none;margin: 0;"></i></p>
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

</div>
<!-- Trigger the modal with a button -->

<!-- Modal -->
<div id="read_more_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content desc-modal" style="height:auto !important;display:block;padding:35px; " >
            <button type="button" class="close" data-dismiss="modal" style="margin-left: 95%">&times;</button>
            <h4 id="attr_name" style="margin-bottom: 20px;"></h4>
            <!--<p  id="like_text" class="like" style="float: right;margin: 0;margin-right:  10%;color: ">Like-->
                <!--<i id="like_icon" class="far fa-thumbs-up like"  style="float: none;margin: 0;"></i></p>-->  
            <p id="desc"></p>
            <a id="read_more_blog_title"></a>

            <button type="button" class="btn btn-outline-light" data-dismiss="modal" style="width: 33%;float: right">Close</button>

        </div>


    </div>
</div>

<script>
    $('#read_more_modal').on('show.bs.modal', function (event) {

        var modal = $(event.relatedTarget) // image that triggered the modal
        var desc = modal.data('desc');
        var title = modal.data('title');
        var restName = modal.data('attr-name');
        var id = modal.data('id');

        $("#desc").text(desc);
        $("#read_more_blog_title").text("Originally seen on: " + title);
        $("#read_more_blog_title").attr("href", "<?php echo base_url("blog-details/") ?>" + id);

        $("#attr_name").text(restName);

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
<?php foreach ($getRestaurantLikes as $likedRest) { ?>
            index++;
            var restId = <?php echo $likedRest->blog_restaurants_id; ?>;
            $("#like_text" + restId).text("Unlike");
            $("#like_text" + restId).find('i').hide();
            likedRestArray[index] = restId+'';
            //alert(index);
<?php } ?>
    
  });

    $(".like").on('click', function (event) {

        if (<?php echo empty($this->ion_auth->user()->row()) ? 0 : 1; ?> == 1) {
            //var attraction = $(event.relatedTarget); // image that triggered the modal
            //alert(attraction);   
            //    var id = attraction.dataset.id//('id');

            var id = this.getAttribute("data-id");
            if (likedRestArray.includes(id)) {
                var like = 0;
            } else
                var like = 1;

            // alert(id);
            $.ajax({
                url: '<?php echo base_url("restaurant-likes") ?>',
                cache: false,
                type: 'post',
                data: {like: like, restaurant_id: id, userId: <?php echo!empty($user->id) ? $user->id : -1 ?>},
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
            $('#modal-p').text("You need to login in order to like this restaurant.");
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


