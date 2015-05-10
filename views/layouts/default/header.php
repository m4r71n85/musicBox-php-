<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title> MusicBox - <?php if (isset($this->title)) echo htmlspecialchars($this->title) ?></title>
    <link rel="shortcut icon" href="/content/img/favicon.gif"" type="image/x-icon" />
    
    <link href="/content/css/bootstrap.min.css" rel="stylesheet">
    <link href="/content/css/bootstrap-calm-blue.css" rel="stylesheet" type="text/css"/>
    <link href="/content/css/modern-business.css" rel="stylesheet">
    <link href="/content/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/content/css/star-rating.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/content/styles.css" />
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="/">
                    <img src="/content/img/mb-logo_1.png" alt=""/>
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <a href="/songs">All Songs</a>
                    </li>
                    <li>
                        <a href="/songs/mine">My Songs</a>
                    </li>
                    <li>
                        <a href="/playlists">All Playlists</a>
                    </li>
                    <li>
                        <a href="contact.html">Contact</a>
                    </li>
  
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Blog <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="blog-home-1.html">Blog Home 1</a>
                            </li>
                            <li>
                                <a href="blog-home-2.html">Blog Home 2</a>
                            </li>
                            <li>
                                <a href="blog-post.html">Blog Post</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                
                <?php if($this->isLoggedIn): ?>
                    <form class="navbar-form navbar-right" action="/account/logout" method="post">
                        <button type="submit" class="btn btn-default">Logout</button>
                    </form>
                    <p class="navbar-text navbar-right">Hello, <?= htmlspecialchars($this->getUserDetails()["username"]); ?></p>
                <?php else: ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="/account/login">Login</a>
                        </li>
                        <li>
                            <a href="/account/register">Register</a>
                        </li>
                    </ul>
                <?php endif; ?>
            <form action="/songs/search/title" class="navbar-form navbar-left" role="search" method="get">
              <div class="input-group">
                  <input name="phrase" type="text" class="form-control" placeholder="Search for song..." pattern=".{3,}"   required title="3 characters minimum">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default" type="button"><i class="glyphicon glyphicon-search"></i></button>
                </span>
              </div>
            </form>

            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
 <!-- Page Content -->
    <div class="container main-container">
        
    <?php include('messages.php'); ?>
