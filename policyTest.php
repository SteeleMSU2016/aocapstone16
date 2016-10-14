<?php

require 'lib/site.inc.php';
$view = new PolicyView($site)

?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Catastrophic Claims Unit Policy Page</title>
    <link href="css/bootstrapcss/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="css/mainTest.css" type="text/css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>

</head>
<body>

    <?php echo HeaderView::header('policy'); ?>

    <div class="container-fluid" id="mapContainer">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-sm-3">
                    <div class="container-fluid" id="filterbar">
                        <?php echo $view->sortingBar(); ?>
                    </div>
                </div>
                <div class="col-sm-9">
                    <div class="panel panel-default">
                        <div class="panel-heading" id="datasetHeading">
                            <a id="new" class="btn btn-default" href="" role="button">Load Disaster</a>
                        </div>
                        <div class="panel-body datasetPanelBody" >
                            <div class="container-fluid" id="datasetList">
                                <?php echo $view->policyDisplay(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>