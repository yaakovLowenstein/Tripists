<div class="row top-row">
    <div class="col-md-10 offset-md-2">       
        <div class="col-md-9 " style="text-align: center">       
            <h1 >BLOG POSTS</h1>
        </div>
        <form action="<?php echo base_url($this->uri->segment(1)) ?>" style="width: 100%" method="get" onsubmit="">
            <h3 >Search<i class="fas fa-search" style="margin-left: 5px;"></i></h3>

            <div class="row">
                <div class="col-md-3" style="display: inline-block;padding-left: ">
                    <input id="search_title" type="text" placeholder="Title" name="title" class="form-control add_btn"
                           value="<?php echo $this->input->get('title') ?>" >

                </div>
                <?php if ($this->uri->segment(1) == "blogs") { ?>
                    <div class="col-md-3"  style="display: inline-block">
                        <input type="text" placeholder="Dates" name="dates" class="form-control add_btn"
                               value="<?php echo isset($searchstring['dates']) ? $searchstring['dates'] : '' ?>">

                    </div>
                <?php } ?>
                <div class="col-md-3" id="blog-list-users"  style="display: inline-block">

                    <select  data-placeholder="Blogger" class="users" name="user" id="user"  style="width:100%" data-tags='false'>      
                        <?php if (isset($searchstring['user']) && !empty($searchstring['user'])) { ?>

                            <option value="<?php echo $searchstring['user'] ?>" selected="selected"><?php echo $searchstring['username']; ?></option>
                            <?php ?>
                        <?php } ?>

                    </select>
                </div>

            </div>
            <div class="row">
                <div class="col-md-2 blog-list-co" >
                    <!--<label for="location" class="top-row">Location Tags*</label>-->                        
                    <select data-placeholder="Continent" class="continent " name="continent" id="continent"  style="width:100%" data-tags='false'>      
                        <?php if (isset($searchstring['continent']) && !empty($searchstring['continent'])) { ?>

                            <option value="<?php echo $searchstring['continent'] ?>" selected="selected"><?php echo $searchstring['continent_name']; ?></option>
                            <?php ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-2 blog-list-co" >
                    <select data-placeholder="Country" class="country " name="country" id="country"  style="width:100%" data-tags='false'>      
                        <?php if (isset($searchstring['country']) && !empty($searchstring['country'])) { ?>

                            <option value="<?php echo $searchstring['country'] ?>" selected="selected"><?php echo $searchstring['country_name']; ?></option>
                            <?php ?>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-1 blog-list-co" id="state-con" style="display: none">
                    <select data-placeholder="State" class="state " name="state" id="state"  style="width:100%" data-tags='false'>      
                        <?php if (isset($searchstring['state']) && !empty($searchstring['state'])) { ?>

                            <option value="<?php echo $searchstring['state'] ?>" selected="selected"><?php echo $searchstring['state_name']; ?></option>
                            <?php ?>
                        <?php } ?>
                    </select>
                </div>
                <span id="tooltip"  data-toggle="tooltip" data-placement="top" title="To search more specific than country (or state) use the 
                      destination tags field."></span>

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
            <div class="row">
                <div class="col-md-4 ">
                    <ul class="nav nav-pills" >
                        <li class="nav-item">
                            <a class="nav-link <?php
                             $params   = $_SERVER['QUERY_STRING'];
                            if ($this->uri->segment(1) == "blogs") {
                                echo 'active';
                            }
                            ?>"  href="<?php echo base_url('blogs?').$params ?>" >Blogs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php
                            if ($this->uri->segment(1) == "attractions") {
                                echo 'active';
                            }
                            //$params   = $_SERVER['QUERY_STRING']; //my_id=1,3
                            

                            ?>" href="<?php echo base_url('attractions?').$params ?>" >Attractions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php
                            if ($this->uri->segment(1) == "restaurants") {
                                echo 'active';
                            }
                            ?>" href="<?php echo base_url('restaurants?').$params ?>">Restaurants</a>
                        </li>

                    </ul>
                </div>
                <div class="form-group col-md-2 offset-md-7">
                    <!--<form method="get" action="<?php echo base_url('blogs') ?>" >-->
                    <span>Sort By</span>
                    <select name='orderBy' class="form-control float-lg-right" onchange="this.form.submit()">
                        <option <?php if ($this->input->get('orderBy') == 'Newest') { ?>  selected="selected"  <?php } ?>>Newest</option>
                        <option <?php if ($this->input->get('orderBy') == 'Oldest') { ?>  selected="selected"  <?php } ?>>Oldest</option>
                        <?php if ($this->uri->segment(1) == "blogs") { ?>
                            <option <?php if ($this->input->get('orderBy') == 'Most Popular') { ?>  selected="selected"  <?php } ?>>Most Popular</option>
                        <?php } ?>
                        <option <?php if ($this->input->get('orderBy') == 'Most Liked') { ?>  selected="selected"  <?php } ?>>Most Liked</option>
                    </select>
                    <!--</form>-->
                </div>
            </div>
        </form>

    </div>
</div>

<script>
<?php if ($this->uri->segment(1) == "attractions") { ?>
        $("#search_title").attr("placeholder", "Attraction Name");
<?php } ?>

<?php if ($this->uri->segment(1) == "restaurants") { ?>
        $("#search_title").attr("placeholder", "Restaurant Name");
<?php } ?>
</script>
