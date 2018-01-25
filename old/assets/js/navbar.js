
//Creates Navigation Bar and highlights active tab
$(document).ready(function(){
    var html = "<div class='navbar navbar-default' role='navigation'>" +
				    "<div class='navbar navbar-header'>" +
                        "<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-responsive-collapse'>" +
                            "<span class='icon-bar'></span>" +
                            "<span class='icon-bar'></span>" +
                            "<span class='icon-bar'></span>" +
                        "</button>" +
                    "</div>" +
                    "<div class='navbar-collapse collapse navbar-responsive-collapse'>" +
                        "<ul class='nav navbar-nav'>" +
                            "<li id = 'nav_home'><a href='/index.html'>Home</a></li>" +
                            "<li id = 'nav_data'><a href='/data/'>Explore Data</a></li>" +
                            "<li id = 'nav_participate'><a href='/participate/'>Participate</a></li>" +
                            "<li id = 'nav_learning'><a href='/learning/'>Learning Activities</a></li>" +
                            "<li id = 'nav_user'><a href='/user/index.html'>Submit Observations</a></li>" +
                            "<li id = 'nav_admin'><a href='/admin/master_home.html'>Administration</a></li>" +
                            "<li id = 'nav_quiz'><a href='/quiz/'>Quiz</a></li>" +
                            "<li id = 'nav_admin'><a href='/faq.html'>FAQ</a></li>" +
                       "</ul>" +
                    "</div>" +
	    	  "</div>";

    $(".masthead").append(html);



    var urlPath = window.location.pathname;

    var x = urlPath.indexOf('admin');

    if(urlPath == '/'){
        urlPath = '/index.html';
    }else if (urlPath.indexOf('admin') > -1){
        urlPath = '/admin/master_home.html';
    }
    var activeLink = $('a[href = "' + urlPath + '" ]');
    activeLink.attr("href","javascript:void(0)");

    var activeTab = activeLink.parent()
    activeTab.addClass("active");
    //Add logout button if not in admin or user, those processes will already make that request.
    if(activeTab.attr('id') != 'nav_user' && activeTab.attr('id') != 'nav_admin'){
        $.ajax({
            url: '/api/login.php',
            type: "GET",
            success: function(data, xhr, status){
                put_name_in_nav_bar(data);
            }
        });
    }
});

function put_name_in_nav_bar(user){
    $('div.navbar-responsive-collapse').append(
                    '<button id = "logout" type="button" class="btn btn-default navbar-btn navbar-text navbar-right pull-right">Sign Out</button>'+
                    '<p class="navbar-text navbar-right pull-right">'+user.name+
                    '</p>');

                $('#logout').click(function(){
                    $.ajax({
                        url: "/api/login.php?signout=1",
                        type: "GET",
                        success: function (data, xhr, status) {
                            window.location.replace("/index.html");
                        }   
                    });
                });
}
