$(document).ready(function () {
	
	var url = window.location.href;
	var path = '/cv/assets/json/education.json';
	if(url.indexOf('.com.br') !== -1) {
		path = '/cv/assets/json/education.json';
	}
    $.getJSON(path, function (data) {
        var html = '';	
        $.each(data, function (key, val) {
            html += '<div class="d-flex flex-column flex-md-row justify-content-between mb-5">';
            html += '  <div class="flex-grow-1">';
			html += '    <h3 class="mb-0"><a href="'+val.link_curso+'" target="_blank">'+val.curso+'</a></h3>'
            html += '    <div class="subheading mb-0">';
            html += '      <a href="'+val.link+'" target="_blank">'+val.instituicao+'</a></div>';
            html += '    <div class="subheading mb-0">';
            html += '      <a href="'+val.page+'" target="_blank"><i class="fas fa-external-link-alt fa-2x"></i></a></div>';
            html += '  </div>';
            html += '  <div class="flex-shrink-0"><span class="text-primary">'+val.periodo+'</span></div>';
            html += '</div>';
		});		
		$("#load-education").html(html);	
    });
	
});