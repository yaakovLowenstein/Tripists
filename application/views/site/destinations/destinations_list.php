<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<?php
$uri2 = $this->uri->segment(2);
//require_once(APPPATH . "views/site/destinations/tabs.php"); 
?>
<div class="nav nav-pills" id="destination-tabs">
    <ul class="nav nav-tabs tabs">
        <li class=" nav-item" ><a class="nav-link <?php if ($uri2 == 'map') { ?> active<?php } ?>"  href="<?php echo base_url('destinations/map') ?>">Map</a></li>
        <li class=" nav-item" ><a class="nav-link <?php if ($uri2 == 'list') { ?> active<?php } ?>"  href="<?php echo base_url('destinations/list') ?>">List</a></li>
    </ul>
</div>
<!--<h1>Select a Country</h1>-->
<div class="fluid-containter">
    <div class="row">
        <div class="col-md-3 offset-3">
            <?php
            $count = 0;
            $previousContinent = '';
            foreach ($getBlogCountries as $country) {
                $count++;
                if ($count == sizeof($getBlogCountries) / 2 || $count == round(sizeof($getBlogCountries) / 2)) {
                    ?>
                </div>   
                <div class="col-md-3">

                    <?php
                }
                if ($country->continent_code != $previousContinent) {
                    echo "<h3 class='destination_list_title'>" . $country->continent_name . "</h3>";
                }
                $previousContinent = $country->continent_code;
                if ($country->country_id != 230) {
                    ?>

                    <a class="destination_link" href="<?php echo base_url() . 'blogs?country=' . $country->country_id .' &continent='. $country->continent_code ?>"><?php echo $country->name ?></a>
                <?php } else { ?>

                    <p id="usa"class="destination_link" ><?php echo $country->name ?> <i class="fas fa-sort-down"></i></p>

                <?php } if ($country->country_id == 230) { ?>
                    <div id="state-container" style="display:none">
                        <div class="row " style="margin-top:10px;">
                            <?php
                            $stateCount = 0;
                            foreach ($getBlogsInUSA as $state) {
                                $stateCount++;
                                ?>
                                <div class=" col-md-4 col-sm-12"><a href="<?php echo base_url() . 'blogs?country=230&continent=5&state='.$state->state_id; ?>"><?php echo $state->state_name ?></a></div>
                                    <?php
                                    if ($stateCount == 3) {
                                        $stateCount = 0;
                                        ?>
                                    <!--</div>-->   
                                    <!--<div class="row">-->
                                    <?php
                                }
                            }
                            ?>
                            <?php if ($stateCount != 3) { ?>
                            </div>  </div>
                        <?php
                    } else
                        echo "</div>";
                }
            }
            ?>


        </div>


    </div>


</div>

<script>
    $("#usa").on("click", function () {
        $('#state-container').slideToggle();
        $('#usa i').toggleClass("fas fa-sort-down fas fa-caret-up");

    });
</script>
