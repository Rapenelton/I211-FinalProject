<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of date_missing_exception: Tells user that data is missing
 * April 18, 2017
 * data_missing_exception.class.php
 *
 * @author Ryan Penelton
 */
class DataMissingException extends Exception {
    
    public function getDetails() {
        return "Fatal Error:<br> Data is missing.";
    }
}
    
