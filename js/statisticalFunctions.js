/**
 * Created by nicolelawrence on 3/31/16.
 */

var type = document.getElementById('type').value;
var d_id = document.getElementById('d_id').value;

if (d_id != -1){

    $('#myModal').on('shown.bs.modal', function () {
        $('#myInput').focus()
    });

    /**
     * This function runs when the piechart dropdown gets changed
     * It updates the text in the dropdown and runs the ajax call
     * for the information selected
     * */
    $(function(){
        $(".dropdown-menu li a").click(function(){
            $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
            claimsByCategory($(this).text());
        });
    });


    /**
     * The entire section below is creating and executing the
     * Ajax calls needed to display the statistics of each
     * disaster.
     */

    google.charts.load("current", {packages: [ "corechart"]});


    /**
     * Count Claims over 10 Days
     */

    var countDays_url = "/ajax/statisticAjax.php?action=CountDays&d_id="+d_id;

    $.ajax({url: countDays_url, success: function(countDayResult){
        google.charts.setOnLoadCallback(drawDayCount);
        function drawDayCount() {

            /**
             * If we get a result back
             * - Format the dates returned
             * - Add any dates not in the dataset
             * - Display column chart
             */

            if(countDayResult.length > 1) {
                var date = JSON.parse(countDayResult);

                var graphArray = new Array(new Array('Date', 'Count'));
                var currDate = new Date();
                var inArray = false;

                var i = 0;
                while (i < 10){
                    for(var j = 1; j < date.length; j++){

                        var checkDateString = currDate.getFullYear() +"-";
                        if((currDate.getMonth()+1) < 10){
                            checkDateString += "0"+(currDate.getMonth()+1)+"-";
                        }
                        else{
                            checkDateString += (currDate.getMonth()+1)+"-";
                        }

                        if(currDate.getDate() < 10){
                            checkDateString += "0"+currDate.getDate();
                        }
                        else{
                            checkDateString += currDate.getDate();
                        }

                        //Make the actual comparison
                        if(checkDateString ==  date[j][0]){
                            inArray = true;
                            var temp = new Array(currDate.getMonth()+1+"/"+ currDate.getDate()+"/"+ currDate.getFullYear(), date[j][1]);
                            graphArray.push(temp);
                            break;
                        }
                    }
                    if(!inArray){
                        var temp = new Array(currDate.getMonth()+1+"/"+ currDate.getDate()+"/"+ currDate.getFullYear(), 0);
                        graphArray.push(temp);
                    }
                    else{
                        inArray = false;
                    }
                    i++;
                    currDate.setDate(currDate.getDate() - 1);
                }

                /*   Make sure the graphArray is not null, display data  */
                if(graphArray != null){
                    var data = google.visualization.arrayToDataTable(graphArray);
                }
            }

            /**
             * If we don't get a result back
             * - Format the last 10 days
             * - Display column chart of 0s
             */
            else{
                var d = new Date();
                var dString = d.getMonth()+1+"/"+ d.getDate()+"/"+ d.getFullYear();
                d.setDate(d.getDate() - 1);
                var d2String = d.getMonth()+1+"/"+ d.getDate()+"/"+ d.getFullYear();
                d.setDate(d.getDate() - 1);
                var d3String = d.getMonth()+1+"/"+ d.getDate()+"/"+ d.getFullYear();
                d.setDate(d.getDate() - 1);
                var d4String = d.getMonth()+1+"/"+ d.getDate()+"/"+ d.getFullYear();
                d.setDate(d.getDate() - 1);
                var d5String = d.getMonth()+1+"/"+ d.getDate()+"/"+ d.getFullYear();
                d.setDate(d.getDate() - 1);
                var d6String = d.getMonth()+1+"/"+ d.getDate()+"/"+ d.getFullYear();
                d.setDate(d.getDate() - 1);
                var d7String = d.getMonth()+1+"/"+ d.getDate()+"/"+ d.getFullYear();
                d.setDate(d.getDate() - 1);
                var d8String = d.getMonth()+1+"/"+ d.getDate()+"/"+ d.getFullYear();
                d.setDate(d.getDate() - 1);
                var d9String = d.getMonth()+1+"/"+ d.getDate()+"/"+ d.getFullYear();
                d.setDate(d.getDate() - 1);
                var d10String = d.getMonth()+1+"/"+ d.getDate()+"/"+ d.getFullYear();

                var data = google.visualization.arrayToDataTable([
                    [ 'Day', 'Count' ],
                    [ dString, 0 ],
                    [ d2String, 0 ],
                    [ d3String, 0 ],
                    [ d4String, 0 ],
                    [ d5String, 0],
                    [ d6String, 0 ],
                    [ d7String, 0 ],
                    [ d8String, 0 ],
                    [ d9String, 0 ],
                    [ d10String, 0 ]
                ]);
            }

            /*   Options    */
            var options = {
                title: 'Claims Count Over Last Ten Days',
                titleTextStyle: { color: 'grey', fontSize: '18', },
                bars: { groupWidth: "95%" },
                chartArea: { width: "90%", height: "70%" },
                legend: { position: "none" },
            };

            /*    Actually drawing the chart   */
            var chart = new google.visualization.ColumnChart(document.getElementById('barchart_material 1'));
            chart.draw(data, options);
        }
    }});


    /**
     * Claim Count Per Agency
     */

    var countAgency_url = "/ajax/statisticAjax.php?action=CountAgency&d_id="+d_id;

    $.ajax({url: countAgency_url, success: function(countAgencyResult){
        google.charts.setOnLoadCallback(drawAgencyCount);

        function drawAgencyCount() {

            /**
             * If we get a result back
             * - Display column chart of agency data
             */
            if(countAgencyResult.length > 1) {

                var agency = JSON.parse(countAgencyResult);

                /*   Make sure the agency is not null, display data  */
                if(agency != null) {
                    var data = google.visualization.arrayToDataTable(agency);
                }
            }

            /**
             * If we don't get a result back
             * - Display column chart of 0s
             */
            else{
                var data = google.visualization.arrayToDataTable([
                    [ 'Agency', 'Count' ],
                    [ 'N/A', 0]
                ]);
            }

            /*   Options    */
            var options = {
                title: 'Claims Count By Agency',
                titleTextStyle: { color: 'grey', fontSize: '18', },
                bars: { groupWidth: "95%" },
                chartArea: { width: "85%", height: "75%" },
                legend: { position: "none" },
            };

            /*    Actually drawing the chart   */
            var chart = new google.visualization.ColumnChart(document.getElementById('barchart_material 2'));
            chart.draw(data, options);
        }
    }});


    /**
     * Inital PieChart Data - Claim Count per Agency
     */

    var pie_url = "/ajax/statisticAjax.php?action=pieCategory&pieCategory=Agency&d_id="+d_id;

    $.ajax({url: pie_url, success: function(pieResult){
        google.charts.setOnLoadCallback(drawPieChart);

        function drawPieChart() {

            /**
             * If we get a result back
             * - Display pie chart of agency data
             */
            if(pieResult != "") {
                var agency = JSON.parse(pieResult);

                /*   Make sure the agency is not null, display data  */
                if(agency != null) {
                    var data = google.visualization.arrayToDataTable(agency);
                }
            }

            /**
             * If we don't get a result back
             * - Display pie chart of 0s
             */
            else{
                var data = google.visualization.arrayToDataTable([
                    [ '', '' ],
                    [ '', 0]
                ]);
            }

            /*   Options    */
            var options = {
                title: 'Claims By Category',
                titleTextStyle: { color: 'grey', fontSize: '20', },
                is3D: true,
                legend: { position: "bottom" },
                chartArea: { width: "95%", height: "75%" }
            };

            /*    Actually drawing the chart   */
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    }});
}

function claimsByCategory(category) {

    /**
     * Some categories needed to be shorted to one word to pass over
     */

    if(category == 'Assigned Branch/Territory'){
        category = 'Branch';
    }
    else if (category == 'Assignment Status'){
        category = 'Status';
    }
    else if (category == 'Independent Adjuster'){
        category = 'Adjuster';
    }
    else if (category == 'Property Type'){
        category = 'PropType';
    }


    /**
     *  PieChart Data based on Dropdown
     */

    var pieChart_url = "/ajax/statisticAjax.php?action=pieCategory&pieCategory="+category+"&d_id="+d_id;

    $.ajax({url: pieChart_url, success: function(pieResult){
        google.charts.setOnLoadCallback(drawPieChart);

        function drawPieChart() {

            /**
             * If we get a result back
             * - Display pie chart of agency data
             */
            if(pieResult != "") {
                var pie = JSON.parse(pieResult);
                if(pie != null) {
                    var data = google.visualization.arrayToDataTable(pie);
                }
            }

            /**
             * If we don't get a result back
             * - Display pie chart of 0s
             */
            else{
                var data = google.visualization.arrayToDataTable([
                    [ '', '' ],
                    [ '', 0]
                ]);
            }

            /*   Options    */
            var options = {
                title: 'Claims By Category',
                titleTextStyle: { color: 'grey', fontSize: '20', },
                is3D: true,
                legend: { position: "bottom" },
                chartArea: { width: "95%", height: "75%" }
            };

            /*    Actually drawing the chart   */
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
        }
    }});
}