<div class="row">
    <div class="col-sm-4">
        <h3>
            <span><?php echo $show['country']; ?></span>,
            <span><?php echo $show['city']; ?></span>
        </h3>
        <small><?php echo $show['show_date']; ?></small>
        <p><?php echo $show['band_comments']; ?></p>
        <?php
            if ($_SESSION['authorized'] == 1) {
                include './apps/shows/edits/edit-show-form.php';
            }
        ?>
    </div>
    <div class="col-sm-4">
        <h3>Setlist</h3>
        <ol class="setlist">
            <?php
                $songs = explode('|', $show['setlist']);
                foreach ($songs as $song) {
                    echo '<li>'.$song.'</li>';
                }
            ?>
        </ol>
    </div>
    <div class="col-sm-4">
        <h3>Band lineup</h3>
        <p>
            <?php
                $members = explode(', ', $show['performers']);
                foreach ($members as $member) {
                    $details = explode('|', $member);
                    echo '<span class="text-info">'.$details[0].'</span> - '.$details[1];
                    echo '<br />';
                }
            ?>
        </p>
        <h3>Other bands at the show</h3>
            <?php
                $bands = explode(', ', $show['other_bands']);
                foreach ($bands as $band) {
                    $details = explode('|', $band);
                    echo '<a href="';
                    if (substr($details[1], 0, 4) != 'http') {
                        echo 'http://'.$details[1];
                    } else {
                        echo $details[1];
                    }
                    echo '">'.$details[0].'</a><br />';
                }
            ?>
        </small>
    </div>
</div>
<hr />
