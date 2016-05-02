<div class="container-fluid">
    <div class="row">
        <div class="col-sm-8">
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
                } ?>><?php
                    require_once './classes/Markdown.php';
                    $markdown = new Markdown();
                    $fulltext = $markdown->convert($landing['full']);
                    echo $fulltext;
                ?></p>
        </div>
        <div class="col-sm-4">
            <section>
            <h3>Login</h3>
            <?php
                if ($_SESSION['authorized'] == 1) {
                    echo '<p>Nice to see you, '.$_SESSION['username'].'!</p>';
                    include 'apps/admin/partials/logout.php';
                } elseif ($_SESSION['user_logged'] == 1) {
                    echo '<p>Welcome back, '.$_SESSION['username'].'</p>';
                    ?>
                        <label for="logout-form">User logout</label>
                        <form role="form" class="form-inline" id="user-logout-form" name="user-logout-form">
                            <input type="hidden" name="userLogout" value="logout" />
                            <button type="submit" class="btn btn-primary" name="Submit" id="user-logout">Logout</button>
                        </form>
                        <div id="logout-ok" class="text-info" hidden>Successfully logged out! See you again...</div>
                        <div id="logout-failed" class="text-info" hidden>Could not log you out! Try again?</div>
                    <?php
                } else {
                    echo '<p><a href="#" data-toggle="modal" data-target="#login-modal">
                          Login</a> or <a href="#" data-toggle="modal" data-target="#register-modal">
                          Register</a> to add a comment.</p>';
                    echo '<p>Registered users can add comments to News, Releases, Songs, Shows,
                          Photos, and Videos. You can also have a custom avatar/image.</p>';
                }
            ?>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4 well">
            <h4>Visitors</h4>
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
            <p>Copyright &copy; <?php echo date('Y'); ?> Vortech</p>
        </div>
    </div>
</div>

<?php include 'apps/main/modals/login.php'; ?>

<?php include 'apps/main/modals/register.php'; ?>
