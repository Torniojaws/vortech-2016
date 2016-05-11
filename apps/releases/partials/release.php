<div class="row">
    <div class="col-sm-4">
        <!-- The release details will open in a modal window -->
        <a href="#release-modal<?php echo $release['id']; ?>" data-toggle="modal" data-target="#release-modal<?php echo $release['id']; ?>">
            <img src="<?php
                        if (file_exists($release['thumbnail'])) {
                            echo $release['thumbnail'];
                        } else {
                            echo 'static/img/site/cd.jpg';
                        } ?>" alt="<?php echo $release['title']; ?>" /><br />
        </a>
        <h3>
            <span id="releasetitle-<?php echo $release['release_code']; ?>" <?php
                if($_SESSION['authorized'] == 1) { echo ' class="edit-release"'; } ?>><?php
                echo $release['title']; ?></span>
            <small>by</small> <!-- Separate due to Jeditable -->
            <small id="releaseartist-<?php echo $release['release_code']; ?>" <?php
                if($_SESSION['authorized'] == 1) { echo ' class="edit-release"'; } ?>><?php
                echo $release['artist']; ?></small>
        </h3>
        <p id="releasedate-<?php echo $release['release_code']; ?>" <?php
            if($_SESSION['authorized'] == 1) { echo ' class="edit-release"'; } ?>><?php
            echo $release['release_date']; ?></p>
        <?php
            if (strtolower($release['has_cd']) == 'yes') {
                echo '<small>CD available</small><br />';
            }
        ?>
        <small>Release Code: </small> <!-- Separate due to jeditable -->
        <small id="releasecode-<?php echo $release['release_code']; ?>" <?php
            if($_SESSION['authorized'] == 1) { echo ' class="edit-release"'; } ?>><?php
            echo $release['release_code']; ?></small>
        <!-- Star rating for the Release -->
        <?php
            $votes_api = 'api/v1/votes/releases/'.$release['id'];
            $votes = json_decode(file_get_contents(SERVER_URL.$votes_api), true);
            $release_rating = $votes[0]['rating'];
            $max_rating = $votes[0]['max_rating'];
            $vote_count = $votes[0]['votes'];
        ?>
        <input id="release-rating-<?php echo $release['id']; ?>" type="number" class="rating"
               value=<?php echo $release_rating; ?> min=0 max=<?php echo $max_rating; ?>
               data-step=0.5 data-size="xs" data-rtl="false" starCaptions={} />
    </div>
    <div class="col-sm-4">
        <?php
            if ($_SESSION['authorized'] == 1) {
                foreach ($songs as $song) {
                    echo '<span id="songtitle-'.$release['release_code'].'-'.$song['release_song_id'];
                    echo '" class="edit-song">';
                    echo $song['title'].'</span> ';
                    echo '(<span id="songdura-'.$release['release_code'].'-'.$song['release_song_id'];
                    echo '" class="edit-song">';
                    echo $song['duration'].'</span>)';
                    echo '<br />';
                }
            } else {
                foreach ($songs as $song) {
                    echo $song['title'];
                    echo ' (';
                    echo $song['duration'];
                    echo ')<br />';
                }
            }
        ?>
    </div>
    <div class="col-sm-4">
        <p id="releasenotes-<?php echo $release['release_code']; ?>" <?php
            if($_SESSION['authorized'] == 1) { echo ' class="edit-release"'; } ?>><?php
            echo $release['release_notes']; ?></p>
    </div>
</div>
<hr />

<?php include 'apps/releases/modals/release.php'; ?>
