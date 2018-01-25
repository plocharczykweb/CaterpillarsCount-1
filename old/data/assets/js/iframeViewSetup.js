//This function adjust the height of the nav bar and the iframe so they don't overlap
function adjustNavMapHeights(windowHeight){
	$('nav').css('height', '60px');
	$('iframe').css('height', (windowHeight-60) + 'px');
}

//Adds a click event to the open/close button in the site information section. 
//If the section is open, then it will close it and the other way around.
function setSectionButton(){
	$('#arrowSiteInfo').on('click', function(){
		var open = $('#siteInfo').data('open');
		if(open){
			var right = $('#content').width();
			$('#siteInfo').animate({'right': -right + 'px'}, 1000, function(){
				$('#siteInfo').data('open', false);
				$('#arrowSiteInfo span').removeClass('glyphicon-chevron-right');
				$('#arrowSiteInfo span').addClass('glyphicon-chevron-left');
			});
		} else {
			$('#siteInfo').animate({'right': '0px'}, 1000, function(){
				$('#siteInfo').data('open', true);
				$('#arrowSiteInfo span').removeClass('glyphicon-chevron-left');
				$('#arrowSiteInfo span').addClass('glyphicon-chevron-right');
			});
		}
	});
}

//Adds a click event to the open/close button in the filters section. 
//If the section is open, then it will close it and the other way around.
function setFiltersButton(){
	$('#arrowFilters').on('click', function(){
		var open = $('#filtersSection').data('open');
		if(open){
			var left = $('#filtersContent').outerWidth(true);
			$('#filtersSection').animate({'left': -left + 'px'}, 1000, function(){
				$('#filtersSection').data('open', false);
				$('#arrowFilters span').removeClass('glyphicon-chevron-left');
				$('#arrowFilters span').addClass('glyphicon-chevron-right');
			});
		} else {
			$('#filtersSection').animate({'left': '0px'}, 1000, function(){
				$('#filtersSection').data('open', true);
				$('#arrowFilters span').removeClass('glyphicon-chevron-right');
				$('#arrowFilters span').addClass('glyphicon-chevron-left');
			});
		}
	})
}

// Creates and returns the GET request URL to send to the REST API in the backend with the information to use to filter the sites.
// It gets the information from the form in the index.html, specifically in the filters section
function createFilterURL(){
	var url = '../api/sites.php/Filter';
	var arthropod = encodeURI($('#arthropodSelect').val());
	var plant = encodeURI($('#plantSelect').val());
	var minSize = encodeURI(sliderMinSize.data('slider').getValue());
	//var years = sliderYear.data('slider').getValue();
	//var months = sliderMonth.data('slider').getValue();
	//var beginDate = years[0] + "-" + months[0] + "-01";
	//var endDate = years[1] + "-" + months[1] + "-31";
	url = url + "?arthropodSelect=" + arthropod + "&plantSelect=" + plant + "&minSize=" + minSize;
	return url;
}

// Adds a click event to the filters ("GO") submit button. Gets the GET URL and if the AJAX request is successful, we will redraw the sites (green) and the 
// sites that are not part of the filtered sites will be colored gray.
function setFilterSubmitButton(){
	$('#submitFilter').click(function(event){
		event.preventDefault();
		var url = createFilterURL();
		$.ajax(url, {
			type: 'GET',
			dataType: 'json',
			success: function(sites, xhr, status){
				console.log(sites);
				document.getElementById('mapIframe').contentWindow.sitesDrawOnMap(sites);
			}, error: function(error, errorCode){
				alert("Error: Error in retrieving filtered results [setFilterSubmitButton]");
			}
		});
	});
}

// Adjusts the top and right CSS properties of the site info section, and initializes the open data attribute to false since 
// this section is initially closed. Sets the filter section open attribute to true since it's initially open.
function setUpSiteInfo(){
	var top = $('nav').height();
	var right = $('#content').width();
	$('#siteInfo').css({'top': top + 'px', 'right': -right + 'px'});
	$('#siteInfo').data('open', false);
	$('#filtersSection').data('open', true);
}
	
// Gets the height of the window and adjusts the nav and iframe heights accordingly.
function setUpInitialIframeLayout(){
	var windowHeight = $(window).height();
	adjustNavMapHeights(windowHeight);
}

function addLegend(){
	var w = $("#filtersContent").width();
	var svgLegend = d3.select("#filtersContent").append("svg")
							.attr("width", w)
							.attr("height", 200)
							.attr("id", "legend");
	var minColor = d3.rgb(255,0,0);
	var maxColor = d3.rgb(0,0,255);
	var c1 = svgLegend.append("circle").attr("cx",w/10).attr("cy",50).attr("r",3).style("fill",d3.interpolateLab(minColor,maxColor)(0));
	var c1text = svgLegend.append("text").attr("x",w/10-10).attr("y",80).attr("font-size","10px").attr("fill","white").text("0.001");
	var c2 = svgLegend.append("circle").attr("cx",w*3/10).attr("cy",50).attr("r",7.25).style("fill",d3.interpolateLab(minColor,maxColor)(0.25));
	var c2text = svgLegend.append("text").attr("x",w*3/10-7).attr("y",80).attr("font-size","10px").attr("fill","white").text("0.01");		
	var c3 = svgLegend.append("circle").attr("cx",w*5/10).attr("cy",50).attr("r",11.50).style("fill",d3.interpolateLab(minColor,maxColor)(0.5));
	var c3text = svgLegend.append("text").attr("x",w*5/10-7).attr("y",80).attr("font-size","10px").attr("fill","white").text("0.1");
	var c4 = svgLegend.append("circle").attr("cx",w*7/10).attr("cy",50).attr("r",15.75).style("fill",d3.interpolateLab(minColor,maxColor)(0.75));
	var c4text = svgLegend.append("text").attr("x",w*7/10-4).attr("y",80).attr("font-size","10px").attr("fill","white").text("1");
	var c5 = svgLegend.append("circle").attr("cx",w*9/10).attr("cy",50).attr("r",20.00).style("fill",d3.interpolateLab(minColor,maxColor)(1));
	var c5text = svgLegend.append("text").attr("x",w*9/10-5).attr("y",80).attr("font-size","10px").attr("fill","white").text("10");
	var legendText = svgLegend.append("text").attr("x",w*4/10).attr("y",20).attr("font-size","25px").attr("fill","white").text("LEGEND");
	var legendDesc = svgLegend.append("text").attr("x",w*2/10).attr("y",110).attr("font-size","13px").attr("fill","white").text("Average number of arthropods per survey");
}

//Creates the plant chart composition of a given site. To do this it creates a new container, creates the data content array
// the way the library is expecting (objects with label and abundance) and creates the pie chart.
function createPlantPieChart(data){
	var chartContainer = document.createElement("div");
	chartContainer.style.width = $('#plantComposition').width() + "px";
	$('#plantComposition').append(chartContainer);
	var dataContent = [];
	var arr = Object.keys(data).map(function(k) { return {"label": k, "abundance": data[k]} });
	if(arr.length == 0){
		$(chartContainer).append("<h1>Plant composition</h1><p>There is no data to create the plant composition</p>"); return;
	}
	for (var i=0; i<arr.length; i++){
		if (i<5){
			dataContent.push({"label": arr[i]['label'], "value": arr[i]['abundance']});
		} else if (i == 5){
			dataContent.push({"label": "Other", "value": arr[i]['abundance']});
		} else {
			dataContent[dataContent.length-1].value += arr[i]['abundance'];
		}
	}
	var statHeight = $('#statistics').height();
	var contentHeight = $('#content').height();
	var sectionTitleHeight = $('#content h1').outerHeight(true);
	var canvasHeight = (contentHeight-statHeight-sectionTitleHeight)/2;
	createPieChart(chartContainer, "Plant composition", dataContent, canvasHeight, "#ffffff");
}

//Creates the arthropod chart composition of a given site. To do this it creates a new container, creates the data content array
// the way the library is expecting (objects with label and abundance) and creates the pie chart.
function createArthropodPieChart(data){
	var dataContent = [];
	
	for (var i in data){
		var arthropod = i;
		var abundance = data[i];
		dataContent.push({"label": arthropod.split("(")[0].trim(), "value": abundance});
	}
	var chartContainer = document.createElement("div");
	chartContainer.style.width = $('#arthropodComposition').width() + "px";
	$('#arthropodComposition').append(chartContainer);
	if(dataContent.length==0){
		$(chartContainer).append("<h1>Arthropod composition</h1><p>There is no data to create the arthropod composition</p>"); return;
	}
	var statHeight = $('#statistics').height();
	var contentHeight = $('#content').height();
	var sectionTitleHeight = $('#content h1').outerHeight(true);
	var canvasHeight = (contentHeight-statHeight-sectionTitleHeight)/2;
	createPieChart(chartContainer, "Arthropod composition", dataContent, canvasHeight, "#ffffff");
}