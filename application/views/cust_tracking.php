<div class="table-responsive mb-3">
    <table class="table table-bordered table-detail">
        <tr>
            <th width="200"><?php echo lang('ekspedisi'); ?></th>
            <td><?php echo $summary['courier_name']; ?></td>
        </tr>
        <tr>
            <th><?php echo lang('status'); ?></th>
            <td><?php echo $summary['status']; ?></td>
        </tr>
    </table>
</div>
<div class="table-responsive">
    <table class="table table-bordered table-detail">
        <?php foreach($manifest as $m) { ?>
        <tr>
            <th width="200"><?php echo c_date($m['manifest_date'].' '.$m['manifest_time']); ?></th>
            <td><?php echo $m['manifest_description'].' '.$m['city_name']; ?></td>
        </tr>
        <?php } ?>
    </table>
</div>