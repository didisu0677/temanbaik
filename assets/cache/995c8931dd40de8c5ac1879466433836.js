
function counter() {
	$.get(base_url + 'hasil/postborder/get_counter',function(res){
		$('#counter').html(res);
	});
}
