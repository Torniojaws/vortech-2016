<div class="row">
    <div class="col-sm-4">
        <?php echo $photo['full']; ?>
        <a href="static/img/<?php echo strtolower($photo['name_id']) . "/"; echo $photo['full']; ?>">
            <img src="static/img/<?php echo strtolower($photo['name_id']) . "/"; echo $photo['thumbnail']; ?>" alt="<?php echo $photo['caption']; ?>" />
        </a>
    </div>
    <div class="col-sm-8">
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
</div>
<hr />
