<?php

    function endpoint_list($method, $request, $input_data=null) {

        // Check API version
        list($skip, $api, $api_version) = explode('/', $request);

        switch($method) {

            case 'GET':
                switch($api_version) {
                    case "v1":
                        $noun = str_replace("/api/v1/", "", $request);
                        $sql_query = get_handler($noun);
                        break;
                    default:
                        return '{"Error":"Unknown API version"}';
                }
                break;

            case 'POST':
                switch($api_version) {
                    case "v1":
                        $noun = str_replace("/api/v1/", "", $request);
                        $sql_query = post_handler($noun, $input_data);
                        break;
                    default:
                        return '{"Error":"Unknown API version"}';
                }
                break;

            default:
                $sql_query = '{"Error":"Unsupported method"}';
                break;

        }
        return $sql_query;

    }

    function get_handler($request_endpoint) {

        // But first, let's just escape apostrophes
        $request_endpoint = str_replace("'", "&apos;", $request_endpoint);

        // And let's see if there's any filters
        $filters = explode('?', $request_endpoint);
        $uri_filters = null;
        if(isset($filters[1])) {
            $uri_filters = $filters[1];
            // Now that the filters are picked up, let's remove the fluff from uri
            $request_endpoint = str_replace("?".$uri_filters, '', $request_endpoint);
        }

        // Eg. GET /releases/123/comments/2  will return comment 2 for release 123
        // Some special cases have more depth:
        // eg. GET /releases/123/songs/1/comments       All comments for a song
        // eg. GET /releases/123/songs/1/comments/1     Specific comment for a song
        $uri = explode('/', $request_endpoint);
        $root_request = $uri[0];
        $root_id = null;
        $sub = null;
        $sub_id = null;
        $detail = null;
        $detail_id = null;

        // Catch any sub-URIs that exist
        if(isset($uri[1])) {
            $root_id = $uri[1];
        }
        if(isset($uri[2])) {
            $sub = $uri[2];
        }
        if(isset($uri[3])) {
            $sub_id = $uri[3];
        }
        if(isset($uri[4])) {
            $detail = $uri[4];
        }
        if(isset($uri[5])) {
            $detail_id = $uri[5];
        }

        switch($root_request) {
            case 'news':
                include('news-handler.php');
                $sql = news_handler($root_id, $sub, $sub_id, $detail, $detail_id, $uri_filters);
                break;
            case 'releases':
                include('release-handler.php');
                $sql = release_handler($root_id, $sub, $sub_id, $detail, $detail_id, $uri_filters);
                break;
            default:
                $sql = '';
                break;
        }
        return $sql;

    }

    function post_handler($request_endpoint) {
        // But first, let's just escape apostrophes
        $request_endpoint = str_replace("'", "&apos;", $request_endpoint);

    }

?>
