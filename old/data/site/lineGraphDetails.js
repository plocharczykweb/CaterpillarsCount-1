/*created by Ethan Chu*/
function addDataToLineGraph(year, jsonData, dataNum){

//sample test data *REMOVE WHEN FINISHED*/////
//data = [{"day":135,"density":0.11111111111111},{"day":138,"density":0.11111111111111},{"day":141,"density":0.032258064516129},{"day":146,"density":0},{"day":148,"density":0.11428571428571},{"day":152,"density":0.17647058823529},{"day":155,"density":0.037735849056604},{"day":159,"density":0.058823529411765},{"day":162,"density":0.090909090909091},{"day":166,"density":0.11764705882353},{"day":169,"density":0.25},{"day":171,"density":0.16666666666667},{"day":173,"density":0.20588235294118},{"day":176,"density":0.11627906976744},{"day":178,"density":0},{"day":180,"density":0.21875},{"day":183,"density":0.11538461538462},{"day":187,"density":0.22222222222222},{"day":190,"density":0.037735849056604},{"day":192,"density":0},{"day":194,"density":0.066666666666667},{"day":197,"density":0.056603773584906},{"day":199,"density":0},{"day":201,"density":0.23529411764706},{"day":204,"density":1.4313725490196},{"day":211,"density":0.44444444444444},{"day":213,"density":0.5},{"day":215,"density":0.25},{"day":220,"density":0.5},{"day":227,"density":0},{"day":232,"density":0},{"day":234,"density":0},{"day":241,"density":0},{"day":248,"density":0}];
data = jsonData;

var dates = [];
var densities = [];
var lim = data.length;
for (var i = 0; i < lim; i++)
{
	
	//placeholder year
	var currYear = year;
	var dayVal = data[i].day;
	//console.log(dayVal);
	var date = dateFromDay(currYear, dayVal);
	
	
	//var dateStr = JSON.parse(date);
	//date = new Date(dateStr);
	var month = date.getMonth()+1;
	var day = date.getDate();
	//console.log(day);
	dates.push(currYear + "-" + month + "-" + day);
	
	
	var density = data[i].density;
	densities.push(density);
//	window.alert(d);
	//testData[i].day = date;
	//console.log(month);
//	console.log(testData[i].density);
}

var dataId = dataNum;
dates.unshift('x');
densities.unshift(dataNum);



	setTimeout(function () {
    chart.load({
        columns: [
            dates,
            densities
        ]
       
    });
    chart.axis.min(0);
}, 500);

//setTimeout(function() {
	//clearLineGraph();	
//}, 3000);

}


function clearLineGraph(){
	chart.unload();

}


function dateFromDay(year, day){
  var date = new Date(year, 0); // initialize a date in `year-01-01
  var finalDate = new Date(date.setDate(day));
  //console.log(finalDate);
  return finalDate; // add the number of days
}