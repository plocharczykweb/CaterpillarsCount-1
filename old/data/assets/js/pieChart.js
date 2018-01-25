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
				"borderRadius": 0,
				"font": "verdana",
				"fontSize": 14,
				"padding": 20
			}
		},
		"labels": {
			"outer": {
				"pieDistance": 12,
				"fill": outerLabelsColor
			},
			"inner": {
				"hideWhenLessThanPercentage": 1
			},
			"mainLabel": {
				"fontSize": 12
			},
			"percentage": {
				fontSize: 11
			},
			"percentage": {
				"color": "#ffffff",
				"decimalPlaces": 0
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