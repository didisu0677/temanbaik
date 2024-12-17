<style>
	.label-chart {
		white-space: nowrap;
		font-size: 8px;
		margin-right: 10px;
		margin-bottom: 3px;
		display: inline-block;
	}
	.label-chart .indicator {
		width: 12px;
		height: 8px;
		border-radius: 2px;
		margin-right: 5px;
	}
</style>
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/breakingnews/breakingnews.css'); ?>">
<div class="content-body body-home bg-grey">
	<div class="position-relative">
		<div class="offset-header"></div>
		<div class="main-container pt-3">
			<div class="row">
				<div class="col-lg-8 mb-3 mb-lg-4">
					<div class="row">
						<div class="col-lg-6 mb-3 mb-lg-4">
							<div class="card">
								<div class="card-header pt-2 pb-2 pr-3 pl-3">
									<div class="float-left pt-2 mb-2 mb-sm-0">
										<?php echo lang('post_border_berdasarkan_status'); ?>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="card-body p-3">
									<canvas id="myChart" height="250"></canvas>
								</div>
							</div>						
						</div>
						<div class="col-lg-6 mb-3 mb-lg-4">
							<div class="card">
								<div class="card-header pt-2 pb-2 pr-3 pl-3">
									<div class="float-left pt-2 mb-2 mb-sm-0">
										<?php echo lang('post_border_berdasarkan_status_sertifikat'); ?>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="card-body p-3">
									<canvas id="myChart1" height="250"></canvas>
								</div>
							</div>						
						</div>
						<div class="col-12 mb-3 mb-lg-4">
							<div class="card">
								<div class="card-header pt-2 pb-2 pr-3 pl-3">
									<div class="float-left pt-2 mb-2 mb-sm-0">
										<?php echo lang('post_border_top_20_importir'); ?>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="card-body pl-3 pr-3">
									<div class="pt-3">
										<canvas id="myChart2" height="250"></canvas>
									</div>
									<div class="pb-3 pt-3">
										<div id="myChart2-desc" class="mt-2 text-center"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 mb-3 mb-lg-4">
							<div class="card">
								<div class="card-header pt-2 pb-2 pr-3 pl-3">
									<div class="float-left pt-2 mb-2 mb-sm-0">
										<?php echo lang('post_border_sertifikat_yang_akan_expired'); ?>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="card-body p-3">
									<canvas id="myChart3" height="250"></canvas>
								</div>
							</div>
						</div>
						<div class="col-lg-6 mb-3 mb-lg-4">
							<div class="card">
								<div class="card-header pt-2 pb-2 pr-3 pl-3">
									<div class="float-left pt-2 mb-2 mb-sm-0">
										<?php echo lang('suket_berdasarkan_jenis_permohonan'); ?>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="card-body p-3">
									<canvas id="myChart4" height="250"></canvas>
								</div>
							</div>
						</div>
						<div class="col-lg-6 mb-3 mb-lg-4">
							<div class="card">
								<div class="card-header pt-2 pb-2 pr-3 pl-3">
									<div class="float-left pt-2 mb-2 mb-sm-0">
										<?php echo lang('suket_berdasarkan_status'); ?>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="card-body p-3">
									<canvas id="myChart5" height="250"></canvas>
								</div>
							</div>
						</div>
						<div class="col-lg-6 mb-3 mb-lg-4">
							<div class="card">
								<div class="card-header pt-2 pb-2 pr-3 pl-3">
									<div class="float-left pt-2 mb-2 mb-sm-0">
										<?php echo lang('suket_berdasarkan_operator'); ?>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="card-body p-3">
									<canvas id="myChart6" height="250"></canvas>
								</div>
							</div>
						</div>
						<div class="col-12">
							<div class="card">
								<div class="card-header pt-2 pb-2 pr-3 pl-3">
									<div class="float-left pt-2 mb-2 mb-sm-0">
										<?php echo lang('suket_top_20_perusahaan'); ?>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="card-body p-3">
									<div class="table-responsive">
										<table class="table table-striped">
											<?php foreach($suket_perusahaan as $b) { ?>
											<tr>
												<td><?php echo $b->perusahaan; ?></td>
												<td class="text-right"><?php echo custom_format($b->jml); ?></td>
											</tr>
											<?php } ?>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 mb-3 mb-lg-4">
					<div class="card">
						<div class="card-header pt-2 pb-2 pr-3 pl-3">
							<div class="float-left pt-2 mb-2 mb-sm-0">
								<?php echo lang('post_border_berdasarkan_asal_barang'); ?>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="card-body p-3">
							<div class="table-responsive">
								<table class="table table-striped">
									<?php foreach($brgasal as $b) { ?>
									<tr>
										<td><?php echo $b->brgasal; ?></td>
										<td class="text-right"><?php echo custom_format($b->jml); ?></td>
									</tr>
									<?php } ?>
								</table>
							</div>
						</div>
					</div>						
				</div>
			</div>
		</div>

		<div class="main-container p-4 text-center">
			<img src="<?php echo base_url(dir_upload('setting').setting('logo')); ?>" alt="logo">
			<div class="version">Version <?php echo APP_VERSION; ?></div>
		</div>
	
	</div>
</div> 
<script src="<?php echo base_url('assets/plugins/breakingnews/breakingnews.js'); ?>"></script>
<script src="<?php echo base_url('assets/plugins/chartjs/Chart.bundle.min.js'); ?>"></script>
<script>
	var grafik1, grafik2, grafik3, grafik4, grafik5, grafik6, grafik7;
	var serialize_color = [
		'#404E67',
		'#22C2DC',
		'#ff6384',
		'#ff9f40',
		'#ffcd56',
		'#4bc0c0',
		'#9966ff',
		'#36a2eb',
		'#848484',
		'#e8b892',
		'#bcefa0',
		'#4dc9f6',
		'#a0e4ef',
		'#c9cbcf',
		'#00A5A8',
		'#10C888',
		'#ff7a7a',
		'#7ae2ff',
		'#8c7aff',
		'#ff7ade'
	];
	function attrPie() {
		return {
			type: 'pie',
			options: {
				maintainAspectRatio: false,
				responsive: true,
				legend: {
					display: true,
					position: 'bottom',
					labels: {
						boxWidth: 10,
						fontSize: 9,
						generateLabels: function(chart) {
							var data = chart.data;
							if (data.labels.length && data.datasets.length) {
								return data.labels.map(function(label, i) {
									var meta = chart.getDatasetMeta(0);
									var ds = data.datasets[0];
									var arc = meta.data[i];
									var custom = arc && arc.custom || {};
									var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
									var arcOpts = chart.options.elements.arc;
									var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
									var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
									var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);

									var value = chart.config.data.datasets[arc._datasetIndex].data[arc._index];

									return {
										text: label + " : " + value,
										fillStyle: fill,
										strokeStyle: stroke,
										lineWidth: bw,
										hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
										index: i
									};
								});
							} else {
								return [];
							}
						}
					}
				}
			}
		}
	}
	function attrBar() {
		return {
			type: 'bar',
			options: {
				maintainAspectRatio: false,
				responsive: true,
				labels: {
					fontSize: 9
				},
				legend: {
					display: false,
					position: 'bottom',
				},
				scales: {
					xAxes: [{
						ticks: {
							fontSize: 0
						}
					}]
				}
			}
		}
	}
	function get_graph() {
		$.ajax({
			url 		: base_url + 'home/welcome/data_grafik',
			data 		: {},
			type 		: 'post',
			dataType	: 'json',
			success 	: function(response) {
				renderGrafik1(response.grafik_status);
				renderGrafik2(response.grafik_status_sertifikat);
				renderGrafik3(response.top_importir);
				renderGrafik4(response.expired);
				renderGrafik5(response.jenis_permohonan);
				renderGrafik6(response.status_suket);
				renderGrafik7(response.operator);
			}
		});
	}
	function renderGrafik1(data) {
		var data_pie 		= [];
		var color_pie 		= [];
		var label_chart 	= [];
		$.each(data,function(k,v){
			data_pie.push(parseInt(v['jumlah']));
			color_pie.push(serialize_color[k]);
			label_chart.push(v['label']);
		});
		grafik1.data = {
			datasets: [{
				data: data_pie,
				backgroundColor: color_pie,
				label: ''
			}],
			labels: label_chart,
		};
		grafik1.update();
	}
	function renderGrafik2(data) {
		var data_pie 		= [];
		var color_pie 		= [];
		var label_chart 	= [];
		$.each(data,function(k,v){
			data_pie.push(parseInt(v['jumlah']));
			color_pie.push(serialize_color[k]);
			label_chart.push(v['label']);
		});
		grafik2.data = {
			datasets: [{
				data: data_pie,
				backgroundColor: color_pie,
				label: ''
			}],
			labels: label_chart,
		};
		grafik2.update();
	}
	function renderGrafik3(data) {
		var labels			= '';
		var label_chart 	= [];
		var data_bar 		= [];
		var background		= [];
		$.each(data,function(k,v){
			label_chart.push(v.label);
			data_bar.push(parseInt(v.jumlah));
			background.push(serialize_color[k]);
			labels += '<div class="label-chart"><span class="indicator" style="background: '+serialize_color[k]+'"></span> ' + v.label + ' : ' + v.jumlah+'</div>';
		});
		
		grafik3.data = {
			labels: label_chart,
			datasets: [{
				label: lang.jumlah,
				backgroundColor: background,
				borderColor: 'transparent',
				borderWidth: 0,
				data: data_bar
			}]
		};

		grafik3.update();
		$('#myChart2-desc').html(labels);
	}
	function renderGrafik4(data) {
		var data_pie 		= [];
		var color_pie 		= [];
		var label_chart 	= [];
		$.each(data,function(k,v){
			data_pie.push(parseInt(v['jumlah']));
			color_pie.push(serialize_color[k]);
			label_chart.push(v['label']);
		});
		grafik4.data = {
			datasets: [{
				data: data_pie,
				backgroundColor: color_pie,
				label: ''
			}],
			labels: label_chart,
		};
		grafik4.update();
	}
	function renderGrafik5(data) {
		var data_pie 		= [];
		var color_pie 		= [];
		var label_chart 	= [];
		$.each(data,function(k,v){
			data_pie.push(parseInt(v['jumlah']));
			color_pie.push(serialize_color[k]);
			label_chart.push(v['label']);
		});
		grafik5.data = {
			datasets: [{
				data: data_pie,
				backgroundColor: color_pie,
				label: ''
			}],
			labels: label_chart,
		};
		grafik5.update();
	}
	function renderGrafik6(data) {
		var data_pie 		= [];
		var color_pie 		= [];
		var label_chart 	= [];
		$.each(data,function(k,v){
			data_pie.push(parseInt(v['jumlah']));
			color_pie.push(serialize_color[k]);
			label_chart.push(v['label']);
		});
		grafik6.data = {
			datasets: [{
				data: data_pie,
				backgroundColor: color_pie,
				label: ''
			}],
			labels: label_chart,
		};
		grafik6.update();
	}
	function renderGrafik7(data) {
		var data_pie 		= [];
		var color_pie 		= [];
		var label_chart 	= [];
		$.each(data,function(k,v){
			data_pie.push(parseInt(v['jumlah']));
			color_pie.push(serialize_color[k]);
			label_chart.push(v['label']);
		});
		grafik7.data = {
			datasets: [{
				data: data_pie,
				backgroundColor: color_pie,
				label: ''
			}],
			labels: label_chart,
		};
		grafik7.update();
	}
	$(document).ready(function(){
		var ctxPie = document.getElementById('myChart').getContext('2d');
		grafik1 = new Chart(ctxPie, attrPie());

		var ctxPie2 = document.getElementById('myChart1').getContext('2d');
		grafik2 = new Chart(ctxPie2, attrPie());

		var ctxPie3 = document.getElementById('myChart3').getContext('2d');
		grafik4 = new Chart(ctxPie3, attrPie());

		var ctxPie4 = document.getElementById('myChart4').getContext('2d');
		grafik5 = new Chart(ctxPie4, attrPie());

		var ctxPie5 = document.getElementById('myChart5').getContext('2d');
		grafik6 = new Chart(ctxPie5, attrPie());

		var ctxPie6 = document.getElementById('myChart6').getContext('2d');
		grafik7 = new Chart(ctxPie6, attrPie());

		var ctxBar1  	= document.getElementById('myChart2').getContext('2d');
		grafik3 		= new Chart(ctxBar1, attrBar());

		get_graph();
	});
	$("#bn7").breakingNews({
		effect		:"slide-v",
		autoplay	:true,
		timer		:5000,
	});
</script>