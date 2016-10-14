<?php

require 'lib/site.inc.php';

$view = new StatisticalView($site);

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Catastrophic Claims Unit Stat Page</title>
    <link href="css/bootstrapcss/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="css/mainTest.css" type="text/css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
    <?php echo HeaderView::header('statistical'); ?>
    <?php
    $type = $_SESSION['type'];
    $d_id = $_SESSION['d_id'];
    echo("<form action=\"#\" method=\"get\">");
    echo("<input type=\"hidden\" id=\"type\" value=\"$type\">");
    echo("<input type=\"hidden\" id=\"d_id\" value=\"$d_id\">");
    ?>

    <div class="container-fluid" id="datasetContainer">
        <div class="panel panel-default">
            <div class="panel-body datasetPanelBody" >
                <div class="container-fluid" id="datasetList">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-6" id="statsDisplayLeft">
                                <div class="panel panel-default" id="statsPanelBodyLeft">
                                    <div class="panel-heading">
                                        <h4>Claims Count Over Last 10 Days</h4>
                                    </div>
                                    <div class="panel-body">
                                        <img src="img/0YA7V.png" width='250' height='175' alt='pie chart'/>
                                    </div>
                                </div>
                                <div class="panel panel-default" id="statsPanelBodyLeft">
                                    <div class="panel-heading">
                                        <h4>Claims Count by Agency</h4>
                                    </div>
                                    <div class="panel-body">
                                        <img src="img/0YA7V.png" width='250' height='175' alt='pie chart'/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" id="statsDisplayRight">
                                <div class="panel panel-default" id="statsPanelBodyRight">
                                    <div class="panel-heading">
                                        <h4>Claims by Category</h4>
                                    </div>
                                    <div class="panel-body">
                                        <img src="img/pie_chart.jpg" width='300' height='300' alt='pie chart'/>
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
</html>