<div class="col-sm-4">
    <a href="static/img/<?php echo strtolower($photo['group_name']) . "/"; echo $photo['full']; ?>">
        <img src="static/img/<?php echo strtolower($photo['group_name']) . "/"; echo $photo['thumbnail']; ?>" alt="<?php echo $photo['caption']; ?>" />
    </a>
    <br />
    <small>
        <?php echo $photo['date_taken']; ?> &ndash;
        <?php echo $photo['caption']; ?>
    </small>
</div>
