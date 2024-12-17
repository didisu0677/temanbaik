
    function _save() {
        if($('#id').val() == '0' || $('#id').val() == '' && saved_id != 0) {
            window.location = base_url + 'monitoring/data_napier/form/profil?i=' + encodeId(saved_id);
        }
    }
