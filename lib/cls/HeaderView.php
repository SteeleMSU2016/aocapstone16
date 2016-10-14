<?php
/**
 * Created by PhpStorm.
 * User: nicolelawrence
 * Date: 1/30/16
 * Time: 1:49 AM
 */

require 'save-modal.php';

class HeaderView
{
    /**
     * Generate HTML for the standard page header
     * param $title The page title
     */


    public static function header($page, $d_id)
    {
        $html = <<<HTML
        <!-- Header and navigation -->
        <header>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-4" id="aologo">
                            <img src='img/Auto-Owners.png' width='250' height="103" alt="logo">
                        </div>
                        <div class="col-sm-8">
                            <nav class="navbar navbar-default" role="navigation">
                                <ul class="nav navbar-nav">
HTML;

        $modal = ModalView::modal_call();

        if($page == 'index'){
            $html.='<li class="active"><a href="index.php">Home</a></li>';
            $html.='<li><a style="color: #F8F8F8">Map Page</a></li>';
            $html.='<li><a style="color: #F8F8F8">Policy Page</a></li>';
            $html.='<li><a style="color: #F8F8F8">Statistics Page</a></li>';
            $html.='<!-- Trigger the modal with a button -->';
            //$html.='<button type="button" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#myModal">Save</button>';
            $html.=$modal;
        }
        else if($page == 'map'){
            $html.='<li><a href="index.php">Home</a></li>';
            $html.='<li class="active"><a href="map.php">Map Page</a></li>';
            if($d_id == -1 ){
                $html.='<li><a style="color: #F8F8F8">Policy Page</a></li>';
                $html.='<li><a style="color: #F8F8F8">Statistics Page</a></li>';
            }
            else{
                $html.='<li><a href="policy.php">Policy Page</a></li>';
                $html.='<li><a href="statistical.php">Statistics Page</a></li>';
            }

            $html.='<!-- Trigger the modal with a button -->';
            $html.='<button type="button" class="btn btn-default navbar-btn" data-toggle="modal" data-target="#myModal">Save</button>';
            $html.=$modal;
        }
        else if($page == 'policy'){
            $html.='<li><a href="index.php">Home</a></li>';
            $html.='<li><a href="map.php">Map Page</a></li>';
            $html.='<li class="active"><a href="policy.php">Policy Page</a></li>';
            $html.='<li><a href="statistical.php">Statistics Page</a></li>';
        }
        else if($page == 'statistical'){
            $html.='<li><a href="index.php">Home</a></li>';
            $html.='<li><a href="map.php">Map Page</a></li>';
            $html.='<li><a href="policy.php">Policy Page</a></li>';
            $html.='<li class="active"><a href="statistical.php">Statistics Page</a></li>';
        }

        $html .=<<<HTML
                                    <a href="post/logout-post.php"><button type="button" class="btn btn-default navbar-btn">Log out</button></a>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </header>
HTML;
        return $html;
    }

}
?>