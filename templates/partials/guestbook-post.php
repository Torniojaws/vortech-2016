<div class="row">
    <div class="col-sm-3">
        <img src="static/img/<?php echo $avatar['name_id'].'/'.$avatar['thumbnail']; ?>"
             alt="<?php echo $avatar['caption']; ?>" />
        <h4><?php echo $guest['name']; ?></h4>
        <small><?php echo $guest['posted']; ?></small>
    </div>
    <div class="col-sm-9">
        <p><?php echo $guest['post']; ?></p>
        <?php
            if ($guest['admin_comment']) {
                echo '<blockquote class="blockquote-reverse">';
                echo '<img src="static/img/user_photos/thumbnails/admin.jpg" alt="Admin" />';
                echo '<h5 class="text-info">Admin has replied:</h5>';
                echo '<p>'.$guest['admin_comment'].'<br />';
                echo '<small>'.date('Y-m-d H:i', strtotime($guest['admin_comment_date'])).'</small></p>';
                echo '</blockquote>';
            }
        ?>
    </div>
</div>
<hr />
