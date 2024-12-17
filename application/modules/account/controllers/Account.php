<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function index() {
		redirect('account/profile');
	}

	function change_language() {
		$cookie	= array(
			'name'          => 'lang',
			'value'         => post('lang'),
			'expire'        => '86500'
		);
		set_cookie( $cookie );
	}

	function change_menu_display() {
		$cookie	= array(
			'name'          => 'menu_display',
			'value'         => post('type'),
			'expire'        => '86500'
		);
		set_cookie( $cookie );
	}

	function show_table_border() {
		$last_config = get_cookie('hide_table_border');
		$new_config = $last_config == false ? true : false;
		$cookie	= array(
			'name'          => 'hide_table_border',
			'value'         => $new_config,
			'expire'        => '86500'
		);
		set_cookie( $cookie );
	}
	
}
