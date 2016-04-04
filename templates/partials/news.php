<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2">
            <img src="static/img/site/admin.jpg" alt="Admin" /><br />
            <b><?php echo $news['author'];?></b>
            <aside><small>Posted on<br /> <?php echo $news['posted']; ?></small></aside>
        </div>
        <div class="col-sm-10">
            <h2><?php echo $news['title']; ?></h2>
            <p><?php echo $news['contents']; ?></p>
            <small>Tags:
                <?php
                    $tags = explode(',', $news['tags']);
                    $tagCount = count($tags);
                    $counter = 0;
                    foreach ($tags as $tag) {
                        $tag = trim($tag);
                        echo "<a href=\"news?tag=$tag\">".$tag.'</a>';
                        ++$counter;
                        if($counter < $tagCount) {
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
                    } elseif($count == 1 and isset($comments[$last]['comment'])) {
                        echo '<strong>'.$comments[$last]['author'].'</strong>: '.$comments[$last]['comment'].'<br />';
                    } else {
                        echo 'No comments yet - add yours?<br />';
                    }
                ?>
                <!-- Comment form -->
                <hr />
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon3">Username</span>
                            <input type="text" class="form-control" id="comment" aria-describedby="basic-addon3" placeholder="Your comment">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
                <br />
            </aside>
        </div>
        <div class="col-sm-4">
            <!-- Modal window -->
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal"
                    data-target="#news-modal<?php echo $news['id']; ?>">
                Show all comments (<?php echo count($comments); ?>)
            </button>
        </div>
    </div>
</div> <!-- Container -->
<hr />

<!-- Modal contents -->
<div class="modal fade" id="news-modal<?php echo $news['id']; ?>" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $news['title'].' <br /> <small>'.$news['posted'].'</small>'; ?></h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <p><?php echo $news['contents']; ?></p>
                        <hr />
                        <h3>Comments</h3>
                    </div>
                    <?php
                        // We'll show all comments here - data loaded near row 10
                        foreach ($comments as $comment) {
                    ?><div class="row">
                        <div class="col-sm-2">
                            <?php echo '<small>'.date('Y-m-d', strtotime($comment['posted'])).'</small>'.PHP_EOL; ?>
                        </div>
                        <div class="col-sm-2">
                            <?php echo '<strong>'.$comment['author'].'</strong>'.PHP_EOL; ?>
                        </div>
                        <div class="col-sm-6">
                            <?php echo $comment['comment'].PHP_EOL; ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
