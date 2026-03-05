$(document).ready(function () {
	
	var url = window.location.href;
	var path = '/cv/assets/json/projects.json';
	if(url.indexOf('.com.br') !== -1) {
		path = '/cv/assets/json/projects.json';
	}
    $.getJSON(path, function (data) {
		 
        var html = '<ul class="list-group list-group-flush">';	

        var count = 0;
        $.each(data, function (key, val) {
            html += '<li class="list-group-item list-group-item-dark m-2">';
            html += '<img class="rounded float-left mr-3" src="'+val.imagem+'" width="314">';
            html += '<h3 class="card-title text-white mb-0">'+val.projeto+'</h3><hr/>';
            html += '<p class="card-text">'+val.description+'</p>';
            html += '<p class="card-text">'+val.tecnologias+'</p>';

            //links
            $.each(val.links, function (keyLink, link) {
                html += '<a href="'+link+'" target="_blank" class="card-link text-dark  mb-0">';
                html += '<i class="fas fa-external-link-alt fa-2x"></i>';
                html += '</a>';
            });

            html += '</li>';

        });	
        html += '</ul>';
        $("#load-projects").html(html);	
	});
});
