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
	table_open('',true,base_url('settings/klasifikasi_napier/data'),'tbl_m_klasifikasi');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('klasifikasi'),'','data-content="klasifikasi"');
				th(lang('indikator'),'','data-content="judul" data-table="tbl_m_indikator indikator"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form');
	modal_body();
		form_open(base_url('settings/klasifikasi_napier/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('klasifikasi'),'klasifikasi','required');
			select2(lang('indikator'),'id_indikator','required',$opt_id_indikator,'id','judul');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
?>
