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

            First Name: <input type="text" name="firstName"><br>
            Last Name: <input type="text" name="lastName"><br>
            Birth date: <input type="date" name="DOB"><br>
            Email: <input type="email" name="email"><br>
            SSN: <input type="number" name="SSN"><br>

            <br>
            <button type="submit" >Register</button>
        </form>
        
        <br><br><br><br><br><br><br><br><br><br><br><br>
        <a href="index/">Show All Users</a>
        <a href="../index/">Home</a>

        <?php
             
        
    }//end display

}//end class
