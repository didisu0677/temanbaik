<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Form extends MY_Controller {
    
	var $variable;

	function __construct() {
		parent::__construct();
		$this->variable = [
			'mitra'             => 'nama_toko',
			'nama'              => 'nama_pembeli',
			'no_telp'           => 'no_telp_pembeli',
            'alamat_full'       => 'alamat',
            'detail_pesanan'    => 'detail_pesanan',
            'ongkir'            => 'ongkir',
			'biaya_cod'         => 'biaya_cod',
            'biaya_asuransi'    => 'asuransi',
			'kode_unik'         => 'kode_unik',
            'total'             => 'total',
			'ekspedisi'         => 'eskpedisi',
			'data_bank'         => 'data_bank'
		];
	}

    function index($slug='') {
        $this->load->library('asset');
        $kode_tipe  = ['-','+'];

        $data           = get_data('tbl_form','slug',$slug)->row_array();
        $id_form        = isset($data['id']) ? $data['id'] : 0;
        $data['produk'] = get_data('tbl_form_produk a',[
            'select'    => 'a.id_produk, a.harga, a.harga_promo, b.nama AS nama_produk, b.foto AS foto_produk, b.berat AS berat_produk',
            'join'      => 'tbl_m_produk b ON a.id_produk = b.id',
            'where'     => 'a.id_form = "'.$id_form.'"',
            'sort_by'   => 'a.id'
        ])->result_array();
        if(isset($data['id']) && count($data['produk'])) {
            $data['ekspedisi']  = get_data('tbl_m_ekspedisi a',[
                'select'        => 'a.id,a.kode,a.nama_ekspedisi,a.logo',
                'join'          => 'tbl_form_ekspedisi b ON a.id = b.id_ekspedisi TYPE LEFT',
                'where'         => 'a.is_active = 1 AND b.id_form = '.$id_form
            ])->result_array();
            $data['provinsi']   = get_data('tbl_wil_provinsi','id_provinsi_ro != 0')->result_array();
            $ids                = [$id_form,$data['id_mitra'],rand()];
            $data['ref']        = encode_id($ids);
            $cod                = get_data('tbl_setting_cod',[
                'where'         => [
                    'is_active' => 1
                ],
                'sort_by'       => 'id'
            ])->result_array();
            $data['cod']    = [];
            if($data['kode_unik']) {
                $tipe_kode      = '';
                if(isset($kode_tipe[$data['tipe_kode_unik']])) {
                    $tipe_kode  = $kode_tipe[$data['tipe_kode_unik']];
                } else {
                    shuffle($kode_tipe);
                    $tipe_kode  = $kode_tipe[0];
                }
                $tk             = $tipe_kode == '-' ? -1 : 1;
                $min            = 0;
                $max            = 9;
                if($data['kode_unik'] == 2) {
                    $min        = 10;
                    $max        = 99;
                } elseif($data['kode_unik'] == 3) {
                    $min        = 100;
                    $max        = 999;
                }
                $data['kode_unik']  = $tk * rand($min,$max);
            }
            foreach($data['ekspedisi'] as $k => $v) {
                foreach($cod as $c) {
                    if($v['id'] == $c['id_ekspedisi']) {
                        $data['cod'][$v['id']]  = [
                            'bc'    => $c['biaya_cod'],
                            'bcm'   => $c['biaya_cod_minimal'],
                            'ba'    => $c['biaya_asuransi'],
                            'bam'   => $c['biaya_asuransi_minimal'],
                            'p'     => $c['pengali']
                        ];
                        continue 2;
                    }
                }
            }

            /* JIKA SUDAH PAKE MOOTA TINGGAL DI MARK AJA */
            $data['bank']   = get_data('tbl_form_bank a',[
                'select'    => 'b.id, b.nama_bank AS bank, b.no_rekening, b.atas_nama',
                'join'      => 'tbl_data_bank b ON a.id_bank = b.id',
                'where'     => 'a.id_form = "'.$id_form.'"'
            ])->result_array();

            if($data['layout']) $this->load->view('form_order_v1',$data);
            else $this->load->view('form_order',$data);
        } else {
            $this->load->view('errors/page_not_found');
        }
    }

    function layanan() {
        $id_kelurahan   = get('id_kelurahan') ? get('id_kelurahan') : 0;
        $berat          = get('berat') ? get('berat') : 1;
        $kode           = get('kode') ? get('kode') : 'none';

        $kelurahan      = get_data('tbl_wil_kelurahan','id',$id_kelurahan)->row();

        $this->load->library('ongkir',['key' => setting('key_rajaongkir')]);
        $rajaongkir     = $this->ongkir->getCost(setting('id_kecamatan_kirim'),$kelurahan->id_kecamatan_ro,$berat,$kode);
        if($rajaongkir['status']['code'] != '200') {
            ?><div class="alert alert-info">
                <div class="font-weight-bold mb-1 size-110">Informasi</div>
                <div>Pengiriman dengan ekspedisi yang dipilih tidak tersedia.</div>
            </div><?php
        } else {
            $cost   = $rajaongkir['results'];
            if(is_array($cost)) {
                ?><div class="row mb-3">
                    <?php $x=0; for ($k=0; $k < count($cost); $k++) {
                    for ($l=0; $l < count($cost[$k]['costs']); $l++) { ?>
                    <div class="col-sm-6 mb-3">
                        <div class="custom-control custom-radio radio-box h-100">
                            <input type="radio" class="custom-control-input" id="layanan<?php echo $x; ?>" name="layanan" value="<?php echo $cost[$k]['costs'][$l]['service']; ?>" data-harga="<?php echo $cost[$k]['costs'][$l]['cost'][0]['value']; ?>" <?php if($x==0) echo 'checked'; ?>>
                            <label class="custom-control-label" for="layanan<?php echo $x; ?>">
                                <div class="font-weight-bold size-75 text-grey"><?php echo $cost[$k]['costs'][$l]['service']; ?></div>
                                <div class="font-weight-bold size-110 text-2line"><?php echo $cost[$k]['costs'][$l]['description']; ?></div>
                                <div class="text-success">Rp <?php echo custom_format($cost[$k]['costs'][$l]['cost'][0]['value']); ?></div>
                            </label>
                        </div>
                    </div>
                    <?php $x++; }} ?>
                </div><?php
            } else {
                ?><div class="alert alert-info">
                    <div class="font-weight-bold mb-1 size-110">Informasi</div>
                    <div>Pengiriman dengan ekspedisi yang dipilih tidak tersedia.</div>
                </div><?php
            }
        }
    }

    function checkout() {
        $id_produk      = post('id_produk');
        $jumlah         = post('jumlah');
        $data           = post();
        unset($data['price']);
        unset($data['ref']);

        if(isset($data['no_telp']) && $data['no_telp']) {
            $data['no_telp']	= str_replace(['(',')',' ','-'],'',$data['no_telp']);
            if(substr($data['no_telp'],0,3) == '+62') $data['no_telp'] = substr($data['no_telp'],1);
            else if(substr($data['no_telp'],0,1) == '0') $data['no_telp'] = '62' . substr($data['no_telp'],1);
            else if(substr($data['no_telp'],0,2) != '62') $data['no_telp'] = '62' . $data['no_telp'];
        }

        $check          = get_data('tbl_blok_nomor','no_hp',$data['no_telp'])->row();
        if(isset($check->id)) {
            header('Content-Type: application/json');
            echo json_encode([
                'status'    => 'failed',
                'message'   => 'Maaf, Anda tidak dapat melakukan pemesanan.'
            ]);
            die;
        }

        if(is_array($id_produk) && count($id_produk) > 0) {
            $price          = decode_id(post('price'));
            $ref            = decode_id(post('ref'));
            if(count($price) != 2 && count($price) != 4) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status'    => 'failed',
                    'message'   => 'Data pemesanan tidak valid'
                ]);
                die;
            }
            $data['id_form']        = $ref[0];
            $data['id_mitra']       = $ref[1];
            if($data['id_mitra'] == 0) {
                $data['mitra']      = 'INTERNAL';
            } else {
                $m                  = get_data('tbl_user','id',$data['id_mitra'])->row();
                $data['mitra']      = isset($m->id) ? $m->nama : '';
            }
            $cek_form               = get_data('tbl_form',[
                'where' => [
                    'id'            => $data['id_form'],
                    'is_active'     => 1
                ]
            ])->row();
            if(!isset($cek_form->id)) {
                header('Content-Type: application/json');
                echo json_encode([
                    'status'    => 'failed',
                    'message'   => 'Data pemesanan tidak valid'
                ]);
                die;
            } else {
                $data['judul_form'] = $cek_form->judul;
                $data['_key']       = $cek_form->_key;
                $data['id_brand']   = $cek_form->id_brand;
                $data['brand']      = $cek_form->brand;
            }
            $ekspedisi              = get_data('tbl_m_ekspedisi','id',$data['id_ekspedisi'])->row();
            $data['kode_ekspedisi'] = isset($ekspedisi->id) ? $ekspedisi->kode : '';
            $data['nama_ekspedisi'] = isset($ekspedisi->id) ? $ekspedisi->nama_ekspedisi : '';
            $data['harga']          = $price[0];
            $data['ongkir']         = $price[1];
            $data['biaya_cod']      = 0;
            $data['biaya_asuransi'] = 0;
            if($data['metode_pembayaran'] == 'cod') {
                $check_cod  = get_data('tbl_setting_cod','id_ekspedisi',$data['id_ekspedisi'])->row();
                if(!isset($check_cod)) {
                    header('Content-Type: application/json');
                    echo json_encode([
                        'status'    => 'failed',
                        'message'   => 'Ekspedisi yang dipilih tidak mendukung metode pembayaran COD'
                    ]);
                    die;
                } else {
                    $param  = $check_cod->pengali == 1 ? $data['harga'] + $data['ongkir'] : $data['harga'];

                    $data['biaya_cod']  = ($check_cod->biaya_cod / 100) * $param;
                    if($data['biaya_cod'] < $check_cod->biaya_cod_minimal) $data['biaya_cod'] = $check_cod->biaya_cod_minimal;

                    $data['biaya_asuransi'] = ($check_cod->biaya_asuransi / 100) * $param;
                    if($data['biaya_asuransi'] < $check_cod->biaya_asuransi_minimal) $data['biaya_asuransi'] = $check_cod->biaya_asuransi_minimal;
                }
                $data['kode_unik']  = 0;
            }

            $data['total']          = $data['kode_unik'] + $data['harga'] + $data['ongkir'] + $data['biaya_cod'] + $data['biaya_asuransi'];

            if($data['id_mitra']) {
                $mitra  = get_data('tbl_user','id',$data['id_mitra'])->row();
                if(isset($mitra->id)) {
                    $data['_key']   = $mitra->_key;
                    $data['mitra']  = $mitra->nama;
                }
            }

            if($data['metode_pembayaran'] == 'cod') {
                $data['id_bank']                = 0;
                $find_cod                       = get_data('tbl_setting_cod','id_ekspedisi',$data['id_ekspedisi'])->row();
                if(isset($find_cod->id)) {
                    $data['id_metode_pemesanan']    = $find_cod->id;
                    $data['metode_pemesanan']       = $find_cod->judul;
                    $data['id_bank']                = $find_cod->id_data_bank;
                }
            } else {
                $data['id_metode_pemesanan']    = 0;
                $data['metode_pemesanan']       = 'Reguler';
            }

            $rotate_cs  = false;
            $r_cs   = get_data('tbl_form_cs',[
                'where' => [
                    'id_form'   => $data['id_form']
                ],
                'sort_by'   => 'jumlah'
            ])->row();
            if($r_cs->id_cs) {
                $data['id_cs']  = $r_cs->id_cs;
                $rotate_cs      = true;
            } else {
                $data['id_cs']  = $data['id_mitra'];
            }

            $pengirim       = get_data('tbl_m_data_pengirim',[
                'where'     => [
                    'id_user'   => $data['id_cs'],
                    'id_brand'  => [0,$data['id_brand']],
                    '_key'      => $data['_key']
                ],
                'sort_by'       => 'id_brand',
                'sort'          => 'desc',
                'limit'         => 1
            ])->row();

            $wa_api_key                     = '';
            if(isset($pengirim->id)) {
                $data['id_pengirim']        = $pengirim->id;
                $data['nama_pengirim']      = $pengirim->nama;
                $data['no_telp_pengirim']   = $pengirim->no_telp;
                $data['alamat_pengirim']    = $pengirim->alamat;
                $wa_api_key                 = $pengirim->api_key;
            }

            $kelurahan 		= get_data('tbl_wil_kelurahan a',[
                'select'	=> 'a.id AS id_kelurahan, a.kelurahan, a.kd_pos, b.id AS id_kecamatan, b.kecamatan, c.id AS id_kota, c.kabupaten_kota, d.id AS id_provinsi, d.provinsi',
                'join'		=> [
                    'tbl_wil_kecamatan b ON a.kecamatan_id = b.id TYPE LEFT',
                    'tbl_wil_kabkot c ON b.kabkot_id = c.id TYPE LEFT',
                    'tbl_wil_provinsi d ON c.provinsi_id = d.id TYPE LEFT',
                ],
                'where'		=> [
                    'a.id'	=> $data['id_kelurahan']
                ]
            ])->row();

            $data['alamat_full']	= $data['alamat'];
            if(isset($kelurahan->id_kelurahan)) {
                $data['id_provinsi']	= $kelurahan->id_provinsi;
                $data['id_kota']		= $kelurahan->id_kota;
                $data['id_kecamatan']	= $kelurahan->id_kecamatan;
                $data['id_kelurahan']	= $kelurahan->id_kelurahan;
                $data['provinsi']		= $kelurahan->provinsi;
                $data['kota']			= $kelurahan->kabupaten_kota;
                $data['kecamatan']		= $kelurahan->kecamatan;
                $data['kelurahan']		= $kelurahan->kelurahan;
                $data['kode_pos']		= $kelurahan->kd_pos;

                $data['alamat_full']	.= ', '.$data['kelurahan'].', '.$data['kecamatan']."\n".$data['kota'].', '.$data['provinsi'].', '.$data['kode_pos'];
            } else {
                unset($data['id_kelurahan']);
            }
            
            $data['nomor']          = 'P' . strtotime(date('Y-m-d H:i:s')) . rand(10,99);
            $data['create_at']      = date('Y-m-d H:i:s');

            $save                   = insert_data('tbl_prospek',$data);
            if($save) {
                $j                  = 0;
                foreach($id_produk as $k => $v) {
                    $produk     = get_data('tbl_m_produk','id',$v)->row();
                    $form_produk= get_data('tbl_form_produk',[
                        'where' => [
                            'id_form'   => $data['id_form'],
                            'id_produk' => $v
                        ]
                    ])->row();
                    $harga      = 0;
                    if(isset($form_produk->id)) {
                        $harga  = $form_produk->harga_promo ? $form_produk->harga_promo : $form_produk->harga;
                    }
                    if(isset($data['kode_unik']) && $data['kode_unik'] && $j == 0) {
                        $kd_u   = $data['kode_unik'] / $jumlah[$k];
                        $harga  += $kd_u;
                    }
                    insert_data('tbl_prospek_detail',[
                        'id_produk'     => $v,
                        'id_prospek'    => $save,
                        'produk'        => isset($produk->nama) ? $produk->nama : '',
                        'jumlah'        => $jumlah[$k],
                        'harga'         => $harga
                    ]);
                    $j++;
                }
                insert_data('tbl_notifikasi',[
                    'title'         => 'Prospek Pesanan',
                    'description'   => 'Prosepek #'.$data['nomor'].' membutuhkan tindaklanjut',
                    'notif_link'    => base_url('transaksi/prospek/detail/'.encode_id($save)),
                    'notif_date'    => date('Y-m-d H:i:s'),
                    'notif_type'    => 'info',
                    'notif_icon'    => 'fa-shopping-basket',
                    'transaksi'     => 'prospek',
                    'id_user'       => $data['id_cs'],
                    'id_transaksi'  => $save
                ]);
                if($rotate_cs) {
                    $cs_form        = get_data('tbl_form_cs',[
                        'id_form'   => $data['id_form'],
                        'id_cs'     => $data['id_cs']
                    ])->row();
                    if(isset($cs_form->id)) {
                        update_data('tbl_form_cs',[
                            'jumlah'    => $cs_form->jumlah + 1
                        ],'id',$cs_form->id);
                    }
                }

                // SIMPAN QUEUE WA
                if($wa_api_key) {
                    $template_wa   = get_data('tbl_template_wa',[
                        'where' => [
                            'id_produk'     => -1,
                            'id_kategori'   => $data['metode_pembayaran'] == 'cod' ? 1000 : [1000,2000,3000,4000,5000]
                        ]
                    ])->result();
                    if(count($template_wa) > 0) {
                        $prospek        = get_data('tbl_prospek','id',$save)->row_array();
                        $bank           = get_data('tbl_form_bank a',[
                            'select'    => 'b.*',
                            'join'      => 'tbl_data_bank b ON a.id_bank = b.id TYPE LEFT',
                            'where'     => [
                                'a.id_form' => $prospek['id_form'],
                                'b.id'      => $prospek['id_bank']
                            ]
                        ])->result();
                        $detail         = get_data('tbl_prospek_detail','id_prospek',$save)->result();
                        $prospek['mitra']           = $prospek['mitra'] ?: $prospek['brand'].' Official';
                        $prospek['harga']           = custom_format($prospek['harga']);
                        $prospek['ongkir']          = custom_format($prospek['ongkir']);
                        $prospek['biaya_cod']       = custom_format($prospek['biaya_cod']);
                        $prospek['biaya_asuransi']  = custom_format($prospek['biaya_asuransi']);
                        $prospek['total']           = custom_format($prospek['total']);
                        $prospek['data_bank']       = "";
                        $prospek['detail_pesanan']  = "";
                        foreach($bank as $b) {
                            $prospek['data_bank']   .= "Bank : *".$b->nama_bank."*\nNo.Rekening : *".$b->no_rekening."*\na.n : *".$b->atas_nama."*\n\n";
                        }
                        foreach($detail as $d) {
                            $prospek['detail_pesanan']   .= "Produk/Paket : ".$d->produk."\nQty : ".$d->jumlah."\nHarga Satuan : ".custom_format($d->harga)."\n\n";
                        }

                        foreach($template_wa as $t_wa) {
                            if($t_wa->konten) {        
                                $konten = $t_wa->konten;
                                if(strpos($konten,'[COD]') !== false && strpos($konten,'[/COD]') !== false 
                                    && strpos($konten,'[TRANSFER]') !== false && strpos($konten,'[/TRANSFER]') !== false) {
                                    $metode = $prospek['metode_pembayaran'] == 'transfer' ? 'TRANSFER' : 'COD';
                                    $konten = string_between($konten, '['.$metode.']', '[/'.$metode.']');
                                } else {
                                    $konten = str_replace(['[COD]','[/COD]','[TRANSFER]','[/TRANSFER]'],'',$konten);
                                }
                    
                                foreach($prospek as $k => $v) {
                                    if(isset($this->variable[$k])) {
                                        $konten = str_replace('{{'.$this->variable[$k].'}}',$v,$konten);
                                    }
                                }

                                $tanggal_kirim  = date('Y-m-d H:i:s');
                                if($t_wa->hari) {
                                    $jam_kirim      = $t_wa->jam == '00:00:00' ? date('H:i:s') : $t_wa->jam;
                                    $tanggal_kirim  = date('Y-m-d',strtotime('+'.$t_wa->hari.' days')).' '.$jam_kirim;
                                }

                                insert_data('tbl_antrian_wa',[
                                    'api_key'       => $wa_api_key,
                                    'no_telp'       => $prospek['no_telp'],
                                    'pesan'         => $konten,
                                    'tanggal_kirim' => $tanggal_kirim,
                                    'ref'           => 'prospek',
                                    'id_ref'        => $prospek['id']
                                ]);
                            }
                        }
                    }
                }

                header('Content-Type: application/json');
                echo json_encode([
                    'status'    => 'success',
                    'message'   => 'Pemesanan berhasil dibuat',
                    'href'      => base_url('payment/'.$data['nomor']).'?rel='.$cek_form->tipe_redirect
                ]);
                die;
            } else {
                header('Content-Type: application/json');
                echo json_encode([
                    'status'    => 'failed',
                    'message'   => 'Pemesanan gagal dibuat'
                ]);
                die;
            }
        } else {
            header('Content-Type: application/json');
            echo json_encode([
                'status'    => 'failed',
                'message'   => 'Anda belum memilih produk.'
            ]);
            die;
        }
    }

    function payment($nomor='') {
        $data   = get_data('tbl_prospek','nomor',$nomor)->row_array();
        $this->load->library('asset');
        if(isset($data['id'])) {
            $data['rel']        = get('rel');
            $data['form']       = get_data('tbl_form','id',$data['id_form'])->row_array();
            $cs                 = get_data('tbl_user','id',$data['id_cs'])->row_array();
            $data['redirect']   = '';
            $data['no_cs']      = '';
            if(isset($cs['telepon'])) {
                $data['no_cs']      = 'https://web.whatsapp.com/send?phone='.$cs['telepon'].'&text='.urlencode("Halo ka, untuk pesanan *".$nomor."* bagaimana ya?");
            }
            if($data['rel'] == 1 && isset($cs['telepon'])) {
                $data['redirect']   = 'https://web.whatsapp.com/send?phone='.$cs['telepon'].'&text='.urlencode("Halo ka, untuk pesanan *".$nomor."* bagaimana ya?");
            } elseif($data['rel'] == 1 && isset($data['form']['link_redirect'])) {
                $data['redirect']   = $data['form']['link_redirect'];
            }
            $data['bank']   = get_data('tbl_form_bank a',[
                'select'    => 'b.nama_bank AS bank, b.no_rekening, b.atas_nama',
                'join'      => 'tbl_data_bank b ON a.id_bank = b.id',
                'where'     => 'a.id_form = "'.$data['id_form'].'" AND b.id = "'.$data['id_bank'].'"'
            ])->result_array();
            $this->load->view('payment',$data);
        } else {
            $this->load->view('errors/page_not_found');
        }
    }

}