<div class="row">
    <div class="col-sm-3">
        <a href="static/img/<?php echo strtolower($shop['name_id']) . "/"; echo $shop['full']; ?>">
            <img src="static/img/<?php echo strtolower($shop['name_id']) . "/"; echo $shop['thumbnail']; ?>" alt="<?php echo $shop['name']; ?>" />
        </a>
    </div>
    <div class="col-sm-9">
        <h2><?php echo $shop['name']; ?></h2>
        <p><?php echo $shop['description']; ?></p>
        <aside><small>Price: <?php echo $shop['price']; ?></small></aside>
    </div>
</div>
<hr />
