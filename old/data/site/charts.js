//New methods to automatically call charts.

function getDataAndBuildChart(siteID,createGraph){
	
	// AJAX call to get all the information about the submissions made to that site (order name, order count, plant species for all the submissions)
	// when the AJAX call is successful, then the plant and arthropod pie charts are created.
	$.ajax({
		type: 'GET',
		url: '../../api/sites.php/SurveysAndOrders?siteID=' + siteID,
		dataType: 'json',
		success: function(surveys, xhr, status){
			var data = surveys;
			createGraph(data);
			
			$("#siteStatistics").append("<p>"+JSON.stringify(surveys[1])+"<p>");
		}
	});
}

//createPlantsChart(data);
		//	createArthropodChart(data);