$(document).ready(function () {
	
	var url = window.location.href;
	var path = '/cv/assets/json/experience.json';
	if(url.indexOf('.com.br') !== -1) {
		path = '/cv/assets/json/experience.json';
	}
    $.getJSON(path, function (data) {
		 
        var html = '';	

        $.each(data, function (key, val) {
            html += '<div class="d-flex flex-column flex-md-row justify-content-between mb-5">';
            html += '<div class="flex-grow-1">';


			html += '<h3 class="mb-0">'+val.titulo+'</h3>'
            html += '<div class="subheading mb-3">';
            html += '<a href="'+val.link+'" target="_blank">';
            html += val.empresa;
            html += '</a>';
            html += '</div>';
            html += '<p class="mb-0">'+val.funcao+'</p>';
            html += '<p>'+val.observacoes+'</p>';            
            html += '</div>';
            html += '<div class="flex-shrink-0"><span class="text-primary">'+val.periodo+'</span></div>';
			html += '</div>';
		});	
				
		$("#load-experience").html(html);	

	});
	
});