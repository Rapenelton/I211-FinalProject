<?php

session_start();

/*
 * Author: Aaron White, Ryan Penelton, Adam Grounds, Raleigh Stelle V
 * Date: April 10, 2017
 * File: user_model.class.php
 * Description: the user model
 * 
 */

require_once 'application/utilities.class.php';

class UserModel {

//private data members
    private $db;
    private $dbConnection;
    static private $_instance = NULL;
    private $tblUsers;
    private $tblAccounts;

//To use singleton pattern, this constructor is made private. To get an instance of the class, the getUserModel method must be called.
    private function __construct() {
        $this->db = Database::getDatabase();
        $this->dbConnection = $this->db->getConnection();
        $this->tblUsers = $this->db->getUsersTable();
        $this->tblAccounts = $this->db->getAccountsTable();

//Escapes special characters in a string for use in an SQL statement. This stops SQL inject in POST vars. 
        foreach ($_POST as $key => $value) {
            $_POST[$key] = $this->dbConnection->real_escape_string($value);
        }

//Escapes special characters in a string for use in an SQL statement. This stops SQL Injection in GET vars 
        foreach ($_GET as $key => $value) {
            $_GET[$key] = $this->dbConnection->real_escape_string($value);
        }
    }

//static method to ensure there is just one UserModel instance
    public static function getUserModel() {
        if (self::$_instance == NULL) {
            self::$_instance = new UserModel();
        }
        return self::$_instance;
    }

    /*
     * the list_user method retrieves all users from the database and
     * returns an array of User objects if successful or false if failed.
     */

    public function list_user() {
        /* construct the sql SELECT statement in this format
         * SELECT ...
         * FROM ...
         * WHERE ...
         */

        $sql = "SELECT * FROM " . $this->tblUsers;

        //execute the query
        $query = $this->dbConnection->query($sql);

        // if the query failed, return false. 
        try {
            if (!$query) {
                throw new DatabaseException();
            }
        } catch (DatabaseExceptionException $e) {
            $message = $e->getDetails();
            $error = new UserError();
            $error->display($message);
        }

        //if the query succeeded, but no user was found.
        if ($query->num_rows == 0)
            return 0;

        //create an array to store all returned users
        $users = array();

        //loop through all rows in the returned users
        while ($obj = $query->fetch_object()) {
            $user = new User(stripslashes($obj->client_id), stripslashes($obj->last_name), stripslashes($obj->first_name), stripslashes($obj->birth_date), stripslashes($obj->email), stripslashes($obj->SSN), stripslashes($obj->role), stripslashes($obj->username), stripslashes($obj->password));

            //set the id for the user
            $user->setClient_id($obj->client_id);

            //add the user into the array
            $users[] = $user;
        }
        return $users;
    }

    /*
     * the viewUser method retrieves the details of the user specified by its id
     * and returns an user object. Return false if failed.
     */

    public function view_user($id) {

        //the select ssql statement
        $sql = "SELECT * FROM " . $this->tblUsers .
                " WHERE " . $this->tblUsers . ".id='$id'";

        //execute the query
        $query = $this->dbConnection->query($sql);

        try {
            if (!$query) {
                throw new DatabaseException();
            }
        } catch (DatabaseExceptionException $e) {
            $message = $e->getMessage();
            $error = new UserError();
            $error->display($message);
        }

        if ($query && $query->num_rows > 0) {
            $obj = $query->fetch_object();

            //create an user object
            $user = new User(stripslashes($obj->client_id), stripslashes($obj->last_name), stripslashes($obj->first_name), stripslashes($obj->birth_date), stripslashes($obj->email), stripslashes($obj->SSN), stripslashes($obj->role), stripslashes($obj->username), stripslashes($obj->password));

            //set the id for the user
            $user->setClient_id($obj->client_id);

            return $user;
        }

        return false;
    }

    //search the database for users that match words in titles. Return an array of users if succeed; false otherwise.
    public function search_user($terms) {
        if ($terms == NULL) {
            $sql = "SELECT * FROM " . $this->tblUsers;
        } else {
            $terms = explode(" ", $terms); //explode multiple terms into an array
            //select statement for AND serach
            $sql = "SELECT * FROM " . $this->tblUsers .
                    " WHERE " . $this->tblUsers . ".client_id AND (1";

            foreach ($terms as $term) {
                $sql .= " AND first_name  LIKE '%" . $term . "%'";
                $sql .= " OR last_name  LIKE '%" . $term . "%'";
                $sql .= " OR email LIKE '%" . $term . "%'";
                $sql .= " OR SSN LIKE '%" . $term . "%'";
            }

            $sql .= ")";
        }
        //execute the query
        $query = $this->dbConnection->query($sql);

        // the search failed, return false. 
        try {
            if (!$query) {
                throw new DatabaseException();
            }
        } catch (DatabaseExceptionException $e) {
            $message = $e->getDetails();
            $error = new UserError();
            $error->display($message);
        }
        //search succeeded, but no user was found.
        if ($query->num_rows == 0)
            return 0;

        //search succeeded, and found at least 1 user found.
        //create an array to store all the returned users
        $users = array();

        //loop through all rows in the returned users
        while ($obj = $query->fetch_object()) {
            $user = new User(stripslashes($obj->client_id), stripslashes($obj->last_name), stripslashes($obj->first_name), stripslashes($obj->birth_date), stripslashes($obj->email), stripslashes($obj->SSN), stripslashes($obj->role), stripslashes($obj->username), stripslashes($obj->password));
            //set the id for the user
            $user->setClient_id($obj->client_id);

            //add the user into the array
            $users[] = $user;
        }
        return $users;
    }

    public function add_user() {

        try {
            if (!filter_has_var(INPUT_POST, 'firstName') ||
                    !filter_has_var(INPUT_POST, 'lastName') ||
                    !filter_has_var(INPUT_POST, 'DOB') ||
                    !filter_has_var(INPUT_POST, 'SSN') ||
                    !filter_has_var(INPUT_POST, 'email') ||
                    !filter_has_var(INPUT_POST, 'username') ||
                    !filter_has_var(INPUT_POST, 'password')) {

                throw new DataMissingException();
            }
        } catch (DataMissingException $e) {
            $message = $e->getDetails();
            $error = new UserError();
            $error->display($message);
        }

        //retrieve data for the new account; data are sanitized and escaped for security.
        $first_name = $this->dbConnection->real_escape_string(trim(filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING)));
        $last_name = $this->dbConnection->real_escape_string(trim(filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING)));
        $birth_date = $this->dbConnection->real_escape_string(filter_input(INPUT_POST, 'DOB', FILTER_DEFAULT));
        $SSN = $this->dbConnection->real_escape_string(filter_input(INPUT_POST, 'SSN', FILTER_SANITIZE_STRING));
        $email = $this->dbConnection->real_escape_string(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
        $username = $this->dbConnection->real_escape_string(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING));
        $password = $this->dbConnection->real_escape_string(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING));


        //This is a try throw catch block that handles all possible exceptions
        try {
            if ($last_name == "" || $first_name == "" || $birth_date == "" || $email == "") {
                throw new DataMissingException();
            }
            if (!Utilities::validatedate($birth_date)) {
                throw new DateException();
            }
            if (!Utilities::checkemail($email)) {
                throw new EmailException();
            }
            if (!Utilities::validatessn($SSN)) {
                throw new SsnException();
            }
        } catch (DataMissingException $e) {
            $message = $e->getDetails();
            $error = new UserError();
            $error->display($message);
        } catch (DateException $e) {
            $message = $e->getDetails();
            $error = new UserError();
            $error->display($message);
        } catch (EmailException $e) {
            $message = $e->getDetails();
            $error = new UserError();
            $error->display($message);
        } catch (SsnException $e) {
            $message = $e->getDetails();
            $error = new UserError();
            $error->display($message);
        } catch (Exception $e) {
            $message = $e->getMessage();
            $error = new UserError();
            $error->display($message);
        }


        // select all usernames from database
        $sql = "SELECT username FROM $this->tblUsers";

        try {

            // execute query
            $query = $query = $this->dbConnection->query($sql);

            if (!$query) {
                throw new DatabaseException();
            }
        } catch (DatabaseException $e) {
            $message = $e->getDetails();
            $error = new UserError();
            $error->display($message);
        }

        // create array to hold results
        $usernameArray = array();

        //get all usernames from the database and store them in usernameArray variable
        while ($obj = $query->fetch_object()) {
            $usernamesInDatabase = stripslashes($obj->username);
            $usernameArray[] = $usernamesInDatabase;
        }

        // if username already exists in the database, tell the user
        if (in_array($username, $usernameArray)) {
            $message = "This username has already been taken!";
            $error = new UserError();
            $error->display($message);
            exit();
        }



        // assuming '2' is considered a normal 'user' account.
        $role = 2;

        //query string for update   
        $sql = "INSERT INTO $this->tblUsers (last_name, first_name, birth_date, email, SSN, role, username, password) VALUES ('$last_name', '$first_name', '$birth_date', '$email', $SSN, $role, '$username', '$password')";
        // users table parameters: client_id, last_name, first_name, birth_date, email, SSN, role, username, password

        $query = $this->dbConnection->query($sql);

        try {
            if (!$query) {
                throw new DatabaseException();
            }
        } catch (DatabaseException $e) {
            $message = $e->getDetails();
            $error = new UserError();
            $error->display($message);
        }
    }

    public function login() {

        //make sure post data exists first
        try {
            if (!filter_has_var(INPUT_POST, 'username') ||
                    !filter_has_var(INPUT_POST, 'password')) {
                throw new DataMissingException();
            }
        } catch (DataMissingException $e) {
            $message = $e->getDetails();
            $error = new UserError();
            $error->display($message);
            exit();
        }

        //get user info from the form
        $username = $this->dbConnection->real_escape_string(trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING)));
        $password = $this->dbConnection->real_escape_string(trim(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)));

        try {

            //select all 'usernames' that currently exist in the database
            $sql = "SELECT username FROM $this->tblUsers";

            //execute the query
            $query = $this->dbConnection->query($sql);

            if (!$query) {
                throw new DatabaseException();
            }
        } catch (DatabaseException $e) {
            $error = new UserError();
            $message = $e->getDetails();
            $error->display($message);
            exit();
        }
        //create array to hold all of the usernames from the above query
        $usernameArray = array();

        //get all usernames from the database and store them in usernameArray variable
        while ($obj = $query->fetch_object()) {
            $usernamesInDatabase = stripslashes($obj->username);
            $usernameArray[] = $usernamesInDatabase;
        }

        //check to see if username from the form exists in the database
        if (in_array($username, $usernameArray)) {

            //get the password for the account
            $sql = "SELECT password FROM $this->tblUsers WHERE username = '$username'";

            try {

                //execute the query
                $query = $this->dbConnection->query($sql);

                if (!$query) {
                    throw new DatabaseException();
                }
            } catch (DatabaseException $e) {
                $message = $e->getDetails();
                $error = new UserError();
                $error->display($message);
                exit();
            }
            //will hold the password found in the database
            $databasePasswords = array();

            //get the password for the selected username
            while ($obj = $query->fetch_object()) {
                $databasePassword = stripslashes($obj->password);
                $databasePasswords[] = $databasePassword;
            }

            // get user role, admin? normal user?
            $role = array();

            // sql statement to find the user role
            $sql = "SELECT role FROM $this->tblUsers WHERE username = '$username' AND password = '$password'";

            try {

                //execute the query
                $query = $this->dbConnection->query($sql);

                if (!$query) {
                    throw new DatabaseException();
                }
            } catch (DatabaseException $e) {
                $message = $e->getDetails();
                $error = new UserError();
                $error->display($message);
                exit();
            }

            if ($query->num_rows == 0) {
                $message = "Incorrect password for this user.";
                $error = new UserError();
                $error->display($message);
                exit();
            }

            while ($obj = $query->fetch_object()) {
                $role = stripslashes($obj->role);
            }

            if ($role == 1) {
                $role = "admin";
            } else {
                $role = "normal";
            }

            //get the users id number
            $sql = "SELECT client_id FROM $this->tblUsers WHERE username = '$username'";

            try {

                //execute the query
                $query = $this->dbConnection->query($sql);


                if (!$query) {
                    throw new DatabaseException();
                }
            } catch (DatabaseException $e) {
                $message = $e->getMessage();
                $error = new UserError();
                $error->display($message);
            }

            $client_id = array();

            while ($obj = $query->fetch_object()) {
                $client_id = stripslashes($obj->client_id);
            }

            //both the form username and password exist in the database
            if (in_array($password, $databasePasswords)) {

                $_SESSION['username'] = $username;
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['role'] = $role;
                $_SESSION['clientId'] = (int) $client_id;
                return true;
            }
        }
        //username from the form is not in the database
        else {
            return false;
        }
    }

//end login
}

// end class
