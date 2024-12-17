<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:url" content="<?php echo current_url(); ?>" />
	<meta property="og:title" content="<?php echo isset($id) ? $judul : lang('halaman_tidak_ditemukan'); ?>" />
	<meta property="og:description" content="<?php echo htmlspecialchars($deskripsi); ?>" />
	<meta property="og:type" content="product" />
	<meta property="og:image" content="<?php echo base_url(dir_upload('produk')).$produk[0]['foto_produk']; ?>" />
	<meta name="description" content="<?php echo htmlspecialchars($deskripsi); ?>">
	<meta name="author" content="<?php echo setting('title'); ?>">
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
	<title><?php echo $judul ? htmlspecialchars($judul) : "Form Pemesanan"; ?></title>
	<link href="<?php echo base_url(dir_upload('setting').setting('favicon')); ?>" rel="shortcut icon" />
	<?php 
	Asset::css('bootstrap.min.css', true);
	Asset::css('bootstrap.color.min.css', true);
	Asset::css('roboto.css', true);
	Asset::css('fontawesome.css', true);
	Asset::css('select2.min.css', true);
	Asset::css('style.css', true);
	Asset::css('small-style.css', true);
	echo Asset::render();
    ?>
    <style type="text/css">
        form #btn-submit {font-weight: bold; font-size: 110% !important; text-transform: uppercase; padding: .75rem 1rem;}
        .row-pesanan {margin-bottom: .5rem}
        .row-pesanan:after {display: block; clear: both; content: "";}
        .row-pesanan .left {float: left; width: 60%; margin-right: 2%;}
        .row-pesanan .right {float: right; width: 35%; text-align: right;}
        .video-container {position: relative; padding-bottom: 56.25%; margin-bottom: 1.5rem; height: 0;}
        .video-container iframe {position: absolute; top: 0; left: 0; width: 100%; height: 100%;}
        .radio-box-group {padding: .75rem .5rem !important; border: 1px solid #ccc; border-radius: .25rem; cursor: pointer;}
        .radio-box {padding: .75rem .5rem .75rem 2rem !important; border: 1px solid #ccc; border-radius: .25rem; cursor: pointer;}
        <?php if($is_progresive) { ?>
        .progresive {display: none;}
        <?php } ?>
    </style>
    <?php if($fb_pixel_checkout && $event_pixel_checkout) { ?>
    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');

        <?php foreach(explode('||',$fb_pixel_checkout) as $fp) {
        echo "fbq('init', '".$fp."');" . PHP_EOL;
        } ?>
                    
        if ( typeof(fbq) != 'undefined' ) {
            <?php 
                $harga = $produk[0]['harga_promo'] ? $produk[0]['harga_promo'] : $produk[0]['harga'];
                foreach(explode('||',$event_pixel_checkout) as $ep) { ?>
            
            fbq('track', '<?php echo $ep; ?>', {
                value: <?php echo $harga; ?>,
                currency: 'IDR',
                content_name: '<?php echo $produk[0]['nama_produk']; ?>',
                content_category: '<?php echo $brand; ?>',
            });

            <?php } ?>
        }
    </script>
    <!-- End Facebook Pixel Code -->
    <?php } ?>
</head>
<body class="bg-grey p-0">
	<div class="container">
        <div class="row justify-content-center">
			<div class="col col-md-10 col-lg-10 mt-4 mb-4">
				<div class="card mb-4">
					<div class="card-header p-4 bg-light-grey">
                        <div class="font-weight-bold text-center text-uppercase size-150"><?php echo $judul ? htmlspecialchars($judul) : "Form Pemesanan"; ?></div>
                        <?php if($keterangan) { ?>
                        <div class="mt-2 text-center text-grey"><?php echo htmlspecialchars($keterangan); ?></div>
                        <?php } ?>
                    </div>
                    <div class="card-body p-4">
                        <div class="row invisible">
                            <div class="col-lg-8" id="width-reference">
                                <form method="post" action="<?php echo base_url('checkout'); ?>" id="formCheckout">
                                    <input type="hidden" name="kode_unik" id="kode_unik" value="<?php echo $kode_unik; ?>" />
                                    <input type="hidden" name="ref" id="ref" value="<?php echo $ref; ?>" />
                                    <input type="hidden" name="price" id="price" value="" />
                                    <?php if(($link_video && strpos(parse_url($link_video)['host'],'youtube.com') !== false) || $deskripsi) { ?>
                                    <div id="atribut-section">
                                        <?php if($link_video && strpos(parse_url($link_video)['host'],'youtube.com') !== false) { ?>
                                        <div class="video-container">
                                            <iframe src="<?php echo $link_video; ?>" data-src="<?php echo $link_video; ?>" allow="autoplay; encrypted-media" allowfullscreen="" frameborder="0"></iframe>
                                        </div>
                                        <?php } if($deskripsi) { ?>
                                        <div class="text-center mb-4 size-150"><?php echo htmlspecialchars($deskripsi); ?></div>
                                        <?php } ?>
                                    </div>
                                    <?php } ?>

                                    <div class="text-legend">
                                        <span>Pilihan Produk :</span>
                                    </div>
                                    <div class="row mb-3" id="choose-produk">
                                        <?php foreach($produk as $k => $p) { ?>
                                        <div class="col-sm-6 mb-3">
                                            <div class="radio-box-group h-100">
                                                <div class="custom-control custom-<?php echo $multiple_produk ? 'checkbox' : 'radio'; ?>">
                                                    <input type="<?php echo $multiple_produk ? 'checkbox' : 'radio'; ?>" class="custom-control-input" id="produk<?php echo $p['id_produk']; ?>" name="id_produk[]" value="<?php echo $p['id_produk']; ?>" data-berat="<?php echo $p['berat_produk']; ?>" data-harga="<?php echo $p['harga_promo'] ? $p['harga_promo'] : $p['harga']; ?>" <?php if($k==0) echo 'checked'; ?>>
                                                    <label class="custom-control-label" for="produk<?php echo $p['id_produk']; ?>">
                                                        <div class="row">
                                                            <div class="col-3 pr-2">
                                                                <img src="<?php echo base_url(dir_upload('produk')).$p['foto_produk']; ?>" alt="" class="d-block w-100" />
                                                            </div>
                                                            <div class="col-9 pl-1">
                                                                <div class="font-weight-bold size-110 text-2line prod-name"><?php echo $p['nama_produk']; ?></div>
                                                                <?php if($p['harga_promo']) { ?>
                                                                <div class="size-75 text-grey"><s>Rp <?php echo custom_format($p['harga']); ?></s></div>
                                                                <?php } ?>
                                                                <div class="size-110 text-success">Rp <?php echo custom_format($p['harga_promo'] ? $p['harga_promo'] : $p['harga']); ?></div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                                <?php if($multiple_jumlah) { ?>
                                                <div class="float-right">
                                                    <div class="input-group mt-3">
                                                        <div class="input-group-prepend">
                                                            <button class="btn btn-default btn-icon-only min" type="button"><i class="fa-minus"></i></button>
                                                        </div>
                                                        <input type="text" class="form-control text-center jumlah" value="1" name="jumlah[]" autocomplete="off" style="max-width: 50px;">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-default btn-icon-only plus" type="button"><i class="fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                                <?php } else { ?>
                                                <input type="hidden" name="jumlah" class="jumlah" value="1" />
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>

                                    <div class="text-legend">
                                        <span>Data Penerima :</span>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-12 required" for="nama">Nama</label>
                                        <div class="col-12">
                                            <input type="text" name="nama" id="nama" class="form-control" autocomplete="off" data-validation="required" />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-form-label col-12 required" for="no_telp">No. Handphone / WhatsApp</label>
                                        <div class="col-12">
                                            <input type="text" name="no_telp" id="no_telp" class="form-control text-number" autocomplete="off" data-validation="required|number" />
                                        </div>
                                    </div>
                                    <div class="form-group row progresive">
                                        <label class="col-form-label col-12 required" for="id_provinsi">Provinsi</label>
                                        <div class="col-12">
                                            <select name="id_provinsi" id="id_provinsi" class="form-control select2" data-validation="required">
                                                <option value=""></option>
                                                <?php foreach($provinsi as $p) { ?>
                                                    <option value="<?php echo $p['id']; ?>"><?php echo $p['provinsi']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row progresive">
                                        <label class="col-form-label col-12 required" for="id_kota">Kota/Kabupaten</label>
                                        <div class="col-12">
                                            <select name="id_kota" id="id_kota" class="form-control select2" data-validation="required"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row progresive">
                                        <label class="col-form-label col-12 required" for="id_provinsi">Kecamatan</label>
                                        <div class="col-12">
                                            <select name="id_kecamatan" id="id_kecamatan" class="form-control select2" data-validation="required"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row progresive">
                                        <label class="col-form-label col-12 required" for="id_kelurahan">Kelurahan/Desa - Kode Pos</label>
                                        <div class="col-12">
                                            <select name="id_kelurahan" id="id_kelurahan" class="form-control select2" data-validation="required"></select>
                                        </div>
                                    </div>
                                    <div class="form-group row mb-4 progresive">
                                        <label class="col-form-label col-12 required" for="alamat">Alamat Lengkap (Nama Jalan, RT, RW)</label>
                                        <div class="col-12">
                                            <textarea name="alamat" id="alamat" class="form-control" rows="5" data-validation="required" placeholder="Contoh : Jl. KH Ahmad Sanusi, No.15, RT.01 RW.01" aria-label="Alamat Lengkap"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="radio-panel progresive">
                                        <div class="text-legend">
                                            <span>Metode Pembayaran :</span>
                                        </div>
                                        <div class="row mb-3" id="choose-pembayaran">
                                            <?php if($is_transfer) { ?>
                                            <div class="col-sm-6 mb-3">
                                                <div class="custom-control custom-radio radio-box h-100">
                                                    <input type="radio" class="custom-control-input" id="pembayaran_transfer" name="metode_pembayaran" value="transfer" <?php if(!$is_progresive) echo 'checked'; ?>>
                                                    <label class="custom-control-label" for="pembayaran_transfer">
                                                        <div class="row">
                                                            <div class="col-3 pr-2">
                                                                <img src="<?php echo base_url('assets/images/bank_transfer.png'); ?>" alt="" class="d-block w-100" />
                                                            </div>
                                                            <div class="col-9 pl-1">
                                                                <div class="font-weight-bold size-110 text-2line">Transfer Bank</div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php } if($is_cod) { ?>
                                            <div class="col-sm-6 mb-3">
                                                <div class="custom-control custom-radio radio-box h-100">
                                                    <input type="radio" class="custom-control-input" id="pembayaran_cod" name="metode_pembayaran" value="cod" <?php if(!$is_transfer && !$is_progresive) echo 'checked'; ?>>
                                                    <label class="custom-control-label" for="pembayaran_cod">
                                                        <div class="row">
                                                            <div class="col-3 pr-2">
                                                                <img src="<?php echo base_url('assets/images/cod.png'); ?>" alt="" class="d-block w-100" />
                                                            </div>
                                                            <div class="col-9 pl-1">
                                                                <div class="font-weight-bold size-110 text-2line">COD (Bayar Ditempat)</div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <?php if($is_transfer) { ?>
                                    <div class="radio-panel progresive">
                                        <div class="text-legend">
                                            <span>Tujuan Transfer :</span>
                                        </div>
                                        <div class="row mb-3" id="choose-transfer">
                                            <?php foreach($bank as $b) { ?>
                                            <div class="col-sm-6 mb-3">
                                                <div class="custom-control custom-radio radio-box h-100">
                                                    <input type="radio" class="custom-control-input" id="id_bank<?php echo $b['id']; ?>" name="id_bank" value="<?php echo $b['id']; ?>">
                                                    <label class="custom-control-label d-block" for="id_bank<?php echo $b['id']; ?>">
                                                        <div class="font-weight-bold size-110 text-2line"><?php echo $b['bank']; ?></div>
                                                        <div class="font-weight-bold text-2line"><?php echo $b['no_rekening']; ?></div>
                                                        <div class="text-2line"><?php echo $b['atas_nama']; ?></div>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php } ?>

                                    <div class="radio-panel progresive">
                                        <div class="text-legend">
                                            <span>Pengiriman :</span>
                                        </div>
                                        <div class="row mb-3" id="choose-ekspedisi">
                                            <?php foreach($ekspedisi as $k => $p) { ?>
                                            <div class="col-sm-6 mb-3 row-control">
                                                <div class="custom-control custom-radio radio-box h-100">
                                                    <input type="radio" class="custom-control-input" id="ekspedisi<?php echo $p['id']; ?>" data-kode="<?php echo $p['kode']; ?>" name="id_ekspedisi" value="<?php echo $p['id']; ?>" <?php if($k==0 && !$is_progresive) echo 'checked'; ?>>
                                                    <label class="custom-control-label" for="ekspedisi<?php echo $p['id']; ?>">
                                                        <div class="row">
                                                            <div class="col-3 pr-2">
                                                                <img src="<?php echo base_url(dir_upload('ekspedisi')).$p['logo']; ?>" alt="" class="d-block w-100" />
                                                            </div>
                                                            <div class="col-9 pl-1">
                                                                <div class="font-weight-bold size-110 text-2line"><?php echo $p['nama_ekspedisi']; ?></div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                            <?php } ?>
                                        </div>
                                        <div id="layanan"></div>
                                    </div>

                                    <div class="border rounded p-3 mb-3" id="rincian-pesanan">
                                        <div class="font-weight-bold mb-3 size-110">Rincian Pesanan :</div>
                                        <div id="list-pesanan">
                                        </div>
                                        <div class="row-pesanan d-none" id="row-ongkir">
                                            <div class="left"></div>
                                            <div class="right"></div>
                                        </div>
                                        <div class="row-pesanan d-none" id="row-cod">
                                            <div class="left"></div>
                                            <div class="right"></div>
                                        </div>
                                        <div class="row-pesanan d-none" id="row-asuransi">
                                            <div class="left"></div>
                                            <div class="right"></div>
                                        </div>
                                        <div class="row-pesanan d-none" id="row-unik">
                                            <div class="left"></div>
                                            <div class="right"></div>
                                        </div>
                                        <div class="row-pesanan font-weight-bold border-top pt-3 size-110" id="row-total">
                                            <div class="left">TOTAL</div>
                                            <div class="right"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-12">
                                            <button type="submit" id="btn-submit" class="btn btn-block btn-primary">PESAN SEKARANG</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
var base_url = "<?php echo base_url(); ?>";
var _c = <?php echo json_encode($cod); ?>;
</script>
<?php 
Asset::js('jquery.min.js', true);
Asset::js('popper.min.js', true);
Asset::js('bootstrap.min.js', true);
Asset::js('_id.js', true);
Asset::js('select2.min.js', true);
Asset::js('hashids.min.js', true);
Asset::js('sweetalert.min.js', true);
echo Asset::render();
?>
<script type="text/javascript" src="<?php echo base_url('assets/app/form_order.js'); ?>"></script>
<script type="text/javascript">
function customLayout(top) {
    if(typeof top == 'undefined') top = 0;
    if( $(window).width() > 991) {
        var w_ref1  = $('#width-reference').outerWidth();
        var w_ref2  = $('#width-reference').width();
        var p_ref   = (w_ref1 - w_ref2) / 2;
        var w_attr  = $('#width-reference').parent().outerWidth() - (w_ref1 + (p_ref * 2));
        if($('#atribut-section').length == 1) {
            $('#atribut-section').css({
                position: 'absolute',
                left: (w_ref1 + p_ref) + 'px',
                top: top + 'px',
                width : w_attr + 'px'
            });
        }
        var t_rincian = top;
        if($('#atribut-section').length == 1) {
            t_rincian = top + $('#atribut-section').outerHeight();
        }
        
        $('#rincian-pesanan').css({
            position: 'absolute',
            left: (w_ref1 + p_ref) + 'px',
            top: t_rincian + 'px',
            width : w_attr + 'px'
        });
    } else {
        $('#atribut-section, #rincian-pesanan').removeAttr('style');
    }
}
$(document).ready(function(){
    customLayout();
    $('.invisible').removeClass('invisible');
});
$(window).resize(function(){
    customLayout();
});
$(document).scroll(function(){
    var sTop = $(document).scrollTop();
    var offset = $('.card-body.p-4').offset().top;
    var top = 0;
    if(sTop > offset) {
        top = sTop - offset;
    }
    customLayout(top);
});
</script>
</body>
</html>