<?php
/**
 * Created by PhpStorm.
 * User: Nick
 * Date: 2/18/2016
 * Time: 7:11 PM
 *
 * returns serialized list of disasters in database
 */

require 'mobile.inc.php';

$disasters= new Disasters($site);
$query = $disasters->getDisasters();
$result = "[";
        $end = count($query) - 1;
        $i = 0;
        foreach($query as $row){
            $result.=$row->serialize();
            if($i != $end) {
                $result .= ",";
            }
            $i+=1;
        }
        $result.="]";

echo($result);
