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
                <?php 
                form_open(base_url('monitoring/data_napier/save'),'post','form','data-submit="ajax" data-callback="_save"');
                col_init(3,9);
                ?>
                <div class="card mb-3">
                    <div class="card-header"><?php echo lang('data_pribadi'); ?></div>
                    <div class="card-body">
                        <?php 
                        input('hidden','id','id','',$id);
                        input('text',lang('nama_lengkap'),'nama','required',$nama);
                        input('tags',lang('nama_alias'),'alias','',$alias);
                        input('text',lang('tempat_lahir'),'tempat_lahir','required',$tempat_lahir);
                        input('date',lang('tanggal_lahir'),'tanggal_lahir','required',c_date($tanggal_lahir));
                        select2(lang('jenis_kelamin'),'jenis_kelamin','required|infinity',['Laki-Laki','Perempuan'],'','',$jenis_kelamin);
                        input('text',lang('nik'),'nik','required',$nik);
                        textarea(lang('alamat_ktp'),'alamat_ktp','required',$alamat_ktp);
                        textarea(lang('alamat_domisili'),'alamat_domisili','required',$alamat_domisili);
                        ?>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3"><?php echo lang('foto'); ?></label>
                            <div class="col-md-9">
                                <div class="row">
                                    <?php for($i=1;$i<=3;$i++) { ?>
                                    <div class="col-6 col-sm-4 mb-2">
                                        <div class="image-upload">
                                            <div class="image-content">
                                                <img src="<?php echo base_url(dir_upload('napier')); echo $foto[$i] ?: 'default.png'; ?>" alt="Logo Perusahaan" data-action="<?php echo base_url('upload/image/500/500'); ?>">
                                                <input type="hidden" name="foto<?php echo $i; ?>" data-validation="image">
                                            </div>
                                            <div class="image-description"><?php echo lang('rekomendasi_ukuran');?> 500 x 500 (px)</div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header"><?php echo lang('riwayat_penangkapan'); ?></div>
                    <div class="card-body">
                        <?php
                        input('date',lang('tanggal_penangkapan'),'tanggal_penangkapan','required',c_date($tanggal_penangkapan));
                        textarea(lang('detail_kasus'),'detail_kasus','required',$detail_kasus);
                        select2(lang('klasifikasi'),'id_klasifikasi','required',$opt_klasifikasi,'id','klasifikasi',$id_klasifikasi);
                        input('tags',lang('jaringan'),'jaringan','',$jaringan);
                        input('text',lang('spk'),'spk','',$spk);
                        input('tags',lang('rekam_jejak'),'rekam_jejak',$rekam_jejak);
                        ?>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header"><?php echo lang('penempatan_dan_vonis'); ?></div>
                    <div class="card-body">
                        <?php
                        input('date',lang('tanggal_vonis'),'tanggal_vonis','',c_date($tanggal_vonis));
                        ?>
                        <div class="form-group row">
                            <label class="col-form-label col-md-3" for="vonis_tahun"><?php echo lang('vonis'); ?></label>
                            <div class="col-md-4 col-6">
                                <input type="text" name="vonis_tahun" id="vonis_tahun" autocomplete="off" class="form-control" data-validation="number" value="<?php echo $vonis_tahun; ?>" data-suffix="Tahun">
                            </div>
                            <div class="col-md-5 col-6">
                                <input type="text" name="vonis_bulan" id="vonis_bulan" autocomplete="off" class="form-control" data-validation="number" value="<?php echo $vonis_bulan; ?>" data-suffix="Tahun">
                            </div>
                        </div>
                        <?php
                        input('text',lang('subsidair'),'subsidair','number',$subsidair,'data-suffix="'.lang('bulan').'"');
                        input('money',lang('denda'),'denda','',$denda,'data-prefix="Rp"');
                        label('');
                        input('text',lang('no_berkas_kejaksaan'),'no_berkas_kejaksaan','',$no_berkas_kejaksaan);
                        input('text',lang('no_registrasi'),'no_registrasi','',$no_registrasi);
                        input('text',lang('kondisi_kesehatan'),'kondisi_kesehatan','',$kondisi_kesehatan);
                        label(lang('penempatan'));
                        sub_open(1);
                            input('date',lang('tanggal_penempatan'),'tanggal_penempatan','required',c_date($tanggal_penempatan));
                            select2(lang('rutan'),'id_rutan','required',$rutan,'id','nama',$id_rutan);
                            select2(lang('blok').' - '.lang('kamar'), 'id_ruangan', 'required', $ruangan, 'id', 'blok - kamar', $id_ruangan);
                        sub_close();
                        form_button(lang('simpan'),lang('batal'));
                        ?>
                    </div>
                </div>
                <?php 
                    form_close();                        
                ?>
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
$('#id_rutan').change(function(){
    var opt = '<option value=""></option>';
    if($(this).val() != '') {
        $.get(base_url + 'monitoring/data_napier/get_ruangan/' + $(this).val(), function(r){
            opt = r
            $('#id_ruangan').html(opt).trigger('change');
        });
    } else {
        $('#id_ruangan').html(opt).trigger('change');
    }
});
</script>