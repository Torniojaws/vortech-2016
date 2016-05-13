<input id="<?php echo $this->category; ?>-rating-<?php echo $this->target_id; ?>" type="number" class="rating"
       value=<?php echo $this->rating; ?> min=0 max=<?php echo $this->max_rating; ?>
           data-step=0.5 data-size="xs" data-rtl="false" />
<small>
    <?php
        echo $this->vote_count;
        // Oxford comma of CS?
        if ($this->vote_count == 1) {
            echo ' vote';
        } else {
            echo ' votes';
        }
    ?>
</small>
<div id="added-ok-<?php echo $this->target_id; ?>" class="text-success" hidden><h3>Thanks for your vote!</h3></div>
