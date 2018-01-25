var siteID;
$(document).ready(function(){
   siteID=$.urlParam("siteId");
   if(siteID!=undefined&&siteID!=0){
        $.ajax({
		    url: "/api/sites.php",
		    type : "POST",
		    crossDomain: true,
            async: false,
		    dataType: 'json',
		    data: JSON.stringify({
			    "action" : "getOneByID",
			    "siteID" : siteID
		    }),
		success: function(circleResult){
            //$("#header").html("Site Name: "+circleResult.siteName+" Circle#: "+circleResult.numCircles);
            generateTable(circleResult.siteID, circleResult.numCircles, circleResult.siteName);
            },
		error : function(xhr, status, error){
			$("#hearder").html("AJAX ERROR: "+error);
		    }
        });
   }else{

   }
});

$.urlParam = function(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    if (results==null){
       return null;
    }
    else{
       return results[1] || 0;
    }
}

function generateTable(ID, circileNum, siteName){
    var table=$("table.qrlist");
    var content="";
    var survey={0:'A', 1:'B', 2:'C', 3:'D', 4:'E'};
    var tree=["AVL tree", "red black tree", "huffman tree ", "binary tree", " balanced tree"];
    var siteId=ID;
    var qrcodelist=[];
    var x=0;
    var k=0;
    var row="<tr>";
    for(var i=1; i<=circileNum; i++){
        for(var j=0; j<5; j++){
            if(k==3){
                row+="</tr>";
                content+=row;
                row="<tr>";
                k=0;
            }
            var plant="";
            $.ajax({
		        url: "/api/PlantSpecies.php",
		        type : "POST",
                crossDomain: true,
                async: false,
		        dataType: 'json',
		        data: JSON.stringify({
			        "action" : "getPlantData",
			        "siteID" : siteID,
                    "circle" : i,
                    "survey" : survey[j],
                    "plantSpecies" : "NA"
		        }),
		    success: function(result){
                plant=result.plantSpecies;
                },
		    error : function(xhr, status, error){
			    $("#hearder").html("Plant AJAX ERROR: "+error);
		        }
            });
            var code="{\"siteID\": \""+siteId+"\", \"circle\":\""+i+"\" ,\"survey\": \""+survey[j]+"\"";
            if(plant!="NONE"){
                code+=", \"plantSpecies\":\""+plant+"\"";
            }
            code+="}";
            qrcodelist.push(code);
            row+="<th class='qrcode'>";
            row+="<div id="+x+">";
             x+=1;
            row+="</div>";
            //row+=code;
            row+="<div class=\"qr test\">"+"Site: "+siteName+"<br>Circle: "+i+"&nbsp;&nbsp;&nbsp;&nbsp; Survey: "+survey[j]+"<br>Plant: "+plant+"</div>";
            row+="</th>";
            k+=1;
        }
    }
    content+=row;
    content+="</tr>";
    table.html(content);
    for(var k=0; k<qrcodelist.length; k++){
        var code=qrcodelist[k];
        $("#"+k).qrcode({width: 250,height: 250,text: code});
    }
}