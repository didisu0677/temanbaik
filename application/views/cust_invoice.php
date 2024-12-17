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
</head>
<body class="bg-grey p-0">
	<div class="container">
        <div class="row justify-content-center">
			<div class="col col-md-10 col-lg-8 mt-4 mb-4">
				<div class="card mb-4">
					<div class="card-header p-4 bg-light-grey">FAKTUR</div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <table width="100%">
                                <tr>
                                    <th width="100">Nomor</th>
                                    <th width="20">:</th>
                                    <td><?php echo $nomor; ?></td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>:</th>
                                    <td><?php echo date_indo($create_at, false); ?></td>
                                </tr>
                                <tr><td colspan="3">&nbsp;</td></tr>
                                <tr>
                                    <th>Nama</th>
                                    <th>:</th>
                                    <td><?php echo $nama_pembeli; ?></td>
                                </tr>
                                <tr>
                                    <th>No. Telp / HP</th>
                                    <th>:</th>
                                    <td><?php echo $no_telp; ?></td>
                                </tr>
                                <tr>
                                    <th>Alamat</th>
                                    <th>:</th>
                                    <td><?php echo $alamat_full; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-detail">
                                <thead>
                                    <tr>
                                        <th class="text-center" width="20">No.</th>
                                        <th>Nama Barang</th>
                                        <th class="text-center">Jumlah</th>
                                        <th class="text-right">Harga Satuan</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total = 0; foreach($detail as $k => $d) { ?>
                                    <tr>
                                        <td class="text-center"><?php echo ($k + 1); ?></td>
                                        <td><?php echo $d['nama_produk']; ?></td>
                                        <td class="text-center"><?php echo custom_format($d['jumlah']); ?></td>
                                        <td class="text-right"><?php echo custom_format($d['harga_jual']); ?></td>
                                        <td class="text-right"><?php echo custom_format($d['harga_jual'] * $d['jumlah']); ?></td>
                                    </tr>
                                    <?php $total += ($d['jumlah'] * $d['harga_jual']); } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" class="text-right">TOTAL</th>
                                        <th class="text-right"><?php echo custom_format($total); ?></th>
                                    </tr>
                                    <?php if($biaya_cod){ ?>
                                        <tr>
                                            <th colspan="4" class="text-right">BIAYA COD</th>
                                            <th class="text-right"><?php echo custom_format($biaya_cod); ?></th>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <th colspan="4" class="text-right">ONGKOS KIRIM</th>
                                        <th class="text-right"><?php $ongkir = $rev_ongkir ? $rev_ongkir : $ongkir; echo custom_format($ongkir); ?></th>
                                    </tr>
                                    <tr>
                                        <th colspan="4" class="text-right">TOTAL PEMBAYARAN</th>
                                        <th class="text-right"><?php echo custom_format($ongkir + $total + $biaya_cod); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <?php if($no_resi && isset($tracking['summary'])) { ?>
				<div class="card">
					<div class="card-header p-4 bg-light-grey">RIWAYAT PENGIRIMAN</div>
                    <div class="card-body p-4">
                        <div class="table-responsive mb-3">
                            <table class="table table-bordered table-detail">
                                <tr>
                                    <th width="200">Ekspedisi</th>
                                    <td><?php echo $tracking['summary']['courier_name']; ?></td>
                                </tr>
                                <tr>
                                    <th>No. Resi</th>
                                    <td><?php echo $no_resi; ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?php echo $tracking['summary']['status']; ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-detail">
                                <?php foreach($tracking['manifest'] as $m) { ?>
                                <tr>
                                    <th width="200"><?php echo c_date($m['manifest_date'].' '.$m['manifest_time']); ?></th>
                                    <td><?php echo $m['manifest_description'].' '.$m['city_name']; ?></td>
                                </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
	</div>
<?php 
Asset::js('jquery.min.js', true);
Asset::js('popper.min.js', true);
Asset::js('bootstrap.min.js', true);
echo Asset::render();
?>
</body>
</html>