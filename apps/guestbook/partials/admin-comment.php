<blockquote class="blockquote-reverse">
  <img src="static/img/user_photos/thumbnails/admin.jpg" alt="Admin" />
  <h5 class="text-info">Admin has replied:</h5>
  <?php
    echo '<p id="gb-'.$guest['id'];
    if ($_SESSION['authorized'] == 1) {
      echo '" class="edit-gb';
    }
    echo '">';
    echo $guest['admin_comment'];
  ?></p>
  <small><?php echo date('Y-m-d H:i', strtotime($guest['admin_comment_date'])); ?></small>
</blockquote>
