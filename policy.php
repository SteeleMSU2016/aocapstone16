<?php

require 'lib/site.inc.php';

$view = new PolicyView($site);
$disasters = new Disasters($site);
$head = new Head_script();

?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $head->head(); ?>
    <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyCxeyV6EiZCU3Kb-ONQvZIC0fh9Jrf88Gw&libraries=drawing,places,geometry"></script>
    <script src="js/function.inc.js"></script>
</head>
<body>

    <?php echo HeaderView::header('policy', $_SESSION['d_id']); ?>
    <?php
    $type = $_SESSION['type'];
    $d_id = $_SESSION['d_id'];
    $disaster = $disasters->getDisasterFromId($d_id);
    echo("<form action=\"#\" method=\"get\">");
    echo("<input type=\"hidden\" id=\"type\" value=\"$type\">");
    echo("<input type=\"hidden\" id=\"d_id\" value=\"$d_id\">");
    echo("</form>")
    ?>

    <div class="container-fluid" id="mapContainer">
        <div class="panel panel-default">
            <div class="panel-heading" id="datasetHeading">
                <h3 style="float: left;">Policy Page</h3>
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
                                <div class="container-fluid" id="sortingbar">
                                    <?php echo $view->sortingBar(); ?>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="container-fluid" id="sortingbar">
                                    <div class="panel panel-default">
                                        <div class="panel-body policyPanelBody" >
                                            <div class="container-fluid" id="policyList">
                                                <?php echo $view->policyDisplay(); ?>
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
    </div>

    <!-- Modal -->
    <?php echo $view->DisplayModal();?>
</body>

</html>