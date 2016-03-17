<div class="row">
    <div class="col-sm-8">
        <h2><?php echo $news['title']; ?></h2>
        <p><?php echo $news['contents']; ?></p>
        <aside><small><?php echo $news['tags']; ?></small></aside>
    </div>
    <div class="col-sm-4">
        <img src="static/img/site/admin.jpg" alt="Admin" /><br />
        <b><?php echo $news['author'];?></b>
        <aside><small>Posted on <?php echo $news['posted']; ?></small></aside>
    </div>
</div>
<hr />
