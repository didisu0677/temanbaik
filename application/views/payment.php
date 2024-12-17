<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo isset($id) ? $nomor : lang('halaman_tidak_ditemukan'); ?></title>
	<link href="<?php echo base_url(dir_upload('setting').setting('favicon')); ?>" rel="shortcut icon" />
	<?php 
	Asset::css('bootstrap.min.css', true);
	Asset::css('bootstrap.color.min.css', true);
	Asset::css('roboto.css', true);
	Asset::css('fontawesome.css', true);
	Asset::css('style.css', true);
	Asset::css('small-style.css', true);
	echo Asset::render();
    ?>
    <?php if(isset($form['id']) && $form['fb_pixel_success'] && $form['event_pixel_success']) { ?>
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

        <?php foreach(explode('||',$form['fb_pixel_success']) as $fp) {
            echo "fbq('init', '".$fp."');" . PHP_EOL;
        } ?>
                    
        if ( typeof(fbq) != 'undefined' ) {
            <?php foreach(explode('||',$form['event_pixel_success']) as $ep) { ?>
            
            fbq('track', '<?php echo $ep; ?>', {
                value: <?php echo $total; ?>,
                currency: 'IDR',
                content_name: '<?php echo $produk; ?>',
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
			<div class="col col-md-8 col-lg-6 mt-4 mb-4">
				<div class="card mb-4">
					<div class="card-header p-4 bg-light-grey">#<?php echo $nomor; ?></div>
                    <div class="card-body p-4">
                        <?php if($redirect) { ?>
                        <p class="text-center size-2x mb-3">Mengalihkan</p>
                        <div class="lds-ellipsis mb-2"><div></div><div></div><div></div><div></div></div>
                        <?php } else { ?>
                        <p class="size-110">Hai, <strong><?php echo $nama; ?></strong></p>
                        <?php if($metode_pembayaran == 'cod') { ?>
                        <p>Pesanan anda sudah dibuat. Tim kami akan segera memproses pesanan anda.</p>
                        <?php } else { ?>
                        <p>Pesanan anda sudah dibuat. Agar pesanan segera di proses, silahkan lakukan pembayaran sebesar</p>
                        <p class="size-2x font-weight-bold text-center">Rp <?php echo custom_format($total); ?></p>
                        <p>ke nomor rekening dibawah ini :</p>
                        <?php foreach($bank as $b) { ?>
                        <div class="border rounded p-3 mb-3">
                            <div class="mb-1"><?php echo $b['bank']; ?></div>
                            <div class="mb-1 font-weight-bold"><?php echo $b['no_rekening']; ?></div>
                            <div class="mb-0">an. <?php echo $b['atas_nama']; ?></div>
                        </div>
                        <?php } ?>
                        <?php } if($no_cs) { ?>
                        <p>Untuk informasi terkait pemesanan ini silahkan hubungi Tim CS kami.</p>
                        <div class="text-center">
                            <a href="javascript:;" class="btn btn-lg btn-success" id="send-message"><i class="fa-whatsapp"></i> WhatsApp</a>
                        </div>
                        <?php }} ?>
                    </div>
                </div>
            </div>
        </div>
	</div>
<?php 
Asset::js('jquery.min.js', true);
Asset::js('popper.min.js', true);
Asset::js('bootstrap.min.js', true);
echo Asset::render();
?>
<script type="text/javascript">
<?php if($redirect) { ?>
$(window).on('load',function() {window.location = "<?php echo $redirect; ?>"})
<?php } elseif($no_cs) { ?>
$('#send-message').click(function(){ window.location = "<?php echo $no_cs; ?>"});
<?php } ?>
</script>
</body>
</html>