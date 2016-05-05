<?php
    // After a comment has been added, this will reopen the modal
    if (isset($_SERVER['QUERY_STRING'])) {
        parse_str($_SERVER['QUERY_STRING']);
        if (isset($showModal)) {
            echo '<script type="text/javascript">
                $(window).load(function () {
                    $("#release-modal'.$showModal.'").modal("show");
                });
            </script>';
        }
    }
