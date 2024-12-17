<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ruangan extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['opt_id_rutan'] 	= get_data('tbl_m_rutan','is_active',1)->result_array();
		$data['indikator']		= get_data('tbl_m_indikator')->result_array();
		render($data);
	}

	function data() {
		$data = data_serverside();
		render($data,'json');
	}

	function get_data() {
		$data = get_data('tbl_m_ruangan','id',post('id'))->row_array();
		if(isset($data['toleransi'])) {
			$toleransi	= json_decode($data['toleransi'],true);
			if(is_array($toleransi)) {
				$data['toleransi']	= $toleransi;
			} else {
				$data['toleransi']	= [];
			}
		}
		render($data,'json');
	}

	function save() {
		$data		= post();
		$_toleransi	= [];
		$toleransi	= post('toleransi');
		if(is_array($toleransi)) {
			$_toleransi	= $toleransi;
		}
		$data['toleransi']	= json_encode($_toleransi);

		$response = save_data('tbl_m_ruangan',$data,post(':validation'));
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_m_ruangan','id',post('id'));
		render($response,'json');
	}

}