<div class="row">
    <h2><?php echo $member['name']; ?> <small><?php echo $member['instrument']; ?></small></h2>
    <small>
        <?php
            echo $member['type'] . '. In the band since ' . $member['started'];
            if(substr($member['quit'], 0, 4) != 9999) {
                echo ' until ' . $member['quit'];
            }
        ?>
    </small>
</div>
<hr />
