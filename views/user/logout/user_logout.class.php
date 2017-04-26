<?php

/**
 * Description of UserLogout: This class/function is called when the user wants to logout
 *                            It destroys the user's session.
 *
 * @author Adam Grounds
 * @date   4/26/2017
 */
class UserLogout extends UserIndexView {
    //put your code here
    
   public function display()    {
       parent::displayHeader("Logged out.");
       session_destroy();
       ?>
       
        <h2>You have successfully logged out!</h2>

        <a href="<?= BASE_URL ?>/index">Back to Home</a>

       <?php
   }
    
}
