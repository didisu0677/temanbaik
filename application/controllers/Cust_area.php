<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cust_area extends MY_Controller {
    
    function invoice($id='') {
        $ids    = decode_id($id);
        $i      = isset($ids[0]) ? $ids[0] : 0;
        $data   = get_data('tbl_pesanan','id',$i)->row_array();
        if(isset($data['id'])) {
            $data['detail'] = get_data('tbl_pesanan_detail','id_pesanan',$data['id'])->result_array();
        }
        $this->load->library('asset');
        if(isset($data['id'])) {
            if($data['no_resi']) {
                $this->load->library('ongkir',['key'=>setting('key_rajaongkir')]);
                $x = $this->ongkir->tracking($data['no_resi'],$data['kode_ekspedisi']);
                $data['tracking'] = $x['result'];
            }
            $this->load->view('cust_invoice',$data);
        } else {
            $this->load->view('errors/page_not_found');    
        }
    }

    function tracking() {
        $d = post();
        $this->load->library('ongkir',['key'=>setting('key_rajaongkir')]);
        $x = $this->ongkir->tracking($d['no_resi'],$d['kode_ekspedisi']);
        if(isset($x['result']['summary'])) {
            include_lang('transaksi');
            $this->load->view('cust_tracking',$x['result']);
        }
    }

}