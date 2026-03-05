$(document).ready(function () {
	
	var url = window.location.href;
	var path = '/cv/assets/json/projects.json';
	if(url.indexOf('.com.br') !== -1) {
		path = '/cv/assets/json/projects.json';
	}
    $.getJSON(path, function (data) {
		 
        var html = '<div class="card-columns">';	

        var count = 0;
        $.each(data, function (key, val) {
            html += '<div class="card bg-secondary text-white">';
            html += '<img class="card-img-top" src="'+val.imagem+'">';
            html += '<div class="card-body">'
            html += '<h5 class="card-title text-white mb-0">'+val.projeto+'</h5>';
            html += '<p class="card-text">'+val.tecnologias+'</p>';

            //links
            $.each(val.links, function (keyLink, link) {
                html += '<a href="'+link+'" target="_blank" class="card-link text-dark  mb-0">';
                html += '<i class="fas fa-external-link-alt fa-2x"></i>';
                html += '</a>';
            });

            html += '</div></div>';

            count++;
            console.log(count +"-"+count % 3);
            if(count % 3 == 0) {
                html += '</div><div class="card-columns">';
            }

        });	
        html += '</div>';
        $("#load-projects").html(html);	
	});
});