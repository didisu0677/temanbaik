<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
		<div class="float-right">
			<?php echo access_button('delete',base_url('monitoring/data_napier/form/profil')); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="content-body">
	<?php
	table_open('',true,base_url('monitoring/data_napier/data'),'tbl_napier');
		thead();
			tr();
				th('checkbox','text-center','width="30" data-content="id"');
				th('&nbsp;','','data-content="foto1" data-type="image" width="100"');
				th(lang('nama_lengkap'),'','data-content="nama"');
				th(lang('nama_alias'),'','data-content="alias" data-type="list" data-delimiter=","');
				th(lang('tempat_lahir'),'','data-content="tempat_lahir"');
				th(lang('tanggal_lahir'),'','data-content="tanggal_lahir" data-type="daterange"');
				th(lang('nik'),'','data-content="nik"');
				th(lang('alamat_ktp'),'','data-content="alamat_ktp"');
				th('&nbsp;','','width="30" data-content="action_button"');
	table_close();
	?>
</div>