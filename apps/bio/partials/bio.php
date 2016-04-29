<div class="row">
    <div class="col-sm-3">
        <!-- The photo will open in a modal window -->
        <a href="#photo-modal<?php echo $photo['id']; ?>" data-toggle="modal" data-target="#photo-modal<?php echo $photo['id']; ?>">
            <img src="static/img/<?php echo strtolower($photo['name_id']).'/';
            echo $photo['thumbnail']; ?>" alt="<?php echo $photo['caption']; ?>" />
        </a>
    </div>
    <div class="col-sm-9">
        <h2><?php echo $member['name']; ?> <small><?php echo $member['instrument']; ?></small></h2>
        <small>
            <?php
                echo $member['type'].'. In the band since ';
                $date_start = date('F Y', strtotime($member['started']));
                echo $date_start;
                if (substr($member['quit'], 0, 4) != 9999) {
                    $end_date = date('F Y', strtotime($member['quit']));
                    echo ' until '.$end_date.'.';
                }
            ?>
        </small>
        <p id="membershort-<?php echo $member['id']; ?>"<?php
            if ($_SESSION['authorized'] == 1) {
                echo ' class="edit-memberbio"';
            }
         ?>><?php echo $member_bio['short']; ?></p>
    </div>
</div>
<hr />

<?php include './apps/bio/modals/bio.php'; ?>
