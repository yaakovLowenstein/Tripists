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

<div class="fluid-containter">
    <div class="row">
        <div id="chartdiv2" class="col-md-10 offset-1" ></div>
    </div >
</div>








<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/maps.js"></script>
<script src="https://cdn.amcharts.com/lib/4/geodata/worldLow.js"></script>
<script src="https://cdn.amcharts.com/lib/4/geodata/usaLow.js"></script>

<script>
// Create map instance
    var chart = am4core.create("chartdiv2", am4maps.MapChart);
 //   chart.maxZoomLevel = 1;
    chart.seriesContainer.draggable = false;
    chart.seriesContainer.resizable = false;
// Set map definition
    chart.geodata = am4geodata_worldLow;
// Set projection
    chart.projection = new am4maps.projections.Miller();
// Create map polygon series
    var polygonSeries = chart.series.push(new am4maps.MapPolygonSeries());
// Make map load polygon (like country names) data from GeoJSON
    polygonSeries.useGeodata = true;
// Configure series
    var polygonTemplate = polygonSeries.mapPolygons.template;
    polygonTemplate.tooltipText = "{name}";
    polygonTemplate.fill = am4core.color("#74B266");
// Create hover state and set alternative fill color
    var hs = polygonTemplate.states.create("hover");
    // hs.properties.fill = am4core.color("#367B25");
    polygonSeries.data = [{
            id: "US",
            disabled: true
        }];
<?php
$data = '';
$countryCodes = '';
foreach ($getBlogCountries as $country) {
    if ($country->country_id != '230') {
        $countryCodes .= "'" . $country->code . "',";
        $data .= "{
                'id':'" . $country->code . "'," .
                "'name':'" . $country->name . "'," .
                "'url':'" . base_url() . "/blogs?country=" . $country->country_id . "&continent=" . $country->continent_code . "'" . "," .
                "'fill': am4core.color('#F05C5C')
               
    },"

        ;
    }
    else{
        if($country->state!=0){
            $stateData = "{
                'id':'US-" . $country->state_code . "'," .
                "'name':'" . $country->state_name . "'," .
                "'url':'" . base_url() . "/blogs?country=" . $country->country_id . "&continent=" . $country->continent_code."&state=".$country->state_id . "'" . "," .
                "'fill': am4core.color('#F05C5C')
               
    },"

        ;
        }
    }
}
$countryCodes = rtrim($countryCodes, ",");
?>
    polygonSeries.data = [<?php echo $data ?>];
    polygonTemplate.propertyFields.fill = "fill";
    polygonTemplate.propertyFields.url = "url";
    var legend = new am4maps.Legend();
    legend.parent = chart.chartContainer;
    legend.background.fill = am4core.color("#000");
    legend.background.fillOpacity = 0.05;
    legend.width = 120;
    legend.align = "right";
    legend.padding(20, 20);
    legend.data = [{
            "name": "Blogs",
            "fill": "#F05C5C"
        }, {
            "name": "No Blogs",
            "fill": "#74B266"
        }];
    legend.itemContainers.template.clickable = false;
    legend.itemContainers.template.focusable = false;
    //***********USA MAP**************
    var usaSeries = chart.series.push(new am4maps.MapPolygonSeries());
    usaSeries.geodata = am4geodata_usaLow;
    var polygonTemplate = usaSeries.mapPolygons.template;
    polygonTemplate.tooltipText = "{name}";
    polygonTemplate.fill = am4core.color("#74B266");
   // var hs = polygonTemplate.states.create("hover");
    //hs.properties.fill = am4core.color("#367B25");
    usaSeries.data = [<?php echo $stateData ?>];
 polygonTemplate.propertyFields.fill = "fill";
    polygonTemplate.propertyFields.url = "url";

</script>
