<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Data_napier extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		render();
	}

	function data($tipe = 'napier', $id_napier = 0) {
		$config['access_view']			= false;
		if($tipe == 'napier') {
			$config['link_edit']		= base_url('monitoring/data_napier/form/profil?i=');
		} else {
			$config['where']['id_napier']	= $id_napier;
		}
		if($tipe == 'kunjungan_keluarga') {
			$config['where']['tipe']		= 0;
		}elseif($tipe == 'kunjungan_petugas') {
			$config['where']['tipe']		= 1;
		}
		if($tipe == 'penempatan') {
			$config['access_edit']		= false;
			$config['access_delete']	= false;
			$config['button']			= [
				button_serverside('btn-warning','btn-input',['fa-edit',lang('ubah'),true],'act-edit',['is_first'=>0]),
				button_serverside('btn-danger','btn-delete',['fa-trash',lang('hapus'),true],'act-delete',['is_first'=>0]),
			];
		}
		$data = data_serverside($config);
		render($data,'json');
	}

	function get_data($tipe = 'napier') {
		if($tipe == 'kunjungan_kelurga' || $tipe == 'kunjungan_petugas') {
			$tipe = 'kunjungan';
		}
		$tipe = $tipe == 'napier' ? 'napier' : 'napier_' . $tipe;
		$data = get_data('tbl_'.$tipe,'id',post('id'))->row_array();
		render($data,'json');
	}

	function save($tipe = 'napier') {
		$data		= post();

		if($tipe == 'kunjungan_petugas') {
			$data['tipe'] = 1;
		}
		if($tipe == 'kunjungan_keluarga' || $tipe == 'kunjungan_petugas') {
			$tipe = 'kunjungan';
		}
		if($tipe == 'napier' || $tipe == 'penempatan') {
			$rutan				= get_data('tbl_m_rutan','id',$data['id_rutan'])->row();
			$klasifikasi		= get_data('tbl_m_klasifikasi','id',$data['id_klasifikasi'])->row();
			$ruangan			= get_data('tbl_m_ruangan','id',$data['id_ruangan'])->row();
			$data['nama_rutan']	= isset($rutan->id) ? $rutan->nama : '';
			$data['blok']		= isset($ruangan->id) ? $ruangan->blok : '';
			$data['kamar']		= isset($ruangan->id) ? $ruangan->kamar : '';
			$data['klasifikasi']= isset($klasifikasi->id) ? $klasifikasi->klasifikasi : '';
			$data['id_indikator']	= isset($klasifikasi->id) ? $klasifikasi->id_indikator : 0;
		}
		if($tipe == 'napier') {
			$data['vonis']		= $data['vonis_tahun'].' Tahun '.$data['vonis_bulan'].' Bulan';
		}

		$subsidair = $data['subsidair'];
		$data['tanggal_bebas'] = '0000-00-00';
		if(isset($data['tanggal_vonis']) && !empty($data['tanggal_vonis'])){
			if(isset($data['vonis_tahun']) && $data['vonis_tahun'] > 0) {
				$y = manipulasiTanggal($data['tanggal_vonis'],$data['vonis_tahun'],'year');
				$data['tanggal_bebas'] = $y;
			}	

			
			if(isset($data['vonis_bulan']) && $data['vonis_bulan'] > 0) {
				$m = manipulasiTanggal($y,$data['vonis_bulan'],'month');
				$data['tanggal_bebas'] = $m;
			} 
			
			if(isset($data['vonis_tahun']) && $data['subsidair'] > 0) {
				$c = manipulasiTanggal($m,$subsidair,'month');
				$data['tanggal_bebas'] = $c;
			} 

		}



		$tipe = $tipe == 'napier' ? 'napier' : 'napier_' . $tipe;
		$response = save_data('tbl_'.$tipe,$data,post(':validation'));
		if($tipe == 'napier' && $response['status'] == 'success' && isset($data['nama_rutan']) && $data['nama_rutan']) {
			$cek	= get_data('tbl_napier_penempatan',[
				'where'	=> [
					'id_napier'	=> $response['id'],
					'is_first'	=> 1
				]
			])->row();

			if(isset($data['subsidair']) && $data['subsidair'] > 0) $subsidair = $data['subsidair'] * -1;

			if(!isset($cek->id)) {
				save_data('tbl_napier_penempatan',[
					'id'			=> '',
					'id_napier'		=> $response['id'],
					'tanggal'		=> $data['tanggal_penempatan'],
					'id_rutan'		=> $data['id_rutan'],
					'nama_rutan'	=> $data['nama_rutan'],
					'blok'			=> $data['blok'],
					'kamar'			=> $data['kamar'],
					'is_first'		=> 1
				]);
			}
		}
		render($response,'json');
	}

	function delete($tipe = 'napier') {
		if($tipe == 'kunjungan_kelurga' || $tipe == 'kunjungan_petugas') {
			$tipe = 'kunjungan';
		}
		$tipe = $tipe == 'napier' ? 'napier' : 'napier_' . $tipe;
		$response = destroy_data('tbl_'.$tipe,'id',post('id'));
		render($response,'json');
	}

	function get_ruangan($id_rutan=0) {
		$opt	= get_data('tbl_m_ruangan','id_rutan = "'.$id_rutan.'" AND is_active = 1 ')->result_array();
		echo '<option value=""></option>';
		foreach($opt as $o) {
			echo '<option value="'.$o['id'].'">'.$o['blok'].' - '.$o['kamar'].'</option>';
		}
	}

	function form($tipe 	= 'profil') {
		$ids				= decode_id(get('i'));
		$id					= is_array($ids) && isset($ids[0]) ? $ids[0] : 0;
		$data				= get_data('tbl_napier','id',$id)->row_array();
		$data['page']		= $tipe;
		$data['foto'][1]	= $data['foto'][2] = $data['foto'][3]	= '';
		$data['rutan']		= get_data('tbl_m_rutan','is_active = 1')->result_array();
		$data['opt_klasifikasi']	= get_data('tbl_m_klasifikasi')->result_array();
		$data['ruangan']			= '';
		if(isset($data['id_rutan']) && $data['id_rutan']) {
			$data['ruangan']		= get_data('tbl_m_ruangan','id_rutan = '.$data['id_rutan'].' AND is_active = 1 ')->result_array();
		}
		$access	= get_access('data_napier');
		if(!isset($data['id'])) {
			if($access['access_input']) {
				$data['title']	= lang('tambah_napier');
				$fields			= get_field('tbl_napier','name');
				foreach($fields as $f) {
					$data[$f]	= '';
				}
				$data['akses']	= $access['access_input'];
				render($data,'view:monitoring/data_napier/profil');
			} else {
				render('404');
			}
		} else {
			$data['title']		= $data['nama'];
			$data['encode_id']	= get('i');
			for($i=1;$i<=3;$i++) {
				$data['foto'][$i]	= $data['foto'.$i];
			}
			$data['vonis_tahun']	= $data['vonis_tahun'] ?: '';
			$data['vonis_bulan']	= $data['vonis_bulan'] ?: '';
			$data['subsidair']		= $data['subsidair'] ?: '';
			$data['denda']			= $data['denda'] ?: '';
			$list_menu	= [
				'keluarga',
				'penempatan',
				'kegiatan',
				'catatan',
				'kunjungan_petugas',
				'kunjungan_keluarga',
				'kesehatan'
			];
			if($tipe == 'kegiatan') {
				$data['jenis_kegiatan']	= get_master(1);
			}
			if($tipe == 'profil') {
				if($access['access_edit']) {
					render($data,'view:monitoring/data_napier/profil');
				} else {
					render($data,'view:monitoring/data_napier/profil_info');
				}
			} elseif(in_array($tipe,$list_menu)) {
				render($data,'view:monitoring/data_napier/'.$tipe);
			} else {
				render('404');
			}
		}
	}

}