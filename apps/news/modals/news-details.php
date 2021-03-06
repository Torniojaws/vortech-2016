<!-- Modal contents -->
<div class="modal fade" id="news-modal<?php echo $news['id']; ?>" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
          <?php echo $news['title'].' <br /> <small>'.$news['posted'].'</small>'; ?>
        </h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <div class="row">
            <p><?php echo $news['contents']; ?></p>
            <hr />
            <h3>Comments</h3>
          </div>
          <?php
            $counter = 0;
            if (empty($comments[0]) == false) {
            foreach ($comments as $comment) {
              ++$counter;
              if ($counter % 2 == 0) {
                echo '<div class="row alternate-comment-row">';
              } else {
                echo '<div class="row">';
              } ?>
            <div class="col-sm-2">
              <?php echo '<small>'.date('Y-m-d', strtotime($comment['posted'])).'</small>'.PHP_EOL;
              ?>
            </div>
            <div class="col-sm-5">
              <?php echo '<strong>'.$comment['author'].'</strong>'.PHP_EOL;
              ?>
            </div>
            <div class="col-sm-5">
              <?php echo $comment['comment'].PHP_EOL;
              ?>
            </div>
          </div>
          <?php
          } // foreach
        } // if ?>
          <div class="row">
            <?php include 'apps/news/partials/news-comments.php'; ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<button type="button" class="btn btn-info btn-lg" data-toggle="modal"
    data-target="#news-modal<?php echo $news['id']; ?>">
  Show all comments (<?php echo $counter; ?>)
</button>
