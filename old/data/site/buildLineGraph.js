/*created by Ethan Chu*/
var chart;
$(document).ready(function(){
	///params: year, data array, chart title
	
chart = c3.generate({
     bindto: '#lineChartContainer',
   data: {
   		x: 'x',
	
	columns: []
   },
   transition: {
        duration: 1500
    },
   axis: {
      y: {
      	show: true,
        label: { 
        text: 'Density',
        position: 'outer-middle',
        
        },
        //max: 1.0,
        //min: 0.0,
        padding: {bottom: 0}
      },
      x: {
      	
		
      	type: 'timeseries',
      	tick: {
                //format: function (x) { return x.getMonth() + 1; },
                //culling: {max: 12},
                format: '%m-%d',
                fit: true
                //count: 12
                //count: 12
              
            },
        show: true,
        label: { 
          text: 'Date',
          position: 'outer-center'
        },
             
      },
      
 		
    },
    tooltip: {
    grouped: true	
    	
    }
    
   
});

	chart.resize({height:400, width: 1100});
	chart.axis.min(1);
	
//call addDataToLineGraph() to test////
////remove when done with testData////
//addDataToLineGraph();


//console.log("added");	
	
	
});
