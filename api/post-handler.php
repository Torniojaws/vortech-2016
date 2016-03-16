<?php
    function post_handler($request_endpoint) {
        // But first, let's just escape apostrophes
        $request_endpoint = str_replace("'", "&apos;", $request_endpoint);

    }
?>
