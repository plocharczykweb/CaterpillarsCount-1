
//Get the number of circles for a site, and update the circle <input> object
function circleInputUpdate(){
	$.ajax("/api/sites.php", {
		type: "POST",
		dataType: "json",
		data: JSON.stringify({action: "getOneByID", siteID: $("#siteID").val()}),
		success: function (data, xhr, status) {
			var numCircles = Number(data.numCircles);
			$("#circle").empty();
			for (var i = 1; i <= numCircles; i++) {
				$("#circle").append("<option value = '" + i + "'>" + i + "</option>");
			}
		}
	});
}


$(document).ready(function (){
	//Get list of sites that admin can look at, add it to sites <input> tag
	$.ajax("/api/sites.php?action=getAllAuthorized",{
		type: "GET",
		dataType: "json",
		success: function (data, xhr, status){
			$("#siteID").empty();

			if (data.status = 'OK'){
				data = data.sites;
				for (var i in data){
					var site = data[i];
					$("#siteID").append("<option value = '"+site.siteID+"'>"+site.siteState+", "+site.siteName+"</option>");

				}
				circleInputUpdate();
			}else{
				alert("Site Request Failed");
			}


		}
	});
	//if site changes, get num circles
	$("#siteID").change(function(){
		circleInputUpdate();

	});
	//main point of this page, get all plant related data and display it
	$("#getPlantInfo").click(function(e){
		e.preventDefault();
	var siteID = $("#siteID").val();
	var circle = $("#circle").val();
	var survey = $("#survey").val();
	$.ajax("/api/plants.php", {
		type: "POST",
		dataType: "json",
		data: JSON.stringify({action:"getPlantData",siteID : siteID, circle : circle, survey : survey}),
		success: function (data, xhr, status) {
            var plantTable = $("#plantTable");
            var plantHistory = data['plantHistory'];
			var officialPlantName = data['officialName'];
			var photoURLs = data["photoURLs"];
			if (officialPlantName === null){
				officialPlantName = "None"
			}
			$("#officialName").html("  "+officialPlantName);

			$("#officialNameInput").attr("placeholder",officialPlantName);

            plantTable.empty();
            for (var i = 0; i < plantHistory.length; i++) {
                plantTable.append("<tr>"+'<td>"'+plantHistory[i].plantSpecies+'"</td>'+"<td>"+data.plantHistory[i].total+"</td>"+"</tr>");
            }
			//If you empty a carousel while it is the middle of a slide, it will break
			//must pause carousel first.
			var carousel = $('#myCarousel');
			carousel.carousel("pause").removeData();
			$(".carousel-inner").empty();
			if(photoURLs !== null) {
				for(var i = 0; i < photoURLs.length; i++) {
					if (i === 0) {
						$(".carousel-inner").append(
							"<div class='item active'>"
							+	"<img src=" + photoURLs[i] + ">"
							+	"</div>"
						);
					} else {
						$(".carousel-inner").append(
							"<div class='item'>"
							+ "<img src=" + photoURLs[i] + ">"
							+ "</div>");
					}
				}



				carousel.carousel();
			}

        },
        error: function (xhr, status) {
            alert("Error loading plant data. Please refresh the page.");
        }

	});
});
	//Change the official record
	$(".submit-button").click(function(e){
		e.preventDefault();
		var siteID = $("#siteID").val();
		var circle = $("#circle").val();
		var survey = $("#survey").val();
		var plantSpecies = $("#officialNameInput").val();

		$.ajax("/api/plants.php", {
			type: "POST",
			dataType: "json",
			data: JSON.stringify({action:"changeOfficialRecord",siteID : siteID, circle : circle, survey : survey, plantSpecies : plantSpecies}),
			success: function (data, xhr, status) {
				alert("Successfully updated the data");
				$("#officialName").html("  " + plantSpecies);
				$("#officialNameInput").attr("placeholder",plantSpecies);
			},
			error: function (xhr, status) {
				alert("Database Error");
			}

		});




	});


});