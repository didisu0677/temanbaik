<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb($title); ?>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="content-body">
    <div class="main-container">
		<div class="row">
			<div class="col-md-9">
                <div class="card">
                    <div class="card-header"><?php echo lang('data_pribadi'); ?></div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3 col-lg-2">
                                <img src="<?php echo base_url(dir_upload('napier')); echo $foto1 ?: 'default.png'; ?>" alt="" class="img-thumbnail" />
                            </div>
                            <div class="col-sm-9 col-lg-10">
                                <div class="table-responsive">
                                    <table class="table table-app table-detail table-normal table-bordered">
                                        <tr>
                                            <th width="150"><?php echo lang('nama_lengkap'); ?></th>
                                            <td><?php echo $nama; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo lang('nama_alias'); ?></th>
                                            <td><?php echo str_replace(',',' / ',$alias); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo lang('tempat_lahir'); ?></th>
                                            <td><?php echo $tempat_lahir; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo lang('tanggal_lahir'); ?></th>
                                            <td><?php echo c_date($tanggal_lahir); ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo lang('jenis_kelamin'); ?></th>
                                            <td><?php echo $jenis_kelamin; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo lang('nik'); ?></th>
                                            <td><?php echo $nik; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo lang('alamat_ktp'); ?></th>
                                            <td><?php echo $alamat_ktp; ?></td>
                                        </tr>
                                        <tr>
                                            <th><?php echo lang('alamat_domisili'); ?></th>
                                            <td><?php echo $alamat_domisili; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if($id) { ?>
            <div class="col-md-3 mt-3 mt-md-0">
				<?php echo include_view('monitoring/data_napier/list'); ?> 
			</div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    function _save() {
        if($('#id').val() == '0' || $('#id').val() == '' && saved_id != 0) {
            window.location = base_url + 'monitoring/data_napier/form/profil?i=' + encodeId(saved_id);
        }
    }
</script>