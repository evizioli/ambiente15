function readURL(input) {
	if (input.files && input.files[0] && input.files[0].type.match('image.*')) {
		var reader = new FileReader();

		reader.onload = function(e) {
			$('#'+input.id+'_foto').attr('src', e.target.result);
			$('#'+input.id+'_foto').attr('title', input.files[0].name);
		};

		reader.readAsDataURL(input.files[0]);
	}
}
