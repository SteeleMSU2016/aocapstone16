<?php

/**
 * Created by PhpStorm.
 * User: cse498
 * Date: 2/9/16
 * Time: 3:03 PM
 */
class MapView
{
    private $site;

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    public static function display_mapLegend(){

        return <<<HTML
        <div class="panel panel-default" id="mapLegend">
            <div class="panel-body" id="mapLegendBody">
                <h4>Map Legend</h4>
                <div class="container-fluid" id="legend">
                <div class="box">
                    <div class="box1"></div><div class="boxTitle1">No Claim</div>
                </div>
                <div class="box">
                    <div class="box2"></div><div class="boxTitle2">New Claim</div>
                </div>
                <div class="box">
                    <div class="box3"></div><div class="boxTitle3">Assigned Claim</div>
                </div>
                <div class="box">
                    <div class="box4"></div><div class="boxTitle4">Closed Claim</div>
                </div>
                    </div>
            </div>
        </div>
HTML;
    }

    public static function display_weather(){

        return <<<HTML
        <div class="panel panel-default" id="mapLegend">
            <div class="panel-body" id="mapLegendBody">
            <h4>Weather Overlays</h4>
                <div class="container-fluid" id="legend">
                    <form id="weatherOverlay">
                    <div class="form-group" >
                        <input type="datetime-local" class="form-control overlayTime" placeholder="Start Time" id="startTime" onchange="overlay.time()">
                    </div>
                    <div class="form-group">
                      <select class="form-control" name="style" id="style" onchange="overlay.time()" >
                                <option value="radar">Overlay Style</option>
                                <option value="None">None</option>
                                <option value="radar">Radar</option>
                                <option value="alerts">Alerts</option>
                                <option value="stormreports">Storm Reports</option>
                                <option value="lightning-strike-density">Lightning Strike Density</option>
                                <option value="alerts-extreme-outlines">Tornado/Thunderstorm Warning</option>
                                <option value="alerts-severe">Severe Alerts</option>
                                <option value="alerts-fire">Fire Alerts</option>
                                <option value="alerts-flood">Flood Alerts</option>
                                <option value="alerts-wind">Wind Alerts</option>
                                <option value="alerts-winter">Winter Alerts</option>
                                <option value="stormreports-avalanche">Avalanche Report</option>
                                <option value="stormreports-blizzard">Blizzard Report</option>
                                <option value="stormreports-flood">Flood Report</option>
                                <option value="stormreports-fog">Fog Report</option>
                                <option value="stormreports-ice">Ice Report</option>
                                <option value="stormreports-hail">Hail Report</option>
                                <option value="stormreports-lightning">Lightning Report</option>
                                <option value="stormreports-rain">Rain Report</option>
                                <option value="stormreports-snow">Snow Report</option>
                                <option value="stormreports-tides">Tides Report</option>
                                <option value="stormreports-tornado">Tornado Report</option>
                                <option value="stormreports-wind">Wind Report</option>

                         </select>
                    </div>
                    <!--<div>-->
                        <!--<input type="button" class="btn" value="Weather Overlay" onclick="overlay.time()">-->
                    <!--</div>-->
                    <!--<div>-->
                        <!--<input type="button" class="btn" value="Weather Overlay Display" onclick="overlay.toggle()">-->
                    <!--</div>-->
                 </form>
                </div>
            </div>
        </div>
HTML;
    }

    public static function display_filterBar() {
        return <<<HTML
           <div class="panel panel-default" id="mapFilter">
                <div class="panel-body" id="mapFilterBody">
                    <h4>Map Filters</h4>
                    <div class="container-fluid" id="mapContainer">
                        <ul class="checkbox">
                          <li id="topCheckbox">
                            <input type="checkbox" name="AllCheck" id="AllCheck" checked>
                            <label id="filterLablel" for="AllCheck">All Filters</label>

                            <ul class="checkbox">
                              <li>
                                <input type="checkbox" name="SizeCheck" id="SizeCheck" checked>
                                <label id="filterLablel">Home Policy Size</label>

                                <ul class="checkbox">
                                  <li>
                                    <input type="checkbox" name="Size-0" id="Size-0" checked>
                                    <label id="filterLablel" for="Size-0">0 - $20K</label>
                                  </li>
                                  <li>
                                    <input type="checkbox" name="Size-20" id="Size-20" checked>
                                    <label id="filterLablel" for="Size-20">$20K - $50K</label>
                                  </li>
                                  <li>
                                    <input type="checkbox" name="Size-50" id="Size-50" checked>
                                    <label id="filterLablel" for="Size-50">$50K - $100K</label>
                                  </li>
                                  <li>
                                    <input type="checkbox" name="Size-100" id="Size-100" checked>
                                    <label id="filterLablel" for="Size-100">$100K - $150K</label>
                                  </li>
                                  <li>
                                    <input type="checkbox" name="Size-150" id="Size-150" checked>
                                    <label id="filterLablel" for="Size-150">$150K - $250K</label>
                                  </li>
                                  <li>
                                    <input type="checkbox" name="Size-250" id="Size-250" checked>
                                    <label id="filterLablel" for="Size-250">$250K - $500K</label>
                                  </li>
                                  <li>
                                    <input type="checkbox" name="Size-500" id="Size-500" checked>
                                    <label id="filterLablel" for="Size-500">$500K+</label>
                                  </li>
                                </ul>
                              </li>
                              <li>
                                <input type="checkbox" name="StatusCheck" id="StatusCheck" checked>
                                <label id="filterLablel" for="StatusCheck">Policy Status</label>
                                <ul class="checkbox">
                                  <li>
                                    <input type="checkbox" name="NoClaim" id="NoClaim" checked>
                                    <label id="filterLablel" for="NoClaim">No Claim</label>
                                  </li>
                                  <li>
                                    <input type="checkbox" name="NewClaim" id="NewClaim" checked>
                                    <label id="filterLablel" for="NewClaim">New Claim</label>
                                  </li>
                                  <li>
                                    <input type="checkbox" name="AssignedClaim" id="AssignedClaim" checked>
                                    <label id="filterLablel" for="AssignedClaim">Assigned Claim</label>
                                  </li>
                                  <li>
                                    <input type="checkbox" name="ClosedClaim" id="ClosedClaim" checked>
                                    <label id="filterLablel" for="ClosedClaim">Closed Claim</label>
                                  </li>
                                </ul>
                              </li>
                            </ul>
                          </li>
                        </ul>
                        <div>
                            <input type="button" class="btn btn-primary" value="Submit Filters" onclick="markerFilter()">
                        </div>
                    </div>
                </div>
            </div>
HTML;
    }
}