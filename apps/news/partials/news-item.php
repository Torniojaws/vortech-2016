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
            <?php include 'apps/news/partials/news-comments.php'; ?>
        </div>
        <div class="col-sm-4">
            <?php include 'apps/news/modals/news-details.php'; ?>
        </div>
    </div>
</div> <!-- Container -->
<hr />

<!-- Modals -->
<?php include 'apps/main/modals/login.php'; ?>

<?php include 'apps/main/modals/register.php'; ?>
