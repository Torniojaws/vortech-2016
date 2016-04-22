<div class="container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <?php
                $landing_api = 'api/v1/articles/3';
                $landing_result = file_get_contents(SERVER_URL.$landing_api);
                $landing_article = json_decode($landing_result, true);
                $landing = $landing_article[0];
            ?>
            <h2 id="landingshort-3"<?php
                if ($_SESSION['authorized'] == 1) {
                    echo ' class="edit-landing"';
                } ?>><?php echo $landing['short']; ?></h2>
            <p id="landingfull-3"<?php
                if ($_SESSION['authorized'] == 1) {
                    echo ' class="edit-landing"';
                } ?>><?php echo $landing['full']; ?></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-8">
            <h2>Visitors</h2>
            <?php
                $api = 'api/v1/visitors';
                $visitor_result = file_get_contents(SERVER_URL.$api);
                $visitors = json_decode($visitor_result, true);
                $visitors = $visitors[0];
            ?>
            <p><?php echo $visitors['count']; ?></p>
            <?php
                // Increment visitor count
                $increment_api = 'api/v1/visitors';
                $data = array('increment' => 1);
                $options = array(
                    'http' => array(
                        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                        'method' => 'PUT',
                        'content' => http_build_query($data),
                    ),
                );
                $context = stream_context_create($options);
                $result = file_get_contents(SERVER_URL.$increment_api, false, $context);
                if ($result === false) {
                    echo 'Could not update count!';
                }
            ?>
        </div>
    </div>
</div>
