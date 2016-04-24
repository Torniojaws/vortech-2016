<div class="col-sm-4">
    <!-- The photo will open in a modal window -->
    <a href="#photo-modal<?php echo $photo['id']; ?>" data-toggle="modal" data-target="#photo-modal<?php echo $photo['id']; ?>">
        <img src="static/img/<?php echo strtolower($photo['name_id']).'/';
        echo $photo['thumbnail']; ?>" alt="<?php echo $photo['caption']; ?>" />
    </a>
    <br />
    <small>
        <?php
            echo date('Y-m-d', strtotime($photo['date_taken']));
            echo ' &ndash; ';

            if (empty($photo['caption'])) {
                if ($_SESSION['authorized'] == 1) {
                    echo '<span id="photocaption-'.$photo['id'].'" class="edit-photo">(no description)</span>';
                } else {
                    echo '<span class="text-muted">(no description)</span>';
                }
            } else {
                echo '<span id="photocaption-'.$photo['id'];
                if($_SESSION['authorized'] == 1) {
                    echo '" class="edit-photo';
                }
                echo '">'.$photo['caption'].'</span>';
            }
            echo '<br />';
            echo 'From: <strong>'.$photo['name'].'</strong>';
        ?>
    </small>
</div>

<?php include 'templates/modals/photo.php'; ?>
