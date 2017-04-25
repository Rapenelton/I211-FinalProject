<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ssn_excepetion
 *
 * @author ryanpene
 */
class SsnException extends Exception {

    public function getDetails() {
        echo "Fatal Error:<br> Your Social Security Number is not the correct length. Please try again";
    }
    }
