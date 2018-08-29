
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
});