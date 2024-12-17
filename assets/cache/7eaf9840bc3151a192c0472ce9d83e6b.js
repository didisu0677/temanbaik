
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
