//builds the admin pill tab, and then highlights the correct one

function build_pills(){
	$('#admin_vertical_pills').append(
			'<h1> Actions</h1>'+
                    '<ul class="nav nav-pills nav-stacked">'+
                        '<li role = "presentation"><a href = "master_home.html">Sites</a></li>'+
                        '<li role = "presentation"><a href = "surveys.html">Surveys</a></li>'+
                        '<li role = "presentation"><a href = "curate_survey_data.html">Curate Data</a></li>'+
                        '<li role = "presentation"><a href = "review_plant_data.html">Review Plant Data</a></li>'+
						'<li role = "presentation"><a href = "manage_quiz.html">Manage Quiz Photos</a></li>'+
                        '<li role = "presentation"><a href = "qrcode.html">Generate QR Code</a></li>'+
                        '<li role = "presentation" class "master"><a href = "/phpMyAdmin/">phpMyAdmin</a></li>'+
                    '</ul>');

	var splitPath = window.location.pathname.split('/');
	var activeSite = splitPath[splitPath.length-1];
	$('[href = "'+activeSite+'"]').parent().addClass('active');
}