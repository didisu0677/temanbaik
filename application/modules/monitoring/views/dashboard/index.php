<div class="content-header">
	<div class="main-container position-relative">
		<div class="header-info">
			<div class="content-title"><?php echo $title; ?></div>
			<?php echo breadcrumb(); ?>
		</div>
	</div>
</div>
<div class="content-body">
    <div class="main-container">
        <div class="card mb-3">
            <div class="card-header"><?php echo lang('grafik') . ' - ' . lang('monitoring_rutan'); ?></div>
            <div class="card-body p-3">
                    <div class="col-sm-12">
                        <div class="form-group row">    
                            <div class="col-sm-6">
                                <canvas id="myChart"></canvas>
                            </div>

                            <div class="col-sm-6">
                                <canvas id="myChart2"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group row">    
                            <div class="col-sm-6">
                                <canvas id="chart3"></canvas>
                            </div>

                            <div class="col-sm-6">
                                <canvas id="chart4"></canvas>
                            </div>
                        </div>
                    </div>
            </div>



        </div>
        <div class="card mb-3">
            <div class="card-header">
                <div class="float-left pt-1"><?php echo lang('tabel') . ' - ' . lang('monitoring_ruangan'); ?></div>
                <div class="float-right">
                    <select class="custom-select select2" id="id_rutan" style="width: 300px">
                        <?php foreach($rutan as $r) { ?>
                            <option value="<?php echo $r['id'];?>"><?php echo $r['nama'];?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th class="text-left" rowspan="2"><?php echo lang('blok').' - '.lang('kamar'); ?></th>
                                <th class="text-center" rowspan="2"><?php echo lang('kapasitas'); ?></th>
                                <th class="text-center" rowspan="2"><?php echo lang('jumlah_napi'); ?></th>
                                <th class="text-center" colspan="<?php echo count($indikator);?>"><?php echo lang('klasifikasi_indikator'); ?></th>
                            </tr>
                            <tr>
                                <?php foreach($indikator as $i) { ?>
                                <th class="text-center" style="background:<?php echo $i['warna'];?>; color: #FFF;"><?php echo $i['judul'];?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody id="datatable"></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <div class="float-left pt-1"><?php echo lang('tabel') . ' - ' . lang('masa_tahanan'); ?></div>
                            </div>     
                    <div class="table-responsive tab-pane fade active show" id="result5">
                        <div class="row mr-0 ml-0">
                            <div class="col-sm-12 pl-0 pr-0 pr-sm-2">
                            <?php
                                table_open('table table-bordered table-app table-hover');
                                    thead();
                                        ?>
                                        <tr>
                                            <th style="background-color: #e64a19; color: white; text-align: center; "><font color="#fff">No</font></th>
                                            <th style="background-color: #e64a19; color: white; text-align: center"><font color="#fff">Nama Lengkap</font></th>
                                            <th style="background-color: #e64a19; color: white; text-align: center"><font color="#fff">Nama Alias</font></th>
                                            <th style="background-color: #e64a19; color: white; text-align: center"><font color="#fff">Alamat</font></th>
                                            <th style="background-color: #e64a19; color: white; text-align: center"><font color="#fff">Tanggal Lahir</font></th>
                                            <th style="background-color: #e64a19; color: white; text-align: center"><font color="#fff">Tanggal Vonis</font></th>
                                        </tr>
                                    <?php       
                                    tbody('result-overall');
                                        tr();
                                            td('Tidak ada data','text-left','colspan="7"');
                                table_close();
                            ?>                          
                            </div>

                        </div>
                    </div>
        </div>     
                <div class="card mb-3">
            <div class="card-header">
                <div class="float-left pt-1"><?php echo lang('tabel') . ' - ' . lang('grup_jaringan'); ?></div>
                            </div>     
                    <div class="table-responsive tab-pane fade active show" id="result">
                        <div class="row mr-0 ml-0">
                            <div class="col-sm-12 pl-0 pr-0 pr-sm-2">
                            <?php
                                table_open('table table-bordered table-app table-hover');
                                    thead();
                                        ?>
                                        <tr>
                                            <th style="background-color: #e64a19; color: white; text-align: center; "><font color="#fff">No</font></th>
                                            <th style="background-color: #e64a19; color: white; text-align: center"><font color="#fff">Nama Lengkap</font></th>
                                            <th style="background-color: #e64a19; color: white; text-align: center"><font color="#fff">Nama Alias</font></th>
                                            <th style="background-color: #e64a19; color: white; text-align: center"><font color="#fff">Alamat</font></th>
                                            <th style="background-color: #e64a19; color: white; text-align: center"><font color="#fff">Tanggal Lahir</font></th>
                                            <th style="background-color: #e64a19; color: white; text-align: center"><font color="#fff">Tanggal Vonis</font></th>
                                        </tr>
                                    <?php       
                                    tbody('result-overall');
                                        tr();
                                            td('Tidak ada data','text-left','colspan="7"');
                                table_close();
                            ?>                          
                            </div>

                        </div>
                    </div>
        </div>          
    </div>
</div>
<script src="<?php echo base_url('assets/plugins/chartjs/Chart.bundle.min.js'); ?>"></script>
<script>
var grafik;
var grafik2;
var grafik3;
var xhr_ajax5 = null;
var serialize_color2 = [
    '#7e57c2',
    '#f44336',
    '#3F729B',
    '#9e9e9e',
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
    '#7d3cff',
    '#f2d53c',
    '#c80e13',
    '#e1b382',
    '#c89666',
    '#2d545e',
    '#12343b',
    '#9bc400',
    '#8076a3',
    '#f9c5bd',
    '#7c677f'
];

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
                position: 'bottom',
            }
        }
    }
}

function attrPie() {
    return {
        type: 'pie',
        options: {
            maintainAspectRatio: false,
            responsive: true,
            labels: {
                fontSize: 9
            },
            legend: {
                position: 'bottom',
            }
        }
    }
}


$(document).ready(function(){
    var ctxBar  	= document.getElementById('myChart').getContext('2d');
    grafik 		= new Chart(ctxBar, attrBar());

    var ctxBar2  = document.getElementById('myChart2').getContext('2d');
    grafik2      = new Chart(ctxBar2, attrBar());

    var ctxPie = document.getElementById('chart3').getContext('2d');
    grafik3     = new Chart(ctxPie, attrPie());

    var ctxBar3  = document.getElementById('chart4').getContext('2d');
    grafik4      = new Chart(ctxBar3, attrBar());

    $.ajax({
        url 		: base_url + 'monitoring/dashboard/grafik',
        data 		: {},
        type 		: 'post',
        dataType	: 'json',
        success 	: function(response) {
            var color_pie       = [];
            var label_chart 	= [];
            var data_bar 		= [];
            var background		= [];
            var data_bar1       = [];
            var data_bar2       = [];
            var i = 1;
            $.each(response.data,function(k,v){

                    i++;
                color_pie.push(serialize_color2[i]);
                label_chart.push(v.title);
                data_bar.push(parseInt(v.value));
                background.push('#22C2DC');

                $.each(response.data_gender,function(x,y){
                    if(v.title == y.nama) { 
                        if(y.jenis_kelamin == 'Laki-Laki'){
                            data_bar1.push(parseInt(y.jml));
                        }else{
                            data_bar2.push(parseInt(y.jml));
                        }
                    }
                });

            });

            
            grafik.data = {
                labels: label_chart,
                datasets: [{
                    label: 'Jumlah Napier',
                    backgroundColor: color_pie,
                    borderColor: 'transparent',
                    borderWidth: 0,
                    data: data_bar
                }]
            };

            grafik.update();


            grafik2.data = {
                labels: label_chart,
                datasets: [

                    {
                      label: "Laki-Laki",
                      type: "bar",
                      backgroundColor: "#0288d1",
                      data: data_bar1,
                    }, 
                    {
                      label: "Perempuan",
                      type: "bar",
                      backgroundColor: "#ef6c00",
                      data: data_bar2,
                    }, 

      
                ]
            };
            grafik2.update();


            grafik3.data = {
                labels: label_chart,
                datasets: [{
                    label: 'Jumlah Napier',
                    backgroundColor: color_pie,
                    borderColor: 'transparent',
                    borderWidth: 0,
                    data: data_bar
                }]
            };
            grafik3.update();

            grafik4.data = {
                labels: label_chart,
                datasets: [{
                    label: 'Jumlah Napier',
                    backgroundColor: background,
                    borderColor: 'transparent',
                    borderWidth: 0,
                    data: data_bar
                }]
            };

            grafik4.update();

            get_table();
            loadData5();
        }
    });
});
$('#id_rutan').change(function(){
    get_table();
});
function get_table() {
    $.get(base_url + 'monitoring/dashboard/table/' + $('#id_rutan').val(),function(r){
        $('#datatable')[0].innerHTML = r;
    });
}

function loadData5(pageNum){
    if(typeof pageNum == 'undefined') {
        pageNum = 1;
    }

    if( xhr_ajax5 != null ) {
        xhr_ajax5.abort();
        xhr_ajax5 = null;
    }

    var page = base_url + 'monitoring/dashboard/data5/'+pageNum;
    page += '/'+ $('#portfolio').val();
    xhr_ajax5 = $.ajax({
        url: page,
        type: 'post',
        data : $('#form-filter').serialize(),
        dataType: 'json',
        success: function(res){
            xhr_ajax5 = null;
            $('#result5 tbody').html(res.data);         
    
        }
    });
}

</script>