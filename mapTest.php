<?php

require 'lib/site.inc.php';
$view = new MapView($site)

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Catastrophic Claims Unit Map Page</title>
    <link href="css/bootstrapcss/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="css/mainTest.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&libraries=drawing&">
    </script>
    <script type="text/javascript" src="js/google_map_functions.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

</head>
<body>

    <?php echo HeaderView::header('map'); ?>

    <div class="container-fluid" id="mapContainer">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-3">
                    <div class="container-fluid" id="filterbar">
                        <?php echo $view->display_mapLegend(); ?>
                        <?php echo $view->display_filterBar(); ?>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>