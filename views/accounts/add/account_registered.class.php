<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountRegistered: This class/function is displayed when the
 *                                   user successfully creates an account
 *
 * @author Adam Grounds
 * @date   4/26/2017
 */
class AccountRegistered extends AccountIndexView {

    //put your code here

    public function display() {
        parent::displayHeader("Account Registration Successful");
        ?>


        <h2>Thank you for registering an Account with us!</h2>

        <br>
        <a href="<?= BASE_URL ?>/index">Back to Home</a>



        <?php
        parent::displayFooter();
    }//end display

}//end class
