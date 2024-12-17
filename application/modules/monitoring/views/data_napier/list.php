<div class="show-panel sticky-top">
	<div class="card">
		<div class="card-header">
			<?php echo lang('data_napier'); ?>
		</div>
		<div class="card-body dropdown-menu">
			<a class="dropdown-item<?php if($page == 'profil') echo ' active'; ?>" href="<?php echo base_url('monitoring/data_napier/form/profil').'?i='.$encode_id; ?>"><i class="fa-user-edit"></i><?php echo lang('data_pribadi');?></a>
			<a class="dropdown-item<?php if($page == 'keluarga') echo ' active'; ?>" href="<?php echo base_url('monitoring/data_napier/form/keluarga').'?i='.$encode_id; ?>"><i class="fa-users"></i><?php echo lang('data_keluarga');?></a>
			<a class="dropdown-item<?php if($page == 'penempatan') echo ' active'; ?>" href="<?php echo base_url('monitoring/data_napier/form/penempatan').'?i='.$encode_id; ?>"><i class="fa-landmark"></i><?php echo lang('riwayat_penempatan');?></a>
			<a class="dropdown-item<?php if($page == 'kegiatan') echo ' active'; ?>" href="<?php echo base_url('monitoring/data_napier/form/kegiatan').'?i='.$encode_id; ?>"><i class="fa-users-class"></i><?php echo lang('kegiatan');?></a>
			<a class="dropdown-item<?php if($page == 'kunjungan_keluarga') echo ' active'; ?>" href="<?php echo base_url('monitoring/data_napier/form/kunjungan_keluarga').'?i='.$encode_id; ?>"><i class="fa-user-friends"></i><?php echo lang('kunjungan_keluarga');?></a>
			<a class="dropdown-item<?php if($page == 'kunjungan_petugas') echo ' active'; ?>" href="<?php echo base_url('monitoring/data_napier/form/kunjungan_petugas').'?i='.$encode_id; ?>"><i class="fa-user-secret"></i><?php echo lang('kunjungan_petugas');?></a>
			<a class="dropdown-item<?php if($page == 'kesehatan') echo ' active'; ?>" href="<?php echo base_url('monitoring/data_napier/form/kesehatan').'?i='.$encode_id; ?>"><i class="fa-notes-medical"></i><?php echo lang('catatan_kesehatan');?></a>
			<a class="dropdown-item<?php if($page == 'catatan') echo ' active'; ?>" href="<?php echo base_url('monitoring/data_napier/form/catatan').'?i='.$encode_id; ?>"><i class="fa-clipboard"></i><?php echo lang('catatan_khusus');?></a>
		</div>
	</div>
</div>