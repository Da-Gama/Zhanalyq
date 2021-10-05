<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="main.php">Zhanalyq</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="main.php">News</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="categories.php">Categories</a>
            </li>
            <li class="nav-item">
                <?php
                session_start();
                if ($_SESSION['user']['id']){
                    $href = "news.php?author=".$_SESSION['user']['id'];
                    $style = 'style="display: block"';
                    $style2 = 'style="display: none"';
                }else{
                    $href = 'auth/authentication.php';
                    $style = 'style="display: none"';
                    $style2 = 'style="display: display"';
                }
                ?>
                <a class="nav-link" href="<?php echo $href?>">My publications</a>
            </li>
        </ul>
        <div class="btn-group" <?php echo $style2?>>
            <a class="text-white" href="auth/authentication.php">Join or Log into Zhanalyq</a>
        </div>
        <div class="btn-group" <?php echo $style?>>
            <button type="button" class="btn text-white dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php echo $_SESSION['user']['firstName'] . " " . $_SESSION['user']['lastName']?>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="profile.php">Profile</a>
                <a class="dropdown-item" href="edit.php">Edit profile</a>
                <a class="dropdown-item" href="publication.php">Publish</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="auth/signOut.php">Sign out</a>
            </div>
        </div>
    </div>
</nav>