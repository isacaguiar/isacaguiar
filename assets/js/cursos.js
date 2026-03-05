$(document).ready(function () {
	
	
    var url = window.location.href;
	var path = '/cv/assets/json/education-complementary.json';
	if(url.indexOf('.com.br') !== -1) {
		path = '/cv/assets/json/education-complementary.json';
	}
    $.getJSON(path, function (data) {
        var html = '<ul class="fa-ul mb-0">';	
        $.each(data, function (key, val) {
            html += '<li class="mb-2">';
            html += '  <span class="fa-li mb-0"><i class="fas '+val.icone+' text-warning"></i></span>';
			html += '    <h4 class="mb-0">'+val.curso+'</h4>'
            html += '    <div>';
            html += '      <a href="'+val.link+'" target="_blank">'+val.instituicao+'</a> - '+val.ano+'</div>';
            html += '  </div>';
            html += '</li>';
        });		
        html += '</ul>';
        $("#load-education-complementary").html(html);	
        console.log(html)
    });

	
});