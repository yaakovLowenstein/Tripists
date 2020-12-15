<div class="fluid-containter">
    <div class="row top-row">
        <div class="col-md-10 offset-md-2">       
            <div class="col-md-9 " style="text-align: center">       
                <h1 >BLOG POSTS</h1>
            </div>
            <form action="<?php echo base_url('blogs') ?>" style="width: 100%" method="get" onsubmit="">
                <h3 >Search<i class="fas fa-search" style="margin-left: 5px;"></i></h3>

                <div class="row">
                    <div class="col-md-3" style="display: inline-block;padding-left: ">
                        <input type="text" placeholder="Title" name="title" class="form-control add_btn"
                               value="<?php echo $this->input->get('title') ?>" >

                    </div>
                    <div class="col-md-3"  style="display: inline-block">
                        <input type="text" placeholder="Dates" name="dates" class="form-control add_btn"
                               value="<?php echo isset($searchstring['dates']) ? $searchstring['dates'] : '' ?>">

                    </div>
                    <div class="col-md-3" id="blog-list-users"  style="display: inline-block">

                        <select  data-placeholder="Author" class="users" name="user" id="user"  style="width:100%" data-tags='false'>      
                            <?php if (isset($searchstring['user']) && !empty($searchstring['user'])) { ?>

                                <option value="<?php echo $searchstring['user'] ?>" selected="selected"><?php echo $searchstring['username']; ?></option>
                                <?php ?>
                            <?php } ?>

                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4" style="padding-left: ">
                        <!--<label for="location" class="top-row">Location Tags*</label>-->
                        <select data-placeholder="Location Tags" class="location-mulitiple" name="locations[]" id="location" multiple="multiple" style="width:100%" data-tags='false'>      
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
                <div class="form-group col-md-2 offset-md-7 ">
                    <!--<form method="get" action="<?php echo base_url('blogs') ?>" >-->
                    <select name='orderBy' class="form-control float-lg-right" onchange="this.form.submit()">
                        <option <?php if ($this->input->get('orderBy') == 'Newest') { ?>  selected="selected"  <?php } ?>>Newest</option>
                        <option <?php if ($this->input->get('orderBy') == 'Oldest') { ?>  selected="selected"  <?php } ?>>Oldest</option>
                        <option <?php if ($this->input->get('orderBy') == 'Most Popular') { ?>  selected="selected"  <?php } ?>>Most Popular</option>
                        <option <?php if ($this->input->get('orderBy') == 'Most Liked') { ?>  selected="selected"  <?php } ?>>Most Liked</option>
                    </select>
                    <!--</form>-->
                </div>
            </form>

        </div>
    </div>

    <?php for ($i = 0; $i < sizeof($blogs); $i++) { ?>
        <div class="row top-row" >
            <div class="col-md-10 offset-md-2">                
                <div class="row">
                    <?php
                    for ($j = 0; $j < 3; $j++) {
                        if ($i + $j < sizeof($blogs)) {
                            ?>
                            <div class="col-md-3 " style="text-align: left">
                                <a href="<?php echo base_url('blog-details/') . $blogs[$i + $j]['blog_id'] ?>">    <?php if (!empty($blogs[$i + $j]['cover_pic_path'])) { ?>
                                        <img class="blog-cover-image" width="335" height="225" src="<?php echo base_url() . $blogs[$i + $j]['cover_pic_path'] ?>">
                                    <?php } else echo '<img class="blog-cover-image" width="335" height="225" src="' . base_url('uploads/1/default.jpg') . '">'; //"<p>Image</p> <p>Not</p> <p>Available</p>"    ?>
                                    <h3><?php echo $blogs[$i + $j]['blog_title'] ?></h3></a>  
                                <h5><?php echo $blogs[$i + $j]['username'] ?></h5>
                                <p><?php echo $blogs[$i + $j]['blog_dates'] ?></p>
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

