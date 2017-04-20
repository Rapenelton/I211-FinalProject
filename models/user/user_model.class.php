<?php

/*
 * Author: Aaron White, Ryan Penelton, Adam Grounds, Raleigh Stelle V
 * Date: April 10, 2017
 * File: user_model.class.php
 * Description: the user model
 * 
 */

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
        if (!$query)
            return false;

        //if the query succeeded, but no user was found.
        if ($query->num_rows == 0)
            return 0;

        //handle the result
        //create an array to store all returned albums
        $users = array();

        //loop through all rows in the returned users
        while ($obj = $query->fetch_object()) {
            $user = new User(stripslashes($obj->client_id), stripslashes($obj->last_name), stripslashes($obj->first_name), stripslashes($obj->birth_date), stripslashes($obj->email), stripslashes($obj->SSN), stripslashes($obj->role));
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

        if ($query && $query->num_rows > 0) {
            $obj = $query->fetch_object();

            //create an user object
            $user = new User(stripslashes($obj->client_id), stripslashes($obj->last_name), stripslashes($obj->first_name), stripslashes($obj->birth_date), stripslashes($obj->email), stripslashes($obj->SSN), stripslashes($obj->role));
            //set the id for the user
            $user->setClient_id($obj->client_id);

            return $user;
        }

        return false;
    }

    //search the database for users that match words in titles. Return an array of users if succeed; false otherwise.
    public function search_user($terms) {
        $terms = explode(" ", $terms); //explode multiple terms into an array
        //select statement for AND serach
        $sql = "SELECT * FROM " . $this->tblUsers .
                " WHERE " . $this->tblUsers . ".client_id AND (1";

        foreach ($terms as $term) {
            $sql .= " AND first_name LIKE '%" . $term . "%'";
        }

        $sql .= ")";

        //execute the query
        $query = $this->dbConnection->query($sql);

        // the search failed, return false. 
        if (!$query)
            return false;

        //search succeeded, but no user was found.
        if ($query->num_rows == 0)
            return 0;

        //search succeeded, and found at least 1 user found.
        //create an array to store all the returned users
        $users = array();

        //loop through all rows in the returned users
        while ($obj = $query->fetch_object()) {
            $user = new User(stripslashes($obj->client_id), stripslashes($obj->last_name), stripslashes($obj->first_name), stripslashes($obj->birth_date), stripslashes($obj->email), stripslashes($obj->SSN), stripslashes($obj->role));
            //set the id for the user
            $user->setClient_id($obj->client_id);

            //add the user into the array
            $users[] = $user;
        }
        return $users;
    }

    public function add_user() {

        if (!filter_has_var(INPUT_POST, 'firstName') ||
                !filter_has_var(INPUT_POST, 'lastName') ||
                !filter_has_var(INPUT_POST, 'DOB') ||
                !filter_has_var(INPUT_POST, 'SSN') ||
                !filter_has_var(INPUT_POST, 'email')) {

            echo "No post data found!";

            return false;
        }

        //retrieve data for the new account; data are sanitized and escaped for security.

        $first_name = $this->dbConnection->real_escape_string(trim(filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING)));
        $last_name = $this->dbConnection->real_escape_string(trim(filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING)));
        $birth_date = $this->dbConnection->real_escape_string(filter_input(INPUT_POST, 'DOB', FILTER_DEFAULT));
        $SSN = $this->dbConnection->real_escape_string(filter_input(INPUT_POST, 'SSN', FILTER_SANITIZE_STRING));
        $email = $this->dbConnection->real_escape_string(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

        
          echo "<br>firstName: " . $first_name;
          echo "<br>lastName: " . $last_name;
          echo "<br>DOB: " . $birth_date;
          echo "<br>SSN: " . $SSN;
          echo "<br>Email: " . $email;
         

        // assuming '2' is considered a normal 'user' account.
        $role = 2;

        //query string for update   
        $sql = "INSERT INTO $this->tblUsers (last_name, first_name, birth_date, email, SSN, role) VALUES ('$last_name', '$first_name', $birth_date, '$email', $SSN, $role)";
        // users table parameters: client_id, last_name, first_name, birth_date, email, SSN, role

        $query = $this->dbConnection->query($sql);

        if (!$query) {
            echo "Could not update USERS table!";
            echo "<br>SQL: " . $sql;
        }
    }

}

// end class
