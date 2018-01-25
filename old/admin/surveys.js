
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

    formInputs = $(".jtable-edit-form textarea");
    var key = formInputs.attr("name");
    var value = formInputs.val();
    data[key] = value;

    //Find the checked propery on a radio button
    var checkboxes = document.querySelectorAll(".jtable-radio-input input");

    for (var i in checkboxes){
        var x = checkboxes[i];
        if (x.checked == true){
            data[x.name] = x.value;
        }
    }

    return data;
}
function circleInputUpdate(){
    $.ajax("/api/sites.php", {
        type: "POST",
        dataType: "json",
        data: JSON.stringify({action: "getOneByID", siteID: $("#siteID").val()}),
        success: function (data, xhr, status) {
            var numCircles = Number(data.numCircles);
            $("#selectCircle").empty();
            $("#selectCircle").append("<option selected='selected' value='0'>All Circles</option>");
            for (var i = 1; i <= numCircles; i++) {
                $("#selectCircle").append("<option value = '" + i + "'>" + i + "</option>");
            }
        }
    });
}

function getRequestData(){
    var data = {};
    data.action = "getAllBySiteIDArray";
    data.siteIDs = [];
    data.siteIDs.push(Number($('#siteID').val()));
    data.startDate = $('#startDate').val();
    data.endDate = $('#endDate').val();

    return data;
}

$(document).ready(function () {

    $.ajax("/api/sites.php/AllAuthorized",{
        type: "GET",
        dataType: "json",
        success: function (data, xhr, status){
            $("#siteID").empty();

            if (data.status = 'OK'){
                data = data.sites;
                for (var i in data) {
                    var site = data[i];
                    $("#siteID").append("<option value = '" + site.siteID + "'>" + site.siteState + ", " + site.siteName + "</option>");

                }
            }else{
                alert("Site Request Failed");
            }
        }
    });

    surveyTableCreate();

    $('#LoadRecordsButton').click(function (e) {
        e.preventDefault();

        var circleFilter = $('#selectCircle').val();
        var surveyFilter = $('#selectSurvey').val();

        var surveyList = $('#SurveyTable tbody tr');

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

    $('#getSurveys').click(function(e){
        e.preventDefault();
        $('#SurveyTable').jtable('load');
    });




});

function surveyTableCreate(siteID,siteName,dateList,numCircles){

    $('#SurveyTable').jtable({
        title: "Surveys",

        actions: {
            listAction: function (postData, jtParams) {
                return $.Deferred(function ($dfd) {
                    $.ajax({
                        url: '/api/surveys.php',
                        type: 'POST',
                        dataType: "json",
                        data: JSON.stringify(getRequestData()),
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

        fields:{
            surveyID:{
                key: true,
                list: false
            },
            siteID:{
                title: "Site ID",
                list: false
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
            leafCount:{
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
        recordsLoaded: function(event,data){
            circleInputUpdate();
        },
    });

}

function buildOrderTable(img){
    var row = img.closest('tr');
    //retrieve data of from survey.
    var surveyData = row.data('record');
    $('#SurveyTable').jtable('openChildTable',
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
