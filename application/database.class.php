<?php

/*
 * Author: Aaron White, Ryan Penelton, Adam Grounds, Raleigh Stelle V
 * Date: April 10, 2017
 * File: database.class.php
 * Description: Description: the Database class sets the database details.
 * 
 */

class Database {

    //define database parameters
    private $param = array(
        'host' => 'localhost',
        'login' => 'root',
        'password' => '',
        'database' => 'bank',
        'tblUsers' => 'users',
        'tblAccounts' => 'accounts',
    );
    //define the database connection object
    private $objDBConnection = NULL;
    static private $_instance = NULL;

    //constructor
    private function __construct() {
         try {
        $this->objDBConnection = @new mysqli(
                        $this->param['host'],
                        $this->param['login'],
                        $this->param['password'],
                        $this->param['database'],
                        $this->param['port']
        );
            if (mysqli_connect_errno() != 0) {
                $errmsg = "Connecting database failed: " . mysqli_connect_error();
                throw new DatabaseException($errmsg);
            }
        } catch (DatabaseException $e) {
            $error = new Error();
            $error->display($e->getMessage());
            exit;
        }
    }

    //static method to ensure there is just one Database instance
    static public function getDatabase() {
        if (self::$_instance == NULL)
            self::$_instance = new Database();
        return self::$_instance;
    }

    //this function returns the database connection object
    public function getConnection() {
        return $this->objDBConnection;
    }

    //returns the name of the table that stores albums
    public function getAccountsTable() {
        return $this->param['tblAccounts'];
    }
    
    public function getUsersTable() {
        return $this->param['tblUsers'];
    }


}


