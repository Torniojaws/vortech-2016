<!-- Add guestbook post -->
<form class="form" id="user-guestbook-form" name="add-guestbook-post-form">

    <div class="form-group">
        <?php
            if (isset($_SESSION['user_logged']) and $_SESSION['user_logged'] == 1) {
                echo 'Posting as <label for="username">'.$_SESSION['display_name'].'</label><br />
                <input type="hidden" id="username" name="username" value="'.$_SESSION['display_name'].'" />';
            } else {
                echo '<label for="guest_name">Your name</label><br />
                <input type="text" id="guest_name" name="guest_name" placeholder="Your name" /><br />';

                require_once $root.'api/classes/Database.php';
                $db = new Database();

                // Get the count
                $antispam_api = 'api/v1/antispam/count';
                $antispam_list = json_decode(file_get_contents(SERVER_URL.$antispam_api), true);
                $antispam_count = (int) $antispam_list[0]['count'];

                $random_number = mt_rand(1, $antispam_count);

                $db->connect();
                $statement = 'SELECT question FROM antispam WHERE id = :id';
                $params = array('id' => $random_number);
                $result = $db->run($statement, $params);
                $db->close();

                echo '<label for="antispam">Antispam Question:</label><br /> '.$result[0]['question'].'
                <input type="hidden" id="antispam_challenge" name="antispam_challenge" value="'.$random_number.'" /><br />
                <input type="text" id="antispam_response" name="antispam_response" placeholder="Your answer" /><br />';
            }
        ?>
        <label for="comment">Your comment</label>
        <textarea class="form-control" rows="5" id="comment"
                  name="comment" placeholder="Write your guestbook comment here"></textarea>
    </div>

    <button type="submit" class="btn btn-primary" name="Submit" id="send-guestbook-comment-form">Add the comment</button>
</form>
<div id="added-ok" class="text-success" hidden><h3>Successfully added comment! Boom...</h3></div>
<div id="add-failed" class="text-danger" hidden><h3>Failed to add comment!</h3></div>
<hr />
