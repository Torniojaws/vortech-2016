<div class="col-sm-4">
    <a href="static/img/<?php echo strtolower($photo['name_id']) . "/"; echo $photo['full']; ?>">
        <img src="static/img/<?php echo strtolower($photo['name_id']) . "/"; 
        echo $photo['thumbnail']; ?>" alt="<?php echo $photo['caption']; ?>" />
    </a>
    <br />
    <small>
        <?php
            echo date('Y-m-d', strtotime($photo['date_taken']));
            echo ' &ndash; ';
            echo $photo['caption'];
            echo '<br />';
            echo "From: <strong>" . $photo['name'] . "</strong>";
        ?>
    </small>
</div>
