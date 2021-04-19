<link href="<?php echo base_url("bower_components/css/main.css") ?>" rel="stylesheet">

<div class="fluid-containter" style="width: 100%">


    <div class="row d">
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-midnight-bloom">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading"><h3>Total Blogs Published</h3></div>
                        <!--<div class="widget-subheading">Last year expenses</div>-->
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?php echo $getTotals[0]->totalBlogs ?></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-night-fade">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading"><h3>Total Blog Likes</h3></div>
                        <!--<div class="widget-subheading">Last year expenses</div>-->
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?php echo $getTotals[0]->totalLikes ?></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-arielle-smile">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading"><h3>Total Views</h3></div>
                        <!--<div class="widget-subheading">Total Clients Profit</div>-->
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?php echo $getTotals[0]->totalViews ?></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-grow-early">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading"><h3>Subscribers</h3></div>
                        <!--<div class="widget-subheading">People Interested</div>-->
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span><?php echo $getTotals[0]->numSubscribers ?></span></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <h3>Blogs published per month</h3>
    <div id="chartdiv"></div>
    <div class="row top-row">
        <div class="col-md-4" style="display:inline-block;">
            <h3>Top 5 Blogs</h3>
            <table id="blogsTable" style="width:80%;">
                <tr>
                    <!--When a header is clicked, run the sortTable function, with a parameter, 0 for sorting by names, 1 for sorting by country:-->  
                    <th >Title</th>
                    <!--<th >Views</th>-->
                    <th >Likes</th>

                </tr>
                <?php foreach ($getTopBlogs[0] as $row) { ?>
                    <tr >
                        <td><?php echo $row['blog_title']; ?></td>
                        <!--<td><?php // echo $row['views'];   ?></td>-->
                        <td><?php echo $row['likes']; ?></td>

                    </tr>
                <?php } ?>

            </table>
        </div>
        <div class="col-md-4" style="display:inline-block;">
            <h3>Top 5 Attractions</h3>

            <table id="attrTable" style="width:80%;">
                <tr>
                    <!--When a header is clicked, run the sortTable function, with a parameter, 0 for sorting by names, 1 for sorting by country:-->  
                    <th >Title</th>
                    <!--<th >Views</th>-->
                    <th >Likes</th>

                </tr>
                <?php foreach ($getTopBlogs[1] as $row) { ?>
                    <tr >
                        <td><?php echo $row['attr_name']; ?></td>
                        <!--<td><?php // echo $row['views'];   ?></td>-->
                        <td><?php echo $row['likes']; ?></td>

                    </tr>
                <?php } ?>
            </table>
        </div>
        <div class="col-md-4"style="display:inline-block;margin-left: -10px;">
            <h3>Top 5 Restaurants</h3>

            <table id="restTable"style="width:80%;">
                <tr>
                    <!--When a header is clicked, run the sortTable function, with a parameter, 0 for sorting by names, 1 for sorting by country:-->  
                    <th >Title</th>
                    <!--<th >Views</th>-->
                    <th >Likes</th>

                </tr>
                <?php foreach ($getTopBlogs[2] as $row) { ?>
                    <tr  >
                        <td><?php echo $row['rest_name']; ?></td>
                        <!--<td><?php // echo $row['views'];   ?></td>-->
                        <td><?php echo $row['likes']; ?></td>

                    </tr>
                <?php } ?>

            </table>
        </div>
    </div>
   
</div>
</div>
<!-- Styles -->
<style>
    #chartdiv {
        width: 100%;
        height: 300px;
    }

</style>
<style>
    table {
        border-spacing: 0;
        /*width: 100%;*/
        border: 1px solid #ddd;
    }

    th {
        cursor: pointer;
    }

    th, td {
        text-align: left;
        padding: 16px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2
    }
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
    am4core.ready(function () {

// Themes begin
        am4core.useTheme(am4themes_animated);
// Themes end

        var chart = am4core.create("chartdiv", am4charts.XYChart);
        var data = [];
        var value = 50;
        var d = new Date();
        d.setMonth(d.getMonth() - 10);
        //alert(d);
        //  alert(d);
        var m = d.getMonth();
        var y = d.getFullYear();
        var monthsFromDb = Array();
        var yearsFromDb = Array();
        var blogsPerMonth = Array();
<?php foreach ($getTotals as $row) { ?>
            monthsFromDb.push(<?php echo $row->month; ?>);
            //  yearsFromDb.push(<?php echo $row->year; ?>);
            blogsPerMonth.push(<?php echo $row->blogsPerMonth; ?>);
<?php } ?>

//alert(m);
        for (var i = m; i <= 10 + m; i++) {
            //   alert(i);
            var date = new Date(y, i, i);
            var newYear = date.getFullYear();
            var newMonth = date.getMonth();

//  date.setHours(0,0,0,0);
            date.setDate(i);
            value = 0;
//  value -= Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);
            for (var j = 0; j < monthsFromDb.length; j++) {
                console.log("year: " + newYear + " month: " + i + " dbMonth: " + monthsFromDb[j] + " blog: " + blogsPerMonth[j])

                if (parseInt(monthsFromDb[j]) - 1 == newMonth) {
                    value = blogsPerMonth[j];
                    break;
                }
            }

            // value = i;
            data.push({date: date, value: value});
        }
        //  alert(data.lenth)
        chart.data = data;
        // Create axes
        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 60;
        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        // Create series
        var series = chart.series.push(new am4charts.LineSeries());
        series.dataFields.valueY = "value";
        series.dataFields.dateX = "date";
        series.tooltipText = "{value}"

        series.tooltip.pointerOrientation = "vertical";
        series.bullets.push(new am4charts.CircleBullet());
        chart.cursor = new am4charts.XYCursor();
        chart.cursor.snapToSeries = series;
        chart.cursor.xAxis = dateAxis;
        //chart.scrollbarY = new am4core.Scrollbar();
        //        chart.scrollbarX = new am4core.Scrollbar();

    }); //end am4core.ready()
</script>

<script>
    function sortTable(ele, n) {

        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = ele.parentElement.parentElement;
        //document.getElementById("blogsTable");
        switching = true;
        //Set the sorting direction to ascending:
        dir = "asc";
        /*Make a loop that will continue until
         no switching has been done:*/
        while (switching) {
            //start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /*Loop through all table rows (except the
             first, which contains table headers):*/
            for (i = 1; i < (rows.length - 1); i++) {
                //start by saying there should be no switching:
                shouldSwitch = false;
                /*Get the two elements you want to compare,
                 one from current row and one from the next:*/
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /*check if the two rows should switch place,
                 based on the direction, asc or desc:*/
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        //if so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /*If a switch has been marked, make the switch
                 and mark that a switch has been done:*/
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                //Each time a switch is done, increase this count by 1:
                switchcount++;
            } else {
                /*If no switching has been done AND the direction is "asc",
                 set the direction to "desc" and run the while loop again.*/
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>
