<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 3/2/16
 * Time: 5:00 PM
 */

class Head_script
{

    function head()
    {
        $head = <<<HTML

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Catastrophic Claims Unit Map Page</title>
    <link href="css/bootstrapcss/bootstrap.min.css" type="text/css" rel="stylesheet" />
    <link href="css/mainTest.css" type="text/css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
HTML;

        return $head;

    }

}