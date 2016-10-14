<?php

require 'lib/site.inc.php';
$view = new HomeView($site)


?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Catastrophic Claims Unit Home Page</title>
    <link href="css/bootstrapcss/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="css/mainTest.css" type="text/css" rel="stylesheet" />
</head>
<body>

    <?php echo HeaderView::header('index'); ?>

    <div class="container-fluid" id="datasetContainer">
        <div class="panel panel-default">
            <div class="panel-heading" id="datasetHeading">
                <a id="new" class="btn btn-default" href="/post/index-post.php?type=new" role="button">New Disaster</a>
            </div>
            <div class="panel-body datasetPanelBody" >
                <div class="container-fluid" id="datasetList">
                    <?php echo $view->home_display(); ?>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

