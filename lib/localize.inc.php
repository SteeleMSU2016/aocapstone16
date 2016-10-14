<?php
/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 1/30/16
 * Time: 10:20 AM
 */
return function(Site $site){

    $site->setRoot('');
    $site->dbConfigure("mysql:host=localhost;dbname=auto-owners", "root", "AOcapstone16");
};