<?php
/**
 * Created by PhpStorm.
 * User: nicolelawrence
 * Date: 1/30/16
 * Time: 1:49 AM
 */

class ModalView
{
    /**
     * returns an HTML string
     * @return string
     */
    public static function modal_call()
    {
        if($_SESSION['type'] == 'new'){
        $html = <<<HTML

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Save Disaster</h4>
            </div>
            <div class="modal-body">
                <div class="form-group dis_save">
                    <div class="row">
                        <label for="name">Disaster Name:&nbsp;</label></br>
                        <input type="text"  class="form-control" name="name" id="disaster_name"><br>
                    </div>
                    <div class="row" >
                        <label for="city">Disaster City:&nbsp;</label></br>
                        <input  class="form-control" type="text" name="city" id="disaster_city"><br>
                    </div>
                    <div class="row">
                        <label for="state">Disaster State:&nbsp;</label></br>
                            <select class="form-control" name="state" id="disaster_state" >
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">District Of Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                            </select></br>
                    </div>
                    <div class="row">
                        <label for="date">Disaster Date:&nbsp;</label></br>
                        <input class="form-control" type="date" name="date" id="disaster_date"><br>
                    </div>
                    <div class="row">
                        <label for="reason">Disaster Reason:&nbsp;</label></br>
                         <select class="form-control" name="reason" id="disaster_reason" >
                                <option value="Tornado">Tornado</option>
                                <option value="Wind">Wind</option>
                                <option value="Hurricane">Hurricane</option>
                                <option value="Tropical Storm">Tropical Storm</option>
                                <option value="Fire">Fire</option>
                                <option value="Flood">Flood</option>
                                <option value="Ice">Ice</option>
                                <option value="Snow">Snow</option>
                         </select>
                     </div>

                        <span id="error" >&nbsp;</span>

                </div>
            </div>

            <div class="modal-footer">
                <div class="container-fluid">
                    <button type="button" class="btn btn-primary" style="float: left; margin-bottom: 0px; margin-left: .5em;" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" style="float: right;" onclick="save_click()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
HTML;
             return $html;
        }
        else{
        $html = <<<HTML

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Update Disaster</h4>
            </div>
            <div class="modal-body">
                <div class="form-group dis_save">
                    <label for="name">Are you sure you &nbsp;</label><br>
                    <label for="name">want to save changes? &nbsp;</label>
                </div>
            </div>
            <div class="modal-footer">
                <div class="container-fluid">
                    <button type="button" class="btn btn-primary" style="float: left; margin-bottom: 0px; margin-left: .5em;" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" style="float: right;" onclick="update_click()">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>
HTML;
            return $html;
        }
    }
}