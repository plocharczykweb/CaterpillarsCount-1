
//Checks login data and builds the admin pills objects  Also contains some depreciated functions from the previous group

var admin;
var surveys = new Array();
var orders = new Array();
var sortBy = "surveyID";
$(document).ready(function () {

    build_pills();

	//Retrieve login status from server
    $.ajax("/api/login.php", {
        type: "GET",
        dataType: "json",
        async: false,
        success: function (data, status, xhr) {
            /* Redirect to login page if not logged in
             * Server side use session and cookies to verify login status.
             * if priviledgeLevel == 0, the account is a user account and not admin
             */
            var privilegeLevel = data.privilegeLevel;
            if (privilegeLevel == 0) {
                window.location.replace("login.html");
            }

            //Master Admin has logged in!

            admin = data;

            //Load Admin name into navbar
            put_name_in_nav_bar(admin);

        },
        error: function (xhr, status) {
            window.location.replace("login.html");
        }
    });

    //sorting of the table
    $("table.survey").on("click", "th.sort", function (e) {
        var newSortBy = $(this).attr("id");

        if (newSortBy == sortBy)
            return;
        else {
            $("#" + sortBy).css("text-decoration", "none");
            $("#" + newSortBy).css("text-decoration", "underline");
            sortBy = newSortBy;
            updateTable();
        }
    });

});
//Depreciated functions start here

//download surveys from server
//load survey into table and save surveys locally
function downloadSurveys() {
    var siteIDArray = $("#surveySites").val();
    if (!siteIDArray) {
        $("table.survey tbody").empty();
        return;
    }

    //get all survey entries for site
    var inputData = {action: "getAllBySiteIDArray",
        siteIDs: siteIDArray,
        startDate: $("#startDate").val(),
        endDate: $("#endDate").val()
    };
    $.ajax({
        url: "/api/surveys.php",
        type: "POST",
        dataType: "json",
        data: JSON.stringify(inputData),
        success: function (s, xhr, status) {
            surveys = [];
            orders = [];
            surveys = s;
            $("table.survey tbody").empty();
            updateTable(true);
        },
        error: function (xhr, status) {
            surveys = new Array();
            orders = new Array();
            $("table.survey tbody").empty();
        }
    });
}

//Depreciated functions start here
//reload surveys from locally saved surveys array;
//sort surveys array if compare function is given
function updateTable(download) {
    $("table.survey tbody").empty();
    var compare;
    if (sortBy == 'surveyID')
        compare = sortBySurveyID();
    else if (sortBy == 'userID')
        compare = sortByUserID();
    else if (sortBy == 'siteID')
        compare = sortBySiteID();
    else if (sortBy == 'circle')
        compare = sortByCircle();
    else if (sortBy == 'survey')
        compare = sortBySurvey();
    else if (sortBy == 'submissionTime')
        compare = sortBySubmissionTime();
    else if (sortBy == 'temperature')
        compare = sortByTemperature();
    else if (sortBy == 'species')
        compare = sortBySpecies();
    else if (sortBy == 'herbivory')
        compare = sortByHerbivory();
    if (compare) {
        surveys.sort(compare);
    }
    for (var i = 0; i < surveys.length; i++) {
        loadSurvey(surveys[i], isOdd(i + 1), download);
    }

}

//Load one survey entry intothe table, including all its orders;
//call downloadOrders if downloading for the first time;
//otherwise load orders from locally saved orders array
function loadSurvey(survey, isOdd, download) {
    var $tbody = $("table.survey tbody");
    var $tr = $("<tr class = 'survey' id = 'survey" + survey.surveyID + "'></tr>");
    if (isOdd)
        $tr.addClass("odd");

    var image = "<a href = '../pictures/" + survey.leavePhoto + "' target = '_blank'><img src='../pictures/" + survey.leavePhoto + "' onerror='hideSurveyPic(" + survey.surveyID + ")'></a>";

    $tr.append("<td>+</td><td>" + survey.surveyID + "</td><td class='userID'>" + survey.userID + "</td><td>" + survey.siteID + "</td><td>" + survey.circle + "</td><td>" + survey.survey + "</td><td>" + survey.timeStart + "</td><td>" + survey.temperatureMin + " - " + survey.temperatureMax + "</td><td>" + survey.plantSpecies + "</td><td>" + survey.herbivory + "</td><td>" + image + "</td><td><button class='deleteSurvey'>Delete Entry</button></td><td><button class = 'markUserInvalid'>Mark User as Invalid</button></td>");
    $tbody.append($tr);
    if (download) {
        downloadOrders(survey.surveyID);
    }
    else {
        orderArray = orders[survey.surveyID];
        if (!orderArray) {
            $("#survey" + survey.surveyID).find("td:first").html("-");
        }
        for (i in orderArray) {
            loadOrder(orderArray[i]);
        }
    }
}

//get all orders for the survey from the server
//load all orders into the table and save orders locally.
function downloadOrders(surveyID) {
    var inputData = {action: "getAllBySurveyID", surveyID: surveyID};
    $.ajax({
        url: "/api/orders.php",
        type: "POST",
        dataType: "json",
        data: JSON.stringify(inputData),
        success: function (o, xhr, status) {
            orders[surveyID] = o;
            for (i in o) {
                loadOrder(o[i]);
            }
        },
        error: function (xhr, status) {
            $("#survey" + surveyID).find("td:first").html("-");
        }
    });
}

function loadOrder(order) {
    var $surveyRow = $("#survey" + order.surveyID);
    var $tr = $("<tr class = 'order' id = 'order" + order.orderID + "'></tr>");

    var image = "<a href = '../pictures/" + order.insectPhoto + "' target = '_blank'><img src='../pictures/" + order.insectPhoto + "' onerror='hideOrderPic(" + order.orderID + ")'></a>";

    $tr.append("<td class = 'order' colspan = 13><div>Order: " + order.orderArthropod + "<br>Length: " + order.orderLength + "<br>Count: " + order.orderCount + "<br>Notes: " + order.orderNotes + "<br>" + image + "<button class = 'deleteOrder'>Delete</button></div></td>");

    $surveyRow.after($tr);
    $tr.find("div").hide();
}

function isOdd(num) {
    return num % 2;
}

//Retrieve all site information and fill site selector
function downloadSites() {
    $.ajax({
        url: "/api/sites.php",
        type: "post",
        dataType: "json",
        data: JSON.stringify({action: "getAllSiteState"}),
        success: function (sites, xhr, status) {
            var $siteSelect = $("select.siteSelect");
            $siteSelect.empty();
            for (var i = 0; i < sites.length; i++) {
                $siteSelect.append("<option value= '" + sites[i].siteID + "'>" + sites[i].siteID + ": " + sites[i].siteName + ", " + sites[i].siteState + "</option>");
            }
        },
        error: function (xhr, status) {
            alert("Error loading site. Please refresh the page.");
        }
    });
}

//sorting compare functions
function sortBySurveyID() {
    return function (a, b) {
        return parseInt(a.surveyID) - parseInt(b.surveyID);
    };
}

function sortByUserID() {
    return function (a, b) {
        if (parseInt(a.userID) == parseInt(b.userID))
            return parseInt(a.surveyID) - parseInt(b.surveyID);
        return parseInt(a.userID) - parseInt(b.userID);
    };
}

function sortBySiteID() {
    return function (a, b) {
        if (parseInt(a.siteID) == parseInt(b.siteID))
            return parseInt(a.surveyID) - parseInt(b.surveyID);
        return parseInt(a.siteID) - parseInt(b.siteID);
    };
}

function sortByCircle() {
    return function (a, b) {
        if (parseInt(a.circle) == parseInt(b.circle))
            return parseInt(a.surveyID) - parseInt(b.surveyID);
        return parseInt(a.circle) - parseInt(b.circle);
    };
}

function sortBySurvey() {
    return function (a, b) {
        if (a.survey.toLowerCase().localeCompare(b.survey.toLowerCase()) == 0)
            return parseInt(a.surveyID) - parseInt(b.surveyID);
        return a.survey.toLowerCase().localeCompare(b.survey.toLowerCase());
    };
}

function sortBySubmissionTime() {
    return function (a, b) {
        if (Date.parse((a.timeSubmit.replace(' ', 'T') + 'Z')) == Date.parse((b.timeSubmit.replace(' ', 'T') + 'Z')))
            return parseInt(a.surveyID) - parseInt(b.surveyID);
        return Date.parse((a.timeSubmit.replace(' ', 'T') + 'Z')) - Date.parse((b.timeSubmit.replace(' ', 'T') + 'Z'));
    };
}

function sortByTemperature() {
    return function (a, b) {
        if (parseInt(a.temperatureMin) == parseInt(b.temperatureMin))
            return parseInt(a.surveyID) - parseInt(b.surveyID);
        return parseInt(a.temperatureMin) - parseInt(b.temperatureMin);
    };
}

function sortBySpecies() {
    return function (a, b) {
        if (a.plantSpecies.toLowerCase().localeCompare(b.plantSpecies.toLowerCase()) == 0)
            return parseInt(a.surveyID) - parseInt(b.surveyID);
        return a.plantSpecies.toLowerCase().localeCompare(b.plantSpecies.toLowerCase());
    };
}

function sortByHerbivory() {
    return function (a, b) {
        if (parseInt(a.herbivory) == parseInt(b.herbivory))
            return parseInt(a.surveyID) - parseInt(b.surveyID);
        return parseInt(a.herbivory) - parseInt(b.herbivory);
    };
}

function hideSurveyPic(id) {
    $("table.survey").find("#survey" + id).find("img").css("display", "none");
}

function hideOrderPic(id) {
    $("table.survey").find("#order" + id).find("img").css("display", "none");
}