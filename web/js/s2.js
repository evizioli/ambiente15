$(document).ready(function(){
	s2();
});

function s2() {
	$('.s2').select2({ theme: "bootstrap" });
}
$(document).on('focus', '.select2.select2-container', function (e) {

	  var isOriginalEvent = e.originalEvent // don't re-open on closing focus event
	  var isSingleSelect = $(this).find(".select2-selection--single").length > 0

	  if (isOriginalEvent && isSingleSelect) {
	    $(this).siblings('select:enabled').select2('open');
	  } 

	});