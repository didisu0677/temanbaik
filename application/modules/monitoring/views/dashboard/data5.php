<tr>
<td colspan="6" style="background-color: #eeeeee; color: black;">Sisa Masa Tahanan 1 Bulan</td>	
</tr>	

<?php foreach($data_napier as $s) { ?>
<?php if($s->sisa_masa_tahanan =='<= 1 Bulan') {?>
<?php $no++ ; 
?>
<tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $s->nama; ?></td>
    <td><?php echo $s->alias; ?></td>
    <td><?php echo $s->alamat_ktp; ?></td>
    <td><?php echo $s->tanggal_lahir; ?></td>
    <td><?php echo $s->tanggal_vonis; ?></td>
</tr>
<?php }} ?>

<tr>
<td colspan="6" style="background-color: #eeeeee; color: black;">Sisa Masa Tahanan 1 Tahun</td>	
</tr>	
<?php $no =0 ; ?>
<?php foreach($data_napier as $s) { ?>
<?php if($s->sisa_masa_tahanan =='<= 1 Tahun') {?>
<?php $no++ ; 
?>
<tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $s->nama; ?></td>
    <td><?php echo $s->alias; ?></td>
    <td><?php echo $s->alamat_ktp; ?></td>
    <td><?php echo $s->tanggal_lahir; ?></td>
    <td><?php echo $s->tanggal_vonis; ?></td>    
</tr>
<?php }} ?>

<tr>
<td colspan="6" style="background-color: #eeeeee; color: black;">Sisa Masa Tahanan Di Atas 1 Tahun</td>	
</tr>	
<?php $no =0 ; ?>
<?php foreach($data_napier as $s) { ?>
<?php if($s->sisa_masa_tahanan =='> 1 Tahun') {?>
<?php $no++ ; 
?>
<tr>
    <td><?php echo $no; ?></td>
    <td><?php echo $s->nama; ?></td>
    <td><?php echo $s->alias; ?></td>
    <td><?php echo $s->alamat_ktp; ?></td>
    <td><?php echo $s->tanggal_lahir; ?></td>
    <td><?php echo $s->tanggal_vonis; ?></td>
</tr>
?>
<?php
}} ?>