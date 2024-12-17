<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['rutan']		= get_data('tbl_m_rutan','is_active',1)->result_array();
		$data['indikator']	= get_data('tbl_m_indikator')->result_array();
		render($data);
	}

	function grafik() {
		$rutan			= get_data('tbl_m_rutan','is_active',1)->result_array();
		$data['data']	= [];
		foreach($rutan as $r) {
			$count		= get_data('tbl_napier',[
				'select'	=> 'count(id) as jml',
				'where'		=> [
					'id_rutan'	=> $r['id']
				]
			])->row();
			$data['data'][]	= [
				'title'		=> $r['nama'],
				'value'		=> isset($count->jml) && $count->jml ? $count->jml : 0
			];
		}

		$count_gender	= get_data('tbl_m_rutan a',[
			'select'	=> 'a.id,a.nama,b.jenis_kelamin,count(b.jenis_kelamin) as jml',
			'join'		=> 'tbl_napier b on a.id = b.id_rutan type LEFT',
			'group_by' => 'a.id,b.jenis_kelamin'
		])->result_array();


		$data['data_gender']= $count_gender;


		render($data,'json');
	}

	function table($id_rutan=0) {
		$ruangan	= get_data('tbl_m_ruangan',[
			'where'	=> [
				'id_rutan'	=> $id_rutan,
				'is_active'	=> 1
			]
		])->result_array();
		$indikator	= get_data('tbl_m_indikator')->result_array();
		if(count($ruangan) > 0) {
			foreach($ruangan as $r) {
				$toleransi	= json_decode($r['toleransi'],true);
				if(!is_array($toleransi)) {
					$toleransi	= [];
				}
				echo '<tr>';
				echo '<td>'.$r['blok'].' - '.$r['kamar'].'</td>';
				echo '<td class="text-center">'.$r['kapasitas'].'</td>';
				$arr	= [
					'select'	=> 'count(id) as jml',
					'where'		=> [
						'id_ruangan'	=> $r['id']
					]
				];
				$q		= get_data('tbl_napier',$arr)->row();
				$jml	= isset($q->jml) && $q->jml ? $q->jml : 0;
				$style	= '';
				if($jml > $r['kapasitas']) {
					$style	= ' style="background: #ff4d40; color: #fff;" title="Melebihi Kapasitas"';
				}
				echo '<td class="text-center"'.$style.'>'.$jml.'</td>';
				foreach($indikator as $i) {
					$arr['where']['id_indikator']	= $i['id'];
					$q		= get_data('tbl_napier',$arr)->row();
					$jml	= isset($q->jml) && $q->jml ? $q->jml : 0;
					$style	= '';
					if(isset($toleransi[$i['id']])) {
						$t		= str_replace(['.',','],['','.'],$toleransi[$i['id']]);
						if($t) {
							$_t		= ($jml / $r['kapasitas']) * 100;
							if($_t > $t) {
								$style	= ' style="background: #ff4d40; color: #fff;" title="Melebihi Toleransi Napier '.$i['judul'].'"';
							}
						}
					}
					echo '<td class="text-center"'.$style.'>'.$jml.'</td>';	
				}
				echo '</tr>';
			}
		} else {
			echo '<tr><td colspan="'.(count($indikator) + 3).'">Tidak ada data ruangan</td></tr>';
		}
	}

  function data5($page = 1) {


        $limit = 0;
        if($page) {
            $page = ($page - 1) * $limit;
        }

        $attr = [
            'select' => 'a.*',
            'limit' => $limit,
            'offset' => $page,
            'where'  => [
            	'a.nama !=' => '',
            ]
        ];

        $result = data_pagination('tbl_napier a',$attr,base_url('monitoring/dashboard/data5/'),4);
     
        $data_view['record']    = $result['record'];


        $where = [
            'a.nama !=' => '',
        ];
        

        $data_view['data_napier']  = get_data('tbl_napier a',[
            'select' => 'a.*',
            'where' => $where,
            'group_by' => 'a.sisa_masa_tahanan'
        ])->result();

       
        $where2 = [
            'a.nama !=' => '',
        ];
  
        $view   = $this->load->view('monitoring/dashboard/data5',$data_view,true);
     
        $data = [
            'data'      => $view,     
        ];


        render($data,'json');
    }

	function grafik_pie($id_rutan=0) {
		$ruangan	= get_data('tbl_m_ruangan',[
			'where'	=> [
				'id_rutan'	=> $id_rutan,
				'is_active'	=> 1
			]
		])->result_array();
		$indikator	= get_data('tbl_m_indikator')->result_array();
		if(count($ruangan) > 0) {
			foreach($ruangan as $r) {
				$toleransi	= json_decode($r['toleransi'],true);
				if(!is_array($toleransi)) {
					$toleransi	= [];
				}

				$arr	= [
					'select'	=> 'count(id) as jml',
					'where'		=> [
						'id_ruangan'	=> $r['id']
					]
				];
				$q		= get_data('tbl_napier',$arr)->row();
				$jml	= isset($q->jml) && $q->jml ? $q->jml : 0;

				foreach($indikator as $i) {
					$arr['where']['id_indikator']	= $i['id'];
					$q		= get_data('tbl_napier',$arr)->row();
					$jml	= isset($q->jml) && $q->jml ? $q->jml : 0;
					$style	= '';
					if(isset($toleransi[$i['id']])) {
						$t		= str_replace(['.',','],['','.'],$toleransi[$i['id']]);
						if($t) {
							$_t		= ($jml / $r['kapasitas']) * 100;
							if($_t > $t) {
								$style	= ' style="background: #ff4d40; color: #fff;" title="Melebihi Toleransi Napier '.$i['judul'].'"';
							}
						}
					}
				}
			}
		} 
	}




}