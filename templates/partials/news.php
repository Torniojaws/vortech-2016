<div class="row">
    <div class="col-sm-8">
        <h2><?php echo $news['title']; ?></h2>
        <p><?php echo $news['contents']; ?></p>
        <small><?php echo $news['tags']; ?></small>
        <hr />
        <aside class="news-comments">
            <h3>Latest comments</h3>
            <?php
                // We'll get all comments here for showing in the modal and latest 2 for preview
                $api = 'api/v1/news/'.$news['id'].'/comments';
                $comments = file_get_contents(SERVER_URL.$api);
                $comments = json_decode($comments, true);

                // Get the latest 2 comments
                $last = count($comments) - 1;
                $second_last = $last - 1;
                echo '<strong>'.$comments[$second_last]['author'].'</strong>: '.$comments[$second_last]['comment'].'<br />';
                echo '<strong>'.$comments[$last]['author'].'</strong>: '.$comments[$last]['comment'].'<br />';
            ?>
            <button type="button" class="btn btn-info btn-lg" data-toggle="modal"
                    data-target="#news-modal<?php echo $news['id']; ?>">
                Show all comments (<?php echo count($comments); ?>)
            </button>
        </aside>
    </div>
    <div class="col-sm-4">
        <img src="static/img/site/admin.jpg" alt="Admin" /><br />
        <b><?php echo $news['author'];?></b>
        <aside><small>Posted on <?php echo $news['posted']; ?></small></aside>
    </div>
</div>
<hr />

<!-- Modal contents -->
<div class="modal fade" id="news-modal<?php echo $news['id']; ?>" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo $news['title'].' - '.$news['posted']; ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $news['contents']; ?></p>
                <h3>Comments</h3>
                <?php
                    // We'll show all comments here - data loaded near row 10
                    foreach ($comments as $comment) {
                        echo '<strong>'.$comment['author'].'</strong>: '.$comment['comment'].'<br />';
                    }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
