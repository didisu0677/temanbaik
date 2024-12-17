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
                <?php echo include_view('monitoring/data_napier/info'); ?> 
                <div class="table-responsive">
                    <div class="panel-table-non-fixed">
                        <div class="float-left text-uppercase pt-1 pl-1 font-weight-bold"><?php echo lang('kunjungan_petugas'); ?></div>
                        <div class="float-right">
                            <?php echo access_button(); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                    table_open('',false,base_url('monitoring/data_napier/data/kunjungan_petugas/'.$id),'tbl_napier_kunjungan');
                        thead();
                            tr();
                                th(lang('no'),'text-center','width="30" data-content="id"');
                                th(lang('tanggal'),'','data-content="tanggal" data-type="daterange"');
                                th(lang('kegiatan_kunjungan'),'','data-content="kegiatan_kunjungan"');
                                th(lang('nama_pengunjung'),'','data-content="pengunjung" data-type="list" data-delimiter=","');
                                th('&nbsp;','','width="30" data-content="action_button"');
                    table_close();
                    ?>
                </div>
            </div>
            <div class="col-md-3 mt-3 mt-md-0">
				<?php echo include_view('monitoring/data_napier/list'); ?> 
			</div>
        </div>
    </div>
</div>
<?php
modal_open('modal-form','','modal-lg');
    modal_body();
        form_open(base_url('monitoring/data_napier/save/kunjungan_petugas'),'post','form','data-edit="'.base_url('monitoring/data_napier/get_data/kunjungan_petugas').'" data-delete="'.base_url('monitoring/data_napier/delete/kunjungan_petugas').'"');
            col_init(3,9);
            input('hidden','id','id');
            input('hidden','id_napier','id_napier','',$id);
            input('datetime',lang('tanggal'),'tanggal','required');
            input('text',lang('kegiatan_kunjungan'),'kegiatan_kunjungan','required');
            input('tags',lang('nama_pengunjung'),'pengunjung','required');
            form_button(lang('simpan'),lang('batal'));
        form_close();
    modal_footer();
modal_close();
?>