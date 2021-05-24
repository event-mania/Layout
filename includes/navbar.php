<header class="navbar">
    <h1 class="title">Event Mania</h1>
</header>
<ul class="nav-links">
<?php

    $pagelink = $_SERVER['PHP_SELF'];
    $tmp = explode("/",$pagelink);
    $currentPage = end($tmp);

    if($currentPage == "index.php") {
        echo "<li class='nav-link active'><a href='./index.php'>Home</a></li>";
    } else {
        echo "<li class='nav-link'><a href='./index.php'>Home</a></li>";
    }
?>
    <li class="nav-link"><a href="./aboutus.html">About</a></li>
<?php
    if($currentPage == "login.php" || $currentPage == "admin-login.php") {
        echo "<li class='nav-link active'><a href='./login.php'>Login</a></li>";
    } else {
        echo "<li class='nav-link'><a href='./login.php'>Login</a></li>";
    }


    if($currentPage == "register.php") {
        echo "<li class='nav-link active'><a href='./register.php'>Sign up</a></li>";
    } else {
        echo "<li class='nav-link'><a href='./register.php'>Sign up</a></li>";
    }
?>
</ul>
