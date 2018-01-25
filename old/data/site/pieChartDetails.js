pieChartColors = [
				"#2484c1", "#65a620", "#7b6888", "#a05d56", "#961a1a", "#d8d23a", "#e98125", "#d0743c", "#635222", "#6ada6a",
				"#0c6197", "#7d9058", "#207f33", "#44b9b0", "#bca44a", "#e4a14b", "#a3acb2", "#8cc3e9", "#69a6f9", "#5b388f",
				"#546e91", "#8bde95", "#d2ab58", "#273c71", "#98bf6e", "#4daa4b", "#98abc5", "#cc1010", "#31383b", "#006391",
				"#c2643f", "#b0a474", "#a5a39c", "#a9c2bc", "#22af8c", "#7fcecf", "#987ac6", "#3d3b87", "#b77b1c", "#c9c2b6",
				"#807ece", "#8db27c", "#be66a2", "#9ed3c6", "#00644b", "#005064", "#77979f", "#77e079", "#9c73ab", "#1f79a7"
			];
plantIndex = 0;
arthropodIndex = 0;



// This function will create a pie chart inside the given chart container HTML element, with a given title passed as a parameter
// with the data passed in the dataContent array (objects with label and value), with a height for the pie chart and the color of the labels as 
// parameters as well. This function uses the d3pie library to create such pie chart.
// It adds the click event and the tooltips that will be displayed when the user hovers over a given section of the pie chart.
function createPieChart(chartContainer, chartTitle, dataContent, canvasHeight, outerLabelsColor){
	$(chartContainer).css('height', canvasHeight + 'px');
	var pie = new d3pie(chartContainer, {
		"header": {
			"title": {
				"text": chartTitle,
				"fontSize": 24,
				"font": "open sans"
			}
		},
		"size": {
			"canvasWidth": $(chartContainer).width()*0.9,
			"canvasHeight": canvasHeight * 0.8
		},
		"data": {
			"sortOrder": "value-desc",
			"content": dataContent
		},
		"tooltips": {
			"enabled": true,
			"type": "placeholder",
			"string": "{label}, {value}, {percentage}%",
			"styles": {
				"fadeInSpeed": 500,
				"backgroundColor": "#00cc99",
				"backgroundOpacity": 0.9,
				"color": "#ffffcc",
				"borderRadius": 4, //Changed by Allan Clayton
				"font": "verdana",
				"fontSize": 14,
				"padding": 4 //Changed by Allan Clayton
			}
		},
		"labels": {
			"outer": {
				"format": "none",
				"pieDistance": 12,
			},
			"inner": {
				"format": "percentage",
				"hideWhenLessThanPercentage": 6 //Changed by Allan Clayton
			},
			"mainLabel": {
				"fontSize": 16
			},
			"percentage": {
				"color": "#ffffff",
				"decimalPlaces": 0,
				"fontSize": 11
			},
			"value": {
				"color": "#adadad",
				"fontSize": 11
			},
			"lines": {
				"enabled": true
			},
		},
		"effects": {
			"pullOutSegmentOnClick": {
				"effect": "linear",
				"speed": 400,
				"size": 8
			}
		},
		"misc": {
			"gradient": {
				"enabled": true,
				"percentage": 100
			}
		}
	});
}