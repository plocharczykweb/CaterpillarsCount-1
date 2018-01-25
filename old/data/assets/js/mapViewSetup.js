// This function will open the site info section in the index.html file, updating the CSS and the open data attribute of the HTML element.
function openInfoSection(){
	$('#siteInfo', window.parent.document).animate({'right': '0px'}, 1000, function(){
		parent.$('#siteInfo').data('open', true);
		$('#arrowSiteInfo span', window.parent.document).removeClass('glyphicon-chevron-left');
		$('#arrowSiteInfo span', window.parent.document).addClass('glyphicon-chevron-right');
	});
}

// This function creates the statistics section inside the site info section of a given site. It will add 
// information like the name, description, number of different users, number of different arthropod orders and number of surveys
// contained in that site.
function createStatisticsSection(data, siteId){
	if(!data.siteDescription){
		data.siteDescription = "(No description available)";
	}
	$('#siteInfo #content', window.parent.document).prepend("<h2 id='contentHeader'>" + data.siteName + "</h2>");
	$('#statistics', window.parent.document).append("<p><span class=''>Site description</span>: " + data.siteDescription + "</p>");
	$('#statistics', window.parent.document).append("<p><span class=''>Number of different users</span>: " + data.countUsers + "</p>");
	$('#statistics', window.parent.document).append("<p><span class=''>Number of different arthropod orders</span>: " + data.countArthropods + "</p>");
	$('#statistics', window.parent.document).append("<p><span class=''>Number of surveys</span>: " + data.countSurveys + "</p>");
	$('#statistics', window.parent.document).append("<p><span class=''>Most recent survey</span>: " + data.recentSurvey + "</p>");
	$('#statistics', window.parent.document).append("<a id='detailedSiteLink' href='site/details.html?" + siteId + "'>See site</a>");
}

// This function makes an AJAX call to the REST API in the backend to get the information necessary to fill the 
// site statistics section for a given site.
function makeSiteStatisticsRequest(siteID){
	$.ajax('../api/sites.php/Statistics?siteID=' + Number(siteID), {
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

// This function makes an AJAX call to the REST API in the backend to get the plant composition of the site.
// Once it gets the data, it creates the plant chart for the site.
function makePlantCompositionRequest(siteID){
	$.ajax('../api/sites.php/PlantComposition?siteID=' + Number(siteID), {
		type: 'GET',
		dataType: 'json',
		success: function(data, xhr, status){
			parent.createPlantPieChart(data);
		}
	});
}

// This function makes an AJAX call to the REST API in the backend to get the arthropod composition of the site.
// Once it gets the data, it creates the arthropod composition for the site.
function makeArthropodCompositionRequest(siteID){
	$.ajax('../api/sites.php/ArthropodComposition?siteID=' + Number(siteID), {
		type: 'GET',
		dataType: 'json',
		success: function(data, xhr, status){
			parent.createArthropodPieChart(data);
		}
	});
}

// This function adds event callbacks to the sites on the map. When a site is clicked, the site info section will be open and will contain 
// information about the site clicked. When a site is hovered over, a tooltip will appear showing the name of the site.
function addSiteToOverlayMouse(panes, element, dataMap){
	panes.overlayMouseTarget.appendChild(element.parentNode);
	google.maps.event.addDomListener(element[0], 'click', function() {
		$('#siteInfo #content h2', window.parent.document).remove();
		$('#siteInfo #content div', window.parent.document).empty();
		$('#statistics', window.parent.document).append("<p><span class=''>SiteID</span>: " + element[0].id + "</p>");
		makeSiteStatisticsRequest(element[0].id);
		makePlantCompositionRequest(element[0].id);
		makeArthropodCompositionRequest(element[0].id);
		var classOld = $('.cactive').attr('class');
		if(classOld){
			var newOldClassParts = classOld.split('cactive');
			var newOldClass = newOldClassParts.join('');
			$('.cactive').attr('class', newOldClass);
		}
		$(this).attr('class', $(this).attr('class') + ' cactive');
		openInfoSection();
	});
	google.maps.event.addDomListener(element[0], 'mouseover', function(){
		$(element[0]).attr('title', dataMap[element[0].id].siteName);
		$(element[0]).tooltipsy({
				offset: [-10, 0],
				show: function (e, $el) {
					$el.css({
						'left': parseInt($el[0].style.left.replace(/[a-z]/g, '')) - 50 + 'px',
						'opacity': '0.0',
						'display': 'block'
					}).animate({
						'left': parseInt($el[0].style.left.replace(/[a-z]/g, '')) + 50 + 'px',
						'opacity': '1.0'
					}, 300);
				},
				hide: function (e, $el) {
					$el.slideUp(100);
				},
				css: {
					'padding': '10px',
					'max-width': '200px',
					'color': '#303030',
					'background-color': '#f5f5b5',
					'border': '1px solid #deca7e',
					'-moz-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
					'-webkit-box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
					'box-shadow': '0 0 10px rgba(0, 0, 0, .5)',
					'text-shadow': 'none'
				}
			});
	});
}

// Gets an array of objects and returns an array with objects containing only relevant information to create the sites.
// This information includes: site id, site latitude, site longitude and site name
function getCorrectData(sites){
	var data = [];
	
	for(var i in sites){
		var id = Number(sites[i].siteID);
		var lat = Number(sites[i].siteLat);
		var lng = Number(sites[i].siteLong);
		var name = sites[i].siteName;
		
		data.push({siteID: id, siteLat: lat, siteLong: lng, siteName: name});					
	}
	return data;
}

// We create a map where the keys are the site IDs and the values are maps containing information about that site.
// We do this because working of performance
function getDataMap(data){
	var map = {};
	$.each(data, function(index, value){
		map[value.siteID] = value;
	});
	return map;
}

// Creates and returns an array with the ids of all the sites in the data array passed as a parameter
function getIDArray(data){
	var ids = [];
	for(var i in data){
		var site = data[i];
		ids.push(site.siteID);
	}
	return ids;
}