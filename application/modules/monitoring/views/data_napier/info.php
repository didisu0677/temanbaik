<div class="card mb-3">
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
                            <th><?php echo lang('jenis_kelamin'); ?></th>
                            <td><?php echo $jenis_kelamin; ?></td>
                        </tr>
                        <tr>
                            <th><?php echo lang('nik'); ?></th>
                            <td><?php echo $nik; ?></td>
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