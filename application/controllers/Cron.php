<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends MY_Controller {

    protected $negara        = [];
    protected $pelabuhan     = [];

    function __construct() {
        parent::__construct();
        $negara     = get_data('tbl_m_negara')->result();
        foreach($negara as $n) {
            $this->negara[$n->kode]    = $n->negara;
        }

        $pelabuhan     = get_data('tbl_m_pelabuhan')->result();
        foreach($pelabuhan as $n) {
            $this->pelabuhan[$n->kode]    = $n->pelabuhan;
        }
    }
    
    function backup($tipe = 'all') {
		ini_set('memory_limit', '-1');

        if(in_array($tipe, ['all','db'])) {
            $backupdir = FCPATH . 'assets/backup/backup_'.date('Y_m_d_h_i');
            if(!is_dir($backupdir)) mkdir($backupdir, 0777, true);
            
            $table = db_list_table();
            $this->load->dbutil();
            $this->load->helper('file');
            foreach($table as $t) {
                $prefs = array(
                    'tables'      => array($t),
                    'format'      => 'sql',
                    'filename'    => $t.'.sql'
                );
                $backup		= $this->dbutil->backup($prefs);
                $db_name 	= $t.'.sql';
                $save 		= $backupdir.'/'.$db_name;
                write_file($save, $backup);
            }
        }
        if(in_array($tipe, ['all','file'])) {
            $conf       = [
                'src'       => FCPATH . 'assets/uploads/',
                'dst'       => FCPATH . 'assets/backup/',
                'filename'  => 'backup_file_'.date('Y_m_d_h_i')
            ];
            $this->load->library('Rzip',$conf);
            $this->rzip->compress();
        }
    }

    function remote_file($periode='') {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');
        
        $protocol   = setting('ftp_protocol');
        $host       = setting('ftp_host');
        $port       = setting('ftp_port') ? setting('ftp_port') : 22;
        $username   = setting('ftp_user');
        $password   = setting('ftp_pass');
        $new_only   = $periode ? false : true;
        $periode    = $periode ?: date('Ymd');

        $allowed_filename = [
            'ijin-pib'      => 'tbl_ijin_pib',
            'header-pib'    => 'tbl_header_pib',
            'detail-pib'    => 'tbl_detail_pib'
        ];

        if(!in_array($protocol,['ftp','sftp'])) {
            log_message('error', '[remote file] Protokol tidak valid'); die;
        }

        if($protocol == 'ftp') {
            if(!function_exists('ftp_connect')) {
                log_message('error', '[remote file] Protokol FTP tidak aktif karena php_ftp tidak ter-install atau tidak diaktifkan');
                die;
            }

            $conn_id        = @ftp_connect($host);
            if(!$conn_id) {
                log_message('error', '[remote file] Koneksi Gagal');
                die;
            }

            if(! @ftp_login($conn_id, $username, $password)) {
                log_message('error', '[remote file] Otentifikasi Username dan Password Gagal');
                ftp_close($conn_id);
                die;
            }

            ftp_pasv($conn_id, true);

            // ambil data ftp
            // if (! @ftp_get($conn_id, $save_as, $filename, FTP_BINARY)) {
            //     log_message('error', '[remote file] Tidak bisa membaca file '.$filename);
            // }

            // if (! @ftp_get($conn_id, $save_as2, $filename2, FTP_BINARY)) {
            //     log_message('error', '[remote file] Tidak bisa membaca file '.$filename2);
            // }

            ftp_close($conn_id);
        } elseif($protocol == 'sftp') {
            if(!function_exists('ssh2_connect')) {
                log_message('error', '[remote file] Protokol SFTP tidak aktif karena php_ssh2 tidak ter-install atau tidak diaktifkan');
                die;
            }

            $connection = @ssh2_connect($host, $port);
            if(!$connection) {
                log_message('error', '[remote file] Koneksi Gagal'); die;
            }

            if(! @ssh2_auth_password($connection, $username, $password) ) {
                log_message('error', '[remote file] Otentifikasi Username dan Password Gagal'); die;
            }

            $sftp = @ssh2_sftp($connection);
            if(!$sftp) {
                log_message('error', '[remote file] Tidak bisa menginisiasi Sub-Sitem SFTP'); die;
            }

            $_fields = [
                'ijin-pib'  => [
                    'id_ijin','kd_ijin','no_ijin','tgl_ijin','kd_ijin_rekom',
                    'no_ijin_rekom','tgl_ijin_rekom','npwp','nm_trader'
                ],
                'header-pib'    => [
                    'cusdecid','car','pibno','pibtg','sppbtg','impnpwp','impnama','impalmt',
                    'kdkpbc','urkdkpbc','pelmuat','peltransit','pelbkr','jnsdok'    
                ],
                'detail-pib'    => [
                    'cusdecid','serial','nohs','kondisibrg','kd_komoditi','brgurai','ur_brg_skep',
                    'brgasal','kdsat','jmlsat','kemasjn','kemasjm','statusijin','id_ijin','wk_realisasi','netto'    
                ]
            ];

            $sftp_fd    = intval($sftp);
            if($periode == 'init') {

                $dir_loc    = "ssh2.sftp://$sftp_fd/kominfo/PostBorder/";
                $handle     = @opendir($dir_loc);
                $dirs       = [];
                while(false != ($dir = @readdir($handle))) {
                    if($dir != '..' && $dir != '.') {
                        $dirs[] = $dir;
                    }
                }
                sort($dirs);

                foreach($dirs as $dir) {
                    $file_loc   = "ssh2.sftp://$sftp_fd/kominfo/PostBorder/$dir/";
                    $handle     = @opendir($file_loc);
                    $files      = [];
                    while(false != ($file = @readdir($handle))) {
                        $keyname   = '';
                        foreach($allowed_filename as $_keyname => $table) {
                            if(strpos($file,$_keyname) !== false) {
                                $keyname    = $_keyname;
                            }
                        }
                        if($keyname) {
                            $stream = @fopen($file_loc.$file, 'r');
                            if (! $stream) {
                                log_message('error', '[remote file] Tidak bisa membaca file '.$file);
                            }
                            $contents   = fread($stream, filesize($file_loc.$file));
                            $contents   = str_replace('| ', "|\n",$contents);
                            $fields     = $_fields[$keyname];
                            $data       = explode("\n", $contents);
                            foreach($data as $urutan => $d) {
                                if($urutan > 0) {
                                    $_data = explode('|',substr($d, 0, -1));

                                    // DATA DETAIL KADANG SUKA ADA TANDA | JADI HARUS DI INDEX ULANG
                                    if($keyname == 'detail-pib' && count($_data) > 16) {
                                        $merge  = [];
                                        for($ii=5; $ii<=(count($_data) - 10); $ii++) {
                                            $merge[] = $_data[$ii];
                                            if($ii != 5) {
                                                unset($_data[$ii]);
                                            }
                                        }
                                        $_data[5]   = _implode('|',$merge);
                                        $_data = array_values($_data);
                                    }

                                    $record = [];
                                    foreach($_data as $k => $dt) {
                                        if(isset($fields[$k])) {
                                            if(in_array($fields[$k],[
                                                'tgl_ijin', 'tgl_ijin_rekom', 'wk_realisasi', 'pibtg', 'sppbtg'
                                            ])) {
                                                $record[$fields[$k]]    = $this->normalisasi($dt);
                                            } else {
                                                $record[$fields[$k]]    = $dt;
                                            }
                                        }
                                    }
                                    if(count($fields) == count($record)) {
                                        $table  = $allowed_filename[$keyname];
                                        $check  = get_data($table,[
                                            'where' => $record
                                        ])->row_array();
        
                                        if(!isset($check['id'])) {
                                            $record['uploaded_by']   = 'cronjob';
                                            $record['uploaded_at']   = date('Y-m-d H:i:s');
                                            insert_data($table,$record);
                                        }
                                    }
                                }
                            }
                            @fclose($stream);        
                        }
                    }    
                }

            } else {

                $file_loc   = "ssh2.sftp://$sftp_fd/kominfo/PostBorder/$periode/";
                $handle     = @opendir($file_loc);
                $files      = [];
                while(false != ($file = @readdir($handle))) {

                    $keyname   = '';
                    foreach($allowed_filename as $_keyname => $table) {
                        if(strpos($file,$_keyname) !== false) {
                            $keyname    = $_keyname;
                        }
                    }
                    if($keyname) {
                        $files[$keyname][]  = $file;
                    }

                }

                foreach($files as $k => $f) {
                    sort($files[$k]);
                }

                if($new_only) {
                    $_files = $files;
                    $files  = [];
                    foreach($_files as $k => $f) {
                        $files[$k][]    = end($f);
                    }
                }

                foreach($files as $keyname => $arr_file) {
                    foreach($arr_file as $filename) {
                        $stream = @fopen($file_loc.$filename, 'r');
                        if (! $stream) {
                            log_message('error', '[remote file] Tidak bisa membaca file '.$filename);
                        }
                        $contents   = fread($stream, filesize($file_loc.$filename));
                        $contents   = str_replace('| ', "|\n",$contents);
                        $fields     = $_fields[$keyname];
                        $data       = explode("\n", $contents);
                        foreach($data as $urutan => $d) {
                            if($urutan > 0) {
                                $_data = explode('|',substr($d, 0, -1));

                                // DATA DETAIL KADANG SUKA ADA TANDA | JADI HARUS DI INDEX ULANG
                                if($keyname == 'detail-pib' && count($_data) > 16) {
                                    $merge  = [];
                                    for($ii=5; $ii<=(count($_data) - 10); $ii++) {
                                        $merge[] = $_data[$ii];
                                        if($ii != 5) {
                                            unset($_data[$ii]);
                                        }
                                    }
                                    $_data[5]   = _implode('|',$merge);
                                    $_data = array_values($_data);
                                }
                                $record = [];
                                foreach($_data as $k => $dt) {
                                    if(isset($fields[$k])) {
                                        if(in_array($fields[$k],[
                                            'tgl_ijin', 'tgl_ijin_rekom', 'wk_realisasi', 'pibtg', 'sppbtg'
                                        ])) {
                                            $record[$fields[$k]]    = $this->normalisasi($dt);
                                        } else {
                                            $record[$fields[$k]]    = $dt;
                                        }
                                    }
                                }
                                if(count($fields) == count($record)) {
                                    $table  = $allowed_filename[$keyname];
                                    $check  = get_data($table,[
                                        'where' => $record
                                    ])->row_array();

                                    if(!isset($check['id'])) {
                                        if($keyname == 'detail-pib') {
                                            $record['brgasal_desc'] = isset($this->negara[$record['brgasal']]) ? $this->negara[$record['brgasal']] : $record['brgasal'];
                                        }
                                        $record['uploaded_by']   = 'cronjob';
                                        $record['uploaded_at']   = date('Y-m-d H:i:s');
                                        insert_data($table,$record);
                                    }
                                }
                            }
                        }
                        @fclose($stream);
                    }
                }
            }
        }

        $this->sync_data($periode);
    }

    function get_api($tipe='') {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');
        $arr    = [
            'sertifikat_berlaku',
            'sertifikat_tidak_berlaku',
            'pencabutan_sertifikat'
        ];
        if(in_array($tipe,$arr)) {
            $arr    = [$tipe];
        }

        foreach($arr as $a) {
            $url        = setting('api_'.$a);
            $username   = setting('api_user');
            $password   = setting('api_pass');

            if($url && $username && $password) {
                $data = $this->curl_data($url, $username, $password);
                if(isset($data['DATASERTIFIKASI'])) {
                    delete_data('tbl_sertifikat','label',$a);
                    $rec = [];
                    $i = 0;
                    foreach($data['DATASERTIFIKASI'] as $d) {
                        foreach($d as $k => $v) {
                            $rec[$i][strtolower($k)] = $v == null ? '' : $v;
                        }
                        if(count($rec[$i]) == 11) {
                            $rec[$i]['label']           = $a;
                            $rec[$i]['imported_by']     = 'cronjob';
                            $rec[$i]['imported_date']   = date('Y-m-d H:i:s');

                            update_data('tbl_detail_pib',[
                                'tgl_ijin'          => $rec[$i]['lic_date'],
                                'tgl_expired_ijin'  => $rec[$i]['exp_date'],
                                'keterangan_ijin'   => $rec[$i]['label']
                            ],'no_ijin',$rec[$i]['lic_no']);
                        }
                        $i++;
                    }
                    insert_batch('tbl_sertifikat',$rec);
                }
            }
        }
    }

    function sync_certificate($detail = []) {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '0');
        
        if(!isset($detail[0])) {
            $detail = get_data('tbl_detail_pib',[
                'select'    => 'id,impnama,brgurai',
                'where'     => 'no_ijin = ""'
            ])->result();
        }
        foreach($detail as $d) {
            $check_duplicate    = get_data('tbl_detail_pib',[
                'select'        => 'no_ijin, tgl_ijin, tgl_expired_ijin, keterangan_ijin, sync_by',
                'where'         => [
                    'impnama'       => $d->impnama,
                    'brgurai'       => $d->brgurai,
                    'no_ijin !='    => ''
                ],
                'limit'         => 1
            ])->row();
            if(isset($check_duplicate->no_ijin)) {
                update_data('tbl_detail_pib',[
                    'no_ijin'           => $check_duplicate->no_ijin,
                    'tgl_ijin'          => $check_duplicate->tgl_ijin,
                    'tgl_expired_ijin'  => $check_duplicate->tgl_expired_ijin,
                    'keterangan_ijin'   => $check_duplicate->keterangan_ijin,
                    'sync_by'           => $check_duplicate->sync_by,
                    'sync_date'         => date('Y-m-d H:i:s')
                ],'id',$d->id);
            } else {
                $nama_perusahaan    = trim(str_replace(['PT.','PT','CV','CV.'],'',$d->impnama));
                $sertifikat         = get_data('tbl_sertifikat',[
                    'where'         => 'nama_perusahaan LIKE "%'.$nama_perusahaan.'%"',
                    'sort_by'       => 'exp_date',
                    'sort'          => 'DESC'
                ])->result();
                $match_model        = [];
                $match_merk_model   = [];
                foreach($sertifikat as $s) {
                    if(strpos(strtoupper($d->brgurai), strtoupper($s->model)) !== false && strpos(strtoupper($d->brgurai), strtoupper($s->merk)) !== false) {
                        // cari model yg belakangnya spasi (contoh kasus yg di cari model T4U, biar yg model T4UH tidak masuk maka dilakukan pengecekan lagi)
                        $exp            = explode(strtoupper($s->model),strtoupper($d->brgurai));
                        $cek_model      = trim(substr($exp[1],0,1));
                        if(!$cek_model) {
                            $match_merk_model[] = [
                                'lic_no'    => $s->lic_no,
                                'lic_date'  => $s->lic_date,
                                'exp_date'  => $s->exp_date,
                                'label'     => $s->label
                            ];
                        }
                    }
                    if(strpos(strtoupper($d->brgurai), strtoupper($s->model)) !== false) {
                        $exp            = explode(strtoupper($s->model),strtoupper($d->brgurai));
                        $cek_model      = trim(substr($exp[1],0,1));
                        if(!$cek_model) {
                            $match_model[] = [
                                'lic_no'    => $s->lic_no,
                                'lic_date'  => $s->lic_date,
                                'exp_date'  => $s->exp_date,
                                'label'     => $s->label
                            ];
                        }
                    }
                }
                if(count($match_model) > 0) {
                    $verified   = count($match_merk_model) ? $match_merk_model : $match_model;
                    if(isset($verified[0])) {
                        update_data('tbl_detail_pib',[
                            'no_ijin'           => $verified[0]['lic_no'],
                            'tgl_ijin'          => $verified[0]['lic_date'],
                            'tgl_expired_ijin'  => $verified[0]['exp_date'],
                            'keterangan_ijin'   => $verified[0]['label'],
                            'label'             => 'SERTIFIKAT',
                            'sync_by'           => 'cronjob',
                            'sync_date'         => date('Y-m-d H:i:s')
                        ],'id',$d->id);
                    }
                }
            }
        }

        // cari brgurai yg tidak sama tetapi lisensi nya sama
        // untuk dihapus lagi no lisensi nyai, karena brgurai nya tidak sama
        $c = get_data('tbl_detail_pib a',[
            'join'  => 'tbl_detail_pib b ON a.no_ijin = b.no_ijin AND REPLACE(a.brgurai," ","") != REPLACE(b.brgurai," ","")',
            'where' => [
                'a.sync_by'     => 'cronjob',
                'b.sync_by'     => 'cronjob'
            ]
        ])->result();
        foreach($c as $z) {
            update_data('tbl_detail_pib',[
                'no_ijin'           => '',
                'tgl_ijin'          => '',
                'tgl_expired_ijin'  => '',
                'keterangan_ijin'   => '',
                'sync_by'           => '',
                'sync_date'         => date('Y-m-d H:i:s')
            ],'id',$z->id);
        }
    }

    protected function normalisasi($tanggal='') {
        $result = '';
        if(strlen($tanggal) == 8) {
            $result = substr($tanggal,0,4).'-'.substr($tanggal,4,2).'-'.substr($tanggal,6,2);
        } elseif(strlen($tanggal) == 14) {
            $result = substr($tanggal,0,4).'-'.substr($tanggal,4,2).'-'.substr($tanggal,6,2).' '.substr($tanggal,8,2).':'.substr($tanggal,10,2).':'.substr($tanggal,12,2);
        }
        return $result;
    }

    function sync_data($periode='') {
        if($periode == 'init') {
            $header = get_data('tbl_header_pib',[
                'select'    => 'impnpwp,impnama,impalmt,cusdecid,pibno,pelmuat,peltransit,pelbkr'
            ])->result();
            foreach($header as $h) {
                update_data('tbl_detail_pib',[
                    'impnpwp'           => $h->impnpwp,
                    'impnama'           => $h->impnama,
                    'impalmt'           => $h->impalmt,
                    'pibno'             => $h->pibno,
                    'pelmuat'           => $h->pelmuat,
                    'peltransit'        => $h->peltransit,
                    'pelbkr'            => $h->pelbkr,
                    'pelmuat_desc'      => isset($this->pelabuhan[$h->pelmuat]) ? $this->pelabuhan[$h->pelmuat] : $h->pelmuat,
                    'peltransit_desc'   => isset($this->pelabuhan[$h->peltransit]) ? $this->pelabuhan[$h->peltransit] : $h->peltransit,
                    'pelbkr_desc'       => isset($this->pelabuhan[$h->pelbkr]) ? $this->pelabuhan[$h->pelbkr] : $h->pelbkr
                ],'cusdecid',$h->cusdecid);
            }
            $ijin = get_data('tbl_ijin_pib',[
                'select'    => 'id_ijin,no_ijin,tgl_ijin'
            ])->result();
            foreach($ijin as $h) {
                update_data('tbl_detail_pib',[
                    'no_ijin'   => $h->no_ijin,
                    'tgl_ijin'  => $h->tgl_ijin,
                    'label'     => 'SERTIFIKAT'
                ],'id_ijin',$h->id_ijin);
            }
        } else {
            $detail = get_data('tbl_detail_pib','impnpwp = ""')->result();
            foreach($detail as $d) {
                $header = get_data('tbl_header_pib','cusdecid',$d->cusdecid)->row();
                $ijin   = get_data('tbl_ijin_pib','id_ijin',$d->id_ijin)->row();
                $update = [];
                if(isset($header->id)) {
                    $update['impnpwp']          = $header->impnpwp;
                    $update['impnama']          = $header->impnama;
                    $update['impalmt']          = $header->impalmt;
                    $update['pibno']            = $header->pibno;
                    $update['pelmuat']          = $header->pelmuat;
                    $update['peltransit']       = $header->peltransit;
                    $update['pelbkr']           = $header->pelbkr;
                    $update['pelmuat_desc']     = isset($this->pelabuhan[$header->pelmuat]) ? $this->pelabuhan[$header->pelmuat] : $header->pelmuat;
                    $update['peltransit_desc']  = isset($this->pelabuhan[$header->peltransit]) ? $this->pelabuhan[$header->peltransit] : $header->peltransit;
                    $update['pelbkr_desc']      = isset($this->pelabuhan[$header->pelbkr]) ? $this->pelabuhan[$header->pelbkr] : $header->pelbkr;
                }
                if(isset($ijin->id)) {
                    $update['no_ijin']  = $ijin->no_ijin;
                    $update['tgl_ijin'] = $ijin->tgl_ijin;
                    $update['label']    = 'SERTIFIKAT';
                }
                if(count($update)) {
                    update_data('tbl_detail_pib',$update,'id',$d->id);
                }
                if(!isset($ijin->id)) {
                    $sync[0]    = $d;
                    $this->sync_certificate($sync);
                }
            }
        }
    }

    protected function curl_data($url, $username, $password) {
        $data = 'username='.urlencode($username).'&password='.urlencode($password);
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT ,3);
        curl_setopt($ch,CURLOPT_TIMEOUT, 60);
        $response = curl_exec($ch);
        curl_close ($ch);
        return json_decode($response, true);
    }

}