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
                        <div class="float-left text-uppercase pt-1 pl-1 font-weight-bold"><?php echo lang('data_keluarga'); ?></div>
                        <div class="float-right">
                            <?php echo access_button('delete'); ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                    table_open('',false,base_url('monitoring/data_napier/data/keluarga/'.$id),'tbl_napier_keluarga');
                        thead();
                            tr();
                                th('checkbox','text-center','width="30" data-content="id"');
                                th(lang('nama'),'','data-content="nama"');
                                th(lang('hubungan'),'','data-content="hubungan"');
                                th(lang('alamat'),'','data-content="alamat"');
                                th(lang('no_hp'),'','data-content="no_hp"');
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
        form_open(base_url('monitoring/data_napier/save/keluarga'),'post','form','data-edit="'.base_url('monitoring/data_napier/get_data/keluarga').'" data-delete="'.base_url('monitoring/data_napier/delete/keluarga').'"');
            col_init(3,9);
            input('hidden','id','id');
            input('hidden','id_napier','id_napier','',$id);
            input('text',lang('nama'),'nama','required');
            input('text',lang('hubungan'),'hubungan','required');
            textarea(lang('alamat'),'alamat');
            input('text',lang('no_hp'),'no_hp','phone');
            form_button(lang('simpan'),lang('batal'));
        form_close();
    modal_footer();
modal_close();
?>