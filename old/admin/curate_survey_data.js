
//This is the javascript necessary to run the curate data page.
//Uses jquery and JTable

    //Retrieves input form data from modal inputs.
    //API requires JSON input, instead of URL encoded variables
    function getInputFormData(){

        var data = {};

        var formInputs = $(".jtable-edit-form input");

        formInputs.each(function(){
            var key = $(this).attr("name");
            var value = $(this).val();

            data[key] = value;
        });

        formInputs = $(".jtable-edit-form select");

        formInputs.each(function(){
            var key = $(this).attr("name");
            var value = $(this).val();

            data[key] = value;
        });
        //Find the checked propery on a radio button
        var checkboxes = document.querySelectorAll(".jtable-radio-input input");

        for (var i in checkboxes){
            var x = checkboxes[i];
            if (x.checked == true){
                data[x.name] = x.value;
            }
        }

        formInputs = $(".jtable-edit-form textarea");
        var key = formInputs.attr("name");
        var value = formInputs.val();
        data[key] = value;


        return data;
    }
    //Builds the initial tables
    function loadSiteAndOverviewTable(){
        $('#SiteOverviewTable').jtable({
            title: 'Sites',

            actions: {
                //Pull information from the Server
                listAction: function (postData, jtParams) {
                    return $.Deferred(function ($dfd) {
                        $.ajax({
                            url: '/api/sites.php/AllAuthorized',
                            type: 'GET',
                            dataType: "json",
                            processData: false,
                            success: function (data) {
                                if (data.status = "OK") {
                                    var response = {Result: "OK"};
                                    response["Records"] = data.sites;
                                    response["TotalRecordCount"] = data.length;
                                    $dfd.resolve(response);
                                } else {
                                    alert(data.status);
                                    $dfd.reject();
                                }
                            },
                            error: function () {
                                $dfd.reject();
                            }
                        });
                    });
                },

            },
            //Columns for the table
            fields: {
                siteID: {
                    key: true,
                    list: false
                },
                siteName: {
                    title: 'Name',
                    edit: false

                },
                siteState: {
                    title: 'State',
                    edit: false,
                    width: '5%'

                },
                siteDescription: {
                    title: 'Description',
                    type: 'textarea',
                    edit: false,
                    width: '40%'

                },

                numCircles: {
                    title: '# Circles',
                    edit: false
                },
                //The list icon will create a drowpdown child table
                seeNewData: {
                    title: "New Data",
                    display: function (siteData) {
                        //Create an image that will be used to open child table
                        var img = $('<span class="glyphicon glyphicon-th-list"></span>');
                        //console.log(studentData);
                        //Open child table when user clicks the image
                        img.click(function () {
                            var siteNumCircles = Number(siteData.record.numCircles);
                            //The child table initializer
                            $('#SiteOverviewTable').jtable('openChildTable',
                                img.closest('tr'),
                                {
                                    title: siteData.record.siteName + ' - New Data',
                                    toolbar: {
                                        hoverAnimation: true, //Enable/disable small animation on mouse hover to a toolbar item.
                                        hoverAnimationDuration: 60, //Duration of the hover animation.
                                        hoverAnimationEasing: undefined, //Easing of the hover animation. Uses jQuery's default animation ('swing') if set to undefined.
                                        //Tool bar button that allows surveys to be created
                                        items: [{text: 'View Surveys', click: function(){

                                            var selectedRows = $('#SiteOverviewTable>.jtable-main-container>.jtable>tbody>.jtable-child-row .jtable-row-selected');

                                            if (selectedRows.length > 0){
                                                var dateList = [];
                                                selectedRows.each(function () {
                                                    var record = $(this).data('record');
                                                    dateList.push(record.date);
                                                    var name = record.Name;
                                                });

                                                var overviewTable = $("#SiteOverviewTable");
                                                overviewTable.hide();
                                                //table must be destroyed for new child tables
                                                //to display correctly
                                                overviewTable.jtable('destroy');
                                                $("#admin_vertical_pills").hide();
                                                $("#filtering").show();
                                                $('#CurateSurveysTable').show();
                                                $('#CurateSurveysTable').empty();
                                                $("#CurateSurveysTable").data("numCircles",siteNumCircles);
                                                surveyTableCreate(siteData.record.siteID,
                                                    siteData.record.siteName,
                                                    dateList,
                                                    siteData.record.numCircles);
                                            }
                                        }}] //Array of your custom toolbar items.
                                    },
                                    selecting: true,
                                    multiselect: true,
                                    selectingCheckboxes: true,
                                    actions: {
                                        //Load data from server, list of days and surveys on that day
                                        listAction: function (postData, jtParams) {
                                            return $.Deferred(function ($dfd) {
                                                $.ajax({
                                                    url: '/api/curate_data.php?siteID='+siteData.record.siteID,
                                                    type: 'GET',
                                                    dataType: "json",
                                                    data: JSON.stringify({'action': "getAll"}),
                                                    processData: false,
                                                    success: function (data) {
                                                        var response = {Result: "OK"};
                                                        response["Records"] = data.data;
                                                        response["TotalRecordCount"] = data.data.length;
                                                        $dfd.resolve(response);

                                                    },
                                                    error: function () {
                                                        $dfd.reject();
                                                    }
                                                });
                                            });
                                        }
                                    },
                                    fields: {

                                        date: {
                                            title: 'Survey Date',
                                        },
                                        count: {
                                            title: 'Total number of Surveys',
                                        },
                                    }
                                },

                                function (data) { //opened handler
                                    data.childTable.jtable('load');

                                });
                        });
                        //Return image to show on the person row
                        //A boostrap glyphicon
                        return img;
                    }
                }
            }
        });
        $('#SiteOverviewTable').jtable('load');
    }
    //Attach listeners and start table here
    $(document).ready(function () {

        var numSurveys = $("#numSurveys");

        numSurveys.val("1");
        numSurveys.change(function(){
            var surveys = getSurveys();
            checkRules(surveys);
        });
        loadSiteAndOverviewTable();

        //Logic for the filter button
        $('#LoadRecordsButton').click(function (e) {
            e.preventDefault();

            var circleFilter = $('#selectCircle').val();
            var surveyFilter = $('#selectSurvey').val();

            var surveyList = $('#CurateSurveysTable tbody tr');

            if (circleFilter == '0' && surveyFilter == '0'){
                surveyList.show();
            }else if (circleFilter == '0'){
                surveyList.hide();
                surveyList.each(function(){
                    if($(this).data('record').survey == surveyFilter){
                        $(this).show();
                    }
                });
            }else if (surveyFilter == '0'){
                surveyList.hide();
                surveyList.each(function() {
                    if($(this).data('record').circle == circleFilter){
                        $(this).show();
                    }
                });
            }else{
                surveyList.hide();
                surveyList.each(function() {
                    if($(this).data('record').circle == circleFilter &&
                        $(this).data('record').survey == surveyFilter){
                        $(this).show();
                    }
                });
            }
        });



    });
//Function to create the table of Surveys (where actual editable content takes place)
function surveyTableCreate(siteID,siteName,dateList,numCircles){

    $('#CurateSurveysTable').jtable({
        title: "Site: "+siteName+" on Date(s): " +dateList.toString(),

        actions: {
                //Load surveys from server
                listAction: function (postData, jtParams) {
                    return $.Deferred(function ($dfd) {
                        $.ajax({
                            url: '/api/surveys.php',
                            type: 'POST',
                            dataType: "json",
                            data: JSON.stringify({'action': "getBySiteAndDateList",
                                                    'siteID': siteID,
                                                    'dateList': dateList}),
                            processData: false,
                            success: function (data) {
                                var response = {Result: "OK"};
                                response["Records"] = data;
                                response["TotalRecordCount"] = data.length;
                                $dfd.resolve(response);
                                
                            },
                            error: function () {
                                $dfd.reject();
                            }
                        });
                    });
                },
            //Make changes to an edited survey
            updateAction: function (postData, jtParams) {
                var data = getInputFormData();
                console.log(data);
                return $.Deferred(function ($dfd) {
                    $.ajax({
                        url: '/api/Survey_Update.php',
                        type: 'POST',
                        dataType: "json",
                        data: JSON.stringify(data),
                        processData: false,
                        success: function (data) {
                            var response = {Result: "OK"};
                            response["Record"] = data;
                            response["TotalRecordCount"] = data.length;
                            $dfd.resolve(response);

                        },
                        error: function () {
                            $dfd.reject();
                        }
                    });
                });
            }

        },
        toolbar: {
            //Buttons on top of the toolbar for curating the survey Data.
            hoverAnimation: true, //Enable/disable small animation on mouse hover to a toolbar item.
            hoverAnimationDuration: 60, //Duration of the hover animation.
            hoverAnimationEasing: undefined, //Easing of the hover animation. Uses jQuery's default animation ('swing') if set to undefined.
            items: [
                //Go Back button, resets the page to it's original state showing the sites with new data.
                {text: 'Go Back', click: goBack},
                //Mark all as valid, sends an array of surveyIDs to the server saying to
                //Change status from 'new' to 'valid'
                {text: 'Mark all as Valid', click: markAllValid}

            ] //Array of your custom toolbar items.
        },
            //List of table columns
            fields:{
                surveyID:{
                    key: true,
                    list: false
                },
                siteID:{
                    title: "Site ID"
                },
                name:{
                    title: "user",
                    edit: false
                },
                circle:{
                    title: "Circle",
                    width: "5%"
                },
                survey:{
                    title: "Survey",
                    width: "5%",
                    options: ["A","B","C","D","E"]
                },
                timeStart:{
                    title: "Date/Time"
                },
                temperatureMin:{
                    title: "T. Min",
                    width: "5%"
                },
                temperatureMax:{
                    title: "T. Max",
                    width: "5%"
                },
                plantSpecies:{
                    title: "Plant Species"
                },
                officialPlantSpecies:{
                    title: "Official",
                    edit: false
                },
                siteNotes:{
                    title: "Site Notes",
                    edit: false
                },
                mod_notes:{
                    title: "mod Notes",
                    edit: true,
                    type: "textarea"
                },
                surveyType:{
                    title: "Survey Type",
                    options: ["Visual","Beat_Sheet"]
                },
                LeafCount:{
                    title: "Leaf Count"

                },
                leavePhoto:{
                    title: "Photo",
                    edit: false,
                    display: function(data){
                        var pic_link = data.record.leavePhoto;
                        if (pic_link != "" && pic_link != null){
                            pic_link = "/pictures/"+pic_link;
                        }else{
                            return "N/A";
                        }
                        return "<a href = '"+pic_link+"' target = '_blank'>Photo</a>";
                    }
                },
                herbivory:{
                    title: "Herbivory"
                },
                status:{
                    title: "Status",
                    type: "radiobutton",
                    options: ["valid","invalid","new"]
                },
                //returns an icon that when clicked will create a child row table of insect counts
                getOrders:{
                    edit: false,
                    title: "",
                    display: function (siteData) {
                        //Create an image that will be used to open child table
                        var img = $('<span class="glyphicon glyphicon-th-list"></span>');
                        //console.log(studentData);
                        //Open child table when user clicks the image
                        img.click(function () {
                            buildOrderTable(img);
                        });
                        //Return image to show on the person row
                        return img;
                    }
                }

            },
            //After records are loaded recheck entries against the rulesset
            recordsLoaded: function(event,data){
                $("#RulesTable").show();
                //console.log(data);
                checkRules(data.records);
            },
        //After a record is edited recheck entries against the rulesset
            recordUpdated: function(event, data){
                surveys = getSurveys();
                checkRules(surveys);
            }

    });
    $("#CurateSurveysTable").jtable('load');
    console.log($("#CurateSurveysTable").data());

}

    /*This is the list of rules that will be used for testing.  A rule is a function
    that returns a ruleSummary object pictured below
    */
var rules = [];

var ruleSummary = function (name,outcome, notes){
    //The name of the rule, ex: 40 surveys?
    this.name = name;
    //Boolean value indicating whether or not the surveys passed the rule
    this.outcome = outcome;
    //Any additional notes to aid in error detectio
    this.notes = notes;
}
//Takes boolean value and converts it to an appropriate boostrap glyphicon, used in rules table
function getStatusChar(status){
    if (status == true){
        return '<span class="glyphicon glyphicon-ok"></span>';
    }else{
        return '<span class="glyphicon glyphicon-remove"></span>';
    }
}
//Checks for the total number of surveys
var aRule = function(sites,numCircles, numSurveys){

    var output = new ruleSummary();

    output.name = "Expected "+(numCircles*numSurveys*5)+" Surveys";

    if (sites.length == numCircles*5*numSurveys){
        output.outcome = true;
        output.notes = "";
    }else{
        output.outcome = false;
        output.notes = sites.length+" surveys detected, "+numCircles*5*numSurveys+" surveys expected";
    }
    return output;
};

rules.push(aRule);
//Correct number of circles
aRule = function(sites,numCircles, numSurveys){
    var output = new ruleSummary();
    output.name = "Are there "+numCircles+" Circles?";
    var circles = [];

    for (var i = 0; i < numCircles; i++) {
        circles[i] = 0;
    };

    for (var i in sites){

        if(circles[sites[i].circle-1] == undefined){
            circles[sites[i].circle-1] = 1;
        }else{
            circles[sites[i].circle-1]++;
        }
        
    }
    var status = true;
    var notes = ""
    for (var i in circles){
        var circle_index = Number(i)+1;
        if(circles[i] == 0){
            status = false;
            notes = notes + "missing Circle #"+circle_index+", ";
        }else if (i >= numCircles){
            status = false;
            notes = notes+ "out of bounds entry for Circle #"+ circle_index +", ";
        }
    }
    output.outcome = status;
    output.notes = notes;

    return output;
};
rules.push(aRule);
//5 surveys in each circle for each complete survey
aRule = function(sites, numCircles, numSurveys){

    var output = new ruleSummary();

    output.name = 5*numSurveys+" surveys for each Circle?";

    var circles = [];

    for (var i = 0; i < numCircles; i++) {
        circles[i] = 0;
    };

    for (var i in sites){

        if(circles[sites[i].circle-1] == undefined){
            circles[sites[i].circle-1] = 1;
        }else{
            circles[sites[i].circle-1]++;
        }
        
    }
    var status = true;
    var notes = ""
    for (var i in circles){
        if(circles[i] != 5*numSurveys){
            status = false;

            var circle_index = Number(i)+1;

            notes = notes + "Circle #"+circle_index+" has "+circles[i]+" values, ";
        }
    }
    output.outcome = status;
    output.notes = notes;

    return output;
};
rules.push(aRule);
//expected number of surveys for a specific location
aRule = function(sites, numCircles, numSurveys){

    var output = new ruleSummary();

    if (numSurveys == 1){
        output.name = "1 Entry for each Circle-Survey";
    }else{
        output.name = numSurveys + " Entries for each Circle-Survey";
    }


    var surveyVariables = ['A','B','C','D','E'];

    var status = true;
    var notes = "";
    var surveys = [];

    for(var i = 1; i<= numCircles; i++){
        for (var j in surveyVariables){
            surveys[i+surveyVariables[j]] = 0;
        }
    }

    for (var i in sites){
        var circleSurvey = sites[i].circle + sites[i].survey;
        if (surveys[circleSurvey] == undefined){
            surveys[circleSurvey] = 1;
        }else{
            surveys[circleSurvey]++;
        }
    }
    for (var i in surveys){
        if(surveys[i] == 0){
            status = false;
            notes = notes + "Survey "+i+" is missing, ";
        }else if (surveys[i] > numSurveys){
            status = false;
            notes = notes +"Survey "+i+" has "+surveys[i]+" entries, ";
        }else if (surveys[i] == 1 && numSurveys != 1){
            status = false;
            notes = notes+ "Survey "+i+" has 1 entry, ";
        }else if (surveys[i] < numSurveys){
            status = false;
            notes = notes + "";
        }
    }
    output.outcome = status;
    output.notes = notes;

    return output;
};
rules.push(aRule);
//Checks the rules agains the surveys
function checkRules(surveys) {

    //Only surveys with a status of new are accepted into newSurveys;
    var newSurveys = [];

    for (var i =0; i < surveys.length; i++){
        var survey = surveys[i];

        if (survey.status = "new"){
            newSurveys.push(survey);
        }
    }

    var numCircles = $("#CurateSurveysTable").data("numCircles");
    var numSurveys = Number($('#numSurveys').val());

    //console.log(rules);
    var tableBody = $("#tableRules");
                    tableBody.empty();
                    for (var i in rules){
                        var rule = rules[i];
                        var ruleOutput = rule(newSurveys, numCircles, numSurveys);

                        tableBody.append("<tr><td>"+ruleOutput.name+"</td><td>"+
                            getStatusChar(ruleOutput.outcome)+"</td><td>"+ruleOutput.notes+"</td></tr>");
                    }
}   //Surveys are stored by JTable in a specific way, this pulls the information out and retuns an array
    function getSurveys(){
        var surveys = [];

        $("#CurateSurveysTable tbody tr").each(function(){
            surveys.push($(this).data("record"));
        });
        return surveys;
    }
    //Build the child table of insect counts
    function buildOrderTable(img){
        var row = img.closest('tr');
        //retrieve data of from survey.
        var surveyData = row.data('record');
        $('#CurateSurveysTable').jtable('openChildTable',
            //the row the child table will be opened below
            row,
            //here is the actual table object
            {
                title: "Arthropod Data for Survey #"+surveyData.surveyID,

                actions: {
                    listAction: function (postData, jtParams) {
                        return $.Deferred(function ($dfd) {
                            $.ajax({
                                url: '/api/orders.php',
                                type: 'POST',
                                dataType: "json",
                                data: JSON.stringify({'action': "getAllBySurveyID",'surveyID':surveyData.surveyID}),
                                processData: false,
                                success: function (data) {
                                    var response = {Result: "OK"};
                                    response["Records"] = data;
                                    response["TotalRecordCount"] = data.length;
                                    $dfd.resolve(response);

                                },
                                error: function () {
                                    $dfd.reject();
                                }
                            });
                        });
                    }
                },
                fields: {

                    orderID: {
                        key: true,
                        list: false,
                    },
                    surveyID: {
                        list: false,
                    },
                    orderArthropod:{
                        title: "Order Arthropod"
                    },
                    orderLength:{
                        title: "Length"

                    },
                    orderNotes:{
                        title: "Notes"
                    },
                    orderCount:{
                        title: "Count"
                    },
                    insectPhoto:{
                        title: "Photo",
                        edit: false,
                        display: function(data){
                            var pic_link = data.record.insectPhoto;
                            if (pic_link != "" && pic_link != null){
                                pic_link = "/pictures/"+pic_link;
                            }else{
                                return "N/A";
                            }
                            return "<a href = '"+pic_link+"' target = '_blank'>Photo</a>";
                        }
                    }
                }
            },
            //This function populates the new child table with data when it is loaded
            function (data) { //opened handler
                data.childTable.jtable('load');
            });
    }
    //hides the survey table and displays the site table
    function goBack(){


        $("#SiteOverviewTable").show();
        $("#admin_vertical_pills").show();
        $("#filtering").hide();
        $("#RulesTable").hide();
        $('#CurateSurveysTable').hide();
        $('#CurateSurveysTable').jtable("destroy");
        $('#CurateSurveysTable').empty();
        loadSiteAndOverviewTable();

    }
    //Sends an AJAX request to change all 'new' surveys to 'valid', then calls goBack()
    function markAllValid(){
        var surveys = getSurveys();

        var newSurveys = [];

        for (var i in surveys){
            var survey = surveys[i];
            if (survey.status = 'new'){
                newSurveys.push(survey.surveyID);
            }
        }
        $.ajax({
            url: '/api/surveys.php',
            type: 'POST',
            dataType: "json",
            data: JSON.stringify({'action': "markValid",'surveyArray':newSurveys}),
            processData: false,
            success: function (data) {

                if (data.status == 'OK'){
                    alert('All New Surveys marked as Valid');
                    goBack();
                }else{
                    alert ('Unable to Update Values');
                }
            },
            error: function () {
                alert('An Unexpected Error Occured');
            }
        });
    }






