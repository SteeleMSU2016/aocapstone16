<?php

require 'lib/site.inc.php';
$view = new MapView($site);
$disasters = new Disasters($site);
$head = new Head_script();

?>
<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCxeyV6EiZCU3Kb-ONQvZIC0fh9Jrf88Gw&libraries=drawing,places,geometry">
    </script>

    <script src="//cdn.aerisapi.com/js/aerismaps-animation.min.js"></script>
    <script type="text/javascript" src="js/google_map_functions.js"></script>
    <script type="text/javascript" src="src/markerclusterer.js"></script>
    <script src="js/function.inc.js"></script>
    <?php echo $head->head(); ?>
</head>
<body>

<?php echo HeaderView::header('map', $_SESSION['d_id']); ?>
<?php
    $type = $_SESSION['type'];
    $d_id = $_SESSION['d_id'];
    $disaster = $disasters->getDisasterFromId($d_id);
    echo('<form action="#" method="get">');
    echo("<input type=\"hidden\" id=\"type\" value=\"$type\">");
    echo("<input type=\"hidden\" id=\"d_id\" value=\"$d_id\">");
?>

<div class="container-fluid" id="mapContainer">
    <div class="panel panel-default">
        <div class="panel-heading" id="datasetHeading">
            <H3 style="float: left;">Map Page</H3>
            <h3><?php
                    if($disaster != null){
                        echo $disaster->getName() . " - " . $disaster->getCity() . " - " . $disaster->getReadableDate();
                    }
                    else{
                        echo 'New Disaster';
                    }
                ?>
            </h3>
        </div>
        <div class="panel-body mapPanelBody">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-3">
                            <div class="container-fluid" id="filterbar">
                                <!--<?php //echo $view->display_mapLegend(); ?>-->
                                <?php echo $view->display_weather(); ?>
                                <?php echo $view->display_filterBar(); ?>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <!--<input id="pac-input" class="controls" type="text" placeholder="Search Box">-->
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
<script>
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
    });


    $('input[type="checkbox"]').change(function() {

        var checked = $(this).prop("checked"),
            container = $(this).parent(),
            siblings = container.siblings();

        container.find('input[type="checkbox"]').prop({
            indeterminate: false,
            checked: checked
        });

        function checkSiblings(el) {

            var parent = el.parent().parent(),
                all = true;

            el.siblings().each(function() {
                return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
            });

            if (all && checked) {

                parent.children('input[type="checkbox"]').prop({
                    indeterminate: false,
                    checked: checked
                });

                checkSiblings(parent);

            } else if (all && !checked) {

                parent.children('input[type="checkbox"]').prop("checked", checked);
                parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
                checkSiblings(parent);

            } else {

                el.parents("li").children('input[type="checkbox"]').prop({
                    indeterminate: true,
                    checked: false
                });

            }

        }

        checkSiblings(container);
    });
</script>

</html>