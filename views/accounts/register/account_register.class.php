<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of account_register: This will be the view page for a user to create
 *                                  a new account and have it be inserted into the 
 *                                  database.
 *
 * @author Adam
 */
class AccountRegister extends AccountIndexView {

    //put your code here

    public function display() {
        parent::displayHeader("Register a new Account");
        ?>

        <!--display a form where a user can register-->
        <form id="register" method="post" action="addAccount">

            <h3>Fill this out to register an Account</h3>

            Checkings Account <input type="radio" name="account_type" value="checkings" required checked> &nbsp; &nbsp;
            Savings Account <input type="radio" name="account_type" value="savings" required>

            <br><br><br>
            <button type="submit">Register</button>
        </form>

        <br><br><br><br><br><br><br><br>
        <a href="../index/">Home</a>

        <?php
        parent::displayFooter();
    }

//end display
}

//end class
