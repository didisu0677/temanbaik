
function _save() {
    if($('#id').val() == '0' || $('#id').val() == '' && saved_id != 0) {
        window.location = base_url + 'monitoring/data_napier/form/profil?i=' + encodeId(saved_id);
    }
}
$('#id_rutan').change(function(){
    var opt = '<option value=""></option>';
    if($(this).val() != '') {
        $.get(base_url + 'monitoring/data_napier/get_ruangan/' + $(this).val(), function(r){
            opt = r
            $('#id_ruangan').html(opt).trigger('change');
        });
    } else {
        $('#id_ruangan').html(opt).trigger('change');
    }
});
