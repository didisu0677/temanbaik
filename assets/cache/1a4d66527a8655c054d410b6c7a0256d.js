
function formOpen() {
	var r = response_edit;
	if(typeof r.id != 'undefined') {
		$.each(r.toleransi,function(k,v){
			$('[name="toleransi['+k+']"').val(v);
		});
	}
}
