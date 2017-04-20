<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountLogin: This page will display a form allowing an existing
 *                              user to login to their account.
 *
 * @author Adam
 */
class AccountLogin extends AccountIndexView {

    //put your code here

    public function display() {
        parent::displayHeader("Existing User");
        ?>

        <!--display a form where a user can register-->
        <form id="register" method="post" action="">

            <h3>Login</h3>

            First Name: <input type="text" name="firstName"><br>
            Last Name: <input type="text" name="LastName"><br>
            Email: <input type="email" name="email"><br>

            <br>
            <button type="submit" >Login</button>
        </form>
        
        <br><br><br><br><br><br><br><br><br>
        <a href="index/">Show All Accounts</a>
        <br><br>
        <a href="../index/">Home</a>

        <?php
    }

//end display
}

//end class