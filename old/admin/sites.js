var numCircles;
var cells;
var row_contents = [];
var input_form_str = '<div class="plant-input"><select id="circle">';
    $(document).ready(function () {
        //Create the site JTable, this can be a little difficult to understand.
        $('#SiteTable').jtable({
            title: 'Sites',
            actions: {
                //Get data from server function
                listAction: function (postData, jtParams) {
                    return $.Deferred(function ($dfd) {
                        $.ajax({
                            url: '/api/sites.php/AllAuthorized',
                            type: 'GET',
                            dataType: "json",
                            processData: false,
                            success: function (data) {
                                if (data.status = "OK"){
                                    var response = {Result: "OK"};
                                    response["Records"] = data.sites;
                                    response["TotalRecordCount"] = data.length;
                                    $dfd.resolve(response);
                                }else{
                                    var response = {"Records": null};
                                    response["TotalRecordCounts"] = 0;
                                    $dfd.resolve(response);
                                    //alert(data.status);
                                    //$dfd.reject();
                                }
                                
                            },
                            error: function () {
                                $dfd.reject();
                            }
                        });
                    });
                },
                //Create a new site function
                createAction: function (postData, jtParams) {
                    var input = $('div.jtable-input input');

                    var data = {};

                    input.each(function(){
                        var value = $(this);
                        data[value.attr("name")] = value.val();
                    });
                    console.log(data);

                    input = $('div.jtable-input textarea');
                    data[input.attr("name")] = input.val();

                    console.log(data);
                    data.action = 'create';
                    data.email = admin.email;
                    return $.Deferred(function ($dfd) {
                        $.ajax({
                            url: '/api/sites.php',
                            type: 'POST',
                            dataType: "json",

                            data: JSON.stringify(data),
                            processData: false,
                            
                            success: function (data) {
                                var response = {Result: "OK"};
                                response["Record"] = data;
                                response["TotalRecordCount"] = data.length;
                                $dfd.resolve(response);
                                
                            },
                            error: function (e) {
                                console.log(e);
                                $dfd.reject();
                            }
                        });
                    });
                },
            },
            messages:{
                addNewRecord: "Create New Site"
            },
            //all of the necessary columns and relevant data
            fields: {
                siteID: {
                    key: true,
                    list: false
                },
                siteName: {
                    title: 'Name',
                    edit: false
                    
                },
                siteState: {
                    title: 'State',
                    edit: false,
                    width: '5%'

                },
                siteLat: {
                    title: 'Latitude',
                    edit: false
                    
                },
                siteLong:{
                    title: 'Longitude',
                    edit: false
                },
                siteDescription: {
                    title: 'Description',
                    type: 'textarea',
                    edit: false,
                    width: '40%'

                },
                password: {
                    title: 'Password',
                    type: 'password',
                    list: false,
                    edit: false
                },
                sitePassword: {
                    title: 'Site Password',
                    type: 'password',
                    list: false
                },
                numCircles: {
                    title: '# Circles',
                    edit: false
                },
                timeStamp: {
                    title: "Created On",
                    edit: false,
                    create: false

                },
                isValid: {
                    title: "Valid?",
                    type: 'checkbox',
                    values: {'0': 'Invalid','1':'Valid'},
                    edit: false,
                    create: false
                },
                species: {
                    title: 'Plant',
                    edit: false,
                    create: false, 
                    width: '20%', 
                    display: function(siteData){
                        var $link = $('<img src="../quiz/assets/images/icon.jpg" title="Edit Plant Species" height="28" width="32"/>');
                        $link.click(function(){
                            
                            $('#SiteTable').jtable('openChildTable', $link.closest('tr'), 
                            {
                                title: "Plant Species", 
                                selecting: true,
                                selectOnRowClick: true,
                                actions: {
                                    listAction: function(postData, jtParams){
                                        var send_data = {};
                                        send_data['action'] = 'getAll';
                                        send_data['siteID'] = siteData.record.siteID;
                                        send_data['circle'] = 0;
                                        send_data['survey'] = 0;
                                        send_data['plantSpecies'] = '';
                                        return $.Deferred(function($dfd){
                                            $.ajax({
                                                url: '/api/PlantSpecies.php',
                                                type: 'POST',
                                                datatype: 'json',
                                                data: JSON.stringify(send_data),
                                                success: function(data){
                                                    var response = {};
                                                    response["Result"] = "OK";
                                                    response["Records"] = data['plants'];
                                                    response["TotalRecordCount"] = data['number'];

                                                    $dfd.resolve(response);
                                                },
                                                error: function(e){
                                                    console.log(e);
                                                    $dfd.reject();
                                                }
                                            });
                                        });
                                    },
                                    updateAction: function(postData){
                                        //parsing postData to retrieve new plantSpecies name
                                        //postData initially has the form "plantSpecies=plant+name"
                                        var split1 = postData.split('=');
                                        var name_with_plus="";
                                        for(var i=1; i<split1.length; i++){
                                            name_with_plus += split1[i];
                                        }
                                        var split2 = name_with_plus.split("+");
                                        var name="";
                                        for(var i=0; i<split2.length; i++){
                                            name += split2[i];
                                            if(i<split2.length-1){name += " ";}
                                        }

                                        var updateData = {};
                                        updateData['action'] = "changeRecord";
                                        updateData['plantSpecies'] = name; 
                                        updateData['siteID'] = siteData.record.siteID; 
                                        updateData['circle'] = row_contents[0]; 
                                        updateData['survey'] = row_contents[1]; 
                                
                                        //var $selectedRows = $("#SiteTable>.jtable-main-container>.jtable>tbody>.jtable-child-row .jtable-row-selected");
                                        
                                        return $.Deferred(function($dfd){
                                            $.ajax({
                                                url: '/api/PlantSpecies.php',
                                                type: 'POST',
                                                datatype: 'json',
                                                data: JSON.stringify(updateData),
                                                success: function(data){
                                                    var update_response = {};
                                                    update_response["Result"] = "OK";
                                                    update_response["Records"] = data['plants'];
                                                    update_response["TotalRecordCount"] = data['number'];
                                                    $dfd.resolve(update_response);
                                                },
                                                error: function(){
                                                    $dfd.reject();
                                                }
                                            });
                                        });
                                    }
                                },
                                fields:{
                                    circle: {
                                        title: 'Circle',
                                        edit: false
                                    },
                                    survey: {
                                        title: 'Survey',
                                        edit: false
                                    },
                                    plantSpecies: {
                                        title: 'Species',
                                        edit: true
                                    }
                                },
                                recordsLoaded: function(event, data){
                                    var $edit_button = $("#SiteTable>.jtable-main-container>.jtable>tbody>.jtable-child-row>td>.jtable-child-table-container>.jtable-main-container>.jtable>tbody>tr>.jtable-command-column>button");
                                    
                                    $edit_button.click(function(){
                                       cells = $(this).closest("td").siblings("td");
                                       row_contents = [];
                                       cells.each(function(){
                                           row_contents.push($(this).text());
                                       });
                                   }); 
                                } 
                            }, function(data){ //open handler
                                    data.childTable.jtable('load');
                                });
                            });
                            return $link;
                        }
                    } 
                }
        });
        //After init, must call load
        $('#SiteTable').jtable('load');
    });

function getCircles(sid){
    $.ajax("/api/sites.php", {
		type: "POST",
		dataType: "json",
		data: JSON.stringify({action: "getOneByID", siteID: sid}),
		success: function (data, xhr, status) {
			numCircles = Number(data.numCircles);
			for (var i = 1; i <= numCircles; i++) {
				input_form_str += "<option value = '" + i + "'>" + i + "</option>";
			}
		}
	});
}