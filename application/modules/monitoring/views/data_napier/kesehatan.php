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
                        <div class="float-left text-uppercase pt-1 pl-1 font-weight-bold"><?php echo lang('catatan_kesehatan'); ?></div>
                        <div class="float-right">
                            <?php echo access_button(); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                    table_open('',false,base_url('monitoring/data_napier/data/kesehatan/'.$id),'tbl_napier_kesehatan');
                        thead();
                            tr();
                                th(lang('no'),'text-center','width="30" data-content="id"');
                                th(lang('tanggal'),'','data-content="tanggal" data-type="daterange"');
                                th(lang('sakit'),'','data-content="sakit"');
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
        form_open(base_url('monitoring/data_napier/save/kesehatan'),'post','form','data-edit="'.base_url('monitoring/data_napier/get_data/kesehatan').'" data-delete="'.base_url('monitoring/data_napier/delete/kesehatan').'"');
            col_init(3,9);
            input('hidden','id','id');
            input('hidden','id_napier','id_napier','',$id);
            input('date',lang('tanggal'),'tanggal','required');
            input('text',lang('sakit'),'sakit','required');
            form_button(lang('simpan'),lang('batal'));
        form_close();
    modal_footer();
modal_close();
?>