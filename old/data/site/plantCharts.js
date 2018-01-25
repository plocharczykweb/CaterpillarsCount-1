// Creates the top 6 plant charts of the given site
function createPlantsChart(data){
	
	arthropodIndex = 0;
	
	$(".arthropodCharts").empty(); //Added by Allan Clayton
	$(".plantCharts").empty(); //Added by Allan Clayton
	var sortedArray = countGroupByPlant(data);
	var topPlants = getTopSixPlantSpecies(sortedArray);
	//This creates the map composition of all the plants, and a specific plant composition can be accessed by the plant species
	var overallMapComposition = createPlantsCompositionMap(data, topPlants); 
	
	var overallWidth = $('#pieChartsContainer').width();
	var width = $(".plantCharts").width(); //changed by Allan Clayton
	// We create the pie chart for each of the plant species in the top 6 (if there are six, otherwise that number)
	for(var idx = 0; idx < topPlants.length; idx++){
		var plantSpecies = topPlants[idx];
		var specificMap = overallMapComposition[plantSpecies];
		// The library that creates the pie chart expects the data in an array of objects with two properties: the label and the value
		var dataContent = [];
		$.each(specificMap, function(arthropod, abundance) {
			dataContent.push({"label": arthropod.split("(")[0].trim(), "value": abundance, "color": getArthropodColor(arthropod.split("(")[0].trim())}); //color added by Allan Clayton
		});
		var chartContainer = document.createElement("div");
		chartContainer.style.width = width + "px";
		$('#plantChart' + (idx + 1)).append(chartContainer);
		createPieChart(chartContainer, plantSpecies.split("(")[0].trim(), dataContent, width, "#000000");
	}
}

// Groups the submissions by plant and creates an array where for each key, which is the plant name,
// the value is the number of surveys with that plant. Then, sorts the array by number of occurrences 
// and returns such array.
function countGroupByPlant(data){
	var map = {};
	for(var idx = 0; idx < data.length; idx++){
		var plantSpecies = data[idx]['plantSpecies'];
		if(plantSpecies in map){ // Plant species already in the map, so we just increase its value
			map[plantSpecies]++;
		} else { // Plant species not in the map, so we add it.
			map[plantSpecies] = 1;
		}
	}
	// We convert the map to an array because JavaScript allows sorting arrays but not maps the way we want
	var mapArray = [];
	for(var key in map){
		mapArray.push([key, map[key]]);
	}
	
	mapArray.sort(function(a, b){
		var firstValue = a[1];
		var secondValue = b[1];
		return firstValue > secondValue ? -1 : firstValue < secondValue ? 1 : 0;
	});
	return mapArray;
}

// Gets and returns an array with the top 6 plant species
function getTopSixPlantSpecies(sortedArray){
	var topPlants = [];
	var counter = 0;
	for(var idx = 0; idx < sortedArray.length; idx++){
		if(counter < 6){
			topPlants.push(sortedArray[idx][0]);
		} else {
			break;
		}
		counter++;
	}
	return topPlants;
}

//added by Allan Clayton
var arthropodColors = [];
function getArthropodColor(arthropod){
	if (arthropodColors[arthropod] === undefined){
	arthropodColors[arthropod] = pieChartColors[arthropodIndex]
	arthropodIndex = (arthropodIndex + 1)%pieChartColors.length;
	}
	return arthropodColors[arthropod];
}

// Creates a map with the top plant species as keys, and the values are maps with the 
//arthropod composition for that plant species.
function createPlantsCompositionMap(data, topPlantSpecies){
	var overallMap = {};
	for(var idx = 0; idx < data.length; idx++){
		var plantSpecies = data[idx]['plantSpecies'];
		var orderCount = data[idx]['orderCount'];
		if (topPlantSpecies.indexOf(plantSpecies) != -1){ //The plant species is in the top 6
			var orderArthropod = data[idx]['orderArthropod'];
			if (plantSpecies in overallMap){
				if (orderArthropod in overallMap[plantSpecies]){
					overallMap[plantSpecies][orderArthropod] += orderCount;
				} else {
					overallMap[plantSpecies][orderArthropod] = orderCount;
				}
			} else {
				overallMap[plantSpecies] = {};
				overallMap[plantSpecies][orderArthropod] = orderCount;
			}
		}
	}
	return overallMap;
}