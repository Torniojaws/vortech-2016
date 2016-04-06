<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4">
            <h2>Main</h2>
            <p>Page</p>
        </div>
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
