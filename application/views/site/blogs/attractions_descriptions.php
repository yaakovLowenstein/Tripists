<?php $user = $this->ion_auth->user()->row(); ?>

<div class="black-divider"></div>
<div class="banner-container">
    <img class="banner" src="<?php echo base_url('Images/attractions_banner.jpg') ?>">
</div>
<i><a href="https://lovepik.com/images/illustration-aircraft.html" class="attribute-link">Aircraft Png vectors by Lovepik.com</a></i>

<h1 style="text-align: center" class="title"><?php echo $getAttrDescriptions[0]->attr_name ?></h1>
<?php $count = 0 ?>
<?php foreach ($getAttrDescriptions as $attrDesc) { ?>
<div class="col-md-10 offset-1 desc-box load" style="margin-bottom:20px;">
        <div class="star">
            <?php if ($count == 0) { ?>
                <h4 style="display: inline"><i class="fas fa-star"></i></h4>
                <h4 style="display: inline"> Top Summary </h4>
                <h4 style="display: inline"><i class="fas fa-star"></i></h4>
            <?php } ?>
        </div> 
        <div class="desc-inner-box">
            <p><?php echo $attrDesc->attr_description ?></p>
            <i id="like_icon" class="far fa-thumbs-up like" style="margin-right:0;float: left;"></i>

            <p  id="like_text<?php echo $attrDesc->blog_attractions_id; ?>" class="like " style="float: left;margin-right: 20px;" data-id="<?php echo $attrDesc->blog_attractions_id; ?>">Like this Summary</p>  
            <span style="color:blue;">Likes: <?php echo $attrDesc->totallikes ?></span>
            <span style="float:right;font-size: 20px;font-weight: 600;">&mdash; <?php echo $attrDesc->username ?></span>

        </div>

    </div>







    <?php
    $count++;
}
?>
<div class="row" style="font-size:20px;margin-bottom: 60px;">
        <div class="col-md-10 offset-md-1" >

            <div class="" align='center'>
                <p ><?php // echo $links;                  ?></p>
                <?php if (sizeof($getAttrDescriptions) > 9) { ?>
                    <a href="#" id="loadMore">Load More</a>
                <?php } ?>
            </div>

        </div>
    </div>
<script>
    var likedAttrArray =[];
  $(document).ready(function () {
        //setScreenHWCookie();
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

           //  alert(like);
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
