<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends BE_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $akses                  = get_access('dashboard');
        if(isset($akses['access_view']) && $akses['access_view']) {
            redirect('monitoring/dashboard');
        } else {
            $data['title']          = 'Welcome';
            $data['ip']             = $this->input->ip_address();
            $data['agent']          = $this->agent->agent_string();
            $data['browser']        = 'globe';
            $data['is_dashboard']   = true;
            if(strpos($data['agent'],'Firefox') != false) $data['browser'] = 'firefox';
            else if(strpos($data['agent'],'Chrome') != false) $data['browser'] = 'chrome';
            $data['pengumuman'] = get_data('tbl_pengumuman a',array(
                'select'    => 'a.pengumuman,b.nama',
                'join'      => 'tbl_user b on a.id_user = b.id type left',
                'where'     => array(
                    'a.tanggal_publish <='  => date('Y-m-d H:i:s'),
                    'a.tanggal_selesai >='  => date('Y-m-d H:i:s'),
                    'a.is_active'           => 1
                ),
                'sort_by'   => 'a.update_at',
                'sort'      => 'desc'
            ))->result_array();
            render($data,'view:home/welcome/index_old');    
        }
    }

}