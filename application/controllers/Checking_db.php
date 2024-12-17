<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checking_db extends BE_Controller {

	function __construct() {
		parent::__construct();
    }
    
    function save_structure($p = false) {
        $tables = list_tables();
        $data   = [];
        foreach($tables as $table) {
            $data[$table]   = [];
            $fields = get_field($table);
            foreach($fields as $field) {
                $data[$table][$field->name] = [
                    'type'      => $field->type,
                    'length'    => $field->max_length
                ];
            }
        }
        $filename       = $p ? 'db_2.txt' : 'db_1.txt';
        $full_filename  = FCPATH . $filename;
        $handle         = fopen ($full_filename, "wb");
        if($handle) {
            fwrite ( $handle, json_encode($data) );
        }
        fclose($handle);
        $oldmask = umask(0);
        chmod($full_filename, 0777);
        umask($oldmask);
    }

    function find_diff() {
        $db1    = json_decode(file_get_contents(FCPATH . 'db_1.txt'),true);
        $db2    = json_decode(file_get_contents(FCPATH . 'db_2.txt'),true);

        $new_table  = [];
        $diff_field = [];
        foreach($db1 as $tbl1 => $d1) {
            $new    = true;
            foreach($db2 as $tbl2 => $d2) {
                if($tbl1 == $tbl2) $new = false;
            }
            if($new) {
                $new_table[]    = $tbl1;
            } else {
                foreach($db1[$tbl1] as $field1 => $struc1) {
                    $change_field  = true;
                    foreach($db2[$tbl1] as $field2 => $struc2) {
                        if($field1 == $field2 && $struc1['type'] == $struc2['type'] && $struc1['length'] == $struc2['length']) {
                            $change_field = false;
                        }
                    }
                    if($change_field) {
                        $diff_field[$tbl1][] = [
                            'field_name'    => $field1,
                            'type'          => $struc1['type'],
                            'length'        => $struc1['length']
                        ];
                    }
                }
            }
        }

        ?>
        <h4>TABEL BARU</h4>
        <table border="1" cellspacing="0" cellpadding="0" width="100%">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 5px 10px;">NAMA TABEL</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($new_table as $nt) { ?>
                <tr>
                    <td style="text-align: left; padding: 5px 10px;"><?php echo $nt; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <br />
        <br />

        <h4>PENAMBAHAN / PERUBAHAN FIELD</h4>
        <table border="1" cellspacing="0" cellpadding="0" width="100%">
            <thead>
                <tr>
                    <th style="text-align: left; padding: 5px 10px;">NAMA FIELD</th>
                    <th style="text-align: left; padding: 5px 10px;">TYPE</th>
                    <th style="text-align: left; padding: 5px 10px;">LENGTH</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($diff_field as $tbl => $field) { ?>
                <tr>
                    <td colspan="3" style="text-align: left; padding: 5px 10px; color: #fff; background: #000;"><?php echo $tbl; ?></td>
                </tr>
                <?php foreach($field as $f) { ?>
                <tr>
                    <td style="text-align: left; padding: 5px 10px;"><?php echo $f['field_name']; ?></td>
                    <td style="text-align: left; padding: 5px 10px;"><?php echo $f['type']; ?></td>
                    <td style="text-align: left; padding: 5px 10px;"><?php echo $f['length']; ?></td>
                </tr>
                <?php }} ?>
            </tbody>
        </table>
        <?php        
    }
}