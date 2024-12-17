
function openForm() {
	var r = response_edit;
	if(typeof r.id != 'undefined') {
		$('#warna').spectrum("set", $('#warna').val());
		$.each(r.detail,function(k,v){
			$('[name="nilai['+v.id_parameter+']"]').val(customFormat(v.nilai,2));
		});
	} else {
		$('#warna').spectrum("set", '');
	}
}
$('#warna').spectrum({
	type: "component",
	hideAfterPaletteSelect: "true",
	showInput: "true",
	showInitial: "true",
	showButtons: "false",
	appendTo: "#modal-form"
});
