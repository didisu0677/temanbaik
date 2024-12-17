
var wi, timer;
$(document).on('click','.btn-edit',function(){
	$.ajax({
		url : base_url + 'desk_audit_process/post_border/get_data',
		data : {
			id : $(this).attr('data-id')
		},
		type : 'post',
		dataType : 'json',
		success : function(res) {
			$('#id').val(res.id);
			$('#detail').html(res.detail);
			$('#suket, #sertifikat').closest('.row').addClass('d-none');
			$('#suket, #sertifikat').val('');
			$('#suket, #sertifikat').removeAttr('data-validation');
			$('#label').val('').trigger('change');
			$('#modal-form').modal();
		}
	})
});
$('#label').change(function(){
	$('#suket, #sertifikat').closest('.row').addClass('d-none');
	$('#suket, #sertifikat').removeAttr('data-validation');
	if($(this).val() == 'SUKET') {
		$('#suket').closest('.row').removeClass('d-none');
		$('#suket').attr('data-validation','required');
	} else if($(this).val() == 'SERTIFIKAT') {
		$('#sertifikat').closest('.row').removeClass('d-none');
		$('#sertifikat').attr('data-validation','required');
	}
});
$(document).on('click','.browse-sertifikat',function(){
	if(!wi) {
		wi = popupWindow(base_url + 'desk_audit_process/post_border/browse/sertifikat', '_blank', window, 1000, 500);
		timer = setInterval(checkChild, 500);
	} else wi.focus();
});
$(document).on('click','.browse-suket',function(){
	if(!wi) {
		wi = popupWindow(base_url + 'desk_audit_process/post_border/browse/suket', '_blank', window, 1000, 500);
		timer = setInterval(checkChild, 500);
	} else wi.focus();
});
function popupWindow(url, title, win, w, h) {
    const y = win.top.outerHeight / 2 + win.top.screenY - ( h / 2);
    const x = win.top.outerWidth / 2 + win.top.screenX - ( w / 2);
    return win.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+y+', left='+x);
}
function checkChild() {
    if (wi.closed) {
        wi = null;
        clearInterval(timer);
    }
}
function setValue(tipe, data) {
	if(tipe == 'sertifikat') {
		$('#sertifikat').removeClass('is-invalid');
		$('#sertifikat').closest('.form-group').find('span.error').remove();
		$('#sertifikat').val(data).focus();
	} else {
		$('#suket').removeClass('is-invalid');
		$('#suket').closest('.form-group').find('span.error').remove();
		$('#suket').val(data).focus();
	}
	
	if (wi) {
		if(!wi.closed) {
			wi.close();
			wi = null;
			clearInterval(timer);
		}
	}
}
$(window).bind('beforeunload', function(e){
	if(typeof wi != 'undefined' && wi && !wi.closed) {
		wi.close();
		wi = null;
		clearInterval(timer);
	}
});
function counter() {
	$.get(base_url + 'desk_audit_process/post_border/get_counter',function(res){
		$('#counter').html(res);
	});
}
