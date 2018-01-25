$(document).ready(function () {
	fillDropDown();
	countPhotos();
	buildTable();
});


function fillDropDown() {
	$(function(){
		var choose_x = $("#add_x");
		for (i=1; i<=20; i++){
			choose_x.append($('<option></option>').val(i).html(i))
		}
	});
}


function countPhotos(){
	$.ajax({
		url: "/api/manage_quiz.php",
		type: "GET",
		dataType: 'json',
		data: {action:"count"},
		success: function(response, status, jqXHR){
			var orders = Object.keys(response);
			for (let order of orders) {
				$("[id='" + order + "']").text(response[order]);
			}

		}
	});
}

function buildTable() {
	$('#photos_table').jtable({
		title: 'Table of people',
		paging: true,
        pageSize: 50,
		sorting: true,
		defaultSorting: 'id ASC',
		actions: {
			listAction: 'PhotoActions.php?action=list',
			updateAction: 'PhotoActions.php?action=update',
			deleteAction: 'PhotoActions.php?action=delete'
		},
		fields: {
			id: {
				key: true,
				create: false,
				edit: false,
				list: true
			},
			classification: {
				title: 'classification',
				width: '20%'
			},
			url: {
				title: 'url',
				width: '60%'
			},
			Photo: {
				title: "photo",
				width: '20%',
				edit: false,
				create: false,
				display: function (data) {
					return '<img src=' + data.record.url + ' width="200"/>';
			}
 }
		}
	});

	$('#photos_table').jtable('load');
}


function addPhoto() {
	var url = $('#url').val();
	var order = $('#classification').val();
	
	$.ajax({
		url: "/api/manage_quiz.php",
		type: "GET",
		dataType: 'text',
		data: {url:url, order:order},
		success: function(response, status, jqXHR){
			
			if (response == "does exist") {
				$.ajax({
					url: "/api/manage_quiz.php",
					type: "POST",
					dataType: 'text',
					data: {url:url, order:order},
					success: function(response, status, jqXHR){
						alert("Response from server: " + response);
						buildTable();
					}
				});
			} else {
				alert("This url " + response);
			}
		}
	});
}


function addXPhotos() {
	var num = $('#add_x').val();
	
	$.ajax({
		url: "/api/manage_quiz.php",
		type: "POST",
		dataType: 'text',
		data: {num:num},
		success: function(response, status, jqXHR){
			alert("Response from server: " + response);
			buildTable();
		}
	});
}