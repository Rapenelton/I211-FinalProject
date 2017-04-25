<?php

/*
 * Author: Aaron White, Ryan Penelton, Adam Grounds, Raleigh Stelle V
 * Date: April 10, 2017
 * File: account_model.class.php
 * Description: the account model
 * 
 */

class AccountModel {

//private data members
    private $db;
    private $dbConnection;
    static private $_instance = NULL;
    private $tblAccounts;
    private $tblUsers;

//To use singleton pattern, this constructor is made private. To get an instance of the class, the getAccountModel method must be called.
    private function __construct() {
        $this->db = Database::getDatabase();
        $this->dbConnection = $this->db->getConnection();
        $this->tblAccounts = $this->db->getAccountsTable();
        $this->tblUsers = $this->db->getUsersTable();

//Escapes special characters in a string for use in an SQL statement. This stops SQL inject in POST vars. 
        foreach ($_POST as $key => $value) {
            $_POST[$key] = $this->dbConnection->real_escape_string($value);
        }

//Escapes special characters in a string for use in an SQL statement. This stops SQL Injection in GET vars 
        foreach ($_GET as $key => $value) {
            $_GET[$key] = $this->dbConnection->real_escape_string($value);
        }
    }

//static method to ensure there is just one AccountModel instance
    public static function getAccountModel() {
        if (self::$_instance == NULL) {
            self::$_instance = new AccountModel();
        }
        return self::$_instance;
    }

    /*
     * the list_account method retrieves all accounts from the database and
     * returns an array of Account objects if successful or false if failed.
     */

    public function list_account() {
        /* construct the sql SELECT statement in this format
         * SELECT ...
         * FROM ...
         * WHERE ...
         */

        $sql = "SELECT * FROM " . $this->tblAccounts;

//execute the query
        $query = $this->dbConnection->query($sql);

// if the query failed, return false. 
        try {
            if (!$query) {
                throw new DatabaseException();
            }
        } catch (DatabaseExceptionException $e) {
            $message = $e->getDetails();
            echo $message;
        }
//if the query succeeded, but no account was found.
        if ($query->num_rows == 0)
            return 0;

//handle the result
//create an array to store all returned albums
        $accounts = array();

//loop through all rows in the returned accounts
        while ($obj = $query->fetch_object()) {
            $account = new Account(stripslashes($obj->id), stripslashes($obj->client_id), stripslashes($obj->account_number), stripslashes($obj->balance), stripslashes($obj->routing_number), stripslashes($obj->account_type));
//set the id for the account
            $account->setID($obj->id);

//add the account into the array
            $accounts[] = $account;
        }
        return $accounts;
    }

    /*
     * the viewAccount method retrieves the details of the account specified by its id
     * and returns an account object. Return false if failed.
     */

    public function view_account($id) {
//the select ssql statement
        $sql = "SELECT * FROM " . $this->tblAccounts .
                " WHERE " . $this->tblAccounts . ".id='$id'";
//execute the query
        $query = $this->dbConnection->query($sql);


        try {
            if (!$query) {
                throw new DatabaseException();
            }
        } catch (DatabaseExceptionException $e) {
            $message = $e->getDetails();
            echo $message;
        }

        if ($query && $query->num_rows > 0) {
            $obj = $query->fetch_object();

//create an account object
            $account = new Account(stripslashes($obj->id), stripslashes($obj->client_id), stripslashes($obj->account_number), stripslashes($obj->balance), stripslashes($obj->routing_number), stripslashes($obj->account_type));
//set the id for the account
            $account->setId($obj->id);

            return $account;
        }

        return false;
    }

//search the database for accounts that match words in titles. Return an array of accounts if succeed; false otherwise.
    public function search_account($terms) {
        if ($terms == NULL) {
            $sql = "SELECT * FROM " . $this->tblAccounts;
        } else {
            $terms = explode(" ", $terms); //explode multiple terms into an array
//select statement for AND serach
            $sql = "SELECT * FROM " . $this->tblAccounts .
                    " WHERE " . $this->tblAccounts . ".id AND (1";
            foreach ($terms as $term) {
                $sql .= " AND account_number LIKE '%" . $term . "%'";
                $sql .= " OR client_id LIKE '%" . $term . "%'";
                $sql .= " OR balance LIKE '%" . $term . "%'";
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
            echo $message;
        }
//search succeeded, but no account was found.
        if ($query->num_rows == 0)
            return 0;

//search succeeded, and found at least 1 account found.
//create an array to store all the returned accounts
        $accounts = array();

//loop through all rows in the returned accounts
        while ($obj = $query->fetch_object()) {
            $account = new Account(stripslashes($obj->id), stripslashes($obj->client_id), stripslashes($obj->account_number), stripslashes($obj->balance), stripslashes($obj->routing_number), stripslashes($obj->account_type));
//set the id for the account
            $account->setId($obj->id);

//add the account into the array
            $accounts[] = $account;
        }
        return $accounts;
    }

    public function add_account() {

//if the script did not received post data, display an error message and then terminite the script immediately

        try {
            if (!filter_has_var(INPUT_POST, 'account_type') ||
                    !filter_has_var(INPUT_POST, 'balance')) {
                
                throw new DataMissingException();
            }
        } catch (DataMissingException $e) {
            $message = $e->getDetails();
            echo $message;
        }
//retrieve data for the new account; data are sanitized and escaped for security.

        /* $first_name = $this->dbConnection->real_escape_string(trim(filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING)));
          $last_name = $this->dbConnection->real_escape_string(trim(filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING)));
          $birth_date = $this->dbConnection->real_escape_string(filter_input(INPUT_POST, 'DOB', FILTER_DEFAULT));
          $SSN = $this->dbConnection->real_escape_string(filter_input(INPUT_POST, 'SSN', FILTER_SANITIZE_STRING));
          $email = $this->dbConnection->real_escape_string(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL)); */

// increment id number somehow
        $id = 1;

// increment client id
        $client_id = 1;

// increment account number
        $account_number = rand(1000, 9000);

        $account_type = $this->dbConnection->real_escape_string(trim(filter_input(INPUT_POST, 'account_type', FILTER_SANITIZE_STRING)));


// default values for stuff
        $balance = 0;

// value of 1 for normal user?
        if ($account_type == 1) {
            $account_type = "Checkings";
        } else if ($account_type == 2) {
            $account_type = "Savings";
        }

// increment routing number unless we need to just generate a random number for it and then
// check the database to see if that number already exists or not.
        if ($account_type == "Checkings") {
            $routing_number = 000000;
        } else if ($account_type == "Savings") {
            $routing_number = 111111;
        }

//query string for update   
        $sql = "INSERT INTO $this->tblAccounts (account_number, balance, routing_number, account_type) VALUES ($account_number, $balance, $routing_number, $account_type)";

//id, client_id, account_number, balance, routing_number, account_type
//"INSERT INTO books (id, title, isbn, author, publish_date, publisher, price, category_id, image, description) VALUES ($id, '$title', $isbn, '$author', '$publish_date', '$publisher', $price, $category, '$image', '$description')";
//execute the query
//$query = $this->dbConnection->query($sql);
        $query = $this->dbConnection->query($sql);

        try {
            if (!$query) {
                throw new DatabaseException();
            }
        } catch (DatabaseExceptionException $e) {
            $message = $e->getDetails();
            echo $message;
            echo "SQL: " . $sql;
        }

//account_model->dbConnection->query($sql);
    }

//end addAccount
}

// end class
