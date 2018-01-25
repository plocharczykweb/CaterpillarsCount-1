$(document).ready(function(){
    fetchSite();
});

function fetchSite(){
        $.ajax({
		    url: "/api/sites.php",
		    type : "POST",
		    crossDomain: true,
            async: false,
		    dataType: 'json',
		    data: JSON.stringify({
			    "action" : "getAll"
		    }),
		success: function(siteResult){
            generateTable(siteResult);
            },
		error : function(xhr, status, error){
			$("#site").html("AJAX ERROR: "+error);
		    }
        });
}

function generateTable(Sites){
    var table=$("#siteTable");
    var headline="<tr><td>Site Name</td><td>Site Id</td><td>Site State</td><td>Circle</td><td>Created On</td><td>QR Code</td></tr>";
    table.append(headline);
    for(var i=0; i<Sites.length; i++){
        var cell="<tr>";
        cell+="<td>"+Sites[i].siteName+"</td>";
        //site name
        cell+="<td>"+Sites[i].siteID+"</td>";
        //site id
        cell+="<td>"+Sites[i].siteState+"</td>";
        //site state
        cell+="<td>"+Sites[i].numCircles+"</td>";
        //circle       
        cell+="<td>"+Sites[i].timeStamp+"</td>";
        //created on
        cell+='<td><a href="generate.html?siteId='+Sites[i].siteID+'" target="_blank">Create QR Code</a>';
        //qrcode
        cell+="</tr>"
        table.append(cell);
    }
}

