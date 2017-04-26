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
class UserRegister extends UserIndexView {

    //put your code here

    public function display() {
        parent::displayHeader("Register a new User");
        ?>

        <!--display a form where a user can register-->
        <form id="register" method="post" action="addUser">

            <h3>Fill this out to register a User</h3>

            First Name: <input type="text" name="firstName" required><br>
            Last Name: <input type="text" name="lastName" required><br>
            Birth date: <input type="date" name="DOB" required><br>
            Email: <input type="email" name="email" required><br>
            SSN: <input type="number" name="SSN" required><br>
            Username: <input type="text" name="username" required><br>
            Password: <input type="text" name="password" required><br>

            <br>
            <button type="submit" >Register</button>
        </form>

        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <a href="../index/">Home</a>

        <?php
        parent::displayFooter();
    }

//end display
}

//end class
