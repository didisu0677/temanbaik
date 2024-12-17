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
                        <div class="float-left text-uppercase pt-1 pl-1 font-weight-bold"><?php echo lang('catatan_khusus'); ?></div>
                        <div class="float-right">
                            <?php echo access_button(); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                    table_open('',false,base_url('monitoring/data_napier/data/catatan/'.$id),'tbl_napier_catatan');
                        thead();
                            tr();
                                th(lang('no'),'text-center','width="30" data-content="id"');
                                th(lang('catatan'),'','data-content="catatan"');
                                th(lang('klasifikasi'),'','data-content="klasifikasi"');
                                th(lang('kategori_kejadian'),'','data-content="kategori_kejadian"');
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
modal_open('modal-form');
    modal_body();
        form_open(base_url('monitoring/data_napier/save/catatan'),'post','form','data-edit="'.base_url('monitoring/data_napier/get_data/catatan').'" data-delete="'.base_url('monitoring/data_napier/delete/catatan').'"');
            col_init(3,9);
            input('hidden','id','id');
            input('hidden','id_napier','id_napier','',$id);
            textarea(lang('catatan'),'catatan','required');
            select2(lang('klasifikasi'),'klasifikasi','required|infinity',['Info','Urgent','Emergency']);
            select2(lang('kategori_kejadian'),'kategori_kejadian','required|infinity',['Ringan','Sedang','Berat']);
            form_button(lang('simpan'),lang('batal'));
        form_close();
    modal_footer();
modal_close();
?>