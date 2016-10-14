<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/9/16
 * Time: 3:03 PM
 */

class HomeView
{
    private $site;

    public function __construct(Site $site){
        $this->site = $site;
    }

    public function home_display()
    {
        $result = '<ul class="list-group">';
        //$result .= '<p id="new"><a href="/post/index-post.php?type=new">New Disaster</a></p>';


        $disasters = new Disasters($this->site);
        $all = $disasters->getDisasters();
        foreach($all as $row){
            $id = $row->getId();
            $name = $row->getName();
            $city = $row->getCity();
            $state = $row->getState();
            $date = $row->getReadableDate();
            $date = substr($date, 0, 10);
            $result.="<li class=\"list-group-item\"><a href=\"/post/index-post.php?type=existing&d_id=$id\">$name &nbsp;&nbsp; - &nbsp;&nbsp;$city, $state &nbsp;&nbsp; - &nbsp;&nbsp; $date</a></li>";
        }
        $result.='</ul>';

        return $result;
    }
}