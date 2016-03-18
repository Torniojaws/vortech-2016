<div class="row">
    <div class="col-sm-4">
        <h3>
            <?php
                echo $show['country'];
                echo ", " . $show['city'];
            ?>
        </h3>
        <small><?php echo $show['show_date']; ?></small>
        <p><?php echo $show['band_comments']; ?></p>
    </div>
    <div class="col-sm-8">
        <ol class="setlist">
            <?php
                $songs = explode('|', $show['setlist']);
                foreach($songs as $song) {
                    echo '<li>' . $song . '</li>';
                }
            ?>
        </ol>
        <p><?php echo $show['performers']; ?></p>
        <small><?php echo $show['other_bands']; ?></small>
    </div>
</div>
<hr />
