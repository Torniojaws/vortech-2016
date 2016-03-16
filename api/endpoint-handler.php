<?php

    function endpoint_list($method, $request, $input_data=null) {

        // Check API version
        list($skip, $api, $api_version) = explode('/', $request);

        switch($method) {

            case 'GET':
                switch($api_version) {
                    case "v1":
                        $noun = str_replace("/api/v1/", "", $request);
                        include('get-handler.php');
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
                        include('post-handler.php');
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

?>
