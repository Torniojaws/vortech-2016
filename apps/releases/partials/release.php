<div class="row">
  <div class="col-sm-4">
    <!-- The release details will open in a modal window -->
    <a href="#release-modal<?php echo $release['id']; ?>" data-toggle="modal"
       data-target="#release-modal<?php echo $release['id']; ?>">
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
      $root = str_replace('apps/releases/partials', '', __DIR__);
      require_once $root.'classes/StarRating.php';
      $release_params = array(
        'rootdir' => $root,
        'category' => 'releases',
        'id' => $release['id'],
      );
      $rating = new StarRating($release_params);
      $rating->display();
    ?>
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

          // Star rating for the song -->
          require_once $root.'classes/StarRating.php';
          $song_params = array(
            'rootdir' => $root,
            'category' => 'songs',
            'id' => $song['song_id'],
          );
          $song_rating = new StarRating($song_params);
          $song_rating->display();
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
