<?php

session_start();



//if the script did not received post data, display an error message and then terminite the script immediately
if (!filter_has_var(INPUT_POST, 'firstName') ||
        !filter_has_var(INPUT_POST, 'lastName') ||
        !filter_has_var(INPUT_POST, 'DOB') ||
        !filer_has_var(INPUT_POST, 'email') ||
        !filter_has_var(INPUT_POST, 'SSN')) {

    return false;
}



//retrieve data for the new account; data are sanitized and escaped for security.
$first_name = $_SESSION['firstName'];
$last_name = $_SESSION['lastName'];
$birth_date = $_SESSION['DOB'];
$email = $_SESSION['email'];
$SSN = $_SESSION['SSN'];

// increment id number somehow
//$id = $this->db->insert_id;
$role = 2;

// default values for stuff
//$balance = 0;
//$account_number = 0; 
//$account_type = "Savings";
//query string for update
$sql = "INSERT INTO users VALUES ('$last_name', '$first_name', '$birth_date', '$email', $SSN, '$role')";


//execute the query
return $this->dbConnection->query($sql);

