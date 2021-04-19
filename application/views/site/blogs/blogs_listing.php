<div class="fluid-containter">
 <?php require_once(APPPATH . "views/site/blogs/listing_header.php"); ?>


    <?php for ($i = 0; $i < sizeof($blogs); $i++) { ?>
        <div class="row top-row" >
            <div class="col-md-10 offset-md-2">                
                <div class="row">
                    <?php
                    for ($j = 0; $j < 3; $j++) {
                        if ($i + $j < sizeof($blogs)) {
                            ?>
                            <div class="col-md-3 col-sm-12" style="text-align: left">
                                <a href="<?php echo base_url('blog-details/') . $blogs[$i + $j]['blog_id'] ?>">    <?php if (!empty($blogs[$i + $j]['cover_pic_path'])) { ?>
                                    <div class="image-con-cover-thumb" style="margin-bottom: 0">  
                                            <img class="blog-cover-image img-cover-thumb" src="<?php echo base_url() . $blogs[$i + $j]['cover_pic_path'] ?>">
                                        </div>
                                    <?php } else { ?> 
                                        <div class="image-con-cover-thumb"> 
                                            <img class="blog-cover-image img-cover-thumb"  src="<?php echo base_url('uploads/1/default.jpg')?>">   
                                        </div>
                                    <?php } ?>
                                    <h3><?php echo $blogs[$i + $j]['blog_title'] ?></h3></a>  
                                <h5><strong>Destination: </strong><?php
                                    if ($blogs[$i + $j]['country'] == '230') {
                                        echo $blogs[$i + $j]['state_name'] . ", USA";
                                    } else {
                                        echo $blogs[$i + $j]['country_name'] . ", " . $blogs[$i + $j]['continent_name'];
                                    }
                                    ?></h5>
                                <h5><strong>By: </strong><?php echo $blogs[$i + $j]['username'] ?></h5>
                                <p><strong>Dates:</strong> <?php echo $blogs[$i + $j]['blog_dates'] ?></p>
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
    <div class="row" style="font-size:20px">
        <div class="col-md-10 offset-md-2" >
            <div class="col-md-3 offset-md-3" align='center'>
                <p ><?php echo $links; ?></p>

            </div>

        </div>
    </div>

</div>

<script>
<?php
$refer = $this->agent->referrer();
if ($refer == base_url() . "destinations/list" || $refer == base_url() . "destinations/map") {
    ?>

        $(document).ready(function () {
            $('#tooltip').tooltip("show");
            setTimeout(function () {
                $('#tooltip').tooltip('hide');
            }, 3000);

        });
<?php } ?>
</script>