<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <img src="static/img/site/admin.jpg" alt="Admin" /><br />
            <b><?php echo $news['author'];?></b>
            <aside><small>Posted on<br /> <?php echo $news['posted']; ?></small></aside>
        </div>
        <div class="col-sm-10">
            <h2 id="title-<?php echo $news['id']; ?>"
                <?php if($_SESSION['authorized'] == 1) { echo ' class="edit-news"'; } ?>><?php
                echo $news['title']; ?></h2>
            <p id="contents-<?php echo $news['id']; ?>"
                <?php if($_SESSION['authorized'] == 1) { echo ' class="edit-news"'; } ?>><?php
                echo $news['contents']; ?></p>
            <small id="tags-<?php echo $news['id']; ?>"
                <?php if($_SESSION['authorized'] == 1) { echo ' class="edit-news"'; } ?>>
                Tags:
                <?php
                    $tags = explode(',', $news['tags']);
                    $tagCount = count($tags);
                    $counter = 0;
                    foreach ($tags as $tag) {
                        $tag = trim($tag);
                        echo "<a href=\"news?tag=$tag\">".$tag.'</a>';
                        ++$counter;
                        if ($counter < $tagCount) {
                            echo ' &middot; ';
                        }
                    }
                ?>
            </small>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2 text-right">
            <h4>Comments</h4>
        </div>
        <div class="col-sm-6">
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
                        echo '<strong>'.$comments[$second_last]['author'].'</strong>: '.$comments[$second_last]['comment'].'<br />';
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
                        <form class="form-inline" role="form">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon3">
                                        <?php echo $_SESSION['username']; ?></span>
                                    <input type="text" class="form-control" id="comment"
                                        aria-describedby="basic-addon3" placeholder="Your comment" />
                                </div>
                            </div>
                            <button type="submit" class="btn btn-default">Submit</button>
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
        <div class="col-sm-4">
            <?php include 'templates/modals/news.php'; ?>
        </div>
    </div>
</div> <!-- Container -->
<hr />

<!-- Modals -->
<?php include 'templates/modals/login.php'; ?>

<?php include 'templates/modals/register.php'; ?>
