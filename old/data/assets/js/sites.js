// This JavaScript file will be executed when the raw-map page is loaded. It will make an AJAX call to get all the sites
// then it draws the sites on the Google Map.
$(window).load(function(){
	$.ajax('../api/sites.php', {
		type: 'GET',
		dateType: 'json',
		success: function(sites, xhr, status){
			allSites = getCorrectData(sites);
			sitesDrawOnMap(allSites);
		},
		error: function(){
			alert("There was an error getting sites");
		}
	});
});