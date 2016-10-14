<?php

require 'lib/site.inc.php';

$view = new StatisticalView($site);
$disasters = new Disasters($site);
$head = new Head_script();

?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $head->head(); ?>
</head>
<body>
    <?php
        echo HeaderView::header('statistical', $_SESSION['d_id']);
        $type = $_SESSION['type'];
        $d_id = $_SESSION['d_id'];
        $disaster = $disasters->getDisasterFromId($d_id);
        echo("<form action=\"#\" method=\"get\">");
        echo("<input type=\"hidden\" id=\"type\" value=\"$type\">");
        echo("<input type=\"hidden\" id=\"d_id\" value=\"$d_id\">");
    ?>

    <div class="container-fluid" id="statsContainer">
        <div class="panel panel-default">
            <div class="panel-heading" id="datasetHeading">
                <h3 style="float: left;">Statistics Page</h3>
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
            <div class="panel-body mapPanelBody" >
                <div class="container-fluid" id="statsList">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-7" id="statsDisplayLeft">
                                <div class="panel panel-default" id="statsPanelBodyLeft">
                                    <div class="panel-body">
                                        <div class="container-fluid">
                                            <div id="barchart_material 1" style="height: 200px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default" id="statsPanelBodyLeft">
                                    <div class="panel-body">
                                        <div class="container-fluid">
                                            <div id="barchart_material 2" style="height: 225px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5" id="statsDisplayRight">
                                <div class="panel panel-default" id="statsPanelBodyRight">
                                    <div class="panel-heading">
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                Claims by Category
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                                <li><a>Claims by Category</a></li>
                                                <li role="separator" class="divider"></li>
                                                <li><a>Agency</a></li>
                                                <li><a>Assigned Branch/Territory</a></li>
                                                <li><a>Assignment Status</a></li>
                                                <li><a>Independent Adjuster</a></li>
                                                <li><a>Property Type</a></li>
                                                <li><a>City</a></li>
                                                <li><a>State</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="panel-body" id="piechart">
                                        <div class="container-fluid">
                                            <div id="piechart" style="height: 455px;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript" src="js/statisticalFunctions.js"></script>
</html>