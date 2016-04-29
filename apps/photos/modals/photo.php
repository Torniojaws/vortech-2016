<!-- Modal contents -->
<div class="modal fade" id="photo-modal<?php echo $photo['id']; ?>" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $photo['name'].' - '.$photo['date_taken']; ?></h4>
            </div>
            <div class="modal-body text-center">
                <img src="static/img/<?php echo strtolower($photo['name_id']).'/';
                echo $photo['full']; ?>" alt="<?php echo $photo['caption']; ?>" />
                <p><?php echo $photo['caption']; ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
