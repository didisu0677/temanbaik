
$(document).on('click','.view-detail',function(){
	$.get(base_url + 'master_data/insw/detail?c=' + $(this).attr('data-value'),function(r){
		cInfo.open(lang.detil,r);
	});
});
