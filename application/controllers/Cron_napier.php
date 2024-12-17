<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron_napier extends MY_Controller {
	function __construct(){
		parent::__construct();
	}
	

	function index(){	
	}
	
	function parse_waktu($hari = 0) {
		$xx = $hari ;
		$tahun 	= floor($hari / 360);
		$hari -= ($tahun * 360);
		$bulan 	= floor($hari / 30);
		$hari -= ($bulan * 30);

		$result = [];

		if ($xx > 0) {  
			if($tahun) $result[] = $tahun.' Tahun';
			if($bulan) $result[] = $bulan.' Bulan';
			if($hari) $result[] = $hari.' Hari';
		}else{
			$result[] = "Kadaluarsa";
		}

		return implode(', ',$result);
	}	

	
	function status_napier() {
		$napier = get_data('tbl_napier',[
			'sort_by' => 'tanggal_bebas',
			'sort'	=>'ASC'
		])->result();
		

		$age ='';
		$st_age ='';
		foreach ($napier as $p) {

			if($p->tanggal_bebas !='0000-00-00' && $p->tanggal_bebas != '1970-01-01'){

				$today     = new DateTime();
				$selectDay = new DateTime($p->tanggal_bebas);
				$interval  = date_diff( $selectDay, $today);

				$age1 = $interval->format("%y");
				$age2 = $interval->format("%a");

				if ($age2 >= 0 && $age2 <= 31) {
				  $age = '01';
				  $st_age = '<= 1 Bulan'; 
				} elseif ($age2 >= 32 && $age2 <= 365) { 
				  $age = '12';  
				  $st_age = '<= 1 tahun'; 
				} else {
				  $age = '99';
				  $st_age = '> 1 Tahun'; 
				}

			}

			update_data('tbl_napier',['sisa_masa_tahanan'=>$st_age],['id'=>$p->id]);

			$age ='';
		}

		echo 'Success' ;	
	}	
}