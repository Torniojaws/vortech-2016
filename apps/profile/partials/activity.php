<div class="col-sm-12">
    <span class="text-muted"><?php echo date('Y, M j - H:i', strtotime($activity['date_commented'])); ?></span> in <strong><?php echo $activity['target']; ?></strong>: 
    <span class="text-info"><?php echo $activity['comment']; ?></span>
</div>
