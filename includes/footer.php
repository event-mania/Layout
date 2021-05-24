<?php

    $pagelink = $_SERVER['PHP_SELF'];
    $tmp = explode("/",$pagelink);
    $currentPage = end($tmp);
?>


<footer class="footer">
    <div class="left-footer">
        <h2 class="title"><a href="./index.php">Event Mania</a></h2>
        <p class="text">
                Our aim is to connect students and make them aware about the college events orgranized in Ahmedabad area.
            </p>
            <p class="text">We provide a safe and secure platform for Students and Organizers to register themselves for a specific event.</p>
        <div class="social-container">
            <ul class="sociallist">
                <li class="social"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li class="social"><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li class="social"><a href="#"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="implinks">
        <ul class="footerlinks">
            <li class="links"><i class="fas fa-home"></i> <a href="./index.php">Home</a></li>
            <li class="links"><i class="fas fa-info-circle"></i> <a href="./aboutus.html">About</a></li>
            <li class="links"><i class="fas fa-shield-alt"></i> <a href="./PrivacyPolicy.html">Privacy Policy</a></li>
        </ul>
    </div>
    <div class="implinks">
        <ul class="footerlinks">
            
            <?php 
                if($currentPage == "index.php" || $currentPage == "aboutus.html" || $currentPage == "contactus.php") {
                    echo "<li class='links'><i class='fas fa-sign-in-alt'></i> <a href='./login.php'>Login</a></li>";
                    echo "<li class='links'><i class='fas fa-user-plus'></i> <a href='./register.php'>Sign Up</a></li>";
                
                }

                if($currentPage == "login.php") {
                    echo "<li class='links'><i class='fas fa-user-plus'></i> <a href='#'>Sign Up</a></li>";
                }

                if($currentPage == "register.php") {
                    echo "<li class='links'><i class='fas fa-sign-in-alt'></i> <a href='#'>Login</a></li>";
                }
            ?>

            <li class="links"><i class="fas fa-address-card"></i> <a href="./contactus.php">Contact Us</a></li>
            <li class="links"><i class="fas fa-file-contract"></i> <a href="./Terms&Conditions.php">Terms & Conditions</a></li>
        </ul>
    </div>
</footer>