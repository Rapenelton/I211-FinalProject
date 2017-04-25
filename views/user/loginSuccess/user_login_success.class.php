<?php


/**
 * Description of UserLoginSuccess: This page is displayed if the user is able to
 *                                  successfully log in.
 *
 * @author Adam Grounds
 * @date 4/25/2017
 */
class UserLoginSuccess extends UserIndexView {
    //put your code here
    
    public function display()   {
        parent::displayHeader("Success!");
    ?>    
        
    <h2>Successfully logged in!</h2>
    
    <p>Logged in with username <?php echo $_SESSION['username'] ?>.</p>
    
    <p><a href="../index/">Back to Home</a></p>
        
    <?php    
    }// end display
    
}
