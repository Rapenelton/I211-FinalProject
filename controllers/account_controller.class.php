<?php

/*
 * Author: Aaron White, Ryan Penelton, Adam Grounds, Raleigh Stelle V
 * Date: April 10, 2017
 * File: account_controller.class.php
 * Description: the account controller
 *
 */

class AccountController {

    //creates account model variable
    private $account_model;

    //default constructor
    public function __construct() {
        //create an instance of the AccountModel class
        $this->account_model = AccountModel::getAccountModel();
    }

    //index action that displays all accounts
    public function index() {
        //retrieve all accounts and store them in an array
        $accounts = $this->account_model->list_account();

        if (!$accounts) {
            //display an error
            $message = "There was a problem displaying accounts.";
            $this->error($message);
            return;
        }

        // display all accounts
        $view = new AccountIndex();
        $view->display($accounts);
    }

    //show details of an account
    public function detail() {
        //retrieve the specific account
        $account = $this->account_model->view_account($_SESSION['clientId']);

        if (!$account) {
            //display an error
            $message = "There was a problem displaying the the account.";
            $this->error($message);
            return;
        }

        //display account details
        $view = new AccountDetail();
        $view->display($account);
    }

    //search accounts
    public function search() {
        //retrieve query terms from search form
        $query_terms = trim($_GET['query-terms']);

        //if search term is empty, list all accounts
        /* if ($query_terms == "") {
          $this->index();
          }
         */
        //search the database for matching accounts
        $accounts = $this->account_model->search_account($query_terms);

        if ($accounts === false) {
            //handle error
            $message = "Something went wrong.";
            $this->error($message);
            return;
        }
        //display matched accounts
        $search = new AccountSearch();
        $search->display($query_terms, $accounts);
    }

    //autosuggestion
    public function suggest($terms) {
        //retrieve query terms
        $query_terms = urldecode(trim($terms));
        $accounts = $this->account_model->search_account($query_terms);

        //retrieve all account titles and store them in an array
        $titles = array();
        if ($accounts) {
            foreach ($accounts as $account) {
                $titles[] = $account->getAccount_number();
            }
        }

        echo json_encode($titles);
    }

    //handle an error
    public function error($message) {
        //create an object of the Error class
        $error = new AccountError();

        //display the error page
        $error->display($message);
    }

    //handle calling inaccessible methods
    public function __call($name, $arguments) {
        //$message = "Route does not exist.";
        // Note: value of $name is case sensitive.
        $message = "Calling method '$name' caused errors. Route does not exist.";

        $this->error($message);
        return;
    }

    public function login() {
        $login = new AccountLogin();
        $login->display();
    }
    
    public function register()  {
        $register = new AccountRegister();
        $register->display();
    }
    
    public function addAccount()    {
        
        $this->account_model->add_account();
        
        $registered = new AccountRegistered();
        $registered->display();
    }
}
