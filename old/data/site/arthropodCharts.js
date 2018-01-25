// Creates the top 6 arthropod charts of the given site
function createArthropodChart(data){
	
	plantIndex = 0;
	
	$(".plantCharts").empty(); //Added by Allan Clayton
	$(".arthropodCharts").empty(); //Added by Allan Clayton
	var sortedArray = countGroupByArthropod(data);
	var topArthropods = getTopSixArthropodOrders(sortedArray);
	//This creates the map composition of all the arthropods, and a specific arthropod composition can be accessed by the arthropod order
	var overallMapComposition = createArthropodCompositionMap(data, topArthropods);
	
	var overallWidth = $('#pieChartsContainer').width();
	var width = $(".arthropodCharts").width(); //Changed by Allan Clayton
	// We create the pie chart for each of the plant species in the top 6 (if there are six, otherwise that number)
	for(var idx = 0; idx < topArthropods.length; idx++){
		var orderArthropod = topArthropods[idx];
		var specificMap = overallMapComposition[orderArthropod];
		// The library that creates the pie chart expects the data in an array of objects with two properties: the label and the value
		var dataContent = [];
		$.each(specificMap, function(plant, abundance) {
			dataContent.push({"label": plant.split("(")[0].trim(), "value": abundance, "color": getPlantColor(plant.split("(")[0].trim())});
		});
		var chartContainer = document.createElement("div");
		chartContainer.style.width = width + "px";
		$('#arthropodChart' + (idx + 1)).append(chartContainer);
		createPieChart(chartContainer, orderArthropod.split("(")[0].trim(), dataContent, width, "#000000");
	}
}

// Groups the submissions by arthropod and creates an array where for each key, which is the arthropod name,
// the value is the abundance of that arthropod. Then, sorts the array by number of occurrences 
// and returns such array.
function countGroupByArthropod(data){
	var map = {};
	for(var idx = 0; idx < data.length; idx++){
		var orderArthropod = data[idx]['orderArthropod'];
		var orderCount = data[idx]['orderCount'];
		if(orderArthropod in map){ // Arthropod species already in the map, so we just increase its value
			map[orderArthropod] += orderCount;
		} else { // Arthropod species not in the map, so we add it.
			map[orderArthropod] = orderCount;
		}
	}
	// We convert the map to an array because JavaScript allows sorting arrays but not maps the way we want
	var mapArray = [];
	for(var key in map){
		mapArray.push([key, map[key]]);
	}
	
	//Modified by Allan Clayton to put Caterpillars first, if present
	mapArray.sort(function(a, b){
		if ((a[0].split("("))[0].trim() === "Caterpillars"){
			return -1;
		}
		if ((b[0].split("("))[0].trim() === "Caterpillars"){
			return 1;
		}
		var firstValue = a[1];
		var secondValue = b[1];
		return firstValue > secondValue ? -1 : firstValue < secondValue ? 1 : 0;
	});
	return mapArray;
}

// Gets and returns an array with the top 6 arthropod orders
function getTopSixArthropodOrders(sortedArray){
	var topArthropods = [];
	var counter = 0;
	for(var idx = 0; idx < sortedArray.length; idx++){
		if(counter < 6){
			topArthropods.push(sortedArray[idx][0]);
		} else {
			break;
		}
		counter++;
	}
	return topArthropods;
}

//added by Allan Clayton
var plantColors = [];
function getPlantColor(plant){
	if (plantColors[plant] === undefined){
	plantColors[plant] = pieChartColors[plantIndex];
	plantIndex = (plantIndex+1)%pieChartColors.length;
	}
	return plantColors[plant];
}

// Creates a map with the top arthropod order as keys, and the values are maps with the 
// plant species composition for that arthropod order.
function createArthropodCompositionMap(data, topArthropods){
	var overallMap = {};
	for(var idx = 0; idx < data.length; idx++){
		var arthropodOrder = data[idx]['orderArthropod'];
		if (topArthropods.indexOf(arthropodOrder) != -1){ //The arthropod order is in the top 6
			var plantSpecies = data[idx]['plantSpecies'];
			if (arthropodOrder in overallMap){
				if (plantSpecies in overallMap[arthropodOrder]){
					overallMap[arthropodOrder][plantSpecies] += 1;
				} else {
					overallMap[arthropodOrder][plantSpecies] = 1;
				}
			} else {
				overallMap[arthropodOrder] = {};
				overallMap[arthropodOrder][plantSpecies] = 1;
			}
		}
	}
	return overallMap;
}