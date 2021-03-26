<div class="row ">
    <div class="col-md-10 offset-md-1">       
        <div class="col-md-12 " style="text-align: center">       
        </div>

        <form  action="<?php echo base_url('profile/liked/') . ($this->uri->segment(3)) ?>" style="width: 100%;display: none;" method="get" onsubmit="">

            <div class="row" id="liked_form">
                <div class="col-md-3" style="display: inline-block;padding-left: ">
                    <input id="search_title" type="text" placeholder="Title" name="title" class="form-control add_btn"
                           value="<?php echo $this->input->get('title') ?>" >

                </div>

                <div class="col-md-2" id="blog-list-users"  style="display: inline-block">

                    <select  data-placeholder="Blogger" class="users" name="user" id="user"  style="width:100%" data-tags='false'>      
                        <?php if (isset($searchstring['user']) && !empty($searchstring['user'])) { ?>

                            <option value="<?php echo $searchstring['user'] ?>" selected="selected"><?php echo $searchstring['username']; ?></option>
                            <?php ?>
                        <?php } ?>

                    </select>
                </div>
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
                <div class="col-md-2 blog-list-co" id="state-con" style="display: none">
                    <select data-placeholder="State" class="state " name="state" id="state"  style="width:100%" data-tags='false'>      
                        <?php if (isset($searchstring['state']) && !empty($searchstring['state'])) { ?>

                            <option value="<?php echo $searchstring['state'] ?>" selected="selected"><?php echo $searchstring['state_name']; ?></option>
                            <?php ?>
                        <?php } ?>
                    </select>
                </div>
               
            </div>
            <div class="row">

                <div class="col-md-4" style="padding-left: ">
                    <!--<label for="location" class="top-row">Location Tags*</label>-->

                    <select  class="location-mulitiple" name="locations[]" id="location" multiple="multiple" style="width:100%" data-tags='false'>      
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

        </form>
        <div class="col-md-12">
            <button id="search-toggle" class="btn " style="float: right;background-color: #47c4e1 "> <p style="color: white;margin: 0" >Search Bar<i class="fas fa-search" style="margin-left: 5px;"></i></p></button>
        </div>
    </div>
</div>

<script>
<?php if ($this->uri->segment(3) == "attractions") { ?>
        $("#search_title").attr("placeholder", "Attraction Name");
<?php } ?>

<?php if ($this->uri->segment(3) == "restaurants") { ?>
        $("#search_title").attr("placeholder", "Restaurant Name");
<?php } ?>
    $('#search-toggle').click(function () {
        $('form').slideToggle();
    });
    $(document).ready(function () {
<?php if ($this->input->get('search') == 'Search') { ?>
            $('form').show();
<?php } ?>
    });
</script>
