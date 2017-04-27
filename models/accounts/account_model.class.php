<?php

/*
 * Author: Aaron White, Ryan Penelton, Adam Grounds, Raleigh Stelle V
 * Date: April 10, 2017
 * File: account_model.class.php
 * Description: the account model
 * 
 */

session_start();

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
        } catch (DatabaseException $e) {
            $message = $e->getDetails();
            $error = new AccountError();
            $error->display($message);
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

    public function view_account() {
        /* construct the sql SELECT statement in this format
         * SELECT ...
         * FROM ...
         * WHERE ...
         */
        $client_id = $_SESSION['clientId'];
        $sql = "SELECT * FROM " . $this->tblAccounts . " WHERE client_id ='$client_id'";

        //execute the query
        $query = $this->dbConnection->query($sql);

        // if the query failed, return false. 
        try {
            if (!$query) {
                throw new DatabaseException();
            }
        } catch (DatabaseException $e) {
            $message = $e->getDetails();
            $error = new AccountError();
            $error->display($message);
        }

        //if the query succeeded, but no account was found.
        if ($query->num_rows == 0) {
            $message = "You don't have any registered Accounts!";
            $error = new AccountError();
            $error->display($message);
            exit();
        }
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
        } catch (DatabaseException $e) {
            $message = $e->getDetails();
            $error = new AccountError();
            $error->display($message);
            exit();
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
            if (!filter_has_var(INPUT_POST, 'account_type')) {

                throw new DataMissingException();
            }
        } catch (DataMissingException $e) {
            $message = $e->getDetails();
            $error = new AccountError();
            $error->display($message);
            exit();
        }

        // does this user already have both a savings AND a checkings account?
        $client_id = $_SESSION['clientId'];

        //create sql statement to see how many accounts are already opened up.
        $sql = "SELECT account_type FROM $this->tblAccounts WHERE client_id = '$client_id'";

        //retrieve data for the new account; data are sanitized and escaped for security.
        $account_type = $this->dbConnection->real_escape_string(trim(filter_input(INPUT_POST, 'account_type', FILTER_SANITIZE_STRING)));

        try {
            //execute query
            $query = $this->dbConnection->query($sql);

            if (!$query) {
                throw new DatabaseException();
            }
        } catch (DatabaseException $e) {
            $message = $e->getDetails();
            $error = new AccountError();
            $error->display($message);
        }

        $accountTypesArray = array();

        while ($obj = $query->fetch_object()) {
            $databaseAccountTypes = stripslashes($obj->account_type);
            $accountTypesArray[] = $databaseAccountTypes;
        }

        // if a user has a checkings account
        if (in_array("checkings", $accountTypesArray)) {

            if ($account_type == "checkings") {
                $message = "You already have a Checkings account!";
                $error = new AccountError();
                $error->display($message);
                exit();
            }

        }

        while (TRUE) {

            // generate a random account number; account numbers are 9 digits in length
            $account_number = rand(000000000, 999999999);

            // see if this account number already exists in the database
            $sql = "SELECT account_number FROM $this->tblAccounts WHERE account_number = '$account_number'";

            try {

                //execute the query
                $query = $this->dbConnection->query($sql);
            } catch (DatabaseException $e) {
                $message = $e->getDetails();
                $error = new AccountError();
                $error->display($message);
                exit();
            }

            $accountNumbersArray = array();

            while ($obj = $query->fetch_object()) {
                $databaseAccountNumbers = stripslashes($obj->account_number);
                $accountNumbersArray[] = $databaseAccountNumbers;
            }

            // if the account number already exists in the database
            if (in_array($account_number, $accountNumbersArray)) {
                // generate a new account number and try it all again
                continue;
            } else {
                // move on with the code
                break;
            }
        }// end while
        // default values for stuff
        $balance = 0;
        $routing_number = 0;

        $client_id = $_SESSION['clientId'];

        //query string for update   
        $sql = "INSERT INTO $this->tblAccounts (client_id, account_number, balance, routing_number, account_type) VALUES ($client_id, $account_number, $balance, $routing_number, '$account_type')";

        try {

            //execute the query
            $query = $this->dbConnection->query($sql);


            if (!$query) {
                throw new DatabaseException();
            }
        } catch (DatabaseException $e) {
            $message = $e->getDetails();
            $error = new AccountError();
            $error->display($message);
            exit();
        }
    }

//end addAccount
}

// end class
