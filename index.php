<!doctype html>
<html lang="fi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="res/favicon.ico">
    <base href="/" />

    <title>Tech 0</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
          integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
    <link rel="stylesheet" href="static/navbar.css" />
    <link rel="stylesheet" href="static/custom.css" />

</head>
<body>
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                            data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Tech 0</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <?php
                            // For Bootstrap active tab support with PHP Rewrite on
                            $cur = str_replace('/', '', $_SERVER['REQUEST_URI']);
                        ?>
                        <li <?php if ($cur == 'news') echo 'class="active"'; ?>><a href="news">News</a></li>
                        <li <?php if ($cur == 'releases') echo 'class="active"'; ?>><a href="releases">Releases</a></li>
                        <li <?php if ($cur == 'shows') echo 'class="active"'; ?>><a href="shows">Shows</a></li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">Photos <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="photos/promo">Promotional</a></li>
                                <li><a href="photos/studio">Studio</a></li>
                                <li><a href="photos/live">Live</a></li>
                                <li><a href="photos/misc">Miscellaneous</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="photos">All photos</a></li>
                            </ul>
                        </li>
                        <li <?php if ($cur == 'bio') echo 'class="active"'; ?>><a href="bio">Bio</a></li>
                        <li <?php if ($cur == 'videos') echo 'class="active"'; ?>><a href="videos">Videos</a></li>
                        <li <?php if ($cur == 'contact') echo 'class="active"'; ?>><a href="contact">Contact</a></li>
                        <li <?php if ($cur == 'shop') echo 'class="active"'; ?>><a href="shop">Shop</a></li>
                        <li <?php if ($cur == 'guestbook') echo 'class="active"'; ?>>
                            <a href="guestbook">Guestbook</a>
                        </li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>

        <!-- Main content -->
        <?php
            require_once 'constants.php';
            require_once 'classes/route.php';
            $route = new Route();
            $route->getTemplate();
        ?>

    </div> <!-- Container ends -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <!-- Form handling -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/3.51/jquery.form.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"
            integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
            crossorigin="anonymous"></script>
    <!-- Custom jquery -->
    <script src="static/main.js"></script>

</body>
</html>
