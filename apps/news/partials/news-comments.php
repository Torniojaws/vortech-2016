<aside class="well">
  <?php
    // We'll get all comments here for showing in the modal and latest 2 for preview
    $api = 'api/v1/news/'.$news['id'].'/comments';
    $comments = file_get_contents(SERVER_URL.$api);
    $comments = json_decode($comments, true);

    // Get the latest comments
    $count = count($comments);
    $last = count($comments) - 1;
    if ($count >= 2) {
      $second_last = $last - 1;
      echo '<strong>'.$comments[$second_last]['author'].'</strong>: '.
            $comments[$second_last]['comment'].'<br />';
      echo '<strong>'.$comments[$last]['author'].'</strong>: '.$comments[$last]['comment'].'<br />';
    } elseif ($count == 1 and isset($comments[$last]['comment'])) {
      echo '<strong>'.$comments[$last]['author'].'</strong>: '.$comments[$last]['comment'].'<br />';
    } else {
      echo 'No comments yet - add yours?<br />';
    }
  ?>
  <!-- Comment form, shown when user has logged in-->
  <?php
    if ($_SESSION['user_logged'] == 1) { ?>
      <hr />

      <form class="form-inline" role="form"
            id="user-news-comment-<?php echo $_SESSION['user_id']; ?>">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-addon" id="basic-addon3">
              <?php echo $_SESSION['display_name']; ?></span>
            <input type="text" class="form-control" id="comment" name="comment"
              aria-describedby="basic-addon3" placeholder="Your comment" />
            <!-- We'll get the next sub-id by adding 2 (from 0-index conversion + next new)
               to get the correct new sub-id -->
            <input type="hidden" name="comment_subid" value="<?php echo $last+2; ?>" />
            <input type="hidden" name="news_id" value="<?php echo $news['id']; ?>" />
            <input type="hidden" name="display_name"
                   value="<?php echo $_SESSION['display_name']; ?>" />
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />
          </div>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
        <div id="added-ok-<?php echo $news['id']; ?>" class="text-success" hidden>
          <h3>Successfully added comment! Boom...</h3>
        </div>
        <div id="add-failed-<?php echo $news['id']; ?>" class="text-danger" hidden>
          <h3>Failed to add comment!</h3>
        </div>
      </form>
      <br />
    <?php } else {
      echo '<br /><a href="#" data-toggle="modal" data-target="#login-modal">
          Login</a> or <a href="#" data-toggle="modal" data-target="#register-modal">
          Register</a> to add a comment.';
    }
  ?>
</aside>
