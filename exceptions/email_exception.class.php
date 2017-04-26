<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of email_exception: handles email format exceptions
 * April 18, 2017
 * email_exception.class.php
 *
 * @author Ryan Penelton
 */
class EmailException extends Exception {
    
    public function getDetails() {
        return "Fatal Error:<br> A valid email address appears in the format of 'username@domain.domain'.";
    }
    
}
