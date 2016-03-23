<?php

    /**
     * The purpose of this is to generate the SQL query for each case when the
     * API is called via url, eg. localhost/api/v1/photos
     *
     * There is support for up to 5 levels, eg.
     * PUT /photos/promo/123/comments/123
     * Which would get comment 123 for the promo photo number 123
     */
    function put_handler($request_endpoint, $data) {

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
            case 'visitors':
                include('put-handlers/visitor-handler.php');
                $sql = visitor_handler($data);
                break;
            default:
                $sql = '';
                break;
        }

        return $sql;
    }

?>
