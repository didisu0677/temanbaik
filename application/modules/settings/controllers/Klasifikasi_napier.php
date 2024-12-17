<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Klasifikasi_napier extends BE_Controller {

	function __construct() {
		parent::__construct();
	}

	function index() {
		$data['opt_id_indikator'] = get_data('tbl_m_indikator')->result_array();
		render($data);
	}

	function data() {
		$data = data_serverside();
		render($data,'json');
	}

	function get_data() {
		$data = get_data('tbl_m_klasifikasi','id',post('id'))->row_array();
		render($data,'json');
	}

	function save() {
		$response = save_data('tbl_m_klasifikasi',post(),post(':validation'));
		render($response,'json');
	}

	function delete() {
		$response = destroy_data('tbl_m_klasifikasi','id',post('id'));
		render($response,'json');
	}

}