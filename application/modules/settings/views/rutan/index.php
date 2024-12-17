<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
		<div class="float-right">
			<?php echo access_button('delete,active,inactive,export,import'); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="content-body">
	<?php
	table_open('',true,base_url('settings/rutan/data'),'tbl_m_rutan');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th(lang('kode'),'','data-content="kode" width="100"');
				th(lang('nama_rutan'),'','data-content="nama" width="200"');
				th(lang('alamat'),'','data-content="alamat"');
				th(lang('aktif').'?','text-center','data-content="is_active" data-type="boolean"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>
<?php 
modal_open('modal-form');
	modal_body();
		form_open(base_url('settings/rutan/save'),'post','form');
			col_init(3,9);
			input('hidden','id','id');
			input('text',lang('kode'),'kode','required|unique');
			input('text',lang('nama_rutan'),'nama','required');
			textarea(lang('alamat'),'alamat');
			toggle(lang('aktif').'?','is_active');
			form_button(lang('simpan'),lang('batal'));
		form_close();
	modal_footer();
modal_close();
modal_open('modal-import',lang('impor'));
	modal_body();
		form_open(base_url('settings/rutan/import'),'post','form-import');
			col_init(3,9);
			fileupload('File Excel','fileimport','required','data-accept="xls|xlsx"');
			form_button(lang('impor'),lang('batal'));
		form_close();
modal_close();
?>
