<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of account_add
 *
 * @author Adam
 */
class UserAdd extends UserIndexView {

    //put your code here

    public function display() {
        parent::displayHeader("Registration Successful");
        ?>


        <h2>Thank you for registering with us!</h2>

        <br>
        <a href="<?= BASE_URL ?>/index">Back to Home</a>



        <?php
        parent::displayFooter();
    }

//end display
}

// end class
