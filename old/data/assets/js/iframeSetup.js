// This JavaScript file will be executed when the index.html page is loaded. This will adjust the nav bar and the iframe heights.
// Then, it will set up the site information (set the top and right css properties, close the site info and set the open attribute to false).
// After that, we set up the site information button to open/hide that pannel. We do the same with the filters section
// We set the sliders and give them a max date, and add events to the submit filter button
$(document).ready(function(){
	adjustNavMapHeights($(window).height());
	setUpSiteInfo();
	setSectionButton();
	setFiltersButton();
	$('#yearInput').attr('data-slider-max', (new Date).getFullYear());
	$('#yearInput').attr('data-slider-value', '[' + $('#yearInput').attr('data-slider-min') + ',' + (new Date).getFullYear() + ']');
	sliderYear = $('#yearInput').slider({});
	sliderMonth = $('#monthInput').slider({});
	sliderMinSize = $('#minSize').slider({});
	setFilterSubmitButton();
	addLegend();
});