<?php

require 'lib/site.inc.php';
$view = new HomeView($site);
$head = new Head_script();

?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $head->head(); ?>
</head>
<body>

<?php echo HeaderView::header('index', $_SESSION['d_id']); ?>

<div class="container-fluid" id="datasetContainer">
    <div class="panel panel-default">
        <div class="panel-heading" id="datasetHeading">
            <h3 id="indexHeading">Select a Disaster...</h3>
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
<script>
    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
    })
</script>
</html>

