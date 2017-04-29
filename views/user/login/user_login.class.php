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
class UserLogin extends UserIndexView {

    //put your code here

    public function display() {
        parent::displayHeader("Existing User");
        ?>

        <!--display a form where a user can register-->
        <form id="register" method="post" action="checkLogin">

            <h3>Login</h3>

            Username: <input type="text" name="username" ><br>
            Password: <input type="text" name="password" ><br>

            <br>
            <button type="submit" >Login</button>
        </form>
        
        <br><br><br><br><br><br><br><br><br>
        <a href="../index/">Home</a>

        <?php
        parent::displayFooter();
    }

//end display
}

//end class