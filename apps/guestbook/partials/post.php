<div class="row">
  <div class="col-sm-3">
    <img src="static/img/<?php echo $user_photo['name_id'].'/'.$user_photo['thumbnail']; ?>"
         alt="<?php echo $user_photo['caption']; ?>" />
    <h4><?php echo $guest['name']; ?></h4>
    <small><?php echo $guest['posted']; ?></small>
  </div>
  <div class="col-sm-6">
    <p><?php echo $guest['post']; ?></p>
  </div>
  <div class="col-sm-3">
    <?php
      if ($guest['admin_comment']) {
        include 'apps/guestbook/partials/admin-comment.php';
      } elseif (isset($_SESSION['authorized']) && $_SESSION['authorized'] == 1) {
        include 'apps/guestbook/admin/add-comment-modal.php';
      }
    ?>
  </div>
</div>
<hr />
