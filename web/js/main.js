
function readURL(input,id) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function (e) {
			$('#'+id+'')
			.attr('src', e.target.result);                
		};
		reader.readAsDataURL(input.files[0]);
	}
}

$(document).ready(function() {
	/*$.get("https://api.ipdata.co?api-key=test", function (response) {
		console.log(JSON.stringify(response, null, 2));
	}, "jsonp");*/

	$('#modalTrailerPhim').on('shown.bs.modal', function(){     
		var urlTrailer = $(this).find('iframe').attr('src');
		var playVideo = urlTrailer.concat("?autoplay=1;rel=0&amp;showinfo=1");
		$('iframe').attr('src',playVideo);
	});

	$('#modalTrailerPhim').on('hidden.bs.modal', function(){ 
		var urlTrailer = $(this).find('iframe').attr('src');
		var playVideo = urlTrailer.replace("?autoplay=1;rel=0&amp;showinfo=1","");
		$('iframe').attr('src', playVideo);
	});

});