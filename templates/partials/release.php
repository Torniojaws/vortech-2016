<div class="row">
    <div class="col-sm-4">
        <img src="static/img/site/cd.jpg" alt="CD placeholder" /><br />
        <h3><?php echo $release['title']; ?> <small>by <?php echo $release['artist']; ?></small></h3>
        <p><?php echo $release['release_date']; ?></p>
        <?php
            if (strtolower($release['has_cd']) == 'yes') {
                echo '<small>CD available</small>';
            }
        ?>
        <small>Code: <?php echo $release['release_code']; ?></small>
    </div>
    <div class="col-sm-4">
        <?php
            foreach($songs as $song) {
                echo $song["title"];
                echo ' (';
                echo $song["duration"];
                echo ')<br />';
            }
        ?>
    </div>
    <div class="col-sm-4">
        Recored and produced
    </div>
</div>
<hr />
