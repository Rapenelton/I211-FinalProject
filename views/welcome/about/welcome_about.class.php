<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of welcome_about
 *
 * @author Benton
 */

session_start();

class WelcomeAbout extends IndexView {
    //put your code here
    
    public function display()   {
        parent::displayHeader("Cash Money Bank");
        ?>
        
<html>
            <head>
                <title> <?php echo $page_title ?> </title>
                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
                <link type='text/css' rel='stylesheet' href='<?= BASE_URL ?>/www/css/style.css' />
                <script>
                    //create the JavaScript variable for the base url
                    var base_url = "<?= BASE_URL ?>";
                </script>
            </head>
            <body>
                <ul>
                    <div class="buttons">
                        <?php
                        // if the user is NOT logged in
                        if ($_SESSION['isLoggedIn'] == false) {
                            ?>
                            <li><a href="<?= BASE_URL ?>/user/register">Register</a></li>
                            <li><a href="<?= BASE_URL ?>/user/login">Login</a></li>
                            <li><a href ="<?= BASE_URL ?>/welcome/about">About Us</a></li>
                            
                            <?php
                        }

                        // if the user IS logged in and is NOT an admin
                        if ($_SESSION['isLoggedIn'] == true && $_SESSION['role'] == "normal") {
                            ?>
                            <li><a href="<?= BASE_URL ?>/account/register">Register an Account</a></li>
                            <li><a href="<?= BASE_URL ?>/account/detail/<?= $_SESSION['clientId'] ?>">View My Account</a></li>
                            <li><a href="<?= BASE_URL ?>/user/logout">Log out</a></li> 

                        <?php }
                        
                        if($_SESSION['isLoggedIn'] == true && $_SESSION['role'] == "admin") {
                            ?>
                            
                            <li><a href="<?= BASE_URL ?>/user/index">View All Users</a></li>
                            <li><a href="<?= BASE_URL ?>/account/index">View All Accounts</a></li>
                            <li><a href="<?= BASE_URL ?>/user/logout">Log out</a></li>
                            
                            <?php
                        }
                        ?>
                        
                    </div>

                </ul>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut tellus tellus, finibus nec porta ac, mattis ac lacus. Praesent accumsan odio felis, ut consectetur odio facilisis sit amet. Suspendisse semper urna a commodo aliquet. Duis ac tortor vitae erat interdum iaculis. Donec congue vitae nisl et efficitur. Integer id justo vitae enim ultricies fermentum. Sed non arcu fringilla, imperdiet risus ut, porttitor mauris. Vivamus at elit tincidunt, vulputate odio sed, vulputate augue.</p>
                <br>


            </body>

</html>
        <?php
        //display page footer
        parent::displayFooter();
    }

}
