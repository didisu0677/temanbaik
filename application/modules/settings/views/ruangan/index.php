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
	table_open('',true,base_url('settings/ruangan/data'),'tbl_m_ruangan');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('rutan'),'','data-content="nama" data-table="tbl_m_rutan rutan"');
				th(lang('blok'),'','data-content="blok"');
				th(lang('kamar'),'','data-content="kamar"');
				th(lang('kapasitas'),'','data-content="kapasitas" data-suffix="Napier"');
				th(lang('aktif').'?','text-center','data-content="is_active" data-type="boolean"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form','','','data-openCallback="formOpen"');
	modal_body();
		form_open(base_url('settings/ruangan/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			select2(lang('rutan'),'id_rutan','required|unique_group',$opt_id_rutan,'id','nama');
			input('text',lang('blok'),'blok','required|unique_group');
			input('text',lang('kamar'),'kamar','required|unique_group');
			input('text',lang('kapasitas'),'kapasitas','required|number','','data-append="Napier"');
			label(lang('toleransi'));
			sub_open(1);
			foreach($indikator as $i) {
				input('percent',$i['judul'],'toleransi['.$i['id'].']');
			}
			sub_close();
			toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
?>
<script>
function formOpen() {
	var r = response_edit;
	if(typeof r.id != 'undefined') {
		$.each(r.toleransi,function(k,v){
			$('[name="toleransi['+k+']"').val(v);
		});
	}
}
</script>