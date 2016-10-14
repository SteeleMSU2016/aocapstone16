<?php
/**
 * Created by PhpStorm.
 * User: nicolelawrence
 * Date: 3/10/15
 * Time: 7:34 PM
 */
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Site $site) {

    // Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setRoot('');
    $site->dbConfigure("mysql:host=localhost;dbname=auto-owners",
        'root',       // Database user
        'AOcapstone16',     // Database password
        '');            // Table prefix
};