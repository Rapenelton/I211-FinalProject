<?php

/*
 * Author: Aaron White, Ryan Penelton, Adam Grounds, Raleigh Stelle V
 * Date: April 10, 2017
 * File: user_controller.class.php
 * Description: the user controller
 *
 */

class UserController {

    //creates user model variable
    private $user_model;

    //default constructor
    public function __construct() {
        //create an instance of the UserModel class
        $this->user_model = UserModel::getUserModel();
    }

    //index action that displays all users
    public function index() {
        //retrieve all users and store them in an array
        $users = $this->user_model->list_user();

        if (!$users) {
            //display an error
            $message = "There was a problem displaying users.";
            $this->error($message);
            return;
        }

        // display all users
        $view = new UserIndex();
        $view->display($users);
    }

    //show details of an user
    public function detail($id) {
        //retrieve the specific user
        $user = $this->user_model->view_user($id);

        if (!$user) {
            //display an error
            $message = "There was a problem displaying the user id='" . $id . "'.";
            $this->error($message);
            return;
        }

        //display user details
        $view = new UserDetail();
        $view->display($user);
    }

    //search users
    public function search() {
        //retrieve query terms from search form
        $query_terms = trim($_GET['query-terms']);

        /*
          //if search term is empty, list all users
          if ($query_terms == "") {
          $this->index();
          }

         */
        //search the database for matching users
        $users = $this->user_model->search_user($query_terms);

        if ($users === false) {
            //handle error
            $message = "Something went wrong.";
            $this->error($message);
            return;
        }
        //display matched users
        $search = new UserSearch();
        $search->display($query_terms, $users);
    }

    //autosuggestion
    public function suggest($terms) {
        //retrieve query terms
        $query_terms = urldecode(trim($terms));
        $users = $this->user_model->search_user($query_terms);

        //retrieve all user titles and store them in an array
        $titles = array();
        if ($users) {
            foreach ($users as $user) {
                $titles[] = $user->getUser_number();
            }
        }

        echo json_encode($titles);
    }

    //handle an error
    public function error($message) {
        //create an object of the Error class
        $error = new UserError();

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

    // displays the user registration page
    public function register() {
        $register = new UserRegister();
        $register->display();
    }

    public function login() {

        $logIn = new UserLogin();
        $logIn->display();
    }

    public function checkLogin() {
        //true if successful login, false otherwise
        $loginStatus = $this->user_model->login();

        if ($loginStatus) {
            $success = new UserLoginSuccess();
            $success->display();
        } else {
            $error = new UserError();
            $message = "No such username exists in the database.";
            $error->display($message);
        }
    }

    public function addUser() {

        $this->user_model->add_user();
        $added = new UserAdd();
        $added->display();
    }

}
