<div class="fluid-containter">
    <div class="row top-row">
        <div class="col-md-10 offset-md-2">       
            <div class="col-md-9 " style="text-align: center">       
                <h1 >BLOGGERS</h1>
            </div>
            <form action="<?php echo base_url('bloggers/list') ?>" style="width: 100%" method="get" onsubmit="">
                <h3 >Search<i class="fas fa-search" style="margin-left: 5px;"></i></h3>

                <div class="row">
                    <!--                    <div class="col-md-3" style="display: inline-block;padding-left: ">
                                            <input type="text" placeholder="Title" name="title" class="form-control add_btn"
                                                   value="<?php echo $this->input->get('title') ?>" >
                    
                                        </div>
                                        <div class="col-md-3"  style="display: inline-block">
                                            <input type="text" placeholder="Dates" name="dates" class="form-control add_btn"
                                                   value="<?php echo isset($searchstring['dates']) ? $searchstring['dates'] : '' ?>">
                    
                                        </div>-->
                    <div class="col-md-2 blog-list-co" id="blogger-list-users">

                        <select  data-placeholder="Blogger" class="users" name="user" id="user"  style="width:100%" data-tags='false'>      
                            <?php if (isset($searchstring['user']) && !empty($searchstring['user'])) { ?>

                                <option value="<?php echo $searchstring['user'] ?>" selected="selected"><?php echo $searchstring['username']; ?></option>
                                <?php ?>
                            <?php } ?>
                        </select>
                    </div>



                    <div class="col-md-2 blog-list-co" >
                        <!--<label for="location" class="top-row">Location Tags*</label>-->                        
                        <select data-placeholder="Destination Continent" class="continent " name="continent" id="continent"  style="width:100%" data-tags='false'>      
                            <?php if (isset($searchstring['continent']) && !empty($searchstring['continent'])) { ?>

                                <option value="<?php echo $searchstring['continent'] ?>" selected="selected"><?php echo $searchstring['continent_name']; ?></option>
                                <?php ?>
                            <?php } ?>

                        </select>
                    </div>
                    <div class="col-md-2 blog-list-co" >
                        <select data-placeholder="Destination Country" class="country " name="country" id="country"  style="width:100%" data-tags='false'>      
                            <?php if (isset($searchstring['country']) && !empty($searchstring['country'])) { ?>

                                <option value="<?php echo $searchstring['country'] ?>" selected="selected"><?php echo $searchstring['country_name']; ?></option>
                                <?php ?>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-2 blog-list-co" id="state-con" style="display: none">
                        <select data-placeholder="Destination State" class="state " name="state" id="state"  style="width:100%" data-tags='false'>      
                            <?php if (isset($searchstring['state']) && !empty($searchstring['state'])) { ?>

                                <option value="<?php echo $searchstring['state'] ?>" selected="selected"><?php echo $searchstring['state_name']; ?></option>
                                <?php ?>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row top-row">
                    <div class="col-md-3" style="padding-left: ">
                        <!--<label for="location" class="top-row">Location Tags*</label>-->

                        <select data-placeholder="Destination Tags" class="location-mulitiple" name="locations[]" id="location" multiple="multiple" style="width:100%" data-tags='false'>      
                            <?php
                            if (isset($searchstring['locations']) && !empty($searchstring['locations'])) {
                                foreach ($searchstring['locations'] as $RowC) {
                                    ?>
                                    <option value="<?php echo $RowC->id; ?>" selected="selected"><?php echo $RowC->text; ?></option>
                                <?php } ?>
                            <?php } ?>

                        </select>

                    </div>
                    <div class="col-md-4">
                        <input name="search" type ="submit" class="btn btn-success add_btn " value="Search" style="margin-top:0">
                        <input name="view_all" type ="submit" class="btn btn-success add_btn " value="View All" style="margin-top:0">
                    </div></div>
                <!--<input hidden="hidden" value="<?php echo $this->input->get('orderBy') ?>" name="orderBy">-->

                <!--                <div class="form-group col-md-2 offset-md-7 ">
                                    <form method="get" action="<?php echo base_url('blogs') ?>" >
                                    <span>Sort By</span>
                                    <select name='orderBy' class="form-control float-lg-right" onchange="this.form.submit()">
                                        <option <?php if ($this->input->get('orderBy') == 'Newest') { ?>  selected="selected"  <?php } ?>>Newest</option>
                                        <option <?php if ($this->input->get('orderBy') == 'Oldest') { ?>  selected="selected"  <?php } ?>>Oldest</option>
                                        <option <?php if ($this->input->get('orderBy') == 'Most Popular') { ?>  selected="selected"  <?php } ?>>Most Popular</option>
                                        <option <?php if ($this->input->get('orderBy') == 'Most Liked') { ?>  selected="selected"  <?php } ?>>Most Liked</option>
                                    </select>
                                    </form>
                                </div>-->
            </form>

        </div>
    </div>

    <?php for ($i = 0; $i < sizeof($getBloggers); $i++) { ?>
        <div class="row top-row" >
            <div class="col-md-10 offset-md-2">                
                <div class="row">
                    <?php
                    for ($j = 0; $j < 3; $j++) {
                        if ($i + $j < sizeof($getBloggers)) {
                            ?>
                            <div class="col-md-3 " style="text-align: left">
                                <a href="<?php echo base_url('bloggers/details/') . $getBloggers[$i + $j]['id'] ?>">    <?php if (!empty($getBloggers[$i + $j]['profile_pic_path'])) { ?>
                                        <div class="prof-image-con">
                                            <img class="prof-img"  src="<?php echo base_url() . $getBloggers[$i + $j]['profile_pic_path'] ?>">
                                        </div>   
                                    <?php }// else echo '<img class="blog-cover-image" width="335" height="225" src="' . base_url('uploads/1/default.jpg') . '">'; //"<p>Image</p> <p>Not</p> <p>Available</p>"    ?>
                                    <h3><?php echo $getBloggers[$i + $j]['username'] ?></h3></a>  
                                <h4 style="display: inline"><a href="<?php echo base_url() . "bloggers/details/" . $getBloggers[$i + $j]['id'] ?>" class="col-md-4" style="padding: 0;">Bio</a></h4>
                                <h4 style="display: inline">  <a href="<?php echo base_url() . 'blogs?user=' . $getBloggers[$i + $j]['id']; ?>" class="col-md-4" style="display: inline">Blogs</a></h4>
                                <h5><?php // echo $getBloggers[$i + $j]['country']     ?></h5>
                                <p><?php echo character_limiter($getBloggers[$i + $j]['about'], 300, '<a href="#"> more...</a>') ?></p>
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