<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
		<div class="float-right">
			<?php echo access_button('delete'); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="content-body">
	<?php
	table_open('',true,base_url('settings/indikator_napier/data'),'tbl_m_indikator');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('judul'),'','data-content="judul"');
				th(lang('warna'),'','data-content="warna" data-badge data-filter="false" data-sort="false"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form','','','data-openCallback="openForm"');
	modal_body();
		form_open(base_url('settings/indikator_napier/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('judul'),'judul','required|unique');
			input('text',lang('warna'),'warna','required|unique');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/spectrum/spectrum.min.css" />
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/spectrum/spectrum.min.js"></script>
<script>
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
</script>