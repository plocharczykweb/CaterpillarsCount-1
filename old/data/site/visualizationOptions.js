//Created by John Schutts

var dataNumber;
var siteID;
$(document).ready(function () {
	
	dataNumber = 1;
	siteID = Number(window.location.search.substring(1));
	
	//makes AJAX requests to build Site Statistics part of page, populate years for Line Graph
	//and populate the plant species for line graph
	siteStatisticsRequest(siteID);
	yearsActiveRequest(siteID);
	treesRequest(siteID);
	
	//defaults to show Pie Chart first and makes Plant Pie Charts active
	$("#lineChartContainer").addClass("hidden");
	$("#lineGraphOptions").addClass("hidden");
	$("#plantsPi").parent().addClass("active");
	$("#pieChartsContainer").show();
		
	getDataAndBuildChart(siteID, createPlantsChart);
	
	
	//changes view to show line graph and line graph options
	$("#lineGraph").click(function (e) {
		e.preventDefault();	
		
		$("#lineGraph").parent().addClass("active");
		$("#piChart").parent().removeClass("active");
		$("#lineGraphOptions").removeClass("hidden");
		$("#lineChartContainer").removeClass("hidden");
		$("#piChartOptions").addClass("hidden");
		$("#pieChartsContainer").hide();
		
	});
	
	//changes view to show pie charts and pie chart options
	$("#piChart").click(function (e) {
		e.preventDefault();	
		
		$("#lineGraph").parent().removeClass("active");
		$("#piChart").parent().addClass("active");
		$("#lineGraphOptions").addClass("hidden");
		$("#lineChartContainer").addClass("hidden");
		$("#piChartOptions").removeClass("hidden");
		$("#pieChartsContainer").show();
		$("#plantsPi").parent().addClass("active");
		$("#arthropodsPi").parent().removeClass("active");
		
		getDataAndBuildChart(siteID, createPlantsChart);
		
	});
	
	//builds plant pie charts with AJAX call and changes view to show pie charts
	$("#plantsPi").click(function (e) {
		e.preventDefault();	
		
		$("#plantsPi").parent().addClass("active");
		$("#arthropodsPi").parent().removeClass("active");
		$("#pieChartsContainer").show();
		
		getDataAndBuildChart(siteID, createPlantsChart);
		

	});
	
	//builds arthropod pie charts with AJAX call and changes view to show pie charts
	$("#arthropodsPi").click(function (e) {
		e.preventDefault();	
		
		$("#arthropodsPi").addClass("active");
		$("#arthropodsPi").parent().addClass("active");
		$("#plantsPi").parent().removeClass("active");
		$("#pieChartsContainer").show();
		
		getDataAndBuildChart(siteID, createArthropodChart);
		

	});
	
	//collects user inputs and makes AJAX call to build the line graph
	$("#submit").click(function (e) {
		e.preventDefault();	
		
		var data = {};
		
		data.year = $("#yearSelect").val();
		data.orders = $("#arthropodSelect").val();
		data.plantSpecies = $("#plantSelect").val();
		data.siteID = siteID;
		
		submitRequest(data);

	});
	
	//resets the line graph
	$("#reset").click(function (e) {
		e.preventDefault();	
		dataNumber = 1;
		clearLineGraph();

	});
	
	
	
});

	//AJAX call to collect Site Statistics to populate pie chart page
	function siteStatisticsRequest(siteID){
		$.ajax('../../api/sites.php/Statistics?siteID=' + Number(siteID), {
			type: 'GET',
			dataType: 'json',
			async: false,
			success: function(data, xhr, status){
				createStatisticsSection(data, siteID);
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert('Text status: ' + textStatus + ". Error message: " + errorThrown);
			}
		});
	}
	
	//creates the statistics section in the pie chart view
	function createStatisticsSection(data, siteId){
		if(!data.siteDescription){
			data.siteDescription = "(No description available)";
		}
		
		$('#siteName').prepend("<h2 id='contentHeader'>" + data.siteName + "</h2>");
		$('#statistics').append("<p><span class=''>Site description</span>: " + data.siteDescription + "</p>");
		$('#statistics').append("<p><span class=''>Number of different users</span>: " + data.countUsers + "</p>");
		$('#statistics').append("<p><span class=''>Number of different arthropod orders</span>: " + data.countArthropods + "</p>");
		$('#statistics').append("<p><span class=''>Number of surveys</span>: " + data.countSurveys + "</p>");
		$('#statistics').append("<p><span class=''>Most recent survey</span>: " + data.recentSurvey + "</p>");
	}
	
	//AJAX call to collect the years in which surveys were done at the particular site that's selected
	function yearsActiveRequest(siteID){
		$.ajax('../../api/sites.php/YearsActive?siteID=' + Number(siteID), {
			type: 'GET',
			dataType: 'json',
			async: false,
			success: function(data, xhr, status){
				populateYears(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert('yearsActiveRequest failed');
			}
		});
	}
	
	//fills in html selector with correct years from site
	function populateYears(data){
		for(var i in data){
			$("#yearSelect").append("<option value = '"+data[i]+"'>"+data[i]+"</option>" );
		}
	}
	
	//AJAX request to collect which trees were surveyed at the particular site that's selected
	function treesRequest(siteID){
		$.ajax('../../api/sites.php/Plants?siteID=' + Number(siteID), {
			type: 'GET',
			dataType: 'json',
			async: false,
			success: function(data, xhr, status){
				populateTrees(data);
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert('treesRequest failed');
			}
		});
	}
	
	//fills in html selector with correct trees from site
	function populateTrees(data){
		
		$("#plantSelect").append("<option value = "+'"%"'+ " selected=" + '"selected"'   + "'>"+"SELECT ALL"+"</option>");
		for(var i in data){
			$("#plantSelect").append("<option value = '"+data[i]+"'>"+data[i]+"</option>" );
		}
	}
	
	//AJAX call that collects user inputs from line graph options and builds the line graph
	function submitRequest(data){
		var year = data.year;
		$.ajax(' ../../api/sites.php/OrderDensity?' + $.param(data), {
			type: 'GET',
			dataType: 'json',
			async: false,
			success: function(data, xhr, status){
				addDataToLineGraph(year,data,"data "+ dataNumber);
				dataNumber++;
			},
			error: function(jqXHR, textStatus, errorThrown){
				alert("No data collected");
			}
		});
	}
	
	
	
	
	
	