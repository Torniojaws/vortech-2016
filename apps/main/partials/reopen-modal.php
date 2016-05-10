<?php
    // After a comment has been added, this will reopen the modal
    if (isset($_SERVER['QUERY_STRING'])) {
        parse_str($_SERVER['QUERY_STRING']);
        if (isset($showModal)) {
            list($uri, $params) = explode('?', $_SERVER['REQUEST_URI']);
            switch ($uri) {
                case substr($uri, 0, 5) == '/news':
                    $modal_name = 'news-modal';
                    break;
                case substr($uri, 0, 9) == '/releases':
                    $modal_name = 'release-modal';
                    break;
                case substr($uri, 0, 7) == '/photos':
                    $modal_name = 'photo-modal';
                    break;
                case substr($uri, 0, 4) == '/bio':
                    $modal_name = 'bio-modal';
                    break;
                case substr($uri, 0, 5) == '/shop':
                    $modal_name = 'shop-modal';
                    break;
                default:
                    $modal_name = '';
                    break;
            }
            echo '<script type="text/javascript">
                $(window).load(function () {
                    $("#'.$modal_name.$showModal.'").modal("show");
                });
            </script>';
        }
    }
