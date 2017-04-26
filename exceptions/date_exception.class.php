<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of date_exception: handles date exceptions
 * April 18, 2017
 * date_exception.class.php
 *
 * @author Ryan Penelton
 */
class DateException extends Exception {
    
    public function getDetails() {
        return "Fatal Error:<br> A valid date must be entered in 'mm/dd/yyyy' or 'mm-dd-yyyy' format.";
    }
}
