<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/9/16
 * Time: 3:03 PM
 */
class StatisticalView
{

    private $site;

    /**
     * Constructor
     * @param Site $site
     */
    public function __construct(Site $site){
        $this->site = $site;
    }


    /**
     * Displays HTML string for stats page
     * @return string
     */
    public static function stat_display()
    {
        $stat_content = <<<HTML
        <!-- filter and policies -->

        <div class="container-fluid text-center" >

            <div class="row stat_content" >
                <div class="col-sm-10">

                    <div class="row map_content1">
                        <div class="col-sm-2 text-left sidenav" >
HTML;
        $stat_content .= StatisticalView::filter_bar();

        $stat_content .= <<<HTML
                        </div >
                    <div class="col-sm-4 graphs">
                        <p>Hello World</p>
                    </div>
                    <div class="col-sm-4 pie_chart">
                        <p>Hello World</p>

                    </div>
HTML;
        return $stat_content;
    }



}


