$(function(){
	bdp();
});

function bdp(){
	$('input[data-provide=datepicker]').each(function(i,e){ 
		$(e).addClass('form-control');
		o=$(e).datetimepicker( $.extend( {}, eval('bsdtp_'+e.id+'_config') ) );
		picker_events=eval('bsdtp_'+e.id+'_on');
		for(j in picker_events) {
			eval('$(o).on("'+j+'", function(ev) { '+picker_events[j]+'(ev); })');
		}
	});
}