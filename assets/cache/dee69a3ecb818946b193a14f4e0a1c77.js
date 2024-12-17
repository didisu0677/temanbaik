
	$('.btn-act-setting').click(function(){
		$('#modal-setting').modal();
	});
	$('#form-setting').submit(function(e){
		e.preventDefault();
		if(validation($(this).attr('id'))) {
			$.ajax({
				url : $(this).attr('action'),
				data : $(this).serialize(),
				type : 'post',
				dataType : 'json',
				success : function(response) {
					cAlert.open(response.message,response.status);
					if(response.status == 'success') {
						$('#modal-setting').modal('hide');
					}
				}
			});
		}
	});
