
$(document).ready(function(){
	$('input[type="color"]').attr('type','text').addClass('color-picker');
	setTimeout(function(){
		$('.color-picker').spectrum({
			type: "component",
			hideAfterPaletteSelect: "true",
			showInput: "true",
			showInitial: "true",
			showButtons: "false"
		});
	},500);
});
