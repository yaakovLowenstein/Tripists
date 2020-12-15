

<div class="row" style="height: ">
    <div class="col-md-8" style="padding-left: 0"> 
        <form action="<?php echo base_url() . 'profile/blogs' ?>" style="width: 100%" method="get">
            <div class="row">
                <div class="col-md-3" style="display: inline-block;padding-left: ">
                    <input type="text" placeholder="Title" name="title" class="form-control add_btn"
                           value="<?php echo $this->input->get('title') ?>">

                </div>
                <div class="col-md-3"  style="display: inline-block">
                    <input type="text" placeholder="Dates" name="dates" class="form-control add_btn"
                           value="<?php echo isset($searchstring['dates']) ? $searchstring['dates'] : '' ?>">

                </div>
                <div class="col-md-3 top-row"  style="display: ">
                    <select  name="published" class="form-control" >
                        <option>--------Select----------</option>
                        <option <?php
                        if (isset($searchstring['published'])) {
                            if ($searchstring['published'] == 1) {
                                ?> selected="selected" <?php
                                }
                            }
                            ?> value="1">Published</option>
                        <option <?php
                        if (isset($searchstring['published'])) {
                            if ($searchstring['published'] == '0') {
                                ?> selected="selected" <?php
                                }
                            }
                            ?> value="0">Not Published</option>
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

        </form>

    </div>

    <div class="col-md-2 ">
        <form action="<?php echo base_url('profile/blogs/add/overview'); ?>"> 
            <input type ="submit" class="btn btn-primary add_btn " value="Add New Blog">
        </form>
    </div>
</div>

<div class="row blog-list" >
    <table class="table table-striped" width="100%">
        <thead>
            <tr>
                <th width="5%">Id#</th>
                <th width="20%">Title</th>
                <th width="15%">Dates</th>
                <th width="15%">Status</th>
                <th width='25%'>Location Tags</th>
                <th width="5%">likes</th>
                <th width='15%'></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = $this->input->get('per_page') == '' ? 1 : $this->input->get('per_page') + 1;
            foreach ($getAllBLogsByUser as $row) {
                ?>
            <td><?php echo $i ?></td>
            <td><?php echo $row->blog_title ?></td>
            <td><?php echo $row->blog_dates ?></td>
            <?php if ($row->publish == 1) { ?>
                <td><span class="published">Published</span></td>
            <?php } ?>
            <?php if ($row->publish == 0) { ?>
                <td><span class="not-published">Not Published</span></td>
            <?php } ?>
            <td>
                <?php
                $this->load->model('profile_model');
                $locations = $this->profile_model->getSummaryDataLocations($row->blog_id);
               $list = '';
                foreach ($locations as $location) {
                    $list .= $location->text . ', ';
                }
                echo substr($list, 0, -2);
                ?>            </td>

            <td>0</td>


            <td>
                <a href="<?php echo base_url() . 'profile/blogs/add/overview/' . $row->blog_id ?>"> <button id="edit-btn" class="btn btn-primary btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-edit fa-xs"></i></button></a>
                <!--<span class="tooltip" hidden="hidden">Edit</span>-->
                <a href="<?php echo base_url('publish/') . $row->blog_id ?>"> <button class="btn btn-success btn-sm" type="button"data-toggle="tooltip" data-placement="top" title="Publish" ><i class="fa fa-check fa-xs"></i></button></a>
                <button class="btn btn-danger btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-times fa-xs"></i></button>
                <button class="btn btn-info btn-sm" type="button" data-toggle="tooltip" data-placement="top" title="View Blog"><i class="fa fa-eye fa-xs"></i></button>
            </td>

            </tr>
            <?php
            $i++;
        }
        ?>
        </tbody>
    </table>
    <p><?php echo $links; ?></p>


    <!--        <h3 class="place-name">Colorado</h3>
            <p>January 2020</p>
            <p>
            <p>This sidebar is as tall as its content (the links), and is always shown.</p>
            <p>Scroll down the page to see the result.</p>
            <p>Some text to enable scrolling.. Lorem ipsum dolor sit amet, illum definitiones no quo, maluisset concludaturque et eum, altera fabulas ut quo. Atqui causae gloriatur ius te, id agam omnis evertitur eum. Affert laboramus repudiandae nec et. Inciderint efficiantur his ad. Eum no molestiae voluptatibus.</p>-->

    <!--    <div class="col-md-2">
            <p align="right">Likes: 12</p>
    
        </div>-->
</div> 






</div>
