<?php

    function get_handler($request_endpoint) {

        // But first, let's just escape apostrophes in the URL
        $request_endpoint = str_replace("'", "&apos;", $request_endpoint);

        // And let's see if there's any filters
        $filters = explode('?', $request_endpoint);
        $uri_filters = null;
        if(isset($filters[1])) {
            $uri_filters = $filters[1];
            // Now that the filters are picked up, let's remove the fluff from uri
            $request_endpoint = str_replace("?" . $uri_filters, '', $request_endpoint);
        }

        list($root_request, $root_id, $sub, $sub_id, $detail,
        $detail_id) = array_pad(explode('/', $request_endpoint), 6, null);

        switch($root_request) {
            case 'news':
                include('view-handlers/news-handler.php');
                $sql = news_handler($root_id, $sub, $sub_id, $detail, $detail_id, $uri_filters);
                break;
            case 'releases':
                include('view-handlers/release-handler.php');
                $sql = release_handler($root_id, $sub, $sub_id, $detail, $detail_id, $uri_filters);
                break;
            case 'shows':
                include('view-handlers/show-handler.php');
                $sql = show_handler($root_id, $sub, $sub_id, $detail, $detail_id, $uri_filters);
                break;
            default:
                $sql = '';
                break;
        }

        return $sql;
    }

?>
