<div class="container-fluid">
<aside class="well">
    <?php
        // We'll get all comments here for showing in the modal and latest 2 for preview
        $api = 'api/v1/photos/'.$photo['id'].'/comments';
        $comments = file_get_contents(SERVER_URL.$api);
        $comments = json_decode($comments, true);

        // Get the latest comments
        $count = count($comments);
        $last = count($comments) - 1;

        // For storing the next value in "photo_comments" table
        $next_category_comment_subid = $comments[$last]['category_comment_subid'] + 1;

        if ($count >= 2) {
            $second_last = $last - 1;
            // TODO: make this more sensible - include author name in photos API?
            $second_last_user = 'api/v1/users/'.$comments[$second_last]['author_id'];
            $second_last_author_name = json_decode(file_get_contents(SERVER_URL.$second_last_user), true);
            $last_user = 'api/v1/users/'.$comments[$last]['author_id'];
            $last_author_name = json_decode(file_get_contents(SERVER_URL.$last_user), true);

            echo '<strong>'.$second_last_author_name[0]['name'].'</strong>: '.$comments[$second_last]['comment'].'<br />';
            echo '<strong>'.$last_author_name[0]['name'].'</strong>: '.$comments[$last]['comment'].'<br />';
        } elseif ($count == 1 and isset($comments[$last]['comment'])) {
            $last_user = 'api/v1/users/'.$comments[$last]['author_id'];
            $last_author_name = json_decode(file_get_contents(SERVER_URL.$last_user), true);
            echo '<strong>'.$last_author_name[0]['name'].'</strong>: '.$comments[$last]['comment'].'<br />';
        } else {
            echo 'No comments yet - add yours?<br />';
        }
    ?>
    <!-- Comment form, shown when user has logged in-->
    <?php
        if ($_SESSION['user_logged'] == 1) { ?>
            <hr />

            <form class="form-inline" role="form" id="user-photo-comment-<?php echo $_SESSION['user_id']; ?>">
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">
                            <?php echo $_SESSION['display_name']; ?></span>
                        <input type="text" class="form-control" id="comment" name="comment"
                            aria-describedby="basic-addon3" placeholder="Your comment" />
                        <!-- We'll get the next sub-id by adding 2 (from 0-index conversion + next new)
                             to get the correct new sub-id -->
                        <input type="hidden" name="comment_subid" value="<?php echo $last+2; ?>" />
                        <input type="hidden" name="photo_id" value="<?php echo $photo['id']; ?>" />
                        <input type="hidden" name="category_comment_subid" value="<?php echo $next_category_comment_subid; ?>" />
                        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>" />

                    </div>
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
                <div id="added-ok-<?php echo $photo['id']; ?>" class="text-success" hidden><h3>Successfully added comment! Boom...</h3></div>
                <div id="add-failed-<?php echo $photo['id']; ?>" class="text-danger" hidden><h3>Failed to add comment!</h3></div>
            </form>
            <br />
        <?php } else {
            echo '<br /><a href="#" data-toggle="modal" data-target="#login-modal">
                  Login</a> or <a href="#" data-toggle="modal" data-target="#register-modal">
                  Register</a> to add a comment.';
        }
    ?>
</aside>
</div>

<!-- Modals -->
<?php include 'apps/main/modals/login.php'; ?>

<?php include 'apps/main/modals/register.php'; ?>
