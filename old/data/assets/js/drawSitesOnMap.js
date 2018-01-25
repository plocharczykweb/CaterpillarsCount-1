// This function will draw all the sites on top of the Google map in an overlay layer.
// Each circle represents a site in the system. This function will also redraw the sites 
// when the user zooms in or zooms out, and will add click and hover functions to the circles.
var allSites;
var siteMarkers = {};
var clickedSite = null;


var clickedColor = "#50509B";
var defaultColor = "#80ac80";
var defaultScale = 8.5;

var minColor = d3.rgb(255,0,0);
var maxColor = d3.rgb(0,0,255);

function siteIcon(site, clicked){
	var scale;
	var color;
	if (site.abundance === undefined){
		scale = defaultScale;
		color = defaultColor;
	}else{
		scale = (site.abundance * 17) + 3;
		color = d3.interpolateLab(minColor,maxColor)(site.abundance);
		
	}
	if(clicked){
		color = clickedColor;
	}
	return {
			  path: google.maps.SymbolPath.CIRCLE,
			  scale: scale,
			  strokeWeight: 1,
			  fillColor: color,
			  fillOpacity: .9
			};
}

function sitesDrawOnMap(sites){
	
	for (var i in siteMarkers) {
    siteMarkers[i].setMap(null);
  }

	siteMarkers = {};
	
	for (i in sites){
		
		var site = sites[i];
		
		
		
		var marker = new google.maps.Marker({
			position: {lat: site.siteLat, lng: site.siteLong},
			icon: siteIcon(site, false),
			draggable: false,
			map: map,
			title: site.siteName,
			animation: google.maps.Animation.DROP,
			clickable: true,
			site : site
			});
		
		siteMarkers[site.siteID] = marker;
		
		marker.addListener('click', makeClickRequest);
		marker.addListener('click', bounce);


	}
	clickedSite = null;
}

function bounce(marker)
{
	
marker.setAnimation(google.maps.Animation.BOUNCE);
    setTimeout(function(){ marker.setAnimation(null); }, 750);

}



function makeClickRequest()
{
	//marker.setAnimation(google.maps.Animation.BOUNCE);
    //setTimeout(function(){ marker.setAnimation(null); }, 750);
	if(clickedSite != null){
		var oldMarker = siteMarkers[clickedSite];
		oldMarker.setIcon(siteIcon(oldMarker.site, false));
		oldMarker.setAnimation(null);
	}
	 
	var siteID = this.site.siteID;
	console.log(this.site);
	this.setIcon(siteIcon(this.site,true));
	clickedSite = siteID;
	bounce(this);
	$('#siteInfo #content h2', window.parent.document).remove();
	$('#siteInfo #content div', window.parent.document).empty();
	//$('#statistics', window.parent.document).append("<p><span class=''>SiteID</span>: " + siteID + "</p>");
	makeSiteStatisticsRequest(siteID);
	makePlantCompositionRequest(siteID);
	makeArthropodCompositionRequest(siteID);
	
	openInfoSection();
}


/*
function sitesDrawOnMapOLD(data){
	var overlay = new google.maps.OverlayView();
	var filteredSitesIds = getIDArray(data);
	var minColor = d3.rgb(255,0,0);
	var maxColor = d3.rgb(0,0,255);

	overlay.onAdd = function() {
		var layer = d3.select(this.getPanes().overlayLayer).append("div")
			.attr("class", "stations");
				
		panes = this.getPanes();
		// Draw each marker as a separate SVG element.
		overlay.draw = function() {
			var projection = this.getProjection(),
			padding = 20;
			// We get the previous active site so that we will keep it active after all the circles 
			// are redrawn.
			var activeId = 'None';
			var activeEls = $('.cactive');
			if($(activeEls).length){
				activeId = $(activeEls[0]).attr('id');
			}
			// Transition to remove the old circles
			d3.selectAll("circle")
				.transition()
					.duration(1)
					.attr('r', 0)
				.each('start', function(){
					d3.select(this.parentNode).remove();
				});
			
			
			var marker = layer.selectAll("svg")
				.data(data)
				.each(transform) // update existing markers
			.enter().append("svg:svg")
				.each(transform)
				.attr("class", "marker");

			// Add a circle.
			marker.append("svg:circle")
				.attr("cx", padding)
				.attr("cy", padding)
				//d3.interpolateLab(d3.rgb(R,G,B),d3.rgb(0,100,0))(*number between 0-1*)
				.style("fill", function(d) { 
					//console.log(d.abundance);
					//*
					if(d.abundance < 0){
						d.abundance = 0;
					}
					if(d.abundance > 20){
						console.log("abundance greater than 20:" + d.abundance);
						d.abundance = 20;
					}/*/
				/*		return d3.interpolateLab(minColor,maxColor)(d.abundance);})
				.attr("id", function(d){return d.siteID;})
				.attr("data-site-name", function(d){return d.siteName;})
				.attr("class", function(d){
					if(filteredSitesIds.indexOf(d.siteID)==-1){
						return "filteredOut";
					}
				})
				.transition()
					.duration(1500)
					.attr('r', function(d){
						if(filteredSitesIds.indexOf(d.siteID)==-1){
							return 0;
						}
						else if('abundance' in d){
							return (d.abundance * 17) + 3;
						}
						else return 8.5;
					});
			
			// Restablishes the active site
			if (activeId != 'None'){
				$('#' + activeId).attr('class', $('#' + activeId).attr('class') + ' cactive');
			}
			var circles = marker.selectAll("circle");
			// We add the circles to the overlay mouse so that we can add click and hover events
			circles.forEach(function(element, index, array){
				var dataMap = getDataMap(allSites);
				addSiteToOverlayMouse(panes, element, dataMap);
			});

			

			// The transform function will be used to transform the latitude and longitude coordinates of a 
			//given site to pixels in the screen.
			function transform(d) {
				d = new google.maps.LatLng(d.siteLat, d.siteLong);
				d = projection.fromLatLngToDivPixel(d);
				return d3.select(this)
					.style("left", (d.x - padding) + "px")
					.style("top", (d.y - padding) + "px");
			}
		};
	};
	overlay.setMap(map);
}
*/